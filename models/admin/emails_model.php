<?php

class Emails_Model extends Model {

	private $getcount = NULL;
	private $total_pages = NULL;
	
    public function __construct() {
	
        parent::__construct();
		
		$this->getcount;
		$this->total_pages;
    }	
	
	public function getRowCount() {
	
		$sql = "SELECT COUNT(*) FROM email";
		
		return (int) $this->db->clean($sql);
	}
	
	public function emailsIndex($entries_per_page, $pageno = '') {
		
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
		
			$sql="SELECT id, name, email, subject, opened, replied FROM email LIMIT $offset, $entries_per_page";
			
			$rows = $this->db->clean($sql);

			return array('rows' => $rows, 'total_pages' => $this->total_pages, 'page' => $page);
		}		
    }
	
	public function commentsContent($id) {
	
		$sql = 'SELECT c. * , ifnull( cc.commentcount, 0 ) AS ccount,
			CASE c.page
				WHEN "news" THEN (
					SELECT title FROM news WHERE id = c.pageid
				)
				WHEN "blogs" THEN (
					SELECT title FROM blogs WHERE id = c.pageid
				)
				WHEN "event" THEN (
					SELECT title FROM events WHERE id = c.pageid
				)
				ELSE ""
				END AS title
			FROM comments c
			LEFT OUTER JOIN (
				
				SELECT page, pageid, count( * ) AS commentcount
				FROM comments
				GROUP BY page
				) AS cc ON cc.pageid = c.pageid
			WHERE c.commentid = :id LIMIT 1';
		
		$rows = $this->db->select($sql, array(':id' => $id));
		
		return array('rows' => $rows);
	}
	
	public function commentApprove($values) {

		$postData = array(
            'status' => 1
        );
        
       $this->db->updatein('comments', $postData, "`commentid`", $values);
	}
	
	public function commentDelete($ids) {
	
		$this->db->delete('comments', "`commentid` IN (".implode(',',$ids).")");
	}
}