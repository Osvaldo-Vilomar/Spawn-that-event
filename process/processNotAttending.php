<?php 

session_start();

require_once 'serverLogin.php';
require_once 'sanitizeInput.php';

$studentID = $_SESSION['studentID'];
$eventID = sanitizeString($_POST['eventID']);
$attending = sanitizeString($_POST['attending']);
$attendingValue = sanitizeString($_GET['attendingValue']);
$eventIDGet = sanitizeString($_GET['eventID']);

if($attending == "no") {
	if(isset($eventID)) {
		$query = "Update Event_Attendee set attending = 'no' where studentID = '$studentID' and eventID = '$eventID'";
		$resultquery = mysql_query($query);
	}
}
elseif($attending == "yes") {
	if(isset($eventID)) {
		$query = "Update Event_Attendee set attending = 'yes' where studentID = '$studentID' and eventID = '$eventID'";
		$resultquery = mysql_query($query);
	}
}

if($attendingValue == "get") {
	$query = "Select attending from Event_Attendee where studentID = '$studentID' and eventID = '$eventIDGet'";
	$resultquery = mysql_query($query);
	$returnValue = mysql_result($resultquery, 0);

	echo $returnValue;
}

?>