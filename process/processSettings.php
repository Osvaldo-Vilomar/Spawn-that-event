<?php 

session_start();

require_once 'serverLogin.php';
require_once 'sanitizeInput.php';

$studentID = $_SESSION['studentID'];

if(isset($_POST['dateTimeLocationStatus'])) {
	$dateTimeLocationStatus = sanitizeString($_POST['dateTimeLocationStatus']);
	mysql_query("Update Student_Settings set dateTimeLocation='$dateTimeLocationStatus' where studentID='$studentID'");
}
if(isset($_POST['shortDescriptionStatus'])) {
	$shortDescriptionStatus = sanitizeString($_POST['shortDescriptionStatus']);
	mysql_query("Update Student_Settings set shortDescription='$shortDescriptionStatus' where studentID='$studentID'");
}
if(isset($_POST['detailSettingStatus'])) {
	$detailSettingStatus = sanitizeString($_POST['detailSettingStatus']);
	mysql_query("Update Student_Settings set details='$detailSettingStatus' where studentID='$studentID'");
}
if(isset($_POST['eventsTotalSettingStatus'])) {
	$eventsTotalSettingStatus = sanitizeString($_POST['eventsTotalSettingStatus']);
	mysql_query("Update Student_Settings set categoryTotalEvents='$eventsTotalSettingStatus' where studentID='$studentID'");
}

header("Location: ../newHome.php");

?>