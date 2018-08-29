<?php

class Donate_Model extends Model {

    public function __construct() {
	
        parent::__construct();
    }
    
	public function getRowCount() {
		// create a SQL query to count how many comments in database
		$sql = "SELECT COUNT(*) FROM dc_comments";
		//return the count using either the new query or the cached file
		return (int) $this->db->countCache('donateGetrowCount', $sql);
	}
	
	public function getDonators($entries_per_page, $pageno = '') {
	
		// get the number of rows
		$this->getcount = $this->getRowCount();
		// get the pagenum.  If it doesn't exist, set it to 1
		if(!empty($pageno) ? $page = $pageno : $page = 1);
		// set the number of entries to appear on the page
		 
		// total pages is rounded up to nearest integer
		$this->total_pages = ceil($this->getcount/$entries_per_page); 
		// offset is used by SQL query in the LIMIT
		$offset = (($page * $entries_per_page) - $entries_per_page);
		
		// if we have some donation in database
		if($this->getcount != 0) {
			// create a SQL query to get the comments from donators
			$sql = 'SELECT * FROM dc_comments ORDER BY dt DESC';
			// query the database or get the cached file
			$rows = $this->db->cleanCache('getDonators'.$page, $sql);
			// return the comments, the number of pages and the current page and the number of rows
			return array('rows' => $rows, 'total_pages' => $this->total_pages, 'page' => $page, 'rowcount' => $this->getcount);
		}
		else {
			// same as above but returning 0 comments
			return array('rows' => 0, 'total_pages' => $this->total_pages, 'page' => $page, 'rowcount' => $this->getcount);
		}
	}   
	
	public function getDonations() {
		// query the database or cache file to get the sum of donations and extract it to variables
		extract($this->db->cleanCache('getDonations', 'SELECT COALESCE(SUM(amount), 0) as amount FROM dc_donations'));
		// calculate the percentage of donations compared to the goal/target
		$percent = (!empty($row[0]['amount'])) ? round(min(100*($row[0]['amount']/GOAL),100)) : round(min(100*(0/GOAL),100)) ;
		// create an array for the google chart
		$data = array( 
			array('Type', 'Percent'),
			array('Donations', $percent),  
			array('Goal', (100-$percent)),  
		);
		// reutn the array and the percentage to the controller
		return array('chartData' => $data, 'percent' => $percent);
	}
	
	public function postMessage($data) {
		// add the donators comment to the database along with their name, website (if applicable) and PayPal transaction id
		$this->db->insert('comments', array('transaction_id' => $data['txn_id'], 'name' => $data['nameField'], 'url' => $data['websiteField'], 'message' => $data['messageField']));
		// show the user they've been added to the donator's list
		return '<a href="'.URL.'donate">You were added to our donor list! &raquo;</a>';
	}
	
	public function insertDonation($ipn_data) {
	
		$this->db->insert('dc_donations', array('transaction' => $ipn_data['txn_id'], 'donor_email' => $ipn_data['payer_email'], 'amount' => (float)$ipn_data['amount']));
		
		return true;
		
		$emailContent = array();
				
		$emailcontent['to_name'] = 'David Godfrey';
		$emailcontent['to_email'] = 'david-operationbraveheart@talktalk.net';
		$emailcontent['from_name'] = 'Operation Braveheart';
		$emailcontent['from_email'] = 'notifications@operationbraveheart.org.uk';
		$emailcontent['subject'] = 'New comment on website';
		$emailcontent['body'] = '';
		$emailcontent['part'] = "Hi Dave! \r\n Some kind person has made a donation of $ipn_data['amount'] using the website. \r\n Many Thanks! \r\n The Operation Braveheart admin team. \r\n This is an automated response, please do not reply!";
		
		$this->sendMail($emailContent);
	}
}
