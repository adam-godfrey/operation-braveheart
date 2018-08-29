<?php

class Blogs_Model extends Model {

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
	
		$sql = "SELECT COUNT(*) FROM blogs WHERE archived=:archived";
		
		return (int) $this->db->countCache('blogs_GetRowCount', $sql, array(':archived' => 'n'));
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
		
			$sql="SELECT id, title, content, DATE_FORMAT( postdate, '%D %M %Y' ) AS postdate, image, alternate, ifnull( c.commentscount, 0 ) AS count
				FROM blogs b
				LEFT OUTER
				JOIN (
				
				SELECT pageid, page, count( * ) AS commentscount
				FROM comments
				GROUP BY pageid
				) AS c ON c.pageid = b.id
				WHERE archived=:archived
				ORDER BY id DESC LIMIT $offset, $entries_per_page";
			
			$rows = $this->db->selectCache('blogs_GetContent', $sql, array(':archived' => 'n'));
			
			$blogs = array();
			
			foreach($rows as $key=> $row) {

				$blogs[$key]['title'] = strtoupper($row['title']);
				$blogs[$key]['content'] = $this->words->trunc($row['content'], 60);
				$blogs[$key]['postdate'] = $row['postdate'];
				$blogs[$key]['image'] = $row['image'];
				$blogs[$key]['alternate'] = $row['alternate'];
				$blogs[$key]['count'] = $row['count'];
			}

			return array('rows' => $blogs, 'total_pages' => $this->total_pages, 'page' => $page, 'rowcount' => $this->getcount);
		}
		else {
			return array('rows' => 0);
		}
	}
	
	public function getBlog($entries_per_page, $pageno = '') {
	
		// get the number of rows
		$this->getcount = $this->getRowCount();
		// get the pagenum.  If it doesn't exist, set it to 1
		if(!empty($pageno) ? $page = $pageno : $page = 1); 
		// total pages is rounded up to nearest integer
		$this->total_pages = ceil($this->getcount/$entries_per_page); 
		// offset is used by SQL query in the LIMIT
		$offset = (($page * $entries_per_page) - $entries_per_page);

		if($this->getcount != 0) {
		
			$sql = "SELECT id, title, content, DATE_FORMAT( postdate, '%D %M %Y' ) AS postdate, image, alternate, ifnull( c.commentscount, 0 ) AS count
				FROM blogs b
				LEFT OUTER
				JOIN (
				
				SELECT pageid, page, count( * ) AS commentscount
				FROM comments
				GROUP BY pageid
				) AS c ON c.pageid = b.id
				WHERE archived=:archived
				ORDER BY id DESC LIMIT $offset, $entries_per_page";
			
			$rows = $this->db->selectCache('blogs_GetBlog', $sql, array(':archived' => 'n'));

			return array('rows' => $rows, 'total_pages' => $this->total_pages, 'page' => $page, 'rowcount' => $this->getcount);
		}
		else {
			return array('rows' => 0, 'total_pages' => 0, 'page' => 0, 'rowcount' => 0);
		}
	}
	
	public function getCommentsCount($blogid) {
	
		$sql="SELECT COUNT(c.pageid),
					 c.pageid
				FROM comments c 
				INNER JOIN blogs b
					ON c.pageid = b.id 
				LEFT OUTER JOIN (SELECT page,pageid, 
								 COUNT(*) as commentcount 
								 FROM comments 
						GROUP BY page) as cc 
				on cc.pageid = c.pageid
				WHERE c.pageid= :blogid";
				
		return (int) $this->db->countCache('blogs_GetCommentsCount', $sql, array(':blogid' => $blogid));
	}
	
	public function getComments($blogid) {
	
		// get the number of rows
		$this->getcount = $this->getCommentsCount($blogid);
		
		if($this->getcount != 0) {
		
			$sql="SELECT `b`.`title`,
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
						LEFT OUTER JOIN `blogs` `b` ON b.id = `c`.`pageid`
					WHERE `c`.`page` = 'blogs'
						AND `c`.`pageid` = :blogid";
			
			$rows = $this->db->selectCache('blogs_GetComments', $sql, array(':blogid' => $blogid));
			
			foreach($rows as $key => $row) {
			
				$rows[$key]['postdate'] = $this->braveheart->getDateDifference($row['postdate'], date('Y-m-d'));
			}

			return array('comments' => $rows);
		}
	}
	
	public function submitComment($data) {
	
		if ($this->verifyFormToken($data)) {
	
			$this->db->insert('comments', array(
					'page' => 'blogs',
					'pageid' => $data['blogid'],
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
			$emailContent['body'] = "Hi Dave! \r\nA new comment has been posted on the website under the 'Blogs' category. \r\n Many Thanks! \r\n The Operation Braveheart admin team. \r\n This is an automated response, please do not reply!";
			$emailContent['part'] = "Hi Dave! \r\nA new comment has been posted on the website under the 'Blogs' category. \r\n Many Thanks! \r\n The Operation Braveheart admin team. \r\n This is an automated response, please do not reply!";
			
			return ($this->sendMail($emailContent)) ? true : false;
		}
		else {
			return false;
		}
	}
}