<?php 

require_once 'loggedin.php';
require_once 'updateEventValue.php';
require_once 'objectProgramming.php';

$studentID = $_SESSION['studentID'];
$fieldOfStudy = $_SESSION['fieldOfStudy'];
$firstName = $_SESSION['firstName'];
$lastName = $_SESSION['lastName'];
$currentDate = strtotime(date('Y/m/d'));
$object = new PHP_HTML($studentID, $fieldOfStudy, $firstName, $lastName);
$categorySelect = urldecode($_GET['category']);

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
			#home {
				background-color: rgb(225, 225, 225);
			}
		</style>
		<script type="text/javascript" src="refresh.js"></script>
		<script src="../HTML/scripts/jquery-1.9.1.min.js"></script>
		<script src='hideShowEventsTime.js'></script>
	</head>
<body>
<div id="main">
_END;


$object->header();
$object->linksNav();
// print_r($_COOKIE['groupID']);
// print_r($_COOKIE['tabCookie']);

echo "<div id='timeBarContain'>";

$object->timeSelected();

//from selecting a category to search, and when the event count value selected is different from what was on the sever.
//value eventCountHidden comes from the hidden input field in the script section of the allcategories function the objectprogramming.php file
if(isset($_GET['eventCountHidden'])) {
	$eventCountHidden = $_GET['eventCountHidden'];
	$getSettings = mysql_query("Update Student_Settings set categoryTotalEvents='$eventCountHidden' where studentID = '$studentID'");
}
$object->allCategories();

echo <<<_END
</div>
<div id='boxMain'>
<div id='box1'>
<div id="eventsTitle">
_END;

$object->toggleEvent();
$object->attendClick();
$object->homeSettings();

