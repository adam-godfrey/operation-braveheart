<?php

class Register_Model extends Model {

    public function __construct()
    {
        parent::__construct();
    }
	
	public function create($data) {
	
		//Generate users salt
		$user_salt = $this->randomString();
				
		//Salt and Hash the password
		$password = $user_salt . $data['password'];
		$password = $this->hashData($password);
				
		//Create verification code
		$code = $this->randomString();
		// start a transaction so if anything fails, roll all others back
		$this->db->beginTransaction();
		
		try {
			// insert into the users table, the form data from user
			$this->db->insert('users', array(
				'first_name' => $data['first_name'],
				'last_name' => $data['last_name'],
				'email' => $data['email'],
				'username' => $data['username'], 
				'password' => $password,
				'user_salt' => $user_salt,
				'interests' => $data['interests'],
				'signup_date' => date('Y-m-d H:i:s'), 
				'verification_code' => $code
			));
			
			try {
				// get the new userid for the user
				$insertID = $this->db->lastInsertId();
				// and insert it into the logged_in_member table
				$this->db->insert('logged_in_member', array('user_id' => $insertID, 'session_id' => '', 'token' => ''));
				// and also the misc table so all tables can be linked
				$this->db->insert('misc', array('userid' => $insertID, 'profpic' => '', 'avatar' => '', 'signature' => ''));
				
				// if the user signed up for the newsletter
				if($data['newsletter'] =='y') {

					try {
						// insert there name and email address into the mailinglist table
						$this->db->insert('mailinglist', array('name' => $data['first_name'], 'email' => $data['email']));
						
						// end the transactions as all data should have saved.  On failuire, rollback.
						$this->db->endTransaction();
						
						// send the user the activation email with the username and password
						return ($this->emailUser($data['first_name'], $data['email'], $data['username'], $data['password'], $insertID, $code)) ? 1 : 5;					
					}
					catch(PDOException $e) {
						// If this statement fails, rollback...
						$this->db->endTransaction();
						
						// this means account created but failed newsletter signup
						// send the user the activation email with the username and password
						return ($this->emailUser($data['first_name'], $data['email'], $data['username'], $data['password'], $insertID, $code)) ? 2 : 5;
					}	
				}
				else {
				
					// end the transactions as all data should have saved.  On failuire, rollback.
					$this->db->endTransaction();

					// this means account created without newsletter signup
					// send the user the activation email with the username and password
					return ($this->emailUser($data['first_name'], $data['email'], $data['username'], $data['password'], $insertID, $code)) ? 3 : 5;
				}
			}
			catch(PDOException $e) {
				// If this statement fails, rollback...
				$this->db->cancelTransaction();
				
				// write the error to the log
				$errmsg = $e->getMessage();
				error_log('$errmsg-> '.$errmsg);
				
				return 6;
			}	
		}
		catch(PDOException $e) {
			// If this statement fails, rollback...
			$this->db->cancelTransaction();
			
			// write the error to the log
			$errmsg = $e->getMessage();
			error_log('$errmsg-> '.$errmsg);
				
			return 4;
		}	
	}
	
	// function to activate a user account
	public function activate($data) {
        
		// update the database with the vars supplied from users activation link
        $this->db->update('user', array('activated' => 1), "`userid` = {$data['userid']} AND `passsword` = {$data['code']}");
		
		// prepare a statement to query the database to see if row has been updated
		$sql = 'SELECT count(*) FROM users WHERE userid = :userid AND password = :code AND activated = :activated';
		
		// check to see if the account has activated
		$result = (int) $this->db->count(false, $sql, array(
			':activated' => 1,
			':userid' => $data['userid'],
			':code' => $data['code']
		));
		
		// display a message showing if account has activated
		return ($result == 0) ? 'Your account could not be activated!  Please contact the webmaster' : 'Your account has been activated!';
	}
	
	private function emailUser($first_name, $email, $username, $password, $userid, $code) {
	
		$html = file_get_contents('http://localhost/app/libs/resources/email_templates/register.html');
		$text = file_get_contents('http://localhost/app/libs/resources/email_templates/register.txt');
		
		$replacements = array();
		
		// add data to replacements array
		$replacements[$email] = array (
			"{first_name}" => $first_name,
			"{username}" => $username,
			"{password}" => $password,
			"{userid}" => $userid,
			"{code}" => $code,
			"{email}" => $email
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
		$message->setSubject('Your membership at www.operationbraveheart.org.uk!');
		// HTML version of email
		$message->setBody($html,'text/html');
		// Plain text version of email
		$message->addPart($text, 'text/plain');

		$message->setFrom('admin@operationbraveheart.org.uk', 'Operation Braveheart');

		$message->setTo($email, $first_name);

		return ($mailer->send($message)) ? true : false;
	}
	
	public function newsletterSignUp($data) {
	
		try {
			
			$this->db->insert('mailinglist', array(
				'name' => $data['name'],
				'email' => $data['email']
			));
			
			return true;
			
		}
		catch(PDOException $e) {

			return false;
		}	
	}
}