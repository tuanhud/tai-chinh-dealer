<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/src/DAO/ManagerUserDAO.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/src/DAO/AuthorizationDAO.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/src/entitys/ManagerUser.php');

if (isset($_GET["acc"])) {
	$userID = $_GET["acc"];
	$managerUserDAO = new ManagerUserDAO();
	
	$aUser = $managerUserDAO -> getInfoUserManageByUserID($userID);
	
	if ($aUser -> getUserID() != "") {
?>
<script type="text/javascript" src="<?php echo($host) ?>js/detailAccountManager.js"></script>
<div class="album_content" style="min-height:700px;">
	<div class="info-account">
    	<div style="width: 100%; height: 30px; line-height: 30px; text-align: center; color: #0C9; font-weight: bold; margin-bottom: 10px;">
        	<h1>Thông Tin Chi Tiết Account</h1>
        </div>
        <div>
        	<form id="form_acction_update_account_info" action="#" method="post">
            	<input type="hidden" name="action" value="updateAccount" />	
                <table style="min-width: 1124px; max-width: 1124px;">
                    <tr>
                        <?php 
                        if ($authorUser->isEditUser()) { 
                        ?>
                        <th class="title" width="150px">Lock User</th>
                        <?php 
                        }
                        ?>
                        <th class="title" width="300px">Username Quản Lý</th>
                        <th class="title">Họ Tên</th>
                        <th class="title" width="200px">User Create</th>
                        <th class="title" width="100px">Date Create</th>
                    </tr>
                    <tr>
                        <?php 
                        if ($authorUser->isEditUser()) { 
                        ?>
                        <td align="center"><?php if(!$aUser->isLock()) { ?><img src="/images/unclockicon.png" width="20px" title="" style="cursor: pointer;" class="class-display-link" idpr="<?php echo($aUser->getUserID()) ?>" /><?php } else { ?><img class="class-hiden-link" idpr="<?php echo($aUser->getUserID()) ?>" src="../images/lockicon.png" width="20px" style="cursor: pointer;" title="Unclock account" /><?php } ?></td>
                        <?php 
                        }
                        ?>
                        <td align="center"><?php echo($aUser->getUserID()) ?><input type="hidden" value="<?php echo($aUser->getUserID()) ?>" name="user_account" /></td>
                        <td align="center"><input type="text" maxlength="255" name="name_account" value="<?php echo($aUser->getFullname()) ?>" style="width: 300px;" /></td>
                        <td align="center"><?php echo($aUser->getUserCreate()) ?></td>
                        <td align="center"><?php echo(CommonFuns::int_to_date($aUser->getDateCreate())) ?></td>
                    </tr>
                </table>
                <table style="min-width: 1124px; max-width: 1124px;">
                    <tr>
                        <th class="title" width="362px">Allow Add User</th>
                        <th class="title" width="362px">Allow Edit User</th>
                        <th class="title" width="362px">Allow Lock User</th>
                        <th class="title" width="362px">Allow Edit Profile</th>
                        <th class="title" width="362px">Allow Delete Profile</th>
                        <th class="title" width="362px">Date Lock</th>
                    </tr>
                    <tr>
                        <td align="center"><input type="checkbox" name="chkAllowAddUser" <?php if($aUser->getAuthorization()->isInsertUser()) { ?> checked="checked" <?php /*?><img src="/images/activity.jpg" width="20px" style="cursor: pointer;" /><?php */?> <?php }?> value="1" /></td>
                        <td align="center"><input type="checkbox" name="chkAllowEditUser" <?php if($aUser->getAuthorization()->isEditUser()) { ?> checked="checked" <?php /*?><img src="/images/activity.jpg" width="20px" style="cursor: pointer;" /><?php */?> <?php }?> value="1" /></td>
                        <td align="center"><input type="checkbox" name="chkAllowDelUser" <?php if($aUser->getAuthorization()->isDeleteUser()) { ?> checked="checked" <?php /*?><img src="/images/activity.jpg" width="20px" style="cursor: pointer;" /><?php */?> <?php }?> value="1" /></td>
                        <td align="center"><input type="checkbox" name="chkAllowEditProfile" <?php if($aUser->getAuthorization()->isEditProfile()) { ?> checked="checked" <?php /*?><img src="/images/activity.jpg" width="20px" style="cursor: pointer;" /><?php */?> <?php }?> value="1" /></td>
                        <td align="center"><input type="checkbox" name="chkAllowDelProfile" <?php if($aUser->getAuthorization()->isDeleteProfile()) { ?> checked="checked" <?php /*?><img src="/images/activity.jpg" width="20px" style="cursor: pointer;" /><?php */?> <?php }?> value="1" /></td>
                        <td align="center"><?php if($aUser->isLock()) { echo(CommonFuns::int_to_date($aUser->getDateLock())); } ?></td>
                    </tr>
                    <?php 
                    if ($authorUser->isEditUser()) { 
                    ?>
                    <tr>
                        <td colspan="3" align="right"><input type="button" class="btnclra class_resetPassword" value="Reset Password" style="width: 130px;"></td>
                        <td colspan="3" align="left"><input type="button" class="btnclra class_edit_account" value="Chỉnh sửa" style="width: 90px;"></td>
                    </tr>
                    <?php 
                    }
                    ?>
                </table>
            </form>
        </div>
        <div style="clear: both; border-top: 1px solid #666; margin-top: 10px;"></div>
        <div style="width: 100%; height: 30px; line-height: 30px; text-align: center; font-weight: bold; margin-bottom: 10px; margin-top: 20px;">
        	<h2>Danh Sách Đại Lý Được Cấp Phép Quản Lý</h2>
            
            <?php
			$ListViewDealer = $managerUserDAO -> getDealerByUserID($userID);
			?>
            <div style="min-width: 100%;  min-height: 400px; overflow-y: scroll; border: 1px solid #CCC;" class="listviewcontent">
                <table class="table-view-manager" cellspacing="1" cellpadding="0" border="0" style="width: 1105px;">
                    <tr class="title_tr">
                        <th class="title" width="35px">STT</th>
                        <?php 
                        if ($authorUser->isEditUser()) { 
                        ?>
                        <th class="title" width="80px">Remove</th>
                        <th class="title" width="150px">Change Manager</th>
                        <?php 
                        }
                        ?>
                        <th class="title" width="100px">Mã KH</th>
                        <th class="title" width="250px">Email Đại Lý</th>
                        <th class="title" width="250px">Họ Tên Đại Lý</th>
                        <th class="title" width="40px">GT</th>
                        <th class="title" width="100px">Điện Thoại</th>
                        <th class="title" width="100px">Tỉnh Thành</th>
                    </tr>
                    <?php
                    $i = 1;
                    foreach($ListViewDealer as $aDealer) {
                    ?>
                    <tr>
                        <td align="center"><?php echo($i) ?></td>
                        <?php 
                        if ($authorUser->isEditUser()) { 
                        ?>
                        <td align="center"><img src="/images/icon-delete.gif" width="20px" style="cursor: pointer;" idpr="<?php echo($aDealer->getEmailDealer()) ?>" class="class-deletedealer-link" title="Delete" /></td>
                        <td align="center"><img src="/images/icon-edit.gif" width="20px" style="cursor: pointer;" idpr="<?php echo($aDealer->getEmailDealer()) ?>" class="class-changeaccount-link" title="Thay đổi người quản lý đại lý" /></td>
                        <?php 
                        }
                        ?>
                        <td align="center"><?php echo($aDealer->getIDCODE()) ?></td>
                        <td align="center"><?php echo($aDealer->getEmailDealer()) ?></td>
                        <td align="center"><?php echo($aDealer->getFullname()) ?></td>
                        <td align="center"><?php if($aDealer->getGender()) echo ("Nam"); else echo("Nữ"); ?></td>
                        <td align="center"><?php echo($aDealer->getMobile()) ?></td>
                        <td align="center"><?php echo($aDealer->getProvince()) ?></td>
                    </tr>
                    <?php
                    $i++;
                    }
                    ?>
                </table>
            </div>
            
            <div>
            	<?php 
				if ($authorUser->isEditUser()) { 
				?>
            	<input type="button" class="btnclra add_dealer_for_account" value="Thêm Đại Lý" account="<?php echo($userID); ?>" style="width: 120px;" />
                <?php 
				}
				?>
            </div>
            
        </div>
	</div>
	
</div>
<div class="full_box">
	<div class="box_add_dealer">
    	<div class="box_close close_add_dealer" title="Close"></div>
    	<div style="text-align: center; width: 100%; height: 40px;" class="box_header"><h1>Danh Sách Đại Lý</h1></div>
        <div class="content_box listviewcontent">
        	<form id="action_add_new_dealer" method="post" action="">
            	<input type="hidden" name="action_dealer" value="add" />
            	<input type="hidden" name="user" value="<?php echo($userID); ?>" />
                <table style="width: 100%;">
                    <tr>
                        <th class="title" width="40px"></th>
                        <th class="title" width="80px">Mã KH</th>
                        <th class="title" width="250px">Email Đại Lý</th>
                        <th class="title">Họ Tên Đại Lý</th>
                        <th class="title" width="50px">GT</th>
                        <th class="title" width="150px">Điện Thoại</th>
                        <th class="title" width="150px">Tỉnh Thành</th>
                    </tr>
                    
                </table>
            </form>
        </div>
        <div align="center">
        	<input type="button" class="btnclra add_dealer_submit" value="Thêm Đại Lý" account="<?php echo($userID); ?>" title="Thêm đại lý cần quản lý cho user <?php echo($userID); ?>" style="width: 120px;" /> &nbsp;&nbsp;&nbsp;&nbsp;
            <input type="button" class="btnclra box_close_btn close_add_dealer" value="Hủy Bỏ" title="Close" style="width: 120px;" />
        </div>
    </div>
</div>

<div class="full_box1">
	<div class="box_add_dealer1">
    	<div class="box_close close_change_account" title="Close"></div>
    	<div style="text-align: center; width: 100%; height: 40px;" class="box_header"><h1>Danh Sách Tài Khoản Quản Lý</h1></div>
        <div class="content_box1 listviewcontent">
        	<form id="action_change_dealer" method="post" action="">
            	<input type="hidden" name="action_dealer" value="change" />
            	<input type="hidden" name="userCurrent" id="userCurrent" value="<?php echo($userID); ?>" />
            	<input type="hidden" name="userDealer" id="userDealer" value="" />
                <table style="width: 100%;">
                    <tr>
                        <th class="title" width="40px"></th>
                        <th class="title" width="80px">ID Acount</th>
                        <th class="title">Tên Account</th>
                    </tr>
                </table>
            </form>
        </div>
        <div align="center">
        	<input type="button" class="btnclra change_account_submit" value="Thay Đổi" account="<?php echo($userID); ?>" title="Thay đổi người quản lý" style="width: 120px;" /> &nbsp;&nbsp;&nbsp;&nbsp;
            <input type="button" class="btnclra box_close_btn close_change_account" value="Hủy Bỏ" title="Close" style="width: 120px;" />
        </div>
    </div>
</div>

<div class="full_box2">
	<div class="box_add_dealer2">
    	<div class="box_close close_resetPassword" title="Close"></div>
    	<div style="text-align: center; width: 100%; height: 40px;" class="box_header"><h1>Reset Password Cho Account</h1></div>
        <div class="content_box2 listviewcontent">
        	<form id="action_change_password_account" method="post" action="">
            	<input type="hidden" name="action" value="change_password" />
            	<input type="hidden" name="userCurrent" id="userCurrent" value="<?php echo($userID); ?>" />
                <table style="width: 100%;">
                    <tr>
                        <td>Password reset</td>
                        <td><input type="text" name="txt_password" maxlength="50" /></td>
                    </tr>
                </table>
            </form>
        </div>
        <div align="center">
        	<input type="button" class="btnclra changepassword_account_submit" value="Thay Đổi" account="<?php echo($userID); ?>" title="Thay đổi người quản lý" style="width: 120px;" /> &nbsp;&nbsp;&nbsp;&nbsp;
            <input type="button" class="btnclra box_close_btn close_resetPassword" value="Hủy Bỏ" title="Close" style="width: 120px;" />
        </div>
    </div>
</div>

<?php
	} else {
		echo("<strong>Không tìm thấy thông tin bạn cần tại đây.</strong>");
	}
} else {
	echo("<strong>Không tìm thấy thông tin bạn cần tại đây.</strong>");
}
?>