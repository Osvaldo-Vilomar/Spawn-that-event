<?php

session_start();

require_once 'serverLogin.php';
require_once 'sanitizeInput.php';

// Fix allow numbers in title
if(isset($_POST['eventName']) &&
	isset($_POST['eventType']) &&
	isset($_POST['date1']) && 	
	isset($_POST['date2']) &&	
	isset($_POST['date3']) &&	
	isset($_POST['hour1']) &&	
	isset($_POST['minutes1']) &&	
	isset($_POST['ampm1']) &&	
	isset($_POST['hour2']) &&	
	isset($_POST['minutes2']) &&	
	isset($_POST['ampm2']) &&	
	isset($_POST['location']) &&	
	isset($_POST['shortDescription']) &&	
	isset($_POST['name']) && 	
	isset($_POST['contactInfo']) && 
	isset($_POST['sponsor']) &&
	isset($_POST['eventTag']) &&
	isset($_SESSION['studentID']))
{
	
	$eventName = sanitizeString($_POST['eventName']);
	$shareStatus = sanitizeString($_POST['shareStatus']);
	$eventType = sanitizeString($_POST['eventType']);
	$date1 = sanitizeString($_POST['date1']);
	$date2 = sanitizeString($_POST['date2']);
	$date3 = sanitizeString($_POST['date3']);
	$hour1 = sanitizeString($_POST['hour1']);
	$minutes1 = sanitizeString($_POST['minutes1']);
	$ampm1 = sanitizeString($_POST['ampm1']);
	$hour2 = sanitizeString($_POST['hour2']);
	$minutes2 = sanitizeString($_POST['minutes2']);
	$ampm2 = sanitizeString($_POST['ampm2']);
	$location = sanitizeString($_POST['location']);
	$shortDescription = sanitizeString($_POST['shortDescription']);
	$name = sanitizeString($_POST['name']);
	$contactInfo = sanitizeString($_POST['contactInfo']);
	$sponsor = sanitizeString($_POST['sponsor']);
	$eventTag = sanitizeString($_POST['eventTag']);
	
	if($eventTag == "none") $eventTag = "";
	
	$studentID = $_SESSION['studentID'];
	$fieldOfStudy = $_SESSION['fieldOfStudy'];
	$firstName = $_SESSION['firstName'];
	$lastName = $_SESSION['lastName'];
	
	$getID = mysql_query("Select max(id) from Made_Events");
	$newID = mysql_result($getID, 0) + 1;
	
	if(isset($_POST['requestTagText'])) {
		$tag = $_POST['requestTagText'];
		mysql_query("Insert into AuthorizeTag values ('$eventType', '$tag', 'n', $newID)");
	}
	
	if($ampm1 == 1) {
		$ampm1 = "am";
	}
		
	if($ampm1 == 2) {
		$ampm1 = "pm";
	}
	
	if($ampm2 == 1) {
		$ampm2 = "am";
	}
	
	if($ampm2 == 2) {
		$ampm2 = "pm";
	}
		
	if($minutes1 == "0" || $minutes1 == "") {
		$minutes1 = "00";
	}
	
	if($minutes2 == "0" || $minutes2 == "") {
		$minutes2 = "00";
	}
	
	$eventDate = $date3 . $date1 . $date2;
		
	// Need to look into 00:--, 0:--, (x>12):(y>60)
	// Refine time input
	$numberTen1_1 = strpos($hour1, "1");
	$numberTen2_1 = strpos($hour1, "0");
		
	if($numberTen1_1 === 0 && $numberTen2_1 === 1) {
		$usedHour1 = $hour1;
	}
	else {
		$usedHour1 = str_replace("0", "", $hour1);
	}
		
	$timeStart = $usedHour1 . ":" . $minutes1 . $ampm1;
		
	$numberTen1_2 = strpos($hour2, "1");
	$numberTen2_2 = strpos($hour2, "0");
		
	if($numberTen1_2 === 0 && $numberTen2_2 === 1) {
		$usedHour2 = $hour2;
	}
	else {
		$usedHour2 = str_replace("0", "", $hour2);
	}
		
	$timeEnd = $usedHour2 . ":" . $minutes2 . $ampm2;
	// End refine time input
		
	$unixDate = $date1 . "/" . $date2 . "/" . $date3;
	$unixTime = $usedHour1 . ":" . $minutes1 . $ampm1;
	$unixTimeStamp = $unixDate . " " . $unixTime;
	$unixTimeStart = strtotime("$unixTimeStamp");
	
	$unixCreated = time();
	
	if($shareStatus != "y") {

		$query = mysql_query("Insert INTO Made_Events VALUES" .
				"('','$studentID,','$eventName','$eventType','$location','$shortDescription', '$eventDate', '$timeStart',
				'$timeEnd', '$name', '$contactInfo', '$sponsor', '$unixTimeStart', '', CURRENT_TIMESTAMP, '$unixCreated',
				'$eventTag', '', '')");
		
		header("Location: ../newHome.php");
	}
	else {
		if(!isset($_SESSION['groupID'])) {
			$queryGroupID = mysql_query("Select groupID, groupTitle from Group_Founder where studentID='$studentID'");
			
			$groupID = mysql_result($queryGroupID, 0, 'groupID');
			$_SESSION['groupID'] = $groupID;
				
			$groupTitle = mysql_result($queryGroupID, 0, 'groupTitle');
			$_SESSION['groupTitle'] = $groupTitle;
			
		}
		else {
			$groupID = $_SESSION['groupID'];
			$groupTitle = $_SESSION['groupTitle'];
		}
		
		$query = mysql_query("Insert INTO Made_Events VALUES" .
				"('','$studentID,','$eventName','$eventType','$location','$shortDescription', '$eventDate', '$timeStart',
				'$timeEnd', '$name', '$contactInfo', '$sponsor', '$unixTimeStart', '', CURRENT_TIMESTAMP, '$unixCreated',
				'$eventTag', '$groupID', '$groupTitle')");
		
		mysql_query("Insert into Group_Events values ('', '$studentID', '$newID', '$groupTitle', '$eventName', '$eventType', CURRENT_TIMESTAMP, '$unixTimeStart')");
		
		header("Location: ../followPage.php?fp=$groupID&loc=home");
	}
}
?>