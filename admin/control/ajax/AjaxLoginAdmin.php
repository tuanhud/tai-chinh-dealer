<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/src/DAO/ManagerUserDAO.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/src/entitys/ManagerUser.php');
session_start();

$result = "false";
		
$managerUserDAO = new ManagerUserDAO();

try {
	if(isset($_POST['emailre']) && isset($_POST['passre'])) {
		$email = trim($_POST['emailre']);
		$pass = sha1($email.trim($_POST['passre']));
		
		$manageUser = new ManageUser();
		$manageUser -> setUserID($email);
		$manageUser -> setPassword($pass);
		$adealer = $managerUserDAO -> getInfoAdmin($manageUser);
		
		if("null" != $adealer->getUserID()) {
			if(!$adealer->isLock()) {
				$result = "success";
				$_SESSION['adminlogintcdealeronline'] = serialize($adealer);
			} else {
				$result = "lock";
			}
		}
	}
} catch (Exception $e) {
	$result = "false";
}
echo json_encode($result);
?>