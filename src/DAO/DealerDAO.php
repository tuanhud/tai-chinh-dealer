<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/src/db/connectdatabase.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/src/common/CommonVals.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/src/entitys/Dealer.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/src/entitys/Bank.php');

class DealerDAO {
	function getRowDealers($makh, $email, $namekey, $mobile, $city, $tempsql, $isRoot, $UserID) {
		$result = 0;
		try {
			$con = new ConnectDB();
			
			$isWhere = false;
			
			$sql = "SELECT count(D.".CommonVals::$IDCODE.")";
			if (!$isRoot) {
				$sql .= " FROM ".CommonVals::$tbl_authorization_link." AS A INNER JOIN ".CommonVals::$tbl_dealer_bank." AS D ON A.".CommonVals::$EmailDealer."=D.".CommonVals::$EmailDealer." ";
			
				$sql .= " WHERE A.".CommonVals::$user_id."='".$UserID."' ";
				$isWhere = true;
			} else {
				$sql .= " FROM ".CommonVals::$tbl_dealer_bank." AS D ";
			}
			
			if ($makh != "") {
				if (!$isWhere) {
					$sql .= " WHERE ";
					$isWhere = true;
				} else {
					$sql .= " AND ";
				}
				$sql .= " D.".CommonVals::$IDCODE." LIKE '%".$makh."%' ";
			}
			if ($email != "") {
				if (!$isWhere) {
					$sql .= " WHERE ";
					$isWhere = true;
				} else {
					$sql .= " AND ";
				}
				$sql .= "D.".CommonVals::$EmailDealer." LIKE '%".$email."%' ";
			}
			if ($namekey != "") {
				if (!$isWhere) {
					$sql .= " WHERE ";
					$isWhere = true;
				} else {
					$sql .= " AND ";
				}
				$sql .= "D.".CommonVals::$NameDealer." LIKE '%".$namekey."%' ";
			}
			if ($mobile != "") {
				if (!$isWhere) {
					$sql .= " WHERE ";
					$isWhere = true;
				} else {
					$sql .= " AND ";
				}
				$sql .= "D.".CommonVals::$Mobile." LIKE '%".$mobile."%' ";
			}
			if ($city != "") {
				if (!$isWhere) {
					$sql .= " WHERE ";
					$isWhere = true;
				} else {
					$sql .= " AND ";
				}
				$sql .= "D.".CommonVals::$Province." LIKE '%".$city."%' ";
			}
			if ($tempsql != "") {
				if (!$isWhere) {
					$sql .= " WHERE 1=1 ";
				}
				$sql .= $tempsql;
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
	get infomation Dealers
	*/
	function getDealers($makh, $email, $namekey, $mobile, $city, $start, $lenght, $tempsql, $isRoot, $UserID) {
		$result=array();
		
		try {
			$con = new ConnectDB();
	
			$sql = "SELECT ";
			$sql .= "D.".CommonVals::$IDCODE.",";
			$sql .= "D.".CommonVals::$EmailDealer.",";
			$sql .= "D.".CommonVals::$PassDealer.",";
			$sql .= "D.".CommonVals::$NameDealer.",";
			$sql .= "D.".CommonVals::$Gender.",";
			$sql .= "D.".CommonVals::$DayOfBirth.",";
			$sql .= "D.".CommonVals::$Mobile.",";
			$sql .= "D.".CommonVals::$HomePhone.",";
			$sql .= "D.".CommonVals::$Address.",";
			$sql .= "D.".CommonVals::$Province.",";
			$sql .= "D.".CommonVals::$CompanyWork.",";
			$sql .= "D.".CommonVals::$AddressWork.",";
			$sql .= "D.".CommonVals::$IntroInfoWork.",";
			$sql .= "D.".CommonVals::$IntroInfoKill.",";
			$sql .= "D.".CommonVals::$CardNumber.",";
			$sql .= "D.".CommonVals::$BankID.",";
			$sql .= "B.".CommonVals::$BankName.",";
			$sql .= "D.".CommonVals::$DateRegis.",";
			$sql .= "D.".CommonVals::$IsAccept.",";
			$sql .= "D.".CommonVals::$DateAccept.",";
			$sql .= "D.".CommonVals::$IsLock;
			
			$isWhere = false;
			
			if (!$isRoot) {
				$sql .= " FROM ".CommonVals::$tbl_authorization_link." AS A INNER JOIN ".CommonVals::$tbl_dealer_bank." AS D ON A.".CommonVals::$EmailDealer."=D.".CommonVals::$EmailDealer." LEFT JOIN ".CommonVals::$tbl_bank." AS B ";
				$sql .= " ON D.".CommonVals::$BankID."=B.".CommonVals::$BankID;
				
				$sql .= " WHERE A.".CommonVals::$user_id."='".$UserID."' ";
				$isWhere = true;
			} else {
				$sql .= " FROM ".CommonVals::$tbl_dealer_bank." AS D LEFT JOIN ".CommonVals::$tbl_bank." AS B ";
				$sql .= " ON D.".CommonVals::$BankID."=B.".CommonVals::$BankID;
			}
			
			if ($makh != "") {
				if (!$isWhere) {
					$sql .= " WHERE ";
					$isWhere = true;
				} else {
					$sql .= " AND ";
				}
				$sql .= " D.".CommonVals::$IDCODE." LIKE '%".$makh."%' ";
			}
			if ($email != "") {
				if (!$isWhere) {
					$sql .= " WHERE ";
					$isWhere = true;
				} else {
					$sql .= " AND ";
				}
				$sql .= " D.".CommonVals::$EmailDealer." LIKE '%".$email."%' ";
			}
			if ($namekey != "") {
				if (!$isWhere) {
					$sql .= " WHERE ";
					$isWhere = true;
				} else {
					$sql .= " AND ";
				}
				$sql .= " D.".CommonVals::$NameDealer." LIKE '%".$namekey."%' ";
			}
			if ($mobile != "") {
				if (!$isWhere) {
					$sql .= " WHERE ";
					$isWhere = true;
				} else {
					$sql .= " AND ";
				}
				$sql .= " D.".CommonVals::$Mobile." LIKE '%".$mobile."%' ";
			}
			if ($city != "") {
				if (!$isWhere) {
					$sql .= " WHERE ";
					$isWhere = true;
				} else {
					$sql .= " AND ";
				}
				$sql .= " D.".CommonVals::$Province." LIKE '%".$city."%' ";
			}
			if ($tempsql != "") {
				if (!$isWhere) {
					$sql .= " WHERE 1=1 ";
				}
				$sql .= $tempsql;
			}
			
			$sql .= " ORDER BY D.".CommonVals::$IsAccept.", D.".CommonVals::$DateRegis." DESC LIMIT ".$start.",".$lenght;
			$dealers = $con -> getvalueString($sql);
	
			if(sizeof($dealers) != 0) {
				foreach ($dealers as $row) {
					$aDealer = new Dealer();
					$aDealer -> setIDCODE($row[0]);
					$aDealer -> setEmailDealer($row[1]);
					$aDealer -> setPassword($row[2]);
					$aDealer -> setFullname($row[3]);
					if ($row[4] == 1)
						$aDealer -> setGender(true);
					else
						$aDealer -> setGender(false);
					$aDealer -> setDayOfBirth($row[5]);
					$aDealer -> setMobile($row[6]);
					$aDealer -> setHomePhone($row[7]);
					$aDealer -> setAddress($row[8]);
					$aDealer -> setProvince($row[9]);
					$aDealer -> setCompanyWork($row[10]);
					$aDealer -> setAddressWork($row[11]);
					$aDealer -> setInfoIntroWork($row[12]);
					$aDealer -> setKinhNghiem($row[13]);
					$aDealer -> setCardNumber($row[14]);
					
					$aBank = new Bank();
					$aBank -> setBankID($row[15]);
					$aBank -> setBankName($row[16]);
					$aDealer -> setBank($aBank);
					
					$aDealer -> setDateCreate($row[17]);
					
					if ($row[18] == 1)
						$aDealer -> setIsAccept(true);
					else
						$aDealer -> setIsAccept(false);
					
					$aDealer -> setDateAccept($row[19]);
					
					if ($row[20] == 1)
						$aDealer -> setIsLock(true);
					else
						$aDealer -> setIsLock(false);
					
					array_push($result, $aDealer);
				}
			}
	
			return $result;
		} catch (Exception $e) {
			//echo 'Caught exception: ',  $e->getMessage(), "\n";
			return $result;
		}
	}
	
	/**
	get infomation Dealer by email
	*/
	function getDealerInfoByEmail($email) {
		$result=array();
		
		try {
			$con = new ConnectDB();
	
			$sql = "SELECT ";
			$sql .= "D.".CommonVals::$IDCODE.",";
			$sql .= "D.".CommonVals::$EmailDealer.",";
			$sql .= "D.".CommonVals::$PassDealer.",";
			$sql .= "D.".CommonVals::$NameDealer.",";
			$sql .= "D.".CommonVals::$Gender.",";
			$sql .= "D.".CommonVals::$DayOfBirth.",";
			$sql .= "D.".CommonVals::$Mobile.",";
			$sql .= "D.".CommonVals::$HomePhone.",";
			$sql .= "D.".CommonVals::$Address.",";
			$sql .= "D.".CommonVals::$Province.",";
			$sql .= "D.".CommonVals::$CompanyWork.",";
			$sql .= "D.".CommonVals::$AddressWork.",";
			$sql .= "D.".CommonVals::$IntroInfoWork.",";
			$sql .= "D.".CommonVals::$IntroInfoKill.",";
			$sql .= "D.".CommonVals::$CardNumber.",";
			$sql .= "D.".CommonVals::$BankID.",";
			$sql .= "B.".CommonVals::$BankName.",";
			$sql .= "D.".CommonVals::$DateRegis.",";
			$sql .= "D.".CommonVals::$IsAccept.",";
			$sql .= "D.".CommonVals::$DateAccept.",";
			$sql .= "D.".CommonVals::$IsLock;
			$sql .= " FROM ".CommonVals::$tbl_dealer_bank." AS D LEFT JOIN ".CommonVals::$tbl_bank." AS B";
			$sql .= " ON D.".CommonVals::$BankID."=B.".CommonVals::$BankID;
			
			if (trim($email) != "")
			{
				$sql .= " WHERE ";
				$sql .= "D.".CommonVals::$EmailDealer."='".$email."'";
			}
			
			$dealers = $con -> getvalueString($sql);
	
			if(sizeof($dealers) != 0) {
				foreach ($dealers as $row) {
					$aDealer = new Dealer();
					$aDealer -> setIDCODE($row[0]);
					$aDealer -> setEmailDealer($row[1]);
					$aDealer -> setPassword($row[2]);
					$aDealer -> setFullname($row[3]);
					if ($row[4] == 1)
						$aDealer -> setGender(true);
					else
						$aDealer -> setGender(false);
					$aDealer -> setDayOfBirth($row[5]);
					$aDealer -> setMobile($row[6]);
					$aDealer -> setHomePhone($row[7]);
					$aDealer -> setAddress($row[8]);
					$aDealer -> setProvince($row[9]);
					$aDealer -> setCompanyWork($row[10]);
					$aDealer -> setAddressWork($row[11]);
					$aDealer -> setInfoIntroWork($row[12]);
					$aDealer -> setKinhNghiem($row[13]);
					$aDealer -> setCardNumber($row[14]);
					
					$aBank = new Bank();
					$aBank -> setBankID($row[15]);
					$aBank -> setBankName($row[16]);
					$aDealer -> setBank($aBank);
					
					$aDealer -> setDateCreate($row[17]);
					
					if ($row[18] == 1)
						$aDealer -> setIsAccept(true);
					else
						$aDealer -> setIsAccept(false);
					
					$aDealer -> setDateAccept($row[19]);
					
					if ($row[20] == 1)
						$aDealer -> setIsLock(true);
					else
						$aDealer -> setIsLock(false);
					
					array_push($result, $aDealer);
				}
			}
	
			return $result;
		} catch (Exception $e) {
			//echo 'Caught exception: ',  $e->getMessage(), "\n";
			return $result;
		}
	}
	
	function insertDealer($aDealer) {
		$con = new ConnectDB();
	
		$gender = 0;
		if ($aDealer->getGender() == true){
			$gender = 1;
		}
		
		$tbl = CommonVals::$tbl_dealer_bank;
		$fn = array(CommonVals::$IDCODE => $aDealer->getIDCODE(), CommonVals::$EmailDealer => $aDealer->getEmailDealer(), CommonVals::$PassDealer => $aDealer->getPassword(), CommonVals::$NameDealer => $aDealer->getFullname(), CommonVals::$Gender => $gender, CommonVals::$DayOfBirth => $aDealer->getDayOfBirth(), CommonVals::$Mobile => $aDealer->getMobile(), CommonVals::$HomePhone => $aDealer->getHomePhone(), CommonVals::$Address => $aDealer->getAddress(), CommonVals::$Province => $aDealer->getProvince(), CommonVals::$CompanyWork => $aDealer->getCompanyWork(), CommonVals::$AddressWork => $aDealer->getAddressWork(), CommonVals::$IntroInfoWork => $aDealer->getInfoIntroWork(), CommonVals::$IntroInfoKill => $aDealer->getKinhNghiem(), CommonVals::$CardNumber => $aDealer->getCardNumber(), CommonVals::$BankID => $aDealer->getBank()->getBankID(), CommonVals::$DateRegis => $aDealer->getDateCreate());
		return $con -> insert($tbl, $fn);
	}
	
	function updateDealer($aDealer) {
		$con = new ConnectDB();
	
		$gender = 0;
		if ($aDealer->getGender() == true){
			$gender = 1;
		}
		
		$tbl = CommonVals::$tbl_dealer_bank;
		$fn = array(CommonVals::$NameDealer => $aDealer->getFullname(), CommonVals::$Gender => $gender, CommonVals::$DayOfBirth => $aDealer->getDayOfBirth(), CommonVals::$Mobile => $aDealer->getMobile(), CommonVals::$HomePhone => $aDealer->getHomePhone(), CommonVals::$Address => $aDealer->getAddress(), CommonVals::$Province => $aDealer->getProvince(), CommonVals::$CompanyWork => $aDealer->getCompanyWork(), CommonVals::$AddressWork => $aDealer->getAddressWork(), CommonVals::$IntroInfoWork => $aDealer->getInfoIntroWork(), CommonVals::$IntroInfoKill => $aDealer->getKinhNghiem(), CommonVals::$CardNumber => $aDealer->getCardNumber(), CommonVals::$BankID => $aDealer->getBank()->getBankID());
		$conf = array(CommonVals::$EmailDealer => $aDealer->getEmailDealer());
		return $con -> update($tbl, $fn, $conf);
	}
	
	/**
	get infomation Dealer display add dealer for account
	*/
	function getDealersAddForDealer() {
		$result=array();
		
		try {
			$con = new ConnectDB();
	
			$sql = "SELECT ";
			$sql .= " D.".CommonVals::$IDCODE.",";
			$sql .= " D.".CommonVals::$EmailDealer.",";
			$sql .= " D.".CommonVals::$NameDealer.",";
			$sql .= " D.".CommonVals::$Gender.",";
			$sql .= " D.".CommonVals::$Mobile.",";
			$sql .= " D.".CommonVals::$Province;
			$sql .= " FROM ".CommonVals::$tbl_dealer_bank." AS D LEFT JOIN ".CommonVals::$tbl_authorization_link." AS A";
			$sql .= " ON (D.".CommonVals::$EmailDealer." = A.".CommonVals::$EmailDealer." ) ";
			$sql .= " WHERE ";
			$sql .= " D.".CommonVals::$IsLock."='0' AND D.".CommonVals::$IsAccept."='1' ";
			$sql .= " AND A.".CommonVals::$EmailDealer." IS NULL ";
			
			$dealers = $con -> getvalueString($sql);
	
			if(sizeof($dealers) != 0) {
				foreach ($dealers as $row) {
					$aDealer = new Dealer();
					$aDealer -> setIDCODE($row[0]);
					$aDealer -> setEmailDealer($row[1]);
					$aDealer -> setFullname($row[2]);
					if ($row[3] == 1)
						$aDealer -> setGender(true);
					else
						$aDealer -> setGender(false);
					$aDealer -> setMobile($row[4]);
					$aDealer -> setProvince($row[5]);
					
					array_push($result, $aDealer);
				}
			}
	
			return $result;
		} catch (Exception $e) {
			//echo 'Caught exception: ',  $e->getMessage(), "\n";
			return $result;
		}
	}
	
	function getIDLastDealer() {
		$con = new ConnectDB();
		
		$sql = "SELECT ".CommonVals::$IDCODE." FROM ".CommonVals::$tbl_dealer_bank." ORDER BY ".CommonVals::$IDCODE." DESC LIMIT 0,1";
		return $con -> getvalueString($sql);
	}
	
	function updateActivityDealer($email, $code) {
		$con = new ConnectDB();
		
		$tbl = CommonVals::$tbl_dealer_bank;
		$fn = array(CommonVals::$IDCODE => $code, CommonVals::$IsAccept => '1', CommonVals::$DateAccept => time());
		$condition = array(CommonVals::$EmailDealer => $email);
		return $con -> update($tbl, $fn, $condition);
	}

	function updateLockDealer($email) {
		$con = new ConnectDB();
		
		$tbl = CommonVals::$tbl_dealer_bank;
		$fn = array(CommonVals::$IsLock => '1');
		$condition = array(CommonVals::$EmailDealer => $email);
		return $con -> update($tbl, $fn, $condition);
	}
	
	function updateUnlockDealer($email) {
		$con = new ConnectDB();
		
		$tbl = CommonVals::$tbl_dealer_bank;
		$fn = array(CommonVals::$IsLock => '0');
		$condition = array(CommonVals::$EmailDealer => $email);
		return $con -> update($tbl, $fn, $condition);
	}	
	
	function getInfoCodeByDealer($email) {		
		$con = new ConnectDB();
		$tbl = CommonVals::$tbl_dealer_bank;
		$fn = array(CommonVals::$IDCODE);
		$condetion = array(CommonVals::$EmailDealer => $email);
		$author = $con -> getvalue($tbl, $fn, $condetion);
		
		if(sizeof($author) != 0) {
			$result = $author[0][0];
		} else {
			$result = "";
		}

		return $result;
	}
	
	function updatePasswordDealer($dealer) {
		$con = new ConnectDB();
		
		$tbl = CommonVals::$tbl_dealer_bank;
		$fn = array(CommonVals::$PassDealer => $dealer->getPassword());
		$condition = array(CommonVals::$EmailDealer => $dealer->getEmailDealer());
		return $con -> update($tbl, $fn, $condition);
	}
}

?>