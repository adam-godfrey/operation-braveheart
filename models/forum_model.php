<?php

class Forum_Model extends Model {

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
	
	public function getBoardCount() {
	
		$sql = "SELECT  b.boardid as boardno, b.*, t.topicname, m.*,
				(SELECT  COUNT(*) FROM topics ti
					WHERE ti.boardid = b.boardid) AS topiccount,
				(SELECT COUNT(*) FROM topics ti, messages mi
					WHERE ti.boardid = b.boardid AND mi.topicid = ti.topicid) AS messagecount
				FROM boards b LEFT JOIN messages m ON m.messageid =
				(SELECT  mii.messageid FROM topics tii, messages mii
					WHERE tii.boardid = b.boardid AND mii.topicid = tii.topicid
				ORDER BY mii.postdate DESC LIMIT 1) LEFT JOIN topics t ON t.topicid = m.topicid ORDER BY boardname ASC";
				
		return (int) $this->db->clean($sql);	
	}
	
	public function getBoards($entries_per_page, $pageno = '') {
	
		// get the number of rows
		$this->getcount = $this->getBoardCount();
		// get the pagenum.  If it doesn't exist, set it to 1
		if(!empty($pageno) ? $page = $pageno : $page = 1);
		// set the number of entries to appear on the page
		 
		// total pages is rounded up to nearest integer
		$this->total_pages = ceil($this->getcount/$entries_per_page); 
		// offset is used by SQL query in the LIMIT
		$offset = (($page * $entries_per_page) - $entries_per_page);
			
		if($this->getcount != 0) {
		
			$sql = "SELECT  b.boardid as boardno, 
							b.*, t.topicname, 
							m.messageid,
							m.author,
							m.postdate,
							(SELECT  COUNT(*) FROM topics ti
								WHERE ti.boardid = b.boardid) AS topiccount,
							(SELECT COUNT(*) FROM topics ti, messages mi
								WHERE ti.boardid = b.boardid AND mi.topicid = ti.topicid) AS messagecount
							FROM boards b LEFT JOIN messages m ON m.messageid =
								(SELECT  mii.messageid FROM topics tii, messages mii
									WHERE tii.boardid = b.boardid AND mii.topicid = tii.topicid
							ORDER BY mii.postdate DESC LIMIT 1) LEFT JOIN topics t ON t.topicid = m.topicid ORDER BY boardname ASC LIMIT $offset, $entries_per_page";
		
			$rows = $this->db->clean($sql);
			
			$boards = array();

			foreach($rows as $key=> $row) {

				$boards[$key]['postdate'] = $this->forum->change_date(strtotime($row['postdate']));
				$boards[$key]['boardid'] = $row['boardno'];
				$boards[$key]['boardname'] = ucwords($row['boardname']);
				$boards[$key]['topicname'] = $this->words->shortenText($row['topicname'],30);
				$boards[$key]['board'] = strtolower(str_replace(array(' ','\''), array('-',''), $row['boardname']));
				$boards[$key]['boarddesc'] = $row['boarddesc'];
				$boards[$key]['messagecount'] = $row['messagecount'];
				$boards[$key]['topiccount'] = $row['topiccount'];
				$boards[$key]['author'] = $row['author'];
			}
			
			return array('rows' => $boards, 'total_pages' => $this->total_pages, 'page' => $page, 'rowcount' => $this->getcount);
		}
		else {
		
			return array('rows' => '', 'total_pages' => $this->total_pages, 'page' => $page, 'rowcount' => $this->getcount);
		}
	}
}