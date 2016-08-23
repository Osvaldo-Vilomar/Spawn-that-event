<?php 

// make sure all the different categories on here exist on the database
// make sure the variables like studentID appear like normal
class PHP_HTML {
	
	private $studentID, $fieldOfStudy, $currentDate, $firstName, $lastName;
	
	function __construct($studentID, $fieldOfStudy, $firstName, $lastName) {
		
		$this->studentID = $studentID;
		$this->fieldOfStudy = $fieldOfStudy;
		$this->currentDate = strtotime(date('Y/m/d'));
		$this->firstName = $firstName;
		$this->lastName = $lastName;
	}
	
	private function echoCategory($span, $category, $showTotalEvents) {
		
		$getStudentCategories = mysql_query("Select * from Student_Categories where studentID='$this->studentID'");
		$categoriesArray = mysql_fetch_array($getStudentCategories, MYSQL_ASSOC);
		
		$resultTotalEvents = mysql_query("Select categoryTotalEvents from Student_Settings where studentID='$this->studentID'");
		$totalEventsSetting = mysql_result($resultTotalEvents, 0);
	
		if($span == "" && $category == "" && $showTotalEvents == true) {
			if($totalEventsSetting == "on") {
				echo <<<_END
				<style type="text/css">
					#eventCount {
						text-decoration: underline;
					}
				</style>	
_END;
				
			}
			if($totalEventsSetting == "off") {
				echo <<<_END
				<style type="text/css">
					.allCategoriesTotalEvents {
						visibility: hidden;
					}
				</style>
_END;
			}
		}
		
