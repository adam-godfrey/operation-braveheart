<?php
    require_once 'Validator.php';
 
    class ValidateAddress extends Validator {
        public function ValidateAddress ($address, $field) {
			//  Create an array of errors
			$this->errors = array();
			// Validate the text for that field
            $this->validate($address, $field);
        }  
  
		public function validate() {
		
			$args = func_get_args();
			
			$address = $args[0];
			$field = $args[1];

			// If any of the text fields are empty add an error message to the array
			if(empty($address)) {
				$this->setError($field.' field is empty');
			}
			else {
				// Validate the text fields against the regex.  If it fails add error message to array
				if (!preg_match('/^[a-zA-Z0-9. -]+$/', $address)) {
					$this->setError($field.' contains invalid characters');
				}
				// if the length of the field is less than 2, add error message to array
				if (strlen($address) < 2) {
					$this->setError($field.' is too short'); 
				}
				// if the length of the field greater than 30, add error message to array
				if (strlen($address) > 50) {
					$this->setError($field.' is too long');
				}
			}    
		}    
    }
?>