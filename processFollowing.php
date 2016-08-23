<?php 

session_start();

require_once 'serverLogin.php';
require_once 'sanitizeInput.php';

$studentID = sanitizeString($_SESSION['studentID']);
$following = sanitizeString($_POST['updateFollow']);

$queryPromoterName = "Select promoterFName, promoterLName, studentID from Event_Promoter where promoterID = '$following'";
$resultPromoterName = mysql_query($queryPromoterName);
$promoterFName = mysql_result($resultPromoterName, 0, 'promoterFName');
$promoterLName = mysql_result($resultPromoterName, 0, 'promoterLName');
$clickingSelf = mysql_result($resultPromoterName, 0, 'studentID');

$timeStamp = date('Y-m-d H:i:s');

// check if user is already following
$queryIsFollowing = "Select followingID from Following where studentID = '$studentID'";
$resultIsFollowing = mysql_query($queryIsFollowing);

if(mysql_num_rows($resultIsFollowing) == false) {
	if($studentID != $clickingSelf) {
		$queryFollowing = "Insert into Following values ('$studentID', '$following', '$promoterFName', '$promoterLName', '$timeStamp')";
		$resultFollowing = mysql_query($queryFollowing);
	}
}

?>