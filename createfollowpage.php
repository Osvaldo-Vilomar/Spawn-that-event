<?php

require_once 'objectProgramming.php';

session_start();

$studentID = $_SESSION['studentID'];
$fieldOfStudy = $_SESSION['fieldOfStudy'];
$firstName = $_SESSION['firstName'];
$lastName = $_SESSION['lastName'];
$object = new PHP_HTML($studentID, $fieldOfStudy, $firstName, $lastName);

echo <<<_END
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title>Campus Connect</title>
		<link rel="stylesheet" type="text/css" href="../HTML/CSS/index.css" />
		<link rel="stylesheet" type="text/css" href="../HTML/CSS/createfollowpage.css" />
		<link rel="stylesheet" type="text/css" href="../HTML/scripts/uploadify/uploadify.css" />
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
		<script src="../HTML/scripts/jquery-1.9.1.min.js"></script>
	</head>
<body>
<div id="main">
_END;

$object->header();
$object->linksNav();

$timestamp = time();
$md5 = md5('unique_salt' . $timestamp);

echo <<<_END
<div id='boxMain'>
	<div id='form'>
		<div id='requiredField'><span class='basicRed'>*</span>&nbsp;Required Fields</div>
		<form action = "../HTML/process/processGroupPage.php" method="post">
			<div id="organizerTitle">Group Title<span class="basicRed">*</span>:</div>
				<input type='text' name='groupTitle'  maxlength='50' size='41'></input>
			<div id='groupTypesOfEvents'>Type of Events<span class="basicRed">*</span>:</div>
			<input type='text' name='groupTypesOfEvents' maxlength='50' size='41' placeholder='e.g. social, entertaining, etc.' />
			<script type="text/javascript" src="../HTML/scripts/uploadify/jquery.uploadify.min.js"></script>
			<div class='uploadCSS'><input type='file' name='images_upload' id='imagesUpload' /></div>
			<script>
				$(function() {
					 $('#imagesUpload').uploadify({
					 	'formData'     : {
							'timestamp' : '$timestamp',
							'token'     : '$md5'
						},
				        'swf'      : '../HTML/scripts/uploadify/uploadify.swf',
				        'uploader' : '../HTML/scripts/uploadify/uploadify.php'
				        // Put your options here
				    }); 
				});
			</script>
			<div id='groupAboutUs'>About Us<span class="basicRed">*</span>:</div>
				<textarea id='createAboutUsPage' name='groupAboutUs'></textarea>
			<div id='groupEmail'>Group Email<span class="basicRed">*</span>:</div>
				<input typee='text' name='groupEmail' maxlength="50" size="41" />
			<div id='groupPhone'>Group Phone Number:</div>
				<input typee='text' name='groupPhoneNumber' maxlength='12' size='12' />
			<div id='groupCreatePage'><input type="submit" value="Create Group Page"/></div>
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