if(isset($_GET['category'])) {
	echo "<span class='categoryOnly'>$categorySelect</span>";
	echo "</div><!--eventsTitle-->";
	
	$object->getEvents("justCategory", $categorySelect);
	$removeThis = array(" ", "&", "-");
	$thisCategorySearch = str_replace($removeThis, "", $categorySelect);
	echo <<<_END
	<script>
		$(function() {
			
			var category = $("div[class^='eventsFeedIndent justCategory']").attr('class').substring(29);
			tagFeature(category);
			
			var thisTag;
			var tagsSpan;
			var spanTagID;
			function updateTag(tag, category){
				$.post('getTags.php', 'updateCategory=' + category + '&updateTag=' + tag);
			}
			function tagFeature(category) {
				$.get('getTags.php', 'getTags=true&category=' + category, function(data) {
					if(data == "all") {
						$('div[class^="displayTag"]').show();
						$('span[id^="tagType"]').css('background-color', 'rgb(230, 230, 230)');
					}
					else if(data == "none") {
						$('span[id^="tagType"]').data("filter", "off");
						$('div[class^="displayTag"]').hide();
						$('div[class^="noEventTags"]').show();
					}
					else if(data == "") {
						$('span[id^="tagType"]').data("filter", "off");
						$('div[class^="displayTag"]').hide();
						$('div[class^="noEventTags"]').show();
					}
					else  {
						$('div[class^="displayTag"]').hide();
						$('.noEventTags').hide();
						$('.displayTag' + data).show();
						$('#tagType' + data).data("filter", "on");
						$('#tagType' + data).css('background-color', 'rgb(230, 230, 230)');
					}
					$('.tagShowResult').unbind('click').delegate('span[id^="tagType"]', 'click', function() {
						var thisTagID = $(this).attr('id');
						var thisID = thisTagID.substring(7);
						var eventTagResult = '.displayTag' + thisID;
						$('.noEventTags').hide();
						if(thisID == "all") {
							if($(this).data("filter") == "off") {
								$('span[id^="tagType"]').data("filter", "off");
								$('div[class^="displayTag"]').show();
								$('.noEventTags').show();
								updateTag(thisID, category);
								$('span[id^="tagType"]').css('background-color', 'rgb(230, 230, 230)');
								$('span[id^="tagType"]').data("filter", "on");
							}
							else {
								$('div[class^="displayTag"]').hide();
								$('.noEventTags').show();
								updateTag("none", category);
								$('span[id^="tagType"]').css('background-color', '');
								$('span[id^="tagType"]').data("filter", "off");
							}
						}
						else {
							if($(this).data("filter") == "on") {
								if($('#tagTypeall').data("filter") == "on") {
									$('span[id^="tagType"]').data("filter", "off");
									$('span[id^="tagType"]').css('background-color', '');
									$('div[class^="displayTag"]').hide();
									$(eventTagResult).show();
									$(this).css('background-color', 'rgb(230, 230, 230)');
									$(this).data("filter", "on");
								}
								else {
									$(this).css('background-color', '');
									$('.noEventTags').show();
									$(eventTagResult).hide();
									updateTag("none", category);
									$('span[id^="tagType"]').data("filter", "off");
								}
							}
							else {
								$('div[class^="displayTag"]').hide();
								$('span[id^="tagType"]').data("filter", "off");
								$('span[id^="tagType"]').css('background-color', '');
								$(eventTagResult).show();
								$(this).css('background-color', 'rgb(230, 230, 230)');
								updateTag(thisID, category);
								$(this).data("filter", "on");
								
							}
						}
					});
				});
			}
		});
	</script>
_END;
}
elseif(!isset($_GET['category'])) {
	echo <<<_END
		<span id="AllEventsSpan">Event Feed</span>
		<!--<span id="StudyEventsSpan">$fieldOfStudy</span>-->
_END;
	$object->echoTabs();
	
	echo "</div><!--eventsTitle-->";
	
	$object->getEvents("allEvents");
	// $object->getEvents("studyEvents");
	$trackingArray = $object->echoTabs("tracking");
	for($j = 1; $j < count($trackingArray); $j++) {
		if($trackingArray[$j] != "") $object->getEvents("trackingEvents", $trackingArray[$j]);
	}

	// This cookie tracks the last tab the user was under
	$previousCategory = $_COOKIE['tabCookie'];
	
	echo <<<_END
	<script>
		$(function() {
			var idCategory;
			var spanIndex;
			var category;
			var showThis;
			var loadCategory = '$previousCategory';
			
			if(loadCategory == "") {
				$('.noEventTags').show();
				$('div[class^="display"]').show();
			}
			else {
				if(loadCategory == "AllEvents") {
					$('.noEventTags').show();
					$('div[class^="display"]').show();
				}
				else {
					$('div[id^="display"]').hide();
					showThis = '#display' + loadCategory;
					$(showThis).show();
					console.log(loadCategory);
					tagFeature(loadCategory);
				}
			}
			$('span[id$="Span"]').click(function() {
				idCategory = $(this).attr('id');
				spanIndex = idCategory.indexOf("Span");
				category = idCategory.substring(0, spanIndex);
				$('div[id^="display"]').hide();
				$.get('setTab.php', 'category=' + category);
				showThis = '#display' + category;
				$(showThis).show();
				if(category != "AllEvents") {
					$.getJSON('getTags.php', 'getTags=textField&tagCategory=' + category, function(data) {
						if(data.length == 0) {
							$('.tagShowResult').empty();
							$('.tagShowResult').text('No tags.');
						}
						else {
							$('.tagShowResult').empty();
							for (tag in data) {
								$('.tagShowResult').append("<span id=tagType" + data[tag] + " class='tagResultTrue'>" + data[tag] + "</span>");
							}
						}
					});
					tagFeature(category);
				}
				else {
					$('div[class^="noEventTags"]').show();
					$('div[class^="displayTagAll"]').show();
				}
			});
			
			var thisTag;
			var tagsSpan;
			var spanTagID;
			
			function updateTag(tag, category){
				$.post('getTags.php', 'updateCategory=' + category + '&updateTag=' + tag);
			}
			function tagFeature(category) {
				$.get('getTags.php', 'getTags=true&category=' + category, function(data) {
					if(data == "all") {
						$('div[class^="displayTag"]').show();
						$('span[id^="tagType"]').css('background-color', 'rgb(230, 230, 230)');
					}
					else if(data == "none") {
						$('span[id^="tagType"]').data("filter", "off");
						$('div[class^="displayTag"]').hide();
						$('div[class^="noEventTags"]').show();
					}
					else  {
						$('div[class^="displayTag"]').hide();
						$('.noEventTags').hide();
						$('.displayTag' + data).show();
						$('#tagType' + data).data("filter", "on");
						$('#tagType' + data).css('background-color', 'rgb(230, 230, 230)');
					}
					$('.tagShowResult').unbind('click').delegate('span[id^="tagType"]', 'click', function() {
						var thisTagID = $(this).attr('id');
						var thisID = thisTagID.substring(7);
						var eventTagResult = '.displayTag' + thisID;
						$('.noEventTags').hide();
						if(thisID == "all") {
							if($(this).data("filter") == "off") {
								$('span[id^="tagType"]').data("filter", "off");
								$('div[class^="displayTag"]').show();
								$('.noEventTags').show();
								updateTag(thisID, category);
								$('span[id^="tagType"]').css('background-color', 'rgb(230, 230, 230)');
								$('span[id^="tagType"]').data("filter", "on");
							}
							else {
								$('div[class^="displayTag"]').hide();
								$('.noEventTags').show();
								updateTag("none", category);
								$('span[id^="tagType"]').css('background-color', '');
								$('span[id^="tagType"]').data("filter", "off");
							}
						}
						else {
							if($(this).data("filter") == "on") {
								if($('#tagTypeall').data("filter") == "on") {
									$('span[id^="tagType"]').data("filter", "off");
									$('span[id^="tagType"]').css('background-color', '');
									$('div[class^="displayTag"]').hide();
									$(eventTagResult).show();
									$(this).css('background-color', 'rgb(230, 230, 230)');
									$(this).data("filter", "on");
								}
								else {
									$(this).css('background-color', '');
									$('.noEventTags').show();
									$(eventTagResult).hide();
									updateTag("none", category);
									$('span[id^="tagType"]').data("filter", "off");
								}
							}
							else {
								$('div[class^="displayTag"]').hide();
								$('span[id^="tagType"]').data("filter", "off");
								$('span[id^="tagType"]').css('background-color', '');
								$(eventTagResult).show();
								$(this).css('background-color', 'rgb(230, 230, 230)');
								updateTag(thisID, category);
								$(this).data("filter", "on");
								
							}
						}
					});
				});
			}
		});
		</script>
	
_END;
	
}

echo <<<_END
</div><!--box1-->
<div id="box2">
_END;

$object->following();
$object->map();
$object->eventsAttending();
$object->eventHistory();
$object->eventsCreated();

echo <<<_END
</div><!--box2-->
<div id='bottomSpace'></div>
</div><!--boxMain-->
</div><!--main-->
<div id="footer">
<div id="copyRight"><span id="copyRightSpan">Copyright &copy; 2013</span></div>
</div>
</body>
</html>
_END;

mysql_close($db_server);
?>