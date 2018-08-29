<?php

class Forgot_Password_Model extends Model {

    public function __construct() {
	
        parent::__construct();
    }
    
    public function request($email) {
    
		$sql = "SELECT first_name, last_name, username, email FROM users WHERE email= :email LIMIT 1";
		
		$rows = $this->db->select($sql, array(':email' => $email));
		
		//if the email exists in database
		if(count($rows) != 0) {
		
			//Generate users salt
			$user_salt = $this->randomString();
			// Generate a new random password 8 chars in length
			$temp_pass = $this->randomString(8);
					
			//Salt and Hash the password
			$password = $user_salt . $temp_pass;
			$random_password = $this->hashData($password);
					
			//Create verification code
			$code = $this->randomString();
			
			// update the database with the vars supplied from users activation link
			$this->db->update('users', array('password' => $random_password, 'user_salt' => $user_salt, 'verification_code' => $code), "`email` = $email LIMIT 1");
			
			$name = $rows[0]['first_name'] . " " . $rows[0]['last_name'];
			$username = $rows[0]['username'];
			
			//if the email send return 1 else return 2
			return ($this->sendEmail($name, $username, $email, $random_password)) ? 1 : 2;
		}
		// the email doesn't exist in database
		return 0;
    }
	
	public function sendEmail($name, $username, $email, $temp_pass) {
	
		$html = file_get_contents('forgot-password.html');
		$text = file_get_contents('forgot-password.txt');
		
		$replacements = array();
		
		// add data to replacements array
		$replacements[$email] = array (
			"{username}" => $username,
			"{temp_pass}" => $temp_pass
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
		$message->setSubject('Your password at Operation Braveheart');
		// HTML version of email
		$message->setBody($html,'text/html');
		// Plain text version of email
		$message->addPart($text, 'text/plain');

		$message->setFrom('no-reply@operationbraveheart.org.uk', 'Operation Braveheart');

		$message->setTo($email, $name);

		return ($mailer->send($message)) ? true : false;
	}
}