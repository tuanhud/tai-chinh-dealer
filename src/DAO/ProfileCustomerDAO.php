<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/src/db/connectdatabase.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/src/common/CommonVals.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/src/entitys/TypeLoan.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/src/entitys/Status.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/src/entitys/ProfileCustomer.php');


class ProfileCustomerDAO {
	/**
	get profiles
	*/
	function getProfilesByUserManager($isRoot, $UserManager, $codeID, $namesr, $statussr, $city, $typeloan, $tempsql, $start, $lenght) {
		$result=array();
		
		try {
			$con = new ConnectDB();
	
			$sql = "SELECT ";
			$sql .= "P.".CommonVals::$IDPro.", ";
			$sql .= "P.".CommonVals::$IDCODE.", ";
			$sql .= "P.".CommonVals::$StatusID.", ";
			$sql .= "S.".CommonVals::$StatusName.", ";
			$sql .= "P.".CommonVals::$LoanID.", ";
			$sql .= "T.".CommonVals::$LoanName.", ";
			$sql .= "P.".CommonVals::$EmailDealer.", ";
			$sql .= "P.".CommonVals::$UserManager.", ";
			$sql .= "P.".CommonVals::$NameCustomer.", ";
			$sql .= "P.".CommonVals::$PhoneNumber.", ";
			$sql .= "P.".CommonVals::$Province.", ";
			$sql .= "P.".CommonVals::$InfoPro.", ";
			$sql .= "P.".CommonVals::$InfoRequest.", ";
			$sql .= "P.".CommonVals::$AmountLoan.", ";
			$sql .= "P.".CommonVals::$BankLoan.", ";
			$sql .= "P.".CommonVals::$HoaHong.", ";
			$sql .= "P.".CommonVals::$Isgnore.", ";
			$sql .= "P.".CommonVals::$datecreate.", ";
			$sql .= "P.".CommonVals::$dateupdate.", ";
			$sql .= "P.".CommonVals::$IsBackup.", ";
			$sql .= "P.".CommonVals::$UserBackup.", ";
			$sql .= "P.".CommonVals::$IsDelete.", ";
			$sql .= "P.".CommonVals::$DateDelete.", ";
			$sql .= "P.".CommonVals::$UserDelete." ";
			$sql .= " FROM ".CommonVals::$tbl_type_loan." AS T INNER JOIN ".CommonVals::$tbl_profile_customer." AS P ON P.".CommonVals::$LoanID."=T.".CommonVals::$LoanID." LEFT JOIN ".CommonVals::$tbl_status_proccess_profile." AS S ON S.".CommonVals::$StatusID."=P.".CommonVals::$StatusID." ";
			
			$isWhere = false;
			if (!$isRoot) {
				$sql .= " WHERE ";
				$sql .= " P.".CommonVals::$UserManager."='".$UserManager."' ";
				$isWhere = true;
			}
			
			if ($codeID != "")
			{
				if ($isWhere) {
					$sql .= " AND ";
				} else {
					$sql .= " WHERE ";
					$isWhere = true;
				}
				$sql .= " P.".CommonVals::$IDCODE."='".$codeID."' ";
			}
			
			if ($namesr != "")
			{
				if ($isWhere) {
					$sql .= " AND ";
				} else {
					$sql .= " WHERE ";
					$isWhere = true;
				}
				$sql .= " P.".CommonVals::$NameCustomer." LIKE '%".$namesr."%' ";
			}
			
			if ($statussr != "")
			{
				if ($isWhere) {
					$sql .= " AND ";
				} else {
					$sql .= " WHERE ";
					$isWhere = true;
				}
				$sql .= " P.".CommonVals::$StatusID."='".$statussr."' ";
			}
			
			if ($city != "")
			{
				if ($isWhere) {
					$sql .= " AND ";
				} else {
					$sql .= " WHERE ";
					$isWhere = true;
				}
				$sql .= " P.".CommonVals::$Province." LIKE '%".$city."%' ";
			}
			
			if ($typeloan != "")
			{
				if ($isWhere) {
					$sql .= " AND ";
				} else {
					$sql .= " WHERE ";
					$isWhere = true;
				}
				$sql .= " P.".CommonVals::$LoanID."='".$typeloan."' ";
			}
			
			if ($tempsql != "")
			{
				if (!$isWhere) {
					$sql .= " WHERE 1=1 ";
					$isWhere = true;
				}
				$sql .= " ".$tempsql;
			}
			
			if (!$isRoot) {
				if ($isWhere) {
					$sql .= " AND ";
				} else {
					$sql .= " WHERE ";
					$isWhere = true;
				}
				$sql .= " P.".CommonVals::$IsDelete."=0 AND P.".CommonVals::$IsBackup."=0 ";
			}
			
			$sql .= " ORDER BY P.".CommonVals::$datecreate." DESC ";
			
			$sql .= " LIMIT ".$start.",".$lenght;
			
			$profiles = $con -> getvalueString($sql);
	
			if(sizeof($profiles) != 0) {
				foreach ($profiles as $row) {
					$aProfile = new ProfileCustomer();
					$aProfile -> setIDProfile($row[0]);
					$aProfile -> setIDCODE($row[1]);
					
					$status = new Status();
					$status -> setStatusID($row[2]);
					$status -> setStatusName($row[3]);
					$aProfile -> setStatus($status);
					
					$typeLoan = new TypeLoan();
					$typeLoan -> setLoanID($row[4]);
					$typeLoan -> setLoanName($row[5]);
					$aProfile -> setTypeLoan($typeLoan);
					
					$aProfile -> setEmailDealer($row[6]);
					$aProfile -> setUserManager($row[7]);
					$aProfile -> setNameCustomer($row[8]);
					$aProfile -> setPhoneNumber($row[9]);
					$aProfile -> setProvince($row[10]);
					$aProfile -> setInfoProfile($row[11]);
					$aProfile -> setInfoRequest($row[12]);
					$aProfile -> setAmountLoan($row[13]);
					$aProfile -> setBankLoan($row[14]);
					$aProfile -> setHoaHong($row[15]);
					
					$isgnore = false;
					if ($row[16] == "1") {
						$isgnore = true;
					}
					$aProfile -> setIsgnore($isgnore);
					$aProfile -> setDateCreate($row[17]);
					$aProfile -> setDateUpdate($row[18]);
					
					$isBackup = false;
					if ($row[19] == "1") {
						$isBackup = true;
					}
					$aProfile -> setIsBackup($isBackup);
					$aProfile -> setUserBackup($row[20]);
					
					$isDelete = false;
					if ($row[21] == "1") {
						$isDelete = true;
					}
					$aProfile -> setIsDelete($isDelete);
					$aProfile -> setDateDelete($row[22]);
					$aProfile -> setUserDelete($row[23]);
					
					array_push($result, $aProfile);
				}
			}
	
			return $result;
		} catch (Exception $e) {
			//echo 'Caught exception: ',  $e->getMessage(), "\n";
			return $result;
		}
	}
	
