<?php
    require_once 'Validator.php';
 
    class ValidateDate extends Validator {
        public function ValidateDate ($date, $field) {
			//  Create an array of errors
            $this->errors = array();
			// Validate the text for that field
            $this->validate($date, $field);
        }  
  
		public function validate() {
		
			$args = func_get_args();
			
			$date = $args[0];
			$field = $args[1];

			// If any of the text fields are empty add an error message to the array
			if(empty($date)) {
				$this->setError($field.' field is empty');
			}
			else {
			// Validate the text fields against the regex.  If it fails add error message to array
				if (!preg_match('/(0[1-9]|[12][0-9]|3[01])-(0[1-9]|1[0-2])-([2][0-9][0-9][0-9])/', $date)) {
					$this->setError($field.' not in correct format');
				}
			// if the length of the field is less than 2, add error message to array
				if (strlen($date) < 10) {
					$this->setError($field.' is too short'); 
				}
			// if the length of the field greater than 30, add error message to array
				if (strlen($date) > 10) {
					$this->setError($field.' is too long');
				}
			}    
		}    
    }
?>