<?php

	session_start();
	
	require_once 'serverLogin.php';
	require_once 'sanitizeInput.php';
	
	$studentID = $_SESSION['studentID'];
	$getTags = $_GET['getTags'];
	$tagCategory = urldecode($_GET['tagCategory']);
	
	$allTags = array();
	if($getTags == 'createEvent') {
		$resultTags = mysql_query("Select tag from AvailableTags where category='$tagCategory' order by tag ASC");
		$tagsRows = mysql_num_rows($resultTags);

		for($j = 0; $j < $tagsRows; $j++) {
			$tag = mysql_result($resultTags, $j);
			array_push($allTags, $tag);
		}
		
		echo json_encode($allTags);
	}
	
	if(isset($_GET['category']) && isset($_GET['getTags'])) {
		
		if($_GET['getTags'] == true) {
			$tagCategory = $_GET['category'];
			
			$resultUserTags = mysql_query("Select tag from Student_Tags where studentID = '$studentID' and category='$tagCategory'");
			$userTag = mysql_result($resultUserTags, 0);
			
			echo $userTag;
		}
	}
	
	if(isset($_POST['updateCategory']) && isset($_POST['updateTag'])) {
		
		$tagCategory = $_POST['updateCategory'];
		$tagSelect = $_POST['updateTag'];
		
		$updateTag = mysql_query("Update Student_Tags set tag = '$tagSelect' where studentID='$studentID' and category='$tagCategory'");
	}
?>