	/**
	Count profile
	*/
	function getRowsProfile($isRoot, $UserManager, $codeID, $namesr, $statussr, $city, $typeloan, $tempsql) {
		$result = 0;
		
		try {
			$con = new ConnectDB();
	
			$sql = "SELECT COUNT(".CommonVals::$IDPro.")";
			$sql .= " FROM ".CommonVals::$tbl_type_loan." AS T INNER JOIN ".CommonVals::$tbl_profile_customer." AS P ON P.".CommonVals::$LoanID."=T.".CommonVals::$LoanID." LEFT JOIN ".CommonVals::$tbl_status_proccess_profile." AS S ON S.".CommonVals::$StatusID."=P.".CommonVals::$StatusID." ";
			
			$isWhere = false;
			if (!$isRoot) {
				$sql .= " WHERE ";
				$sql .= " P.".CommonVals::$UserManager."='".$UserManager."' ";
				$isWhere = true;
			}
			
			if ($codeID != "")
			{
				if ($isWhere) {
					$sql .= " AND ";
				} else {
					$sql .= " WHERE ";
					$isWhere = true;
				}
				$sql .= " P.".CommonVals::$IDCODE."='".$codeID."' ";
			}
			
			if ($namesr != "")
			{
				if ($isWhere) {
					$sql .= " AND ";
				} else {
					$sql .= " WHERE ";
					$isWhere = true;
				}
				$sql .= " P.".CommonVals::$NameCustomer." LIKE '%".$namesr."%' ";
			}
			
			if ($statussr != "")
			{
				if ($isWhere) {
					$sql .= " AND ";
				} else {
					$sql .= " WHERE ";
					$isWhere = true;
				}
				$sql .= " P.".CommonVals::$StatusID."='".$statussr."' ";
			}
			
			if ($city != "")
			{
				if ($isWhere) {
					$sql .= " AND ";
				} else {
					$sql .= " WHERE ";
					$isWhere = true;
				}
				$sql .= " P.".CommonVals::$Province." LIKE '%".$city."%' ";
			}
			
			if ($typeloan != "")
			{
				if ($isWhere) {
					$sql .= " AND ";
				} else {
					$sql .= " WHERE ";
					$isWhere = true;
				}
				$sql .= " P.".CommonVals::$LoanID."='".$typeloan."' ";
			}
			
			if ($tempsql != "")
			{
				if (!$isWhere) {
					$sql .= " WHERE 1=1 ";
					$isWhere = true;
				}
				$sql .= " ".$tempsql;
			}
			
			if (!$isRoot) {
				if ($isWhere) {
					$sql .= " AND ";
				} else {
					$sql .= " WHERE ";
					$isWhere = true;
				}
				$sql .= " P.".CommonVals::$IsDelete."=0 AND P.".CommonVals::$IsBackup."=0 ";
			}
			
			$count = $con -> getvalueString($sql);
	
			if(sizeof($count) != 0) {
				$result = $count[0][0];
			}
	
			return $result;
		} catch (Exception $e) {
			//echo 'Caught exception: ',  $e->getMessage(), "\n";
			return $result;
		}
	}
	
