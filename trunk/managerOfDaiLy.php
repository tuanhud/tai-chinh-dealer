<?php
session_start();

include_once($_SERVER['DOCUMENT_ROOT'].'/src/db/connectdatabase.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/src/model/ChangeURL.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/src/common/CommonFuns.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/src/entitys/FileProfile.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/src/entitys/TypeLoan.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/src/entitys/Status.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/src/entitys/Dealer.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/src/entitys/Bank.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/src/entitys/ProfileCustomer.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/src/DAO/TypeLoanDAO.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/src/DAO/StatusDAO.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/src/DAO/DealerDAO.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/src/DAO/BankDAO.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/src/DAO/ProfileCustomerDAO.php');


ob_start("ob_gzhandler");
date_default_timezone_set("Asia/Saigon");

if (!isset($_SESSION['taichinhondealer'])) {
	header('Location: /');
	return;
}
$email = $_SESSION['taichinhondealer'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>HỆ THỐNG QUẢN LÝ KHÁCH HÀNG DÀNH CHO CỘNG TÁC VIÊN - Cho vay, Vay vốn, Vay tiền, Vay tín chấp, Vay tiêu dùng, Vay ngân hàng, Vay thế chấp</title>

<link rel="stylesheet" type="text/css" href="/css/styledef.css"/>
<link rel="stylesheet" type="text/css" href="/css/messi.css"/>
<link rel="stylesheet" type="text/css" href="/css/managerOfDaiLy.css"/>
<link rel="stylesheet" type="text/css" href="/css/jquery-ui.css"/>
<script type="text/javascript" src="/js/jquery-1.11.1.js"></script>
<script type="text/javascript" src="/js/messi.js"></script>
<script type="text/javascript" src="/js/jquery-ui.js"></script>
<script type="text/javascript" src="/js/datepicker-vi.js"></script>
</head>

<body>
<div class="intrl_txt">
	<div class="baner-logo">
    	<div class="logo-class"><img src="/images/logo.png" /></div>
        <div class="content-logo"><h1>HỆ THỐNG QUẢN LÝ KHÁCH HÀNG <br />DÀNH CHO CỘNG TÁC VIÊN</h1></div>
    </div>
    <div style="clear:both;"></div>
	<div class="menu-album">
        <div class="menualbumleft">
            <ul>
	            <li class="first canhanpage">THÔNG TIN CÁ NHÂN</li>
                <li class="thongbaopage-click">THÔNG BÁO</li>
    	        <li class="last hosocuabanpage">TẤT CẢ HỒ SƠ ĐÃ LOGIN</li>
            </ul>
        </div>
   	</div>
    <div style="clear:both; height: 10px;"></div>
    
    <?
	$contentPage = "dealer/ListProfileCustomer.php";
	if (isset($_GET['p'])) {
		if ($_GET['p'] == "new-profile") {
			$contentPage = "dealer/NewProfileCustomer.php";
		} else if ($_GET['p'] == "profile-detail") {
			$contentPage = "dealer/DetailProfileCustomer.php";
		} else if ($_GET['p'] == "profile-update") {
			$contentPage = "dealer/UpdateProfileCustomer.php";
		}
	}
	include($contentPage);
	?>
    
</div>

<div style="clear: both; height: 50px;"></div>
<script>
$(document).ready(function(e) {
    $(document).on("click", ".hosocuabanpage", function() {
		window.location = "/quanly/profile.html";
	});
	
	<?php
	if (isset($_GET['mess'])) {
		if ($_GET['mess'] == "success") {
	?>
		alert("Cập nhật thông tin thành công");
	<?php
		} else {
		?>
		alert("Cập nhật thông tin thất bại");
		<?php	
		}
	}
	?>
});
</script>
</body>
</html>