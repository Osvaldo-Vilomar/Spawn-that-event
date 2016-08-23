<?php 

session_start();

require_once 'serverLogin.php';

$studentID = $_SESSION['studentID'];
$eventName = "This is a sample event";

$location = "Tech Square";
$shortDescription = "This is a short description that all events created with this script will have after running it.";
$nextWeek = time() + (7 * 24 * 60 * 60);
$eventDate = date('Y-m-d', $nextWeek);
$timeStart = "8:00pm";
$timeEnd = "9:00pm";
$contactName = $_SESSION['firstName'];
$email = "ovilomar@gatech.edu";
$sponsor = "Event Automated";
$UnixTime = strtotime(date('Y-m-d', $nextWeek));
$Votes = 0;
$currentTime = time();
$dateCurrent = date('Y-m-d');
$eventTag = "rock";

mysql_query("Insert into Made_Events values ('','$studentID', '$eventName', 'Movies', '$location', '$shortDescription', '$eventDate', '$timeStart', '$timeEnd', '$contactName', '$email', '$sponsor', '$nextWeek', '$Votes', CURRENT_TIMESTAMP, '$currentTime', '')");
mysql_query("Insert into Made_Events values ('','$studentID', '$eventName', 'Movies', '$location', '$shortDescription', '$eventDate', '$timeStart', '$timeEnd', '$contactName', '$email', '$sponsor', '$nextWeek', '$Votes', CURRENT_TIMESTAMP, '$currentTime', '')");
mysql_query("Insert into Made_Events values ('','$studentID', '$eventName', 'Movies', '$location', '$shortDescription', '$eventDate', '$timeStart', '$timeEnd', '$contactName', '$email', '$sponsor', '$nextWeek', '$Votes', CURRENT_TIMESTAMP, '$currentTime', '')");
mysql_query("Insert into Made_Events values ('','$studentID', '$eventName', 'Movies', '$location', '$shortDescription', '$eventDate', '$timeStart', '$timeEnd', '$contactName', '$email', '$sponsor', '$nextWeek', '$Votes', CURRENT_TIMESTAMP, '$currentTime', '')");
mysql_query("Insert into Made_Events values ('','$studentID', '$eventName', 'Movies', '$location', '$shortDescription', '$eventDate', '$timeStart', '$timeEnd', '$contactName', '$email', '$sponsor', '$nextWeek', '$Votes', CURRENT_TIMESTAMP, '$currentTime', '')");

header("Location: newHome.php");

?>