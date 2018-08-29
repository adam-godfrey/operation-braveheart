<?php

class Topic_Model extends Model {

	private $getcount = NULL;
	private $total_pages = NULL;
	private $forum = NULL;
	private $words = NULL;
	
    public function __construct() {
        parent::__construct();
		
		$this->forum = new OBForum();
		$this->words = new Words();
		
		$this->getcount;
		$this->total_pages;		
    }
		
	public function getPostsCount($topic, $entries_per_page='' , $pageno = '') {
	
		$sql = "SELECT COUNT(*) FROM messages WHERE topicid = :topic";
		
		return (int) $this->db->count($sql, array(':topic' => $topic));
	}
	
	public function getPosts($topic, $entries_per_page='' , $pageno = '') {
	
		// get the number of rows
		$this->getcount = $this->getPostsCount($topic);
		
		// get the pagenum.  If it doesn't exist, set it to 1
		if(!empty($pageno) ? $page = $pageno : $page = 1);
		// set the number of entries to appear on the page
		 
		// total pages is rounded up to nearest integer
		if(!empty($entries_per_page) ? $this->total_pages = ceil($this->getcount/$entries_per_page) : $this->getcount); 
		// offset is used by SQL query in the LIMIT
		$offset = (($page * $entries_per_page) - $entries_per_page);
			
		if($this->getcount != 0) {
		
			$sql = "SELECT  b.boardid, 
							b.boardname, 
							t.topicid, 
							t.topicname as topic,
							t.locked, 
							m.messageid, 
							m.author as mauthor, 
							m.message as message, 
							DATE_FORMAT(m.postdate, '%M %d, %Y, %r') as newpostdate, 
							tm.post_count as posts, 
							u.user_level, 
							DATE_FORMAT(u.signup_date, '%b %Y') as joindate, 
							ms.avatar, 
							ms.signature
						FROM topics t
					INNER
						JOIN boards b
							ON t.boardid = b.boardid
					INNER 
						JOIN messages m 
							ON t.topicid = m.topicid
					INNER 
						JOIN users u
							ON m.author = u.username
					INNER 
						JOIN misc ms
							ON ms.userid = u.userid
					INNER
						JOIN (SELECT author, COUNT(*) as post_count
								FROM messages
							  GROUP
								BY author) as tm
							ON tm.author = m.author
						WHERE t.topicid = :topic
						ORDER BY postdate ASC LIMIT $offset, $entries_per_page";
		
			$rows = $this->db->select($sql, array(':topic' => $topic));
			
			$posts = array();

			$counter = 0;
			
			foreach($rows as $key => $row) {
			
				if($counter != 0) {
					$topic = "Re: ".ucwords($row['topic']);
					$reply = "Reply #".$counter." on: ";
				}
				else {
					$topic = ucwords($row['topic']);
					$reply = "on: ";
				}
				
				if(in_array($row['mauthor'], $this->usersOnline())) {
					$useronline = 'Online';
				}
				else {
					$useronline = 'Offline';
				}
				
				switch($row['user_level']) {
					case 'default':
						$userlvl = 'Supporter';
						break;
					case 'admin':
						$userlvl = 'Moderator</p>';
						break;
					case 'owner':
						$userlvl = 'Site Admin</p>';
						break;
					default:
				}
		
				$posts[$key]['boardid'] = $row['boardid'];
				$posts[$key]['boardname'] = $row['boardname'];
				$posts[$key]['topicid'] = $row['topicid'];
				$posts[$key]['topic'] = $topic;
				$posts[$key]['messageid'] = $row['messageid'];
				$posts[$key]['mauthor'] = $row['mauthor'];
				$posts[$key]['message'] = html_entity_decode($row['message']);
				$posts[$key]['newpostdate'] = $row['newpostdate'];
				$posts[$key]['posts'] = $row['posts'];
				$posts[$key]['user_level'] = $userlvl;
				$posts[$key]['joindate'] = $row['joindate'];
				$posts[$key]['avatar'] = $row['avatar'];
				$posts[$key]['signature'] = $row['signature'];
				$posts[$key]['reply'] = $reply;
				$posts[$key]['online'] = $useronline;
				$posts[$key]['locked'] = $row['locked'];
			}
			
			if(($offset+$entries_per_page) < $this->getcount) {
			
				$pagemax = ($offset+$entries_per_page);
			}
			else {
			
				$pagemax = $this->getcount;
			}
			
			return array('rows' => $posts, 'total_pages' => $this->total_pages, 'page' => $page, 'offset' => $offset+1, 'pagemax' => $pagemax, 'rowcount' => $this->getcount);
		}
		else {
		
			return array('rows' => '', 'total_pages' => $this->total_pages, 'page' => $page);
		}
	}
	
	public function updateTopics($topic) {
	
		$sql = 'UPDATE topics SET counter = counter + 1 WHERE topicid = :topic';
		
		$this->db->increment($sql, array(':topic' => $topic));
	}

	public function usersOnline() {
	
		//show the number of people online now.... 
		$sql = "SELECT * FROM logged_in_member WHERE status = :status";
		
		$status = 1;
		
		return $this->db->select($sql, array(':status' => $status));
	}
	
	public function postReply($data) {
	
		$this->db->insert('messages', array(
			'boardid' => $data['boardid'],
			'topicid' => $data['topicid'],
			'message' => $data['message'],
			'author' => $data['author']
		));
		
		return true;
	}
}