<?php
class Validator {
    var $errors;
	
    //Constructor
    public function validate() {}
	
    // Function to add all the error messages to the array
    public function setError($msg) {
		$this->errors[] = $msg;
    }
	
    // Function to check if the validation passes
    public function isValid() {
		if (count($this->errors) > 0) {
			return false;
		} else {
			return true;
		}
    }
	
    // Function to get each of the errors
    public function fetch() {
		$error = each($this->errors);
		if ($error) {
			return $error['value'];
		} else {
			reset($this->errors);
			return false;
		}
    }
}
?>