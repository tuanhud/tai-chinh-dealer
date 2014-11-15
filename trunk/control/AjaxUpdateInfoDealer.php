<?php
session_start();
include_once($_SERVER['DOCUMENT_ROOT'].'/src/DAO/DealerDAO.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/src/entitys/Dealer.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/src/entitys/Bank.php');

$result = "false";

if(isset($_SESSION['taichinhondealer'])) {
	$email = $_SESSION['taichinhondealer'];
	if(isset($_POST['act'])) {
		$act = $_POST['act'];
		if($act == "updainfo") {
			if(isset($_POST['namere']) && isset($_POST['gend']) && isset($_POST['birthdayre']) && isset($_POST['phonere']) && isset($_POST['homephonere']) && isset($_POST['addressre']) && isset($_POST['provicere']) && isset($_POST['dvct']) && isset($_POST['dcct']) && isset($_POST['gtcv']) && isset($_POST['gtknlv']) && isset($_POST['stk']) && isset($_POST['ngh'])) {
				$name = $_POST['namere'];
				$gender = $_POST['gend'];
				$dayofbirth = strtotime($_POST['birthdayre']);
				$mobile = $_POST['phonere'];
				$homephone = $_POST['homephonere'];
				$address = $_POST['addressre'];
				$province = $_POST['provicere'];
				$dvct = $_POST['dvct'];
				$dcct = $_POST['dcct'];
				$gtcv = $_POST['gtcv'];
				$gtknlv = $_POST['gtknlv'];
				$codebank = $_POST['stk'];
				$bank = $_POST['ngh'];
				if ($name != "" && $gender != "" && $dayofbirth != "" && $mobile != "" && $address != "" && $province != "" && $dvct != "" && $dcct != "" && $gtcv != "" && $gtknlv != "" && $codebank != "" && $bank != "") {
					$aDealer = new Dealer();
					$aDealer -> setEmailDealer($email);
					$aDealer -> setFullname($name);
					if ($gender == 1) {
						$aDealer -> setGender(true);
					} else {
						$aDealer -> setGender(false);
					}
					$aDealer -> setDayOfBirth($dayofbirth);
					$aDealer -> setMobile($mobile);
					$aDealer -> setHomePhone($homephone);
					$aDealer -> setAddress($address);
					$aDealer -> setProvince($province);
					$aDealer -> setCompanyWork($dvct);
					$aDealer -> setAddressWork($dcct);
					$aDealer -> setInfoIntroWork($gtcv);
					$aDealer -> setKinhNghiem($gtknlv);
					$aDealer -> setCardNumber($codebank);
					
					$aBank = new Bank();
					$aBank -> setBankID($bank);					
					$aDealer -> setBank($aBank);
					
					$dealerDAO = new DealerDAO();
					if($dealerDAO->updateDealer($aDealer) == true) {
						$result = 'true';
					}
				}
			}
		} else if($act == "updainfopas") {
			if(isset($_POST['passoldre']) && isset($_POST['passnewre'])) {
				$passold = $_POST['passoldre'];
				$passnew = $_POST['passnewre'];
				
				$dealerDAO = new DealerDAO();
				$pass = sha1($email.$passold);
				$dealerList = $dealerDAO->getDealerInfoByEmail($email);
				
				if (count($dealerList) > 0) {
					$aDealer = $dealerList[0];
					
					if($aDealer->getPassword() == $pass) {
						$dealer = new Dealer();
						$dealer->setEmailDealer($email);
						$dealer->setPassword(sha1($email.$passnew));
						if ($dealerDAO -> updatePasswordDealer($dealer)) {
							$result = 'true';
						}
					} else {
						$result = "notavali";
					}
				} else {
					$result = "notavali";
				}
			}
		}
	}
}

echo json_encode($result);
?>