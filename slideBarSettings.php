<?php 

session_start();

require_once 'serverlogin.php';
require_once 'sanitizeInput.php';

if(isset($_SESSION['studentID'])) {
	
	$studentID = sanitizeString($_SESSION['studentID']);
	$slideBar = sanitizeString($_GET['slideBar']);
	$updateSlideBar = sanitizeString($_GET['updateSlideBar']);
	
	if($slideBar == "actionFeed") {
		$queryActionFeed = "Select actionFeed from Student_Settings where studentID = '$studentID'";
		$resultActionFeed = mysql_query($queryActionFeed);
		$actionFeedStatus = mysql_result($resultActionFeed, 0);
		
		if($updateSlideBar == "no") {
			$queryUpdate = "Update Student_Settings set actionFeed='n' where studentID='$studentID'";
			$resultUpdate = mysql_query($queryUpdate);
		}
		else if($updateSlideBar == "yes") {
			$queryUpdate = "Update Student_Settings set actionFeed='y' where studentID='$studentID'";
			$resultUpdate = mysql_query($queryUpdate);
		}
		
		echo $actionFeedStatus;
	}
	
	if($slideBar == "categories") {
		$queryActionFeed = "Select Category from Student_Settings where studentID = '$studentID'";
		$resultActionFeed = mysql_query($queryActionFeed);
		$actionFeedStatus = mysql_result($resultActionFeed, 0);
	
		if($updateSlideBar == "no") {
			$queryUpdate = "Update Student_Settings set Category='n' where studentID='$studentID'";
			$resultUpdate = mysql_query($queryUpdate);
		}
		else if($updateSlideBar == "yes") {
			$queryUpdate = "Update Student_Settings set Category='y' where studentID='$studentID'";
			$resultUpdate = mysql_query($queryUpdate);
		}
	
		echo $actionFeedStatus;
	}
	
	if($slideBar == "attending") {
		$queryActionFeed = "Select Attending from Student_Settings where studentID = '$studentID'";
		$resultActionFeed = mysql_query($queryActionFeed);
		$actionFeedStatus = mysql_result($resultActionFeed, 0);
	
		if($updateSlideBar == "no") {
			$queryUpdate = "Update Student_Settings set Attending='n' where studentID='$studentID'";
			$resultUpdate = mysql_query($queryUpdate);
		}
		else if($updateSlideBar == "yes") {
			$queryUpdate = "Update Student_Settings set Attending='y' where studentID='$studentID'";
			$resultUpdate = mysql_query($queryUpdate);
		}
	
		echo $actionFeedStatus;
	}
	if($slideBar == "eventHistory") {
		$queryActionFeed = "Select eventHistory from Student_Settings where studentID = '$studentID'";
		$resultActionFeed = mysql_query($queryActionFeed);
		$actionFeedStatus = mysql_result($resultActionFeed, 0);
	
		if($updateSlideBar == "no") {
			$queryUpdate = "Update Student_Settings set eventHistory='n' where studentID='$studentID'";
			$resultUpdate = mysql_query($queryUpdate);
		}
		else if($updateSlideBar == "yes") {
			$queryUpdate = "Update Student_Settings set eventHistory='y' where studentID='$studentID'";
			$resultUpdate = mysql_query($queryUpdate);
		}
	
		echo $actionFeedStatus;
	}
	if($slideBar == "eventsCreated") {
		$queryActionFeed = "Select eventsCreated from Student_Settings where studentID = '$studentID'";
		$resultActionFeed = mysql_query($queryActionFeed);
		$actionFeedStatus = mysql_result($resultActionFeed, 0);
	
		if($updateSlideBar == "no") {
			$queryUpdate = "Update Student_Settings set eventsCreated='n' where studentID='$studentID'";
			$resultUpdate = mysql_query($queryUpdate);
		}
		else if($updateSlideBar == "yes") {
			$queryUpdate = "Update Student_Settings set eventsCreated='y' where studentID='$studentID'";
			$resultUpdate = mysql_query($queryUpdate);
		}
	
		echo $actionFeedStatus;
	}
}


?>