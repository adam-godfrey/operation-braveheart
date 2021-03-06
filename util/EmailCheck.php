<?php

require '../config.php';

try {
	// create a new instance of a PDO connection
    $db = new PDO(DB_TYPE.':host='.DB_HOST.';dbname='.DB_NAME, DB_USER, DB_PASS);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e) {
	// if the connection fails, display an error message
    echo 'ERROR: ' . $e->getMessage();
}

if(isset($_GET['email']) && !empty($_GET['email'])) {

	$email = $_GET['email'];
	
	$sql = 'SELECT email FROM users WHERE email = :email';
	
	$stmt = $db->prepare($sql);
	$stmt->bindValue('email', $email);
	$stmt->execute();
	$count = (int) count($stmt->fetchAll());
	
	echo json_encode(($count == 1) ? false : true);
	
}

?>