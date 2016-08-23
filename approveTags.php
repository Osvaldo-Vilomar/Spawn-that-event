<?php

require_once 'serverLogin.php';

if(isset($_GET['tagExists']) &&
	isset($_GET['thisCategory'])) {
	
	$tag = $_GET['tagExists'];
	$eventType = $_GET['thisCategory'];
	
	if(mysql_num_rows(mysql_query("Select * from AvailableTags where category='$eventType' and tag='$tag'"))) {
		echo "exists";
	}
	else {
		echo "doesntExist";
	}
}
else {
	$resultApproveTags = mysql_query("Select * from AuthorizeTag");
	$rows = mysql_num_rows($resultApproveTags);
	
	echo "Approve Tags<br/>n = not approved, y = yes approved<br/><br/>";
	for($j = 0; $j < $rows; $j++) {
		$tag = mysql_fetch_row($resultApproveTags);
	
		echo "$tag[0] $tag[1] <span id='$tag[0]$tag[1]'>$tag[2]</span> || <span id='categoryYes$tag[0]' class='$tag[1]'>yes</span> - <span id='categoryNo$tag[0]' class='$tag[1]'>no</span><br/>";
	}
		
	echo <<<_END
	<script src='../HTML/scripts/jquery-1.9.1.min.js'></script>
	<script>
		$(function() {
	
			$('span[id^="category"]').css('cursor', 'pointer');
		
			$('span[id^="category"]').hover(function() {
				$(this).css('text-decoration' , 'underline');
			},
			function() {
				$(this).css('text-decoration' , '');
			});
		
			$('span[id^="category"]').hover(function() {
				$(this).css('text-decoration' , 'underline');
			},
			function() {
				$(this).css('text-decoration' , '');
			});
		
			var thisID;
			var id;
			var thisClass;
			$('span[id^="categoryYes"]').click(function() {
				thisID = $(this).attr('id');
				id = thisID.substring(11);
				thisClass= $(this).attr('class');
				$.post('approveTags.php', 'update=yes&category=' + id + '&thisClass=' + thisClass, function() {
					$('#' + id + thisClass).text('y');
				});
			});
			$('span[id^="categoryNo"]').click(function() {
				thisID = $(this).attr('id');
				id = thisID.substring(10);
				thisClass= $(this).attr('class');
				$.post('approveTags.php', 'update=no&category=' + id + '&thisClass=' + thisClass, function() {
					$('#' + id + thisClass).text('n');
				});
			});
		});
	</script>
_END;
	
	if(isset($_POST['update'])) {
		
		$update = $_POST['update'];
		$eventType = $_POST['category'];
		$tag = $_POST['thisClass'];
		$eventID = mysql_result(mysql_query("Select eventID from AuthorizeTag where eventType = '$eventType' and tag='$tag'"), 0);
		
		if($update == 'yes') {
			mysql_query("Update AuthorizeTag set authorize = 'y' where eventType = '$eventType' and tag='$tag'");
			mysql_query("Insert into AvailableTags values ('$tag', '$eventType')");
			mysql_query("Update Made_Events set eventTag = '$tag' where id='$eventID'");
		}
		else {
			mysql_query("Update AuthorizeTag set authorize = 'n' where eventType = '$eventType' and tag='$tag'");
			mysql_query("Delete from AvailableTags where tag='$tag' and category='$eventType'");
			mysql_query("Update Made_Events set eventTag = '' where id='$eventID'");
		}
	}
}
	
?>