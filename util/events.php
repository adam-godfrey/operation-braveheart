<?php

// Initializations of the variables used
$dates = array();

// MYSQL connection credentials
define('MYSQL_HOST',     '127.0.0.1');
define('MYSQL_USER',     'root');
define('MYSQL_PASSWORD', '28fulford');
define('MYSQL_DB',       'mvc');

// PDO - connect to the database
try 
{
	$dbh = new PDO('mysql:host='.MYSQL_HOST.';dbname='.MYSQL_DB, MYSQL_USER, MYSQL_PASSWORD);

	$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$dbh->setAttribute(PDO::ATTR_PERSISTENT, true);
	$dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);
	$dbh->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, true);
} 
catch (PDOException $e) 
{
	echo 'Error!: ' . $e->getMessage() . '<br/>';
}

// take the events from the table named "events"
try
{
	$stmt = $dbh->query('SELECT * FROM events WHERE eventdate >= CURDATE()');
}
catch (PDOException $e)
{
	print($e->getMessage());
	die;
}
while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
{
	// because $row['event_date'] will have this form: 2012-01-10 and in Javascript we have 2012-1-10, 
	// we need to rewrite it the way we use it in Javascript so we can compare it
	$row['eventdate'] =  date("Y-n-j", strtotime($row['eventdate']));
	$dates[] = $row;
}	

echo json_encode($dates);

?>