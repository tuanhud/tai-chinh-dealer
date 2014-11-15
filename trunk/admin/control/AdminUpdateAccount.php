<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/src/db/connectdatabase.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/src/control/RedirectForward.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/src/DAO/ManagerUserDAO.php');
session_start();

$url = 'admin/?content=user';

if(isset($_SESSION['adminlogintcdealeronline']) && isset($_POST['act'])) {
	$mess = "";
	if ($_POST['act'] == "unlock") {
		if(isset($_POST['idcheckmanager'])) {
			$managerUserDAO = new ManagerUserDAO();
			$ids = $_POST['idcheckmanager'];
			if(count($ids) > 0 && $managerUserDAO->lockAccountList($ids, '0')) {
				$mess = 'success';
			}
		}
	} else if ($_POST['act'] == "lock") {
		if(isset($_POST['idcheckmanager'])) {
			$managerUserDAO = new ManagerUserDAO();
			$ids = $_POST['idcheckmanager'];
			if(count($ids) > 0 && $managerUserDAO->lockAccountList($ids, '1')) {
				$mess = 'success';
			}
		}
	} else if ($_POST['act'] == "addAccount") {
		if(isset($_POST['userID']) && isset($_POST['fullname']) && isset($_POST['password'])) {
			$aAdminUser = unserialize($_SESSION['adminlogintcdealeronline']);
			
			$userID = trim($_POST['userID']);
			$fullname = trim($_POST['fullname']);
			$password = trim($_POST['password']);
			$isAddUser = false;
			if (isset($_POST['isAddUser'])) {
				$isAddUser = true;
			}
			$isEditUser = false;
			if (isset($_POST['isEditUser'])) {
				$isEditUser = true;
			}
			$isDeleteUser = false;
			if (isset($_POST['isDeleteUser'])) {
				$isDeleteUser = true;
			}
			$isEditProfile = false;
			if (isset($_POST['isEditProfile'])) {
				$isEditProfile = true;
			}
			$isDelProfile = false;
			if (isset($_POST['isDelProfile'])) {
				$isDelProfile = true;
			}
			
			$manageUser = new ManageUser();
			$manageUser -> setUserID($userID);
			$manageUser -> setFullname($fullname);
			$manageUser -> setPassword(sha1($userID.$password));
			$manageUser -> setIsRoot(0);
			$manageUser -> setIsLock(0);
			$manageUser -> setUserCreate($aAdminUser->getUserID());
			$manageUser -> setDateCreate(time());
			
			$authorization = new Authorization();
			$authorization->setUserID($userID);
			$authorization->setIsInsertUser($isAddUser);
			$authorization->setIsEditUser($isEditUser);
			$authorization->setIsDeleteUser($isDeleteUser);
			$authorization->setIsEditProfile($isEditProfile);
			$authorization->setIsDeleteProfile($isDelProfile);
			$manageUser -> setAuthorization($authorization);
			
			$managerUserDAO = new ManagerUserDAO();
			if ($managerUserDAO->insertAccount($manageUser)) {
				$mess = 'success';
			}
			$url .= '&p=add-user';
		}
	}
	$url .= '&mess='.$mess;
}
redirect($url);
?>