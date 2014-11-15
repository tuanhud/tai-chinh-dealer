<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/src/db/connectdatabase.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/src/common/CommonVals.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/src/entitys/TypeLoan.php');

class TypeLoanDAO {
	/**
	get banks
	*/
	function getTypeLoans($isLock) {
		$result=array();
		
		try {
			$con = new ConnectDB();
	
			$sql = "SELECT ";
			$sql .= CommonVals::$LoanID.",";
			$sql .= CommonVals::$LoanName.",";
			$sql .= CommonVals::$datecreate.",";
			$sql .= CommonVals::$dateupdate.",";
			$sql .= CommonVals::$is_lock;
			$sql .= " FROM ".CommonVals::$tbl_type_loan;
			
			if ($isLock == 0 || $isLock == 1)
			{
				$sql .= " WHERE ";
				$sql .= CommonVals::$is_lock."=".$isLock;
			}
			$sql .= " ORDER BY ".CommonVals::$is_lock.", ".CommonVals::$LoanID." DESC";
			
			$typeLoans = $con -> getvalueString($sql);
	
			if(sizeof($typeLoans) != 0) {
				foreach ($typeLoans as $row) {
					$aTypeLoan = new TypeLoan();
					$aTypeLoan -> setLoanID($row[0]);
					$aTypeLoan -> setLoanName($row[1]);
					$aTypeLoan -> setDateCreated($row[2]);
					$aTypeLoan -> setDateUpdate($row[3]);
		
					if ($row[4] == 1)
						$aTypeLoan -> setIsLock(true);
					else
						$aTypeLoan -> setIsLock(false);
					
					array_push($result, $aTypeLoan);
				}
			}
	
			return $result;
		} catch (Exception $e) {
			//echo 'Caught exception: ',  $e->getMessage(), "\n";
			return $result;
		}
	}
	
	function getTypeLoanByID($loanID) {
		$typeLoan = new TypeLoan();
		
		try {
			$con = new ConnectDB();
	
			$sql = "SELECT ";
			$sql .= CommonVals::$LoanID.",";
			$sql .= CommonVals::$LoanName.",";
			$sql .= CommonVals::$datecreate.",";
			$sql .= CommonVals::$dateupdate.",";
			$sql .= CommonVals::$is_lock;
			$sql .= " FROM ".CommonVals::$tbl_type_loan;
			$sql .= " WHERE ";
			$sql .= CommonVals::$LoanID."='".$loanID."'";
			
			$typeLoans = $con -> getvalueString($sql);
	
			if(sizeof($typeLoans) != 0) {
				foreach ($typeLoans as $row) {
					$typeLoan -> setLoanID($row[0]);
					$typeLoan -> setLoanName($row[1]);
					$typeLoan -> setDateCreated($row[2]);
					$typeLoan -> setDateUpdate($row[3]);
		
					if ($row[4] == 1)
						$typeLoan -> setIsLock(true);
					else
						$typeLoan -> setIsLock(false);
					
					break;
				}
			}
	
			return $typeLoan;
		} catch (Exception $e) {
			return $typeLoan;
		}
	}
	
	function lockTypeLoan($typeLoan) {
		$lock = 0;
		if ($typeLoan->isLock()){
			$lock = 1;
		}
		
		$con = new ConnectDB();
		$tbl = CommonVals::$tbl_type_loan;
		$fn = array(CommonVals::$is_lock => $lock, CommonVals::$dateupdate => $typeLoan->getDateUpdate());
		$conf = array(CommonVals::$LoanID => $typeLoan->getLoanID());
		if ($con -> update($tbl, $fn, $conf)) {
			return true;
		}
		return false;
	}
	
	function lockTypeLoanList($loanIDs, $lock) {
		$con = new ConnectDB();
		$tbl = CommonVals::$tbl_type_loan;
		$fn = array(CommonVals::$is_lock => $lock, CommonVals::$dateupdate => time());
		if ($con -> updatedels($tbl, $fn, CommonVals::$LoanID, $loanIDs)) {
			return true;
		}
		return false;
	}
	
	function insertTypeLoan($aTypeLoan) {
		$con = new ConnectDB();
		$tbl = CommonVals::$tbl_type_loan;
		$fn = array(CommonVals::$LoanID => $aTypeLoan->getLoanID(), CommonVals::$datecreate => $aTypeLoan->getDateCreated(), CommonVals::$LoanName => $aTypeLoan->getLoanName(), CommonVals::$is_lock => 0);
		if ($con -> insert($tbl, $fn)) {
			return true;
		} else {
			return false;
		}
	}
	
	function updateTypeLoan($aTypeLoan) {
		$con = new ConnectDB();
		$tbl = CommonVals::$tbl_type_loan;
		$fn = array(CommonVals::$dateupdate => $aTypeLoan->getDateUpdate(), CommonVals::$LoanName => $aTypeLoan->getLoanName());
		$conf = array(CommonVals::$LoanID => $aTypeLoan->getLoanID());
		if ($con -> update($tbl, $fn, $conf)) {
			return true;
		} else {
			return false;
		}
	}
}

?>