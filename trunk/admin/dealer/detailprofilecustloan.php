<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/src/entitys/ProfileCustomer.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/src/entitys/FileProfile.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/src/entitys/Status.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/src/DAO/ProfileCustomerDAO.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/src/DAO/FileProfileDAO.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/src/DAO/StatusDAO.php');

$profileCustomerDAO = new ProfileCustomerDAO();
$fileProfileDAO = new FileProfileDAO();
$statusDAO = new StatusDAO();

if(isset($_GET['rei'])) {
	$idpro = $_GET['rei'];
	$arrprodetail = $profileCustomerDAO -> getProfileDetailByIDPro('', $idpro);
	if(count($arrprodetail) > 0) {
		$fileProfiles = $fileProfileDAO -> getFileProfile($idpro);
		$statusList = $statusDAO->getStatuss(0);
?>
<style>
#showlistbankdeletedlightbox {
	display: none;
	top: 0px; 
	left: 50%;
	margin-left: -300px;
	width: 600px;
	background: #eee url(../modal-gloss.png) no-repeat -200px -80px;
	position: absolute;
	z-index: 101;
	padding: 0px 0px 0px;
	-moz-border-radius: 5px;
	-webkit-border-radius: 5px;
	border-radius: 5px;
	-moz-box-shadow: 0 0 10px rgba(0,0,0,.4);
	-webkit-box-shadow: 0 0 10px rgba(0,0,0,.4);
	-box-shadow: 0 0 10px rgba(0,0,0,.4);
}

#showlistbankdeletedlightbox .close-reveal-modal {
	font-size: 22px;
	line-height: .5;
	position: absolute;
	top: 8px;
	right: 11px;
	color: #aaa;
	text-shadow: 0 -1px 1px rbga(0,0,0,.6);
	font-weight: bold;
	cursor: pointer;
} 
.reveal-modal-title {
    background: url('../images/box-title-blue.jpg') repeat-x;
    height: 50px;
    text-align: center;
	-moz-border-radius: 5px;
	-webkit-border-radius: 5px;
}

.reveal-modal-title h1 {
    color: white;
}

