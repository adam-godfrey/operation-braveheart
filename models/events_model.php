<?php

class Events_Model extends Model {

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
	
		$eventdate = date('Y-m-d');
		
		$sql = "SELECT COUNT(*) FROM events"; // WHERE eventdate >= '".$eventdate."'";
		
		return (int) $this->db->countCache('events_GetRowCount', $sql);
	}
	
	public function getContent($entries_per_page, $pageno = '') {
	
		$eventdate = date('Y-m-d');
		
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
		
			$sql="SELECT e.*, 
						 v.total, 
						 v.votes, 
						 v.eventid, 
						 ifnull(r.reviewcount,0) as revcount,
						 ifnull(c.commentscount, 0) as commcount
						 FROM events e
						 LEFT OUTER JOIN vote v 
							ON e.id = v.eventid 
						LEFT OUTER JOIN
							(SELECT 
								eventid, 
								count(*) as reviewcount 
							FROM reviews 
								GROUP BY eventid) as r 
							ON r.eventid = v.eventid
						LEFT OUTER JOIN 
							(SELECT pageid, 
									page,
									count( * ) AS commentscount
							FROM comments
								GROUP BY pageid) AS c 
							ON c.pageid = e.id 	
					WHERE e.eventdate >= :eventdate			
					ORDER BY e.eventdate, e.title ASC LIMIT $offset,$entries_per_page";
			
			$rows = $this->db->selectCache('events_GetContent'.$page, $sql, array(':eventdate' => $eventdate));
			
			$events = array();
			
			$currentmonth = '';
			
			foreach($rows as $key=> $row) {
			
				$current = (($row['total'] != 0) && ($row['votes'] != 0)) ? ($this->bravehart->round_to_half($row['total'] / $row['votes'])) : 0;
								
				$events[$key]['title'] = strtoupper($row['title']);
				$events[$key]['photo'] = $row['photo'];
				$events[$key]['alternate'] = $row['alternate'];
				$events[$key]['location'] = $row['location'];
				$events[$key]['eventdate']  = $this->braveheart->formatDate($row['eventdate']);
				$events[$key]['content'] = $this->words->trunc($row['content'], 60);
				$events[$key]['current'] = $current;
				//$events[$key]['rate'] = $this->bravehart->GetRating($current);
				$events[$key]['postdate'] = $this->braveheart->formatDate( $row['postdate']);
				$events[$key]['short_url'] = $row['short_url'];
				$events[$key]['revcount'] = $row['revcount'];
				$events[$key]['count'] = $row['commcount'];				
			}
			
			//echo '<pre>';var_dump($events);echo'</pre>';

			return array('rows' => $events, 'total_pages' => $this->total_pages, 'page' => $page, 'rowcount' => $this->getcount);
		}
	}
	
	public function getEvent($entries_per_page, $pageno = '') {
	
		$eventdate = date('Y-m-d');
		
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
		
			$sql="SELECT e.*,
						 v.total,
						 v.votes, 
						 v.eventid, 
						 ifnull(r.reviewcount,0) as revcount,
						 ifnull(c.commentscount, 0) as commcount
					FROM events e
					LEFT OUTER JOIN vote v 
						ON e.id = v.eventid 
					LEFT OUTER JOIN
						(SELECT eventid, 
								count(*) as reviewcount 
						FROM reviews 
							GROUP BY eventid) as r 
						ON r.eventid = v.eventid
					LEFT OUTER JOIN 
						(SELECT pageid, 
								page,
								count( * ) AS commentscount
						FROM comments
							GROUP BY pageid) AS c 
						ON c.pageid = e.id 	
				WHERE e.eventdate >= :eventdate 	
				ORDER BY e.eventdate, e.title ASC LIMIT $offset,$entries_per_page";
								
			$rows = $this->db->selectCache('events_GetEvent'.$page, $sql, array(':eventdate' => $eventdate));

			return array('rows' => $rows, 'total_pages' => $this->total_pages, 'page' => $page, 'rowcount' => $this->getcount);
		}
	}
	
	public function getCommentsCount($eventid) {
	
		$sql="SELECT COUNT(c.pageid),
					 c.pageid
				FROM comments c 
				INNER JOIN events e
					ON c.pageid = e.id 
				LEFT OUTER JOIN (SELECT page,pageid, 
								 COUNT(*) as commentcount 
								 FROM comments 
						GROUP BY page) as cc 
				on cc.pageid = c.pageid
				WHERE c.pageid= :eventid";
				
		return (int) $this->db->countCache('events_GetCommentsCount', $sql, array(':eventid' => $eventid));
	}
	
	public function getComments($eventid) {
	
		// get the number of rows
		$this->getcount = $this->getCommentsCount($eventid);
		
		if($this->getcount != 0) {
		
			$sql="SELECT `e`.`title`,
						`c`.`page`,
						`c`.`pageid`,
						`c`.`comment`,
						`c`.`user`,
						`c`.`status`,
						`c`.`posted`,
						`m`.`avatar`
					FROM `comments` `c`
						LEFT JOIN `users` `u` ON `c`.`email` = `u`.`email`
						LEFT JOIN `misc` `m` ON `m`.`userid` = `u`.`userid`
						LEFT OUTER JOIN `events` `e` ON e.id = `c`.`pageid`
					WHERE `c`.`page` = 'events'
						AND `c`.`pageid` = :eventid";
			
			$rows = $this->db->selectCache('events_GetComments'.$page, $sql, array(':eventid' => $eventid));
			
			if($rows > 0) {
			
				foreach($rows as $key => $row) {
				
					$rows[$key]['postdate'] = $this->braveheart->getDateDifference($row['posted'], date('Y-m-d'));
				}

				return array('comments' => $rows);
			}
		}
	}
	
	public function submitComment($data) {
	
		if ($this->verifyFormToken($data)) {
	
			$this->db->insert('comments', array(
					'page' => 'events',
					'pageid' => $data['eventid'],
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
			$emailContent['body'] = "Hi Dave! \r\nA new comment has been posted on the website under the 'Articles' category. \r\n Many Thanks! \r\n The Operation Braveheart admin team. \r\n This is an automated response, please do not reply!";
			$emailContent['part'] = "Hi Dave! \r\nA new comment has been posted on the website under the 'Articles' category. \r\n Many Thanks! \r\n The Operation Braveheart admin team. \r\n This is an automated response, please do not reply!";
			
			return ($this->sendMail($emailContent)) ? true : false;
		}
		else {
			return false;
		}
	}
	
	public function getEventsByDate($entries_per_page, $eventdate, $pageno = '') {
			
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
		
			$sql="SELECT e.*, 
						 v.total, 
						 v.votes, 
						 v.eventid, 
						 ifnull(r.reviewcount,0) as revcount,
						 ifnull(c.commentscount, 0) as commcount
						 FROM events e
						 LEFT OUTER JOIN vote v 
							ON e.id = v.eventid 
						LEFT OUTER JOIN
							(SELECT 
								eventid, 
								count(*) as reviewcount 
							FROM reviews 
								GROUP BY eventid) as r 
							ON r.eventid = v.eventid
						LEFT OUTER JOIN 
							(SELECT pageid, 
									page,
									count( * ) AS commentscount
							FROM comments
								GROUP BY pageid) AS c 
							ON c.pageid = e.id 	
					WHERE e.eventdate = :eventdate			
					ORDER BY e.eventdate, e.title ASC LIMIT $offset,$entries_per_page";
			
			$rows = $this->db->selectCache('events_GetEventsByDate-'.$eventdate, $sql, array(':eventdate' => $eventdate));
			
			$events = array();
			
			$currentmonth = '';
			
			foreach($rows as $key=> $row) {
			
				$current = (($row['total'] != 0) && ($row['votes'] != 0)) ? ($this->bravehart->round_to_half($row['total'] / $row['votes'])) : 0;
								
				$events[$key]['title'] = strtoupper($row['title']);
				$events[$key]['photo'] = $row['photo'];
				$events[$key]['alternate'] = $row['alternate'];
				$events[$key]['location'] = $row['location'];
				$events[$key]['eventdate']  = $this->braveheart->formatDate($row['eventdate']);
				$events[$key]['content'] = $this->words->trunc($row['content'], 60);
				$events[$key]['current'] = $current;
				//$events[$key]['rate'] = $this->bravehart->GetRating($current);
				$events[$key]['postdate'] = $this->braveheart->formatDate( $row['postdate']);
				$events[$key]['short_url'] = $row['short_url'];
				$events[$key]['revcount'] = $row['revcount'];
				$events[$key]['count'] = $row['commcount'];				
			}
			
			//echo '<pre>';var_dump($events);echo'</pre>';

			return array('rows' => $events, 'total_pages' => $this->total_pages, 'page' => $page, 'rowcount' => $this->getcount);
		}
	}
}