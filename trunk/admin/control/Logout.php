<?php
session_start();
include_once($_SERVER['DOCUMENT_ROOT'].'/src/control/RedirectForward.php');
if(isset($_SESSION['adminlogintcdealeronline'])) {
	session_destroy();
}
redirect("/admin/");

?>