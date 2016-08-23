<?php

session_start();

require_once 'serverLogin.php';
require_once 'sanitizeInput.php';
require_once 'objectProgramming.php';

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
		<link rel="stylesheet" type="text/css" href="../HTML/CSS/index.css" />
		<link rel="stylesheet" type="text/css" href="../HTML/CSS/followPage.css" />
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
		<link rel="stylesheet" type="text/css" href="http://localhost/CampusConnect/HTML/ADGallery/lib/jquery.ad-gallery.css">
		<script src="../HTML/scripts/jquery-1.9.1.min.js"></script>
		<script type="text/javascript" src="http://localhost/CampusConnect/HTML/ADGallery/lib/jquery.ad-gallery.js"></script>
		<script type="text/javascript">
		$(function() {
		    var galleries = $('.ad-gallery').adGallery();
		});
	  	</script>
	</head>
<body>
<div id="main">
_END;

$object->header();
$object->linksNav();

$groupID = sanitizeString($_GET['fp']);
$location = sanitizeString($_GET['loc']);

$resultGroup = mysql_query("Select * from Group_Pages where groupID='$groupID'");
$groupPage = mysql_fetch_row($resultGroup);

$resultUserFollowing = mysql_query("Select studentID from Group_Following where studentID='$studentID' and groupID='$groupID'");
$userFollowing = mysql_fetch_row($resultUserFollowing);

$replaceCharacter = array(" ", "&", "-", "amp;");

// more efficient to assign a variable to the row values?
echo <<<_END
<div id='boxMain'>
_END;

function followUnfollow($userType, $groupTitle, $groupID, $pageType) {

	if($userType == "groupOwner") {
		echo "<div id='followTitleContain'>$groupTitle<span id='followEditAboutUs'class='groupActionButton'><a href='editfollowPage.php?fp=$groupID&loc=$pageType&edit=true'>Edit</a></span></div>";
	}
	else if($userType == "userIsNotFollowing") {
		echo "<div id='followTitleContain'>$groupTitle<span id='followThisStatus' class='groupActionButton'><span class='green'>Follow</span></span></div>";
	}
	else if($userType == "userIsFollowing") {
		echo "<div id='followTitleContain'>$groupTitle<span id='followThisStatus' class='groupActionButton'><span class='brickRed'>Unfollow</span></span></div>";
	}
}

if($location == "home") {
	if($studentID == $groupPage[1]) {
		followUnfollow('groupOwner', $groupPage[2], $groupPage[0], 'home');
	}
	else {
		if($userFollowing == false) {
			followUnfollow('userIsNotFollowing', $groupPage[2], $groupPage[0]);
		}
		else {
			followUnfollow('userIsFollowing', $groupPage[2], $groupPage[0]);
		}
	}
}
else if($location == "aboutus"){
	if($studentID == $groupPage[1]) {
		followUnfollow('groupOwner', $groupPage[2], $groupPage[0], 'aboutus');
	}
	else {
		if($userFollowing == false) {
			followUnfollow('userIsNotFollowing', $groupPage[2], $groupPage[0]);
		}
		else {
			followUnfollow('userIsFollowing', $groupPage[2], $groupPage[0]);
		}
	}
}
else if($location == "photos") {
	if($studentID == $groupPage[1]) {
		followUnfollow('groupOwner', $groupPage[2], $groupPage[0], 'photos');
	}
	else {
		if($userFollowing == false) {
			followUnfollow('userIsNotFollowing', $groupPage[2], $groupPage[0]);
		}
		else {
			followUnfollow('userIsFollowing', $groupPage[2], $groupPage[0]);
		}
	}
}
else if($location == "contactus") {
	if($studentID == $groupPage[1]) {
		followUnfollow('groupOwner', $groupPage[2], $groupPage[0], 'contactus');
	}
	else {
		if($userFollowing == false) {
			followUnfollow('userIsNotFollowing', $groupPage[2], $groupPage[0]);
		}
		else {
			followUnfollow('userIsFollowing', $groupPage[2], $groupPage[0]);
		}
	}
}

echo <<<_END
<div id='followContentContain'>
	<div id='followContent' class='clearfix'>
