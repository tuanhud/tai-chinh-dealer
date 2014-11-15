<?
session_start();
ob_start("ob_gzhandler");
date_default_timezone_set("Asia/Saigon");
$host  = $_SERVER['HTTP_HOST'];
$host = "http://$host/";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>LOGIN-HỆ THỐNG QUẢN LÝ ĐẠI LÝ DÀNH CHO QUẢN TRỊ VIÊN</title>

<style>
.aplfrm {
	border-left: 5px solid #a2d7f6;
	border-right: 5px solid #a2d7f6;
	background: #f6fcff;
}
</style>
<link rel="stylesheet" type="text/css" href="<?php echo($host) ?>css/styledef.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo($host) ?>css/messi.css"/>
<script type="text/javascript" src="<?php echo($host) ?>js/jquery-1.11.1.js"></script>
<script type="text/javascript" src="<?php echo($host) ?>js/messi.js"></script>
<script>
$(document).ready(function(e) {
	
	resizeWindow();
	
	function resizeWindow() {
		var heightWindow = window.innerHeight;
	
		var heightMarrinTop = (heightWindow - $(".form_login").height()) / 2;
		if (heightMarrinTop < 0) heightMarrinTop = 0;
		$(".form_login").css("margin-top", heightMarrinTop);
	}
	
	$( window ).resize(function() {
		resizeWindow();
	});
	
    $('#logindealer_frm').submit(function(e) {
		var email = $.trim($('#From_Email').val());
		var pass = $('#From_pass').val();
		
		if(pass.length < 4) {
			$('#erremail').html('Username không hợp lệ');
			$('#From_Email').focus();
			return false;
		} else {
			$('#erremail').html('');
		}
		
		if(pass.length < 6) {
			$('#errpass').html('Vui lòng nhập mật khẩu và ít nhất 6 ký tự');
			$('#From_pass').focus();
			return false;
		} else {
			$('#errpass').html('');
		}
		
		$('body').append('<div class="reveal-modal-bg"></div>');
	
		$.ajax({
			type: "POST",
			url: "<?php echo($host) ?>admin/control/ajax/AjaxLoginAdmin.php",
			data:{emailre: email, passre: pass},
			dataType: "json",
			success: function(response){
				if(response == "success") {
					$(".fShowLoginSuccess").css("display", "block");
					setTimeout(function(){
						$(".fShowLoginSuccess").hide(1000);
						window.location = "<?php echo($host) ?>/admin/";
					}, 3000);
				} else if(response == "lock") { 
					new Messi('Tài khoản của bạn đã bị khóa vui lòng liên hệ với chúng tôi để được kích hoạt lại!', {
						title: 'Đăng Nhập',
						titleClass: 'anim error', //anim error
						buttons: [{
							id: 0, 
							label: 'Đóng', 
							val: 'X'
						}]
					});
				} else {
					new Messi('Đăng nhập không thành công, vui lòng kiểm tra lại!', {
						title: 'Đăng Nhập',
						titleClass: 'anim error', //anim error
						buttons: [{
							id: 0, 
							label: 'Đóng', 
							val: 'X'
						}]
					});
				}
			}
		});
        return false;
    });
});
</script>
</head>

<body>
<div class="intrl_txt form_login" style="margin: auto; width: 970px;">
	<div class="text11" style="color:#4c4c4c; width:950px; margin-left:20px; margin-top:10px;">
    	<div style="width: 458px; position: relative; margin: auto;">
        	<div class="fShowLoginSuccess" style="display: none;">
                <div style="position: absolute; width: 448px; height: 220px; top: 18px; left: 5px; background: #CCC; opacity: 0.5; border-radius: 15px; z-index: 2;"></div>
                <div style="width: 458px; position: absolute; height: 220px; top: 18px; left: 5px; z-index: 3;">
                    <div style="height: 30px; width: 250px; background: #0C6; border-radius: 10px; text-align: center; line-height: 30px; margin: auto; margin-top: 110px;">
                        <label style="color: #FFF; font-size: 18px; font-style:oblique;"><strong>Login thành công...!</strong></label>
                    </div>
                </div>
            </div>
            <form id="logindealer_frm" name="logindealer_frm" method="post" action="">
                <table width="458" border="0" align="center" cellpadding="0" cellspacing="0">
                    <tr>
                        <td valign="middle">&nbsp;</td>
                    </tr>
                    <tr>
                        <td height="74" valign="middle" align="center" background="<?php echo($host) ?>images/apl-tp.gif" style="background-repeat:no-repeat;"><h1>ĐĂNG NHẬP QUẢN TRỊ VIÊN</h1></td>
                    </tr>
                    <tr>
                        <td class="aplfrm"><table width="400" border="0" align="center" cellpadding="0" cellspacing="0">
                            <tbody>
                                <tr>
                                    <td colspan="2">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td height="35" class="frmtxt" valign="center">Username <span class="showms">*</span></td>
                                    <td><input name="From_Email" id="From_Email" type="text" style="width: 315px;" maxlength="500" autocomplete="off"><br><span id="erremail" class="showms"></span></td>
                                </tr>
                                <tr>
                                    <td width="30%" height="35" class="frmtxt" valign="center">Password <span class="showms">*</span></td>
                                    <td width="70%"><input name="From_pass" id="From_pass" type="password" style="width: 315px;" autocomplete="off" maxlength="200"><br><span id="errpass" class="showms"></span></td>
                                </tr>
                                <tr><td>&nbsp;</td></tr>
                                <tr>
                                    <td colspan="2" align="center"><font><input name="submit" type="submit" class="btnclra" value="Đăng nhập" style="width: 90px;"></font></td>
                                </tr>
                            </tbody>
                        </table></td>
                    </tr>
                    <tr>
                        <td width="458" height="26"><img src="<?php echo($host) ?>images/apl-bt.gif" width="458" height="26"></td>
                    </tr>
                </table>
            </form>   
        </div>
    </div>
</div>
</body>
</html>
