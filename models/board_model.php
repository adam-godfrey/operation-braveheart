<?php

class Board_Model extends Model {

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
	
	public function getTopicsCount($boardid) {
	
		$sql = "SELECT 	b.boardname,
						b.boardid,
						t.topicid, 
						t.topicname,
						t.author AS tauthor,
						t.counter,
						t.locked as locked,
						tm.msg_count,
						tm.last_msg_date,
						lm.author AS last_msg_author
				FROM boards AS b
				INNER JOIN topics AS t
					ON t.boardid = b.boardid 
				INNER JOIN (
					SELECT  topicid, 
							COUNT(*) AS msg_count,
							MAX(`postdate`) AS last_msg_date
					FROM messages GROUP BY topicid ) AS tm
					ON tm.topicid = t.topicid 
				INNER JOIN messages AS lm
					ON lm.topicid = t.topicid AND lm.postdate = tm.last_msg_date
				WHERE b.boardid = :board
				ORDER BY t.topicname = 'Forum Rules And Guidelines' DESC, tm.last_msg_date DESC";
			
		return (int) count($this->db->select($sql, array(':board' => $boardid)));
	}
	
	public function getTopics($boardid, $entries_per_page='' , $pageno = '') {
	
		// get the number of rows
		$this->getcount = $this->getTopicsCount($boardid);
		
		// get the pagenum.  If it doesn't exist, set it to 1
		if(!empty($pageno) ? $page = $pageno : $page = 1);
		// set the number of entries to appear on the page
		 
		// total pages is rounded up to nearest integer
		$this->total_pages = ceil($this->getcount/$entries_per_page); 
		// offset is used by SQL query in the LIMIT
		$offset = (($page * $entries_per_page) - $entries_per_page);
			
		if($this->getcount != 0) {
		
			$sql = "SELECT 	b.boardid,
						b.boardname,
						t.topicid, 
						t.topicname,
						t.author AS author,
						t.counter,
						t.locked as locked,
						tm.msg_count,
						tm.last_msg_date,
						lm.author AS last_msg_author
				FROM boards AS b
				INNER JOIN topics AS t
					ON t.boardid = b.boardid 
				INNER JOIN (
					SELECT  topicid, 
							COUNT(*) AS msg_count,
							MAX(`postdate`) AS last_msg_date
					FROM messages GROUP BY topicid ) AS tm
					ON tm.topicid = t.topicid 
				INNER JOIN messages AS lm
					ON lm.topicid = t.topicid AND lm.postdate = tm.last_msg_date
				WHERE b.boardid = :board
				ORDER BY t.topicname = 'Forum Rules And Guidelines' DESC, tm.last_msg_date DESC LIMIT $offset,$entries_per_page";
				
			$rows = $this->db->select($sql, array(':board' => $boardid));
			
			$topics = array();

			foreach($rows as $key=> $row) {
			
				$topics[$key]['boardid'] = $row['boardid'];
				$topics[$key]['boardname'] = ucwords($row['boardname']);
				$topics[$key]['topicid'] = $row['topicid'];
				$topics[$key]['topic'] = str_replace(' ','-',strtolower($row['topicname']));
				$topics[$key]['topicname'] = $this->words->shortenText($row['topicname'],30);
				$topics[$key]['author'] = $row['author'];
				$topics[$key]['counter'] = $row['counter'];
				$topics[$key]['locked'] = $row['locked'];
				$topics[$key]['msg_count'] = $row['msg_count'];
				$topics[$key]['last_msg_date'] = $this->forum->change_date(strtotime($row['last_msg_date']));
				$topics[$key]['last_msg_author'] = $row['last_msg_author'];
			}
			
			if(($offset+$entries_per_page) < $this->getcount) {
			
				$pagemax = ($offset+$entries_per_page);
			}
			else {
			
				$pagemax = $this->getcount;
			}
			
			return array('rows' => $topics, 'total_pages' => $this->total_pages, 'page' => $page, 'offset' => $offset+1, 'pagemax' => $pagemax, 'rowcount' => $this->getcount);	
		}
		else {
			
			return array('rows' => '', 'total_pages' => $this->total_pages, 'page' => $page);
		}
	}
	
	public function newTopic($data) {
			
		// start a transaction so if anything fails, roll all others back
		$this->db->beginTransaction();
		
		try {
			// insert into the users table, the form data from user
			$this->db->insert('topics', array(
				'boardid' => $data['boardid'],
				'topicname' => $data['topictitle'],
				'author' => $data['author']
			));
			
			try {
				// get the new userid for the user
				$insertID = $this->db->lastInsertId();
				
				// insert into the users table, the form data from user
				$this->db->insert('messages', array(
					'boardid' => $data['boardid'],
					'topicid' => $insertID,
					'message' => $data['message'],
					'author' => $data['author'],
					'parent' => 1
				));
				
				// end the transactions as all data should have saved.  On failuire, rollback.
				$this->db->endTransaction();
				
				return true;
			}
			catch(PDOException $e) {
				// If this statement fails, rollback...
				$this->db->cancelTransaction();
				
				// write the error to the log
				$errmsg = $e->getMessage();
				error_log('$errmsg-> '.$errmsg);
				
				return false;
			}
		}
		catch(PDOException $e) {
			// If this statement fails, rollback...
			$this->db->cancelTransaction();
			
			// write the error to the log
			$errmsg = $e->getMessage();
			error_log('$errmsg-> '.$errmsg);
			
			return false;
		}
	}
}