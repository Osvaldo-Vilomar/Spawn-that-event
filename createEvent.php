<?php

session_start();

require_once 'serverLogin.php';
require_once 'objectProgramming.php';

$studentID = $_SESSION['studentID'];
$firstName = $_SESSION['firstName'];
$lastName = $_SESSION['lastName'];
$fieldOfStudy = $_SESSION['fieldOfStudy'];
$object = new PHP_HTML($studentID, $fieldOfStudy, $firstName, $lastName);

// make sure the script location works
// Optional: create event from difference field of study
// What to do with items that you can't seem to categorize? Replace with workshops?
// add Workshops when you already have emails for that?
// Edit form so it is not submitted when hour is greater than 12 or when fields are not filled in.
// Edit max length for input boxes
// Look into validate time
// Look into validate date
echo <<<_END
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title>Campus Connect</title>
		<link rel="stylesheet" type="text/css" href="../HTML/CSS/index.css" />
		<link rel="stylesheet" type="text/css" href="../HTML/CSS/createEvent.css" />
		<style type="text/css">
			a:link {
				text-decoration: none;
			}
			a:visited {
				color: #000000;
				text-decoration: none;
			}
			
			#createEvent {
				background-color: rgb(225, 225, 225);
			}
		</style>
		<script type="text/javascript" src="../HTML/scripts/formValidate.js"></script>
		<script type="text/javascript">
		function validateForm(form) {
			result  = validateEventName(form.eventName.value)
			result += validateEventType(form.eventType.value)
			result += validateEventDate(form.date1.value, form.date2.value, form.date3.value)
			result += validateEventTime(form.hour1.value, form.minutes1.value, form.hour2.value, form.minutes2.value)
			result += validateLocation(form.location.value)
			result += validateShortDescription(form.shortDescription.value)
			result += validateName(form.name.value)
			result += validateContact(form.contactInfo.value)
			if(result == "") return true
			else {
				alert(result); return false
			}
		}
		</script>
		<script src="../HTML/scripts/jquery-1.9.1.min.js"></script>
	</head>
<body>
<div id="main">
_END;

$object->header();
$object->linksNav();

echo <<<_END
<div id="boxMain">
	<div id="form">
		<div id='requiredFields'><span class='basicRed'>*</span>&nbsp;Required Fields</div>
		<form action = "../HTML/process/processEvent.php" method="post" onsubmit="return validateForm(this)">
				<div id="eventName">Event Title<span class="basicRed">*</span>:</div>
					<input type="text" name="eventName"  maxlength="50" size="41"></input>
