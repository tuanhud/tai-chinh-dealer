<?php
session_start();
include_once($_SERVER['DOCUMENT_ROOT'].'/src/DAO/ProfileCustomerDAO.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/src/common/CommonFuns.php');

$profileCustomerDAO = new ProfileCustomerDAO();

if(isset($_SESSION['taichinhondealer'])) {
	$email = $_SESSION['taichinhondealer'];
	if(isset($_POST['datestart']) && isset($_POST['dateend'])) {
		$datestart = trim($_POST['datestart']);
		$dateend = trim($_POST['dateend']);
		
		$arrsalary = $profileCustomerDAO->calculatorSalaryDealer($email, $datestart, $dateend);
		$sumsalary = 0;
		foreach($arrsalary as $value) {
			$sumsalary += $value[0];
		}
		
		echo json_encode("Tổng thu nhập từ ngày ".$datestart." - ".$dateend."<br />".CommonFuns::changnumbermoney($sumsalary)." VNĐ");
		return;
	}
}
echo json_encode("true");

?>