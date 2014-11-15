<?
include_once($_SERVER['DOCUMENT_ROOT'].'/src/common/CommonFuns.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/src/entitys/Bank.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/src/DAO/BankDAO.php');

session_start();
ob_start("ob_gzhandler");
date_default_timezone_set("Asia/Saigon");

$bankDao = new BankDAO();

$banks = $bankDao->getBanks(-1);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Đăng ký chương trình cộng tác viên kinh doanh</title>
<link rel="stylesheet" type="text/css" href="/css/styledef.css"/>
<link rel="stylesheet" type="text/css" href="/css/messi.css"/>
<style>
.aplfrm {
	border-left: 5px solid #a2d7f6;
	border-right: 5px solid #a2d7f6;
	background: #f6fcff;
}

input[type=text], input[type=password] {
	width: 275px;
	margin-bottom: 5px;
}

input[type=tel] {
	width: 275px;
	margin-bottom: 5px;
}

textarea {
	width: 277px;
	margin-bottom: 5px;
	border-radius: 3px;
}

#Form_gender, #ProvinceID, #From_namebank {
	width: 282px;
	margin-bottom: 5px;
	border-radius: 3px;
	padding: 3px;
	border-radius: 3px;
	border: 1px solid #999;
	height: 20px;
}
</style>
<link rel="stylesheet" type="text/css" href="/css/jquery-ui.css">
<script type="text/javascript" src="/js/jquery-1.11.1.js"></script>
<script type="text/javascript" src="/js/messi.js"></script>
<script src="/js/jquery-ui.js"></script>
<script type="text/javascript" src="/js/datepicker-vi.js"></script>

