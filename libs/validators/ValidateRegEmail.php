<?php
    // Include the Validator class to extend
    require_once 'Validator.php';
	$root = realpath($_SERVER["DOCUMENT_ROOT"]);

	require_once "$root/php/database/connection2.php";
	
    class ValidateRegEmail extends Validator {
        public function ValidateRegEmail ($email) {
			// Create an array of errors
            $this->errors = array();
			// Validate the email addresses
            $this->validate($email);
        } 

		public function validate() {
			global $host,$dbUser,$dbPass,$dbName;
			$args = func_get_args();
			
			$email = $args[0];
			
			// Set your variable	
			$username = $_SESSION['username'];
			
			/* Create a new mysqli object with database connection parameters */
			$db = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_DBNAME);

			// Create statement object
			$stmt = $db->stmt_init();
			
			// Create a prepared statement
			if($stmt->prepare("SELECT `email` FROM `users` WHERE `email` = ?  AND email NOT IN (SELECT email FROM users WHERE username = ?)")) {
			 
				// Bind your variable to replace the ?
				if(!$stmt->bind_param('ss', $email, $username)) {
					//if BIND fails, display an error
					printf("Errormessage: %s\n", $stmt->error);
				}
			 
				// Execute query
				if(!$stmt->execute()) {
					printf("Errormessage: %s\n", $stmt->error);
				}
				
				// store result of prepared statement
				$stmt->store_result();
				$numrows = $stmt->num_rows;
			 
				// Close statement object
				$stmt->close();
			}
			
			if($numrows != 0) {
				$this->setError('Email address you have supplied has already been used by another member in our database. Please choose a different email address!');
			}
			else {
				// The 2 email addresses are in an array.  Split the array into 2
							
				// If the email addresses are empty add an error message to the array
				if(empty($email)) {
					$this->setError('Email address field is empty');
				}
				else {
					// Validate emails against the regex.  If it fails add error message to array
					if (!preg_match('/^[\w-]+(?:\.[\w-]+)*@(?:[\w-]+\.)+[a-zA-Z]{2,7}$/', $email)) {
						$this->setError('Email in invalid format');
					}
				}
			}
		}
    }
?>