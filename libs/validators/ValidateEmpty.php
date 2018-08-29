<?php
    require_once 'Validator.php';
 
    class ValidateEmpty extends Validator {
	
        public function ValidateEmpty ($name, $field) {
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
		}
    }
?>