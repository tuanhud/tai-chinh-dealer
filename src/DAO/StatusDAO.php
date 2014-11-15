<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/src/db/connectdatabase.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/src/common/CommonVals.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/src/entitys/Status.php');

class StatusDAO {
	/**
	get banks
	*/
	function getStatuss($isLock) {
		$result=array();
		
		try {
			$con = new ConnectDB();
	
			$sql = "SELECT ";
			$sql .= CommonVals::$StatusID.",";
			$sql .= CommonVals::$StatusName.",";
			$sql .= CommonVals::$datecreate.",";
			$sql .= CommonVals::$dateupdate.",";
			$sql .= CommonVals::$is_lock;
			$sql .= " FROM ".CommonVals::$tbl_status_proccess_profile;
			
			if ($isLock == 0 || $isLock == 1)
			{
				$sql .= " WHERE ".CommonVals::$is_lock."=".$isLock;
			}
			$sql .= " ORDER BY ".CommonVals::$is_lock.", ".CommonVals::$StatusID." DESC";
			
			$statuss = $con -> getvalueString($sql);
	
			if(sizeof($statuss) != 0) {
				foreach ($statuss as $row) {
					$aStatus = new Status();
					$aStatus -> setStatusID($row[0]);
					$aStatus -> setStatusName($row[1]);
					$aStatus -> setDateCreated($row[2]);
					$aStatus -> setDateUpdate($row[3]);
		
					if ($row[4] == 1)
						$aStatus -> setIsLock(true);
					else
						$aStatus -> setIsLock(false);
					
					array_push($result, $aStatus);
				}
			}
	
			return $result;
		} catch (Exception $e) {
			//echo 'Caught exception: ',  $e->getMessage(), "\n";
			return $result;
		}
	}
	
	function getStatusByID($statusID) {
		$status = new Status();
		
		try {
			$con = new ConnectDB();
	
			$sql = "SELECT ";
			$sql .= CommonVals::$StatusID.",";
			$sql .= CommonVals::$StatusName.",";
			$sql .= CommonVals::$datecreate.",";
			$sql .= CommonVals::$dateupdate.",";
			$sql .= CommonVals::$is_lock;
			$sql .= " FROM ".CommonVals::$tbl_status_proccess_profile;
			$sql .= " WHERE ";
			$sql .= CommonVals::$StatusID."='".$statusID."'";
			
			$typeLoans = $con -> getvalueString($sql);
	
			if(sizeof($typeLoans) != 0) {
				foreach ($typeLoans as $row) {
					$status -> setStatusID($row[0]);
					$status -> setStatusName($row[1]);
					$status -> setDateCreated($row[2]);
					$status -> setDateUpdate($row[3]);
		
					if ($row[4] == 1)
						$status -> setIsLock(true);
					else
						$status -> setIsLock(false);
					
					break;
				}
			}
	
			return $status;
		} catch (Exception $e) {
			return $status;
		}
	}
	
	function lockStatus($status) {
		$lock = 0;
		if ($status->isLock()){
			$lock = 1;
		}
		
		$con = new ConnectDB();
		$tbl = CommonVals::$tbl_status_proccess_profile;
		$fn = array(CommonVals::$is_lock => $lock, CommonVals::$dateupdate => $status->getDateUpdate());
		$conf = array(CommonVals::$StatusID => $status->getStatusID());
		if ($con -> update($tbl, $fn, $conf)) {
			return true;
		}
		return false;
	}
	
	function lockStatusList($statusIDs, $lock) {
		$con = new ConnectDB();
		$tbl = CommonVals::$tbl_status_proccess_profile;
		$fn = array(CommonVals::$is_lock => $lock, CommonVals::$dateupdate => time());
		if ($con -> updatedels($tbl, $fn, CommonVals::$StatusID, $statusIDs)) {
			return true;
		}
		return false;
	}
	
	function insertStatus($aStatus) {
		$con = new ConnectDB();
		$tbl = CommonVals::$tbl_status_proccess_profile;
		$fn = array(CommonVals::$StatusID => $aStatus->getStatusID(), CommonVals::$datecreate => $aStatus->getDateCreated(), CommonVals::$StatusName => $aStatus->getStatusName(), CommonVals::$is_lock => 0);
		if ($con -> insert($tbl, $fn)) {
			return true;
		} else {
			return false;
		}
	}
	
	function updateStatus($aStatus) {
		$con = new ConnectDB();
		$tbl = CommonVals::$tbl_status_proccess_profile;
		$fn = array(CommonVals::$dateupdate => $aStatus->getDateUpdate(), CommonVals::$StatusName => $aStatus->getStatusName());
		$conf = array(CommonVals::$StatusID => $aStatus->getStatusID());
		if ($con -> update($tbl, $fn, $conf)) {
			return true;
		} else {
			return false;
		}
	}
}

?>