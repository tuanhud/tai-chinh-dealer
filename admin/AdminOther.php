<div style="width: 100%; text-align: center;"><h1>Thay Đổi Mật Khẩu</h1></div>
<form action="/admin/control/AdminChangePassword.php" method="post" onsubmit="return checkchangepassword();">
    <table>
        <tr ><td>Mật Khẩu Củ:</td><td style="padding-bottom: 10px;"><input class="inputtextpasword" style="width: 300px;" type="password" name="oldPass" id="oldPass" onFocus="showStyle(this)" onBlur="hiddenStyle(this)" /><br>
			<font color="red"><span id="err_passold"></span></font></td></tr>
        <tr ><td>Mật Khẩu Mới:</td><td style="padding-bottom: 10px;"><input class="inputtextpasword" style="width: 300px;" type="password" name="newPass" id="newPass" onFocus="showStyle(this)" onBlur="hiddenStyle(this)" /><br>
			<font color="red"><span id="err_passnew"></span></font></td></tr>
        <tr><td>Nhập Lại Mật Khẩu Mới:</td><td><input class="inputtextpasword" style="width: 300px;" type="password" name="re-newPass" id="re-newPass" onFocus="showStyle(this)" onBlur="hiddenStyle(this)" /><br>
			<font color="red"><span id="err_passnewcomfim"></span></font></td></tr>
        <tr><td></td><td style="padding-top: 10px;"><input type="submit" value="Update" /> <a href="/admin/" style="text-decoration:none"><input type="button" value="Cancel"></a></td></tr>
    </table>
</form>

<script>
function checkchangepassword() {
	var passold = $('#oldPass').val();
	var newPass = $('#newPass').val();
	var repass = $('#re-newPass').val();
	
	if(passold.length == 0) {
		$('#err_passold').text('Vui lòng nhập mật khẩu củ!');
		$('#oldPass').focus();
		return false;
	} else {
		$('#err_passold').text('');
	}
	
	if(newPass.length < 4) {
		$('#err_passnew').text('Vui lòng nhập mật khẩu mới và lớn hơn 5 ký tự!');
		$('#newPass').focus();
		return false;
	} else {
		$('#err_passnew').text('');
	}
	
	if(newPass != repass) {
		$('#err_passnewcomfim').text('Mật khẩu mới không trùng khớp, vui lòng nhập lại!');
		$('#re-newPass').focus();
		return false;
	} else {
		$('#err_passnewcomfim').text('');
	}
	
	if(passold == newPass) {
		$('#err_passold').text('Mật khẩu củ và mật khẩu mới trùng nhau!');
		$('#oldPass').focus();
		return false;
	} else {
		$('#err_passold').text('');
	}
}

function showStyle(field) {
	field.style.backgroundColor = '#FFFFCC';
}

function hiddenStyle(field) {
	field.style.backgroundColor = '#FFFFFF';
}
</script>