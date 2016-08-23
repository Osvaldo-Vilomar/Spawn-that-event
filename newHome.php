<?php 

// Don't forget about the title for all pages
if($_SERVER['REQUEST_METHOD'] == "POST") header("Location: newHome.php");

session_start();

// when you first login set all values to y for preferred event categories
// if you need to register to the site, I'll program that. if not, we will have to preset it for all students.
require_once 'serverLogin.php';
require_once 'sanitizeInput.php';
require_once 'updateEventValue.php';

if(isset($_SESSION['firstName']) && isset($_SESSION['lastName']))
{
	require_once 'homeContent.php';
}
elseif(isset($_POST['username']) && isset($_POST['password']))
{
	$username = sanitizeString($_POST['username']);
	$password = sanitizeString($_POST['password']);
	
	$queryLogin = "Select * from Student_Authentication where username = '$username'";
	$resultLogin = mysql_query($queryLogin);
	
	if (!$resultLogin) die ("Database access failed: " . mysql_error());
	elseif (mysql_num_rows($resultLogin)) 
	{
		$rowLogin = mysql_fetch_row($resultLogin);
		$salt1 = "*!&97";
		$salt2 = "@51*!";
		$token = md5("$salt1$password$salt2");
		
		if($password == $rowLogin[4]) {
			$_SESSION['studentID'] = $rowLogin[0];
			$_SESSION['firstName'] = $rowLogin[1];
			$_SESSION['lastName'] = $rowLogin[2];
			
			$queryStudy = "Select FieldOfStudy from Student_Events where studentID = '$rowLogin[0]'";
			$resultStudy = mysql_query($queryStudy);
			
			$fieldOfStudy = mysql_result($resultStudy, 0);
			
			$_SESSION['fieldOfStudy'] = $fieldOfStudy;
			
			if(!isset($_COOKIE['groupID'])) {
				$queryGroupID = mysql_query("Select groupID, groupTitle from Group_Founder where studentID='$rowLogin[0]'");
				$groupID = mysql_result($queryGroupID, 0, 'groupID');
				
				if(!isset($groupID)) {
					$_SESSION['groupID'] = 'none';
				}
				else {
					$_SESSION['groupID'] = $groupID;
					
					$groupTitle = mysql_result($queryGroupID, 0, 'groupTitle');
					$_SESSION['groupTitle'] = $groupTitle;
				}
			}
		
			require_once 'homeContent.php';
		}
	}
}
else {
	header('Location: authentication.php');
}
?>