_END;

	$currentDate = strtotime(date('Y/m/d'));
	
	$groupEventArray = array();
	$eventTypesArray = array();
	$thisFounder = $groupPage[1];
	$resultGroupEventIDs = mysql_query("Select eventID, eventType from Group_Events where studentID='$thisFounder' and eventDateUnix >= '$currentDate'");
	$groupEventsRowsID = mysql_num_rows($resultGroupEventIDs);
	
	$getUserAttending = mysql_query("Select eventID from Event_Attendee where studentID='$studentID' and eventDateUnix >= '$currentDate'");
	$userAttendingRows = mysql_num_rows($getUserAttending);
	$userAttendingArray = array();
	
	for($j = 0; $j < $userAttendingRows; $j++) {
		$userAttending = mysql_result($getUserAttending, $j);
		array_push($userAttendingArray, $userAttending);
	}
	
	for($j = 0; $j < $groupEventsRowsID; $j++) {
		// to get all group events from made events with the corresponding eventIDs
		$groupEventIDs = mysql_result($resultGroupEventIDs, $j, 'eventID');
		
		if(in_array($groupEventIDs, $userAttendingArray) == false) {
			array_push($groupEventArray, $groupEventIDs);
		}

		// for the event type nav bar
		$groupEventType = mysql_result($resultGroupEventIDs, $j, 'eventType');
		if(in_array($groupEventType, $eventTypesArray)  == false) {
			array_push($eventTypesArray, $groupEventType);
		}
	}
	
	if($location == "home") {
	
echo <<<_END
		<div id='followHome'>
			<div id='followEventsContain'>
			<div id='followRightContentContain'>
				<div id='followMapBox'>
					<div id='followMapTitle'>Map</div>
					<div id='followMapShow'>Map Show Here</div>
				</div>
				<div id='followUserAttendingBox'>
					<div id='followUserAttendingTitle'>What you're attending</div>
_END;
					$showStatus = mysql_query("Select groupAttending, groupHistory from Student_Settings where studentID='$studentID'");
					$groupAttendingShow = mysql_result($showStatus, 0, 'groupAttending');
					
					if($groupAttendingShow == 'y') {
						echo "<div id='followUserAttendingContent'>";
					}
					else {
						echo "<div id='followUserAttendingContent' class='loadHide'>";
					}

					$getUserAttending = mysql_query("Select * from Event_Attendee where studentID='$studentID' and eventDateUnix >= '$currentDate' order by attending DESC, eventDateUnix ASC");
					$userAttendingRows = mysql_num_rows($getUserAttending);
					
					if($userAttendingRows == false) {
						echo "<div id='groupAttendingNoEvents' class='followAttendingRow'>You aren't attending any events.</div>";
					}
					else {
						for($j = 0; $j < $userAttendingRows; $j++) {
							$eventRow = mysql_fetch_row($getUserAttending);
							$eventDate = date('D. M. j, y', $eventRow[8]);
							echo "<div id='groupUserAttending'>";
							if($eventRow[6] == "yes") {
								echo "<div id='followAttendingEventID$eventRow[4]' class='followAttendingRow'><span id='followAttendingEventSpan$eventRow[4]'>$eventRow[5]</span></div>";
								echo "<div id='eventAllDetails$eventRow[4]'>";
							}
							else {
								echo "<div id='followAttendingEventID$eventRow[4]' class='followAttendingRow'><span id='followAttendingEventSpan$eventRow[4]' class='type1Link'>$eventRow[5]</span><span id='notAttendingID$eventRow[4]' class='brickRedFont'>&nbsp;[Not Attending]</span></div>";
								echo "<div id='eventAllDetails$eventRow[4]' class='loadHide'>";
							}
							echo <<<_END
										<div class='followingAttendingDTL'>$eventDate | $eventRow[12] - $eventRow[13] | $eventRow[10]</div>
										<div class='followingAttendingDetails'><span id='followingAttendingDetailsID$eventRow[4]' class='attendDetailsSpan'>Details</span></div>
											<div id='followAttendingDetailsContent$eventRow[4]' class='loadHide'>	
												<div class='followingAttendingDetailsContent'>$eventRow[11]</div>
												<div class='followingAttendingDetailsContent'>$eventRow[14], $eventRow[15]</div>
												<div class='followingAttendingDetailsContent'><span id='followEventNotAttending$eventRow[4]' class='followingNotAttendingBox'>Not Attending</span></div>										
											</div>
										<div id='detailsBottomBar$eventRow[4]'></div>
									</div>
								</div>
						
_END;
						}
					}
echo <<<_END
								<script>
							$(function() {
								var thisID;
								var detailsID;
								var groupAttendID = '#followUserAttendingContent';
								var groupAttendClass = $(groupAttendID).attr('class');;
								if(typeof groupAttendClass === 'undefined') {
									$(groupAttendID).data("show", "on");
								}
								else {
									$(groupAttendID).data("show", "off");
								}
								
								<!--click group attending title to show/hide event attending content-->
								$('#followUserAttendingTitle').click(function() {
									$('#followUserAttendingContent').slideToggle();
									if($(groupAttendID).data("show") == "on") {
										$.post('../HTML/process/processGroupPage.php', 'updateGroupBar=true&groupBar=groupAttending&value=n');
										$(groupAttendID).data("show", "off");
									}
									else {
										$.post('../HTML/process/processGroupPage.php', 'updateGroupBar=true&groupBar=groupAttending&value=y');
										$(groupAttendID).data("show", "on");
									}
								});
								
								<!--click details on attending-->
								$('#followUserAttendingContent').delegate('span[id^="followingAttendingDetailsID"]', 'click', function() {
									thisID = $(this).attr('id');
									detailsID = thisID.match(/\d+/);
									if($(this).data("status") == "show") {
										$(this).css('text-decoration', '');
										$('#followAttendingEventID' + detailsID).css({
											'border-top' : '',
											'margin-top' : ''
										});
										$('#detailsBottomBar' + detailsID).css({
											'border-top' : '',
											'margin-top' : ''
										});
										$(this).data("status", "hide");
									}
									else {
										$(this).css('text-decoration', 'underline');
										$('#followAttendingEventID' + detailsID).css({
											'border-top' : '1px solid #CDCDCD',
											'margin-top' : '3px'
										});
										$('#detailsBottomBar' + detailsID).css({
											'border-top' : '1px solid #CDCDCD',
											'margin-top' : '8px'
										});
										$(this).data("status", "show");
									}
									$('#followAttendingDetailsContent' + detailsID).toggle();
									$('#followAttendingDetailsContent' + detailsID).css('background-color', 'rgb(245, 245, 245)');
								});
								
								<!--click not attending-->
								$('#followUserAttendingContent').delegate('span[id^="followEventNotAttending"]', 'click', function() {
									thisID = $(this).attr('id');
									detailsID = thisID.match(/\d+/);
									$.post('../HTML/process/processNotAttending.php', 'eventID=' + detailsID + '&attending=no', function() {
										$('#eventAllDetails' + detailsID).hide();
										$('#followAttendingEventID' + detailsID).append("<span id='notAttendingID" + detailsID + "' class='brickRedFont'>&nbsp;[Not Attending]</span>");
										$('#followAttendingDetailsContent' + detailsID).hide();
										$('#followingAttendingDetailsID' + detailsID).css('text-decoration', '');
										$('#followAttendingEventID' + detailsID).css({
											'border-top' : '',
											'margin-top' : ''
										});
										$('#detailsBottomBar' + detailsID).css({
											'border-top' : '',
											'margin-top' : ''
										});
										$('#followingAttendingDetailsID' + detailsID).data("status", "hide");
										$('#followAttendingEventSpan' + detailsID).addClass('type1Link');
									});
								});
								
								<!--click event name to undo not attending-->
								$('#followUserAttendingContent').delegate('span[id^="followAttendingEventSpan"]', 'click', function() {
									thisID = $(this).attr('id');
									detailsID = thisID.match(/\d+/);
									if($('#notAttendingID' + detailsID).length) {
										$.post('../HTML/process/processNotAttending.php', 'eventID=' + detailsID + '&attending=yes', function() {
											$('#notAttendingID' + detailsID).remove();
											$('#followAttendingEventSpan' + detailsID).removeClass();
											$('#eventAllDetails' + detailsID).show();
										});
									}
								});
							});
						</script>
								</div><!--eventID-->
				</div>
				<div id='thisGroupEventHistoryBox'>
					<div id='thisGroupEventHistoryTitle'>$groupPage[2] Event History</div>
_END;
					$groupHistoryShow = mysql_result($showStatus, 0, 'groupHistory');
					// some times server value is 'n' and it loads as 'y', what's the problem!?
					if($groupHistoryShow == 'n') {
						echo "<div id='thisGroupEventHistoryContent' class='loadHide'>";
					}
					else {
						echo "<div id='thisGroupEventHistoryContent'>";
					}

					$getGroupEventHistory = mysql_query("Select eventID from Group_Events where studentID='$groupPage[1]' and eventDateUnix < $currentDate");
					$groupEventHistoryRows = mysql_num_rows($getGroupEventHistory);
					$groupEventHistoryArray = array();
					
					for($j = 0; $j < $groupEventHistoryRows; $j++) {
						$groupEventHistoryID = mysql_result($getGroupEventHistory, $j);
						array_push($groupEventHistoryArray, $groupEventHistoryID);
					}
					
					$historyEventIDs =  join(',', $groupEventHistoryArray);
					
					$getHistoryEvents = mysql_query("Select * from Made_Events where id in ($historyEventIDs) LIMIT 10");
					$historyEventsRows = mysql_num_rows($getHistoryEvents);
					
					if($historyEventsRows == false) {
						echo "<div class='followAttendingRow'>No Event History.</div>";
					}
					else {
						for($j = 0; $j < $historyEventsRows; $j++) {
							$groupHistoryEvent = mysql_fetch_row($getHistoryEvents);
							$eventDate = date('D. M. j, y', $groupHistoryEvent[12]);
							// change the name of followAttendingRow[class] below in the future to avoid confusion
							echo <<<_END
						<div id='groupUserAttending$groupHistoryEvent[0]'>
							<div id='followEventHistoryID$groupHistoryEvent[0]' class='followAttendingRow'><span id='groupEventHistoryID$groupHistoryEvent[0]' class='type1Link'>$groupHistoryEvent[2]</span></div>
								<div id='followEventHistoryContent$groupHistoryEvent[0]' class='loadHide'>
									<div class='followingAttendingDTL'>$eventDate | $groupHistoryEvent[7] - $groupHistoryEvent[8] | $groupHistoryEvent[4]</div>
									<div class='followingAttendingDetailsContent'>$groupHistoryEvent[5]</div>
									<div class='followingAttendingDetailsContent'>$groupHistoryEvent[9], $groupHistoryEvent[10]</div>
								</div>
						<div id='groupEventHistoryBottomBar$groupHistoryEvent[0]'></div>
						</div>
_END;
						}
						echo <<<_END
						<script>
							$(function() {
								var thisID;
								var detailsID;
								$('span[id^="groupEventHistoryID"]').click(function() {
									thisID = $(this).attr('id');
									detailsID = thisID.match(/\d+/);
									if($(this).data("show") == "yes") {
										$(this).css('text-decoration', '');
										$('#followEventHistoryID' + detailsID).css({
											'border-top' : '',
											'margin-top' : ''
										});
										$('#groupEventHistoryBottomBar' + detailsID).css({
											'border-top' : '',
											'margin-top' : ''
										});
										$('#groupUserAttending' + detailsID).css('background-color', '');
										$(this).data("show", "no");
									}
									else {
										$(this).data("show", "yes");
										$(this).css('text-decoration', 'underline');
										$('#followEventHistoryID' + detailsID).css({
											'border-top' : '1px solid #CDCDCD',
											'margin-top' : '3px'
										});
										$('#groupEventHistoryBottomBar' + detailsID).css({
											'border-top' : '1px solid #CDCDCD',
											'margin-top' : '8px'
										});
										$('#groupUserAttending' + detailsID).css('background-color', 'rgb(250, 250, 250)');
										$(this).data("status", "show");
									}
									$('#followEventHistoryContent' + detailsID).toggle();
								});
							});
						</script>
_END;
					}
echo <<<_END
					</div>
				</div>
				<script>
					$(function() {
						
						var groupEventHistoryID = '#thisGroupEventHistoryContent';
						var groupEventHistoryClass = $(groupEventHistoryID).attr('class');
						if(typeof groupEventHistoryClass !== 'undefined') {
							
							$(groupEventHistoryID).data("show", "off");
						}
						else {
							
							$(groupEventHistoryID).data("show", "on");
						}
						$('#thisGroupEventHistoryTitle').click(function() {
							$('#thisGroupEventHistoryContent').slideToggle();
							if($(groupEventHistoryID).data("show") == "off") {
								$.post('../HTML/process/processGroupPage.php', 'updateGroupBar=true&groupBar=groupHistory&value=y');
								$(groupEventHistoryID).data("show", "on");
							}
							else {
								$.post('../HTML/process/processGroupPage.php', 'updateGroupBar=true&groupBar=groupHistory&value=n');
								$(groupEventHistoryID).data("show", "off");
							}
						});
					});
				</script>
				
			</div><!--followRightContentContain-->
			<div id='followEventsTitle'>Events</div>
_END;
				
				$eventIDs = join(',', $groupEventArray);
				$resultEvent = mysql_query("Select * from Made_Events where id in ($eventIDs) LIMIT 5");
				$eventRows = mysql_num_rows($resultEvent);
				
				for($j = 0; $j < $eventRows; $j++) {
					$groupEvent = mysql_fetch_row($resultEvent);
					$eventDate = date('D. M. j, y', $groupEvent[12]);
					$thisEventType = str_replace($replaceCharacter, "", $groupEvent[3]);
					echo <<<_END
					<div id='thisGroupEventContain$groupEvent[0]' class='type$thisEventType followPageEvent'>
						<div><span id='groupEventTitle$groupEvent[0]' class='type1Link'>$groupEvent[2]</span>&nbsp;<span id='groupAttendButtonID$groupEvent[0]' class='followingAttendButton'>Attend</span></div>
						<div class='followPageEventDTL'><span id='groupDateID$groupEvent[0]'>$eventDate</span> | <span id='groupStartTimeID$groupEvent[0]'>$groupEvent[7]</span> - <span id='groupStopTimeID$groupEvent[0]'>$groupEvent[8]</span> | <span id='groupLocationID$groupEvent[0]'>$groupEvent[4]</span></div>
						<div id='groupEventDetailsID$groupEvent[0]' class='followPageEventDetails loadHide'>
							<div class='groupEventDetails'><span id='groupEventShortDescription$groupEvent[0]'>$groupEvent[5]</span></div>
							<div class='groupEventDetails'><span id='groupEventContactName$groupEvent[0]'>$groupEvent[9]</span>, <span id='groupEventEmail$groupEvent[0]'>$groupEvent[10]</span></div>
_END;
					if($groupEvent[11] != "") {
						echo "<div class='groupEventDetails'>Type: <span id='groupEventType$groupEvent[0]'>$groupEvent[3]</span>,&nbsp;Sponsor: <span id='groupEventSponsorID$groupEvent[0]'>$groupEvent[11]</span></div>";
					}
					else {
						echo "<div class='groupEventDetails'>Type: <span id='groupEventType$groupEvent[0]'>$groupEvent[3]</span><span id='groupEventSponsorID'></span></div>";
					}
					echo <<<_END
						</div>
					</div>
_END;
				}
				
				if(isset($_GET['lc'])) {
					$loadEventView = $_GET['lc'];
				}

		echo <<<_END
			<div class='followBottomSpace'></div>
			</div>
		</div><!--home-->
		<script type="text/javascript" src="../HTML/scripts/groupAttendClick.js"></script>
		<script>
			$(function() {
				var thisID;
				var thisNumber;
				var thisDetails
				$('span[id^="groupEventTitle"]').click(function() {
					thisID = $(this).attr('id');
					thisNumber = thisID.match(/\d+/);
					thisDetails = '#groupEventDetailsID' + thisNumber;
					$(thisDetails).slideToggle(450);
				});
				
				var previousClick;
				var eventType;
				$('span[id^="navType"]').click(function() {
					thisID = $(this).attr('id');
					eventType = thisID.substring(7);
					if(previousClick == thisID) {
						$('span[id^="navType"]').css('text-decoration', '');
						$('div[class^="type"]').show();
						$('#navTypeall').css('text-decoration', 'underline');
						previousClick = '';
					}
					else {
						$('span[id^="navType"]').css('text-decoration', '');
						if(eventType == "all") {
							$('div[class^="type"]').show();
						}
						else {	
							$('div[class^="type"]').hide();
							$('.type' + eventType).show();
						}
						$(this).css('text-decoration', 'underline');
						previousClick = thisID;
					}
				});
				
				var loadEventView = '$loadEventView';
				if(loadEventView != "") {
					if(loadEventView == "All") {
						$('div[class^="type"]').show();
						$('#navTypeall').css('text-decoration', 'underline');
					}
					else {
						$('div[class^="type"]').hide();
						$('.type' + loadEventView).show();
						$('#navType' + loadEventView).css('text-decoration', 'underline');
					}
					previousClick = 'navType' + loadEventView;
				}
				else {
					<!--default underline on default page load-->
					$('#navTypeall').css('text-decoration', 'underline');
				}
				
				var followStatus = $('#followThisStatus').text();
				var groupTitle = encodeURIComponent('$groupPage[2]');
				$('#followThisStatus').click(function() {
					if(followStatus == 'Follow') {
						$(this).text('Unfollow');
						if($('#followGreen').length) {
							$('#followGreen').remove();
							$('#followThisStatus').wrapInner("<span id='followRed' class='brickRed' />");
						}
						else {
							$('#followThisStatus').wrapInner("<span id='followRed' class='brickRed' />");
						}
						$.post('../HTML/process/processGroupPage.php', 'updateFollow=true&action=follow&groupID=$groupID&groupTitle=' + groupTitle);
						followStatus = 'UnFollow';
					}
					else {
						$(this).text('Follow');
						if($('#followRed').length) {
							$('#followRed').remove();
							$('#followThisStatus').wrapInner("<span id='followGreen' class='green' />");
						}
						else {
							$('#followThisStatus').wrapInner("<span id='followGreen' class='green' />");
						}
						$.post('../HTML/process/processGroupPage.php', 'updateFollow=true&action=unfollow&groupID=$groupID&groupTitle=' + groupTitle);
						followStatus = 'Follow';
					}
				});
			});
		</script>
_END;
} // end of home
else if($location == "aboutus") {
	
	echo "<div id='followAboutUs'><div><span id='followTypesOfEvents'>Types of Events: $groupPage[3]</span></div><span id='groupAboutUs'>" . htmlspecialchars_decode($groupPage[4]) . "</span></div>";
}
else if($location == "photos") {
	echo <<<_END
	<div id='followPhotos'>
		<div id='followPhotoSlidesContain'>
			<div class='photoGalleryContain'>
				<div id="container">
					<div id="gallery" class="ad-gallery">
						<div class="ad-image-wrapper"></div>
						<div class="ad-controls"></div>
						<div class="ad-nav">
							<div class="ad-thumbs">
								 <ul class="ad-thumb-list">
								  <li>
						              <a href="images/10.jpg">
						                <img src="images/thumbs/t10.jpg" title="A title for 10.jpg" alt="This is a nice, and incredibly descriptive, description of the image 10.jpg" class="image1">
						              </a>
						          </li>
						          <li>
						              <a href="images/10.jpg">
						                <img src="images/thumbs/t10.jpg" title="A title for 10.jpg" alt="This is a nice, and incredibly descriptive, description of the image 10.jpg">
						              </a>
						          </li>
						          <li>
						              <a href="images/11.jpg">
						              	<img src="images/thumbs/t11.jpg" title="A title for 11.jpg" longdesc="http://coffeescripter.com" alt="This is a nice, and incredibly descriptive, description of the image 11.jpg">
						              </a>
					              </li>
								 </ul>
							</div>
						</div>
					</div>
					
				</div>
			</div>
		</div>
		<!--<div class='groupAlbumLink'>Photo Album 1</div><br />
			<div class='groupAlbumDescription'>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris rhoncus lacus id massa sagittis, sit amet ullamcorper dolor semper. Pellentesque viverra dolor vitae ante iaculis, id bibendum mauris placerat.</div>
		<div class='groupAlbumLink'>Photo Album 2</div><br />
			<div class='groupAlbumDescription'>In vestibulum metus id mauris commodo imperdiet. Quisque ut justo sed lorem laoreet condimentum sed ac est. Nunc aliquam diam et arcu adipiscing molestie. Vivamus dignissim non libero vel pretium. Quisque lobortis molestie velit id rhoncus. </div>
		<div class='groupAlbumLink'>Photo Album 3</div><br />
			<div class='groupAlbumDescription'>Sed ut faucibus nunc. Sed felis nisl, consequat ut dictum eget, convallis vitae enim. Duis vel odio tortor. In tempor est a sem luctus, non consequat lacus varius. Aliquam in libero libero.</div>-->
	<div class='followBottomSpace'></div>
	</div><!--followPhotos-->

_END;
}
else if($location == "contactus") {
	echo <<<_END
	<div id='followContactUs'>
		<div id='groupContactContain'>
			<div class='groupContactElement'>Email: <a href='mailto:ovilomar_jr@yahoo.com' target='_parent'><span id='mailToEffect'>$groupPage[5]</span></a></div>
_END;
	if($groupPage[6] != "") {
		echo "<div class='groupContactElement'>Phone: $groupPage[6]</div>";
	}
	
		echo <<<_END
		</div>
	</div>
_END;
}
echo <<<_END
	</div>
	<div id='followNav'>
		<div id='followTitleCategoriesContain'>
		<div id='followEventCategoriesTitle'><span title='$groupPage[2] event categories'>Event Categories</span></div>
		</div>
		
