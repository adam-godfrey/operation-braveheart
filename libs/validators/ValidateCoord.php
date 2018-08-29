<?php
    require_once 'Validator.php';
 
    class ValidateCoord extends Validator {
        public function ValidateCoord ($coord, $field)
        {
	    //  Create an array of errors
            $this->errors = array();
	    // Validate the text for that field
            $this->validate($coord, $field);
        }  
  
		public function validate() {
		
			$args = func_get_args();
			
			$coord = $args[0];
			$field = $args[1];

			// If any of the text fields are empty add an error message to the array
			if(empty($coord)) {
				$this->setError($field.' field is empty');
			}
			else {
				// Validate the text fields against the regex.  If it fails add error message to array
				if (!preg_match('/^[0-9.-]+$/', $coord)) {
					$this->setError($field.' contains invalid characters');
				}
				// if the length of the field is less than 8, add error message to array
				if (strlen($coord) < 12) {
					$this->setError($field.' is too short'); 
				}
				// if the length of the field greater than 9, add error message to array
				if (strlen($coord) > 12) {
					$this->setError($field.' is too long');
				}
			}    
		}    
    }
?>