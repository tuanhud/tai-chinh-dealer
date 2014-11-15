<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/src/entitys/Dealer.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/src/DAO/DealerDAO.php');
session_start();

$dealerDAO = new DealerDAO();

$result = "false";

if(isset($_POST['emailre']) && isset($_POST['passre'])) {
	$email = $_POST['emailre'];
	$pass = sha1($email.$_POST['passre']);
	$dealerList = $dealerDAO->getDealerInfoByEmail($email);
	
	if (count($dealerList) > 0) {
		$aDealer = $dealerList[0];
		
		if($aDealer->getPassword() == $pass) {
			if($aDealer->isAccept()) {
				if(!$aDealer->isLock()) {
					$_SESSION['taichinhondealer'] = $email;
					$result = "true";
				} else {
					$result = "lock";
				}
			} else {
				$result = "acti";
			}
		}
	}
}

echo json_encode($result);
?>