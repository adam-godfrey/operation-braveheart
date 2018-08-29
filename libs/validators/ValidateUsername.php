<?php
    // Include the Validator class to extend
    require_once 'Validator.php';
		
    class ValidateUsername extends Validator {
        public function ValidateUsername($username) {
			//  Create an array of errors
            $this->errors = array();
			// Validate the passwords
            $this->validate($username);
        } 

		public function validate() {
					
			$args = func_get_args();
			
			$user = $args[0];

			/* Create a new PDO object with database connection parameters */
			$dbh = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME.'', DB_USER, DB_PASS);

			// Create statement object
			$stmt = $dbh->prepare("SELECT username FROM users WHERE username = :username");
			
			$stmt->bindValue(":username", $user);
			 
			$stmt->execute();
			
			if($stmt->rowCount() != 0) {
				$this->setError('<span class="bold">Username</span> you have selected has already been used by another member in our database. Please choose a different Username!');
			}
			else {
				// If any of the username is empty add an error message to the array
				if(empty($user)) {
					$this->setError('<span class="bold">Username</span> field empty');
				}
				// Match the username against the regex.  If it fails add error message to the array
				elseif (!preg_match('/^[a-zA-Z0-9_ ]+$/', $user)) {
					$this->setError('<span class="bold">Username</span> contains invalid characters');
				}
				// if the length of the username is less than 6, add error message to array
				elseif (strlen($user) < 6) {
					$this->setError('<span class="bold">Username</span> is too short');
				}
				// if the length of the username is greater than 30, add error message to array
				elseif (strlen($user) > 30) {
					$this->setError('<span class="bold">Username</span> is too long');
				}
			}
		}
    }
?>