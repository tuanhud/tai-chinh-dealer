<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/src/db/connectdatabase.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/src/common/CommonVals.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/src/entitys/ManagerUser.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/src/entitys/Authorization.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/src/entitys/Dealer.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/src/DAO/AuthorizationDAO.php');

class ManagerUserDAO {
	/**
	check login table admin
	*/
	function checkLoginAdmin($manageUser) {
		try {
			$con = new ConnectDB();
			
			$tbl = CommonVals::$tbl_user_manager;
			$fn = array(
					CommonVals::$user_id
					);
			$condetion = array(
							CommonVals::$user_id => ($manageUser->getUserID()), 
							CommonVals::$password_user => ($manageUser->getPassword())
						);
			$result = $con -> getvalue($tbl, $fn, $condetion);
			if(sizeof($result) != 0) {
				return true;
			}
		} catch (Exception $e) {
			//echo 'Caught exception: ',  $e->getMessage(), "\n";
		}
		return false;
	}
	
	/**
	check login table admin
	*/
	function checkAccountExist($manageUser) {
		try {
			$con = new ConnectDB();
			
			$tbl = CommonVals::$tbl_user_manager;
			$fn = array(
					CommonVals::$user_id
					);
			$condetion = array(
							CommonVals::$user_id => ($manageUser->getUserID())
						);
			$result = $con -> getvalue($tbl, $fn, $condetion);
			if(sizeof($result) != 0) {
				return true;
			}
		} catch (Exception $e) {
			//echo 'Caught exception: ',  $e->getMessage(), "\n";
		}
		return false;
	}
	
	function getInfoAdmin($manageUser) {
		try {
			$con = new ConnectDB();
			
			$tbl = CommonVals::$tbl_user_manager;
			$fn = array(
					CommonVals::$user_id, 
					CommonVals::$fullname, 
					CommonVals::$is_root, 
					CommonVals::$is_lock, 
					CommonVals::$date_lock, 
					CommonVals::$user_reset, 
					CommonVals::$date_reset_pass, 
					CommonVals::$user_create, 
					CommonVals::$datecreate, 
					CommonVals::$dateupdate
					);
			$condetion = array(
							CommonVals::$user_id => ($manageUser->getUserID()), 
							CommonVals::$password_user => ($manageUser->getPassword())
						);
			$managerUsers = $con -> getvalue($tbl, $fn, $condetion);
			
			if(sizeof($managerUsers) == 0) {
				$manageUser -> setUserID("null");
			} else {
				$manageUser -> setFullname($managerUsers[0][1]);
				if ($managerUsers[0][2] == 1)
					$manageUser -> setIsRoot(true);
				else 
					$manageUser -> setIsRoot(false);
					
				if ($managerUsers[0][3] == 1)
					$manageUser -> setIsLock(true);
				else 
					$manageUser -> setIsLock(false);
					
				$manageUser -> setDateLock($managerUsers[0][4]);
				$manageUser -> setUserReset($managerUsers[0][5]);
				$manageUser -> setDateResetPass($managerUsers[0][6]);
				$manageUser -> setUserCreate($managerUsers[0][7]);
				$manageUser -> setDateCreate($managerUsers[0][8]);
				$manageUser -> setDateUpdate($managerUsers[0][9]);
			}
	
			return $manageUser;
		} catch (Exception $e) {
			//echo 'Caught exception: ',  $e->getMessage(), "\n";
			$manageUser -> setUserID("null");
			return $manageUser;
		}
	}
	
	function countInfoAdminPageManage($isRoot, $userID) {
		try {
			$con = new ConnectDB();
		
			$sql = "SELECT COUNT(U.".CommonVals::$user_id.")";
			$sql .= " FROM ".CommonVals::$tbl_user_manager." AS U LEFT JOIN ".CommonVals::$tbl_authorization." AS A";
			$sql .= " ON U.".CommonVals::$user_id."=A.".CommonVals::$user_id;
			$sql .= " WHERE ";
			$sql .= "U.".CommonVals::$is_root."<>1";
			
			if(!$isRoot)
				$sql .= " AND U.".CommonVals::$user_id."<>'".$userID."'";
		
			$managerUsers = $con -> getvalueString($sql);
		
			return sizeof($managerUsers);
		} catch (Exception $e) {
			//echo 'Caught exception: ',  $e->getMessage(), "\n";
			return 0;
		}
	}
	
