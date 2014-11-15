<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/src/db/connectdatabase.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/src/control/RedirectForward.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/src/entitys/Status.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/src/DAO/StatusDAO.php');
session_start();

$url = "/admin/?content=quanli&p=add-status";
if(isset($_SESSION['adminlogintcdealeronline'])) {
	if(isset($_POST['tenstatus'])) {
		$idStatus = time();
		$nameStatus = trim($_POST['tenstatus']);
		$aStatus = new Status();
		$statusDao = new StatusDAO();
		$aStatus -> setStatusID($idStatus);
		$aStatus -> setStatusName($nameStatus);
		$aStatus -> setDateCreated(time());
		
		if($statusDao -> insertStatus($aStatus)) {
			$url .= "&mess=success";
		} else {
			$url .= "&mess=fail";
		}
	}
}
redirect($url);

?>