	/**
	Count profile Index
	*/
	function getRowRecordsCustomIndex($email, $namekey, $status, $tempsql) {
		$result = 0;
		
		try {
			$con = new ConnectDB();
	
			$sql = "SELECT COUNT(".CommonVals::$IDPro.")";
			$sql .= " FROM ".CommonVals::$tbl_type_loan." AS T INNER JOIN ".CommonVals::$tbl_profile_customer." AS P ON P.".CommonVals::$LoanID."=T.".CommonVals::$LoanID." LEFT JOIN ".CommonVals::$tbl_status_proccess_profile." AS S ON S.".CommonVals::$StatusID."=P.".CommonVals::$StatusID." ";
			
			$isWhere = false;			
			if ($email != "")
			{
				if ($isWhere) {
					$sql .= " AND ";
				} else {
					$sql .= " WHERE ";
					$isWhere = true;
				}
				$sql .= " P.".CommonVals::$EmailDealer."='".$email."' ";
			}
			
			if ($namekey != "")
			{
				if ($isWhere) {
					$sql .= " AND ";
				} else {
					$sql .= " WHERE ";
					$isWhere = true;
				}
				$sql .= " P.".CommonVals::$NameCustomer." LIKE '%".$namekey."%' ";
			}
			
			if ($status != "")
			{
				if ($isWhere) {
					$sql .= " AND ";
				} else {
					$sql .= " WHERE ";
					$isWhere = true;
				}
				$sql .= " P.".CommonVals::$StatusID."='".$status."' ";
			}
			
			if ($tempsql != "")
			{
				if (!$isWhere) {
					$sql .= " WHERE 1=1 ";
					$isWhere = true;
				}
				$sql .= " ".$tempsql;
			}
			
			if ($isWhere) {
				$sql .= " AND ";
			} else {
				$sql .= " WHERE ";
				$isWhere = true;
			}
			$sql .= " P.".CommonVals::$IsDelete."=0 AND P.".CommonVals::$IsBackup."=0";
			
			$count = $con -> getvalueString($sql);
	
			if(sizeof($count) != 0) {
				$result = $count[0][0];
			}
	
			return $result;
		} catch (Exception $e) {
			//echo 'Caught exception: ',  $e->getMessage(), "\n";
			return $result;
		}
	}
	
