<?php
    // Include the Validator class to extend
    require_once 'Validator.php';
	
    class ValidatePostcode extends Validator {
        public function ValidatePostcode ($postcode) {
			//  Create an array of errors
            $this->errors = array();
			// Validate the postcode
            $this->validate($postcode);
        } 

		public function validate() {
			
			$args = func_get_args();
			
			$postcode = $args[0];
			
			// If the postcode is empty add an error message to the array
			if(empty($postcode)) {
				$this->setError('Postcode field is empty');
			}
			else {
				// Match the postcode against the regex.  If it fails add error message to the array
				if(!preg_match("/^((([A-PR-UWYZ](\d([A-HJKSTUW]|\d)?|[A-HK-Y]\d([ABEHMNPRVWXY]|\d)?))\s*(\d[ABD-HJLNP-UW-Z]{2})?)|GIR\s*0AA)$/",$postcode)) {
					$this->setError($field.' Postcode in invalid format');
				}
			}
		}
    }
?>