.reveal-modal-main {
    padding: 20px;
	margin-top:-10px;
	min-height: 500px;
	max-height: 500px;
	overflow-y: scroll;
}
</style>
<div style="width: 100%; text-align: center; margin-bottom: 20px;"><h1>Chi Tiết Hồ Sơ Khách Hàng <?php echo($arrprodetail[0]->getNameCustomer()) ?></h1></div>
<div style="width:600px; margin: auto;">
	<table width="600px">
    	<tr>
        	<th align="left" width="150px">Tên khách hàng</th>
            <td><strong><?php echo($arrprodetail[0]->getNameCustomer()) ?></strong></td>
        </tr>
        <tr><td colspan="2"><hr style="border: 1px solid; margin-top:4px; margin-bottom: 4px;"></td></tr>
        <tr>
        	<th align="left" width="150px">Số điện thoại</th>
            <td><strong><?php echo($arrprodetail[0]->getPhoneNumber()) ?></strong></td>
        </tr>
        <tr><td colspan="2"><hr style="border: 1px solid; margin-top:4px; margin-bottom: 4px;"></td></tr>
        <tr>
        	<th align="left">Khu vực</th>
            <td><?php echo($arrprodetail[0]->getProvince()) ?></td>
        </tr>
        <tr><td colspan="2"><hr style="border: 1px solid; margin-top:4px; margin-bottom: 4px;"></td></tr>
        <tr>
        	<th align="left">Sản phẩm</th>
            <td><?php echo($arrprodetail[0]->getTypeLoan()->getLoanName()) ?></td>
        </tr>
        <tr><td colspan="2"><hr style="border: 1px solid; margin-top:4px; margin-bottom: 4px;"></td></tr>
        <tr>
        	<th align="left" valign="top">Thông tin chi tiết</th>
            <td>
				<?php echo($arrprodetail[0]->getInfoProfile()."<br/>"); ?>
                <?php
				for ($i = 1; $i < count($arrprodetail); $i++) {
					echo("**************************************<br/>");
					echo("Ngày đăng: ".CommonFuns::int_to_date2($arrprodetail[$i]->getDateCreate())." <br/>");
					echo($arrprodetail[$i]->getInfoProfile()."<br/>");
				}
				?>
            </td>
        </tr>
        <tr><td colspan="2"><hr style="border: 1px solid; margin-top:4px; margin-bottom: 4px;"></td></tr>
        <tr>
        	<th align="left" valign="top">File Đính Kèm</th>
            <td>
                <ol>
				<?php
                for ($i = 0; $i < count($fileProfiles); $i++) {
                    echo('<li>'.($i + 1).'.&nbsp;&nbsp;<a href="/'.$fileProfiles[$i] -> getLinkFile().'">Hồ sơ '.$fileProfiles[$i] -> getLinkFile().'</a></li>');
                }
                ?>
            	</ol>
            </td>
        </tr>
        <tr><td colspan="2"><hr style="border: 1px solid; margin-top:4px; margin-bottom: 4px;"></td></tr>
        <tr>
        	<th align="left">Trạng Thái</th>
            <td><?php echo($arrprodetail[0]->getStatus()->getStatusName()) ?></td>
        </tr>
        <tr><td colspan="2"><hr style="border: 1px solid; margin-top:4px; margin-bottom: 4px;"></td></tr>
        <tr>
        	<th align="left" valign="top">TT Phản Hồi</th>
            <td>
				<?php echo($arrprodetail[0]->getInfoRequest()."<br/>") ?>
                <?php
				for ($i = 1; $i < count($arrprodetail); $i++) {
					if (trim($arrprodetail[$i]->getInfoRequest()) != "") {
						echo("**************************************<br/>");
						echo("Ngày đăng: ".CommonFuns::int_to_date2($arrprodetail[$i]->getDateCreate())." <br/>");
						echo($arrprodetail[$i]->getInfoRequest()."<br/>");
					}
				}
				?>
            </td>
        </tr>
        <tr><td colspan="2"><hr style="border: 1px solid; margin-top:4px; margin-bottom: 4px;"></td></tr>
        <tr>
        	<th align="left">Số Tiền Vay</th>
            <td><?php if ($arrprodetail[0]->getAmountLoan() != "") { echo(CommonFuns::changnumbermoney($arrprodetail[0]->getAmountLoan())) ?> VNĐ <?php } ?></td>
        </tr>
        <tr><td colspan="2"><hr style="border: 1px solid; margin-top:4px; margin-bottom: 4px;"></td></tr>
        <tr>
        	<th align="left">Ngân Hàng Vay</th>
            <td><?php echo($arrprodetail[0]->getBankLoan()) ?></td>
        </tr>
        <tr><td colspan="2"><hr style="border: 1px solid; margin-top:4px; margin-bottom: 4px;"></td></tr>
        <tr>
        	<th align="left">Hoa Hồng(VNĐ)</th>
            <td><?php if ($arrprodetail[0]->getHoaHong() != "") { echo(CommonFuns::changnumbermoney($arrprodetail[0]->getHoaHong()) )?> VNĐ<?php } ?></td>
        </tr>
        <tr><td colspan="2"><hr style="border: 1px solid; margin-top:4px; margin-bottom: 4px;"></td></tr>
        <tr>
        	<th align="left">Ngày Cập Nhật</th>
            <td><?php if($arrprodetail[0]->getDateUpdate() != "") echo(CommonFuns::int_to_date2($arrprodetail[0]->getDateUpdate())) ?></td>
        </tr>
        
        <tr><td colspan="2"><hr style="border: 1px solid; margin-top:4px; margin-bottom: 4px;"></td></tr>
        <tr>
        	<th colspan="2"><input class="class-edit-detail-profile-link btnclra" type="button" value="Chỉnh Sửa" style="border-radius: 5px; padding:5px; width:100px; font-weight:bold;" /></th>
        </tr>
    </table>