	/**
	get profiles Index
	*/
	function profileRecordsCustomIndex($email, $namekey, $status, $tempsql, $start, $lenght) {
		$result=array();
		
		try {
			$con = new ConnectDB();
	
			$sql = "SELECT ";
			$sql .= "P.".CommonVals::$IDPro.", ";
			$sql .= "P.".CommonVals::$IDCODE.", ";
			$sql .= "P.".CommonVals::$StatusID.", ";
			$sql .= "S.".CommonVals::$StatusName.", ";
			$sql .= "P.".CommonVals::$LoanID.", ";
			$sql .= "T.".CommonVals::$LoanName.", ";
			$sql .= "P.".CommonVals::$EmailDealer.", ";
			$sql .= "P.".CommonVals::$UserManager.", ";
			$sql .= "P.".CommonVals::$NameCustomer.", ";
			$sql .= "P.".CommonVals::$PhoneNumber.", ";
			$sql .= "P.".CommonVals::$Province.", ";
			$sql .= "P.".CommonVals::$InfoPro.", ";
			$sql .= "P.".CommonVals::$InfoRequest.", ";
			$sql .= "P.".CommonVals::$AmountLoan.", ";
			$sql .= "P.".CommonVals::$BankLoan.", ";
			$sql .= "P.".CommonVals::$HoaHong.", ";
			$sql .= "P.".CommonVals::$Isgnore.", ";
			$sql .= "P.".CommonVals::$datecreate.", ";
			$sql .= "P.".CommonVals::$dateupdate.", ";
			$sql .= "P.".CommonVals::$IsBackup.", ";
			$sql .= "P.".CommonVals::$UserBackup.", ";
			$sql .= "P.".CommonVals::$IsDelete.", ";
			$sql .= "P.".CommonVals::$DateDelete.", ";
			$sql .= "P.".CommonVals::$UserDelete." ";
			$sql .= " FROM ".CommonVals::$tbl_type_loan." AS T INNER JOIN ".CommonVals::$tbl_profile_customer." AS P ON P.".CommonVals::$LoanID."=T.".CommonVals::$LoanID." LEFT JOIN ".CommonVals::$tbl_status_proccess_profile." AS S ON S.".CommonVals::$StatusID."=P.".CommonVals::$StatusID." ";
			
			$isWhere = false;			
			if ($email != "")
			{
				if ($isWhere) {
					$sql .= " AND ";
				} else {
					$sql .= " WHERE ";
					$isWhere = true;
				}
				$sql .= " P.".CommonVals::$EmailDealer."='".$email."' ";
			}
			
			if ($namekey != "")
			{
				if ($isWhere) {
					$sql .= " AND ";
				} else {
					$sql .= " WHERE ";
					$isWhere = true;
				}
				$sql .= " P.".CommonVals::$NameCustomer." LIKE '%".$namekey."%' ";
			}
			
			if ($status != "")
			{
				if ($isWhere) {
					$sql .= " AND ";
				} else {
					$sql .= " WHERE ";
					$isWhere = true;
				}
				$sql .= " P.".CommonVals::$StatusID."='".$status."' ";
			}
			
			if ($tempsql != "")
			{
				if (!$isWhere) {
					$sql .= " WHERE 1=1 ";
					$isWhere = true;
				}
				$sql .= " ".$tempsql;
			}
			
			if ($isWhere) {
				$sql .= " AND ";
			} else {
				$sql .= " WHERE ";
				$isWhere = true;
			}
			$sql .= " P.".CommonVals::$IsDelete."=0 AND P.".CommonVals::$IsBackup."=0 ";
			
			$sql .= " ORDER BY P.".CommonVals::$datecreate." DESC ";
			
			$sql .= " LIMIT ".$start.",".$lenght;
			
			$profiles = $con -> getvalueString($sql);
	
			if(sizeof($profiles) != 0) {
				foreach ($profiles as $row) {
					$aProfile = new ProfileCustomer();
					$aProfile -> setIDProfile($row[0]);
					$aProfile -> setIDCODE($row[1]);
					
					$status = new Status();
					$status -> setStatusID($row[2]);
					$status -> setStatusName($row[3]);
					$aProfile -> setStatus($status);
					
					$typeLoan = new TypeLoan();
					$typeLoan -> setLoanID($row[4]);
					$typeLoan -> setLoanName($row[5]);
					$aProfile -> setTypeLoan($typeLoan);
					
					$aProfile -> setEmailDealer($row[6]);
					$aProfile -> setUserManager($row[7]);
					$aProfile -> setNameCustomer($row[8]);
					$aProfile -> setPhoneNumber($row[9]);
					$aProfile -> setProvince($row[10]);
					$aProfile -> setInfoProfile($row[11]);
					$aProfile -> setInfoRequest($row[12]);
					$aProfile -> setAmountLoan($row[13]);
					$aProfile -> setBankLoan($row[14]);
					$aProfile -> setHoaHong($row[15]);
					
					$isgnore = false;
					if ($row[16] == "1") {
						$isgnore = true;
					}
					$aProfile -> setIsgnore($isgnore);
					$aProfile -> setDateCreate($row[17]);
					$aProfile -> setDateUpdate($row[18]);
					
					$isBackup = false;
					if ($row[19] == "1") {
						$isBackup = true;
					}
					$aProfile -> setIsBackup($isBackup);
					$aProfile -> setUserBackup($row[20]);
					
					$isDelete = false;
					if ($row[21] == "1") {
						$isDelete = true;
					}
					$aProfile -> setIsDelete($isDelete);
					$aProfile -> setDateDelete($row[22]);
					$aProfile -> setUserDelete($row[23]);
					
					array_push($result, $aProfile);
				}
			}
	
			return $result;
		} catch (Exception $e) {
			//echo 'Caught exception: ',  $e->getMessage(), "\n";
			return $result;
		}
	}
	
