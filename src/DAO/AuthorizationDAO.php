<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/src/db/connectdatabase.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/src/common/CommonVals.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/src/entitys/Authorization.php');

class AuthorizationDAO {
	function getInfoAuthorizationUser($userID) {
		$authorizationUser = new Authorization();
		try {
			$con = new ConnectDB();
	
			$tbl = CommonVals::$tbl_authorization;
			$fn = array(
					CommonVals::$user_id,
					CommonVals::$AllowInsertUser,
					CommonVals::$AllowDeleteUser,
					CommonVals::$AllowEditUser,
					CommonVals::$AllowEditProfile,
					CommonVals::$AllowDeleteProfile
			);
			$condetion = array(
					CommonVals::$user_id => $userID
			);
			$authorizationUsers = $con -> getvalue($tbl, $fn, $condetion);
	
			$authorizationUser->setUserID($userID);
			$authorizationUser -> setIsInsertUser(false);
			$authorizationUser -> setIsDeleteUser(false);
			$authorizationUser -> setIsEditUser(false);
			$authorizationUser -> setIsEditProfile(false);
			$authorizationUser -> setIsDeleteProfile(false);
			
			if(sizeof($authorizationUsers) != 0) {
				// InsertUser
				if ($authorizationUsers[0][1] == 1)
					$authorizationUser -> setIsInsertUser(true);
				else
					$authorizationUser -> setIsInsertUser(false);
	
				// DeleteUser
				if ($authorizationUsers[0][2] == 1)
					$authorizationUser -> setIsDeleteUser(true);
				else
					$authorizationUser -> setIsDeleteUser(false);
	
				// EditUser
				if ($authorizationUsers[0][3] == 1)
					$authorizationUser -> setIsEditUser(true);
				else
					$authorizationUser -> setIsEditUser(false);
	
				// EditProfile
				if ($authorizationUsers[0][4] == 1)
					$authorizationUser -> setIsEditProfile(true);
				else
					$authorizationUser -> setIsEditProfile(false);
	
				// DeleteProfile
				if ($authorizationUsers[0][5] == 1)
					$authorizationUser -> setIsDeleteProfile(true);
				else
					$authorizationUser -> setIsDeleteProfile(false);
			}
	
			return $authorizationUser;
		} catch (Exception $e) {
			//echo 'Caught exception: ',  $e->getMessage(), "\n";
			$authorizationUser->setUserID($userID);
			return $authorizationUser;
		}
	}
}
?>