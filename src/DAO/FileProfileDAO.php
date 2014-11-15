<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/src/db/connectdatabase.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/src/common/CommonVals.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/src/entitys/FileProfile.php');

class FileProfileDAO {
	
	function getFileProfile($idPro) {
		$result = array();
		
		$con = new ConnectDB();
		$tbl = CommonVals::$tbl_linkfile;
		$fn = array(CommonVals::$IDPro, CommonVals::$LinkImage, CommonVals::$datecreate);
		$conf = array(CommonVals::$IDPro => $idPro);
		
		$fileProfiles = $con -> getvalue($tbl, $fn, $conf);
		
		if(sizeof($fileProfiles) != 0) {
			foreach ($fileProfiles as $row) {
				$fileProfile = new FileProfile();
				$fileProfile -> setIdProfile($row[0]);
				$fileProfile -> setLinkFile($row[1]);
				$fileProfile -> setDateCreated($row[2]);
				
				array_push($result, $fileProfile);
			}
		}
		
		return $result;
	}
	
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