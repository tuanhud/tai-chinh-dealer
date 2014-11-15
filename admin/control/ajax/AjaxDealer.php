<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/src/entitys/Dealer.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/src/DAO/DealerDAO.php');
session_start();

$result = "fail";

if(isset($_SESSION['adminlogintcdealeronline'])) {
	$dealerDao = new DealerDAO();
	$action = $_POST['act'];
	if($action == 'acti') {
		$result = false;
		if(isset($_POST['idre'])) {
			$id = $_POST['idre'];
			$code = "DL";
			$arridcode = $dealerDao->getIDLastDealer();
			if(count($arridcode) > 0) {
				$lastcode = $arridcode[0][0];
				$lastcode = substr($lastcode, 2, strlen($lastcode));
				$lastcode += 1;
				
				$temp = "";
				$lengcode = strlen($lastcode);
				if($lengcode < 5) {
					for($i = 0; $i < 5-$lengcode; $i++) {
						$temp .= "0";
					}
				}
				$code .= $temp.$lastcode;
			} else {
				$code .= "00001";
			}
			
			
			if($dealerDao->updateActivityDealer($id, $code)) {
				$result = "success";
			}
		}
	} else if($action == 'lockacc') {
		$result = false;
		if(isset($_POST['idre'])) {
			$id = $_POST['idre'];
			if($dealerDao->updateLockDealer($id)) {
				$result = "success";
			}
		}
	} else if($action == 'unlockacc') {
		$result = false;
		if(isset($_POST['idre'])) {
			$id = $_POST['idre'];
			if($dealerDao->updateUnlockDealer($id)) {
				$result = "success";
			}
		}
	}
}
echo json_encode($result);
?>