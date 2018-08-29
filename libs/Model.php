<?php

class Model {

	private $_siteKey;
	
    function __construct() {
        $this->db = new Database(DB_TYPE, DB_HOST, DB_NAME, DB_USER, DB_PASS);
		
		$this->_siteKey = '0p3R@t10nBr@v3H3@rt';
    }
	
	public function debug($arg) {
		echo "<pre>"; var_dump($arg); echo "</pre>";
	}
	
	public function setScripts($scripts) {

		$scriptsarray = array();
		
		foreach($scripts as $script) {
			array_push($scriptsarray, $script);
		}
		
		return $scriptsarray;
	}
	
	/**
    * Displays the pagination
    * @access public
    * @param int $total_pages
	* @param int $page
    */
	public function paging($total_pages, $page, $webpage, $type) {
	
		// display the pagination
		$paging = new Pagination($total_pages, $page, $webpage, $type);
		
		return $paging->pagination_one();
	}
	
	protected function randomString($length = 50) {
	
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$string = '';    
			
		for ($p = 0; $p < $length; $p++) {
			$string .= $characters[mt_rand(0, (strlen($characters))-1)];
		}
			
		return $string;
	}
	
	protected function hashData($data) {
	
		return hash_hmac('sha512', $data, $this->_siteKey);
	}
	
	public function breadcrumbs($crumbs) {

		$last = count($crumbs) - 1;
		$breadcrumbs = '<ol class="breadcrumb">';

		foreach ($crumbs as $i => $row) {
			$isFirst = ($i == 0);
			$isLast = ($i == $last);
			
			$breadcrumbs .= (!$isLast) ? '<li><a href="'. $row['url'] . '">' . ucwords(strtolower($row['name'])) . '</a></li>' : '<li class="active">' . ucwords(strtolower($row['name'])) . '</li>';
		}
		$breadcrumbs .= '</ol>';

		return $breadcrumbs;
	}
	
	public function visitorTracker() {
	
		$url = isset($_GET['url']) ? $_GET['url'] : null;
        $url = rtrim($url, '/');
        $url = filter_var($url, FILTER_SANITIZE_URL);
        $_url = explode('/', $url);
			
		if (!in_array("admin", $_url)) {
				
			//get the current page being viewed now
			$sql = "SELECT * FROM analytics WHERE DATE(insertdate) = DATE(NOW()) AND pagename = :pagename";
			//execute the query
			$rows = $this->db->select($sql, array(':pagename' => $_SERVER["QUERY_STRING"]));
			
			$sth = $this->db->prepare("INSERT INTO analytics (pagename, insertdate, counter) VALUES(:pagename, :insertdate, :counter) ON DUPLICATE KEY UPDATE counter = counter + 1");
			
			$sth->bindValue(":pagename", $_SERVER["QUERY_STRING"]);
			$sth->bindValue(":insertdate", date('Y-m-d'));
			$sth->bindValue(":counter", 1);

			$sth->execute();
		}
	}
	
	public function verifyFormToken($data)
	{
		// check if a session is started and a token is transmitted, if not return an error
		if (!Session::get($data['session'])) { 
			return false;
		}
		
		// check if the form is sent with token in it
		if(!isset($data['token'])) {
			return false;
		}
		
		// compare the tokens against each other if they are still the same
		if (Session::get('Br3@veH3@rt_token') !== $data['token']) {
			return false;
		}
		
		return true;
	}
    
    public function generateFormToken($form)
	{
        // generate a token from an unique value, took from microtime, you can also use salt-values, other crypting methods...
    	$token = md5(uniqid(microtime(), true));  
    	
    	// Write the generated token to the session variable to check it against the hidden field when the form is sent
    	Session::set($form.'_token', $token); 

    	return $token;
    }
	
	protected function sendMail($data) {

		// Create the SMTP configuration
		$transport = Swift_SmtpTransport::newInstance('smtp.gmail.com', 465, 'ssl');
		$transport->setUsername("adrock952@gmail.com");
		$transport->setPassword("13C0ldH@rb0ur");

		// Create an instance of the plugin and register it
		$mailer = Swift_Mailer::newInstance($transport);

		// Create the message
		$message = Swift_Message::newInstance();
		$message->setSubject($data['subject']);
		// HTML version of email
		$message->setBody($data['body'],'text/html');
		// Plain text version of email
		$message->addPart($data['part'], 'text/plain');

		$message->setFrom($data['from_email'], $data['from_name']);

		$message->setTo($data['to_email'], $data['to_name']);

		return ($mailer->send($message)) ? true : false;
	}
}