	function getInfoAdminPageManage($isRoot, $userID, $start, $lenght) {
		$resultUser=array();
		
		try {
			$con = new ConnectDB();
	
			$sql = "SELECT ";
			$sql .= "U.".CommonVals::$user_id.",";
			$sql .= "U.".CommonVals::$fullname.",";
			$sql .= "U.".CommonVals::$is_root.",";
			$sql .= "U.".CommonVals::$is_lock.",";
			$sql .= "U.".CommonVals::$date_lock.",";
			$sql .= "U.".CommonVals::$user_reset.",";
			$sql .= "U.".CommonVals::$date_reset_pass.",";
			$sql .= "U.".CommonVals::$user_create.",";
			$sql .= "U.".CommonVals::$datecreate.",";
			$sql .= "U.".CommonVals::$dateupdate.",";
			$sql .= "A.".CommonVals::$AllowInsertUser.",";
			$sql .= "A.".CommonVals::$AllowDeleteUser.",";
			$sql .= "A.".CommonVals::$AllowEditUser.",";
			$sql .= "A.".CommonVals::$AllowEditProfile.",";
			$sql .= "A.".CommonVals::$AllowDeleteProfile;
			$sql .= " FROM ".CommonVals::$tbl_user_manager." AS U LEFT JOIN ".CommonVals::$tbl_authorization." AS A";
			$sql .= " ON U.".CommonVals::$user_id."=A.".CommonVals::$user_id;
			$sql .= " WHERE ";
			$sql .= "U.".CommonVals::$is_root."<>1";
			
			if(!$isRoot)
				$sql .= " AND U.".CommonVals::$user_id."<>'".$userID."'";
			
			$sql .= " ORDER BY U.".CommonVals::$user_id." DESC ";
			$sql .= " LIMIT ".$start.",".$lenght;
			
			$managerUsers = $con -> getvalueString($sql);
	
			if(sizeof($managerUsers) != 0) {
				foreach ($managerUsers as $row) {
					$manageUser = new ManageUser();
					$manageUser -> setUserID($row[0]);
					$manageUser -> setFullname($row[1]);
					if ($row[2] == 1)
						$manageUser -> setIsRoot(true);
					else
						$manageUser -> setIsRoot(false);
		
					if ($row[3] == 1)
						$manageUser -> setIsLock(true);
					else
						$manageUser -> setIsLock(false);
		
					$manageUser -> setDateLock($row[4]);
					$manageUser -> setUserReset($row[5]);
					$manageUser -> setDateResetPass($row[6]);
					$manageUser -> setUserCreate($row[7]);
					$manageUser -> setDateCreate($row[8]);
					$manageUser -> setDateUpdate($row[9]);
					
					$author = new Authorization();
					if ($row[10] == 1)
						$author -> setIsInsertUser(true);
					else
						$author -> setIsInsertUser(false);
					
					if ($row[11] == 1)
						$author -> setIsDeleteUser(true);
					else
						$author -> setIsDeleteUser(false);
					
					if ($row[12] == 1)
						$author -> setIsEditUser(true);
					else
						$author -> setIsEditUser(false);
					
					if ($row[13] == 1)
						$author -> setIsEditProfile(true);
					else
						$author -> setIsEditProfile(false);
					
					if ($row[14] == 1)
						$author -> setIsDeleteProfile(true);
					else
						$author -> setIsDeleteProfile(false);
					
					$manageUser -> setAuthorization($author);
					
					array_push($resultUser, $manageUser);
				}
			}
	
			return $resultUser;
		} catch (Exception $e) {
			//echo 'Caught exception: ',  $e->getMessage(), "\n";
			return $resultUser;
		}
	}
	