<script>
$(document).ready(function(e) {
	
	var date = new Date();
	var yearstart = date.getFullYear() - 80;
	var yearend = date.getFullYear() - 17;
	$( "#From_dayofbirth" ).datepicker({
		changeMonth: true,
		changeYear: true,
		dateFormat: 'dd-mm-yy',
		yearRange: '' + yearstart + ':' + yearend,
		defaultDate: new Date(yearend, date.getMonth(), date.getDay())
	});	
	
    $('#registry_frm').submit(function(e) {
		try {
			//validate
			var email = $.trim($('#From_Email').val());
			var re_mail=/^[A-Za-z\.]+\w+@[A-Za-z]+(.[A-Za-z]+)(.[A-Za-z]+)?$/;
			if(!(re_mail.test(email))) {
				$('#erremail').html('Email không hợp lệ');
				$('#From_Email').focus();
				return false;
			} else {
				$('#erremail').html('');
			}
			
			var pass = $('#From_Pass').val();
			if(pass.length < 6) {
				$('#errpass').html('Vui lòng nhập mật khẩu và ít nhất là 6 ký tự');
				$('#From_Pass').focus();
				return false;
			} else {
				$('#errpass').html('');
			}
			
			var repass = $('#From_Repass').val();
			if(pass != repass) {
				$('#errrepass').html('Mật khẩu không trùng khớp vui lòng kiểm tra lại');
				$('#From_Repass').focus();
				return false;
			} else {
				$('#errrepass').html('');
			}
			
			var name = $.trim($('#From_Name').val());
			if(name.length == 0) {
				$('#errname').html('Vui lòng nhập họ và tên');
				$('#From_Name').focus();
				return false;
			} else {
				$('#errname').html('');
			}
			var gender = $('#Form_gender').val();
			var birthday = $.trim($('#From_dayofbirth').val());
			if(birthday.length == 0) {
				$('#errdayofbirth').html('Vui lòng nhập ngày sinh');
				$('#From_dayofbirth').focus();
				return false;
			} else {
				$('#errdayofbirth').html('');
			}
			
			var phone = $.trim($('#From_Phone').val());
			var re_phone = /^([0-9]+(([0-9])?[0-9]*)*){9,11}$/;
			if(!(re_phone.test(phone))) {
				$('#errphone').html('Số điện thoại không hợp lệ và chỉ được phép 11 ký tự(0-9)');
				$('#From_Phone').focus();
				return false;
			} else {
				$('#errphone').html('');
			}
			
			var homephone = $.trim($('#From_HomePhone').val());
			if(homephone.length > 0) {
				if(!(re_phone.test(homephone))) {
					$('#errhomephone').html('Số điện thoại cố định không hợp lệ và chỉ được phép 11 ký tự(0-9)');
					$('#From_HomePhone').focus();
					return false;
				} else {
					$('#errhomephone').html('');
				}
			} else {
				$('#errhomephone').html('');
			}
			var address = $.trim($('#From_Address').val());
			if(address.length == 0) {
				$('#erraddress').html('Vui lòng nhập địa chỉ liên hệ');
				$('#From_Address').focus();
				return false;
			} else {
				$('#erraddress').html('');
			}
			var provice = $.trim($('#ProvinceID').val());
			if(provice.length == 0) {
				$('#erreprovice').html('Vui lòng chọn tỉnh thành');
				$('#ProvinceID').focus();
				return false;
			} else {
				$('#erreprovice').html('');
			}
			
			var donvicongtac = $.trim($('#From_donvicongtac').val());
			if(donvicongtac.length == 0) {
				$('#errdonvicongtac').html('Vui lòng nhập đơn vị công tác');
				$('#From_donvicongtac').focus();
				return false;
			} else {
				$('#errdonvicongtac').html('');
			}
			
			var diachicongtac = $.trim($('#From_addresscongtac').val());
			if(diachicongtac.length == 0) {
				$('#erraddresscongtac').html('Vui lòng nhập địa chỉ đơn vị công tác');
				$('#From_addresscongtac').focus();
				return false;
			} else {
				$('#erraddresscongtac').html('');
			}
			
			var introwork = $.trim($('#From_introwordcurent').val());
			if(introwork.length == 0) {
				$('#errintrowordcurent').html('Vui lòng nhập mô tả chi tiết công việc hiện tại');
				$('#From_introwordcurent').focus();
				return false;
			} else {
				$('#errintrowordcurent').html('');
			}
			
			var introknwork = $.trim($('#From_introkngwordcurent').val());
			if(introknwork.length == 0) {
				$('#errintrokngwordcurent').html('Vui lòng nhập mô tả chi tiết kinh nghiệm công việc hiện tại');
				$('#From_introkngwordcurent').focus();
				return false;
			} else {
				$('#errintrokngwordcurent').html('');
			}
			
			var codebank = $.trim($('#From_codebank').val());
			if(!(re_phone.test(codebank))) {
				$('#errcodebank').html('Vui lòng nhập số tài khoản(chỉ là số)');
				$('#From_codebank').focus();
				return false;
			} else {
				$('#errcodebank').html('');
			}
			
			var bank = $.trim($('#From_namebank').val());
			if(bank.length == 0) {
				$('#errnamebank').html('Vui lòng chọn ngân hàng');
				$('#From_namebank').focus();
				return false;
			} else {
				$('#errnamebank').html('');
			}
			
			var accept = $('#checkaccept').is(':checked');
			
			if(accept == false) {
				alert("Vui lòng đọc điều khoản và đồng ý");
				return false;
			}
			
			$('body').append('<div class="reveal-modal-bg"></div>');
			$('input[type="submit"]').attr('disabled','disabled');
			$.ajax({
				type: "POST",
				url: "/control/AjaxRegistryDealer.php",
				data:{emailre: email, passre: pass, namere: name, gend: gender, birthdayre: birthday, phonere: phone, homephonere: homephone, addressre: address, provicere: provice, dvct: donvicongtac, dcct: diachicongtac, gtcv: introwork, gtknlv: introknwork, stk: codebank, ngh: bank},
				dataType: "json",
				success: function(response){
					if(response == "exits"){
	//					new Messi('Địa Chỉ email này đã được đăng ký, bạn vui lòng thử lại email khác!', {
	//						title: 'Đăng Ký Thông Tin Làm Đại Lý',
	//						titleClass: 'anim error', //anim error
	//						buttons: [{
	//							id: 0, 
	//							label: 'Đóng', 
	//							val: 'X'
	//						}]
	//					});
						$('.reveal-modal-bg').remove();
						alert("Địa Chỉ email này đã được đăng ký, bạn vui lòng thử lại email khác!");
					} else if(response == "true"){
						//alert('Đăng ký thành công, chúng tôi sẽ liên hệ với bạn sau, cảm ơn bạn đã đăng ký');
						//resetinfoform();
						//$('#registry_frm').reset();
						location.reload();
	//					new Messi('Đăng ký thành công, chúng tôi sẽ kiểm tra thông tin của bạn và kích hoạt tài khoản giao dịch, cảm ơn bạn đã đăng ký', {
	//						title: 'Đăng Ký Thông Tin Làm Đại Lý',
	//						titleClass: 'info', //
	//						buttons: [{
	//							id: 0, 
	//							label: 'Đóng', 
	//							val: 'X'
	//						}]
	//					});
						$('.reveal-modal-bg').remove();
						alert('Đăng ký thành công, chúng tôi sẽ kiểm tra thông tin của bạn và kích hoạt tài khoản giao dịch, cảm ơn bạn đã đăng ký');
					} else {
	//					new Messi('Đăng ký thất bại, bạn vui lòng thử lại sau!', {
	//						title: 'Đăng Ký Thông Tin Làm Đại Lý',
	//						titleClass: 'anim error', //anim error
	//						buttons: [{
	//							id: 0, 
	//							label: 'Đóng', 
	//							val: 'X'
	//						}]
	//					});
						$('.reveal-modal-bg').remove();
						alert('Đăng ký thất bại, bạn vui lòng thử lại sau!');
					}
					$('input[type="submit"]').removeAttr('disabled');
					
				},
				error: function (textStatus, errorThrown) {
					$('input[type="submit"]').removeAttr('disabled');
				}
			});
		} catch (ex) {
			$('input[type="submit"]').removeAttr('disabled');
		}
        
		return false;
    });
	
	function resetinfoform() {
		$('#From_Email').val("");
		$('#From_Name').val("");
		$('#Form_gender').val('1');
		$('#From_dayofbirth').val("");
		$('#From_Phone').val("");
		$('#From_HomePhone').val('');
		$('#From_Address').val('');
		$('#ProvinceID').val('');
	}
});
</script>
</head>

