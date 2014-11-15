<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/src/db/connectdatabase.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/src/common/CommonVals.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/src/entitys/FileProfile.php');

class FileProfileDAO {
	function insertFileProfile($aFileProfile) {
		$con = new ConnectDB();
		$tbl = CommonVals::$tbl_linkfile;
		$fn = array(CommonVals::$LinkImage => $aFileProfile->getLinkFile(), CommonVals::$datecreate => $aFileProfile->getDateCreated(), CommonVals::$IDPro => $aFileProfile->getIdProfile());
		if ($con -> insert($tbl, $fn)) {
			return true;
		} else {
			return false;
		}
	}
	
	function deleteFileProfile($aFileProfile) {
		$con = new ConnectDB();
		$tbl = CommonVals::$tbl_linkfile;
		$fn = array(CommonVals::$datecreate => $aFileProfile->getDateCreated(), CommonVals::$IDPro => $aFileProfile->getIdProfile());
		if ($con -> delete($tbl, $fn)) {
			return true;
		} else {
			return false;
		}
	}
}

?>