<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/src/db/connectdatabase.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/src/entitys/ManagerUser.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/src/DAO/ManagerUserDAO.php');
session_start();

$result = 'fail';
if(isset($_SESSION['adminlogintcdealeronline'])) {
	$userLogin = unserialize($_SESSION['adminlogintcdealeronline']);
	try {
		if (isset($_POST['action'])) {
			if ($_POST['action'] == "change_password") {
				if(isset($_POST['userCurrent']) && isset($_POST['txt_password'])) {
					$managerUserDAO = new ManagerUserDAO();
					$manageUser = new ManageUser();
					$manageUser->setUserID(trim($_POST['userCurrent']));
					$manageUser->setPassword(sha1(trim($_POST['userCurrent']).trim($_POST['txt_password'])));
					$manageUser->setUserReset($userLogin->getUserID());
					$manageUser->setDateResetPass(time());
					$manageUser->setDateUpdate(time());
					if ($managerUserDAO -> updatePasswordAccount($manageUser)) {
						$result = 'success';
					}
				}
			} else if ($_POST['action'] == "updateAccount") {
				if (isset($_POST['user_account']) && isset($_POST['name_account'])) {
					if ($_POST['user_account'] != "" && $_POST['name_account'] != "") {
						$allowAddUser = false;
						$allowEditUser = false;
						$allowDeleteUser = false;
						$allowEditProfile = false;
						$allowDeleteProfile = false;
						
						if(isset($_POST['chkAllowAddUser'])) {
							$allowAddUser = true;
						}
						if(isset($_POST['chkAllowEditUser'])) {
							$allowEditUser = true;
						}
						if(isset($_POST['chkAllowDelUser'])) {
							$allowDeleteUser = true;
						}
						if(isset($_POST['chkAllowEditProfile'])) {
							$allowEditProfile = true;
						}
						if(isset($_POST['chkAllowDelProfile'])) {
							$allowDeleteProfile = true;
						}
						
						$managerUserDAO = new ManagerUserDAO();
						$account = new ManageUser();
						$account->setUserID(trim($_POST['user_account']));
						$account->setFullname(trim($_POST['name_account']));
						
						$author = new Authorization();
						$author->setUserID(trim($_POST['user_account']));
						$author->setIsInsertUser($allowAddUser);
						$author->setIsDeleteUser($allowDeleteUser);
						$author->setIsEditUser($allowEditUser);
						$author->setIsEditProfile($allowEditProfile);
						$author->setIsDeleteProfile($allowDeleteProfile);
						
						$account->setAuthorization($author);
						$account->setDateUpdate(time());
						
						if ($managerUserDAO->updateInfoAccount($account)) {
							$result = 'success';
						}
					}
				}
			} else if ($_POST['action'] == "lock") {
				if (isset($_POST['idpe'])) {
					$IDUser = trim($_POST['idpe']);
					if ($IDUser != "") {
						$managerUserDAO = new ManagerUserDAO();
						$account = new ManageUser();
						$account->setUserID($IDUser);
						$account->setIsLock(true);
						$account->setDateLock(time());
						
						if ($managerUserDAO->lockAccount($account)) {
							$result = 'success';
						}
					}
				}
			} else if ($_POST['action'] == "unlock") {
				if (isset($_POST['idpe'])) {
					$IDUser = trim($_POST['idpe']);
					if ($IDUser != "") {
						$managerUserDAO = new ManagerUserDAO();
						$account = new ManageUser();
						$account->setUserID($IDUser);
						$account->setIsLock(false);
						$account->setDateLock(time());
						
						if ($managerUserDAO->lockAccount($account)) {
							$result = 'success';
						}
					}
				}
			}
		}
	} catch (Exception $e) {
		//echo 'Caught exception: ',  $e->getMessage(), "\n";
		$result = 'fail';
	}
}
echo ($result);
?>