	function getInfoUserManageByUserID($userID) {
		$manageUser = new ManageUser();
		
		try {
			$con = new ConnectDB();
	
			$sql = "SELECT ";
			$sql .= "U.".CommonVals::$user_id.",";
			$sql .= "U.".CommonVals::$fullname.",";
			$sql .= "U.".CommonVals::$is_root.",";
			$sql .= "U.".CommonVals::$is_lock.",";
			$sql .= "U.".CommonVals::$date_lock.",";
			$sql .= "U.".CommonVals::$user_reset.",";
			$sql .= "U.".CommonVals::$date_reset_pass.",";
			$sql .= "U.".CommonVals::$user_create.",";
			$sql .= "U.".CommonVals::$datecreate.",";
			$sql .= "U.".CommonVals::$dateupdate.",";
			$sql .= "A.".CommonVals::$AllowInsertUser.",";
			$sql .= "A.".CommonVals::$AllowDeleteUser.",";
			$sql .= "A.".CommonVals::$AllowEditUser.",";
			$sql .= "A.".CommonVals::$AllowEditProfile.",";
			$sql .= "A.".CommonVals::$AllowDeleteProfile;
			$sql .= " FROM ".CommonVals::$tbl_user_manager." AS U LEFT JOIN ".CommonVals::$tbl_authorization." AS A";
			$sql .= " ON U.".CommonVals::$user_id."=A.".CommonVals::$user_id;
			$sql .= " WHERE ";
			$sql .= "U.".CommonVals::$user_id."='".$userID."'";
			
			$managerUsers = $con -> getvalueString($sql);
			
			if(sizeof($managerUsers) != 0) {
				foreach ($managerUsers as $row) {
					$manageUser -> setUserID($row[0]);
					$manageUser -> setFullname($row[1]);
					if ($row[2] == 1)
						$manageUser -> setIsRoot(true);
					else
						$manageUser -> setIsRoot(false);
		
					if ($row[3] == 1)
						$manageUser -> setIsLock(true);
					else
						$manageUser -> setIsLock(false);
		
					$manageUser -> setDateLock($row[4]);
					$manageUser -> setUserReset($row[5]);
					$manageUser -> setDateResetPass($row[6]);
					$manageUser -> setUserCreate($row[7]);
					$manageUser -> setDateCreate($row[8]);
					$manageUser -> setDateUpdate($row[9]);
					
					$author = new Authorization();
					if ($row[10] == 1)
						$author -> setIsInsertUser(true);
					else
						$author -> setIsInsertUser(false);
					
					if ($row[11] == 1)
						$author -> setIsDeleteUser(true);
					else
						$author -> setIsDeleteUser(false);
					
					if ($row[12] == 1)
						$author -> setIsEditUser(true);
					else
						$author -> setIsEditUser(false);
					
					if ($row[13] == 1)
						$author -> setIsEditProfile(true);
					else
						$author -> setIsEditProfile(false);
					
					if ($row[14] == 1)
						$author -> setIsDeleteProfile(true);
					else
						$author -> setIsDeleteProfile(false);
					
					$manageUser -> setAuthorization($author);
					break;
				}
			}
	
			return $manageUser;
		} catch (Exception $e) {
			//echo 'Caught exception: ',  $e->getMessage(), "\n";
			return $manageUser;
		}
	}
	
