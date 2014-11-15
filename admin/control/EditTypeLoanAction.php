<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/src/db/connectdatabase.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/src/control/RedirectForward.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/src/entitys/TypeLoan.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/src/DAO/TypeLoanDAO.php');
session_start();

$url = "/admin/?content=quanli&p=edit-type-loan";
if(isset($_SESSION['adminlogintcdealeronline'])) {
	if(isset($_POST['matypeloan']) && isset($_POST['tentypeloan'])) {
		$idTypeLoan = trim($_POST['matypeloan']);
		$nameTypeLoan = trim($_POST['tentypeloan']);
		$aTypeLoan = new TypeLoan();
		$typeLoanDao = new TypeLoanDAO();
		$aTypeLoan -> setLoanID($idTypeLoan);
		$aTypeLoan -> setLoanName($nameTypeLoan);
		$aTypeLoan -> setDateUpdate(time());
		
		$url .= "&id=".$idTypeLoan;
		if($typeLoanDao -> updateTypeLoan($aTypeLoan)) {
			$url .= "&mess=success";
		} else {
			$url .= "&mess=fail";
		}
	}
}
redirect($url);

?>