		if($showTotalEvents == true && $category != "") {

				$getTotalNumber = mysql_query("Select count(*) from Made_Events where UnixTime >= '$this->currentDate' and eventType='$category'");
				$totalNumber = mysql_result($getTotalNumber, 0);
				
				if($totalNumber != 0) {
					echo "<span class='allCategoriesTotalEventsRow'>$totalNumber</span>";
				}
				else {
					echo "<span class='allCategoriesTotalEventsZeroRow'>0</span>";
				}
		}
		elseif($category != "") {
			$checkID = substr($span, 2) . "Checked";
			if(in_array($category, $categoriesArray)) {
				echo "<div id='allCategoriesRow'><span id=" . $span . " class='type1Link'>$category</span><span id=" . $checkID . "> V</span></div>";
			}
			else {
				echo "<div id='allCategoriesRow'><span id=" . $span . " class='type1Link'>$category</span></div>";
			}
		}
		
	}
	
	private function echoAlreadyChecked() {
		
		$getAlreadyChecked = mysql_query("Select * from Student_Categories where studentID='$this->studentID'");
		$categorySelect;
		$textCategoryID;
		$textCategory;
		$alreadyChecked = mysql_fetch_row($getAlreadyChecked);
		$removeThis = array(" ", "&", "-");
		
		for($j = 1; $j < 6; $j++) {
			$categorySelect = "categorySelect" . $j;
			$postID = str_replace($removeThis, "", $alreadyChecked[$j]);
			$textCategoryID = "post" . $postID;
			$textCategory = "" . rawurlencode($alreadyChecked[$j]);
			if($alreadyChecked[$j] != "") {
				echo "<input type='hidden' id=" . $textCategoryID . " value=" . $textCategory . " name=" . $categorySelect . " />";
			}
			else {
				echo "<input type='hidden' id=openslot" . $j .  " value=remove" . $j . " name=" . $categorySelect . " />";
			}
		}
	}
	
	public function allCategories() {
		echo <<<_END
		<div id='allCategoriesFind'>
			<div id='allCategoriesBubble'>
				<div id='searchLinkDiv'>
_END;
		$getSettings = mysql_query("Select categoryTotalEvents from Student_Settings where studentID='$this->studentID'");
		$categoryTotalEvents = mysql_result($getSettings, 0);
		
		echo <<<_END
					<div id='searchLinkType'>
						<span id='eventCount' class='$categoryTotalEvents'>Event Count</span>
						<span id='searchLinkCategory'><span id='linkCategoryFocus'></span>Search</span><span id='searchLinkTrack'>My Categories</span>
					</div>
				</div>
				<div id='allCategoriesBubbleContain' class='floatContain'>
					<div id='allCategoriesBubbleC1'>
					<div class='allCategoriesTotalEvents'>
_END;
						$this->echoCategory("", "", true);
						$this->echoCategory("", "Art & Culture", true);
						$this->echoCategory("", "Community", true);
						$this->echoCategory("", "Career", true);
						$this->echoCategory("", "Degree Programs", true);
						$this->echoCategory("", "Food & Drink", true);
						$this->echoCategory("", "Games", true);
						$this->echoCategory("", "Health & Fitness", true);
						$this->echoCategory("", "Hobbies", true);
					echo "</div>";
						$this->echoCategory("cbArtCulture", "Art & Culture");
						$this->echoCategory("cbCommunity", "Community");
						$this->echoCategory("cbCareer", "Career");
						$this->echoCategory("cbDegreePrograms", "Degree Programs");
						$this->echoCategory("cbFoodDrink", "Food & Drink");
						$this->echoCategory("cbGames", "Games");
						$this->echoCategory("cbHealthFitness", "Health & Fitness");
						$this->echoCategory("cbHobbies", "Hobbies");
						
					echo "</div><div id='allCategoriesBubbleC2'><div class='allCategoriesTotalEvents'>";
						$this->echoCategory("", "International", true);
						$this->echoCategory("", "Learning", true);
						$this->echoCategory("", "Leisure", true);
						$this->echoCategory("", "Movies", true);
						$this->echoCategory("", "Music", true);
						$this->echoCategory("", "Outdoors", true);
						$this->echoCategory("", "Parties", true);
						$this->echoCategory("", "Pets & Animals", true);
					echo "</div>";
						$this->echoCategory("cbInternational", "International");
						$this->echoCategory("cbLearning", "Learning");
						$this->echoCategory("cbLeisure", "Leisure");
						$this->echoCategory("cbMovies", "Movies");
						$this->echoCategory("cbMusic", "Music");
						$this->echoCategory("cbOutdoors", "Outdoors");
						$this->echoCategory("cbParties", "Parties");
						$this->echoCategory("cbPetsAnimals", "Pets & Animals");
						
					echo "</div><div id='allCategoriesBubbleC3'><div class='allCategoriesTotalEvents'>";
						$this->echoCategory("", "Politics", true);
						$this->echoCategory("", "Religion & Spirituality", true);
						$this->echoCategory("", "Sci-Fi & Fantasy", true);
						$this->echoCategory("", "Sports & Recreation", true);
						$this->echoCategory("", "Technology", true);
						$this->echoCategory("", "Top Events", true);
						$this->echoCategory("", "Vehicles", true);
						$this->echoCategory("", "Volunteer", true);
					echo "</div>";
						$this->echoCategory("cbPolitics", "Politics");
						$this->echoCategory("cbReligionSpirituality", "Religion & Spirituality");
						$this->echoCategory("cbSciFiFantasy", "Sci-Fi & Fantasy");
						$this->echoCategory("cbSportsRecreation", "Sports & Recreation");
						$this->echoCategory("cbTechnology", "Technology");
						$this->echoCategory("cbTopEvents", "Top Events");
						$this->echoCategory("cbVehicles", "Vehicles");
						$this->echoCategory("cbVolunteer", "Volunteer");
						
		echo <<<_END
					</div>
					<form method="get" action="newhome.php" id='categoryPage'></form>
					<form method='post' action='../HTML/process/processSelectCategories.php' id='studentCategorySelect'>
_END;
					$this->echoAlreadyChecked();
		echo <<<_END
					</form>
				</div>
				<div id='allCategoriesBubbleOutline'></div>
			</div>
_END;
		echo <<<_END
		<span id='allCategoriesClick'>Categories</span>
		</div><!--allCategoriesFind-->
		<script>
			$(function() {
				var show;
				var submitTrack = 0;
				var loadedCountStatus = $('#eventCount').attr('class');
				var changedCountStatus = $('#eventCount').attr('class');
				$('#allCategoriesClick').click(function() {
					if(show == "yes") {
						$('#allCategoriesBubble').hide();
						
						if(submitTrack != 1) {
							if(loadedCountStatus != changedCountStatus) {
								$.post('../HTML/process/processSelectCategories.php', 'eventCount=' + changedCountStatus);
							}
						}
						
						show = "no";
						
						if(totalTracking != loadTracking) {
							$('#studentCategorySelect').submit();
						}
					}
					else {
						$('#allCategoriesBubble').show();
	
						show = "yes";
					}
					
				});
				
				var clicked;
				var clickedCategory;
				var getCategory;
				var textCategory;
				var textCategoryID;
				var thisCategoryID;
				var getRemovedName;
				var getRemovedNumber;
				var emptyCategory = new Array();
				var thisID;
				$('[id^="openslot"]').each(function() {
					thisID = $(this).attr('id').match(/\d+/);
					emptyCategory.push(thisID);
				});	
				var removedThis;
				var openslot;
				var totalTracking;
				var loadTracking;
				$.get('../HTML/process/processSelectCategories.php', 'getTotalSelected=true', function(data) {
					totalTracking = data;
					loadTracking = data;
				});
				var number1;
				var number2;
				var number3;
				var number4;
				var number5;
				var categorySelect;
				$('span[id^="cb"]').click(function() {
					
					if(submitTrack == 0) {
						submitTrack++;
					}
					
					var getID = $(this).attr('id');
					var getCategory = getID.substring(2);
					var checkThis = '' + getCategory + 'Checked';
					var idCheck = '#' + getCategory + 'Checked';
					
					if($('#linkCategoryFocus').length > 0) {
						clickedCategory = encodeURIComponent($(this).text());
						$('#categoryPage').append("<input type='hidden' name='category' value=" + clickedCategory + " />");
						if(loadedCountStatus != changedCountStatus) {
							$('#categoryPage').append("<input name='eventCountHidden' value=" + changedCountStatus + " type='hidden'/>");	
						}
						$('#categoryPage').submit();
					}
					
					<!--my categories-->
					if($('#linkTrackFocus').length > 0) {
						<!--if event check exists and event is clicked we uncheck and append the removal--> 
						if($(idCheck).length > 0) {
							thisCategoryID = '#post' + getCategory;
							getRemovedName = $(thisCategoryID).attr('name');
							getRemovedNumber = getRemovedName.match(/\d+/);
							emptyCategory.push(getRemovedNumber);
							$(thisCategoryID).remove();
							removeCategory = 'remove' + getRemovedNumber;
							categorySelect = 'categorySelect' + getRemovedNumber;
							openslot = 'openslot' + getRemovedNumber;
							$('#studentCategorySelect').append("<input type='hidden' id=" + openslot + " value=" + removeCategory + " name=" + categorySelect + " />");
							totalTracking--;
							$(idCheck).remove();	
						}
						<!--append event track-->
						else if(totalTracking < 5) {
							textCategoryID = 'post' + getCategory;
							thisCategoryID = '#post' + getCategory;
							getRemovedName = $(thisCategoryID).attr('name');
							categorySelect = 'categorySelect' + emptyCategory[0];
							categoryValue = encodeURIComponent($(this).text());
							$('#studentCategorySelect').append("<input type='hidden' id=" + textCategoryID + " value=" + categoryValue + " name=" + categorySelect + " />");
							$(this).after("<span id=" + checkThis + "> V</span>");
							totalTracking++;
							removeThis = '#openslot' + emptyCategory.shift();
							$(removeThis).remove();
						}
					}
			
				});
				
				$('#searchLinkCategory').css('background-color', 'rgb(240, 240, 240)');
				$('#searchLinkTrack').click(function() {
					$('#searchLinkCategory').css('background-color', '');
					$('#searchLinkTrack').css('background-color', 'rgb(240, 240, 240)');
					$('#linkCategoryFocus').remove();
					$('#searchLinkTrack').prepend("<span id='linkTrackFocus'></span>");
				});
				$('#searchLinkCategory').click(function() {
					$('#searchLinkCategory').css('background-color', 'rgb(240, 240, 240)');
					$('#searchLinkTrack').css('background-color', '');
					$('#linkTrackFocus').remove();
					$('#searchLinkCategory').prepend("<span id='linkCategoryFocus'></span>");
				});
				
				var thisCountStatus;
				$('#eventCount').click(function() {
					thisCountStatus = $(this).attr('class'); 
					if(thisCountStatus == "off") {
						$(this).attr('class', 'on');
						$('.allCategoriesTotalEventsRow').css('visibility', 'visible');
						$(this).css('text-decoration', 'underline');
						changedCountStatus = "on";
					}
					else {
						$(this).attr('class', 'off');
						$('.allCategoriesTotalEventsRow').css('visibility', 'hidden');
						$('#eventCount').css('text-decoration', 'none');
						changedCountStatus = "off";
					}
				});
			});
		</script>
		<div id='categoriesBottomSpace'></div>
_END;
	}
	
	public function echoTabs($getCategories) {
		
		$category;
		$removeThis = array(" ", "&", "-");
		$addCSS;
		$spanID;
		$getStudentCategories = mysql_query("Select * from Student_Categories where studentID = '$this->studentID'");
		
		if($getCategories == "tracking") {
			$row = mysql_fetch_array($getStudentCategories, MYSQL_NUM);
			return $row;
		}
		else {
			$row = mysql_fetch_row($getStudentCategories);
			for($j =  1; $j < 6; $j++) {
				
				$category = str_replace($removeThis, "", $row[$j]);
				$addCSS = "#" . $category . "Span";
				echo <<<_END
				<style type="text/css">
				$addCSS {
					border-style: solid;
					border-width: thin;
					font-size: 1.3em;
					padding: 5px 7px 3px 7px;
					z-index: 1;
					background-color: white;
					cursor: pointer;
					display: inline-block;
				} 
				</style>
_END;
				$spanID = $category . "Span";
				if($row[$j] != "") echo "<span id=" . $spanID . ">$row[$j]</span>";
			}
		}
	}
	
	public function homeSettings() {
		
		$getSettings = mysql_query("Select dateTimeLocation, shortDescription, details from Student_Settings where studentID='$this->studentID'");
		$dateTimeLocation = mysql_result($getSettings, 0, 'dateTimeLocation');
		$shortDescription = mysql_result($getSettings, 0, 'shortDescription');
		$details = mysql_result($getSettings, 0, 'details');
		
		if($dateTimeLocation == "off") $dateTimeLocationColor = "offColor";
		if($shortDescription == "off") $shortDescriptionColor = "offColor";
		if($details == "off") $detailsColor = "offColor";
		
		
		if($dateTimeLocation == "on") $dateTimeLocationColor = "onColor";
		if($shortDescription == "on") $shortDescriptionColor = "onColor";
		if($details == "on") $detailsColor = "onColor";
	
		echo <<<_END
		
			<div id='settings'>
			<div id='settingsLink'></div>
			<div id='settingsBubble'>
			<div id='settingsBoxArrow'></div><div id='settingsBoxArrowOutline'></div>
				<div id='settingsBox'>
					<div class='settingsTitle'><span class='settingsTitleText'>Settings</span><span class='settingsTitleX'>x</span></div>
						<div class='settingsAdjust'>
							<div><span id='dateTimeLocationSetting' class='eventInfoFormat'>Date | Time | Location [ <span id='dtlID' class='$dateTimeLocationColor'>$dateTimeLocation</span> ] </span></div>
							<div><span id='shortDescriptionSetting' class='eventInfoFormat'>Description [ <span id='sdID' class='$shortDescriptionColor'>$shortDescription</span> ] </span></div>
							<div><span id='detailSetting' class='eventInfoFormat'>Details [ <span id='dID' class='$detailsColor'>$details</span> ]</span></div>	
						</div>
_END;
						$settingsCategories = mysql_query("Select * from Student_Categories where studentID='$this->studentID'");
						$settingsCategories = mysql_fetch_row($settingsCategories);
						for($j = 1; $j < 6; $j++) {
							if($settingsCategories[$j] != "") {
								echo "<div id=settingsContent" . $settingsCategories[$j] . " class='settingsContent'>$settingsCategories[$j]<span id=settingsEvent" . $settingsCategories[$j] . " class='settingsEventRemove'>X</span></div>";
							}
						}
		echo <<<_END
						</div></div></div><!--settingsBubble--><!--settings--><!--settingsBox-->
						<script>
							$(function() {
								var somethingHappened = false;
								var categoryRemoved = false;
								var thisSettingClick;
								var thisSettingID;
								var thisSettingText;
								var thisClass;
								var show;
								$('#settingsLink').click(function() {
									$('.settingsTitleX').click(function() {
										$('#settingsBubble').hide();
										$('#settingsLink').css('background-color', '');
										if(categoryRemoved == true) {
											$('#studentCategorySelect').submit();
										}
										show = "yes";
									});
									if(show == "no") {
										$('#settingsBubble').hide();
										$('#settingsLink').css('background-color', '');
										if(categoryRemoved == true) {
											$('#studentCategorySelect').submit();
										}
										show = "yes";
									}
									else {
										$('#settingsBubble').show();
										$('#settingsLink').css('background-color', 'rgb(225, 225, 225)');
										
										$('#dateTimeLocationSetting').unbind('click').click(function() {
											thisSettingClick = $(this).attr('id');
											thisSettingID = '#' + thisSettingClick;
											thisSettingText = $(thisSettingID).text();
											if(thisSettingText.indexOf('[ on ]') != -1) {
												$(thisSettingID).text(function() {
													$('#dateTimeLocationInput').remove();
													$('#dtlID').removeClass('onColor');
													var thisID;
													var id;
													$('div[id^="timeInfoAndLocationID"]').each(function() {
														thisID = $(this).attr('id');
														id = thisID.match(/\d+/);
														$('.eventsDetailsID' + id).prepend(this);
													});
													$.post('../HTML/process/processSettings.php', 'dateTimeLocationStatus=off');
													$('#dtlID').addClass('offColor');
													$('#dtlID').text('off');	
												});
											}
											else {
												$(thisSettingID).text(function() {
													$('#dateTimeLocationInput').remove();
													$('#dtlID').removeClass('offColor');
													var thisID;
													var id;
													$('div[id^="timeInfoAndLocationID"]').each(function() {
														thisID = $(this).attr('id');
														id = thisID.match(/\d+/);
														$('#showingThisEventInfo' + id).prepend(this);
													});
													$.post('../HTML/process/processSettings.php', 'dateTimeLocationStatus=on');
													$('#dtlID').addClass('onColor');
													$('#dtlID').text('on');
												});
											}	
													
										});
										$('#shortDescriptionSetting').unbind('click').click(function() {
											thisSettingClick = $(this).attr('id');
											thisSettingID = '#' + thisSettingClick;
											thisSettingText = $(thisSettingID).text();
											if(thisSettingText.indexOf('[ on ]') != -1) {
												$(thisSettingID).text(function() {
													$('#shortDescriptionInput').remove();
													$('#sdID').removeClass('onColor');
													var thisID;
													var id;
													$('div[id^="shortDescriptionID"]').each(function() {
														thisID = $(this).attr('id');
														id = thisID.match(/\d+/);
														$('div[id^="shortDescriptionID"]').each(function() {
															thisID = $(this).attr('id');
															id = thisID.match(/\d+/);
															if($('.eventsDetailsID' + id + ' #timeInfoAndLocationID' + id).length > 0) {
																$('#timeInfoAndLocationID' + id).after(this);
															}
															else if($('.eventsDetailsID' + id + ' #eventDetailContent' + id).length > 0) {
																$('#eventDetailContent' + id).before(this);
															}
															else {
																$('.eventsDetailsID' + id).append(this);
															}
														});
													});
													$.post('../HTML/process/processSettings.php', 'shortDescriptionStatus=off');
													$('#sdID').addClass('offColor');
													$('#sdID').text('off');													
												});
											}
											else {
												$(thisSettingID).text(function() {
													$('#shortDescriptionInput').remove();
													$('#sdID').removeClass('offColor');
													var thisID;
													var id;
													$('div[id^="shortDescriptionID"]').each(function() {
														thisID = $(this).attr('id');
														id = thisID.match(/\d+/);
														if($('#showingThisEventInfo' + id + ' #timeInfoAndLocationID' + id).length > 0) {
															$('#timeInfoAndLocationID' + id).after(this);
														}
														else if($('#showingThisEventInfo' + id + ' #eventDetailContent' + id).length > 0) {
															$('#eventDetailContent' + id).before(this);
														}
														else {
															$('#showingThisEventInfo' + id).append(this);
														}
													});
													$.post('../HTML/process/processSettings.php', 'shortDescriptionStatus=on');
													$('#sdID').addClass('onColor');
													$('#sdID').text('on');													
												});
											}
											
										});
										$('#detailSetting').unbind('click').click(function() {
											thisSettingClick = $(this).attr('id');
											thisSettingID = '#' + thisSettingClick;
											thisSettingText = $(thisSettingID).text();
											if(thisSettingText.indexOf('[ on ]') != -1) {
												$(thisSettingID).text(function() {
													$('#detailSettingInput').remove();
													$('#dID').removeClass('onColor');
													var thisID;
													var id;
													$('div[id^="eventDetailContent"]').each(function() {
														thisID = $(this).attr('id');
														id = thisID.match(/\d+/);
														$('.eventsDetailsID' + id).append(this);
													});
													$.post('../HTML/process/processSettings.php', 'detailSettingStatus=off');
													$('#dID').addClass('offColor');
													$('#dID').text('off');														
												});
											}
											else {
												$(thisSettingID).text(function() {
													$('#detailSettingInput').remove();
													$('#dID').removeClass('offColor');
													var thisID;
													var id;
													$('div[id^="eventDetailContent"]').each(function() {
														thisID = $(this).attr('id');
														id = thisID.match(/\d+/);
														$('#showingThisEventInfo' + id).append(this);
													});
													$.post('../HTML/process/processSettings.php', 'detailSettingStatus=on');
													$('#dID').addClass('onColor');
													$('#dID').text('on');													
												});												
											}
											
										});
										
										var thisID;
										var thisCategory;
										var thisCloseButton;
										var thisCheck;
										var thisPostName;
										var thisPostNumber;
										var openArray = new Array();
										var openArrayNumber;
										$('div[id^="settingsContent"]').unbind('click').click(function() {
											thisID = $(this).attr('id');
											thisCategory = thisID.substring(15);
											thisCloseButton = '#settingsEvent' + thisCategory;
											thisCheck = '#' + thisCategory + 'Checked';											
											if($(this).data("myCategory") == "remove") {
												$(this).data("myCategory", "keep");
												$(this).css({
													'background-color' : '',
													'cursor' : 'default'
												});
												$(thisCloseButton).css({
													'background-color' : '',
													'color' : ''
												});
												openArrayNumber = openArray[openArray.length - 1];
												$('#studentCategorySelect').append("<input id=post" + thisCategory +" type='hidden' name=categorySelect" + openArrayNumber + " value=" + thisCategory +" />");
												$('#openslot' + openArrayNumber).remove();
												openArray.pop();
												$(thisCheck).show();
												categoryRemoved = false;
											}
											else {
												$(this).data("myCategory", "remove");
												$(this).css({
													'background-color' : '#E1E1E1',
													'cursor' : 'pointer'
												});
												$(thisCloseButton).css({
													'background-color' : '#B4B4B4',
													'color' : 'white'
												});
												thisPostName = $('#post' + thisCategory).attr('name');
												thisPostNumber = thisPostName.match(/\d+/);
												openArray.push(thisPostNumber);
												$('#studentCategorySelect').append("<input id=openslot" + thisPostNumber + " type='hidden' name=categorySelect" + thisPostNumber + " value=remove" + thisPostNumber + " />");
												$('#post' + thisCategory).remove();
												$(thisCheck).hide();
												categoryRemoved = true;
											}
											
										});
										
										show = "no";
									}
								});
							});
						</script>
_END;
		
	}

	public function timeSelected() {
	
		$queryTimePick = "Select Time_Show from Student_Settings where studentID = '$this->studentID'";
		$resultTimePick = mysql_query($queryTimePick);
		if(!$resultTimePick) die ("Database get failed(time pick): " . mysql_error());
		$timeValue = mysql_result($resultTimePick, 0);
	
		echo "<div id='timeBarTest'>";
		if($timeValue == "today") {
			echo '<div id="today" class="timeTabFocused"><span class="timeSpan today">Today</span></div>';
			echo '<div id="tomorrow"><span class="timeSpan tomorrow">Tomorrow</span></div>';
			echo '<div id="weekly"><span class="timeSpan weekly">Weekly</span></div>';
		}
		elseif($timeValue == "tomorrow") {
			echo '<div id="today"><span class="timeSpan today">Today</span></div>';
			echo '<div id="tomorrow" class="timeTabFocused"><span class="timeSpan tomorrow">Tomorrow</span></div>';
			echo '<div id="weekly"><span class="timeSpan weekly">Weekly</span></div>';
		}
		elseif($timeValue == "weekly") {
			echo '<div id="today"><span class="timeSpan today">Today</span></div>';
			echo '<div id="tomorrow"><span class="timeSpan tomorrow">Tomorrow</span></div>';
			echo '<div id="weekly" class="timeTabFocused"><span class="timeSpan weekly">Weekly</span></div>';
		}
		else {
			echo '<div id="today"><span class="timeSpan today">Today</span></div>';
			echo '<div id="tomorrow"><span class="timeSpan tomorrow">Tomorrow</span></div>';
			echo '<div id="weekly"><span class="timeSpan weekly">Weekly</span></div>';
		}
		echo "</div>";
	
		return $timeValue;
	}
	
	private function getTimeSaved() {
		
		$queryTimePick = "Select Time_Show from Student_Settings where studentID = '$this->studentID'";
		$resultTimePick = mysql_query($queryTimePick);
		if(!$resultTimePick) die ("Database get failed(time pick): " . mysql_error());
		$timeValue = mysql_result($resultTimePick, 0);
		
		return $timeValue;
	}
	
	public function getEvents($eventCategory, $tracking) {
		
		$tomorrowDate = strtotime('tomorrow');
		$dayAfterTomorrow = date('Y/m/d', strtotime('tomorrow + 1 day'));
		$dayAfterTomorrowStamp = strtotime($dayAfterTomorrow);
		
		// Refering to the time selection above the event list on the website
		$timeValue = $this->getTimeSaved();
		$timeSearch;
		
		if($timeValue == "all") {
			$timeSearch = "UnixTime >= '$this->currentDate'";
		}
		elseif($timeValue == "today") {
			$timeSearch = "UnixTime Between '$this->currentDate' and $tomorrowDate";
		}
		elseif($timeValue == "tomorrow") {
			$timeSearch = "UnixTime Between $tomorrowDate and $dayAfterTomorrowStamp";
		}
		elseif($timeValue == "weekly") {
			$timeSearch = "UnixTime >= $dayAfterTomorrowStamp";
		}
		
		// Don't worry about topEvents and studyEvents and fieldOfStudy
		if($eventCategory == "topEvents") {
			$resultEvents = mysql_query("Select * from Made_Events where " . $timeSearch . " order by Votes DESC LIMIT 10");
		}
		elseif($eventCategory == "studyEvents") {
			$resultEvents = mysql_query("Select * from Made_Events where " . $timeSearch . " and eventType = '$this->fieldOfStudy' LIMIT 10");
			echo "<div id='displayStudyEvents' class='loadHide'><div id='studyEventsContent'>";
		}
		elseif($eventCategory == "allEvents") {
			$resultEvents = mysql_query("Select * from Made_Events where " . $timeSearch . " LIMIT 20");
			if($_COOKIE['tabCookie'] != "AllEvents" && $_COOKIE['tabCookie'] != "") {
				echo "<div id='displayAllEvents' class='loadHide'><div id='allEventsContent'>";
			}
			else {
				echo "<div id='displayAllEvents'><div id='allEventsContent'>";
			}
		}
		elseif($eventCategory == "trackingEvents") {
			$resultEvents = mysql_query("Select * from Made_Events where " . $timeSearch . " and eventType = '$tracking' LIMIT 15");	
			echo "<div id='display" . $tracking . "' class='loadHide eventsFeedIndent'><div id=" . $tracking . "Content >";
		}
		elseif($eventCategory == "justCategory") {
			$resultEvents = mysql_query("Select * from Made_Events where " . $timeSearch . " and eventType = '$tracking' LIMIT 15");
			
			echo "<div id='display$tracking' class='eventsFeedIndent justCategory$tracking'><div id=" . $tracking . "Content'>";
		}
	
		if(!$resultEvents) die ("Database get failed(time pick): " . mysql_error());
		
		$rows = mysql_num_rows($resultEvents);
		
		$eventsAttended = array();
		
		$resultEventMatch = mysql_query("Select eventID from Event_Attendee where studentID='$this->studentID' and eventDateUnix >= '$this->currentDate'");
		$eventMatchRows = mysql_num_rows($resultEventMatch);
		
		$resultHomeSettings = mysql_query("Select dateTimeLocation, shortDescription, details from Student_Settings where studentID='$this->studentID'");
		$dateTimeLocation = mysql_result($resultHomeSettings, 0, 'dateTimeLocation');
		$shortDescription = mysql_result($resultHomeSettings, 0, 'shortDescription');
		$details = mysql_result($resultHomeSettings, 0, 'details');
		
		$previousCategory = $_COOKIE['tabCookie'];
	
		if($eventCategory != "allEvents") {
			$resultCategoryTabs = mysql_query("Select tag from AvailableTags where category = '$tracking' order by tag ASC");
			$categoryTabRows = mysql_num_rows($resultCategoryTabs);
			
			echo "<div class='eventTagsContain'><span id='tagLinkType'><span id='allTags'>Tags:</span><span class='tagShowResult'>";
			
			if($categoryTabRows > 0) {
				echo "<span id='tagTypeall' class='tagResultTrue'>all</span>";
				for($j = 0; $j < $categoryTabRows; $j++) {
					$currentTag = mysql_result($resultCategoryTabs, $j);
					echo "<span id=tagType$currentTag class='tagResultTrue'>$currentTag</span>";
				}
			}	
			else {
				echo "No Tags.";
			}
			
			echo "</span></span></div>";
		}
		
		for($k = 0; $k < $eventMatchRows; $k++) {
			$eventMatch = mysql_result($resultEventMatch, $k);
			array_push($eventsAttended, $eventMatch);
		}
		
		for($j = 0; $j < $rows; $j++) {
			
			$event = mysql_fetch_row($resultEvents);
			$eventDate = $event[6];
			$eventDateStamp = strtotime($eventDate);
			$dateFormated = date('l F j, y', $eventDateStamp);
			
			//gets an array of my categories
			$trackingArray = $this->echoTabs("tracking");
			
			if(in_array($event[0], $eventsAttended) == false) {
				
				
				if($eventCategory == "allEvents" && in_array($event[3], $trackingArray) == true) {
					// no double posting my category events into all events
				}
				else {
					/* $resultTags = mysql_query("Select eventTag from Event_Tags where eventID='$event[0]'");
					$eventTag = mysql_result($resultTags, 0); */
					
					$eventTag = $event[16];
					
					// Note to self - can remove "" in the feature. Events with no tags will have -none- in $event[16]
					if($eventTag == "") {
						echo "<div id='eventsRow' class='noEventTags displayEventShadow'>";
					}
					else {
						if($eventCategory == "allEvents") {
							echo "<div id='eventsRow' class='displayTagAll" . $eventTag . "_" . $event[3] . " displayEventShadow loadHide'>";
						}
						else {
							echo "<div id='eventsRow' class='displayTag$eventTag displayEventShadow loadHide'>";
						}
					}
					// start event information show
					echo <<<_END
						<div id='eventsRowID$event[0]'>
							<div id='titleAndAttendRow$event[0]'>
								<span id='eventTitleID$event[0]' class='eventTitleDecor'>$event[2]</span>
								<span class="attendClass"><span id="attendClick$event[0]">Attend</span></span>
							</div>
							<div id='showingThisEventInfo$event[0]'>
_END;
					if($dateTimeLocation == "on") echo "<div id='timeInfoAndLocationID$event[0]' class='timeInfoAndLocation'>$dateFormated | $event[7] - $event[8] | $event[4]</div>";
					if($shortDescription == "on") echo "<div id='shortDescriptionID$event[0]'class='shortDescription'>$event[5]</div>";
					if($details == "on") {
					echo <<<_END
						<div id='eventDetailContent$event[0]'>
						<div id="contactShow"><span class='followName'>$event[9]</span>,&nbsp;$event[10]</div>
						<div id="sponsorShow">Sponsor:&nbsp;$event[11]</div>
_END;
					// can remove "" in the future, when you edit the code, so all events with no tags, have none for the eventtag value
					
					if($eventTag == "" || $eventTag == "none") {
						echo "<div id='categoryShow'>Category: $event[3]</div>";
					}
					else {
						echo "<div id='categoryShow'>Category: $event[3] || $eventTag </div>";
					}	
						echo "</div>";
					}
					
					echo "</div><div class='eventsDetailsID$event[0] loadHide'>";
					if($dateTimeLocation == "off") echo "<div id='timeInfoAndLocationID$event[0]' class='timeInfoAndLocation'>$dateFormated | $event[7] - $event[8] | $event[4]</div>";		
					if($shortDescription == "off") echo "<div id='shortDescriptionID$event[0]' class='shortDescription'>$event[5]</div>";			
					if($details == "off") {
					echo <<<_END
						<div id='eventDetailContent$event[0]'>
						<div id="contactShow"><span class='followName'>$event[9]</span>,&nbsp;$event[10]</div>
						<div id="sponsorShow">Sponsor:&nbsp;$event[11]</div>
_END;
					if($eventTag != "") {
						echo "<div id='categoryShow'>Category: $event[3] || $eventTag </div>";
					}
					else {
						echo "<div id='categoryShow'>Category: $event[3]</div>";
					}
						
						echo "</div>";
					}					
					echo <<<_END
							</div>
							<div id='postData' class='loadHide'>
								<div id='eventType'>$event[3]</div>
								<div id='eventDate'>$event[6]</div>
								<div id='location' class='location'>$event[4]</div>
								<div id='timeStart'>$event[7]</div>
								<div id='timeStop'>$event[8]</div>
								<div id='email'>$event[10]</div>
								<div id='sponsor'>$event[11]</div>
								<div id='eventDateStamp'>$eventDateStamp</div>
								<div id='currentDate'>$this->currentDate</div>
							</div>
						</div>
					</div>
_END;
				}
			}
			// end -if- statement for not posting the events under my category in the allEventsTab.
		}
		echo "</div></div>";
	}
	
	public function toggleEvent() {
		echo <<<_END
		<script>
			$(function() {
				$('span[id^="eventTitleID"]').click(function() {
					var getID = $(this).attr('id');
					var id = getID.match(/\d+/);
					var thisToggle = '.eventsDetailsID' + id;
					$(thisToggle).slideToggle("slow");
				});
			});	
		</script>
_END;
	}
	
	public function attendClick() {
		echo <<<_END
		<script>
			$(function() {
				$('span[id^="attendClick"]').click(function() {
					var getID = $(this).attr('id');
					var id = getID.match(/\d+/);
					
					var thisTitle = '#eventsRowID' + id + ' #eventTitleID' + id;
					var eventTitle = $(thisTitle).text();
					var postEventTitle =  encodeURIComponent(encodeURI(eventTitle));
					
					var thisEventType = '#eventsRowID' + id + ' #eventType';
					var eventType = $(thisEventType).text();
					
					var thisEventDate = '#eventsRowID' + id + ' #eventDate';
					var eventDate = $(thisEventDate).text();
					
					var thisEventLocation = '#eventsRowID' + id + ' #location';
					var eventLocation = $(thisEventLocation).text();
					var postEventLocation = encodeURIComponent(encodeURI(eventLocation));
					
					var thisTimeLocation = '#eventsRowID' + id + ' .timeInfoAndLocation';
					var timeLocation = $(thisTimeLocation).text();
					var postTimeLocation = encodeURIComponent(encodeURI(timeLocation));
					
					var thisShortDescription = '#eventsRowID' + id + ' #shortDescription';
					var shortDescription = $(thisShortDescription).text();
					var postShortDescription = encodeURIComponent(encodeURI(shortDescription));
					
					var thisTimeStart = '#eventsRowID' + id + ' #timeStart';
					var timeStart = $(thisTimeStart).text();
					
					var thisTimeStop = '#eventsRowID' + id + ' #timeStop';
					var timeStop = $(thisTimeStop).text();
					
					var thisContact = '#eventsRowID' + id + ' #contactShow';
					var contact = $(thisContact).text();
					var postContact = encodeURIComponent(encodeURI(contact));
					
					var thisEmail = '#eventsRowID' + id + ' #email';
					var email = $(thisEmail).text();
					var postEmail = encodeURIComponent(encodeURI(email));
					
					var thisSponsor = '#eventsRowID' + id + ' #sponsor';
					var sponsor = $(thisSponsor).text();
					var postSponsor = encodeURIComponent(encodeURI(sponsor));
					
					var thisEventDateStamp = '#eventsRowID' + id + ' #eventDateStamp';
					var eventDateStamp = $(thisEventDateStamp).text();
					
					var thisCurrentDate = '#eventsRowID' + id + ' #currentDate';
					var currentDate = $(thisCurrentDate).text();
					
					$.post('updateEventValue.php', 'eventTitle=' + postEventTitle + '&eventType=' + eventType + '&eventID=' + id + '&eventDate=' + eventDate + '&location=' + postEventLocation + '&shortDescription=' + postShortDescription + '&timeStart=' + timeStart + '&timeStop=' + timeStop + '&contactName=' + postContact + '&email=' + postEmail + '&sponsor=' + postSponsor, function(data) {
						var hideThis = '#eventsRowID' + id;
						$(hideThis).hide();
						$('#notAttending').remove();
						
						if(eventDateStamp == currentDate) {
							dateTime = "<div class='timeInfoAndLocation'><span class='brickRed'>Today | " + timeStart + " - " + timeStop + " | " + eventLocation + "</span></div>";
						}
						else {
							dateTime = "<div class='timeInfoAndLocation'>" + timeLocation + "</div>";
						}
						
						var detailID = 'detailID' + id;
						var detailContent = 'detail' + id;
						var notAttending = 'notAttending' + id;
						var notAttendingRemove = 'notAttendingRemove' + id;
						var redNotAttending = 'redNotAttending' + id;
						var attendTitleID = 'attendTitleID' + id;
						$('#attendingEventsContent').append("<div id='attendingEventsContain'><div id='eventNameCategory' class='attendingTitle'><span id=" + attendTitleID + ">" + eventTitle + "</span><span id=" + redNotAttending + " class='brickRedFont'></span></div><div id=" + notAttendingRemove + "><div id='padLeft'><div class='timeInfoAndLocation'>" + dateTime + "</div><div id='attendDetails' class='attendDetailsSpan'><span id=" + detailID + ">Hide Details</span></div><div id=" + detailContent + "><div id='contactShow'>" + contact + "</div><div class='shortDescription'>" + shortDescription + "</div><div class='notAttending'><span id=" + notAttending + " class='notAttendingBox'>Not Attending</span></div></div></div></div>");
						
						var thisDetailID = '#detailID' + id;
						var thisDetailContent = '#detail' + id;
						$(thisDetailID).click(function() {
							if($(this).data("show") == "no") {
								$(this).empty();
								$(this).append('Hide Details');
								$(thisDetailContent).show();
								$(this).data("show", "yes");
							}
							else {
								$(thisDetailContent).hide();
								$(this).empty();
								$(this).append('Details');
								$(this).data("show", "no");
							}
						});
						
						var thisNotAttending = '#notAttending' + id;
						var thisNotAttendingRemove = '#notAttendingRemove' + id;
						var thisRedNotAttending = '#redNotAttending' + id;
						var thisAttendTitleID = '#attendTitleID' + id;
						$(thisNotAttending).click(function() {
							$(thisNotAttendingRemove).hide();
							$(thisRedNotAttending).append(' [Not Attending]');
							$(thisAttendTitleID).addClass("eventNameShowClass");
							$.post('../HTML/process/processNotAttending.php', 'eventID=' + id + '&attending=no');
						});
						
						$(thisAttendTitleID).click(function() {
							$(thisRedNotAttending).empty();
							$(this).removeClass("eventNameShowClass");
							$(thisNotAttendingRemove).show();
							$.post('../HTML/process/processNotAttending.php','eventID=' + id + '&attending=yes');
						});
					});
				});	
			});
		</script>
_END;
	}
	
	public function following() {
		/*
		 * Insert a relative time at certain intervals under the following section. For example, action feed notification(s) for
		 * today under today, action feed notifactions for yesterday under yesterday, then last week, then this month,
		 * then 6 or > for each previous month. Do not include the relative time if there are
		 * not notifications for that time period. Review and compare the feed that facebook has.
		 * 
		 * Think about what the limit should be for each action feed notice
		 */
		echo <<<_END
		<div id="sharedEventsBox">
			<div id="sharedEventsTitle">Following</div>
_END;
			$querySlideBar = "Select actionFeed, Category, Attending, eventHistory, eventsCreated from Student_Settings where studentID = '$this->studentID'";
			$resultSlideBar = mysql_query($querySlideBar);
			$actionFeed = mysql_result($resultSlideBar, 0, 'actionFeed');
			$category = mysql_result($resultSlideBar, 0, 'Category');
			$attendingBar = mysql_result($resultSlideBar, 0, 'Attending');
			$eventHistoryBar = mysql_result($resultSlideBar, 0, 'eventHistory');
			$eventsCreatedBar = mysql_result($resultSlideBar, 0, 'eventsCreated');

			if($actionFeed == "n") {
				echo <<<_END
				<style type="text/css">
					#sharedEventsContent {
						display: none;
					}		
				</style>
_END;
			}
			if($category == "n") {
				echo <<<_END
				<style type="text/css">
					#allCategoriesContent {
						display: none;
					}
				</style>
