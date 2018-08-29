<?php

class Manage_Cache_Model extends Model {

    public function __construct() {
	
        parent::__construct();
    }
	
	public function clearCache($choice, $cached_items) {
	
		$files = preg_grep('#\.cache#', glob('/www/app/cache/*'), PREG_GREP_INVERT);
		$exit = false;
		
		switch($choice) {
			
			case 'all':
				foreach($files as $file) { // iterate files
					if(is_file($file)) { 
						if(!unlink($file)) { // delete file
							return false;
							break;
						}; 
					}
				}
				return true;
				break;
			case 'choices':
				foreach($files as $file) { // iterate files
					if(is_file($file) && in_array(strstr(basename($file), "_", true), $cached_items)) {
						if(!unlink($file)) { // delete file
							return false;
							break;
						}; 
					}
				}
				break;
			default:
		}
	}
}