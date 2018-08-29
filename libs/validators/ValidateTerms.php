<?php
    require_once 'Validator.php';
 
    class ValidateTerms extends Validator {
        public function ValidateTerms ($terms) {
			//  Create an array of errors
            $this->errors = array();
			// Validate the text for that field
            $this->validate($terms);
        }  
  
		public function validate() {
		
			$args = func_get_args();
			
			$terms = $args[0];

			// If any of the text fields are empty add an error message to the array
			if($terms =='No') {
				$this->setError('You didn\'t accept the Terms &amp; Conditions');
			}
		}
    }
?>