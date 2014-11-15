<?php
if (isset($_SESSION['mess'])) {
	if ($_SESSION['mess'] == "success") {
?>
<script>
alert("Cập nhật thông tin khách hàng thành công");
</script>
<?php
	} else {
?>
<script>
alert("Cập nhật thông tin khách hàng thất bại");
</script>
<?php	
	}
	unset($_SESSION['mess']);
}

$profileCustomerDAO = new ProfileCustomerDAO();

if(isset($_GET['id'])) {
	$id = $_GET['id'];
	$arrprodetail = $profileCustomerDAO -> getProfileDetailByIDPro($email, $id);
	if (count($arrprodetail) > 0) {
		$nameCustomer = rewriteTextUrl(stripUnicode($arrprodetail[0]->getNameCustomer()));
?>
<div style="margin:auto; width:980px; text-align: center;"><h1 style="color:#88A943; text-transform:uppercase; margin:auto;">CẬP NHẬT HỒ SƠ KHÁCH HÀNG: <A href="/quanly/chi-tiet-ho-so/<?php echo($arrprodetail[0]->getIDProfile()) ?>/<?php echo($nameCustomer) ?>.html"><?php echo($arrprodetail[0]->getNameCustomer()) ?></A></h1></div>
<div style="height: 20px;"></div>
<div style="width: 500px; margin: auto;">
	<form id="updateprofilecustomerdealer" action="/control/CreateProfileDealer.php" method="post" enctype="multipart/form-data">
        <table>
            <tr>
                <td class="info-basic-bold" width="300px">Tên khách hàng</td>
                <td>
                    <input type="hidden" name="act" value="edit" />
                    <input type="hidden" name="Form_id" value="<?php echo($id) ?>" />
                    <input type="hidden" name="Form_id_date" value="<?php echo($arrprodetail[0]->getDateCreate()) ?>" />
                    <strong><?php echo($arrprodetail[0]->getNameCustomer()) ?></strong></td>
            </tr>
            <tr>
                <td class="info-basic-bold" valign="top">Khu vực</td>
                <td><?php echo($arrprodetail[0]->getProvince()) ?></td>
            </tr>
            <tr>
                <td class="info-basic-bold" valign="top">Sản phẩm</td>
                <td><?php echo($arrprodetail[0]->getTypeLoan()->getLoanName()) ?></td>
            </tr>
            <tr>
                <td class="info-basic-bold" valign="top">Số điện thoại</td>
                <td><?php echo($arrprodetail[0]->getPhoneNumber()) ?></td>
            </tr>
            <tr>
                <td class="info-basic-bold" valign="top">Thông tin bổ sung</td>
                <td></td>
            </tr>
            <tr>
                <td colspan="2"><textarea name="form_infointro" id="form_infointro" class="form_infointro" style="resize:none; width: 500px;" rows="4"></textarea><br><span id="errinfocus" class="showms"></td>
            </tr>
            <tr>
                <td class="info-basic-bold" valign="top">Upload hồ sơ khách hàng trực tuyến</td>
                <td><input type="file" name="filenameprofile[]" id="filenameprofile" multiple="multiple" /><br><span style="font-size:10px; color: #06F;">Cập nhật cho phép tối đa 5 file, dung lượng mỗi file tối đa là 2MB và phải là file *.rar , *.zip, *.jpg, *.png, *.doc, *.xls</span><br /><span id="errfileprofile" class="showms"></td>
            </tr>
            <tr>
                <td colspan="2" align="center"><input type="submit" value="Login" class="submitform class-pageNow btn-menu-action" style="width: 100px; line-height: 20px;"  /></td>
            </tr>
        </table>
    </form>
</div>

<div style="clear: both; height: 20px;"></div>
<?php
if (count($arrprodetail) > 0) {
?>
<div style="margin:auto; width:980px; text-align: center;"><h2 style="color:#88A943; text-transform:uppercase; margin:auto;">Lịch Sử Giao Dịch</h2></div>
<div style="width: 980px; max-width: 980px;"  class="class-content-records">
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
		$icount = 0;
		for ($icount = 0; $icount < count($arrprodetail); $icount++) {
		?>
        <tr>
        	<td align="center"><span><?php echo($icount + 1) ?></span></td>
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

<script src="/ckeditor/ckeditor.js"></script>
<script>
$(document).ready(function(e) {
	CKEDITOR.replace('form_infointro');
	$('#filenameprofile').change(function(){ 
		elem = this;
		if(elem.files.length > 5) {
			alert("Số file tối đa là 5 file");
			$('#errfileprofile').html('Bạn chỉ có thể chọn số file tối đa là 5 file');
			$('#filenameprofile').val('');
			return false;
		}
		for (var x = 0; x < elem.files.length; x++) {
			var f=elem.files[x];
			
			var ext = "";
			sGetPath = f.name;
			ext = sGetPath.substring(sGetPath.length-3, sGetPath.length);
			ext = ext.toLowerCase();
			if((ext != 'rar') && (ext != 'zip') && (ext != 'doc') && (ext != 'xls') && (ext != 'jpg') && (ext != 'png')) {
				alert("Bạn chỉ có thể chọn file có đuôi là: *.rar , *.zip, *.jpg, *.png, *.doc, *.xls");
				$('#errfileprofile').html('Bạn chỉ có thể chọn file có đuôi là: *.rar , *.zip, *jpg, *png, word, excel');
				$('#filenameprofile').val('');
				return false;
			}else{
				if(f.size > 2097152) { //2MB
					alert("File có kích thước lớn hơn 2MB, vui lòng chọn file khác");
					$('#errfileprofile').html('File có kích thước lớn hơn 2MB, vui lòng chọn file khác');
					$('#filenameprofile').val('');
					return false;
				} else {
					$('#errfileprofile').html('');
				}
			}
		}
		return true;
	});
	
	$('#updateprofilecustomerdealer').submit(function(e) {
		var infointro = CKEDITOR.instances['form_infointro'].getData();
		
		if(infointro.length == 0) {
			$('#errinfocus').html('Vui lòng điền một số thông tin cơ bản về khách hàng');
			return false;
		} else {
			$('#errinfocus').html('');
		}
		
		return true;
    });
});
</script>
<?php
	}
}
?>