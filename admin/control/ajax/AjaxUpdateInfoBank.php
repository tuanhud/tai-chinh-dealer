<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/src/db/connectdatabase.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/src/entitys/Bank.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/src/DAO/BankDAO.php');
session_start();

$result = 'fail';
if(isset($_SESSION['adminlogintcdealeronline'])) {
	try {
		if (isset($_POST['action'])) {
			if ($_POST['action'] == "lock") {
				if (isset($_POST['idpe'])) {
					$IDBank = trim($_POST['idpe']);
					if ($IDBank != "") {
						$bankDAO = new BankDao();
						$bank = new Bank();
						$bank->setBankID($IDBank);
						$bank->setIsLock(true);
						$bank->setDateUpdate(time());
						
						if ($bankDAO->lockBank($bank)) {
							$result = 'success';
						}
					}
				}
			} else if ($_POST['action'] == "unlock") {
				if (isset($_POST['idpe'])) {
					$IDBank = trim($_POST['idpe']);
					if ($IDBank != "") {
						$bankDao = new BankDAO();
						$bank = new Bank();
						$bank->setBankID($IDBank);
						$bank->setIsLock(false);
						$bank->setDateUpdate(time());
						
						if ($bankDao->lockBank($bank)) {
							$result = 'success';
						}
					}
				}
			}
		}
	} catch (Exception $e) {
		//echo 'Caught exception: ',  $e->getMessage(), "\n";
		$result = 'fail';
	}
}
echo ($result);
?>