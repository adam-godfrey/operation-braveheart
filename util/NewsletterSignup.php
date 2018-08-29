<?php

require '../config.php';

try {
	// create a new instance of a PDO connection
    $db = new PDO(DB_TYPE.':host='.DB_HOST.';dbname='.DB_NAME, DB_USER, DB_PASS);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e) {
	// if the connection fails, display an error message
    echo 'ERROR: ' . $e->getMessage();
}

if(isset($_POST['signupemail']) && !empty($_POST['signupemail'])) {

	$signupname = $_POST['signupname'];
	$signupemail = $_POST['signupemail'];
	
	// Validate Address
    if(!preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*$/i", $signupemail)) {
	
		$message = "<strong>Error</strong>: An invalid email address was provided.";
    }
    else {
     
		$sql = 'SELECT * FROM mailinglist WHERE email = :email';
	
		$stmt = $db->prepare($sql);
		$stmt->bindValue(':email', $signupemail);
		$stmt->execute();
		$addresscheck = (int) count($stmt->fetchAll());
			
        if( $addresscheck != 0 ) { 
   
			$message = "Address already signed up";
		}
		else {

			try {
				// Insert email address into mailinglist table 
				$sql = 'INSERT INTO mailinglist (name, email) VALUES (:name, :email)';
		
				$stmt = $db->prepare($sql);
				$stmt->bindValue(':name', $signupname);
				$stmt->bindValue(':email', $signupemail);
				$stmt->execute();
				
				$message = "Thanks for signing up!";
			}
			catch(PDOException $e) {
				// if the connection fails, display an error message
				$message = "<strong>Error</strong>: There was an error storing your email address.";
			}
		}
    }
	
	echo $message;
}

?>