<?php

class Home_Page_Model extends Model {

    public function __construct() {
	
        parent::__construct();
    }	
		
	public function homeContent() {
	
		$sql = 'SELECT id, content FROM info WHERE id = 1';
		
		$rows = $this->db->clean($sql);
		
		return array('rows' => $rows);
	}
	
	public function homeEdit($data) {
	
		$postData = array(
            'content' =>$data['content']
        );
        
        return $this->db->update('info', $postData, "`id` = 1");
	}
}