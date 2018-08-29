<?php

class Forum_Flagged_Posts_Model extends Model {

	private $getcount = NULL;
	private $total_pages = NULL;
	private $words = NULL;
	private $braveheart = NULL;
	
    public function __construct() {
	
        parent::__construct();
		
		$this->words = new Words();
		$this->braveheart = new Braveheart();
		
		$this->getcount;
		$this->total_pages;
    }	
	
	public function getRowCount() {
	
		$sql = "SELECT COUNT(*) FROM flagged";
		
		return (int) $this->db->clean($sql);
	}
	
	public function flaggedPostsIndex($entries_per_page, $pageno = '') {
		
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
		
			$sql = "SELECT  f.messageid, 
							b.boardid, 
							m.messageid, 
							m.author, 
							m.message, 
							DATE_FORMAT( m.postdate, '%M %d, %Y, %r' ) AS postdate, 
							t.topicid, 
							t.topicname AS topic, 
							b.boardname
						FROM flagged f
						INNER JOIN messages m ON f.messageid = m.messageid
						INNER JOIN topics t ON m.topicid = t.topicid
						INNER JOIN boards b ON t.boardid = b.boardid LIMIT $offset,$entries_per_page";

			$rows = $this->db->clean($sql);
		
			return array('rows' => $rows, 'total_pages' => $this->total_pages, 'page' => $page);
		}		
    }
	
	public function flaggedPostsContent($id) {
	
		$sql = "SELECT  f.messageid,
						m.messageid, 
						m.author,
						m.message, 
						DATE_FORMAT(m.postdate, '%M %d, %Y, %r') as postdate, 
						t.topicid, 
						t.topicname,
						b.boardid, 
						b.boardname
					FROM flagged f
						INNER JOIN messages m ON f.messageid = m.messageid
						INNER JOIN topics t ON m.topicid = t.topicid
						INNER JOIN boards b ON t.boardid = b.boardid
					WHERE f.messageid = :flagged LIMIT 1";
		
		$rows = $this->db->select($sql, array(':flagged' => $id));	
		
		return array('rows' => $flagged);
	}
	
	public function flaggedPostsApprove($id) {
	
		$postData = array(
            'status' => 1
        );
        
        $this->db->update('comments', $postData, "`commentid` = {$id}");
	}
	
	public function flaggedPostsDelete($ids) {
	
		// SQL query to get all the flagged messages
		$sql = "SELECT  m.messageid, 
						m.topicid, 
						m.parent,
						f.id
					FROM messages m
					LEFT JOIN flagged f
						ON m.messageid=f.messageid
				WHERE m.messageid IN (".implode(',',$ids).")";
				
		// execute the query
		$rows = $this->db->clean($sql);
		
		// create an array for topic messages and replies
		$child = array();
		$parent = array();
		$blah = array();

		// loop through each of the flagged messages
		foreach($rows as $key => $row) {
			$blah[] = $row['id'];
			// if the message is a reply
			if($row['parent'] == 0) {
				// add it to the child array
				$child[] = $row['messageid'];
			}
			else {
				// otherwise it's a topic message
				$parent[] = $row['topicid'];
			}
		}
		
		try {
			// check to see if there are replies to delete
			if(!empty($child)) {
				// delete the flagged replies
				$this->db->delete('messages', "`messageid` IN (".implode(',',$child).")");
			}
			// check to see if there are topics to delete
			if(!empty($parent)) {
				// delete the whole topic
				$this->db->delete('topics', "`topicid` IN (".implode(',',$parent).")");
			}
			
			try {
				// delete the flagged replies
				$this->db->delete('flagged', "`id` IN (".implode(',',$blah).")");
			}
			catch(PDOException $e) {
				// write the error to the log
				$errmsg = $e->getMessage();
				error_log('$errmsg-> '.$errmsg);
			}
		}
		catch(PDOException $e) {
			// write the error to the log
			$errmsg = $e->getMessage();
			error_log('$errmsg-> '.$errmsg);
		}
	}
}