	function insertProfileDealer($profile) {
		$con = new ConnectDB();
		$tbl = CommonVals::$tbl_profile_customer;
		$fn = array(CommonVals::$IDPro => $profile->getIDProfile(), CommonVals::$datecreate => $profile->getDateCreate(), CommonVals::$StatusID => $profile->getStatus()->getStatusID(), CommonVals::$LoanID => $profile->getTypeLoan()->getLoanID(), CommonVals::$IDCODE => $profile->getIDCODE(), CommonVals::$EmailDealer => $profile->getEmailDealer(), CommonVals::$UserManager => $profile->getUserManager(), CommonVals::$NameCustomer => $profile->getNameCustomer(), CommonVals::$PhoneNumber => $profile->getPhoneNumber(), CommonVals::$Province => $profile->getProvince(), CommonVals::$InfoPro => $profile->getInfoProfile(), CommonVals::$InfoRequest => $profile->getInfoRequest(), CommonVals::$BankLoan => $profile->getBankLoan(), CommonVals::$AmountLoan => $profile->getAmountLoan(), CommonVals::$HoaHong => $profile->getHoaHong(), CommonVals::$dateupdate => $profile->getDateUpdate());
		if ($con -> insert($tbl, $fn)) {
			return true;
		} else {
			return false;
		}
	}
	
