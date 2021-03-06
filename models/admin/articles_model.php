<?php

class Articles_Model extends Model {

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
					FROM articles WHERE archived = 0
					UNION ALL
					SELECT COUNT(*) AS counted
					FROM articles WHERE archived = 1) AS counts";
		
		return (int) $this->db->count($sql);
	}
	
	public function articleIndex($entries_per_page, $pageno = '') {
		
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
		
			$sql="(SELECT id, title, postdate, archived FROM articles WHERE archived = 0 ORDER by postdate DESC LIMIT $offset, $entries_per_page) UNION (SELECT id, title, postdate, archived FROM articles WHERE archived = 1 ORDER by postdate DESC LIMIT $offset, $entries_per_page)";
			
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
	
	public function articleContent($id) {
	
		$sql = 'SELECT id, title, content, author, image, alternate, keywords FROM articles WHERE id = :id LIMIT 1';
		
		$rows = $this->db->select($sql, array(':id' => $id));
		
		$articles = array();
		
		foreach($rows as $array) {
			foreach($array as $key => $value) {
				$articles[$key] = $value;
			}	
		}
		
		return array('rows' => $articles);
	}
	
	public function articleAdd($data) {
	
		$insert = $this->db->insert('articles', array(
			'title' => $data['title'],
			'content' => $data['content'],
			'image' => $data['image'],
			'keywords' => $data['keywords'],
			'alternate' => $data['alternate'],
			'postdate' => $data['postdate'],
			'author' => $data['author']
        ));
		
		return ($insert) ? true: false;
	}
	
	public function articleEdit($data) {
	
		$postData = array(
            'title' => $data['title'],
			'content' => $data['content'],
			'image' => $data['image'],
			'keywords' => $data['keywords'],
			'alternate' => $data['alternate']
        );
        
        return $this->db->update('articles', $postData, "`id` = {$data['id']}");
	}
	
	public function articleDelete($id) {
	
		return array('result' => $this->db->delete('articles', "`id` IN (".implode(',',$id).")"), 'action' => 'deleted');
	}
	
	public function articleArchive($id) {
	
		return array('result' => $this->db->updateCase('articles', 'archived', "`id` IN (".implode(',',$id).")"), 'action' => 'archived');
	}
}