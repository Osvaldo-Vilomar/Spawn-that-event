<?php 

session_start();
require_once 'sanitizeInput.php';
require_once 'serverLogin.php';

if(isset($_POST['eventID']) &&
	isset($_POST['eventTitle']) &&
	isset($_POST['eventDate']) &&
	isset($_POST['timeStart']) &&
	isset($_POST['timeStop']) &&
	isset($_POST['location']) &&
	isset($_POST['shortDescription']) &&
	isset($_POST['contactName']) &&
	isset($_POST['email']) &&	
	isset($_POST['eventType']) &&
	isset($_POST['sponsor']) &&
	isset($_SESSION['studentID']) &&
	isset($_SESSION['firstName']) &&
	isset($_SESSION['lastName'])) {

	$studentID = $_SESSION['studentID'];
	/* $currentValue = 100;
	$queryEventValue = "Select $eventType from Student_Events where studentID='$studentID'";
	$resultQueryEventValue = mysql_query($queryEventValue);
	$studentEventValue=mysql_result($resultQueryEventValue, 0);
	$newEventValue = $currentValue + $studentEventValue;
	$queryInsertNewValue = "Update Student_Events set $eventType = '$newEventValue' where studentID = '$studentID'";
	$resultNewValue = mysql_query($queryInsertNewValue); */
	
	$eventID = sanitizeString($_POST['eventID']);
	$eventTitle = urldecode(sanitizeString($_POST['eventTitle']));
	$eventDate = sanitizeString($_POST['eventDate']);
	$timeStart = sanitizeString($_POST['timeStart']);
	$timeStop = sanitizeString($_POST['timeStop']);
	$location = urldecode(sanitizeString($_POST['location']));
	$shortDescription = urldecode(sanitizeString($_POST['shortDescription']));
	$contactName = urldecode(sanitizeString($_POST['contactName']));
	$email = urldecode(sanitizeString($_POST['email']));
	$sponsor = urldecode(sanitizeString($_POST['sponsor']));
	$eventType = sanitizeString($_POST['eventType']);
	$eventDateUnix = strtotime($eventDate);
	
	$studentFName = $_SESSION['firstName'];
	$studentLName = $_SESSION['lastName'];
	
	$queryEventAttendee = mysql_query("Insert into Event_Attendee values" . 
							"('', '$studentID', '$studentFName', '$studentLName', '$eventID',
								'$eventTitle', 'yes', '$eventDate', '$eventDateUnix', '$eventType', '$location',
								'$shortDescription', '$timeStart', '$timeStop', '$contactName', '$email', '$sponsor')");
	
	echo $eventTitle;
	/* if (!mysql_query($queryEventAttendee, $db_server))
		echo "Insert failed: $queryEventAttendee<br/>" . mysql_error() . "<br/><br/>"; */
	
	// fix this
	/* if(sanitizeString($_POST['studyOrHome']) == 2) {
		header("Location: fieldofstudy.php");
	} */
	
// 	if(sanitizeString($_POST['studyOrHome']) == 1) {
		header("Location: newHome.php");
// 	}
}

?>