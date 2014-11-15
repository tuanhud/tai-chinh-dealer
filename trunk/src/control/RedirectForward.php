<?php
function redirect($url) {
	$host  = $_SERVER['HTTP_HOST'];
	$urlrequest = "http://$host/";
	
	header("Location: $urlrequest$url");
}
?>