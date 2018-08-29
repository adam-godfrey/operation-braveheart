<?php

class Forum_Boards_Model extends Model {

	private $getcount = NULL;
	private $total_pages = NULL;
	
    public function __construct() {
	
        parent::__construct();
		
		$this->getcount;
		$this->total_pages;
    }	
	
	public function getRowCount() {
	
		$sql = "SELECT  b.*, t.topicname, m.*,
        (SELECT  COUNT(*) FROM topics ti
			WHERE ti.boardid = b.boardid) AS topiccount,
        (SELECT COUNT(*) FROM topics ti, messages mi
			WHERE ti.boardid = b.boardid AND mi.topicid = ti.topicid) AS messagecount
		FROM boards b LEFT JOIN messages m ON m.messageid =
		(SELECT  mii.messageid FROM topics tii, messages mii
			WHERE tii.boardid = b.boardid AND mii.topicid = tii.topicid
        ORDER BY mii.postdate DESC LIMIT 1) LEFT JOIN topics t ON t.topicid = m.topicid";
		
		return (int) count($this->db->clean($sql));
	}
	
	public function boardsIndex($entries_per_page, $pageno = '') {
		
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
		
			$sql="SELECT  b.*, t.topicname, m.*,
					(SELECT  COUNT(*) FROM topics ti
						WHERE ti.boardid = b.boardid) AS topiccount,
					(SELECT COUNT(*) FROM topics ti, messages mi
						WHERE ti.boardid = b.boardid AND mi.topicid = ti.topicid) AS messagecount
					FROM boards b LEFT JOIN messages m ON m.messageid =
					(SELECT  mii.messageid FROM topics tii, messages mii
						WHERE tii.boardid = b.boardid AND mii.topicid = tii.topicid
					ORDER BY mii.postdate DESC LIMIT 1) LEFT JOIN topics t ON t.topicid = m.topicid LIMIT $offset, $entries_per_page";
			
			$rows = $this->db->clean($sql);

			return array('rows' => $rows, 'total_pages' => $this->total_pages, 'page' => $page);
		}		
    }
	
	public function boardContent($id) {
	
		$sql = 'SELECT boardid, boardname, boarddesc FROM boards WHERE boardid = :id LIMIT 1';
		
		$rows = $this->db->select($sql, array(':id' => $id));
		
		return array('rows' => $rows);
	}
	
	public function boardAdd($data) {
	
		$insert = $this->db->insert('boards', array(
            'boardname' => $data['title'],
            'boarddesc' =>$data['description']
        ));
		
		return ($insert) ? true: false;
	}
	
	public function boardEdit($data) {
	
		$postData = array(
            'boardname' => $data['title'],
            'boarddesc' =>$data['description']
        );
        
        return $this->db->update('boards', $postData, "`boardid` = {$data['id']}");
	}
	
	public function boardDelete($id) {
	
		return $this->db->delete('boards', "`boardid` IN (".implode(',',$id).")");
	}
}