<?php

class Comments_Model extends Model {

	private $getcount = NULL;
	private $total_pages = NULL;
	
    public function __construct() {
	
        parent::__construct();
		
		$this->getcount;
		$this->total_pages;
    }	
	
	public function getRowCount() {
	
		$sql = "SELECT MAX(counts.counted) AS mycount
				FROM (
					SELECT COUNT(*) AS counted
					FROM comments WHERE status = 0
					UNION ALL
					SELECT COUNT(*) AS counted
					FROM comments WHERE status = 1) AS counts";
		
		return (int) $this->db->count($sql);
	}
	
	public function commentsIndex($entries_per_page, $pageno = '') {
		
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
		
			$sql="(SELECT commentid, author, comment, postdate, status FROM comments WHERE status = 0 ORDER by postdate DESC LIMIT $offset, $entries_per_page) UNION (SELECT commentid, author, comment, postdate, status FROM comments WHERE status = 1 ORDER by postdate DESC LIMIT $offset, $entries_per_page)";
			
			$rows = $this->db->clean($sql);
			
			foreach($rows as $key => $row) {
				$rows[$key]['postdate'] = date("d M Y", strtotime($row['postdate']));
			}

			return array('rows' => $rows, 'total_pages' => $this->total_pages, 'page' => $page, 'rowcount' => $this->getcount);
		}
		else {
			return array('rows' => 0, 'total_pages' => 0, 'page' => 0, 'rowcount' => 0);
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
		
		$comments = array();
		
		foreach($rows as $array) {
			foreach($array as $key => $value) {
				$comments[$key] = $value;
			}	
		}
		
		return array('rows' => $comments);
	}
	
	public function commentPublish($ids) {

		return array('result' => $this->db->updateCase('comments', 'status', "`commentid` IN (".implode(',',$id).")"), 'action' => 'published');
	}
	
	public function commentDelete($ids) {
	
		return array('result' => $this->db->delete('comments', "`commentid` IN (".implode(',',$id).")"), 'action' => 'deleted');
	}
}