_END;
			}
			if($attendingBar == "n") {
				echo <<<_END
				<style type="text/css">
					#attendingEventsContent {
						display: none;
					}
				</style>
_END;
			}
			if($eventHistoryBar == "n") {
				echo <<<_END
				<style type="text/css">
					#eventHistoryContent {
						display: none;
					}
				</style>
_END;
			}
			if($eventsCreatedBar == "n") {
				echo <<<_END
				<style type="text/css">
					#eventsCreatedContent {
						display: none;
					}
				</style>
_END;
			}
			
			$actionFeedArray = array();
			
			$groupFounder = mysql_query("Select * from Group_Founder where studentID='$this->studentID' LIMIT 10");
			$founderRows = mysql_num_rows($groupFounder);
			
			for($j = 0; $j < $founderRows; $j++) {
				
				$founder = mysql_fetch_row($groupFounder);
				$unixTime = strtotime($founder[3]);
				
				$actionFeedArray[$unixTime] = array('founder', $founder[2], $founder[1]);
			}
			
			// change all Event_Promoter calls to Group_Founder
			/* $queryPromoter = "Select * from Event_Promoter where studentID = '$this->studentID' LIMIT 10";
			$resultPromoter = mysql_query($queryPromoter);
			$promoterRows = mysql_num_rows($resultPromoter); */
			$today = 0;
			$yesterday = 0;
			$lastWeek = 0;
			
			/* for($j = 0; $j < $promoterRows; $j++) {
				
				$promoter = mysql_fetch_row($resultPromoter);
				$unixTime = strtotime($promoter[3]);
				
				$actionFeedArray[$unixTime] = array('promoter', $promoter[1], $promoter[2]);
			} */
			
			$groupFollowing = mysql_query("Select * from Group_Following where studentID='$this->studentID' LIMIT 10");
			$followingRows = mysql_num_rows($groupFollowing);
			$whoUserIsFollowing = array();
			
			for($j = 0; $j < $followingRows; $j++) {
				$following = mysql_fetch_row($groupFollowing);
				$unixTime = strtotime($following[3]);
			
				$actionFeedArray[$unixTime] = array('following', $following[2], $following[1]);
				array_push($whoUserIsFollowing, $following[1]);
			}
			
			/* $queryFollowing = "Select * from Following where studentID = '$this->studentID' LIMIT 10";
			$resultFollowing = mysql_query($queryFollowing);
			$followingRows = mysql_num_rows($resultFollowing);
			
			 for($j = 0; $j < $followingRows; $j++) {
				$following = mysql_fetch_row($resultFollowing);
				$unixTime = strtotime($following[4]);
				
				$actionFeedArray[$unixTime] = array('following', $following[2], $following[3]);
			} */
			
			$thisUserIsFollowing = join(',', $whoUserIsFollowing);
			
			$getUserFollowingEvents = mysql_query("Select * from Made_Events where groupID in ($thisUserIsFollowing) order by unixTimeCreated DESC LIMIT 10");
			$userFollowingEvventsRows = mysql_num_rows($getUserFollowingEvents);
			
			//Make sure this works with more than one sharing post
			for($j = 0; $j < $userFollowingEvventsRows; $j++) {
				$followingEvent = mysql_fetch_row($getUserFollowingEvents);
				$unixTime = $followingEvent[15];
				
				$actionFeedArray[$unixTime] = array('sharingFollow', $followingEvent[18], $followingEvent[2], $followingEvent[0], $followingEvent[12], $followingEvent[7], $followingEvent[8], $followingEvent[4], $followingEvent[5], $followingEvent[9], $followingEvent[10], $followingEvent[11]);
			}
			
			// use multisort here... if it's at the same time multiple occurences will be removed...fix
			krsort($actionFeedArray);
