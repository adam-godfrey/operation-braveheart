<?php

// Always provide a TRAILING SLASH (/) AFTER A PATH
define('URL', 'http://localhost/app/');
define('LIBS', 'libs/');

define('DB_TYPE', 'mysql');
define('DB_HOST', '127.0.0.1');
define('DB_NAME', 'mvc');
define('DB_USER', 'root');
define('DB_PASS', '28fulford');

// The sitewide hashkey, do not change this because its used for passwords!
// This is for other hash keys... Not sure yet
define('HASH_GENERAL_KEY', 'MixitUp200');

// This is for database passwords only
define('HASH_PASSWORD_KEY', 'catsFLYhigh2000miles');

//session_save_path("/path/to/custom/directory");
	
define('MY_SESSION_NOT_SET', 'value_not_set'); //md5('value_not_set'))
		
date_default_timezone_set("Europe/London");

// Fill your PayPal email below.
// This is where you will receive the donations.

define('MYPAYPALEMAIL', 'your@email.com');

// Your goal in USD:
define('GOAL', 10000);

// Demo mode is set - set it to false to enable donations.
// When enabled PayPal is bypassed.

$demoMode = true;

$buttons = array();
$buttons['back'] = array('class' => 'back', 'name' => 'backbutton', 'id' => 'back-button', 'title' => 'Go Back');
$buttons['save'] = array('class' => 'save', 'name' => 'savebutton', 'id' => 'save-button', 'title' => 'Save');
$buttons['add'] = array('class' => 'add', 'name' => 'addbutton', 'id' => 'add-button', 'title' => 'Add');
$buttons['edit'] = array('class' => 'edit', 'name' => 'editbutton', 'id' => 'edit-button', 'title' => 'Edit');
$buttons['delete'] = array('class' => 'delete', 'name' => 'deletebutton', 'id' => 'delete-button', 'title' => 'Delete');
$buttons['archive'] = array('class' => 'archive', 'name' => 'archivebutton', 'id' => 'archive-button', 'title' => 'Archive');
$buttons['preview'] = array('class' => 'preview', 'name' => 'previewbutton', 'id' => 'preview-button', 'title' => 'Preview');
$buttons['thumbs-up'] = array('class' => 'thumbs-up', 'name' => 'thumbsupbutton', 'id' => 'thumbsup-button', 'title' => 'Thumbs Up');
$buttons['thumbs-down'] = array('class' => 'thumbs-down', 'name' => 'thumbsdownbutton', 'id' => 'thumbsdown-button', 'title' => 'Thumbs Down');

if(!$demoMode) {
	// The paypal URL:
	define('payPalURL', 'https://www.paypal.com/cgi-bin/webscr');
}
else {

	define('payPalURL', 'demo_mode.php');
}