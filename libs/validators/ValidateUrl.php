<?php
    require_once 'Validator.php';
 
    class ValidateUrl extends Validator {
        public function ValidateAddress ($url, $field) {
			//  Create an array of errors
            $this->errors = array();
			// Validate the text for that field
            $this->validate($url, $field);
        }  
  
		public function validate() {
			
			$args = func_get_args();
			
			$url = $args[0];
			$field = $args[1];

			// If any of the text fields are empty add an error message to the array
			if (!preg_match('/^(http|https|ftp)\://([a-zA-Z0-9\.\-]+(\:[a-zA-Z0-9\.&amp;%\$\-]+)*@)*((25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[1-9])\.(25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[1-9]|0)\.(25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[1-9]|0)\.(25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[0-9])|localhost|([a-zA-Z0-9\-]+\.)*[a-zA-Z0-9\-]+\.(com|edu|gov|int|mil|net|org|biz|arpa|info|name|pro|aero|coop|museum|[a-zA-Z]{2}))(\:[0-9]+)*(/($|[a-zA-Z0-9\.\,\?\'\\\+&amp;%\$#\=~_\-]+))*$/', $address)) {
				$this->setError($field.' contains invalid characters');
			}
		}    
    }
?>