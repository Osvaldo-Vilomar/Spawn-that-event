function validateEventName(entered) {
	if(entered == "") return "Must include Event Title.\n"
	return ""
}

function validateEventType(entered) {
	if(entered == "") return "Must select the Event Type.\n"
	return ""
}

function validateEventDate(date1, date2, date3) {
	if(date1 > 12) return "Invalid month.\n"
	else if(date2 > 31) return "Invalid day.\n"
	else if(date1 == "" && date2 == "" && date3 == "") return "Please enter mm/dd/yy.\n"
	else if(date1 == "" && date2 == "") return "Please enter mm/dd.\n"
	else if(date1 == "" && date3 == "") return "Please enter mm and yy.\n"
	else if(date2 == "" && date3 == "") return "Please enter mm and yy.\""
	else if(date1 == "") return "Please enter the month.\n"
	else if(date2 == "") return "Please enter the day.\n"
	else if(date3 == "") return "Please enter the year.\n"
	return ""
}

function validateEventTime(hour1, minutes1, hour2, minutes2) {
	if(hour1 > 12) return "Starting hour using 12 hour notation.\n"
	else if(minutes1 > 60) return "Starting minute range: 0-60.\n"
	else if(hour2 > 12) return "End hour using 12 hour notation.\n"
	else if(minutes2 > 60) return "End minutes range: 0-60.\n"
	else if(hour1 == 0 && hour2 == 0) return "Please enter starting hour and ending hour.\n"
	else if(hour1 == 0) return "Please enter starting hour.\n"
	else if(hour2 == 0) return "Please enter ending hour.\n"
	return ""
}
function validateLocation(entered) {
	if(entered == "") return "Must enter Event Location.\n"
	return ""
}

function validateShortDescription(entered) {
	if(entered == "") return "Must enter a short description.\n"
	return ""
}

function validateName(entered) {
	if(entered == "") return "Must enter a contact name.\n"
	return ""
}

function validateContact(entered) {
	if(entered == "") return "Must enter a contact email address.\n"
	return ""
}