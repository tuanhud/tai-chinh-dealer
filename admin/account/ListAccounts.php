<?php
$managerUserDAO = new ManagerUserDAO();

$page = 1;
if(isset($_GET['page'])) {
	$page = $_GET['page'];
}

$arrcountrows = $managerUserDAO -> countInfoAdminPageManage($aAdminUser->isRoot(), $aAdminUser->getUserID());
$sumrecord = $arrcountrows[0][0];
$numrecord = 20;
$pageNumber = intval(($sumrecord / $numrecord));
if(($sumrecord % $numrecord) != 0) {
	$pageNumber++;
}

if($pageNumber == 0) {
	$pageNumber = 1;	
}

if($page > $pageNumber) {
	$page = $pageNumber;
}

$ListView = $managerUserDAO -> getInfoAdminPageManage($aAdminUser->isRoot(), $aAdminUser->getUserID(), ($page-1)*$numrecord, $numrecord);
?>
<div class="album_content">
	<div class="content_search">
	
	</div>

	<form action="/admin/control/AdminUpdateAccount.php" method="post" id="form_manager_action">
        <div class="the-buttom-edit-manager">
            <input type="hidden" name="act" id="id_action" value=""/><img src="../images/lockicon.png" width="25px" class="class-image-clock-buttom" />&nbsp;&nbsp;<img src="../images/unclockicon.png" width="25px" class="class-image-unclock-buttom" />
        </div>
        <div style="clear:both; height:15px;"></div>
        <div class="class-pagination">
            <span class="class-pageLabel">Page</span>
            <?php if($page == 1) { ?>
            <span title="Page 1" page="1" class="class-pageNow">1</span>
            <?php } else { ?>
            <span title="Page 1" page="1" class="class-pageElem">1</span>
            <?php }?>
            <?php if ($pageNumber != 1) { for($i = 2; $i <= $pageNumber; $i++) { ?>
            <?php if($i == $page) { ?>
            <span title="Trang <?php echo($i) ?>" page="<?php echo($i) ?>" class="class-pageNow"><?php echo($i) ?></span>
            <?php } else { ?>
            <span title="Page <?php echo($i) ?>" page="<?php echo($i) ?>" class="class-pageElem"><?php echo($i) ?></span>
            <?php }?>
            <?php }}?>
        </div>
        <div style="clear:both; height:10px;"></div>
        <div style="min-width: 100%; overflow-x: scroll;" class="listviewcontent">
            <table class="table-view-manager" cellspacing="1" cellpadding="0" border="0" style="width: 1760px;">
                <tr class="title_tr">
                    <th class="title" width="25px"></th>
                    <th class="title" width="35px">STT</th>
                    <?php 
                    if ($authorUser->isEditUser()) { 
                    ?>
                    <th class="title" width="50px">Detail</th>
                    <?php 
                    }
                    if ($authorUser->isDeleteUser()) { 
                    ?>
                    <th class="title" width="50px">Lock User</th>
                    <?php 
                    }
                    ?>
                    <th class="title" width="250px">Username Quản Lý</th>
                    <th class="title" width="250px">Họ Tên</th>
                    <th class="title" width="100px">Allow Add User</th>
                    <th class="title" width="100px">Allow Edit User</th>
                    <th class="title" width="100px">Allow Delete User</th>
                    <th class="title" width="100px">Allow Edit Profile</th>
                    <th class="title" width="100px">Allow Delete Profile</th>
                    <th class="title" width="200px">User Create</th>
                    <th class="title" width="100px">Date Create</th>
                    <th class="title" width="100px">Date Lock</th>
                </tr>
                <?php
                $i = ($page-1)*$numrecord + 1;
                foreach($ListView as $aUser) {
                ?>
                <tr>
                    <td align="center"><input type="checkbox" name="idcheckmanager[]" class="idcheckmanager" value="<?php echo($aUser->getUserID()) ?>" /></td>
                    <td align="center"><?php echo($i) ?></td>
                    <?php 
                    if ($authorUser->isEditUser()) { 
                    ?>
                    <td align="center"><a href="/admin/?content=user&p=detail-account&acc=<?php echo($aUser->getUserID()) ?>"><img src="/images/icon-detail.gif" width="20px" style="cursor: pointer;" idpr="<?php echo($aUser->getUserID()) ?>" class="class-detail-link" title="Detail Account" /></a></td>
                    <?php 
                    }
                    if ($authorUser->isDeleteUser()) { 
                    ?>
                    <td align="center"><?php if(!$aUser->isLock()) { ?><img src="/images/unclockicon.png" width="20px" title="" style="cursor: pointer;" class="class-display-link" idpr="<?php echo($aUser->getUserID()) ?>" /><?php } else { ?><img class="class-hiden-link" idpr="<?php echo($aUser->getUserID()) ?>" src="../images/lockicon.png" width="20px" style="cursor: pointer;" title="Unclock account" /><?php } ?></td>
                    <?php 
                    }
                    ?>
                    <td align="center"><?php echo($aUser->getUserID()) ?></td>
                    <td align="center"><?php echo($aUser->getFullname()) ?></td>
                    <td align="center"><?php if($aUser->getAuthorization()->isInsertUser()) { ?> <img src="/images/activity.jpg" width="20px" style="cursor: pointer;" /> <?php }?></td>
                    <td align="center"><?php if($aUser->getAuthorization()->isEditUser()) { ?> <img src="/images/activity.jpg" width="20px" style="cursor: pointer;" /> <?php }?></td>
                    <td align="center"><?php if($aUser->getAuthorization()->isDeleteUser()) { ?> <img src="/images/activity.jpg" width="20px" style="cursor: pointer;" /> <?php }?></td>
                    <td align="center"><?php if($aUser->getAuthorization()->isEditProfile()) { ?> <img src="/images/activity.jpg" width="20px" style="cursor: pointer;" /> <?php }?></td>
                    <td align="center"><?php if($aUser->getAuthorization()->isDeleteProfile()) { ?> <img src="/images/activity.jpg" width="20px" style="cursor: pointer;" /> <?php }?></td>
                    <td align="center"><?php echo($aUser->getUserCreate()) ?></td>
                    <td align="center"><?php echo(CommonFuns::int_to_date($aUser->getDateCreate())) ?></td>
                    <td align="center"><?php if($aUser->isLock()) { echo(CommonFuns::int_to_date($aUser->getDateLock())); } ?></td>
                </tr>
                <?php
                $i++;
                }
                ?>
            </table>
        </div>
        <div style="clear:both; height:15px;"></div>
        <div class="class-pagination">
            <span class="class-pageLabel">Page</span>
            <?php if($page == 1) { ?>
            <span title="Page 1" page="1" class="class-pageNow">1</span>
            <?php } else { ?>
            <span title="Page 1" page="1" class="class-pageElem">1</span>
            <?php }?>
            <?php if ($pageNumber != 1) { for($i = 2; $i <= $pageNumber; $i++) { ?>
            <?php if($i == $page) { ?>
            <span title="Page <?php echo($i) ?>" page="<?php echo($i) ?>" class="class-pageNow"><?php echo($i) ?></span>
            <?php } else { ?>
            <span title="Page <?php echo($i) ?>" page="<?php echo($i) ?>" class="class-pageElem"><?php echo($i) ?></span>
            <?php }?>
            <?php }}?>
        </div>
        <div style="clear:both; height:10px;"></div>
    </form>
