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
	
	$eventID = sanitizeString($_POST['eventID']);
	$eventTitle = urldecode(sanitizeString($_POST['eventTitle']));
	$eventDate = date('Y-m-d', strtotime(sanitizeString($_POST['eventDate'])));
	$timeStart = urldecode(sanitizeString($_POST['timeStart']));
	$timeStop = urldecode(sanitizeString($_POST['timeStop']));
	$location = urldecode(sanitizeString($_POST['location']));
	$shortDescription = urldecode(sanitizeString($_POST['shortDescription']));
	$contactName = urldecode(sanitizeString($_POST['contactName']));
	$email = urldecode(sanitizeString($_POST['email']));
	$sponsor = urldecode(sanitizeString($_POST['sponsor']));
	$eventType = urldecode(sanitizeString($_POST['eventType']));
	$eventDateUnix = strtotime($eventDate);
	
	$studentFName = $_SESSION['firstName'];
	$studentLName = $_SESSION['lastName'];
	
	 $queryEventAttendee = mysql_query("Insert into Event_Attendee values" . 
							"('', '$studentID', '$studentFName', '$studentLName', '$eventID',
								'$eventTitle', 'yes', '$eventDate', '$eventDateUnix', '$eventType', '$location',
								'$shortDescription', '$timeStart', '$timeStop', '$contactName', '$email', '$sponsor')");
	
}

?>