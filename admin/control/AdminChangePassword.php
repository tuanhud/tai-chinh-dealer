<?php
session_start();
include_once($_SERVER['DOCUMENT_ROOT'].'/src/control/RedirectForward.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/src/entitys/ManagerUser.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/src/DAO/ManagerUserDAO.php');

$url = "/admin/?content=quanlykhac";

if(isset($_SESSION['adminlogintcdealeronline'])) {
	if(isset($_POST['oldPass']) && isset($_POST['newPass'])) {
		$managerUserDAO = new ManagerUserDAO();
		$aAdminUser = unserialize($_SESSION['adminlogintcdealeronline']);
		$usernameadmin = $aAdminUser->getUserID();
		$passold = $_POST['oldPass'];
		$passnew = $_POST['newPass'];
		
		$manageUser = new ManageUser();
		$manageUser -> setUserID($usernameadmin);
		$manageUser -> setPassword(sha1($usernameadmin.$passold));
		
		$adealer = $managerUserDAO -> getInfoAdmin($manageUser);
		if("null" != $adealer->getUserID()) {
			$manageUser -> setPassword(sha1($usernameadmin.$passnew));
			$manageUser -> setDateUpdate(time());
			if($managerUserDAO -> changePassword($manageUser)) {
				$url .= "&mess=success";
			} else {
				$url .= "&mess=fail";
			}
		} else {
			//khong hop le
			$url .= "&mess=fail";
		}
	}
}

redirect($url);
?>