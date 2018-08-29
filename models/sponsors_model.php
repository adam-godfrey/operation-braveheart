<?php

class Sponsors_Model extends Model {

	private $getcount = NULL;
	private $total_pages = NULL;
	
    public function __construct()
    {
        parent::__construct();
		
		$this->getcount;
		$this->total_pages;
    }
	
	public function getRowCount() {
	
		$sql = "SELECT COUNT(*) FROM sponsors";
		
		return (int) $this->db->cleanCache('sponsors_GetRowCount', $sql);
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
		
			$sql="SELECT * FROM sponsors ORDER BY name ASC LIMIT $offset, $entries_per_page";
			
			$rows = $this->db->cleanCache('sponsors_GetContent'.$page, $sql);

			return array('rows' => $rows, 'total_pages' => $this->total_pages, 'page' => $page, 'rowcount' => $this->getcount);
		}
	}
}