_END;
		if($_GET['loc'] != "home") {
			echo "<div id='followEventCategoriesContent'><span id='navTypeall' class='type1Link'><a href='followPage.php?fp=$groupID&loc=home&lc=All'>All</a></span></div>";
		}
		else {
			echo "<div id='followEventCategoriesContent'><span id='navTypeall' class='type1Link'>All</span></div>";
		}
			for($j = 0; $j < count($eventTypesArray); $j++) {
				
				$thisEventType = str_replace($replaceCharacter, "", $eventTypesArray[$j]);
				if($_GET['loc'] != "home") {
					// lc = load category
					echo "<div id='followEventCategoriesContent'><span id='navType$thisEventType' class='type1Link'><a href='followPage.php?fp=$groupID&loc=home&lc=$thisEventType'>$eventTypesArray[$j]</a></span></div>";
				}
				else {
					echo "<div id='followEventCategoriesContent'><span id='navType$thisEventType' class='type1Link'>$eventTypesArray[$j]</span></div>";
				}
			}
echo <<<_END
		<div id='followEventCategoriesContain'>
			<div class='followOption'><span id='followHomeLink' class='type1Link'><a href='followPage.php?fp=$groupID&loc=home'>Home</a></span></div>
		<div class='followOption'><span id='followAboutUsLink' class='type1Link'><a href='followPage.php?fp=$groupID&loc=aboutus'>About Us</a></a></span></div>
		<div class='followOption'><span id='followPhotosLink' class='type1Link'><a href='followPage.php?fp=$groupID&loc=photos'>Photos</a></span></div>
		<div class='followOption'><span id='followContactUsLink' class='type1Link'><a href='followPage.php?fp=$groupID&loc=contactus'>Contact Us</a></span></div>
