<?php 

session_start();

require_once 'serverLogin.php';
require_once 'sanitizeInput.php';

$studentID = $_SESSION['studentID'];

if(isset($_POST['editFollowPage'])) {
	
	$groupID = $_POST['fp'];
	$getID = mysql_query("Select studentID from Group_Pages where groupID = '$groupID'");
	$thisGroupCreater = mysql_result($getID, 0);
	
	if($studentID == $thisGroupCreater) {
		$editValue = $_POST['editFollowPage'];
		if($editValue == "true") {
			$groupTitle = $_POST['groupTitle'];
			$groupEventTypes = $_POST['groupTypesOfEvents'];
			$groupAboutUs = $_POST['groupAboutUs'];
			$groupEmail = $_POST['groupEmail'];
			$groupPhoneNumber = $_POST['groupPhoneNumber'];
			
			mysql_query("Update Group_Pages set groupTitle='$groupTitle',
					groupTypesOfEvents='$groupEventTypes', groupAboutUs='$groupAboutUs',
					groupEmail='$groupEmail', groupPhone='$groupPhoneNumber' where groupID='$groupID'");
		}
	}
	
	$previousPage = $_POST['loc'];
	header('Location: ../followPage.php?fp=' . $groupID . '&loc=' . $previousPage);
}
else if(isset($_POST['updateFollow'])) {
	if($_POST['updateFollow'] == 'true') {
		$groupID = $_POST['groupID'];
		if($_POST['action'] == 'follow') {
			$groupTitle = $_POST['groupTitle'];
			mysql_query("Insert into Group_Following values ('$studentID', '$groupID', '$groupTitle', CURRENT_TIMESTAMP)");
		}
		else {
			mysql_query("Delete from Group_Following where studentID='$studentID' and groupID='$groupID'");
		}
	}
}
else if(isset($_POST['removeTheseGroups'])) {
	if($_POST['removeTheseGroups'] == 'true') {
		$values = join(',', $_POST['values']);
		mysql_query("Delete from Group_Following where groupID in ($values)");
	}
}
else if(isset($_POST['groupTitle']) &&
	isset($_POST['groupTypesOfEvents']) &&
	isset($_POST['groupAboutUs']) &&
	isset($_POST['groupEmail']) &&
	isset($_POST['groupPhoneNumber'])) {
	
	$studentID = sanitizeString($_SESSION['studentID']);
	$groupTitle = sanitizeString($_POST['groupTitle']);
	$groupTypesOfEvents = sanitizeString($_POST['groupTypesOfEvents']);
	$groupAboutUs = sanitizeString($_POST['groupAboutUs']);
	$groupEmail = sanitizeString($_POST['groupEmail']);
	$groupPhone = sanitizeString($_POST['groupPhoneNumber']);
	
	$getID = mysql_query("Select max(groupID) from Group_Pages");
	$newID = mysql_result($getID, 0) + 1;
	
	mysql_query("Insert into Group_Pages values ('', '$studentID', '$groupTitle', '$groupTypesOfEvents', '$groupAboutUs',
													'$groupEmail', '$groupPhone')");
	
	mysql_query("Insert into Groups_Available values('$studentID', '$newID', '$groupTitle')");
	
	mysql_query("Insert into Group_Founder values ('$studentID', '$newID', '$groupTitle', CURRENT_TIMESTAMP, 'y' )");
	
	header('Location: ../followPage.php?fp=' . $newID . '&loc=home');
}
else if(isset($_POST['updateGroupBar'])) {
	if($_POST['updateGroupBar'] == 'true') {
		$thisBar = $_POST['groupBar'];
		$newValue = $_POST['value'];
		
		if($thisBar == 'groupAttending') {
			mysql_query("Update Student_Settings set groupAttending = '$newValue' where studentID='$studentID'");
		}
		else if($thisBar == 'groupHistory') {
			mysql_query("Update Student_Settings set groupHistory = '$newValue' where studentID='$studentID'");
		}
	}
}

?>