	function backupProfileDealer($profile) {
		$isBackup = 0;
		if ($profile->isBackup()) {
			$isBackup = 1;
		}
		
		$con = new ConnectDB();
		$tbl = CommonVals::$tbl_profile_customer;
		$fn = array(CommonVals::$IsBackup => $isBackup, CommonVals::$UserBackup => $profile->getUserBackup());
		$conf = array(CommonVals::$IDPro => $profile->getIDProfile(), CommonVals::$datecreate => $profile->getDateCreate());
		if ($con -> update($tbl, $fn, $conf)) {
			return true;
		} else {
			return false;
		}
	}
	
	function deleteProfileDealer($profile) {
		$isDelete = 0;
		if ($profile->isDelete()) {
			$isDelete = 1;
		}
		
		$con = new ConnectDB();
		$tbl = CommonVals::$tbl_profile_customer;
		$fn = array(CommonVals::$IsDelete => $isDelete, CommonVals::$UserDelete => $profile->getUserDelete(), CommonVals::$DateDelete => $profile->getDateDelete());
		$conf = array(CommonVals::$IDPro => $profile->getIDProfile());
		if ($con -> update($tbl, $fn, $conf)) {
			return true;
		} else {
			return false;
		}
	}
	
	/**
	get profiles by idpro
	*/
	function getProfileDetailByIDPro($email, $idPro) {
		$result=array();
		
		try {
			$con = new ConnectDB();
	
			$sql = "SELECT ";
			$sql .= "P.".CommonVals::$IDPro.", ";
			$sql .= "P.".CommonVals::$IDCODE.", ";
			$sql .= "P.".CommonVals::$StatusID.", ";
			$sql .= "S.".CommonVals::$StatusName.", ";
			$sql .= "P.".CommonVals::$LoanID.", ";
			$sql .= "T.".CommonVals::$LoanName.", ";
			$sql .= "P.".CommonVals::$EmailDealer.", ";
			$sql .= "P.".CommonVals::$UserManager.", ";
			$sql .= "P.".CommonVals::$NameCustomer.", ";
			$sql .= "P.".CommonVals::$PhoneNumber.", ";
			$sql .= "P.".CommonVals::$Province.", ";
			$sql .= "P.".CommonVals::$InfoPro.", ";
			$sql .= "P.".CommonVals::$InfoRequest.", ";
			$sql .= "P.".CommonVals::$AmountLoan.", ";
			$sql .= "P.".CommonVals::$BankLoan.", ";
			$sql .= "P.".CommonVals::$HoaHong.", ";
			$sql .= "P.".CommonVals::$Isgnore.", ";
			$sql .= "P.".CommonVals::$datecreate.", ";
			$sql .= "P.".CommonVals::$dateupdate.", ";
			$sql .= "P.".CommonVals::$IsBackup.", ";
			$sql .= "P.".CommonVals::$UserBackup.", ";
			$sql .= "P.".CommonVals::$IsDelete.", ";
			$sql .= "P.".CommonVals::$DateDelete.", ";
			$sql .= "P.".CommonVals::$UserDelete." ";
			$sql .= " FROM ".CommonVals::$tbl_type_loan." AS T INNER JOIN ".CommonVals::$tbl_profile_customer." AS P ON P.".CommonVals::$LoanID."=T.".CommonVals::$LoanID." LEFT JOIN ".CommonVals::$tbl_status_proccess_profile." AS S ON S.".CommonVals::$StatusID."=P.".CommonVals::$StatusID." ";
			
			$sql .= " WHERE P.".CommonVals::$EmailDealer."='".$email."' AND P.".CommonVals::$IDPro."='".$idPro."'";
			$sql .= " ORDER BY P.".CommonVals::$datecreate." DESC, P.".CommonVals::$IsBackup;
			
			$profiles = $con -> getvalueString($sql);
	
			if(sizeof($profiles) != 0) {
				foreach ($profiles as $row) {
					$aProfile = new ProfileCustomer();
					$aProfile -> setIDProfile($row[0]);
					$aProfile -> setIDCODE($row[1]);
					
					$status = new Status();
					$status -> setStatusID($row[2]);
					$status -> setStatusName($row[3]);
					$aProfile -> setStatus($status);
					
					$typeLoan = new TypeLoan();
					$typeLoan -> setLoanID($row[4]);
					$typeLoan -> setLoanName($row[5]);
					$aProfile -> setTypeLoan($typeLoan);
					
					$aProfile -> setEmailDealer($row[6]);
					$aProfile -> setUserManager($row[7]);
					$aProfile -> setNameCustomer($row[8]);
					$aProfile -> setPhoneNumber($row[9]);
					$aProfile -> setProvince($row[10]);
					$aProfile -> setInfoProfile($row[11]);
					$aProfile -> setInfoRequest($row[12]);
					$aProfile -> setAmountLoan($row[13]);
					$aProfile -> setBankLoan($row[14]);
					$aProfile -> setHoaHong($row[15]);
					
					$isgnore = false;
					if ($row[16] == "1") {
						$isgnore = true;
					}
					$aProfile -> setIsgnore($isgnore);
					$aProfile -> setDateCreate($row[17]);
					$aProfile -> setDateUpdate($row[18]);
					
					$isBackup = false;
					if ($row[19] == "1") {
						$isBackup = true;
					}
					$aProfile -> setIsBackup($isBackup);
					$aProfile -> setUserBackup($row[20]);
					
					$isDelete = false;
					if ($row[21] == "1") {
						$isDelete = true;
					}
					$aProfile -> setIsDelete($isDelete);
					$aProfile -> setDateDelete($row[22]);
					$aProfile -> setUserDelete($row[23]);
					
					array_push($result, $aProfile);
				}
			}
	
			return $result;
		} catch (Exception $e) {
			//echo 'Caught exception: ',  $e->getMessage(), "\n";
			return $result;
		}
	}
	
