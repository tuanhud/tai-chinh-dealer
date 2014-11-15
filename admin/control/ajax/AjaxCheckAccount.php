<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/src/DAO/ManagerUserDAO.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/src/entitys/ManagerUser.php');
session_start();

$result = "false";
		
$managerUserDAO = new ManagerUserDAO();

try {
	if(isset($_POST['user'])) {
		$UserID = trim($_POST['user']);
		
		$manageUser = new ManageUser();
		$manageUser -> setUserID($UserID);
		
		if($managerUserDAO -> checkAccountExist($manageUser)) {
			$result = "exist";
		} else {
			$result = "success";
		}
	}
} catch (Exception $e) {
	$result = "false";
}
echo $result;
?>