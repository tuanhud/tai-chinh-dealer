<?php
$authorizationDAO = new AuthorizationDAO();
if (isset($authorUser))
	$authorUser = $authorizationDAO->getInfoAuthorizationUser($aAdminUser->getUserID());

if (!$authorUser->isInsertUser() && !$authorUser->isDeleteUser() && !$authorUser->isEditUser()){
	echo ("Bạn không có quyền sử dụng danh mục này");
} else {
?>
<!-- menu trong cap thu muc -->
<div class="nav2">
    <ul>
        <li class="first"><a href="/admin/?content=user" class="accounts">Danh Sách User</a></li>
        <?php 
        if ($authorUser->isInsertUser()) {
        ?>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <li><a href="/admin/?content=user&p=add-user" class="add-menu-product">Thêm User</a></li>
        <?php 
        }
        ?>
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
		if($content == 'add-user') {
			$urlContentP = 'account/AddAccount.php';
		} else if ($content == 'detail-account') {
			$urlContentP = 'account/DetailAccount.php';
		} else {
			$urlContentP = 'account/ListAccounts.php';
		}
	} else {
		$urlContentP = 'account/ListAccounts.php';
		?>
		<script>
            $('.accounts').css({'color': "#df4b49"});
        </script>
        <?php
	}
	if($urlContentP != "") {
		include_once($urlContentP);	
	}
	?>
	<script>
        $('.<?php if($content != "") {echo($content); } else {echo('accounts');}?>').css({'color': "#df4b49"});
    </script>
</div>
<!-- end noi dung can quan ly -->
<?php
}
?>