	/**
	get profiles by idpro
	*/
	function getProfileByIDProOnly($idPro, $dateCreate) {
		$aProfile = new ProfileCustomer();
		
		try {
			$con = new ConnectDB();
	
			$sql = "SELECT ";
			$sql .= "P.".CommonVals::$IDPro.", ";
			$sql .= "P.".CommonVals::$IDCODE.", ";
			$sql .= "P.".CommonVals::$StatusID.", ";
			$sql .= "S.".CommonVals::$StatusName.", ";
			$sql .= "P.".CommonVals::$LoanID.", ";
			$sql .= "T.".CommonVals::$LoanName.", ";
			$sql .= "P.".CommonVals::$EmailDealer.", ";
			$sql .= "P.".CommonVals::$UserManager.", ";
			$sql .= "P.".CommonVals::$NameCustomer.", ";
			$sql .= "P.".CommonVals::$PhoneNumber.", ";
			$sql .= "P.".CommonVals::$Province.", ";
			$sql .= "P.".CommonVals::$InfoPro.", ";
			$sql .= "P.".CommonVals::$InfoRequest.", ";
			$sql .= "P.".CommonVals::$AmountLoan.", ";
			$sql .= "P.".CommonVals::$BankLoan.", ";
			$sql .= "P.".CommonVals::$HoaHong.", ";
			$sql .= "P.".CommonVals::$Isgnore.", ";
			$sql .= "P.".CommonVals::$datecreate.", ";
			$sql .= "P.".CommonVals::$dateupdate.", ";
			$sql .= "P.".CommonVals::$IsBackup.", ";
			$sql .= "P.".CommonVals::$UserBackup.", ";
			$sql .= "P.".CommonVals::$IsDelete.", ";
			$sql .= "P.".CommonVals::$DateDelete.", ";
			$sql .= "P.".CommonVals::$UserDelete." ";
			$sql .= " FROM ".CommonVals::$tbl_type_loan." AS T INNER JOIN ".CommonVals::$tbl_profile_customer." AS P ON P.".CommonVals::$LoanID."=T.".CommonVals::$LoanID." LEFT JOIN ".CommonVals::$tbl_status_proccess_profile." AS S ON S.".CommonVals::$StatusID."=P.".CommonVals::$StatusID." ";
			
			$sql .= " WHERE P.".CommonVals::$datecreate."='".$dateCreate."' AND P.".CommonVals::$IDPro."='".$idPro."' ";
			
			$profiles = $con -> getvalueString($sql);
	
			if(sizeof($profiles) != 0) {
				foreach ($profiles as $row) {
					$aProfile -> setIDProfile($row[0]);
					$aProfile -> setIDCODE($row[1]);
					
					$status = new Status();
					$status -> setStatusID($row[2]);
					$status -> setStatusName($row[3]);
					$aProfile -> setStatus($status);
					
					$typeLoan = new TypeLoan();
					$typeLoan -> setLoanID($row[4]);
					$typeLoan -> setLoanName($row[5]);
					$aProfile -> setTypeLoan($typeLoan);
					
					$aProfile -> setEmailDealer($row[6]);
					$aProfile -> setUserManager($row[7]);
					$aProfile -> setNameCustomer($row[8]);
					$aProfile -> setPhoneNumber($row[9]);
					$aProfile -> setProvince($row[10]);
					$aProfile -> setInfoProfile($row[11]);
					$aProfile -> setInfoRequest($row[12]);
					$aProfile -> setAmountLoan($row[13]);
					$aProfile -> setBankLoan($row[14]);
					$aProfile -> setHoaHong($row[15]);
					
					$isgnore = false;
					if ($row[16] == "1") {
						$isgnore = true;
					}
					$aProfile -> setIsgnore($isgnore);
					$aProfile -> setDateCreate($row[17]);
					$aProfile -> setDateUpdate($row[18]);
					
					$isBackup = false;
					if ($row[19] == "1") {
						$isBackup = true;
					}
					$aProfile -> setIsBackup($isBackup);
					$aProfile -> setUserBackup($row[20]);
					
					$isDelete = false;
					if ($row[21] == "1") {
						$isDelete = true;
					}
					$aProfile -> setIsDelete($isDelete);
					$aProfile -> setDateDelete($row[22]);
					$aProfile -> setUserDelete($row[23]);
				}
			}
	
			return $aProfile;
		} catch (Exception $e) {
			//echo 'Caught exception: ',  $e->getMessage(), "\n";
			return $aProfile;
		}
	}
	
