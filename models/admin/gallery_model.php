<?php

class Gallery_Model extends Model {

	private $getcount = NULL;
	private $total_pages = NULL;
	
    public function __construct() {
	
        parent::__construct();
		
		$this->getcount;
		$this->total_pages;
    }	
	
	public function getRowCount() {
	
		$sql = "SELECT COUNT(*) FROM gallery";
		
		return (int) $this->db->count($sql);
	}
	
	public function galleryIndex($entries_per_page, $pageno = '') {
		
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
		
			$sql="SELECT id,image, alternate, category FROM image ORDER BY image, category ASC LIMIT $offset,$entries_per_page";
			
			$rows = $this->db->cleanCache('adminGalleryIndex', $sql);

			return array('rows' => $rows, 'total_pages' => $this->total_pages, 'page' => $page);
		}		
    }
	
	public function galleryContent($id) {
	
		$sql = 'SELECT id, title, content, author, photo, alternate, keywords FROM news WHERE id = :id LIMIT 1';
		
		$rows = $this->db->selectCache('adminGalleryContent', $sql, array(':id' => $id));
		
		return array('rows' => $rows);
	}
	
	public function newsAdd($data) {
	
		$this->db->insert('news', array(
            'image' => $data['title'],
            'alternate' =>$data['alternate'],
            'description' => $data['description'],
			'category' =>$data['gallery_name']
        ));
	}
	
	public function galleryEdit($data) {
	
		$postData = array(
            'alternate' =>$data['content'],
            'description' => $data['author'],
			'category' =>$data['photo']
        );
        
        $this->db->update('gallery', $postData, "`id` = {$data['id']}");
	}
	
	public function galleryDelete($ids) {
	
		// find out how many records there are to update
		foreach($ids as $id) {
		
			$this->db->delete('gallery', "id = '$id'");
		}
	}
}