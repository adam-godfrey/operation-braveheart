<?php
/*
ipn.php - example code used for the tutorial:

PayPal IPN with PHP
How To Implement an Instant Payment Notification listener script in PHP
http://www.micahcarrick.com/paypal-ipn-with-php.html

(c) 2011 - Micah Carrick
*/

// tell PHP to log errors to ipn_errors.log in this directory
ini_set('log_errors', true);
ini_set('error_log', dirname(__FILE__).'/donate_ipn_errors.log');

// require the config file for settings
require('../config.php');
// intantiate the IPN listener
include('ipnlistener.php');
$listener = new IpnListener();
// include the database class
include(URL . 'libs/database.php');
$database = new Database(DB_TYPE, DB_HOST, DB_NAME, DB_USER, DB_PASS);

// tell the IPN listener to use the PayPal test sandbox
$listener->use_sandbox = true;

// try to process the IPN POST
try {
    $listener->requirePostMethod();
    $verified = $listener->processIpn();
} catch (Exception $e) {
    error_log($e->getMessage());
    exit(0);
}

if ($verified) {

    $errmsg = '';   // stores errors from fraud checks
    
    // 1. Make sure the payment status is "Completed" 
    if ($_POST['payment_status'] != 'Completed') { 
        // simply ignore any IPN that is not completed
        exit(0); 
    }

    // 2. Make sure seller email matches your primary account email.
    if ($_POST['receiver_email'] != 'adrock_1278539033_biz@gmail.com') {
        $errmsg .= "'receiver_email' does not match: ";
        $errmsg .= $_POST['receiver_email']."\n";
    }
    	
    if (!empty($errmsg)) {
    
        // manually investigate errors from the fraud checking
        $body = "IPN failed fraud checks: \n$errmsg\n\n";
        $body .= $listener->getTextReport();
        mail('adrock952@gmail.com', 'IPN Fraud Warning', $body);
        
    } else {
    
		$this->db->insert('dc_donations', array(
			'transaction_id' => $_POST['txn_id'],
			'donor_email' => $_POST['payer_email'],
			'amount' => $_POST['mc_gross'],
			'original_request' => http_build_query($_POST),
			'created' => date( 'Y-m-d H:i:s')
		));
    }
    
} else {
    // manually investigate the invalid IPN
    mail('adrock952@gmail.com', 'Invalid IPN', $listener->getTextReport());
}
?>