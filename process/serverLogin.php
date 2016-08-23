<?php 

$db_hostname = 'localhost:8080';
$db_database = 'CampusConnect';
$db_username = 'Osvaldo';
$db_password = 'eaglebrown1';

$db_server = mysql_connect($db_hostname, $db_username, $db_password);

if(!$db_server) die("Unable to connect to MySQL: " . mysql_error());

mysql_select_db($db_database)
or die("Unable to select database: " . mysql_error());

?>