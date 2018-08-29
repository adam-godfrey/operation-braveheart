<?php

class Gallery_Model extends Model {

	private $getcount = NULL;
	private $total_pages = NULL;
	
    public function __construct()
    {
        parent::__construct();
		
		$this->getcount;
		$this->total_pages;
    }
	
	public function getRowCount() {
	
		$sql = "SELECT COUNT(*) FROM image";
		
		return (int) $this->db->cleanCache('gallery_GetRowCount', $sql);
	}
	
	public function getAllImages() {
	
		// get the number of rows
		$this->getcount = $this->getRowCount();
		
		if($this->getcount != 0) {
		
			$sql="SELECT id, thumb, cat FROM image ORDER BY id ASC";
			
			$rows = $this->db->cleanCache('gallery_GetAllImages', $sql);

			return array('rows' => $rows, 'rowcount' => $this->getcount);
		}
	}
	
	public function getContent($category, $entries_per_page, $pageno = '') {
	
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
		
			$sql="SELECT id, thumb, cat FROM image WHERE cat = :category ORDER BY id ASC LIMIT $offset, $entries_per_page";
			
			$rows = $this->db->selectCache('gallery_GetContent', $sql, array(':category' => $category));

			return array('rows' => $rows, 'total_pages' => $this->total_pages, 'page' => $page, 'rowcount' => $this->getcount);
		}
	}
}