_END;
				$queryShareFollowing = "Select followStatus from Event_Promoter where studentID = '$studentID'";
				$resultShareFollowing = mysql_query($queryShareFollowing);
				$shareStatus = mysql_result($resultShareFollowing, 0);
				if($shareStatus == "y") {
					echo <<<_END
					<div id='followStatusText'>Share event with followers:</div>
					<div id='followStatus'>
						Yes <input type="radio" name="shareStatus" value="y" checked/>
						No <input type="radio" name="shareStatus" value="n" />
					</div>
_END;
				}
				echo <<<_END
				<div id="sponsor">Sponsor:</div>
					<input type="text" name="sponsor" maxlength="50" size="40"></input>
				<div id="eventType">Event Type<span class="basicRed">*</span>:&nbsp;
					<select name="eventType" id='eventTypeSelect'>
						<option value="" selected="selected">-- Please Select --</option>	
						<option value="$fieldOfStudy">$fieldOfStudy</option>
						<option value='Art & Culture'>Art & Culture</option>
						<option value='Community'>Community</option>
						<option value='Career'>Career</option>
						<option value='Degree Programs'>Degree Programs</option>
						<option value='Food & Drink'>Food & Drink</option>
						<option value='Games'>Games</option>
						<option value='Health & Fitness'>Health & Fitness</option>
						<option value='Hobbies'>Hobbies</option>
						<option value='International'>International</option>
						<option value='Learning'>Learning</option>
						<option value='Leisure'>Leisure</option>
						<option value='Movies'>Movies</option>
						<option value='Music'>Music</option>
						<option value='Outdoors'>Outdoors</option>
						<option value='Parties'>Parties</option>
						<option value='Pets & Animals'>Pets & Animals</option>
						<option value='Politics'>Politics</option>
						<option value='Religion & Spirituality'>Religion & Spirituality</option>
						<option value='Sci-Fi & Fantasy'>Sci-Fi & Fantasy</option>
						<option value='Sports & Recreation'>Sports & Recreation</option>
						<option value='Technology'>Technology</option>
						<option value='Vehicles'>Vehicles</option>
						<option value='Volunteer'>Volunteer</option>
					</select>
					<span id='includeEventTag'>Include Event Tag:
						<span class='tagRadio'>
							<input type='radio' id='tagIncludeYes' class='tagRadioSelect' name='tagInclude' value='tagIncludeYes' />Yes
							<input type='radio' id='tagIncludeNo' class='tagRadioSelect' name='tagInclude' value='tagIncludeNo' checked />No
						</span>
						<input id='eventTag' type='hidden' name='eventTag' value='none' />
					</span>
					<span id='tagsField'>
						<div id='tagsText'>
							<div id='allTagsDiv'>
								<div>
									<div id='allTagsTitle'>Chosen Field</div>
									<div class='divTagRow'>
									</div>
								</div>
								<div id='divTagRequest'>
									<span id='requestTagClick' class='type1Link'>Request Tag</span><span id='requestTagTextContain'>: <input id='requestTagText' type='text' name='requestTagText' maxlength='30' /></span>
									<div id='requestTagExists'></div>
								</div>
								<script>
									$(function() {
										var thisTagID;
										var thisID;
										var elementIndex;
										var thisCategory
										$('.tagRadioSelect').attr('disabled', true);
										$('#eventTypeSelect').change(function() {
											$('#requestTagText').val('');
											$('#requestTagExists').text('');
											thisCategory = encodeURIComponent($('#eventTypeSelect :selected').val());
											if(thisCategory == "") {
												$('#tagsField').hide();
												$('#tagIncludeNo').prop('checked', true);
												$('.tagRadioSelect').attr('disabled', true);
												$('#eventTag').attr('value', 'none');
											}
											
											else {
												$('.tagRadioSelect').attr('disabled', false);
												$('.tagRadioSelect').change(function() {
													if($('#tagIncludeYes').is(":checked")) {
														$('#tagsField').show();
													}
													else {
														$('#tagsField').hide();
														$('span[id^="tagType"]').css('background-color', '');
														$('span[id^="tagType"]').data("selected", "false");
														$('#eventTag').attr('value', 'none');
														
													}
												});
												$('#allTagsTitle').text($('#eventTypeSelect :selected').val() + " Tags");
												$.getJSON('getTags.php', 'getTags=createEvent&tagCategory=' + thisCategory, function(data) {
													$('.divTagRow').empty();
													if(data.length == 0) $('.divTagRow').append("<span class='divTagNone'>No available tags.</span>");
													else {
														for (tag in data) {
															$('.divTagRow').append("<span id=tagType" + data[tag] + " class='divTag'>" + data[tag] + "</span>");
														}
													}
												});
											}
										});
										$('.divTagRow').delegate('span[id^="tagType"]', 'click', function() {
											$('span[id^="tagType"]').css('background-color', '');
											thisTagID = $(this).attr('id');
											thisID = thisTagID.substring(7);
											if($(this).data("selected") == "true") {
												$('#eventTag').attr('value', 'none');
												$(this).data("selected", "false");
											}
											else {
												$('span[id^="tagType"]').data("selected", "false");
												$('#eventTag').attr('value', thisID);
												$(this).css('background-color', 'rgb(210, 210, 210)');
												$(this).data("selected", "true");
											}
										});
										var textField = "off";
										$('#requestTagClick').click(function() {
											if(textField == "on") {
												$('#requestTagText').css('visibility', 'hidden');
												textField = "off";
											}
											else {
												$('#requestTagText').css('visibility', 'visible');
												$('#requestTagText').focus();
												textField = "on";
											}
										});
										var textFieldValue;
										$('#requestTagText').blur(function() {
											textFieldValue = $('#requestTagText').val();
											$.get('approveTags.php', 'tagExists=' + textFieldValue + '&thisCategory=' + thisCategory, function(data) {
												if(data == "exists") {
													$('#requestTagExists').text('Tag already exists');
													$('#requestTagExists').removeClass();
													$('#requestTagExists').addClass('basicRed');
												}
												else {
													$('#requestTagExists').text('Available');
													$('#requestTagExists').removeClass();
													$('#requestTagExists').addClass('green');
												}
											});
											
										});
									});
								</script>
							</div>
						</div>
					</span>
				</div>
				<div id="date">Date<span class="basicRed">*</span>:&nbsp;
					<input type="text" name="date1" maxlength="2" size="1"></input>&nbsp;&nbsp;/&nbsp;
					<input type="text" name="date2" maxlength="2" size="1"></input>&nbsp;&nbsp;/&nbsp;
					<input type="text" name="date3" maxlength="2" size="1"></input>
				</div>
				<div id="time">Time<span class="basicRed">*</span>:&nbsp;
					<input type="text" name="hour1"  maxlength="2"  size="1"></input>&nbsp;:
					<input type="text" name="minutes1"  maxlength="2"  size="1"></input>
					<span id='ampmFont'>
						pm<input type="radio" name="ampm1" value="2"></input>
						am<input type="radio" name="ampm1" value="1"></input>
					</span>&nbsp;-&nbsp;
					<input type="text" name="hour2" maxlength="2" size="1"></input>&nbsp;:
					<input type="text" name="minutes2"  maxlength="2" size="1"></input>
					<span id='ampmFont'>
						pm<input type="radio" name="ampm2" value="2"></input>
						am<input type="radio" name="ampm2" value="1"></input>
					</span>
				</div>
				<div id="location">Location<span class="basicRed">*</span>:</div>
					<input type="text" name="location"  maxlength=""  size=""></input>
				<div id="shortDescriptionForm">Short Description<span class="basicRed">*</span>:</div>
					<textarea name="shortDescription"  rows="3" cols="50" maxlength="300"></textarea>
				<div id="nameHere">Contact Name<span class="basicRed">*</span>:</div>
					<input type="text" name="name"  maxlength="37" size="31"></input>
				<div id="contactInfo">Contact<span class="basicRed">*</span>:</div>
					<input type="text" name="contactInfo" maxlength="55" size="40" placeholder="Email address"></input>	
				<div id="submit">
					<input type="submit" value="Create Event"/>
				</div>
		</form>
	</div>
</div>
</div>
<div id="footer">
<div id="copyRight"><span id="copyRightSpan">Copyright &copy; 2013</span></div>
</body>
</html>
_END;
?>