<body>
<div class="intrl_txt" style="width:950px; margin: auto;">
	<div class="text11" style="color:#4c4c4c; width:950px;">
    	<div style="width: 458px; position: relative; margin: auto;">
            <form id="registry_frm" name="registry_frm" method="post" action="">
                <table width="458" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                        <tr>
                            <td valign="middle">&nbsp;</td>
                        </tr>
                        <tr>
                            <td height="74" valign="middle" align="center" background="/images/apl-tp.gif" style="background-repeat:no-repeat; color: #690; font-size: 10px;"><h1>ĐĂNG KÝ CỘNG TÁC VIÊN</h1></td>
                        </tr>
                        <tr>
                            <td class="aplfrm"><table width="400" border="0" align="center" cellpadding="0" cellspacing="0">
                                <tbody>
                                    <tr>
                                        <td colspan="2">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td height="35" class="frmtxt" valign="center">Email <span class="showms">*</span></td>
                                        <td><input name="From_Email" id="From_Email" type="text" maxlength="500"><br><span id="erremail" class="showms"></td>
                                    </tr>
                                    <tr>
                                        <td height="35" class="frmtxt" valign="center">Mật khẩu <span class="showms">*</span></td>
                                        <td><input name="From_Pass" id="From_Pass" type="password" maxlength="200"><br><span id="errpass" class="showms"></td>
                                    </tr>
                                    <tr>
                                        <td height="35" class="frmtxt" valign="center">Nhập lại mật khẩu <span class="showms">*</span></td>
                                        <td><input name="From_Repass" id="From_Repass" type="password" maxlength="200"><br><span id="errrepass" class="showms"></td>
                                    </tr>
                                    <tr>
                                        <td width="30%" height="35" class="frmtxt" valign="center"><font><font>Họ và tên <span class="showms">*</span></font></font></td>
                                        <td width="70%"><input name="From_Name" id="From_Name" type="text" maxlength="500"><br><span id="errname" class="showms"></td>
                                    </tr>
                                    <tr>
                                        <td height="35" class="frmtxt" valign="center">Giới tính <span class="showms">*</span></td>
                                        <td><select name="Form_gender" style="height: 30px; padding: 5px;" id="Form_gender"><option value="1">Nam</option><option value="0">Nữ</option></select></td>
                                    </tr>
                                    <tr>
                                        <td height="35" class="frmtxt" valign="center">Ngày tháng năm sinh <span class="showms">*</span></td>
                                        <td><input name="From_dayofbirth" id="From_dayofbirth" type="text"><br><span id="errdayofbirth" class="showms"></td>
                                    </tr>
                                    <tr>
                                        <td height="35" class="frmtxt" valign="center">Điện thoại di động <span class="showms">*</span></td>
                                        <td><input name="From_Phone" id="From_Phone" type="tel"><br><span id="errphone" class="showms"></td>
                                    </tr>
                                    <tr>
                                        <td height="35" class="frmtxt" valign="center"><font>Điện thoại cố định</font></td>
                                        <td><input name="From_HomePhone" id="From_HomePhone" type="text"><br><span id="errhomephone" class="showms"></td>
                                    </tr>
                                    <tr>
                                        <td height="35" class="frmtxt" valign="center">Địa chỉ cư trú<span class="showms">*</span></td>
                                        <td><input name="From_Address" id="From_Address" type="text"><br><span id="erraddress" class="showms"></td>
                                    </tr>
                                    <tr>
                                        <td height="35" class="frmtxt" valign="center">Tỉnh thành <span class="showms">*</span></td>
                                        <td><select id="ProvinceID" name="From_Province"  style="height: 30px;">
                                <option selected="selected" value="">Chọn tỉnh thành</option>
                                <option value="Hà Nội">Hà Nội</option><option value="Hồ Chí Minh">TP HCM</option><option value="Cần Thơ">TP Cần Thơ</option><option value="Đà Nẵng">TP Đà Nẵng</option><option value="Hải Phòng">TP Hải Phòng</option><option value="An Giang">An Giang</option><option value="Vũng Tàu">Bà Rịa - Vũng Tàu</option><option value="Bắc Giang">Bắc Giang</option><option value="Bắc Kạn">Bắc Kạn</option><option value="Bạc Liêu">Bạc Liêu</option><option value="Bắc Ninh">Bắc Ninh</option><option value="Bến Tre">Bến Tre</option><option value="Bình Định">Bình Định</option><option value="Bình Dương">Bình Dương</option><option value="Bình Phước">Bình Phước</option><option value="Bình Thuận">Bình Thuận</option><option value="Cà Mau">Cà Mau</option><option value="Cao Bằng">Cao Bằng</option><option value="Đăk Lăk">Đăk Lăk</option><option value="Đak Nông">Đak Nông</option><option value="Điện Biên">Điện Biên</option><option value="Đồng Nai">Đồng Nai</option><option value="Đồng Tháp">Đồng Tháp</option><option value="Gia Lai">Gia Lai</option><option value="Hà Giang">Hà Giang</option><option value="Hà Nam">Hà Nam</option><option value="Hà Tĩnh">Hà Tĩnh</option><option value="Hải Dương">Hải Dương</option><option value="Hậu Giang">Hậu Giang</option><option value="Hòa Bình">Hòa Bình</option><option value="Hưng Yên">Hưng Yên</option><option value="Khánh Hòa">Khánh Hòa</option><option value="Kiên Giang">Kiên Giang</option><option value="Kon Tum">Kon Tum</option><option value="Lai Châu">Lai Châu</option><option value="Lâm Đồng">Lâm Đồng</option><option value="Lạng Sơn">Lạng Sơn</option><option value="Lào Cai">Lào Cai</option><option value="Long An">Long An</option><option value="Nam Định">Nam Định</option><option value="Nghệ An">Nghệ An</option><option value="Ninh Bình">Ninh Bình</option><option value="Ninh Thuận">Ninh Thuận</option><option value="Phú Thọ">Phú Thọ</option><option value="Phú Yên">Phú Yên</option><option value="Quảng Bình">Quảng Bình</option><option value="Quảng Nam">Quảng Nam</option><option value="Quảng Ngãi">Quảng Ngãi</option><option value="Quảng Ninh">Quảng Ninh</option><option value="Quảng Trị">Quảng Trị</option><option value="Sóc Trăng">Sóc Trăng</option><option value="Sơn La">Sơn La</option><option value="Tây Ninh">Tây Ninh</option><option value="Thái Bình">Thái Bình</option><option value="Thái Nguyên">Thái Nguyên</option><option value="Thanh Hóa">Thanh Hóa</option><option value="Thừa Thiên Huế">Thừa Thiên Huế</option><option value="Tiền Giang">Tiền Giang</option><option value="Trà Vinh">Trà Vinh</option><option value="Tuyên Quang">Tuyên Quang</option><option value="Vĩnh Long">Vĩnh Long</option><option value="Vĩnh Phúc">Vĩnh Phúc</option><option value="Yên Bái">Yên Bái</option>  
                            </select><br><span id="erreprovice" class="showms"></td>
                                    </tr>
                                    <tr>
                                        <td height="35" class="frmtxt" valign="center">Đơn vị công tác <span class="showms">*</span></td>
                                        <td><input name="From_donvicongtac" id="From_donvicongtac" type="text"><br><span id="errdonvicongtac" class="showms"></td>
                                    </tr>
                                    <tr>
                                        <td height="35" class="frmtxt" valign="center">Địa chỉ công tác <span class="showms">*</span></td>
                                        <td><input name="From_addresscongtac" id="From_addresscongtac" type="text"><br><span id="erraddresscongtac" class="showms"></td>
                                    </tr>
                                    <tr>
                                        <td height="35" class="frmtxt" valign="center">Mô tả chi tiết công việc hiện tại <span class="showms">*</span></td>
                                        <td><textarea name="From_introwordcurent" id="From_introwordcurent" type="text" style="height: 70px; margin-bottom: 5px;"></textarea><br><span id="errintrowordcurent" class="showms"></td>
                                    </tr>
                                    
                                    <tr>
                                        <td height="35" class="frmtxt" valign="center">Mô tả chi tiết kinh nghiệm công việc hiện tại <span class="showms">*</span></td>
                                        <td><textarea name="From_introkngwordcurent" id="From_introkngwordcurent" type="text" style="height: 70px;"></textarea><br><span id="errintrokngwordcurent" class="showms"></td>
                                    </tr>
                                    <tr>
                                        <td height="35" class="frmtxt" valign="center">Số tài khoản NH <span class="showms">*</span></td>
                                        <td><input name="From_codebank" id="From_codebank" type="text"><br><span id="errcodebank" class="showms"></td>
                                    </tr>
                                    <tr>
                                        <td height="35" class="frmtxt" valign="center">Tên ngân hàng <span class="showms">*</span></td>
                                        <td><select style="height: 30px; padding: 5px;" name="From_namebank" id="From_namebank" class="From_namebank"><option value="">Chọn ngân hàng</option>
                                        <?php
										foreach ($banks as $entry) {
										?>
                                        <option value="<?php echo($entry->getBankID()) ?>">[<?php echo($entry->getBankID()) ?>]	<?php echo($entry->getBankName()) ?></option>
                                        <?php
										}
										?>                                        
                                        </select><br><span id="errnamebank" class="showms"></td>
                                    </tr>
                                    <tr>
                                    	<td colspan="2" style="font-size: 10px;">(<span class="showms">*</span>) Thông tin là bắt buộc</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" style="font-size:11px"><p><strong>Lời giới thiệu:</strong></p>
                                          <p>                               	   Được thành lập vào tháng 07/2013, Cổng thông tin giải pháp tài chính trực tuyến <strong>Tài chính Online</strong> đang từng bước trở thành cầu nối vững chắc giữa người tiêu dùng và các tổ chức tài chính liên ngân hàng. Cổng thông tin giải pháp tài chính trực tuyến, môi giới dịch vụ bán lẻ ngân hàng, công ty tài chính, công ty bảo hiểm. Qua đó, người tiêu dùng sẽ được cập nhật các thông tin tiện ích từ các tổ chức tài chính thông qua <strong>Tài chính Online</strong> truyền tải thông tin và tư vấn miễn phí các sản phẩm dịch vụ “ Vay tín chấp, vay mua nhà/ ôtô trả góp, vay tiêu dùng, bảo hiểm nhân thọ, bảo hiểm phi nhân thọ và thẻ tín dụng,...”.</p>
                                          <p>
                                            <input type="checkbox" checked name="checkaccept" id="checkaccept" />
                                            <label for="checkaccept">Tôi đồng ý với các <a target="_blank" href="<?php echo($host) ?>dieu-khoan.html">Điều khoản và Điều kiện</a>.</label>
                                      </p></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" align="center">
                                        	<input name="submit" type="submit" class="btnclr" value="Đăng Ký" style="width: 100px;">&nbsp;&nbsp;&nbsp;
                                            <A href="/"><input name="submit" type="button" class="btnclr" value="Đăng Nhập" style="width: 100px;"></A>
                                        </td>
                                    </tr>
                                </tbody>
                            </table></td>
                        </tr>
                        <tr>
                            <td width="458" height="26"><img src="/images/apl-bt.gif" width="458" height="26"></td>
                        </tr>
                    </tbody>
                </table>
            </form>  
        </div> 
    </div>
</div>
<div style="height: 30px;"></div>
</body>
</html>