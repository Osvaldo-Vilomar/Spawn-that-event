<?php 

session_start();

setcookie('tabCookie', '', time() - 2592000);

$tabCategory = $_GET['category'];
setcookie('tabCookie', $tabCategory);

?>