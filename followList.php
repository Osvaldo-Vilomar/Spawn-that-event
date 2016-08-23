<?php 

session_start();

require_once 'serverLogin.php';
require_once 'objectProgramming.php';

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
		<link type="text/css" rel="stylesheet" href="../HTML/CSS/index.css" />
		<style type="text/css">
			a:link {
				text-decoration: none;
			}
			a:visited {
				color: #000000;
				text-decoration: none;
			}
			
			#follow {
				background-color: rgb(225, 225, 225);
			}
		</style>
		<link type="text/css" rel="stylesheet" href="../HTML/CSS/followList.css" />
		<script src="../HTML/scripts/jquery-1.9.1.min.js"></script>
		<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
	</head>
<body>
<div id="main">
_END;

$object->header();
$object->linksNav();

$followingAndCreated = array();

echo <<<_END
<div id="boxMain">
	<div id='searchBox'>
_END;
	
$object->allCategories();

echo <<<_END
		<div id='groupSearchContain'>
			<div id='groupFollowContain'>
				<div id='searchDescription'>Search Group</div>
				<div id='searchField'>
					<input type='text' size='50'/>
				</div>
			</div>
		</div>
	</div>
	<div id='groupContain'>
		<div id='followingContain'>
			<div id='followingContainTitle'>Groups You're Following</div>
			<div id='followingContainContent'>
_END;
			$getUserFollowing = mysql_query("Select groupID, groupTitle from Group_Following where studentID='$studentID' order by groupTitle ASC");
			$userFollowing = mysql_num_rows($getUserFollowing);
			
			if($userFollowing == false) {
				echo "<div class='eachGroup'>You aren't following any groups.</div>";
			}
			else {
				for($j = 0; $j < $userFollowing; $j++) {
					$thisGroupID = mysql_result($getUserFollowing, $j, 'groupID');
					array_push($followingAndCreated, $thisGroupID);
					$thisGroupTitle = mysql_result($getUserFollowing, $j, 'groupTitle');
					echo "<div id='divFollowing$thisGroupID' class='eachGroup'><span id='groupFollowingID$thisGroupID' class='type1Link'><a href='followPage.php?fp=$thisGroupID&loc=home'>$thisGroupTitle</a></span><span id='thisFollowX$thisGroupID' class='followingX'>X</span></div>";
				}
				echo "<input type='hidden' id='totalGroupsFollowing' value='$userFollowing'/>";
			}
			
