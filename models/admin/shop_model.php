<?php

class Shop_Model extends Model {

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
	
		$sql = "SELECT MAX(counts.counted) AS mycount
				FROM (
					SELECT COUNT(*) AS counted
					FROM shop WHERE active = 0
					UNION ALL
					SELECT COUNT(*) AS counted
					FROM shop WHERE active = 1) AS counts";
		
		return (int) $this->db->count($sql);
	}
	
	public function shopIndex($entries_per_page, $pageno = '') {
		
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
		
			$sql="(SELECT prodid, itemid, item, clothing, size, description, shortdesc, keywords image, price, stock, active FROM shop 
				WHERE active = 0 LIMIT $offset, $entries_per_page) 
				UNION 
				(SELECT prodid, itemid, item, clothing, size, description, shortdesc, keywords image, price, stock, active FROM shop 
				WHERE active = 1 LIMIT $offset, $entries_per_page)";
			
			$rows = $this->db->clean($sql);
			
			foreach($rows as $key => $row) {
				$rows[$key]['price'] = "&pound;" . number_format($row['price'], 2);
			}
			
			return array('rows' => $rows, 'total_pages' => $this->total_pages, 'page' => $page, 'rowcount' => $this->getcount);
		}
		else {
			return array('rows' => 0, 'total_pages' => 0, 'page' => 0, 'rowcount' => 0);
		}
	}
	
	public function shopContent($id) {
	
		$sql = 'SELECT prodid, 
						itemid as item_code, 
						item as item_name, 
						clothing, 
						size as item_size,
						shortdesc as short_description,  
						description as full_description, 
						keywords as item_keywords, 
						image as item_image, 
						price as item_price, 
						stock as item_stock, 
						active FROM shop WHERE itemid = :itemid LIMIT 1';
		
		$rows = $this->db->select($sql, array(':itemid' => $id));
		
		$products = array();
		
		foreach($rows as $row) {
			foreach($row as $key => $value) {
				if($key == 'item_price') {
					$products['item_price'] = "&pound;" . number_format($value, 2);
				}
				else {
					$products[$key] = $value;
				}
				
			}	
		}
		
		return array('rows' => $products);
	}
	
	public function shopAdd($data) {
	
		$insert = $this->db->insert('shop', array(
			'item' => $data['item_name'],
			'shortdesc' => $data['short_description'],
			'description' => $data['full_description'],
			'clothing' => $data['is_clothing'],
			'size' => $data['item_size'],
			'keywords' => $data['item_keywords'],
			'itemid' => $data['item_code'],
			'price' => $data['item_price'],
			'stock' => $data['item_stock'],
			'image' => $data['item_image'],
			'alternate' => $data['alternate']
		));

		return ($insert) ? true : false;
	}
	
	public function shopEdit($data) {
	
		$postData = array(
            'item' => $data['item_name'],
			'shortdesc' => $data['short_description'],
			'description' => $data['full_description'],
			'clothing' => $data['is_clothing'],
			'size' => $data['item_size'],
			'keywords' => $data['item_keywords'],
			'itemid' => $data['item_code'],
			'price' => $data['item_price'],
			'stock' => $data['item_stock'],
			'image' => $data['item_image'],
			'alternate' => $data['alternate']
        );
        
        return $this->db->update('shop', $postData, "`prodid` = {$data['prodid']}");
	}
	
	public function shopDelete($id) {
	
		return $this->db->delete('shop', "`itemid` IN (".implode(',',$id).")");
	}
	
	public function shopDisable($id) {
	
		return array('result' => $this->db->updateCase('shop', 'active', "`id` IN (".implode(',',$id).")"), 'action' => 'archived');
	}
}