<?php

class Poems_Model extends Model {

	private $getcount = NULL;
	private $total_pages = NULL;
	
    public function __construct() {
	
        parent::__construct();
		
		$this->getcount;
		$this->total_pages;
    }	
	
	public function getRowCount() {
	
		$sql = "SELECT COUNT(*) FROM poems";
		
		return (int) $this->db->count($sql);
	}
	
	public function poemsIndex($entries_per_page, $pageno = '') {
		
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
		
			$sql="SELECT id, title, author FROM poems LIMIT $offset, $entries_per_page";
			
			$rows = $this->db->clean($sql);

			return array('rows' => $rows, 'total_pages' => $this->total_pages, 'page' => $page, 'rowcount' => $this->getcount);
		}
		else {
			return array('rows' => 0, 'total_pages' => 0, 'page' => 0, 'rowcount' => 0);
		}		
    }
	
	public function poemContent($id) {
	
		$sql = 'SELECT id, title, author, content FROM poems WHERE id = :id LIMIT 1';
		
		$rows = $this->db->select($sql, array(':id' => $id));
		
		$poems = array();
		
		foreach($rows as $row) {
			foreach($row as $key => $value) {
				$poems[$key] = $value;
			}	
		}
		
		return array('rows' => $poems);
	}
	
	public function poemAdd($data) {
	
		$insert = $this->db->insert('poems', array(
            'title' => $data['title'],
			'author' => $data['author'],
			'content' =>$data['content']
        ));
		
		return ($insert) ? true : false;
	}
	
	public function poemEdit($data) {
	
		$postData = array(
            'title' => $data['title'],
			'author' => $data['author'],
			'content' =>$data['content']
        );
        
        return $this->db->update('poems', $postData, "`id` = {$data['id']}");
	}
	
	public function poemDelete($ids) {
	
		return $this->db->delete('poems', "`id` IN (".implode(',',$id).")");
	}
}