_END;
/* send email directly from site... consider implementing in the future
<div>Your Full Name:</div>
<div class='groupTextBoxSpace'><input type='text' id='groupEmailName' size='40' /></div>
<div class='groupTextBoxTitle'>Your Email Address:</div>
<div class='groupTextBoxSpace'><input type='text' id='groupEmailAddress' size='40' /></div>
<div class='groupTextBoxTitle'>Message:</div>
<div class='groupTextBoxSpace'><textarea id='groupEmailMessage' rows="5" cols="50"></textarea></div>
<div id='groupContactUsSubmit'><input type="submit" id='groupEmailSubmit' value="Submit"></div>	 
*/
echo <<<_END
		</div>
	</div>
	
</div><!--follow Content-->
<div class='followBottomSpace'></div>
</div><!--boxMain-->
<script>
	$(function() {
		$('#followCreateLink').css('background-color', '#E1E1E1');
		$('#followSearchLink').hover(function() {
			$('#followCreateLink').css('background-color', '');
		},
		function() {
			$('#followCreateLink').css('background-color', '#E1E1E1');
		});
		
		var followContentHeight = $('#followContent').outerHeight() - 2;
		var setNavHeight = followContentHeight + 'px';
		$('#followNav').css('height', setNavHeight);
		
		if($('#followHome').length) {
			$('#followHomeLink').css('text-decoration', 'underline');
		}
		else if($('#followPhotos').length) {
			$('#followPhotosLink').css('text-decoration', 'underline');
		}
		else if($('#followAboutUs').length) {
			$('#followAboutUsLink').css('text-decoration', 'underline');
		}
		else if($('#followContactUs').length) {
			$('#followContactUsLink').css('text-decoration', 'underline');
		}
	});
</script>
</div><!--main-->
<div id="footer">
<div id="copyRight"><span id="copyRightSpan">Copyright &copy; 2013</span></div>
</body>
</html>
_END;
?>