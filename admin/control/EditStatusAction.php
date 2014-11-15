<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/src/db/connectdatabase.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/src/control/RedirectForward.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/src/entitys/Status.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/src/DAO/StatusDAO.php');
session_start();

$url = "/admin/?content=quanli&p=edit-status";
if(isset($_SESSION['adminlogintcdealeronline'])) {
	if(isset($_POST['mastatus']) && isset($_POST['tenstatus'])) {
		$idStatus = trim($_POST['mastatus']);
		$nameStatus = trim($_POST['tenstatus']);
		$aStatus = new Status();
		$statusDao = new StatusDAO();
		$aStatus -> setStatusID($idStatus);
		$aStatus -> setStatusName($nameStatus);
		$aStatus -> setDateUpdate(time());
		
		$url .= "&id=".$idStatus;
		if($statusDao -> updateStatus($aStatus)) {
			$url .= "&mess=success";
		} else {
			$url .= "&mess=fail";
		}
	}
}
redirect($url);

?>