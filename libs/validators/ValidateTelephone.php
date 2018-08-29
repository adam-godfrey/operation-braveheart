<?php
    require_once 'Validator.php';
 
    class ValidateTelephone extends Validator {
        public function ValidateTelephone ($telephone, $field) {
			//  Create an array of errors
            $this->errors = array();
			// Validate the text for that field
            $this->validate($telephone, $field);
        }  
  
		public function validate() {
		
			$args = func_get_args();
			
			$telephone = $args[0];
			$field = $args[1];

			// If any of the text fields are empty add an error message to the array
			if(empty($telephone)) {
				$this->setError($field.' field is empty');
			}
			else {
			// if the length of the field is less than 2, add error message to array
				if (strlen($telephone) < 10) {
					$this->setError($field.' is too short'); 
				}
				else
				// if the length of the field greater than 30, add error message to array
				if (strlen($telephone) > 13) {
					$this->setError($field.' is too long');
				}
				else {
					// Validate the text fields against the regex.  If it fails add error message to array
					if (!preg_match('/(((\+44)? ?(\(0\))? ?)|(0))( ?[0-9]{3,4}){3}/', $telephone)) {
						$this->setError($field.' contains invalid characters');
					}
				}
			}    
		}    
    }
?>