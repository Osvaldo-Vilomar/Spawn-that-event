<?php 

// sanitize post
session_start();

require_once 'serverLogin.php';

if(isset($_POST['value']) &&
	isset($_POST['eventID']) &&
	isset($_SESSION['studentID'])) {
	
	$studentID = $_SESSION['studentID'];
	$value = $_POST['value'];
	$eventID = $_POST['eventID'];

	if($value == "call") {
		$queryHasVoted = "Select * from Student_Votes where studentID = '$studentID' and eventID='$eventID'";
		$resultHasVoted = mysql_query($queryHasVoted);
		if(!$resultHasVoted) die ("Database access failed(retreive has voted): " . mysql_error());
	
		if(mysql_num_rows($resultHasVoted) == 0) {
			
			$queryVote = "Insert INTO Student_Votes VALUES('$eventID', '$studentID', 'y')";
			$resultVote = mysql_query($queryVote);
			
			$queryUpdateVotes = "Update Made_Events set Votes = Votes + 1 where id='$eventID'";
			$resultUpdateVotes = mysql_query($queryUpdateVotes);
			
			echo "validate";
		}
	}
}

?>