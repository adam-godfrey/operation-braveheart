<?php
    require_once 'Validator.php';
 
    class ValidateNumber extends Validator {
        public function ValidateName ($name, $field) {
			//  Create an array of errors
            $this->errors = array();
			// Validate the text for that field
            $this->validate($name, $field);
        }  
  
		public function validate() {
			
			$args = func_get_args();
			
			$name = $args[0];
			$field = $args[1];

			// If any of the text fields are empty add an error message to the array
			if(empty($name)) {
				$this->setError($field.' field is empty');
			}
			else {
				// Validate the text fields against the regex.  If it fails add error message to array
				if (!preg_match('/^[0-9]+$/', $name)) {
					$this->setError($field.' contains invalid characters');
				}
				// if the length of the field is less than 2, add error message to array
				if (strlen($name) < 1) {
					$this->setError($field.' is too short'); 
				}
			}    
		}    
    }
?>