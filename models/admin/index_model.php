<?php

class Index_Model extends Model {

    public function __construct()
    {
        parent::__construct();
    }
	
	public function getComments() {
	
		$sql = "SELECT COUNT(*) FROM comments WHERE status = :status";
		
		return (int) $this->db->count($sql, array(':status' => 0));
	}
	
	public function getReviews() {
	
		$sql = "SELECT COUNT(*) FROM reviews WHERE status = :status";
		
		return (int) $this->db->count($sql, array(':status' => 0));
	}
	
	public function getEmails() {
	
		$sql = "SELECT COUNT(*) FROM email WHERE opened = :opened";
		
		return (int) $this->db->count($sql, array(':opened' => 0));
	}
	
	public function getFlaggedPosts() {
	
		$sql = "SELECT COUNT(*) FROM flagged ";
		
		return (int) $this->db->count($sql);
	}
}