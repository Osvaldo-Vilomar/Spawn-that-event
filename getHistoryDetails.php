<?php 

session_start();

require_once 'serverLogin.php';
require_once 'sanitizeInput.php';

if(isset($_GET['eventID']) &&
	isset($_SESSION['studentID'])) {
	
	$eventID = sanitizeString($_GET['eventID']);
	$studentID = sanitizeString($_SESSION['studentID']);
	
	$queryEvent = "Select * from Made_Events where id='$eventID'";
	$resultEvent = mysql_query($queryEvent);
	$event = mysql_fetch_row($resultEvent);
	
	$dateFormatted = date('l F j, y', $event[12]);
	
	$eventArray = array(
			"id" => $event[0],
			"eventName" => $event[2],
			"eventType" => $event[3],
			"location" => $event[4],
			"shortDescription" => $event[5],
			"eventDate" => $dateFormatted,
			"timeStart" => $event[7],
			"timeEnd" => $event[8],
			"contact" => $event[9],
			"email" => $event[10],
			"sponsor" => $event[11]);
	
	echo json_encode($eventArray);
	
}
else {
	
}

?>