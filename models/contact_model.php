<?php

class Contact_Model extends Model {

	private $key;
	
    public function __construct()
    {
        parent::__construct();
    }

    public function getRealIp()
	{
		if (!empty($_SERVER['HTTP_CLIENT_IP']))
		{ 
			//check ip from share internet
			$ip = $_SERVER['HTTP_CLIENT_IP'];
		}
		elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
		{  
			//to check ip is pass from proxy
			$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		}
		else {
			$ip = $_SERVER['REMOTE_ADDR'];
		}
		
		return $ip;
    }

    public function writeLog($where)
	{
    	$ip = $this->getRealIp(); // Get the IP from superglobal
    	$host = gethostbyaddr($ip);    // Try to locate the host of the attack
    	$date = date("d M Y");
    	
    	// create a logging message with php heredoc syntax
    	$logging = <<<LOG
    		\n
    		<< Start of Message >>
    		There was a hacking attempt on your form. \n 
    		Date of Attack: {$date}
    		IP-Adress: {$ip} \n
    		Host of Attacker: {$host}
    		Point of Attack: {$where}
    		<< End of Message >>
LOG;
// Awkward but LOG must be flush left
    
            // open log file
    		if($handle = fopen('hacklog.log', 'a')) {
    		
    			fputs($handle, $logging);  // write the Data to file
    			fclose($handle);           // close the file
    			
    		} 
			else
			{  
				// if first method is not working, for example because of wrong file permissions, email the data
    			$to = 'adrock952@gmail.com';  
            	$subject = 'HACK ATTEMPT';
            	$header = 'From: adrock952@gmail.com';
				
            	if (mail($to, $subject, $logging, $header))
				{
            		return "Sent notice to admin.";
            	}
    
    		}
    }
    
	public function submit($data)
	{
		// VERIFY LEGITIMACY OF TOKEN
		if ($this->verifyFormToken($data)) {
		
			// CHECK TO SEE IF THIS IS A MAIL POST
			if (isset($data['message'])) {
				// remove the session name so won't inteferre with whitelist array
				unset($data['session']);
			
				// Building a whitelist array with keys which will send through the form, no others would be accepted later on
				$whitelist = array('token', 'session', 'name', 'email', 'website', 'subject', 'message');
				
				// Building an array with the $_POST-superglobal 
				foreach ($data as $key => $item) {
						
					// Check if the value $key (fieldname from $_POST) can be found in the whitelisting array, if not, die with a short message to the hacker
					if (!in_array($key, $whitelist)) {
						
						$this->writeLog('Unknown form fields');
						return "Hack-Attempt detected. Please use only the fields in the form";
					}
				}
				
				
				$emailContent = array();

				$emailcontent['to_name'] = 'David Godfrey';
				//$emailcontent['to_email'] = 'david-operationbraveheart@talktalk.net';
				$emailcontent['to_email'] = 'adrock952@gmail.com';
				$emailcontent['subject'] = 'Website Message via Contact Form';
				
				foreach($data as $key => $value) {
					$emailcontent['from_name'] = $data['name'];
					$emailcontent['from_email'] = $data['email'];
					$emailcontent['body'] = $data['message'];
					$emailcontent['part'] = $data['message'];
				}
				
				if($this->sendMail($emailcontent)) {
				
					// save form data into database
					$this->db->insert('email', array(
						'name' => $data['name'],
						'email' => $data['email'], 
						'subject' => $data['email'],
						'body' => $data['message'],
						'date_rec' => date('Y-m-d')
					));
					
					// DON'T BOTHER CONTINUING TO THE HTML...*/
					return true;
				}
				else {
					return false;
				}
			}
		} else {
			echo'no';
			exit;
			if (Session::get($data['session']) === MY_SESSION_NOT_SET) {
				
				return Session::get($data['session']);
				
			} else {
			
				$this->writeLog('Formtoken');
				return "Hack-Attempt detected. Got ya!.";
			}
		}
	}
}