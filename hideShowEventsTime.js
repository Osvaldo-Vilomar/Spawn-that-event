$(function() {
	$('.today').click(function() {
		$('.todayShow').show();
		$('.tomorrowShow').hide();
		$('.weeklyShow').hide();
		
		$.post('certainTime.php', 'timeChosen=today', function() {
			refresh();
		});
	});
	
	$('.tomorrow').click(function() {
		$('.todayShow').hide();
		$('.weeklyShow').hide();
		$('.tomorrowShow').show();
		$('.eventDate').hide();
		
		$.post('certainTime.php', 'timeChosen=tomorrow', function() {
			refresh();
		});
	});
	
	$('.weekly').click(function() {
		$('.weeklyShow').show();
		$('.todayShow').hide();
		$('.tomorrowShow').hide();
		$('.eventDate').show();
		
		$.post('certainTime.php', 'timeChosen=weekly', function() {
			refresh();
		});
	});	
});