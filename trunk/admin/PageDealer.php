<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/src/db/connectdatabase.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/src/entitys/Dealer.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/src/entitys/Bank.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/src/DAO/DealerDAO.php');

$dealerDao = new DealerDAO();

if (!$aAdminUser->isRoot() && !$authorUser->isEditProfile() && !$authorUser->isDeleteProfile()){
	echo ("Bạn không có quyền sử dụng danh mục này");
} else {
?>
<!-- menu trong cap thu muc -->
<div class="nav2">
    <ul>
        <li class="first"><a href="/admin/?content=daily" class="dealers">Danh Sách Đại Lý</a></li>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <li><a href="/admin/?content=daily&p=ho-so-khach-hang" class="ho-so-khach-hang">Hồ Sơ Khách Hàng</a></li>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <li><a href="/admin/?content=daily&p=thong-bao" class="thong-bao">Thông Báo</a></li>
        <li><a href="/admin/?content=daily&p=add-thong-bao" class="add-thong-bao">Thêm Thông Báo</a></li>
    </ul>
    <br class="clear">
</div>

<!-- end menu trong cap thu muc -->

<div class="clear"></div>
<!-- start noi dung can quan ly -->
<div class="content-manager" style="overflow: hidden;">
    <?php
	$urlContentP = "";
	$content = "";

	if(isset($_GET['p'])) {
		$content = $_GET['p'];
		if($content == 'chi-tiet-dai-ly') {
			$urlContentP = 'dealer/DetailDealer.php';
		} else if ($content == 'ho-so-khach-hang') {
			$urlContentP = 'dealer/ProfileCustomerView.php';
		} else if ($_GET['p'] == "type-loans") {
			$urlContentP = 'dealer/TypeLoanList.php';
		} else if ($_GET['p'] == "add-type-loan") {
			$urlContentP = 'dealer/AddTypeLoan.php';
		} else if ($_GET['p'] == "edit-type-loan") {
			$urlContentP = 'dealer/EditTypeLoan.php';
		} else if ($_GET['p'] == "status") {
			$urlContentP = 'dealer/StatusList.php';
		} else if ($_GET['p'] == "add-status") {
			$urlContentP = 'dealer/AddStatus.php';
		} else if ($_GET['p'] == "edit-status") {
			$urlContentP = 'dealer/EditStatus.php';
		} else {
			$urlContentP = 'dealer/DealerListView.php';
		}
	} else {
		$urlContentP = 'dealer/DealerListView.php';
		?>
		<script>
            $('.dealers').css({'color': "#df4b49"});
        </script>
        <?php
	}
	if($urlContentP != "") {
		include_once($urlContentP);	
	}
	?>
	<script>
        $('.<?php if($content != "") {echo($content); } else {echo('dealers');}?>').css({'color': "#df4b49"});
    </script>
</div>
<!-- end noi dung can quan ly -->
<?php
}
?>