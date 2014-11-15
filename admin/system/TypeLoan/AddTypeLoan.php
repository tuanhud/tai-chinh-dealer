<div style="width: 100%; height: 30px; line-height: 30px; text-align: center; color: #0C9; font-weight: bold; margin-bottom: 10px;">
    <h1>Thêm Loại Hình Vay Mới</h1>
</div>
<div>
    <form name="newad" method="post" action="/admin/control/AddTypeLoanAction.php" onSubmit="return checkaddtypeLoannew();">
        <table>
            <tr>
                <th valign="top">Tên loại hình vay: </th>
                <td><input class="inputtextfield" type="text" name="tentypeloan" maxlength="200" id="tentypeloan" onFocus="showStyle(this)" onBlur="hiddenStyle(this)" /><br>
			<font color="red"><span id="err_tentypeloan"></span></font></td>
            </tr>
            <tr>
                <th colspan="2"><input type="submit" value="Cập nhật" class="btnclra" style="width: 100px;" /></th>
            </tr>
        </table>
	</form>
</div>

<script>
function checkaddtypeLoannew() {
	//var ma = $.trim($('#manganhang').val());
	var ten = $.trim($('#tentypeloan').val());
	if(ten.length == 0) {
		alert("Tên loại hình vay không được bỏ trống");
		//$('#err_tentypeloan').text('Tên loại hình vay không được bỏ trống');
		$('#tentypeloan').focus();
		return false;
	} else {
		$('#err_tentypeloan').text('');
	}
}

function showStyle(field) {
	field.style.backgroundColor = '#FFFFCC';
}

function hiddenStyle(field) {
	field.style.backgroundColor = '#FFFFFF';
}
</script>