<?php 

session_start();

require_once 'serverLogin.php';
require_once 'sanitizeInput.php';

$studentID = $_SESSION['studentID'];
$eventName = "Leisure";
$eventType = "This is an automated title";
$location = "Tech Squre";
$shortDescription = sanitizeString("Mauris sed tortor nunc. Phasellus justo lectus, scelerisque id pretium pretium, porttitor eu mi. Donec semper, sem sit amet tincidunt ornare, arcu nisi pulvinar ante, ut tristique eros leo in odio. Duis id dui a diam fermentum cursus in non tortor. Vivamus mollis volutpat accumsan. Integer ante nisi");
$eventDate = "2013-06-09";
$timeStart = "6:00pm";
$timeEnd = "8:00pm";
$contact = "George";
$email = sanitizeString("George@gatech.edu");
$sponsor = "GTPSC";
$unixTime = strtotime($eventDate);
$votes = "0";
$timeStamp = date('Y-m-d H:i:s');
$unixTimeCreated = time();



header("Location: newHome.php");
?>