	function getDealerByUserID($userID) {
		$resultDealer=array();
		
		try {
			$con = new ConnectDB();
	
			$sql = "SELECT ";
			$sql .= "A.".CommonVals::$user_id.",";
			$sql .= "A.".CommonVals::$EmailDealer.",";
			$sql .= "D.".CommonVals::$IDCODE.",";
			$sql .= "D.".CommonVals::$NameDealer.",";
			$sql .= "D.".CommonVals::$Gender.",";
			$sql .= "D.".CommonVals::$Mobile.",";
			$sql .= "D.".CommonVals::$Province;
			$sql .= " FROM ".CommonVals::$tbl_authorization_link." AS A INNER JOIN ".CommonVals::$tbl_dealer_bank." AS D";
			$sql .= " ON A.".CommonVals::$EmailDealer."=D.".CommonVals::$EmailDealer;
			$sql .= " WHERE ";
			$sql .= "A.".CommonVals::$user_id."='".$userID."'";
			$sql .= " AND D.".CommonVals::$IsAccept."=1";
			
			$dealers = $con -> getvalueString($sql);
	
			if(sizeof($dealers) != 0) {
				foreach ($dealers as $row) {
					$dealer = new Dealer();
					$dealer -> setEmailDealer($row[1]);
					$dealer -> setIDCODE($row[2]);
					$dealer -> setFullname($row[3]);
					
					if ($row[4] == 1)
						$dealer -> setGender(true);
					else
						$dealer -> setGender(false);
						
					$dealer -> setMobile($row[5]);
					$dealer -> setProvince($row[6]);
					
					array_push($resultDealer, $dealer);
				}
			}
	
			return $resultDealer;
		} catch (Exception $e) {
			//echo 'Caught exception: ',  $e->getMessage(), "\n";
			return $resultDealer;
		}
	}
	
	
	function getInfoPageChangeAccount($userCurent) {
		$resultUser=array();
		
		try {
			$con = new ConnectDB();
	
			$sql = "SELECT ";
			$sql .= "U.".CommonVals::$user_id.",";
			$sql .= "U.".CommonVals::$fullname;
			$sql .= " FROM ".CommonVals::$tbl_user_manager." AS U ";
			$sql .= " WHERE ";
			$sql .= "U.".CommonVals::$is_root."<>1";
			$sql .= " AND U.".CommonVals::$user_id."<>'".$userCurent."'";
			$sql .= " ORDER BY U.".CommonVals::$user_id." DESC ";
			
			$managerUsers = $con -> getvalueString($sql);
	
			if(sizeof($managerUsers) != 0) {
				foreach ($managerUsers as $row) {
					$manageUser = new ManageUser();
					$manageUser -> setUserID($row[0]);
					$manageUser -> setFullname($row[1]);
					
					array_push($resultUser, $manageUser);
				}
			}
	
			return $resultUser;
		} catch (Exception $e) {
			//echo 'Caught exception: ',  $e->getMessage(), "\n";
			return $resultUser;
		}
	}
	
	function updatePasswordAccount($account) {
		$con = new ConnectDB();
		$tbl = CommonVals::$tbl_user_manager;
		$fn = array(CommonVals::$password_user => $account->getPassword(), CommonVals::$dateupdate => $account->getDateUpdate(), CommonVals::$user_reset => $account->getUserReset(), CommonVals::$date_reset_pass => $account->getDateResetPass());
		$conf = array(CommonVals::$user_id => $account->getUserID());
		return $con -> update($tbl, $fn, $conf);
	}
	
	function updateInfoAccount($account) {
		$con = new ConnectDB();
		//$con->beginTransaction();
		$tbl = CommonVals::$tbl_user_manager;
		$fn = array(CommonVals::$fullname => $account->getFullname(), CommonVals::$dateupdate => $account->getDateUpdate());
		$conf = array(CommonVals::$user_id => $account->getUserID());
		if ($con -> update($tbl, $fn, $conf)) {
			$allowAddUser = 0;
			if ($account->getAuthorization()->isInsertUser()) {
				$allowAddUser = 1;
			}
			$allowEditUser = 0;
			if ($account->getAuthorization()->isEditUser()) {
				$allowEditUser = 1;
			}
			$allowDeleteUser = 0;
			if ($account->getAuthorization()->isDeleteUser()) {
				$allowDeleteUser = 1;
			}
			$allowEditProfile = 0;
			if ($account->getAuthorization()->isEditProfile()) {
				$allowEditProfile = 1;
			}
			$allowDeleteProfile = 0;
			if ($account->getAuthorization()->isDeleteProfile()) {
				$allowDeleteProfile = 1;
			}
			
			$sql = "INSERT INTO ".CommonVals::$tbl_authorization."(".CommonVals::$user_id.", ".CommonVals::$AllowInsertUser.", ".CommonVals::$AllowDeleteUser.", ".CommonVals::$AllowEditUser.", ".CommonVals::$AllowEditProfile.", ".CommonVals::$AllowDeleteProfile.") VALUES ('".$account->getUserID()."', '".$allowAddUser."', '".$allowDeleteUser."', '".$allowEditUser."', '".$allowEditProfile."', '".$allowDeleteProfile."') ON DUPLICATE KEY UPDATE ".CommonVals::$AllowInsertUser."='".$allowAddUser."', ".CommonVals::$AllowDeleteUser."='".$allowDeleteUser."', ".CommonVals::$AllowEditUser."='".$allowEditUser."', ".CommonVals::$AllowEditProfile."='".$allowEditProfile."', ".CommonVals::$AllowDeleteProfile."='".$allowDeleteProfile."'";
				if ($con -> updateStr($sql)) {
					return true;
				}
		}
		return false;
	}
	
