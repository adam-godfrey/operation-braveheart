<?php
    // Include the Validator class to extend
    require_once 'Validator.php';
	
    class ValidatePasswords extends Validator {
        public function ValidatePasswords ($passwords) {
			//  Create an array of errors
            $this->errors = array();
			// Validate the passwords
            $this->validate($passwords);
        } 

		public function validate() {
		
			$args = func_get_args();
			
			$passwords = $args[0];

			// The 2 passwords are in an array.  Split the array into 2
			$pass = $passwords[0];
			$confpass = $passwords[1];

			// If any of the password fields are empty add an error message to the array
			if(empty($pass) || empty($confpass)) {
				$this->setError('Password field is empty');
			}
			// If thepasswords aren't the same, add error message to array
			else if ($pass != $confpass) {
				$this->setError('Passwords do not match');
			}
			// Validate the password against the regex.  If it fails add error message to array
			else if (!preg_match('/^[a-zA-Z0-9_]+$/', $pass)) {
				$this->setError('Password contains invalid characters');
			}
			// if the length of the password is less than 6, add error message to array
			else if (strlen($pass) < 6) {
				$this->setError('Password is too short');
			}
			// if the length of the password greater than 30, add error message to array
			else if (strlen($pass) > 30) {
				$this->setError('Password is too long');
			}
		}
    }
?>