	function loadSumSalaryMonth($userdealer, $monthDate) {
		$con = new ConnectDB();
	
		$sql = "SELECT sum(".CommonVals::$HoaHong.") AS SUMSALARY FROM ".CommonVals::$tbl_profile_customer." WHERE ".CommonVals::$IsBackup."=0 AND ".CommonVals::$EmailDealer."='".$userdealer."' AND ".CommonVals::$datecreate.">=".$monthDate;
		return $con -> getvalueString($sql);
	}
	
	function calculatorSalaryDealer($user, $datestart, $dateend) {
		$con = new ConnectDB();
		
		$sql = "SELECT sum(".CommonVals::$HoaHong.") AS SUMSALARY FROM ".CommonVals::$tbl_profile_customer." WHERE ".CommonVals::$IsBackup."=0 AND ".CommonVals::$EmailDealer."='".$user."' ";
		if($datestart != "") {
			$datestart = strtotime($datestart." 00:00");
			$sql .= " AND ".CommonVals::$datecreate.">=".$datestart." ";
		}
		
		if($dateend != "") {
			$dateend = strtotime($dateend." 23:59");
			$sql .= " AND ".CommonVals::$datecreate."<=".$dateend." ";
		}
		
		return $con -> getvalueString($sql);
	}
}
?>