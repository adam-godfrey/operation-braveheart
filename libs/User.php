<?php

// Include database class
//include 'database.class.php';

class Auth {
	private $_siteKey;
	private $db;

	public function __construct(Database $db) {
		$this->db = $db;
		
		$this->siteKey = '0p3R@t10nBr@v3H3@rt';
	}
	
	

	public function checkSession() {
	
		session_start();
		
		//Select the row
		$this->db->query('SELECT * FROM logged_in_member WHERE user_id = :user_id LIMIT 1');
		
		$this->db->bind(':user_id', $_SESSION['user_id']);

		$selection = $this->single();
		
		if($selection) {
			//Check ID and Token
			if(session_id() == $selection['session_id'] && $_SESSION['token'] == $selection['token']) {
			
				$this->db->query('UPDATE logged_in_member SET time= :time, status=1 WHERE user_id = :user_id');
				
				$this->db->bind(':user_id', $_SESSION['user_id']);
				$this->db->bind(':time', time());
				
				$this->db->execute();
				
				//if time now - start time > 300 then its been 5 minutes, so we delete
				
				$this->db->query('UPDATE logged_in_member SET time = :time, status = 0 WHERE ((:time - time) > 900)');
				
				$this->db->bind(':time', '');

				$this->db->execute();

				//Id and token match, refresh the session for the next request
				$this->refreshSession();
				
				return true;
			}
		}
			
		return false;
	}

	private function refreshSession()
	{
		//Regenerate id
		session_regenerate_id();
			
		//Regenerate token
		$random = $this->randomString();
		//Build the token
		$token = $_SERVER['HTTP_USER_AGENT'] . $random;
		$token = $this->hashData($token); 
			
		//Store in session
		$_SESSION['token'] = $token;
		
		$this->db->query('UPDATE logged_in_member SET session_id= :session_id, token = :token WHERE user_id= :user_id LIMIT 1');
					
		$this->db->bind(':session_id', session_id());
		$this->db->bind(':token', $token);
		$this->db->bind(':user_id', $_SESSION['user_id']);
		
		$this->db->execute();
	}
	
	public function logout($user_id)
	{
		session_start();
		//Select users row from database base on session
		$this->db->query('UPDATE logged_in_member SET session_id = :session_id, token = :token, time = :time, status = :status WHERE user_id = :user_id');
		
		$this->db->bind(':session_id', '');
		$this->db->bind(':token', '');
		$this->db->bind(':time', 0);
		$this->db->bind(':status', 0);
		$this->db->bind(':user_id', $_SESSION['user_id']);
		
		if($this->db->execute()) {
			//destroy the session
			session_destroy();
			return true;
		}
		else {
			return false;
		}	
	}
}
?>