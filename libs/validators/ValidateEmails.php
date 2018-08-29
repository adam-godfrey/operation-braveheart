<?php
    // Include the Validator class to extend
    require_once 'Validator.php';
	
    class ValidateEmails extends Validator {
        public function ValidateEmails ($emails) {
			// Create an array of errors
            $this->errors = array();
			// Validate the email addresses
            $this->validate($emails);
        } 

		public function validate() {
		
			$args = func_get_args();
			
			$emails = $args[0];

			$email = $emails[0];
			$confemail = $emails[1];
			
			/* Create a new PDO object with database connection parameters */
			$dbh = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME.'', DB_USER, DB_PASS);

			// Create statement object
			$stmt = $dbh->prepare("SELECT email FROM users WHERE email = :email");
			
			$stmt->bindValue(":email", $email);
			 
			$stmt->execute();
			
			if($stmt->fetchColumn() != 0) {
				$this->setError('<span class="bold">Email address</span> you have supplied has already been used by another member in our database. Please choose a different email address!');
			}
			else {
				// The 2 email addresses are in an array.  Split the array into 2
							
				// If the email addresses are empty add an error message to the array
				if(empty($email) || empty($confemail)) {
					$this->setError('<span class="bold">Email address</span> field is empty');
				}
				else {
					// Validate emails against the regex.  If it fails add error message to array
					if (!preg_match('/^[\w-]+(?:\.[\w-]+)*@(?:[\w-]+\.)+[a-zA-Z]{2,7}$/', $email)) {
						$this->setError('<span class="bold">Email address</span> in invalid format');
					}
					// If the emails aren't the same, add error message to array
					else if ($email != $confemail) {
						$this->setError('<span class="bold">Email address</span> do not match');
					}
				}
			}
		}
    }
?>