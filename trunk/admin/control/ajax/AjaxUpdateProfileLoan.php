<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/src/db/connectdatabase.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/src/entitys/ProfileCustomer.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/src/entitys/ProfileCustomer.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/src/entitys/ManagerUser.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/src/entitys/Status.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/src/DAO/ProfileCustomerDAO.php');
session_start();

$profileCustomerDAO = new ProfileCustomerDAO();
if(isset($_SESSION['adminlogintcdealeronline']) && isset($_POST['act'])) {
	
	
	$action = $_POST['act'];
	
	if($action == 'edit') {
		$result = false;
		if(isset($_POST['rei']) && isset($_POST['datecreate']) && isset($_POST['name']) && isset($_POST['phone']) && isset($_POST['stre']) && isset($_POST['cont']) && isset($_POST['quantityLoan']) && isset($_POST['bankLoan']) && isset($_POST['hoaHong'])) {
			$id = trim($_POST['rei']);
			$dateCreateKey = trim($_POST['datecreate']);
			$name = trim($_POST['name']);
			$phone = trim($_POST['phone']);
			$status = trim($_POST['stre']);
			$inforequest = trim($_POST['cont']);
			$quantityLoan = trim($_POST['quantityLoan']);
			$bankLoan = trim($_POST['bankLoan']);
			$hoaHong = trim($_POST['hoaHong']);
			
			$profileCustomer = new ProfileCustomer();
			$profileCustomer -> setIDProfile($id);
			$profileCustomer -> setDateCreate($dateCreateKey);
			$profileCustomer -> setNameCustomer($name);
			$profileCustomer -> setPhoneNumber($phone);
			
			$aStatus = new Status();
			$aStatus -> setStatusID($status);
			$profileCustomer -> setStatus($aStatus);
			
			$profileCustomer -> setInfoRequest($inforequest);
			$profileCustomer -> setAmountLoan($quantityLoan);
			$profileCustomer -> setBankLoan($bankLoan);
			$profileCustomer -> setHoaHong($hoaHong);
			$profileCustomer -> setDateUpdate(time());
			
			$result = $profileCustomerDAO->updateProfileDealerAdmin($profileCustomer);
		}
		echo json_encode($result);
	} else if($action == 'del') {
		if(isset($_POST['idpe'])) {
			
			$aAdminUser = unserialize($_SESSION['adminlogintcdealeronline']);
			$profileCustomer = new ProfileCustomer();
			$profileCustomer -> setIDProfile(trim($_POST['idpe']));
			$profileCustomer -> setIsDelete(true);
			$profileCustomer -> setUserDelete($aAdminUser->getUserID());
			$profileCustomer -> setDateDelete(time());
			
			echo json_encode($profileCustomerDAO->deleteProfileDealer($profileCustomer));
		}
	}
} else {
	echo json_encode(false);
}
?>