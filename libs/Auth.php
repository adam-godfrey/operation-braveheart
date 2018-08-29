<?php

// Include database class
//include 'database.class.php';

class Auth {
	private $_siteKey;
	private $db;

	public function __construct(Database $db)
  	{
		$this->db = $db;
		
		$this->siteKey = '0p3R@t10nBr@v3H3@rt';
	}
	
	private function randomString($length = 50)
	{
		$characters = '0123456789abcdefghijklmnopqrstuvwxyz';
		$string = '';    
			
		for ($p = 0; $p < $length; $p++) {
			$string .= $characters[mt_rand(0, (strlen($characters))-1)];
		}
			
			return $string;
	}
	
	protected function hashData($data)
    {
		return hash_hmac('sha512', $data, $this->_siteKey);
	}

	public function isAdmin()
	{		
		//$selection being the array of the row returned from the database.
		if($selection['is_admin'] == 1) {
			return true;
		}
			
		return false;
	}
	
	public function createUser($username, $email, $password, $is_verified = 0, $is_active = 0, $is_admin = 0)
	{			
		//Generate users salt
		$user_salt = $this->randomString();
				
		//Salt and Hash the password
		$password = $user_salt . $password;
		$password = $this->hashData($password);
				
		//Create verification code
		$code = $this->randomString();

		//Commit values to database here.
		$this->db->query('INSERT INTO users (username, email, password, user_salt, is_verified, is_active, is_admin, verification_code) VALUES (:username, :email, :password, :user_salt, :is_verified, :is_active, :is_admin, :verification_code)');

		$this->db->bind(':username', $username);
		$this->db->bind(':email', $email);
		$this->db->bind(':password', $password);
		$this->db->bind(':user_salt', $user_salt);
		$this->db->bind(':is_verified', $is_verified);
		$this->db->bind(':is_active', $is_active);
		$this->db->bind(':is_admin', $is_admin);
		$this->db->bind(':verification_code', $code);
		
		$created = $this->db->execute();
		
		if($created != false){
			return true;
		}
				
		return false;
	}
	
	public function login($userfield, $password)
	{
		//Select users row from database base on $email
		$this->db->query('SELECT * FROM users WHERE username = :userfield OR email = :userfield LIMIT 1');
		
		$this->db->bind(':userfield', $userfield);
		
		$selection = $this->db->single();		
			
		//Salt and hash password for checking
		$password = $selection['user_salt'] . $password;
		$password = $this->hashData($password);
			
		//Check email and password hash match database row
		$match = ($password != $selection['password'] ? false : true);
			
		//Convert to boolean
		$is_active = (boolean) $selection['is_active'];
		$verified = (boolean) $selection['is_verified'];
			
		if($match == true) {
			if($is_active == true) {
				if($verified == true) {
					//Email/Password combination exists, set sessions
					//First, generate a random string.
					$random = $this->randomString();
					//Build the token
					$token = $_SERVER['HTTP_USER_AGENT'] . $random;
					$token = $this->hashData($token);
						
					//Setup sessions vars
					session_start();
					$_SESSION['token'] = $token;
					$_SESSION['user_id'] = $selection['id'];
						
					$this->db->query('UPDATE logged_in_member SET session_id= :session_id, token = :token WHERE user_id= :user_id LIMIT 1');
					
					$this->db->bind(':session_id', session_id());
					$this->db->bind(':token', $token);
					$this->db->bind(':user_id', $selection['id']);
					
					$updated  = $this->db->execute();
					
					//Logged in
					if($updated != false) {
						return 0;
					} 
					//Error occured
					return 3;
				} else {
					//Not verified
					return 1;
				}
			} else {
				//Not active
				return 2;
			}
		}
			
		//No match, reject
		return 4;
	}

	public function checkSession()
	{
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