	function lockAccount($account) {
		$lock = 0;
		if ($account->isLock()){
			$lock = 1;
		}
		
		$con = new ConnectDB();
		$tbl = CommonVals::$tbl_user_manager;
		$fn = array(CommonVals::$is_lock => $lock, CommonVals::$date_lock => $account->getDateLock());
		$conf = array(CommonVals::$user_id => $account->getUserID());
		if ($con -> update($tbl, $fn, $conf)) {
			return true;
		}
		return false;
	}
	
	function lockAccountList($userIDs, $lock) {
		$con = new ConnectDB();
		$tbl = CommonVals::$tbl_user_manager;
		$fn = array(CommonVals::$is_lock => $lock, CommonVals::$date_lock => time());
		if ($con -> updatedels($tbl, $fn, CommonVals::$user_id, $userIDs)) {
			return true;
		}
		return false;
	}
	
	function insertAccount($infoAccount) {		
		try {
			$con = new ConnectDB();
			$tbl = CommonVals::$tbl_user_manager;
			$fn = array(CommonVals::$user_id => $infoAccount->getUserID(), CommonVals::$fullname => $infoAccount->getFullname(), CommonVals::$password_user => $infoAccount->getPassword(), CommonVals::$is_root => $infoAccount->isRoot(), CommonVals::$is_lock => $infoAccount->isLock(), CommonVals::$user_create => $infoAccount->getUserCreate(), CommonVals::$datecreate => $infoAccount->getDateCreate());
			if ($con -> insert($tbl, $fn)) {
				$allowAddUser = 0;
				if ($infoAccount->getAuthorization()->isInsertUser()) {
					$allowAddUser = 1;
				}
				$allowEditUser = 0;
				if ($infoAccount->getAuthorization()->isEditUser()) {
					$allowEditUser = 1;
				}
				$allowDeleteUser = 0;
				if ($infoAccount->getAuthorization()->isDeleteUser()) {
					$allowDeleteUser = 1;
				}
				$allowEditProfile = 0;
				if ($infoAccount->getAuthorization()->isEditProfile()) {
					$allowEditProfile = 1;
				}
				$allowDeleteProfile = 0;
				if ($infoAccount->getAuthorization()->isDeleteProfile()) {
					$allowDeleteProfile = 1;
				}
				
				$sql = "INSERT INTO ".CommonVals::$tbl_authorization."(".CommonVals::$user_id.", ".CommonVals::$AllowInsertUser.", ".CommonVals::$AllowDeleteUser.", ".CommonVals::$AllowEditUser.", ".CommonVals::$AllowEditProfile.", ".CommonVals::$AllowDeleteProfile.") VALUES ('".$infoAccount->getUserID()."', '".$allowAddUser."', '".$allowDeleteUser."', '".$allowEditUser."', '".$allowEditProfile."', '".$allowDeleteProfile."') ON DUPLICATE KEY UPDATE ".CommonVals::$AllowInsertUser."='".$allowAddUser."', ".CommonVals::$AllowDeleteUser."='".$allowDeleteUser."', ".CommonVals::$AllowEditUser."='".$allowEditUser."', ".CommonVals::$AllowEditProfile."='".$allowEditProfile."', ".CommonVals::$AllowDeleteProfile."='".$allowDeleteProfile."'";
				if ($con -> updateStr($sql)) {
					return true;
				}
				return true;
			}
	
			return false;
		} catch (Exception $e) {
			//echo 'Caught exception: ',  $e->getMessage(), "\n";
			return false;
		}
	}
	
	
	
	function changePassword($account) {
		$con = new ConnectDB();
		$tbl = CommonVals::$tbl_user_manager;
		$fn = array(CommonVals::$password_user => $account->getPassword(), CommonVals::$dateupdate => $account->getDateUpdate());
		$conf = array(CommonVals::$user_id => $account->getUserID());
		return $con -> update($tbl, $fn, $conf);
	}
	
}
?>