// 			echo $this->addRelativeTime($actionFeedArray);
			echo <<<_END
				<div id='sharedEventsContent'>
				<script>
					$(function() {
					
						$('span[id^="shareFeedTitle"]').click(function() {
							var getID = $(this).attr('id');
							var ID = getID.match(/\d+/);
							var thisBubble = '#bubblePopUp' + ID;
							var thisClose = '#closeID' + ID;
							$(thisClose).click(function() {
								$(thisBubble).hide();
								$(thisBubble).data("show", "no");
							});
							if($(thisBubble).data("show") == "yes") {
								$(thisBubble).hide();
								$(thisBubble).data("show", "no");
							}
							else {
								$(thisBubble).show();
								$(thisBubble).data("show", "yes");
							}
						});
					});
				</script>
_END;
			
			foreach($actionFeedArray as $key => $arrayValue) {

				$currentTime = date('F j, y', $key);
				if($arrayValue[0] == 'founder') {
					echo "<div id='actionFeed'><div id='actionFeedTime'>$currentTime</div>People can now follow [ <a href='followPage.php?fp=$arrayValue[2]&loc=home'><span class='type1Link'>$arrayValue[1]</span></a> ].</div>";
				}
				elseif($arrayValue[0] == 'following') {
					echo "<div id='actionFeed'><div id='actionFeedTime'>$currentTime</div>You are now following [ <a href='followPage.php?fp=$arrayValue[2]&loc=home'><span class='type1Link'>$arrayValue[1]</span></a> ].</div>";
				}
				elseif($arrayValue[0] == 'sharingFollow') {
					$dateFormatted = date('l, F j, y', $arrayValue[4]);;
					echo <<<_END
						<div id='actionFeed'>
							<div id='actionFeedTime'>$currentTime</div>$arrayValue[1]&nbsp;posted
							<span id='followShareFeed'>
								<span id='shareFeedTitle$arrayValue[3]' class='hoverNoUnderline'>$arrayValue[2]</span></span>.
							<span class='bubbleContainerHome'>
								<span id='bubblePopUp$arrayValue[3]' class='loadHide'>
									<span class='bubble'>
										<div id='bubbleTitleContent'>$dateFormatted<span id='closeID$arrayValue[3]'><span id='closeButton'>X</span></span></div>
										<div id='bubbleContent'>$arrayValue[5] - $arrayValue[6] | $arrayValue[7]</div>
										<div id='bubbleContent'>$arrayValue[9], $arrayValue[10]</div>
										<div id='bubbleContent'>Sponsor: $arrayValue[11]</div>
										<div id='bubbleHorizontal'></div>
										<div id='bubbleDescription'>$arrayValue[8]</div>
									</span>
									<span class='bubbleOutline'></span>
								</span>
							</span>
						</div>
_END;
				}
			}
			echo <<<_END
			</div>
			</div>
			<script>
				$(function() {
					var show;
					$.get('slideBarSettings.php', 'slideBar=actionFeed', function(data) {
							if(data == "y") {
								show = "yes";
							}
							else {
								show = "no";
							}
						}
					);
					$('#sharedEventsTitle').click(function() {
						if(show == "yes") {
							$('#sharedEventsContent').slideUp(700);
							show = "no";
							$.get('slideBarSettings.php', 'slideBar=actionFeed&updateSlideBar=no');
						}
						else {
							$('#sharedEventsContent').slideDown(700);
							show = "yes";
							$.get('slideBarSettings.php', 'slideBar=actionFeed&updateSlideBar=yes');				
						}
					});
				});
			</script>
