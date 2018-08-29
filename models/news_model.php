<?php

class News_Model extends Model {

	private $getcount = NULL;
	private $total_pages = NULL;
	private $words = NULL;
	private $braveheart = NULL;
	
	
    public function __construct()
    {
        parent::__construct();
		
		$this->words = new Words();
		$this->braveheart = new Braveheart();
		
		$this->getcount;
		$this->total_pages;
    }
	
	public function getRowCount() {
	
		$sql = "SELECT COUNT(*) FROM news WHERE archived=:archived";
		
		return (int) $this->db->countCache('news_GetrowCount', $sql, array(':archived' => 0));
	}
	
	public function getContent($entries_per_page, $pageno = '') {
	
		// get the number of rows
		$this->getcount = $this->getRowCount();
		// get the pagenum.  If it doesn't exist, set it to 1
		if(!empty($pageno) ? $page = $pageno : $page = 1);
		// set the number of entries to appear on the page
		 
		// total pages is rounded up to nearest integer
		$this->total_pages = ceil($this->getcount/$entries_per_page); 
		// offset is used by SQL query in the LIMIT
		$offset = (($page * $entries_per_page) - $entries_per_page);
			
		if($this->getcount != 0) {
		
			$sql="SELECT id, title, content, DATE_FORMAT( postdate, '%D %M %Y' ) AS postdate, photo, alternate, ifnull( c.commentscount, 0 ) AS count
			FROM news n
			LEFT OUTER
			JOIN (
			
			SELECT pageid, page, count( * ) AS commentscount
			FROM comments
			GROUP BY pageid
			) AS c ON c.pageid = n.id
			WHERE archived=:archived
			ORDER BY id DESC LIMIT $offset, $entries_per_page";
			
			$rows = $this->db->selectCache('news_GetContent'.$page, $sql, array(':archived' => 0));
			
			$news = array();
			
			foreach($rows as $key=> $row) {

				$news[$key]['id'] = $row['id'];
				$news[$key]['title'] = strtoupper($row['title']);
				$news[$key]['content'] = $this->words->trunc($row['content'], 60);
				$news[$key]['postdate'] = $row['postdate'];
				$news[$key]['photo'] = $row['photo'];
				$news[$key]['alternate'] = $row['alternate'];
				$news[$key]['count'] = $row['count'];
			}
			
			//echo '<pre>';var_dump($news);echo'</pre>';

			return array('rows' => $news, 'total_pages' => $this->total_pages, 'page' => $page, 'rowcount' => $this->getcount);
		}
		else {
			return array('rows' => 0);
		}
	}
	
	public function getNews($entries_per_page, $pageno = '') {
	
		// get the number of rows
		$this->getcount = $this->getRowCount();
		// get the pagenum.  If it doesn't exist, set it to 1
		if(!empty($pageno) ? $page = $pageno : $page = 1);
		// set the number of entries to appear on the page
		 
		// total pages is rounded up to nearest integer
		$this->total_pages = ceil($this->getcount/$entries_per_page); 
		// offset is used by SQL query in the LIMIT
		$offset = (($page * $entries_per_page) - $entries_per_page);
			
		if($this->getcount != 0) {
		
			$sql = "SELECT id, title, content, DATE_FORMAT( postdate, '%D %M %Y' ) AS postdate, photo, alternate, ifnull( c.commentscount, 0 ) AS count
				FROM news n
				LEFT OUTER
				JOIN (
				
				SELECT pageid, page, count( * ) AS commentscount
				FROM comments
				GROUP BY pageid
				) AS c ON c.pageid = n.id
				WHERE archived=:archived
				ORDER BY id DESC LIMIT $offset, $entries_per_page";
			
			$rows = $this->db->selectCache('news_GetNews'.$page, $sql, array(':archived' => 0));
			
			//echo '<pre>';var_dump($news);echo'</pre>';

			return array('rows' => $rows, 'total_pages' => $this->total_pages, 'page' => $page, 'rowcount' => $this->getcount);
		}
		else {
			return array('rows' => 0, 'total_pages' => 0, 'page' => 0, 'rowcount' => 0);
		}
	}
	
	public function getCommentsCount($newsid) {
	
		$sql="SELECT COUNT(c.pageid),
					 c.pageid
				FROM comments c 
				INNER JOIN news n
					ON c.pageid = n.id 
				LEFT OUTER JOIN (SELECT page,pageid, 
								 COUNT(*) as commentcount 
								 FROM comments 
						GROUP BY page) as cc 
				on cc.pageid = c.pageid
				WHERE c.pageid= :newsid";
				
		return (int) $this->db->countCache('news_GetCommentsCount', $sql, array(':newsid' => $newsid));
	}
	
	public function getComments($newsid) {
	
		// get the number of rows
		$this->getcount = $this->getCommentsCount($newsid);
		
		if($this->getcount != 0) {
		
			$sql="SELECT `n`.`title`,
						`c`.`page`,
						`c`.`pageid`,
						`c`.`comment`,
						`c`.`author`,
						`c`.`status`,
						`c`.`postdate`,
						`m`.`avatar`
					FROM `comments` `c`
						LEFT JOIN `users` `u` ON `c`.`email` = `u`.`email`
						LEFT JOIN `misc` `m` ON `m`.`userid` = `u`.`userid`
						LEFT OUTER JOIN `news` `n` ON n.id = `c`.`pageid`
					WHERE `c`.`page` = 'news'
						AND `c`.`pageid` = :newsid";
			
			$rows = $this->db->selectCache('news_GetComments', $sql, array(':newsid' => $newsid));
			
			foreach($rows as $key => $row) {
			
				$rows[$key]['postdate'] = $this->braveheart->getDateDifference($row['postdate'], date('Y-m-d'));
			}

			return array('comments' => $rows);
		}
	}
	
	public function submitComment($data) {
	
		if ($this->verifyFormToken($data)) {
	
			$this->db->insert('comments', array(
					'page' => 'news',
					'pageid' => $data['newsid'],
					'author' => $data['name'], 
					'email' => $data['email'],
					'website' => $data['website'],
					'comment' => $data['message']
				));
				
			$emailContent = array();
					
			$emailContent['to_name'] = 'David Godfrey';
			//$emailcontent['to_email'] = 'david-operationbraveheart@talktalk.net';
			$emailContent['to_email'] = 'adrock952@gmail.com';
			$emailContent['from_name'] = 'Operation Braveheart';
			$emailContent['from_email'] = 'notifications@operationbraveheart.org.uk';
			$emailContent['subject'] = 'New comment on website';
			$emailContent['body'] = "Hi Dave! \r\nA new comment has been posted on the website under the 'News' category. \r\n Many Thanks! \r\n The Operation Braveheart admin team. \r\n This is an automated response, please do not reply!";
			$emailContent['part'] = "Hi Dave! \r\nA new comment has been posted on the website under the 'News' category. \r\n Many Thanks! \r\n The Operation Braveheart admin team. \r\n This is an automated response, please do not reply!";
			
			return ($this->sendMail($emailContent)) ? true : false;
		}
		else {
			return false;
		}
	}
}