</div>
<div style="clear: both; height: 20px;"></div>
<?php
if (count($arrprodetail) > 0) {
?>
<div style="margin:auto; width:980px; text-align: center;"><h2 style="color:#88A943; text-transform:uppercase; margin:auto;">Lịch Sử Giao Dịch</h2></div>
<div style="width: 980px; max-width: 980px; margin: auto;"  class="class-content-records">
	<table width="980px" cellpadding="0" cellspacing="0" style="font-size: 12px; border-collapse: collapse; margin-left:5px;">
        <tr>
            <th class="class-headertable" width="30px">STT</th>
            <th class="class-headertable" width="110px">Ngày login</th>
            <th class="class-headertable" width="140px">Tình trạng</th>
            <th class="class-headertable">Thông tin chi tiết</th>
            <th class="class-headertable" width="250px">Tài Chính Online phản hồi</th>
            <th class="class-headertable" width="110px">Ngày cập nhật</th>
        </tr>
        <?php
		$icount = 1;
		for ($icount = 1; $icount < count($arrprodetail); $icount++) {
		?>
        <tr>
        	<td align="center"><span><?php echo($icount) ?></span></td>
            <td align="center"><span><?php echo(CommonFuns::int_to_date2($arrprodetail[$icount]->getDateCreateFirst())); ?></span></td>
            <td align="center"><span><?php echo($arrprodetail[$icount]->getStatus()->getStatusName()); ?></span></td>
            <td align="left"><span><?php echo($arrprodetail[$icount]->getInfoProfile()); ?></span></td>
            <td align="left"><span><?php echo($arrprodetail[$icount]->getInfoRequest()); ?></span></td>
            <td align="center"><span><?php echo(CommonFuns::int_to_date2($arrprodetail[$icount]->getDateUpdate())); ?></span></td>
        </tr>
        <?php
		}
		?>
    </table>
</div>

<div style="clear: both; height: 20px;"></div>
<?php
}
?>
<style>

.class-headertable {
	height: 30px;
	margin: auto;
	background: rgb(136, 169, 67);
}
.class-content-records th {
	color: #FFF;
}

