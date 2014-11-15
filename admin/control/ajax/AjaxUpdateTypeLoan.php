<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/src/db/connectdatabase.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/src/entitys/TypeLoan.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/src/DAO/TypeLoanDAO.php');
session_start();

$result = 'fail';
if(isset($_SESSION['adminlogintcdealeronline'])) {
	try {
		if (isset($_POST['action'])) {
			if ($_POST['action'] == "lock") {
				if (isset($_POST['idpe'])) {
					$IDTypeLoan = trim($_POST['idpe']);
					if ($IDTypeLoan != "") {
						$typeLoanDAO = new TypeLoanDao();
						$typeLoan = new TypeLoan();
						$typeLoan->setLoanID($IDTypeLoan);
						$typeLoan->setIsLock(true);
						$typeLoan->setDateUpdate(time());
						
						if ($typeLoanDAO->lockTypeLoan($typeLoan)) {
							$result = 'success';
						}
					}
				}
			} else if ($_POST['action'] == "unlock") {
				if (isset($_POST['idpe'])) {
					$IDTypeLoan = trim($_POST['idpe']);
					if ($IDTypeLoan != "") {
						$typeLoanDAO = new TypeLoanDao();
						$typeLoan = new TypeLoan();
						$typeLoan->setLoanID($IDTypeLoan);
						$typeLoan->setIsLock(false);
						$typeLoan->setDateUpdate(time());
						
						if ($typeLoanDAO->lockTypeLoan($typeLoan)) {
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