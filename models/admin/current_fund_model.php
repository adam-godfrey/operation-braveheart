<?php

class Current_Fund_Model extends Model {

    public function __construct() {
	
        parent::__construct();
    }
	
	public function updateFund($myFile, $fund) {
	
		if(file_get_contents($myFile)) {
			$fh = fopen($myFile, 'w');
			
			fwrite($fh, $fund);
			fclose($fh);
			
			return true;
		}
		return false;
	}
}