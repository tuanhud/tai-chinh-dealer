<?php
if (!$aAdminUser->isRoot()){
	echo ("Bạn không có quyền sử dụng danh mục này");
} else {
?>
<!-- menu trong cap thu muc -->
<div class="nav2">
    <ul>
        <li class="first"><a href="/admin/?content=quanli" class="quanlis">Danh Sách Ngân Hàng</a></li>
        <li><a href="/admin/?content=quanli&p=add-bank" class="add-bank">Thêm Ngân Hàng</a></li>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <li><a href="/admin/?content=quanli&p=type-loans" class="type-loans">Loại Hình Vay</a></li>
        <li><a href="/admin/?content=quanli&p=add-type-loan" class="add-type-loan">Thêm Loại Hình Vay</a></li>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <li><a href="/admin/?content=quanli&p=status" class="status">Status Hồ Sơ</a></li>
        <li><a href="/admin/?content=quanli&p=add-status" class="add-status">Thêm Status</a></li>
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
		if($content == 'add-bank') {
			$urlContentP = 'system/bank/AddBank.php';
		} else if ($content == 'edit-bank') {
			$urlContentP = 'system/bank/EditBank.php';
		} else if ($_GET['p'] == "type-loans") {
			$urlContentP = 'system/TypeLoan/TypeLoanList.php';
		} else if ($_GET['p'] == "add-type-loan") {
			$urlContentP = 'system/TypeLoan/AddTypeLoan.php';
		} else if ($_GET['p'] == "edit-type-loan") {
			$urlContentP = 'system/TypeLoan/EditTypeLoan.php';
		} else if ($_GET['p'] == "status") {
			$urlContentP = 'system/status/StatusList.php';
		} else if ($_GET['p'] == "add-status") {
			$urlContentP = 'system/status/AddStatus.php';
		} else if ($_GET['p'] == "edit-status") {
			$urlContentP = 'system/status/EditStatus.php';
		} else {
			$urlContentP = 'system/bank/BankList.php';
		}
	} else {
		$urlContentP = 'system/bank/BankList.php';
		?>
		<script>
            $('.quanlis').css({'color': "#df4b49"});
        </script>
        <?php
	}
	if($urlContentP != "") {
		include_once($urlContentP);	
	}
	?>
	<script>
        $('.<?php if($content != "") {echo($content); } else {echo('quanlis');}?>').css({'color': "#df4b49"});
    </script>
</div>
<!-- end noi dung can quan ly -->
<?php
}
?>