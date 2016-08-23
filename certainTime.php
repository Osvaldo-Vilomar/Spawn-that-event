<?php 

session_start();

require_once 'serverLogin.php';

$studentID = $_SESSION['studentID'];
$timeValue = $_POST['timeChosen'];

$queryCurrentTime = "Select Time_Show from Student_Settings where studentID = '$studentID'";
$resultCurrentTime = mysql_query($queryCurrentTime);
if(!$resultCurrentTime) die ("Database get failed(time): " . mysql_error());

$currentTime = mysql_result($resultCurrentTime, 0);

if($timeValue == $currentTime) {
	$queryTimeValue = "Update Student_Settings set Time_Show='all' where studentID = '$studentID'";
	$resultTimeValue = mysql_query($queryTimeValue);
	if(!$resultTimeValue) die ("Database update failed(update all): " . mysql_error());
	echo "all";
}
elseif($timeValue == "today") {
	
	$queryTimeValue = "Update Student_Settings set Time_Show='$timeValue' where studentID = '$studentID'";
	$resultTimeValue = mysql_query($queryTimeValue);
	if(!$resultTimeValue) die ("Database update failed(update today chosen): " . mysql_error());

}
elseif($timeValue == "tomorrow") {
	$queryTimeValue = "Update Student_Settings set Time_Show='$timeValue' where studentID = '$studentID'";
	$resultTimeValue = mysql_query($queryTimeValue);
	if(!$resultTimeValue) die ("Database update failed(update tomorrow chosen): " . mysql_error());
	
}
elseif($timeValue == "weekly") {
	$queryTimeValue = "Update Student_Settings set Time_Show='$timeValue' where studentID = '$studentID'";
	$resultTimeValue = mysql_query($queryTimeValue);
	if(!$resultTimeValue) die ("Database update failed(update weekly chosen): " . mysql_error());
	
}

?>