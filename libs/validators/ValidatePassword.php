<?php
    // Include the Validator class to extend
    require_once 'Validator.php';
	require_once("php/database/connection.php");
	require_once("php/database/MySQL.php");
	
    class ValidatePassword extends Validator {
        public function ValidatePassword ($currentpass) {
			//  Create an array of errors
            $this->errors = array();
			// Validate the password
            $this->validate($currentpass);
        } 

		public function validate() {
		
			$args = func_get_args();
			
			$currentpass = $args[0];
		
			global $host,$dbUser,$dbPass,$dbName;
			// Connect to the database and grab the email
			$db = & new MySQL($host,$dbUser,$dbPass,$dbName);
			
			// Try and get the salt from the database using the username
			$sql = "SELECT salt FROM users WHERE username='".$_SESSION['username']."' LIMIT 1";
			
			$result = $db->query($sql);
			
			while ($row = $result->fetch()) {
				$encrypted_pass = md5(md5($currentpass).$row['salt']);
			}
			
			$sql= "SELECT password FROM users WHERE password='$encrypted_pass' AND username='".$_SESSION['username']."'LIMIT 1";
			$result = $db->query($sql);
			$numrows = $result->size();
			
			while ($row = $result->fetch()) {
				// Assign the database values to vaariables
				$password = $row['password'];
			}
	
			if(empty($currentpass)) {
				$this->setError('Current Password field is empty');
			}
			else if ($numrows == 0){
				$this->setError('Wrong password entered');
			}
		}
	}
?>