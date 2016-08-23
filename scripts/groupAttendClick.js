
var thisID;
var number;
var groupTitle;
var groupDate;
var groupTimeStart;
var groupTimeEnd;
var groupLocation;
var groupShortDescription;
var groupContactName;
var groupContactEmail;

$('span[id^="groupAttendButtonID"]').click(function() {
	thisID = $(this).attr('id');
	number = thisID.match(/\d+/);
	groupTitle = thisContent('#groupEventTitle' + number); 
	groupDate = thisContent('#groupDateID' + number);
	groupTimeStart = thisContent('#groupStartTimeID' + number);
	groupTimeEnd = thisContent('#groupStopTimeID' + number);
	groupLocation = thisContent('#groupLocationID' + number);
	groupShortDescription = thisContent('#groupEventShortDescription' + number);
	groupContactName = thisContent('#groupEventContactName' + number);
	groupContactEmail = thisContent('#groupEventEmail' + number);
	groupEventType = thisContent('#groupEventType' + number);
	groupSponsor = thisContent('#groupEventSponsorID' + number);
	
	$('#followUserAttendingContent').prepend("<div id='groupUserAttending'><div id='followAttendingEventID" + number + "' class='followAttendingRow'><span id='followAttendingEventSpan" + number + "'>" + groupTitle + "</span></div><div id='eventAllDetails" + number + "'><div class='followingAttendingDTL'>" + groupDate + " | " + groupTimeStart + " - " + groupTimeEnd + " | " + groupLocation + "</div><div class='followingAttendingDetails'><span id='followingAttendingDetailsID" + number + "' class='attendDetailsSpan'>Details</span></div><div id='followAttendingDetailsContent" + number + "' class='loadHide'><div class='followingAttendingDetailsContent'>" + groupShortDescription + "</div><div class='followingAttendingDetailsContent'>" + groupContactName + ", " + groupContactEmail + "</div><div class='followingAttendingDetailsContent'><span id='followEventNotAttending" + number + "' class='followingNotAttendingBox'>Not Attending</span></div></div><div id='detailsBottomBar" + number + "'></div></div></div>");
	
	if($('#groupAttendingNoEvents').length) {
		$('#groupAttendingNoEvents').remove();
	}
	
	data = new Object();
	data.eventID = number[0];
	data.eventTitle = sanitize(groupTitle);
	data.eventDate = groupDate;
	data.timeStart = sanitize(groupTimeStart);
	data.timeStop = sanitize(groupTimeEnd);
	data.location = sanitize(groupLocation);
	data.shortDescription = sanitize(groupShortDescription);
	data.contactName= sanitize(groupContactName);
	data.email = sanitize(groupContactEmail);
	data.eventType = sanitize(groupEventType);
	data.sponsor = sanitize(groupSponsor);
	$.post('../HTML/process/processEventAttending.php', data, function(data) {
		$('#thisGroupEventContain' + number).remove();
	});
});


function thisContent(thisID) {
	return $(thisID).text();
}

function sanitize(data) {
	return encodeURIComponent(data);
}