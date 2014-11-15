<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/src/entitys/Bank.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/src/DAO/BankDAO.php');

$bankDAO = new BankDAO();

if(isset($_GET['id'])) {
	$idbank = $_GET['id'];
	$aBank = $bankDAO->getBankByID($idbank);
	if($aBank->getBankID() != "") { 
	?>
<h3>Cập Nhật Thông Tin Ngân Hàng "<?php echo($aBank->getBankName()) ?>"</h3>
<div>
    <form name="newad" method="post" enctype="multipart/form-data" action="/admin/control/EditBank.php" onSubmit="return checkeditbanknew();">
        <table>
            <tr>
                <th align="left" valign="top" width="150px;">Mã Ngân Hàng: </th>
                <td><strong style="color:#C03"><?php echo($aBank->getBankID()) ?></strong><input type="hidden" name="manganhang" id="manganhang" value="<?php echo($aBank->getBankID()) ?>" /></td>
            </tr>
            <tr>
                <th align="left" valign="top">Tên Ngân Hàng: </th>
                <td><input class="inputtextfield" type="text" name="tennganhang" maxlength="200" id="tennganhang" onFocus="showStyle(this)" onBlur="hiddenStyle(this)" value="<?php echo($aBank->getBankName()) ?>" /><br>
			<font color="red"><span id="err_tennganhang"></span></font></td>
            </tr>
            <tr>
                <th align="left" valign="top">Hình Ảnh Icon: </th>
                <td><input type="file" name="logonganhang" id="logonganhang" onChange="doUpFile()" /><input type="hidden" name="logobanktemp" value="<?php echo($aBank->getBankLogo()) ?>" /></td>
            </tr>
            <tr><th colspan="2"><img src="../<?php echo($aBank->getBankLogo()) ?>" /></th></tr>
            <tr>
                <th colspan="2"><input type="submit" value="Cập Nhật" class="btnclra" style="width: 100px;" /></th>
            </tr>
        </table>
	</form>
</div>

<script>
function checkeditbanknew() {
	var ten = $.trim($('#tennganhang').val());
	
	if(ten.length == 0) {
		alert("Tên Ngân Hàng không được bỏ trống");
		//$('#err_tennganhang').text('Tên Ngân Hàng không được bỏ trống');
		$('#tennganhang').focus();
		return false;
	} else {
		$('#err_tennganhang').text('');
	}
}

function doUpFile() {
	var sGetPath = "";
	var ext = "";
	//Đọc giá trị trong hộp file
	sGetPath = document.getElementById("logonganhang").value;
	
	//Kiểm tra phần mở rộng của tên file	
	ext = sGetPath.substring(sGetPath.length-3, sGetPath.length);
	ext = ext.toLowerCase();
	if((ext != 'png') && (ext != 'jpg') && (ext != 'gif')) {
		alert("Bạn chỉ có thể chọn tập tin có định dạng: *.gif , *.jpg, *.png");
		document.getElementById("logonganhang").value = "";
		return false;
	} else {
		document.getElementById("logonganhang").value = sGetPath;
		return true;
	}
}

function showStyle(field) {
	field.style.backgroundColor = '#FFFFCC';
}

function hiddenStyle(field) {
	field.style.backgroundColor = '#FFFFFF';
}
</script>
    <?php
	}
}
?>

