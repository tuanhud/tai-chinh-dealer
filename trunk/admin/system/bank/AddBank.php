<div style="width: 100%; height: 30px; line-height: 30px; text-align: center; color: #0C9; font-weight: bold; margin-bottom: 10px;">
    <h1>Thêm Ngân Hàng Mới</h1>
</div>
<div>
    <form name="newad" method="post" enctype="multipart/form-data" action="/admin/control/AddBank.php" onSubmit="return checkaddbanknew();">
        <table>
            <tr>
                <th valign="top">Tên giao dịch: </th>
                <td><input class="inputtextfield" type="text" name="manganhang" maxlength="200" id="manganhang" onFocus="showStyle(this)" onBlur="hiddenStyle(this)" /><br>
			<font color="red"><span id="err_manganhang"></span></font></td>
            </tr>
            <tr>
                <th valign="top">Tên đầy đủ: </th>
                <td><input class="inputtextfield" type="text" name="tennganhang" maxlength="200" id="tennganhang" onFocus="showStyle(this)" onBlur="hiddenStyle(this)" /><br>
			<font color="red"><span id="err_tennganhang"></span></font></td>
            </tr>
            <tr>
                <th valign="top">Ảnh logo: </th>
                <td><input type="file" name="logonganhang" id="logonganhang" onchange="doUpFile()" />
                  <br>
			<font color="red"><span>Hình ảnh chỉ cho phép không quá 2MB, định dạng up(*.gif , *.jpg, *.png)</span></font></td>
            </tr>
            <tr>
                <th colspan="2"><input type="submit" value="Cập nhật" class="btnclra" style="width: 100px;" /></th>
            </tr>
        </table>
	</form>
</div>

<script>
function checkaddbanknew() {
	var ma = $.trim($('#manganhang').val());
	var ten = $.trim($('#tennganhang').val());
	
	if(ma.length == 0) {
		alert("Mã Ngân Hàng không được bỏ trống");
		//$('#err_manganhang').text('Mã Ngân Hàng không được bỏ trống');
		$('#manganhang').focus();
		return false;
	} else {
		$('#err_manganhang').text('');
	}
	
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