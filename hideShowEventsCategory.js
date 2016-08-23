// change recreation to leisure
$(function() {
	
	if($('#religionOn').length > 0) {
		var iterationValueRel = false;
	}
	else if($('#religionOff').length > 0) {
		var iterationValueRel = true;
	}
	
	if($('#volunteerOn').length > 0) {
		var iterationValueVol = false;
	}
	else if($('#volunteerOff').length > 0) {
		var iterationValueVol = true;
	}
	
	if($('#leisureOn').length > 0) {
		var iterationValueLei = false;
	}
	else if($('#leisureOff').length > 0) {
		var iterationValueLei = true;
	}
	
	if($('#healthOn').length > 0) {
		var iterationValueHea = false;
	}
	else if($('#healthOff').length > 0) {
		var iterationValueHea = true;
	}
	
	if($('#scienceOn').length > 0) {
		var iterationValueSci = false;
	}
	else if($('#scienceOff').length > 0) {
		var iterationValueSci = true;
	}
	
	if($('#workshopsOn').length > 0) {
		var iterationValueWor = false;
	}
	else if($('#workshopsOff').length > 0) {
		var iterationValueWor = true;
	}
	
	if($('#internationalOn').length > 0) {
		var iterationValueInt = false;
	}
	else if($('#internationalOff').length > 0) {
		var iterationValueInt = true;
	}
	
	$('#number1').click(function() {
		$('.religionShow').toggle();
		
		if(iterationValueRel == true) {
			$('#number1').css('background-color', 'rgb(228, 228, 228)');
			$.ajax({
				type: "POST",
				url: "savePreferences.php",
				data: {categoryType: 'religion', categorySetting: 'On'}
			});
			iterationValueRel = false;
		}
		else {
			$('#number1').css('background-color', 'white');
			$.ajax({
				type: "POST",
				url: "savePreferences.php",
				data: {categoryType: 'religion', categorySetting: 'Off'}
			});
			iterationValueRel = true;
		}
	});
	
	$('#number2').click(function() {
		$('.volunteerShow').toggle();
		
		if(iterationValueVol == true) {
			$('#number2').css('background-color', 'rgb(228, 228, 228)');
			$.ajax({
				type: "POST",
				url: "savePreferences.php",
				data: {categoryType: 'volunteer', categorySetting: 'On'}
			});
			iterationValueVol = false;
		}
		else {
			$('#number2').css('background-color', 'white');
			$.ajax({
				type: "POST",
				url: "savePreferences.php",
				data: {categoryType: 'volunteer', categorySetting: 'Off'}
			});
			iterationValueVol = true;
		}
	});

	$('#number3').click(function() {
		$('.leisureShow').toggle();
		
		if(iterationValueLei == true) {
			$('#number3').css('background-color', 'rgb(228, 228, 228)');
			$.ajax({
				type: "POST",
				url: "savePreferences.php",
				data: {categoryType: 'leisure', categorySetting: 'On'}
			});
			iterationValueLei = false;
		}
		else {
			$('#number3').css('background-color', 'white');
			$.ajax({
				type: "POST",
				url: "savePreferences.php",
				data: {categoryType: 'leisure', categorySetting: 'Off'}
			});
			iterationValueLei = true;
		}
	});

	$('#number4').click(function() {
		$('.healthShow').toggle();
		
		if(iterationValueHea == true) {
			$('#number4').css('background-color', 'rgb(228, 228, 228)');
			$.ajax({
				type: "POST",
				url: "savePreferences.php",
				data: {categoryType: 'health', categorySetting: 'On'}
			});
			iterationValueHea = false;
		}
		else {
			$('#number4').css('background-color', 'white');
			$.ajax({
				type: "POST",
				url: "savePreferences.php",
				data: {categoryType: 'health', categorySetting: 'Off'}
			});
			iterationValueHea = true;
		}
	});

	$('#number5').click(function() {
		$('.scienceShow').toggle();
		
		if(iterationValueSci == true) {
			$('#number5').css('background-color', 'rgb(228, 228, 228)');
			$.ajax({
				type: "POST",
				url: "savePreferences.php",
				data: {categoryType: 'science', categorySetting: 'On'}
			});
			iterationValueSci = false;
		}
		else {
			$('#number5').css('background-color', 'white');
			$.ajax({
				type: "POST",
				url: "savePreferences.php",
				data: {categoryType: 'science', categorySetting: 'Off'}
			});
			iterationValueSci = true;
		}
	});

	$('#number6').click(function() {
		$('.workshopsShow').toggle();
		
		if(iterationValueWor == true) {
			$('#number6').css('background-color', 'rgb(228, 228, 228)');
			$.ajax({
				type: "POST",
				url: "savePreferences.php",
				data: {categoryType: 'workshops', categorySetting: 'On'}
			});
			iterationValueWor = false;
		}
		else {
			$('#number6').css('background-color', 'white');
			$.ajax({
				type: "POST",
				url: "savePreferences.php",
				data: {categoryType: 'workshops', categorySetting: 'Off'}
			});
			iterationValueWor = true;
		}
	});
	
	$('#number7').click(function() {
		$('.internationalShow').toggle();
		
		if(iterationValueInt == true) {
			$('#number7').css('background-color', 'rgb(228, 228, 228)');
			$.ajax({
				type: "POST",
				url: "savePreferences.php",
				data: {categoryType: 'international', categorySetting: 'On'}
			});
			iterationValueInt = false;
		}
		else {
			$('#number7').css('background-color', 'white');
			$.ajax({
				type: "POST",
				url: "savePreferences.php",
				data: {categoryType: 'international', categorySetting: 'Off'}
			});
			iterationValueInt = true;
		}
	});
});