</div>

<script>
	$(document).on('click', '.class-image-clock-buttom', function() {
		if($('.idcheckmanager:checked').length != 0) submitformmanager('lock');
		else alert('Vui lòng chọn thông tin cần cập nhật');
	});

	$(document).on('click', '.class-image-unclock-buttom', function() {
		if($('.idcheckmanager:checked').length != 0) submitformmanager('unlock');
		else alert('Vui lòng chọn thông tin cần cập nhật');
	});

	function submitformmanager(value) {
		$('#id_action').val(value);
		$('#form_manager_action').submit();
	}

	$(document).on('click', '.class-pageElem', function() {
		page = $(this).attr('page');
		openwindowns('/admin/?content=user&page=' + page);
	});

	function openwindowns(url) {
		window.location = url;
	}

	$(document).on('click', '.class-display-link', function() {
		elem = $(this);
		id = elem.attr('idpr');
		showWaiting();
		$.ajax({
			type: "POST",
			url: "/admin/control/ajax/AjaxUpdateAccount.php",
			data:{'action': 'lock', idpe: id},
			success: function(response) {
				if(response == 'success') {
					elem.parent().html('<img class="class-hiden-link" idpr="' + id + '" src="../images/lockicon.png" width="20px" style="cursor: pointer;" title="" />').hide().fadeIn(700);
				} else {
					alert("Update fail");
				}
				hideWaiting();
			}
		});
	});

	/*$(document).on('click', '.class-hiden-link', function() {
		elem = $(this);
		id = elem.attr('idpr');
		showWaiting();
		$.ajax({
			type: "POST",
			url: "control/ajax/AjaxAdminMenuProduct.php",
			data:{act: 'edita',type: "1", idpe: id},
			dataType: "json",
			success: function(response){
				if(response == true) {
					elem.parent().html('<img src="../images/unclockicon.png" width="20px" title="" style="cursor: pointer;" class="class-display-link" idpr="' + id + '" />').hide().fadeIn(700);
				} else {
					alert("Update fail");
				}
				hideWaiting();
			}
		});
	});*/
	
	$(document).on('click', '.class-hiden-link', function() {
		elem = $(this);
		id = elem.attr('idpr');
		showWaiting();
		$.ajax({
			type: "POST",
			url: "/admin/control/ajax/AjaxUpdateAccount.php",
			data:{'action': 'unlock', idpe: id},
			success: function(response){
				if(response == 'success') {
					elem.parent().html('<img src="../images/unclockicon.png" width="20px" title="" style="cursor: pointer;" class="class-display-link" idpr="' + id + '" />').hide().fadeIn(700);
				} else {
					alert("Update fail");
				}
				hideWaiting();
			}
		});
	});

	function showWaiting() {
		$(".reveal-modal-bg").show();
	}

	function hideWaiting() {
		$(".reveal-modal-bg").hide();
	}

</script>