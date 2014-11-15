<div style="width: 100%; height: 30px; line-height: 30px; text-align: center; color: #0C9; font-weight: bold; margin-bottom: 10px;">
    <h1>Thêm Status Mới</h1>
</div>
<div>
    <form name="newad" method="post" action="/admin/control/AddStatusAction.php" onSubmit="return checkaddstatusnew();">
        <table>
            <tr>
                <th valign="top">Tên Status: </th>
                <td><input class="inputtextfield" type="text" name="tenstatus" maxlength="200" id="tenstatus" onFocus="showStyle(this)" onBlur="hiddenStyle(this)" /><br>
			<font color="red"><span id="err_tentypeloan"></span></font></td>
            </tr>
            <tr>
                <th colspan="2"><input type="submit" value="Cập nhật" class="btnclra" style="width: 100px;" /></th>
            </tr>
        </table>
	</form>
</div>

<script>
function checkaddstatusnew() {
	var ten = $.trim($('#tenstatus').val());
	if(ten.length == 0) {
		alert("Tên status không được bỏ trống");
		$('#tenstatus').focus();
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