.class-content-records table tr {height: 30px;min-height: 30px;}
.class-content-records table tr {display: table-row;vertical-align: inherit;border-color: inherit;} 
.class-content-records table tr th, .class-content-records table tr td {border: 1px solid #98bf21;}

.class-button-update {
	border:none;
	background: #88A943;
	text-indent: 1px;
	width: 150px;
	height:30px;
	cursor: pointer;
	font-weight: bold;
	font-size: 12px;
	border-radius: 5px;
}
</style>

<div style="clear:both;"></div>
<div class="reveal-modal-bg"></div>
<div id="showlistbankdeletedlightbox">
	<div class="reveal-modal-title"><h1>Cập Nhật Thông Tin Hồ Sơ</h1></div><br />
    <div class="reveal-modal-main">
    	<table>
        	<tr>
            	<th align="left" width="120px">Tên Khách Hàng</th>
                <td><input style="height:30px; width:280px" name="From_NameCus" id="From_NameCus" value="<?php echo($arrprodetail[0]->getNameCustomer()) ?>" type="text" size="40" maxlength="500"></td>
            </tr>
            <tr>
            	<th align="left" width="120px">Số điện thoại</th>
                <td><input style="height:30px; width:280px" name="From_phoneCus" value="<?php echo($arrprodetail[0]->getPhoneNumber()) ?>" id="From_phoneCus" type="text" size="40" maxlength="100"></td>
            </tr>
            <tr>
            	<th align="left" width="120px">Ngày Đăng</th>
                <td><?php echo(CommonFuns::int_to_date2($arrprodetail[0]->getDateCreateFirst())) ?></td>
            </tr>
            <tr>
            	<th align="left" width="120px" valign="top">TT Tóm Tắt</th>
                <td>
					<?php echo($arrprodetail[0]->getInfoProfile()."<br/>"); ?>
					<?php
                    for ($i = 1; $i < count($arrprodetail); $i++) {
                        echo("**************************************<br/>");
                        echo("Ngày đăng: ".CommonFuns::int_to_date2($arrprodetail[$i]->getDateCreate())." <br/>");
                        echo($arrprodetail[$i]->getInfoProfile()."<br/>");
                    }
                    ?>
                </td>
            </tr>
            <tr><td colspan="2"><hr style="border: 1px solid thin; margin-top:4px; margin-bottom: 4px;"></td></tr>
            <tr>
            	<th align="left" width="120px" valign="top">Trạng Thái</th>
                <td>
                <select id="form_statusupdate" style="height: 23px; width:200px; margin-right:10px;">
					<?php
					foreach ($statusList as $aStatus) {
						
					?>
                        <option value="<?php echo ($aStatus->getStatusID()); ?>" <?php if ($aStatus->getStatusID() == $arrprodetail[0]->getStatus()->getStatusID()) {?> selected="selected" <?php } ?>><?php echo ($aStatus->getStatusName()); ?></option>
                    <?php
					}
					?></select>
                </td>
            </tr>
            <tr>
            	<th align="left" width="120px" valign="top">TT Phản Hồi</th>
                <td><textarea style="resize:none; width: 100%;" rows="4" name="form-inforequest" class="form-inforequest" id="form-inforequest"><?php echo($arrprodetail[0]->getInfoRequest()); ?></textarea></td>
            </tr>
            <tr>
            	<th align="left" width="120px" valign="top">Số Tiền Vay</th>
                <td><input value="<?php echo($arrprodetail[0]->getAmountLoan()) ?>" name="form_amoun1" id="form_amoun1" style="height: 23px; width:200px; margin-right:10px; padding:5px;" maxlength="30" /> VNĐ</td>
            </tr>
            <tr>
            	<th align="left" width="120px" valign="top">Tổ chức cho vay</th>
                <td><input value="<?php echo($arrprodetail[0]->getBankLoan()) ?>" name="form_amoun2" id="form_amoun2" style="height: 23px; width:200px; margin-right:10px; padding:5px;" maxlength="500" /></td>
            </tr>
            <tr>
            	<th align="left" width="120px" valign="top">Hoa hồng</th>
                <td><input value="<?php echo($arrprodetail[0]->getHoaHong()) ?>" name="form_amoun2" id="form_amoun3" maxlength="30" style="height: 23px; width:200px; margin-right:10px; padding:5px;" /> VNĐ</td>
            </tr>
            <tr>
                <th colspan="2"><input class="class-update-detail-profile-link btnclra" type="button" value="Cập Nhật" style="border-radius: 5px; padding:5px; width:100px; font-weight:bold;" /></th>
            </tr>
        </table>
    </div>
    <a class="close-reveal-modal">&#215;</a>
</div>
<script src="../ckeditor/ckeditor.js"></script>
<script>
$(document).on('click', '.close-reveal-modal', function(e) {
		clostshowbankdeleted();
	});
	
	$(document).on('click', '.reveal-modal-bg', function(e) {
		clostshowbankdeleted();
	});
	
	function clostshowbankdeleted() {
		$('.reveal-modal-bg').hide();
		$('#showlistbankdeletedlightbox').hide();
	}
	$(document).on('click', '.class-edit-detail-profile-link', function(e) {
		$('.reveal-modal-bg').show();
		$('#showlistbankdeletedlightbox').show();
	});
	$('.class-update-detail-profile-link').click(function(e) {
		var id = '<?php echo($idpro) ?>';
		var namecus = $('#From_NameCus').val();
		var phonecus = $('#From_phoneCus').val();
		var status = $('#form_statusupdate').val();
		var contentrequest = CKEDITOR.instances['form-inforequest'].getData();
		var amount1 = $('#form_amoun1').val();
		var re_num = /^([^0-9]*)$/;
		
		if(namecus.length == 0) {
			alert('Vui lòng nhập tên khách hàng');
			$('#From_NameCus').focus();
			return false;
		}
		
		if(phonecus.length == 0) {
			alert('Vui lòng nhập số điện thoại khách hàng');
			$('#From_phoneCus').focus();
			return false;
		}
		
		if(re_num.test(amount1)) {
			alert("Vui lòng nhập số tiền vay và phải là số");
			$('#form_amoun1').focus();
			return false;
		}
		var amount2 = $.trim($('#form_amoun2').val());
		
		var amount3 = $('#form_amoun3').val();
		if(re_num.test(amount3)) {
			alert("Vui lòng nhập phần trăm hoa hồng và phải là số");
			$('#form_amoun3').focus();
			return false;
		}
		$.ajax({
			url: "../src/ajax/ajaxprofileloan.php",
			type: "post",
			data: {act:'edit', rei: id, name: namecus, phone: phonecus, stre: status, cont: contentrequest, amo1: amount1, amo2: amount2, amo3: amount3},
			dataType:"json",
			success: function(response) {
				if(response == true) {
					alert("Cập Nhật Hồ Sơ Khách Hàng Thành Công");
					location.reload();
				} else {
					alert("Quá trình cập nhật xảy ra sự cố, vui lòng thử lại");
				}
			}
		});
	});
$(document).ready(function(e) {
	CKEDITOR.replace('form-inforequest');
	
	$("#showlistbankdeletedlightbox").height($( window ).height());
});
</script>
<?php
	}
}
?>