<?php

// Create event than log out, need to refresh
// Don't forget about the Title
include_once 'serverLogin.php';

echo <<<_END
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
		<head>
			<style>.signup { border: 1px solid #999999; font: normal 14px helvetica; color:#444444; }</style>
			<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
			<title>eventjacket</title>
			<link type="text/css" rel="stylesheet" href="../HTML/CSS/index.css" />
			<link type="text/css" rel="stylesheet" href="../HTML/CSS/authentication.css" />
			<script src="../HTML/scripts/jquery-1.9.1.min.js"></script>
		</head>
<body>
<div id='loginBottomBar'><div><span id='aboutUsLink'>About</span></div><div id='aboutUsShow'></div></div>
<script>
	$(function() {
		$('#aboutUsLink').click(function() {
			$('#aboutUsShow').slideToggle();
		});
	});
</script>
<div id="main">
	<div id="header">
		<div id="studentNameHeader">&nbsp;</div>
		<div id="name"><span id='logo'>eventjacket</span>	
			<div id="search">
			<form method="post" action="newhome.php" id='loginForm'>
				<div id='emailText'>
					<div>Email</div>
					<input type="text" maxlength="32" name="username" id='loginEmail'/>
				</div>
				<div id='passText'>
					<div>Password</div>
					<input type="password" maxlength="32" name="password" id='loginPass'/>
				</div>
				<div id='searchText'>
					<div>&nbsp</div>
					<div id="signinBox" onclick="document.getElementById('loginForm').submit();">Login</div>
				</div>
			</form>
			</div>
		<div id='bottomSpaceHeader'></div>
		</div>
	</div>
	<div id="boxMainLogin">
		<div id="box1Login">
			<div id='signUpTitle'>Sign up</div>
			<div id='signUpFName'>First Name<div><input type='textbox' size='41'/></div></div>
			<div id='signUpLName'>Last Name<div><input type='textbox' size='41'/></div></div>
			<div id='signUpEmail'>Email<div><input type='textbox' size='41'/></div></div>
			<div id='signUpStudying'>Studying
				<div>
					<select name='studyingValue'>
						<option value='businessStudy'>Business</option>
					</select>
				</div>
			</div>
			<div id='signUpCommunity'>Community
				<div>
					<select name='communityValue'>
						<option value='gaTech' selected='selected'>Georgia Institute of Technology</option>
					</select>
				</div>
			</div>
		</div>
		
		<div id="box2Login">
			<div id="populateEvents">Lorem Ipsum</div>	
		</div>
	</div>
</div><!--main-->
<div id="footer">
<div id="copyRight"><span id="copyRightSpan">Copyright &copy; 2013</span></div>
</div>
</body>
</html>
_END;

?>
