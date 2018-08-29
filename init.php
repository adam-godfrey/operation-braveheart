<?php 
	
	if(ini_get('session.cookie_httponly' == '0'))
		ini_set('session.cookie_httponly', '1');
	
	if(ini_get('session.use_only_cookies') == '0')
		ini_set('session.use_only_cookies', '1');
	
	if(ini_get('session.cookie_secure') == '0')
		ini_set('session.cookie_secure', '1');
			
	date_default_timezone_set("Europe/London");
	
	$pagename = basename($_SERVER['SCRIPT_NAME']);
	
?>