<?php 

session_start();

require_once 'serverLogin.php';
require_once 'sanitizeInput.php';

$studentID = $_SESSION['studentID'];


if(isset($_GET['getTotalSelected'])) {
	
	$returnSelected = $_GET['getTotalSelected'];
	if($returnSelected == "true") {
		
		$resultSelected = mysql_query("Select * from Student_Categories where studentID='$studentID'");
		$selected = mysql_fetch_row($resultSelected);
		$countSelected = 0;

		if($selected[1] != "") {
			$countSelected++;
		}
		if($selected[2] != "") {
			$countSelected++;
		}
		if($selected[3] != "") {
			$countSelected++;
		}
		if($selected[4] != "") {
			$countSelected++;
		}
		if($selected[5] != "") {
			$countSelected++;
		}
		echo $countSelected;
	}
}
else if(isset($_POST['eventCount'])) {
	$eventCount = $_POST['eventCount'];
	$getSettings = mysql_query("Update Student_Settings set categoryTotalEvents='$eventCount' where studentID = '$studentID'");
}
else {
	$updateArray = array();
	
	$number1 = urldecode($_POST['categorySelect1']);
	$number2 = urldecode($_POST['categorySelect2']);
	$number3 = urldecode($_POST['categorySelect3']);
	$number4 = urldecode($_POST['categorySelect4']);
	$number5 = urldecode($_POST['categorySelect5']);
	
	array_push($updateArray, $number1, $number2, $number3, $number4, $number5);
	
	if(substr($number1, 0, 6) == "remove") {
		$removeThis = mysql_result(mysql_query("Select category1 from Student_Categories where studentID='$studentID'"), 0);
		mysql_query("Update Student_Categories set category1='' where studentID='$studentID'");
		mysql_query("Delete from Student_Tags where studentID=$studentID and category='$removeThis'");
		setcookie("tabCookie", "AllEvents");
	}
	else {
		mysql_query("Update Student_Categories set category1='$number1' where studentID='$studentID'");
		mysql_query("Insert into Student_Tags values ('$studentID', '$number1', 'none')");
		setcookie("tabCookie", "AllEvents");
	}
	
	if(substr($number2, 0, 6) == "remove") {
		$removeThis = mysql_result(mysql_query("Select category2 from Student_Categories where studentID='$studentID'"), 0);
		mysql_query("Update Student_Categories set category2='' where studentID='$studentID'");
		mysql_query("Delete from Student_Tags where studentID=$studentID and category='$removeThis'");
		setcookie("tabCookie", "AllEvents");
	}
	else {
		mysql_query("Update Student_Categories set category2='$number2' where studentID='$studentID'");
		mysql_query("Insert into Student_Tags values ('$studentID', '$number2', 'none')");
		setcookie("tabCookie", "AllEvents");
	}
	
	if(substr($number3, 0, 6) == "remove") {
		$removeThis = mysql_result(mysql_query("Select category3 from Student_Categories where studentID='$studentID'"), 0);
		mysql_query("Update Student_Categories set category3='' where studentID='$studentID'");
		mysql_query("Delete from Student_Tags where studentID=$studentID and category='$removeThis'");
		setcookie("tabCookie", "AllEvents");
	}
	else {
		mysql_query("Update Student_Categories set category3='$number3' where studentID='$studentID'");
		mysql_query("Insert into Student_Tags values ('$studentID', '$number3', 'none')");
		setcookie("tabCookie", "AllEvents");
	}
	
	if(substr($number4, 0, 6) == "remove") {
		$removeThis = mysql_result(mysql_query("Select category4 from Student_Categories where studentID='$studentID'"), 0);
		mysql_query("Update Student_Categories set category4='' where studentID='$studentID'");
		mysql_query("Delete from Student_Tags where studentID=$studentID and category='$removeThis'");
		setcookie("tabCookie", "AllEvents");
	}
	else {
		mysql_query("Update Student_Categories set category4='$number4' where studentID='$studentID'");
		mysql_query("Insert into Student_Tags values ('$studentID', '$number4', 'none')");
		setcookie("tabCookie", "AllEvents");
	}
	
	if(substr($number5, 0, 6) == "remove") {
		$removeThis = mysql_result(mysql_query("Select category5 from Student_Categories where studentID='$studentID'"), 0);
		mysql_query("Update Student_Categories set category5='' where studentID='$studentID'");
		mysql_query("Delete from Student_Tags where studentID=$studentID and category='$removeThis'");
		setcookie("tabCookie", "AllEvents");
	}
	else {
		mysql_query("Update Student_Categories set category5='$number5' where studentID='$studentID'");
		mysql_query("Insert into Student_Tags values ('$studentID', '$number5', 'none')");
		setcookie("tabCookie", "AllEvents");
	}
	
	if(isset($_POST['eventCountHidden'])) {
		$eventCountHidden = $_POST['eventCountHidden'];
		$getSettings = mysql_query("Update Student_Settings set categoryTotalEvents='$eventCountHidden' where studentID = '$studentID'");
	}
	
	header("Location: ../newHome.php");
}
?>