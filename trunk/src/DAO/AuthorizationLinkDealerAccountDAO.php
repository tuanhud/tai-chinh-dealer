<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/src/db/connectdatabase.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/src/common/CommonVals.php');

class AuthorizationLinkDealerAccountDAO {
	
	function addLinkAuthorForAccount($userID, $email) {
		$con = new ConnectDB();
		$tbl = CommonVals::$tbl_authorization_link;
		$fn = array(CommonVals::$user_id => $userID, CommonVals::$EmailDealer => $email);
		return $con -> insert($tbl, $fn);
	}
	
	function changeLinkAuthorForAccount($userCurrent, $userID, $email) {		
		$con = new ConnectDB();
		$tbl = CommonVals::$tbl_authorization_link;
		$fn = array(CommonVals::$user_id => $userID);
		$conf = array(CommonVals::$user_id => $userCurrent, CommonVals::$EmailDealer => $email);
		return $con -> update($tbl, $fn, $conf);
	}
	
	function deleteLinkAuthorForAccount($userID, $email) {		
		$con = new ConnectDB();
		$tbl = CommonVals::$tbl_authorization_link;
		$conf = array(CommonVals::$EmailDealer => $email, CommonVals::$user_id => $userID);
		return $con -> delete($tbl, $conf);
	}
	
	function getInfoUserManagerByDealer($email) {		
		$con = new ConnectDB();
		$tbl = CommonVals::$tbl_authorization_link;
		$fn = array(CommonVals::$user_id);
		$condetion = array(CommonVals::$EmailDealer => $email);
		$author = $con -> getvalue($tbl, $fn, $condetion);
		
		if(sizeof($author) != 0) {
			$result = $author[0][0];
		} else {
			$result = "";
		}

		return $result;
	}
}
?>