<?php
    // Include the Validator class to extend
    require_once 'Validator.php';
	require_once ($_SERVER['DOCUMENT_ROOT'] . '/app/libs/php-captcha.inc.php');
	
    class ValidateCaptcha extends Validator {
        public function ValidateCaptcha ($captcha) {
            //  Create an array of errors
            $this->errors = array();
            // Validate the captcha
            $this->validate($captcha);
        } 

        // public function to validate the captcha
    	public function validate() {
		
			$args = func_get_args();
			
			$captcha = $args[0];

			// If the captcha is empty add an error message to the array
			if (empty($captcha)) {
				$this->setError('Anti-Spam key field is empty');
			}
			// Convert the captcha variable to uppercase and see if it matches the captcha session
			// If it fails add error message to the array
			else if (PhpCaptcha::Validate($captcha)) {
				$this->setError('Anti-SPAM key incorrect');
			}
		}
    }
?>