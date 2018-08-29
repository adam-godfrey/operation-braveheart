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

$messageid = $_POST['messageid'];
$topicid = $_POST['topicd'];

$sql = "INSERT INTO flagged (messageid, topicid, reportdate) VALUES (:messageid, :topicid, now())";

$stmt = $db->prepare($sql);
$stmt->bindValue(':messageid', $messageid);
$stmt->bindValue(':topicd', $topicid);
$stmt->execute();

?>