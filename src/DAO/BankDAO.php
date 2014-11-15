<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/src/db/connectdatabase.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/src/common/CommonVals.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/src/entitys/Bank.php');

class BankDAO {
	/**
	get banks
	*/
	function getBanks($isLock) {
		$result=array();
		
		try {
			$con = new ConnectDB();
	
			$sql = "SELECT ";
			$sql .= CommonVals::$BankID.",";
			$sql .= CommonVals::$BankName.",";
			$sql .= CommonVals::$BankLogo.",";
			$sql .= CommonVals::$datecreate.",";
			$sql .= CommonVals::$dateupdate.",";
			$sql .= CommonVals::$IsLock;
			$sql .= " FROM ".CommonVals::$tbl_bank;
			
			if ($isLock == 0 || $isLock == 1)
			{
				$sql .= " WHERE ";
				$sql .= CommonVals::$IsLock."=".$isLock;
			}
			$sql .= " ORDER BY ".CommonVals::$IsLock.", ".CommonVals::$BankID." DESC";
			
			$banks = $con -> getvalueString($sql);
	
			if(sizeof($banks) != 0) {
				foreach ($banks as $row) {
					$abank = new Bank();
					$abank -> setBankID($row[0]);
					$abank -> setBankName($row[1]);
					$abank -> setBankLogo($row[2]);
					$abank -> setDateCreated($row[3]);
					$abank -> setDateUpdate($row[4]);
		
					if ($row[5] == 1)
						$abank -> setIsLock(true);
					else
						$abank -> setIsLock(false);
					
					array_push($result, $abank);
				}
			}
	
			return $result;
		} catch (Exception $e) {
			//echo 'Caught exception: ',  $e->getMessage(), "\n";
			return $result;
		}
	}
	
	function getBankByID($bankID) {
		$bank = new Bank();
		
		try {
			$con = new ConnectDB();
	
			$sql = "SELECT ";
			$sql .= CommonVals::$BankID.",";
			$sql .= CommonVals::$BankName.",";
			$sql .= CommonVals::$BankLogo.",";
			$sql .= CommonVals::$datecreate.",";
			$sql .= CommonVals::$dateupdate.",";
			$sql .= CommonVals::$IsLock;
			$sql .= " FROM ".CommonVals::$tbl_bank;
			$sql .= " WHERE ";
			$sql .= CommonVals::$BankID."='".$bankID."'";
			
			$banks = $con -> getvalueString($sql);
	
			if(sizeof($banks) != 0) {
				foreach ($banks as $row) {
					$bank -> setBankID($row[0]);
					$bank -> setBankName($row[1]);
					$bank -> setBankLogo($row[2]);
					$bank -> setDateCreated($row[3]);
					$bank -> setDateUpdate($row[4]);
		
					if ($row[5] == 1)
						$bank -> setIsLock(true);
					else
						$bank -> setIsLock(false);
					
					break;
				}
			}
	
			return $bank;
		} catch (Exception $e) {
			return $bank;
		}
	}
	
	function lockBank($bank) {
		$lock = 0;
		if ($bank->isLock()){
			$lock = 1;
		}
		
		$con = new ConnectDB();
		$tbl = CommonVals::$tbl_bank;
		$fn = array(CommonVals::$IsLock => $lock, CommonVals::$dateupdate => $bank->getDateUpdate());
		$conf = array(CommonVals::$BankID => $bank->getBankID());
		if ($con -> update($tbl, $fn, $conf)) {
			return true;
		}
		return false;
	}
	
	function lockBankList($bankIDs, $lock) {
		$con = new ConnectDB();
		$tbl = CommonVals::$tbl_bank;
		$fn = array(CommonVals::$IsLock => $lock, CommonVals::$dateupdate => time());
		if ($con -> updatedels($tbl, $fn, CommonVals::$BankID, $bankIDs)) {
			return true;
		}
		return false;
	}
	
	function insertBank($bank) {
		$con = new ConnectDB();
		$tbl = CommonVals::$tbl_bank;
		$fn = array(CommonVals::$BankID => $bank->getBankID(), CommonVals::$datecreate => $bank->getDateCreated(), CommonVals::$BankName => $bank->getBankName(), CommonVals::$BankLogo => $bank->getBankLogo(), CommonVals::$IsLock => 0);
		if ($con -> insert($tbl, $fn)) {
			return true;
		} else {
			return false;
		}
	}
	
	function updateBank($bank) {
		$con = new ConnectDB();
		$tbl = CommonVals::$tbl_bank;
		$fn = array(CommonVals::$dateupdate => $bank->getDateUpdate(), CommonVals::$BankName => $bank->getBankName(), CommonVals::$BankLogo => $bank->getBankLogo());
		$conf = array(CommonVals::$BankID => $bank->getBankID());
		if ($con -> update($tbl, $fn, $conf)) {
			return true;
		} else {
			return false;
		}
	}
}

?>