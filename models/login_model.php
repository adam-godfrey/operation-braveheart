<?php

class Login_Model extends Model {

    public function __construct() {
	
        parent::__construct();
    }
	
	public function login($data) {
	
		//Select users row from database base on $email
		$sql = 'SELECT * FROM users WHERE username = :userfield OR email = :userfield LIMIT 1';

		$selection = $this->db->select($sql, array(':userfield' => $data['username']));

		//Salt and hash password for checking
		$password = $selection[0]['user_salt'] . $data['password'];
		$password = $this->hashData($password);
		//Check email and password hash match database row
		$match = ($password != $selection[0]['password'] ? false : true);

		//Convert to boolean
		$is_active = (boolean) $selection[0]['is_active'];
		$verified = (boolean) $selection[0]['is_verified'];
		
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
					Session::init();
					Session::set('user_id', $selection[0]['userid']);
					Session::set('username', $selection[0]['username']);
					Session::set('token', $token);
					Session::set('loggedIn', true);
					Session::set('admin', $selection[0]['is_admin']);
					
					$postData = array(
						'session_id' => session_id(),
						'token' => $token
					);
					
					$updated = $this->db->update('logged_in_member', $postData, "`user_id` = {$selection[0]['userid']}");
					
					//Logged in
					if($updated != false) {
						return array('bool' => true, 'result' => 0);
					} 
					//Error occured
					return array('bool' => false, 'result' => 1);
				}
				else {
					//Not verified
					return array('bool' => false, 'result' => 2);
				}
			}
			else {
				//Not active
				return array('bool' => false, 'result' => 3);
			}
		}	
		//No match, reject
		return array('bool' => false, 'result' => 4);
	}
}