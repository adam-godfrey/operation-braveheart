<?php
/**
 * 
 */
class Auth {
    
    public static function handleLogin() {
	
        @session_start();
        $logged = $_SESSION['loggedIn'];
		
        if ($logged == false) {
		
            session_destroy();
            header('location: ../login');
            exit;
        }
    }
    
	public static function isAdmin() {
	
	
	}
	
	public static function loginError() {

		@session_start();
		
		if(isset($_SESSION['loginError'])) {
		
			switch($_SESSION['loginError']) {
			
				case 0:
					echo "Logged in";
					break;
				case 1:
					echo "Not verified";
					break;
				case 2:
					echo "Not active";
					break;
				case 3:
					echo "Error occured";
					break;
				case 4:
					echo "No match";
					break;
				default;
			}
			unset($_SESSION['loginError']);
		}
	}
	
	public static function queryString() {
	
		$path = explode('/', parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
		
		unset($path[0]);
		unset($path[1]);
		
		$path = implode('/', $path);
		
		return $path;
	}
}