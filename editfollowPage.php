<?php 

session_start();

require_once 'serverLogin.php';
require_once 'objectProgramming.php';
require_once 'linkBar.php';

$studentID = $_SESSION['studentID'];
$firstName = $_SESSION['firstName'];
$lastName = $_SESSION['lastName'];
$object = new PHP_HTML($studentID, $fieldOfStudy, $firstName, $lastName);

echo <<<_END
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title>Campus Connect</title>
		<link type="text/css" rel="stylesheet" href="../HTML/CSS/index.css" />
		<link type="text/css" rel="stylesheet" href="../HTML/CSS/createfollowpage.css" />
		<style type="text/css">
			a:link {
				text-decoration: none;
			}
			a:visited {
				color: #000000;
				text-decoration: none;
			}
		</style>
		<script type="text/javascript" src="refresh.js"></script>
		<script type="text/javascript" src="../HTML/ckeditor/ckeditor.js"></script>
	</head>
<body>
<div id="main">
_END;

$object->header();
show_linkBar();

$eventInput = mysql_query("Select * from Group_Pages where studentID = '$studentID'");
$eventData = mysql_fetch_row($eventInput);

$groupID = $_GET['fp'];
$previousPage = $_GET['loc'];
echo <<<_END
<div id='boxMain'>
	<div id='followTitleContain'>$eventData[2]<span class='groupActionButton'><a href='followPage.php?fp=$groupID&loc=$previousPage'>Cancel Editing</a></span></div>
	<div id='formEditGroup'>
		<form action = "../HTML/process/processGroupPage.php" method="post">
_END;

		switch($previousPage) {
			case 'home':
				echoOtherFields('home', $eventData[2], $eventData[3], $eventData[4], $eventData[5], $eventData[6]);
				break;
			case 'photos':
				echoOtherFields('photos', $eventData[2], $eventData[3], $eventData[4], $eventData[5], $eventData[6]);
				break;
			case 'aboutus':
				echo <<<_END
				<div id='groupTypesOfEvents'>Type of Events<span class="basicRed">*</span>:</div>
					<input type='text' name='groupTypesOfEvents' maxlength='50' size='41' value='$eventData[3]' />
				<div id='groupAboutUs'>About Us<span class="basicRed">*</span>:</div>
					<textarea id='createAboutUsPage' name='groupAboutUs'>$eventData[4]</textarea>			
_END;
				echoOtherFields('aboutus', $eventData[2], '', '', $eventData[5], $eventData[6]);
				break;
			case 'contactus':
				echo <<<_END
				<div id='groupEmail'>Group Email<span class="basicRed">*</span>:</div>
					<input type='text' name='groupEmail' maxlength="50" size="41" value='$eventData[5]'/>
				<div id='groupPhone'>Group Phone Number:</div>
					<input type='text' name='groupPhoneNumber' maxlength='12' size='12' value='$eventData[6]'/>
_END;
				echoOtherFields('contactus', $eventData[2], $eventData[3], $eventData[4], '', '');
				break;
		}
echo <<<_END
			
_END;
		if(isset($_GET['edit'])) {
			$edit = $_GET['edit'];
			if($edit == "true") {
				echo <<<_END
				<div id='groupCreatePage'><input type='submit' value='Submit Changes'/></div>
				<input type='hidden' name='editFollowPage' value='true' />
				<input type='hidden' name='fp' value='$groupID' />
				<input type='hidden' name='loc' value='$previousPage' />
_END;
			}
		}
		else {
			echo "<div id='groupCreatePage'><input type='submit' value='Create Group Page'/></div>";
		}
		
		function echoOtherFields($notThisOne, $groupTitle, $groupTypeOfEvents, $groupAboutUs, $groupEmail, $groupPhone) {
			
			if($notThisOne == "home") {
				echo <<<_END
				<div id='organizerTitle'>Group Title<span class='basicRed'>*</span>:</div>
					<input type='text' name='groupTitle'  maxlength='50' size='41' value='$groupTitle'></input>
				<div id='groupTypesOfEvents'>Type of Events<span class="basicRed">*</span>:</div>
					<input type='text' name='groupTypesOfEvents' maxlength='50' size='41' value='$groupTypeOfEvents' />
				<div id='groupAboutUs'>About Us<span class="basicRed">*</span>:</div>
					<textarea id='createAboutUsPage' name='groupAboutUs'>$groupAboutUs</textarea>
				<div id='groupEmail'>Group Email<span class="basicRed">*</span>:</div>
					<input type='text' name='groupEmail' maxlength="50" size="41" value='$groupEmail'/>
				<div id='groupPhone'>Group Phone Number:</div>
					<input type='text' name='groupPhoneNumber' maxlength='12' size='12' value='$groupPhone'/>		
_END;
			}
			else if($notThisOne == "photos") {
				echo <<<_END
				<div id="organizerTitle">Group Title<span class="basicRed">*</span>:</div>
					<input type='text' name='groupTitle'  maxlength='50' size='41' value='$groupTitle'></input>
				<div id='groupTypesOfEvents'>Type of Events<span class="basicRed">*</span>:</div>
					<input type='text' name='groupTypesOfEvents' maxlength='50' size='41' value='$groupTypeOfEvents' />
				<div id='groupAboutUs'>About Us<span class="basicRed">*</span>:</div>
					<textarea id='createAboutUsPage' name='groupAboutUs'>$groupAboutUs</textarea>
				<div id='groupEmail'>Group Email<span class="basicRed">*</span>:</div>
					<input type='text' name='groupEmail' maxlength="50" size="41" value='$groupEmail'/>
				<div id='groupPhone'>Group Phone Number:</div>
					<input type='text' name='groupPhoneNumber' maxlength='12' size='12' value='$groupPhone'/>
_END;
			}
			else if($notThisOne == "aboutus"){
				echo <<<_END
				<div id="organizerTitle" class='addSpace'>Group Title<span class="basicRed">*</span>:</div>
					<input type='text' name='groupTitle'  maxlength='50' size='41' value='$groupTitle'></input>
				<div id='groupEmail'>Group Email<span class="basicRed">*</span>:</div>
					<input type='text' name='groupEmail' maxlength="50" size="41" value='$groupEmail'/>
				<div id='groupPhone'>Group Phone Number:</div>
					<input type='text' name='groupPhoneNumber' maxlength='12' size='12' value='$groupPhone'/>
_END;
			}
			else if($notThisOne == "contactus") {
				echo <<<_END
				<div id="organizerTitle" class='addSpace'>Group Title<span class="basicRed">*</span>:</div>
					<input type='text' name='groupTitle'  maxlength='50' size='41' value='$groupTitle'></input>
				<div id='groupTypesOfEvents'>Type of Events<span class="basicRed">*</span>:</div>
					<input type='text' name='groupTypesOfEvents' maxlength='50' size='41' value='$groupTypeOfEvents' />
				<div id='groupAboutUs'>About Us<span class="basicRed">*</span>:</div>
					<textarea id='createAboutUsPage' name='groupAboutUs'>$groupAboutUs</textarea>
_END;
			}
		}
echo <<<_END
		</form>
	</div><!--form-->
	<script>
		CKEDITOR.replace( 'createAboutUsPage' );
		CKEDITOR.config.width = 814;
		$(function() {
			$('#groupPage').css('background-color', 'rgb(225, 225, 225)');
		});
	</script>
</div><!--main-->
<div id="footer">
<div id="copyRight"><span id="copyRightSpan">Copyright &copy; 2013</span></div>
</body>
</html>
_END;

?>