_END;
	}
	
	private function addRelativeTime($actionFeedArray) {
		
	}
	
	public function map() {
		echo <<<_END
		<div id="allCategoriesBox">
			<div id='allCategoriesTitle'>Map</div>
			<div id='allCategoriesContent'>
			<script src='http://maps.google.com/maps/api/js?sensor=false&amp;language=en'></script>
			<script src='gmap3.js'></script>
			
			<!--<script>
				$(function() {
					$('#map').gmap3({
						map:{
							options: {
							center:[33.775618,-84.396285],
							zoom: 15,
							mapTypeId: google.maps.MapTypeId.ROADMAP 
							}
						}
					});
				});
			</script>-->
			<div class='centerOfCampus'><span id='centerOfCampus'>Center of Campus</span></div>
			<div id='map'></div>
			</div>
		</div>
		<script>
			$(function() {
				var show;
				$.get('slideBarSettings.php', 'slideBar=categories', function(data) {
						if(data == "y") {
							show = "yes";
						}
						else {
							show = "no";
						}
					}
				);
				$('#allCategoriesTitle').click(function() {
					if(show == "yes") {
						$('#allCategoriesContent').slideUp(700);
						show = "no";
						$.get('slideBarSettings.php', 'slideBar=categories&updateSlideBar=no');
						
					}
					else {
						$('#allCategoriesContent').slideDown(700);
						show = "yes";
						$.get('slideBarSettings.php', 'slideBar=categories&updateSlideBar=yes');
					}
				});
			});
		</script>
_END;
	}

	public function eventsAttending() {
		echo <<<_END
		<div id="attendingBox">
		<div id="attendingBoxTitle">Attending</div>
		<div id="attendingEventsContent">
_END;
	
		$queryAttending = "Select * from Event_Attendee where studentID='$this->studentID' and eventDateUnix >= '$this->currentDate' order by attending DESC, eventDateUnix ASC";
		$resultAttending = mysql_query($queryAttending);
		$totalAttending = mysql_num_rows($resultAttending);
		
		if($totalAttending == false) {
			echo "<div id='notAttending'><div id='attendingEventsContain'>You aren't attending any events.</div></div>";
		}
		else {
			for($j = 0; $j < $totalAttending; $j++) {
				$rowAttending = mysql_fetch_row($resultAttending);
				$eventDate = $rowAttending[7];
				$eventDateStamp = strtotime($eventDate);
				$dayFormated = date('l, F j, y', $eventDateStamp);
				$attending = $rowAttending[6];
				
				echo <<<_END
				<div id='attendingEventsContain'>
				<div id='attending$rowAttending[0]'>
						<div id='eventNameCategory'>
							<div id='attendingTitle'><span id='attendClick$rowAttending[4]'>$rowAttending[5]</span><span id='red$rowAttending[0]'></span></div>
						</div>
					<div id='padLeft'>
					<div id='hideNotAttending$rowAttending[0]'>
_END;
				if($attending == "no") {
					echo <<<_END
					<script>
						$(function() {
							$("#red$rowAttending[0]").append("<span class='brickRedFont'> [Not Attending]</span>");
							$('#hideNotAttending$rowAttending[0]').hide();
							$("#attendClick$rowAttending[4]").addClass("eventNameShowClass");
						});
					</script>
_END;
				}
				if($eventDateStamp == $currentDate) {
					echo "<div class='timeInfoAndLocation'><span class='brickRed'>Today | $rowAttending[12] - $rowAttending[13] | $rowAttending[10]</span></div>";
				}
				else {
					echo "<div class='timeInfoAndLocation'>$dayFormated | $rowAttending[12] - $rowAttending[13] | $rowAttending[10]</div>";
				}
				echo <<<_END
						<div id='attendDetails'><span class='attendDetailsSpan'><span id='detailIDphp$rowAttending[0]'>Details</span></span></div>
						<div id='detailContent$rowAttending[0]' class='loadHide'>
						<div id='detailFont'>
							<div id='contactShow'>$rowAttending[14],&nbsp;$rowAttending[15]</div>
							<div id='sponsorShow'>Sponsor:&nbsp;$rowAttending[16]</div>
							<div id='categoryShow'>$rowAttending[9]</div>
							<div class='shortDescription'>$rowAttending[11]</div>
							<div class='notAttending'><span class='notAttendingBox'><span id='notAttending$rowAttending[0]'>Not Attending</span></span></div>
						</div>
						</div><!--detail-->
						<script>
							$(function() {
								$('#notAttending$rowAttending[0]').click(function() {
									$("#red$rowAttending[0]").append("<span class='brickRedFont'>&nbsp;[Not Attending]</span>");
									$.post('../HTML/process/processNotAttending.php', 'eventID=$rowAttending[4]&attending=no', function() {
										$('#hideNotAttending$rowAttending[0]').hide();
										$("#attendClick$rowAttending[4]").addClass("eventNameShowClass");
									});
								});
								$('#attendClick$rowAttending[4]').click(function() {
									$("#red$rowAttending[0]").empty();
									$.post('../HTML/process/processNotAttending.php', 'eventID=$rowAttending[4]&attending=yes', function() {
										$('#hideNotAttending$rowAttending[0]').show();
										$("#attendClick$rowAttending[4]").removeClass("eventNameShowClass");
									});
								});
							});
						</script>
						</div><!--padLeft-->
					</div><!--hideNotAttending-->
				<div id='eventSpacing'></div>
				</div><!--attending-->
				</div><!--attendingEventsContain-->
_END;
			}
		}
	echo <<<_END
		</div><!--attendingEventsContent-->
	</div><!--attendingEventsBox-->
	<script>
		$(function() {
			
			$('span[id^="detailIDphp"]').click(function() {
				
				var id = $(this).attr('id');
				var getID = id.match(/\d+/);
				var detailContent = '#detailContent' + getID;
				
				if($(this).data("show") == "no") {
					$(this).empty();
					$(this).append('Details');
					$(detailContent).hide();
					$(this).data("show", "yes");
				}
				else {
					$(detailContent).show();
					$(this).prepend('Hide ');
					$(this).data("show", "no");
				}
			});
			
			var show;
			$.get('slideBarSettings.php', 'slideBar=attending', function(data) {
					if(data == "y") {
						show = "yes";
					}
					else {
						show = "no";
					}
				}
			);
			$('#attendingBoxTitle').click(function() {
				if(show == "yes") {
					$('#attendingEventsContent').slideUp(700);
					show = "no";
					$.get('slideBarSettings.php', 'slideBar=attending&updateSlideBar=no');
				}
				else {
					$('#attendingEventsContent').slideDown(700);
					show = "yes";
					$.get('slideBarSettings.php', 'slideBar=attending&updateSlideBar=yes');
				}
			});
		});
	</script>
_END;
	}
	
	public function eventHistory() {
		echo <<<_END
		<div id="eventHistoryBox">
			<div id="eventHistoryTitle">Attending History</div>
			<div id="eventHistoryContent">
_END;
			// can probably remove unused columns on event_attendee 
			$resultEventHistory = mysql_query("Select eventID from Event_Attendee where attending='yes' and studentID = '$this->studentID' and eventDateUnix < '$this->currentDate' order by eventAttended Desc limit 10");
			$eventHistoryRows = mysql_num_rows($resultEventHistory);
			
			if($eventHistoryRows == false) {
				echo "<div class='eventHistoryContain'>You haven't attended any events.</div>";
			}
			else {
				for($j = 0; $j < $eventHistoryRows; $j++) {
					
					$eventHistory = mysql_result($resultEventHistory, $j);
					$resultHistoryMatch = mysql_query("Select * from Made_Events where id='$eventHistory'");
					$historyMatch = mysql_fetch_row($resultHistoryMatch);
					$unixTimeDate = $historyMatch[12];
					$dateFormatted = date('F j, y', $unixTimeDate);
					
					echo <<<_END
					<div id='eventHistoryContain$historyMatch[0]' class='eventHistoryContain'>
						<span id='eventHistoryNumber$historyMatch[0]' class='type1Link'>$historyMatch[2]</span><div id='box2TitleCorner'>$dateFormatted</div>
						<div id='historyEventHide$historyMatch[0]' class='loadHide'>
							<div class='eventHistoryDetails'>$historyMatch[7] - $historyMatch[8] | $historyMatch[4]</div>
							<div>
								<div class='eventHistoryDetails'>$historyMatch[5]</div>
								<div class='eventHistoryDetails'>$historyMatch[9], $historyMatch[10] </div>
								<div class='eventHistoryDetails'>Type: $historyMatch[3]</div>
							</div>
						</div>
					</div>	
_END;
				}
			}
			echo <<<_END
			</div><!--eventHistoryContent-->
		</div><!--eventHistoryBox-->
		<script>
			$(function() {
				var show;
				// you don't have to make a server request.. just determine if content is hiding.
				$.get('slideBarSettings.php', 'slideBar=eventHistory', function(data) {
						if(data == "y") {
							show = "yes";
						}
						else {
							show = "no";
						}
					}
				);
				$('#eventHistoryTitle').click(function() {
					if(show == "yes") {
						$('#eventHistoryContent').slideUp(700);
						show = "no";
						$.get('slideBarSettings.php', 'slideBar=eventHistory&updateSlideBar=no');
					}
					else {
						$('#eventHistoryContent').slideDown(700);
						show = "yes";
						$.get('slideBarSettings.php', 'slideBar=eventHistory&updateSlideBar=yes');
					}
				});
				
				var thisID;
				$('span[id^="eventHistoryNumber"]').click(function() {
					thisID = $(this).attr('id').match(/\d+/);
					if($(this).data("show") == "no") {
						$('#eventHistoryContain' + thisID).css({
							'border-top' : '',
							'border-bottom' : '',
							'padding' : '',
							'background-color' : ''
						});
						$(this).css('text-decoration', '');
						$('#historyEventHide' + thisID).hide();
						$(this).data("show", "yes");
					}
					else {
						$('#eventHistoryContain' + thisID).css({
							'border-top' : '1px solid #CDCDCD',
							'border-bottom' : '1px solid #CDCDCD',
							'padding' : '5px 3px',
							'background-color' : 'rgb(250, 250, 250)',
						});
						$(this).css('text-decoration', 'underline');
						$('#historyEventHide' + thisID).show();
						$(this).data("show", "no");
					}
					
				});
			});
		</script>
		
_END;
	}

	public function eventsCreated() {
		echo <<<_END
		<div id="eventsCreatedBox">
			<div id="eventsCreatedTitle">Stuff Created</div>
			<div id='eventsCreatedContent'>
_END;
		$resultEventsCreated = mysql_query("Select * from Made_Events where studentID='$this->studentID' order by id DESC LIMIT 10");
		$eventsCreatedRows = mysql_num_rows($resultEventsCreated);
		
		if($eventsCreatedRows != false) {
			for($j = 0; $j < $eventsCreatedRows; $j++) {
				$eventsCreated = mysql_fetch_row($resultEventsCreated);
				$dateCreated = date('F j, y', $eventsCreated[15]);
		
				echo <<<_END
					<div id='eventsCreatedContain$eventsCreated[0]' class='eventsCreatedContain'>
						<span id='eventCreated$eventsCreated[0]' class='type1Link'>$eventsCreated[2]</span><div id='box2TitleCorner'>$dateCreated</div>	
						<div id='showCreatedDetails$eventsCreated[0]' class='loadHide'>
							<div class='eventsCreatedDetails'>$eventsCreated[7] - $eventsCreated[8] | $eventsCreated[4]</div>
							<div>
								<div class='eventHistoryDetails'>$eventsCreated[5]</div>
								<div class='eventHistoryDetails'>$eventsCreated[9], $eventsCreated[10] </div>
								<div class='eventHistoryDetails'>Type: $eventsCreated[3]</div>
							</div>
						</div>
					</div>			
_END;
			}
		}
		echo <<<_END
			</div>
		</div><!--eventsCreatedBox-->
		<script>
			$(function() {
				
				var show;
				$.get('slideBarSettings.php', 'slideBar=eventsCreated', function(data) {
						if(data == "y") {
							show = "yes";
						}
						else {
							
							show = "no";
						}
					}
				);
				$('#eventsCreatedTitle').click(function() {
					if(show == "yes") {
						$('#eventsCreatedContent').slideUp(700);
						show = "no";
						$.get('slideBarSettings.php', 'slideBar=eventsCreated&updateSlideBar=no');
					}
					else {
						$('#eventsCreatedContent').slideDown(700);
						show = "yes";
						$.get('slideBarSettings.php', 'slideBar=eventsCreated&updateSlideBar=yes');
					}
				});
				
				var thisID;
				$('span[id^="eventCreated"]').click(function() {
					thisID = $(this).attr('id').match(/\d+/);
					if($(this).data("show") == "no") {
						$('#eventsCreatedContain' + thisID).css({
							'border-top' : '',
							'border-bottom' : '',
							'padding' : '',
							'background-color' : ''
						});
						$(this).css('text-decoration', '');
						$('#showCreatedDetails' + thisID).hide();
						$(this).data("show", "yes");
					}
					else {
						$('#eventsCreatedContain' + thisID).css({
							'border-top' : '1px solid #CDCDCD',
							'border-bottom' : '1px solid #CDCDCD',
							'padding' : '5px 3px',
							'background-color' : 'rgb(250, 250, 250)',
						});
						$(this).css('text-decoration', 'underline');
						$('#showCreatedDetails' + thisID).show();
						$(this).data("show", "no");
					}
					
				});
			});
		</script>
_END;
	}

	public function header() {
		
		echo <<<_END
		<!--this causes an error with ad gallery?<script src="../HTML/scripts/jquery-1.9.1.min.js"></script>-->
		<script>
			$(function() {
				$('#searchTime').click(function() {
					$('#searchSomething').css('background-color', 'white');
					$('#searchBoth').css('background-color', 'white');
					$(this).css('background-color', 'rgb(225, 225, 225)');
				});
				$('#searchBoth').click(function() {
					$('#searchSomething').css('background-color', 'white');
					$('#searchTime').css('background-color', 'white');
					$(this).css('background-color', 'rgb(225, 225, 225)');
				});
				$('#searchSomething').click(function() {
					$('#searchTime').css('background-color', 'white');
					$('#searchBoth').css('background-color', 'white');
					$(this).css('background-color', 'rgb(225, 225, 225)');
				});
			
				$('#nameTagStyle').click(function() {
					$('#nameTagBox').show();
				});
			
			});
		</script>
		<div id="header">
			<div id="studentNameHeader"><div id='nameTag' class='floatContain'><span id='nameTagStyle'>$this->firstName $this->lastName <a href="signout.php">Log out</a></span></div></div>
			<div id="name">
				<span id='logo'><a href="newHome.php">eventjacket</a></span>&nbsp;<a href='createData.php'>Create Data</a><a href='approveTags.php'> || Approve Tags</a>
			<div id='bottomSpaceHeader'></div>
			</div>
		</div>
_END;
		/* <div id="search">
		 <div>
		<span id='searchSomething'>Thing</span>
		<span id='searchTime'>Time</span>
		<span id='searchBoth'>Both</span>
		</div>
		<div id="searchFloat">
		<div id='searchButton'>Search</div>
		<input type="text" size="33" placeholder="something | 00-00am/pm, 00-00am/pm"></input>
		</div>
		</div> */
	}
	
	public function linksNav() {
		echo <<<_END
		<link type="text/css" rel="stylesheet" href="../HTML/CSS/linkBar.css" />
		<div id="linkBar">
			<a href="newHome.php"><div id="home">Home</div></a><!--this comment assures no white space
			--><a href="createEvent.php"><div id="createEvent">Create Event</div></a><!--this comment assures no white space
			--><a href='followList.php'><div id="follow">Groups</div><!--
			--><a href='createfollowpage.php'><div id='groupPage'>Create Group Page</div></a>
		</div>
_END;
	}
}

?>