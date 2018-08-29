<?php
    // Include the Validator class to extend
    require_once 'Validator.php';
	
    class ValidateEmail extends Validator {
        public function ValidateEmail ($email) {
            //  Create an array of errors
            $this->errors = array();
            // Validate the email address
            $this->validate($email);
        } 

        // public function to validate an email address
    	public function validate() {
		
			$args = func_get_args();
			
			$email = $args[0];
			
			// If the email address is empty add an error message to the array
			if(empty($email)) {
			$this->setError('Email field is empty');
			}
			else {
				// Match the email against the regex.  If it fails add error message to the array
				if(!preg_match('/^[\w-]+(?:\.[\w-]+)*@(?:[\w-]+\.)+[a-zA-Z]{2,7}$/', $email)) {
					$this->setError('Email address in invalid format');
				}
			}
		}
    }
?>