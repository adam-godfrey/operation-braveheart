<?php

header('Content-type: application/json');

// Script Online Users and Visitors - http://coursesweb.net/php-mysql/
session_start();        // start Session, if not already started

$filetxt = 'userson.txt';  // the file in which the online users /visitors are stored
$timeon = 120;             // number of secconds to keep a user online
$sep = '^^';               // characters used to separate the user name and date-time
$vst_id = '-vst-';         // an identifier to know that it is a visitor, not logged user

// get the user name if it is logged, or the visitors IP (and add the identifier)
$unique_visitors = isset($_SESSION['nume']) ? $_SESSION['nume'] : $_SERVER['SERVER_ADDR']. $vst_id;

$rgxvst = '/^([0-9\.]*)'. $vst_id. '/i';         // regexp to recognize the line with visitors
$number_of_visitors = 0;                                       // to store the number of visitors

// sets the row with the current user /visitor that must be added in $filetxt (and current timestamp)
$addrow[] = $unique_visitors. $sep. time();

// check if the file from $filetxt exists and is writable
if(is_writable($filetxt)) {
	// get into an array the lines added in $filetxt
	$ar_rows = file($filetxt, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
	$nrrows = count($ar_rows);            // number of rows

	// if there is at least one line, parse the $ar_rows array
	if($nrrows>0) {
		for($i=0; $i < $nrrows; $i++) {
			// get each line and separate the user /visitor and the timestamp
			$ar_line = explode($sep, $ar_rows[$i]);

			// add in $addrow array the records in last $timeon seconds
			if($ar_line[0] != $unique_visitors && (intval($ar_line[1]) + $timeon) >= time()) {
				$addrow[] = $ar_rows[$i];
			}
		}
	}
}

$total_online = count($addrow);                   // total online
$users_online = '';                                    // to store the name of logged users
// traverse $addrow to get the number of visitors and users
for($i=0; $i < $total_online; $i++) {
	if(preg_match($rgxvst, $addrow[$i])) $number_of_visitors++;       // increment the visitors
	else {
		// gets and stores the user's name
		$ar_usron = explode($sep, $addrow[$i]);
		$users_online .= '<p>'. $ar_usron[0]. '</p>';
	}
}
$users = $total_online - $number_of_visitors;              // gets the users (total - visitors)

// write data in $filetxt
if(!file_put_contents($filetxt, implode("\n", $addrow))) $reout = 'Error: Recording file not exists, or is not writable';
	
$leftwidth = round( (($number_of_visitors/$total_online)*100) );
$rightwidth = round( (($users/$total_online)*100)) ;
	
echo json_encode(array(
	'online' => $total_online,
	'users_online' => $users_online, 
	'left' => $leftwidth,
	'right' => $rightwidth
));

?>