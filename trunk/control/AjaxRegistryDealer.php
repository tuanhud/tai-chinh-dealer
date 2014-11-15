<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/src/entitys/Bank.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/src/entitys/Dealer.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/src/DAO/DealerDAO.php');

$dealerDAO = new DealerDAO();

$result = "false";
if(isset($_POST['emailre'])) {
	$email = $_POST['emailre'];
	if (trim($email) != "") {
		$dealerList = $dealerDAO->getDealerInfoByEmail($email);
		if(count($dealerList) == 0) {
			if(isset($_POST['passre']) && isset($_POST['namere']) && isset($_POST['gend']) && isset($_POST['birthdayre']) && isset($_POST['phonere']) && isset($_POST['homephonere']) && isset($_POST['addressre']) && isset($_POST['provicere']) && isset($_POST['dvct']) && isset($_POST['dcct']) && isset($_POST['gtcv']) && isset($_POST['gtknlv']) && isset($_POST['stk']) && isset($_POST['ngh'])) {
				
				$aDealer = new Dealer();
				$aDealer -> setEmailDealer($email);
				$aDealer -> setPassword(sha1($email.$_POST['passre']));
				$aDealer -> setFullname($_POST['namere']);
				if ($_POST['gend'] == 1)
					$aDealer -> setGender(true);
				else
					$aDealer -> setGender(false);
				$aDealer -> setDayOfBirth(strtotime($_POST['birthdayre']));
				$aDealer -> setMobile($_POST['phonere']);
				$aDealer -> setHomePhone($_POST['homephonere']);
				$aDealer -> setAddress($_POST['addressre']);
				$aDealer -> setProvince($_POST['provicere']);
				$aDealer -> setCompanyWork($_POST['dvct']);
				$aDealer -> setAddressWork($_POST['dcct']);
				$aDealer -> setInfoIntroWork($_POST['gtcv']);
				$aDealer -> setKinhNghiem($_POST['gtknlv']);
				$aDealer -> setCardNumber($_POST['stk']);
				
				$aBank = new Bank();
				$aBank -> setBankID($_POST['ngh']);
				$aDealer -> setBank($aBank);
				
				$aDealer -> setDateCreate(time());
				$aDealer -> setIsAccept(false);
				$aDealer -> setIsLock(false);
				
				
				if($dealerDAO->insertDealer($aDealer)) {
					$result = "true";
				}
			}
		} else {
			$result = "exits";
		}
	}
}

echo json_encode($result);
?>