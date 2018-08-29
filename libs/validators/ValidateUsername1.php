<?php
    // Include the Validator class to extend
    require_once 'Validator.php';
		
    class ValidateUsername extends Validator {
        function ValidateUsername($username)
        {
	    //  Create an array of errors
            $this->errors = array();
  	    // Validate the passwords
            $this->validate($username);
        } 

	function validate($user)
	{
	    // If any of the username is empty add an error message to the array
	    if(empty($user)) {
		$this->setError('Username field empty');
	    }
	    // Connect to the database to see if the username is not the same as the session username
	    // and not taken by another user.  If it has, add error message to array
	    else if( mysql_num_rows(mysql_query("SELECT username FROM users WHERE username = '$user' && username != '".$_SESSION['username']."'")) ) {
		$this->setError('Username you have selected has already been used by another member in our database. Please choose a different Username!');
	    }
	    else {
		// Match the username against the regex.  If it fails add error message to the array
		if (!preg_match('/^[a-zA-Z0-9_ ]+$/', $user)) {
		    $this->setError('Username contains invalid characters');
		}
		// if the length of the username is less than 6, add error message to array
		if (strlen($user) < 6) {
		    $this->setError('Username is too short');
		}
	  	// if the length of the username is greater than 30, add error message to array
		if (strlen($user) > 30) {
		    $this->setError('Username is too long');
		}
	    }
	}
    }
?>