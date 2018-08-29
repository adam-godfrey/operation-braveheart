<?php

class Shop_Model extends Model {

    public function __construct()
    {
        parent::__construct();
    }
	
	public function getRowCount() {
	
		$sql = "SELECT COUNT(*) FROM shop WHERE active = :active";
		
		return (int) $this->db->countCache('shopGetrowCount', $sql, array(':active' => '1'));
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
		
			$sql="SELECT prodid, itemid, item, size, description, shortdesc, image, price FROM shop WHERE active = :active ORDER BY itemid ASC LIMIT $offset, $entries_per_page";
			
			$rows = $this->db->selectCache('shopGetContent'.$page, $sql, array(':active' => '1'));
			
			$items = array();
			
			foreach ($rows as $row) {
				if(!isset($items[$row['itemid']])) {
					$items[$row['itemid']] = $row;
				}
				$items[$row['itemid']]['sizes'][$row['size']] = $row['price'];  ### CHANGED ###
			}

			return array('rows' => $items, 'total_pages' => $this->total_pages, 'page' => $page, 'rowcount' => $this->getcount);
		}
	}
	
	public function getItem($itemid) {
	
		$sql="SELECT prodid, itemid, item, size, description, shortdesc, image, price FROM shop WHERE active = :active AND itemid = :itemid";
		
		$rows = $this->db->selectCache('getItem'.$itemid, $sql, array(':active' => '1', ':itemid' => $itemid));
		
		foreach ($rows as $row) {
			if(!isset($items[$row['itemid']])) {
				$items[$row['itemid']] = $row;
			}
			$items[$row['itemid']]['sizes'][$row['size']] = $row['price'];  ### CHANGED ###
		}

		return array('rows' => $items);
	}
}