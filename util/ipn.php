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
ini_set('error_log', dirname(__FILE__).'/ipn_errors.log');

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
    
	// 3. Make sure the amount(s) paid match
    $sql = "SELECT amount FROM invoices WHERE invoicenumber = :invoice"; //'$invoicenumber'";
	
	$selection = $this->db->select($sql, array(':invoice' => $_POST['invoice']));
    
	$amount = $selection[0]['amount'];
	$result = $db->query($sql);
    	
    if ($_POST['mc_gross'] != $amount) {
        $errmsg .= "'mc_gross' does not match: ";
        $errmsg .= $_POST['mc_gross']."\n";
    }
    
    // 4. Make sure the currency code matches
    if ($_POST['mc_currency'] != 'GBP') {
        $errmsg .= "'mc_currency' does not match: ";
        $errmsg .= $_POST['mc_currency']."\n";
    }

    $sql = "SELECT COUNT(*) FROM payments WHERE txn_id :txn_id";
	
	$exists = $this->db->count($sql, array(':txn_id' => $_POST['txn_id']));
    
    if ($exists) {
        $errmsg .= "'txn_id' has already been processed: ".$_POST['txn_id']."\n";
    }
    
    if (!empty($errmsg)) {
    
        // manually investigate errors from the fraud checking
        $body = "IPN failed fraud checks: \n$errmsg\n\n";
        $body .= $listener->getTextReport();
        mail('adam@operationbraveheart.org.uk', 'IPN Fraud Warning', $body);
        
    } else {
    
        // add this order to a table of completed orders
        $this->db->insert('payments', array(
			'txn_id' => $_POST['txn_id'],
			'payer_email' => $_POST['payer_email'],
			'mc_gross' => $_POST['mc_gross'],
			'invoice' => $_POST['invoice'], 
			'created' => date( 'Y-m-d H:i:s')
		));
    }
    
} else {
    // manually investigate the invalid IPN
    mail('adrock952@gmail.com', 'Invalid IPN', $listener->getTextReport());
}
?>