<?php
session_start();
include_once($_SERVER['DOCUMENT_ROOT'].'/src/control/RedirectForward.php');
if(isset($_SESSION['taichinhondealer'])) {
	unset($_SESSION['taichinhondealer']);
}
redirect("/");

?>