echo <<<_END
			</div>
			<script>
				$(function() {
					var groupID;
					var groupTitle;
					var removeItems = 0;
					var totalRemoved = 0;
					var appendRemove = true;
					var removeList = new Array();
					
					$('#followingContainContent').delegate('span[id^="thisFollowX"]', 'click', function() {
						groupID = parseInt($(this).attr('id').match(/\d+/));
						if($(this).data('followStatus') == 'unfollow') {
							$('#divFollowing' + groupID).css({
								'border' : 'none',
								'background-color' : 'white',
								'margin' : '0px 3px'
							});
							$(this).css('color', '');
							groupTitle = $('#groupFollowingID' + groupID).text();
							$(this).data('followStatus', 'follow');
							removeItems--;
							totalRemoved--;
							removeList.splice(jQuery.inArray(groupID, removeList), 1);
							if(removeItems == 0) {
								$('#removeTheseGroups').remove();
								appendRemove = true;
							}
							console.log('true');
						}
						else {
							$('#divFollowing' + groupID).css({
								'border' : '1px solid red',
								'background-color' : 'rgba(255, 0, 0, .03)',
								'margin' : '3px 3px'
							});
							$(this).css('color', 'red');
							$(this).data('followStatus', 'unfollow');
							removeItems++;
							totalRemoved++;
							removeList.push(groupID);
							if(appendRemove == true) {
								$('#followingContainContent').append("<div id='removeTheseGroups' class='removeTheseGroups'>You're positive you would like to remove <span id='totalRemoveGroups' class='underlineGreen'>" + removeItems + "</span> item(s) [ <span id='positiveRemoveGroups' class='red type1Link'>Remove</span> ].</div>");
								appendRemove = false;
							}	
							console.log('false');					
						}		
						returnTotalRemove(removeItems);
					});
					
					var totalGroupsFollowing = $('#totalGroupsFollowing').attr('value');
					$('#followingContainContent').delegate('#positiveRemoveGroups', 'click', function() {
						$.post('../HTML/process/processGroupPage.php', {'removeTheseGroups': 'true', 'values': removeList }, function() {
							$('#removeTheseGroups').remove();
							if($('.youJustRemoved').length == false) {
								$('#followingContainContent').prepend("<div class='youJustRemoved'>Removed [<span id='totalRemovedNumber' class='green'>" + removeItems + "</span>] item(s).</div>");
							}
							else {
								$('#totalRemovedNumber').text(removeItems);
							}
							
							if(totalRemoved == totalGroupsFollowing) {
								$('#followingContainContent').append("<div class='eachGroup'>You aren't following any groups.</div>");
							}
							
							for(id in removeList) {
								$('#divFollowing' + removeList[id]).remove();
								// $('#groupFollowContent').prepend("");
							}
							appendRemove = true;
							removeItems = 0;
						});
					});
					
					function returnTotalRemove(totalRemove) {
						$('#totalRemoveGroups').text(totalRemove);
					}
				});
			</script>
_END;
			$userGroupCreator = mysql_query("Select groupID, groupTitle from Group_Founder where studentID='$studentID' and groupExists='y'");
			$valueExists = mysql_num_rows($userGroupCreator);
			$groupCreaterID = mysql_result($userGroupCreator, 0, 'groupID');
			$groupCreaterTitle = mysql_result($userGroupCreator, 0, 'groupTitle');
			array_push($followingAndCreated, $groupCreaterID);
			if($valueExists != false) {
				echo <<<_END
				<div id='yourGroupsBox'>
					<div id='yourGroupsTitle'>Created Group</div>
					<div id='yourGroupsContainContent'>
						<div class='eachGroup'><span class='type1Link'><a href='followPage.php?fp=$groupCreaterID&loc=home'>$groupCreaterTitle</a></span></div>
					</div>
				</div>
_END;
			}			
echo <<<_END
		</div>
		<div id='groupFollowContain'>
			<div id='groupFollowTitle'>Groups You Can Follow</div>	
				<div id='groupFollowContent'>		
_END;
				sort($followingAndCreated);
				$notThisID = join(',', $followingAndCreated);
				//fp stands for: follow page, loc: location
				$getGroups = mysql_query("Select groupID, groupTitle from Groups_Available where groupID NOT IN ($notThisID)");
				$groupsRows = mysql_num_Rows($getGroups);
				if($groupsRows == false) {
					echo "<div class='eachGroup'>No available groups.</div>";
				}
				else {
					for($j = 0; $j < $groupsRows; $j++) {
						$groupID = mysql_result($getGroups, $j, 'groupID');
						$groupTitle = mysql_result($getGroups, $j, 'groupTitle');
						echo "<div class='eachGroup'><span id='groupID$groupID' class='type1Link'><a href='followPage.php?fp=$groupID&loc=home'>$groupTitle</a></span></div>";
					}
				}
echo <<<_END
			</div>
		</div>
	</div>
<script>
	$(function() {
		var thisID;
		var followID;
		$('span[id^="groupID"]').click(function() {
			thisID = $(this).attr('id');
			followID = thisID.match(/\d+/);
			$('#followID').attr('value', followID);
		});
	});
</script>
</div><!--boxMain-->
</div><!--main-->	
<div id="footer">Copyright &copy; 2013</div>
</body>
</html>
_END;

mysql_close($db_server);

?>