<?php

class Newsletters_Model extends Model {

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
					FROM newsletters WHERE sent = 0
					UNION ALL
					SELECT COUNT(*) AS counted
					FROM newsletters WHERE sent = 1) AS counts";
		
		return (int) $this->db->count($sql);
	}
	
	public function newslettersIndex($entries_per_page, $pageno = '') {
		
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
		
			$sql="(SELECT id, title, date_created, sent, date_sent FROM newsletters WHERE sent = 0 ORDER BY date_created LIMIT $offset, $entries_per_page) UNION (SELECT id, title, date_created, sent, date_sent FROM newsletters WHERE sent = 1 ORDER BY date_created LIMIT $offset, $entries_per_page)";

			$rows = $this->db->clean($sql);
			
			foreach($rows as $key => $row) {
				$rows[$key]['date_created'] = date("d M Y", strtotime($row['date_created']));
				$rows[$key]['date_sent'] = date("d M Y", strtotime($row['date_sent']));
			}

			return array('rows' => $rows, 'total_pages' => $this->total_pages, 'page' => $page, 'rowcount' => $this->getcount);
		}
		else {
			return array('rows' => 0, 'total_pages' => 0, 'page' => 0, 'rowcount' => 0);
		}		
    }
	
	public function newslettersContent($id) {
	
		$sql = 'SELECT id, title, intro, body FROM newsletters WHERE id = :id LIMIT 1';
		
		$rows = $this->db->select($sql, array(':id' => $id));
		
		$newsletter = array();
		
		foreach($rows as $row) {
			foreach($row as $key => $value) {
			
				if($key == 'body') {
					$json = json_decode($value);
					
					foreach($json as $key => $value) {
						$newsletter[$key] = $value;
					}
				}
				else {
					$newsletter[$key] = $value;
				}
			}	
		}

		return array('rows' => $newsletter);
	}
	
	public function newslettersAdd($data) {
	
		$insert = $this->db->insert('newsletters', array(
            'title' => $data['title'],
			'welcome' => $data['welcome'],
            'body' =>$data['body']
        ));
		
		return ($insert) ? true: false;
	}
	
	public function newslettersEdit($data) {
	
		$postData = array(
            'title' => $data['title'],
			'welcome' => $data['welcome'],
            'body' =>$data['body']
        );
        
        return $this->db->update('newsletters', $postData, "`id` = {$data['id']}");
	}
	
	public function newslettersDelete($ids) {
	
		return array('result' => $this->db->delete('newsletters', "`id` IN (".implode(',',$id).")"), 'action' => 'deleted');
	}
	
	public function newslettersSend($data) {
	
		$html = file_get_contents('newsletter.html');
		$text = file_get_contents('newsletter.txt');
		
		$replacements = array();
		
		// add data to replacements array
		$replacements[$email] = array (
			"{email}" => $first_name,
			"{name}" => $username,
			"{welcome}" => $password,
			"{userid}" => $userid,
			"{code}" => $code
		);
		
		// Create the SMTP configuration
		$transport = Swift_SmtpTransport::newInstance('smtp.gmail.com', 465, 'ssl');
		$transport->setUsername("adrock952@gmail.com");
		$transport->setPassword("13C0ldH@rb0ur");

		// Create an instance of the plugin and register it
		$mailer = Swift_Mailer::newInstance($transport);
		$mailer->registerPlugin(new Swift_Plugins_DecoratorPlugin($replacements));
		
		// Create the message
		$message = Swift_Message::newInstance();
		$message->setSubject($data['title']);
		// HTML version of email
		$message->setBody($html,'text/html');
		// Plain text version of email
		$message->addPart($text, 'text/plain');

		$message->setFrom('no-reply@operationbraveheart.org.uk', 'Operation Braveheart');

		$message->setTo($email, $first_name);

		return ($mailer->send($message)) ? true : false;
        
        return array('result' => $this->db->updateCase('newsletters', 'archived', "`id` IN (".implode(',',$id).")"), 'action' => 'sent');
	}
}