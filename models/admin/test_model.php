<?php

class Test_Model extends Model {

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
					FROM news WHERE archived = 0
					UNION ALL
					SELECT COUNT(*) AS counted
					FROM news WHERE archived = 1) AS counts";
		
		return (int) $this->db->count($sql);
	}
	
	public function newsIndex($entries_per_page, $pageno = '') {
		
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
		
			$sql="(SELECT id, title, postdate, archived FROM news WHERE archived = 0 ORDER by postdate DESC LIMIT $offset, $entries_per_page) UNION (SELECT id, title, postdate, archived FROM news WHERE archived = 1 ORDER by postdate DESC LIMIT $offset, $entries_per_page)";
			
			$rows = $this->db->clean($sql);
			
			foreach($rows as $key => $row) {
				$rows[$key]['postdate'] = date("d M Y", strtotime($row['postdate']));
			}

			return array('rows' => $rows, 'total_pages' => $this->total_pages, 'page' => $page);
		}	
	}
	
	public function newsContent($id) {
	
		$sql = 'SELECT id, title, content, author, photo, alternate, keywords FROM news WHERE id = :id LIMIT 1';
		
		$rows = $this->db->selectCache('adminNewsContent', $sql, array(':id' => $id));
		
		$news = array();
		
		foreach($rows as $array) {
			foreach($array as $key => $value) {
				$news[$key] = $value;
			}	
		}
		
		return array('rows' => $news);
	}
	
	public function newsAdd($data) {
	
		$insert = $this->db->insert('news', array(
			'title' => $data['title'],
			'content' => $data['content'],
			'photo' => $data['photo'],
			'keywords' => $data['keywords'],
			'alternate' => $data['alternate'],
			'postdate' => $data['postdate'],
			'author' => $data['author']
        ));
		
		return ($insert) ? true: false;
	}
	
	public function newsEdit($data) {
	
		$postData = array(
            'title' => $data['title'],
			'content' => $data['content'],
			'photo' => $data['photo'],
			'keywords' => $data['keywords'],
			'alternate' => $data['alternate']
        );
        
        return $this->db->update('news', $postData, "`id` = {$data['id']}");
	}
	
	public function newsDelete($id) {
	
		return $this->db->delete('news', "`id` IN (".implode(',',$id).")");
	}
	
	public function newsArchive($id) {
	
		$postData = array(
            'archived' => 'Y'
        );
        
        return $this->db->update('news', $postData, "`id` IN (".implode(',',$id).")");
	}
}