<?php
$dealerDAO = new DealerDAO();
$profileCustomerDAO = new ProfileCustomerDAO();

$dealers = $dealerDAO->getDealerInfoByEmail($email);
if (count($dealers) > 0) {
	$aDealer = $dealers[0];
	
	//load sum salary acc
	$now = getdate(); 
	$monthDate = "01-" . $now["mon"] . "-" . $now["year"];
	$monthDate = strtotime($monthDate);
	$arrsalary = $profileCustomerDAO->loadSumSalaryMonth($email, $monthDate);
	$sumsalary = 0;
	foreach($arrsalary as $entry) {
		$sumsalary = $entry[0];
	}
	$sumsalary = CommonFuns::changnumbermoney($sumsalary);
	
	
	$bankDao = new BankDAO();
	
	$banks = $bankDao->getBanks(-1);
	
?>
<script type="text/javascript" src="/js/jquery-1.8.3.js"></script>
<link rel="stylesheet" type="text/css" href="/css/jquery-ui.css">
<script type="text/javascript" src="/js/jquery-ui.js"></script>
<link rel="stylesheet" type="text/css" href="/css/reveal.css">
<script type="text/javascript" src="/js/jquery.reveal.js"></script>
<style>
.member-info-basic table tr td {border-bottom: 1px solid #98bf21;}
</style>

<div style="clear: both"></div>
<div class="info-left">
    <div class="member-info-basic">
        <div class="title-color-blue"></div>
        <div style="margin-left:20px; margin-right:20px;">
        	<br />
            <div class="info-member-title"><h1>THÔNG TIN CÁ NHÂN</h1></div>
            <div>
                <table style="font-size: 12px; border-collapse: collapse;" width="400px">
                    <tr>
                        <td width="101" class="info-basic-bold" height="30px">Mã khách hàng</td>
                        <td width="145" id="info-name"><strong><?php echo($aDealer->getIDCODE()) ?></strong></td>
                    </tr>
                    <tr>
                        <td width="101" class="info-basic-bold" height="30px">Họ và tên</td>
                        <td width="145" id="info-name"><?php echo($aDealer->getFullname()) ?></td>
                    </tr>
                    <tr>
                        <td class="info-basic-bold" height="30px">Giới tính</td>
                        <td id="info-gender"><?php if($aDealer->getGender() == true) { echo("Nam"); } else {echo("Nữ");} ?></td>
                    </tr>
                    <tr>
                        <td class="info-basic-bold" height="30px">Ngày tháng năm sinh</td>
                        <td id="info-dayofbith"><?php echo(CommonFuns::int_to_date($aDealer->getDayOfBirth())) ?></td>
                    </tr>
                    <tr>
                        <td class="info-basic-bold" height="30px">Tỉnh thành</td>
                        <td id="info-country"><?php echo($aDealer->getProvince()) ?></td>
                    </tr>
                    <tr>
                        <td class="info-basic-bold" height="30px">Địa chỉ cư trú</td>
                        <td id="info-address"><?php echo($aDealer->getAddress()) ?></td>
                    </tr>
                    <tr>
                        <td class="info-basic-bold" height="30px">Điện thoại di động</td>
                        <td id="info-phone"><?php echo($aDealer->getMobile()) ?></td>
                    </tr>
                    <tr>
                        <td class="info-basic-bold" height="30px">Điên thoại cố định</td>
                        <td id="info-homephone"><?php echo($aDealer->getHomePhone()) ?></td>
                    </tr>
                    <tr>
                        <td class="info-basic-bold" height="30px">Đơn vị công tác</td>
                        <td id="info-homephone"><?php echo($aDealer->getCompanyWork()) ?></td>
                    </tr>
                    <tr>
                        <td class="info-basic-bold" height="30px">Địa chỉ công tác</td>
                        <td id="info-homephone"><?php echo($aDealer->getAddressWork()) ?></td>
                    </tr>
                    <tr>
                        <td class="info-basic-bold" height="30px">Số tài khoản NH</td>
                        <td id="info-homephone"><?php echo($aDealer->getCardNumber()) ?></td>
                    </tr>
                    <tr>
                        <td class="info-basic-bold" height="30px">Tên ngân hàng</td>
                        <td id="info-homephone"><?php echo($aDealer->getBank()->getBankName()) ?></td>
                    </tr>
                    <tr>
                        <td class="info-basic-bold" height="30px" valign="top">Chi tiết công việc hiện tại</td>
                        <td id="info-homephone"><?php echo($aDealer->getInfoIntroWork()) ?></td>
                    </tr>
                    <tr>
                        <td class="info-basic-bold" height="30px" valign="top">Chi tiết kinh nghiệm công việc hiện tại </td>
                        <td id="info-homephone"><?php echo($aDealer->getKinhNghiem()) ?></td>
                    </tr>
                    <tr>
                        <td class="info-basic-bold" height="30px">Mật khẩu</td>
                        <td id="info-pass"><a href="#" data-reveal-id="changepassinfo">Thay đổi mật khẩu</a></td>
                    </tr>
                    <tr>
                        <td class="info-basic-bold" height="30px">Thu nhập hiện tại</td>
                        <td><?php echo($sumsalary) ?> đồng</td>
                    </tr>
                </table>
            </div>
            <div class="info-link-edit">
                <a href="#" id="updateinfo-link" data-reveal-id="updateinfo">Chỉnh sửa</a>
            </div>
        </div>
    </div>
</div>
<div class="info-right">
	<div class="member-info-basic">
        <div class="title-color-blue"></div>
        <div style="margin-left:20px; margin-right:20px; text-align: center;">
        	<br />
            <div class="info-member-title"><h1>TÍNH TỔNG THU NHẬP</h1></div>
            <div>
                <table style="font-size: 12px; border-collapse: collapse;" width="400px">
                    <tr>
                        <td width="51" class="info-basic-bold" height="30px" align="right">Từ ngày</td>
                        <td width="145" id="info-name"><input type="text" name="form_search_datestart" class="form_search_datestart" value="" placeholder="dd-mm-yyy" /></td>
                    </tr>
                    <tr>
                        <td class="info-basic-bold" height="30px" align="right">Đến ngày</td>
                        <td id="info-gender"><input type="text" name="form_search_dateend" class="form_search_dateend" value="" placeholder="dd-mm-yyy" /></td>
                    </tr>
                    <tr>
                        <td class="info-basic-bold" height="30px" colspan="2" align="center"><input style="margin-top: 5px; width: 100px;" type="button" value="Tính" class="btn-class-maytinh btn-class-calculator btnclr" /></td>
                    </tr>
                </table>
            </div>
            <div class="info-link-edit result-calculator-class">
                
            </div>
        </div>
    </div>
</div>
<div style="clear:both; height:15px;"></div>

<div id="updateinfo" class="reveal-modal">
    <div class="reveal-modal-title"><h1  style="margin-top: -10px; font-size: 18px;">CẬP NHẬT THÔNG TIN CÁ NHÂN</h1></div><br />
    <form name="updateinfodealer" id="updateinfodealer" action="" method="post">
        <div class="reveal-modal-main">
            <div style="padding: 0px 20px 10px;">
                <table>
                	<tr>
                        <td class="info-basic-bold" width="300px">Họ và tên</td>
                        <td><input value="<?php echo($aDealer->getFullname()) ?>" name="From_Name" id="From_Name" type="text" style="width:270px; height: 26px;" maxlength="500"><br><span id="errname" class="showms"></td>
                    </tr>
                    <tr>
                        <td class="info-basic-bold">Giới tính</td>
                        <td><select  style="width:270px; height: 26px;" name="Form_gender" id="Form_gender"><option value="1" <?php if ($aDealer->getGender() == true) { ?> selected <?php } ?>>Nam</option><option value="0" <?php if ($aDealer->getGender() != true) { ?> selected <?php } ?>>Nữ</option></select></td>
                    </tr>
                    <tr>
                        <td class="info-basic-bold" valign="top">Ngày tháng năm sinh</td>
                        <td><input value="<?php echo(CommonFuns::int_to_date($aDealer->getDayOfBirth())) ?>" name="From_dayofbirth" id="From_dayofbirth" type="text"  style="width:270px; height: 26px;"><br><span id="errdayofbirth" class="showms"></td>
                    </tr>
                    <tr>
                        <td class="info-basic-bold" valign="top">Tỉnh thành</td>
                        <td><select id="ProvinceID" name="From_Province"  style="width:270px; height: 26px;">
                            <option selected="selected" value="">--Vui lòng chọn--</option>
                            <option value="Hà Nội">Hà Nội</option><option value="Hồ Chí Minh">TP HCM</option><option value="Cần Thơ">TP Cần Thơ</option><option value="Đà Nẵng">TP Đà Nẵng</option><option value="Hải Phòng">TP Hải Phòng</option><option value="An Giang">An Giang</option><option value="Vũng Tàu">Bà Rịa - Vũng Tàu</option><option value="Bắc Giang">Bắc Giang</option><option value="Bắc Kạn">Bắc Kạn</option><option value="Bạc Liêu">Bạc Liêu</option><option value="Bắc Ninh">Bắc Ninh</option><option value="Bến Tre">Bến Tre</option><option value="Bình Định">Bình Định</option><option value="Bình Dương">Bình Dương</option><option value="Bình Phước">Bình Phước</option><option value="Bình Thuận">Bình Thuận</option><option value="Cà Mau">Cà Mau</option><option value="Cao Bằng">Cao Bằng</option><option value="Đăk Lăk">Đăk Lăk</option><option value="Đak Nông">Đak Nông</option><option value="Điện Biên">Điện Biên</option><option value="Đồng Nai">Đồng Nai</option><option value="Đồng Tháp">Đồng Tháp</option><option value="Gia Lai">Gia Lai</option><option value="Hà Giang">Hà Giang</option><option value="Hà Nam">Hà Nam</option><option value="Hà Tĩnh">Hà Tĩnh</option><option value="Hải Dương">Hải Dương</option><option value="Hậu Giang">Hậu Giang</option><option value="Hòa Bình">Hòa Bình</option><option value="Hưng Yên">Hưng Yên</option><option value="Khánh Hòa">Khánh Hòa</option><option value="Kiên Giang">Kiên Giang</option><option value="Kon Tum">Kon Tum</option><option value="Lai Châu">Lai Châu</option><option value="Lâm Đồng">Lâm Đồng</option><option value="Lạng Sơn">Lạng Sơn</option><option value="Lào Cai">Lào Cai</option><option value="Long An">Long An</option><option value="Nam Định">Nam Định</option><option value="Nghệ An">Nghệ An</option><option value="Ninh Bình">Ninh Bình</option><option value="Ninh Thuận">Ninh Thuận</option><option value="Phú Thọ">Phú Thọ</option><option value="Phú Yên">Phú Yên</option><option value="Quảng Bình">Quảng Bình</option><option value="Quảng Nam">Quảng Nam</option><option value="Quảng Ngãi">Quảng Ngãi</option><option value="Quảng Ninh">Quảng Ninh</option><option value="Quảng Trị">Quảng Trị</option><option value="Sóc Trăng">Sóc Trăng</option><option value="Sơn La">Sơn La</option><option value="Tây Ninh">Tây Ninh</option><option value="Thái Bình">Thái Bình</option><option value="Thái Nguyên">Thái Nguyên</option><option value="Thanh Hóa">Thanh Hóa</option><option value="Thừa Thiên Huế">Thừa Thiên Huế</option><option value="Tiền Giang">Tiền Giang</option><option value="Trà Vinh">Trà Vinh</option><option value="Tuyên Quang">Tuyên Quang</option><option value="Vĩnh Long">Vĩnh Long</option><option value="Vĩnh Phúc">Vĩnh Phúc</option><option value="Yên Bái">Yên Bái</option>  
                        </select></td>
                    </tr>
                    <tr>
                        <td class="info-basic-bold" valign="top">Địa chỉ cư trú</td>
                        <td><input value="<?php echo($aDealer->getAddress()) ?>" name="From_Address" id="From_Address" type="text"  style="width:270px; height: 26px;"><br><span id="erraddress" class="showms"></td>
                    </tr>
                    <tr>
                        <td class="info-basic-bold" valign="top">Điện thoại di động</td>
                        <td><input value="<?php echo($aDealer->getMobile()) ?>" name="From_Phone" id="From_Phone" type="text" style="width:270px; height: 26px;"><br><span id="errphone" class="showms"></td>
                    </tr>
                    <tr>
                        <td class="info-basic-bold" valign="top">Điện thoại cố định</td>
                        <td><input value="<?php echo($aDealer->getHomePhone()) ?>" name="From_HomePhone" id="From_HomePhone" type="text" style="width:270px; height: 26px;"><br><span id="errhomephone" class="showms"></td>
                    </tr>
                    <tr>
                        <td class="info-basic-bold" height="30px">Đơn vị công tác</td>
                        <td><input value="<?php echo($aDealer->getCompanyWork()) ?>" name="From_donvicongtac" id="From_donvicongtac" type="text" style="width:270px; height: 26px;"><br><span id="errdonvicongtac" class="showms"></td>
                    </tr>
                    <tr>
                        <td class="info-basic-bold" height="30px">Địa chỉ công tác</td>
                        <td><input value="<?php echo($aDealer->getAddressWork()) ?>" name="From_addresscongtac" id="From_addresscongtac" type="text" style="width:270px; height: 26px;"><br><span id="erraddresscongtac" class="showms"></td>
                    </tr>
                    <tr>
                        <td class="info-basic-bold" height="30px" valign="top">Chi tiết công việc hiện tại</td>
                        <td><textarea name="From_introwordcurent" id="From_introwordcurent" type="text" style="width: 270px; height: 70px; margin-bottom: 5px;"><?php echo($aDealer->getInfoIntroWork()) ?></textarea><br><span id="errintrowordcurent" class="showms"></td>
                    </tr>
                    <tr>
                        <td class="info-basic-bold" height="30px" valign="top">Chi tiết kinh nghiệm công việc hiện tại </td>
                        <td><textarea name="From_introkngwordcurent" id="From_introkngwordcurent" type="text" style="width: 270px; height: 70px;"><?php echo($aDealer->getKinhNghiem()) ?></textarea><br><span id="errintrokngwordcurent" class="showms"></td>
                    </tr>
                    <tr>
                        <td class="info-basic-bold" height="30px">Số tài khoản NH</td>
                        <td><input name="From_codebank" id="From_codebank" type="text" value="<?php echo($aDealer->getCardNumber()) ?>" style="width: 270px; height: 30px;" size="40"><br><span id="errcodebank" class="showms"></td>
                    </tr>
                    <tr>
                        <td class="info-basic-bold" height="30px">Tên ngân hàng</td>
                        <td><select style="width: 270px; height: 30px; padding: 5px;" name="From_namebank" id="From_namebank" class="From_namebank"><option value="">Chọn ngân hàng</option>
                        	<?php
							foreach ($banks as $entry) {
							?>
							<option value="<?php echo($entry->getBankID()) ?>" <?php if ($entry->getBankID() == $aDealer->getBank()->getBankID()) { ?> selected <?php } ?>>[<?php echo($entry->getBankID()) ?>]	<?php echo($entry->getBankName()) ?></option>
							<?php
							}
							?>
                        </select><br><span id="errnamebank" class="showms"></td>
                    </tr>
                    <tr>
                    	<td colspan="2" align="center"><input type="submit" value="Cập Nhật" class="btnclr" style="width: 100px;" /></td>
                    </tr>
                </table>
            </div>
            <div class="cl"></div>
        </div>
    </form>
    <a class="close-reveal-modal"><img src="/images/close_bnt.jpg" width="25px;" /></a>
</div>

<div id="changepassinfo" class="reveal-modal">
    <div class="reveal-modal-title"><h1 style="margin-top: -10px; font-size: 18px;">THAY ĐỔI MẬT KHẨU</h1></div><br />
    <form name="updatepassdealer" id="updatepassdealer" action="" method="post">
        <div class="reveal-modal-main">
            <div style="padding: 0px 60px 10px;">
            	<table>
                	<tr>
                        <td class="info-basic-bold">Mật khẩu cũ</td>
                        <td><input name="From_Passold" id="From_Passold" type="password" size="30" maxlength="200"><br><span id="errpassold" class="showms"></td>
                    </tr>
                    <tr>
                        <td class="info-basic-bold">Mật khẩu mới</td>
                        <td><input name="From_Passnew" id="From_Passnew" type="password" size="30" maxlength="200"><br><span id="errpassnew" class="showms"></td>
                    </tr>
                    <tr>
                        <td class="info-basic-bold">Nhập lại mật khẩu</td>
                        <td><input name="From_RePassNew" id="From_RePassNew" type="password" size="30" maxlength="200"><br><span id="errrepassnew" class="showms"></td>
                    </tr>
                    <tr>
                    	<td colspan="2" align="center"><input type="submit" class="btnclr" style="width: 100px;" value="Thay đổi" /></td>
                    </tr>
                </table>
            </div>
            <div class="cl"></div>
        </div>
    </form>
    <a class="close-reveal-modal"><img src="/images/close_bnt.jpg" width="25px;" /></a>
</div>

<div style="clear: both"></div>
<div style="float: left; width: 100%; margin-top: 20px; clear: right;">
    <div></div>
</div>
<script>
$( ".form_search_datestart" ).datepicker({
	defaultDate: "+1w",
	changeMonth: true,
	changeYear: true,
	numberOfMonths: 2,
	dateFormat: 'dd-mm-yy',
	maxDate: '<?php echo date("d-m-Y",time()); ?>',
	onClose: function( selectedDate ) {
		$( ".form_search_dateend" ).datepicker( "option", "minDate", selectedDate );
	}
});
$( ".form_search_dateend" ).datepicker({
	defaultDate: "+1w",
	changeMonth: true,
	changeYear: true,
	numberOfMonths: 2,
	dateFormat: 'dd-mm-yy',
	maxDate: '<?php echo date("d-m-Y",time()); ?>',
	onClose: function( selectedDate ) {
		if(selectedDate == "") {
			$( ".form_search_datestart" ).datepicker( "option", "maxDate", '<?php echo date("d-m-Y",time()); ?>' );
		} else {
			$( ".form_search_datestart" ).datepicker( "option", "maxDate", selectedDate );
		}
	}
});


$('.btn-class-calculator').click(function(e) {
    var datestart = $.trim($('.form_search_datestart').val());
	var dateend = $.trim($('.form_search_dateend').val());
	if(datestart != ""){
		$.ajax({
			type: "POST",
			url: "/control/AjaxCalculatorSalaryDealer.php",
			data:{'datestart': datestart, 'dateend': dateend},
			dataType: "json",
			success: function(response){
				if(response == 'true'){
					$('.result-calculator-class').html('<span style="color: red;">Kết nối đến server đã bị ngắt vui lòng đăng nhập lại để thực hiện chức năng này!</span>');
				} else {
					$('.result-calculator-class').html(response);
				}
			}
		});
	}
});

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
	$('#ProvinceID').val('<?php echo($aDealer->getProvince()) ?>');
	
	$('#updateinfodealer').submit(function(e) {
		var name = $.trim($('#From_Name').val());
		if(name.length == 0) {
			$('#errname').html('Vui Lòng Nhập Họ Và Tên');
			$('#From_Name').focus();
			return false;
		} else {
			$('#errname').html('');
		}
		var gender = $('#Form_gender').val();
		var birthday = $.trim($('#From_dayofbirth').val());
		if(birthday.length == 0) {
			$('#errdayofbirth').html('Vui Lòng Nhập Ngày Sinh');
			$('#From_dayofbirth').focus();
			return false;
		} else {
			$('#errdayofbirth').html('');
		}
		
		var phone = $.trim($('#From_Phone').val());
		var re_phone = /^([0-9]+(([0-9])?[0-9]*)*){9,11}$/;
		if(!(re_phone.test(phone))) {
			$('#errphone').html('Số Điện Thoại Không Hợp Lệ và chỉ được phép 11 ký tự(0-9)');
			$('#From_Phone').focus();
			return false;
		} else {
			$('#errphone').html('');
		}
		
		var homephone = $.trim($('#From_HomePhone').val());
		if(homephone.length > 0) {
			if(!(re_phone.test(homephone))) {
				$('#errhomephone').html('Số Điện Thoại Cố Định Không Hợp Lệ và chỉ được phép 11 ký tự(0-9)');
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
			$('#erraddress').html('Vui Lòng Nhập Địa Chỉ Liên Hệ');
			$('#From_Address').focus();
			return false;
		} else {
			$('#erraddress').html('');
		}
		var provice = $.trim($('#ProvinceID').val());
		if(provice.length == 0) {
			$('#erreprovice').html('Vui Lòng Chọn Tỉnh Thành');
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
		
		
		$('body').append('<div class="reveal-modal-bg"></div>');
		$('#updateinfo').hide();
		$.ajax({
			type: "POST",
			url: "/control/AjaxUpdateInfoDealer.php",
			data:{act: 'updainfo', 'namere': name, 'gend': gender, 'birthdayre': birthday, 'phonere': phone, 'homephonere': homephone, 'addressre': address, 'provicere': provice, 'dvct': donvicongtac, 'dcct': diachicongtac, 'gtcv': introwork, 'gtknlv': introknwork, 'stk': codebank, 'ngh': bank},
			dataType: "json",
			success: function(response){
				if(response == 'true'){
					/*new Messi('Cập Nhật thành công thông tin cá nhân', {
						title: 'Cập Nhật Thông Tin Làm Đại Lý',
						titleClass: 'info', //
						buttons: [{
							id: 0, 
							label: 'Đóng', 
							val: 'X'
						}]
					});*/
					alert('Cập Nhật thành công thông tin cá nhân');
					location.reload();
					//window.location = 'index.php?cont=profile&ac=ca-nhan';
				} else {
					$('#updateinfo').show();
					alert('Cập Nhật thất bại, bạn vui lòng thử lại sau!');
					/*new Messi('Cập Nhật thất bại, bạn vui lòng thử lại sau!', {
						title: 'Cập Nhật Thông Làm Đại Lý',
						titleClass: 'anim error', //anim error
						buttons: [{
							id: 0, 
							label: 'Đóng', 
							val: 'X'
						}]
					});*/
				}
				
			}
		});
		
		return false;
    });
	
	$('#updatepassdealer').submit(function(e) {
        var passold = $('#From_Passold').val();
		var passnew = $('#From_Passnew').val();
		var passrenew = $('#From_RePassNew').val();
		
		if(passold.length == 0) {
			$('#errpassold').html('Vui lòng nhập mật khẩu củ');
			$('#From_Passold').focus();
			return false;
		} else {
			$('#errpassold').html('');
		}
		
		if(passnew.length < 6) {
			$('#errpassnew').html('Vui Lòng Nhập Mật Khẩu Và Ít Nhất Là 6 Ký Tự');
			$('#From_Passnew').focus();
			return false;
		} else {
			$('#errpassnew').html('');
		}
		
		if(passnew != passrenew) {
			$('#errrepassnew').html('Mật Khẩu Mới Không Trùng Khớp Vui Lòng Kiểm Tra Lại');
			$('#From_RePassNew').focus();
			return false;
		} else {
			$('#errrepassnew').html('');
		}
		
		if(passold == passnew) {
			$('#errpassold').html('Mật khẩu mới trùng với mật khẩu củ');
			$('#From_Passold').focus();
			return false;
		} else {
			$('#errpassold').html('');
		}
		
		$('body').append('<div class="reveal-modal-bg"></div>');
		$('#changepassinfo').hide();
		$.ajax({
			type: "POST",
			url: "/control/AjaxUpdateInfoDealer.php",
			data:{act: 'updainfopas', 'passoldre': passold, 'passnewre': passnew},
			dataType: "json",
			success: function(response){
				if(response == 'notavali'){
					$('#changepassinfo').show();
					alert('Mật khẩu củ không khớp, vui lòng thử lại');
					/*new Messi('Mật khẩu củ không khớp, vui lòng thử lại', {
						title: 'Cập Nhật Mật Khẩu',
						titleClass: 'anim error',
						buttons: [{
							id: 0, 
							label: 'Đóng', 
							val: 'X'
						}]
					});*/
				} else if(response == 'true'){
					$('.close-reveal-modal').click();
					$('#From_Passold').val('');
					$('#From_Passnew').val('');
					$('#From_RePassNew').val('');
					alert('Cập Nhật thành công mật khẩu mới');
					/*new Messi('Cập Nhật thành công mật khẩu mới', {
						title: 'Cập Nhật Mật Khẩu',
						titleClass: 'info',
						buttons: [{
							id: 0, 
							label: 'Đóng', 
							val: 'X'
						}]
					});*/
				} else {
					$('#changepassinfo').show();
					alert('Cập Nhật thất bại, bạn vui lòng thử lại!');
					/*new Messi('Cập Nhật thất bại, bạn vui lòng thử lại!', {
						title: 'Cập Nhật Mật Khẩu',
						titleClass: 'anim error', //anim error
						buttons: [{
							id: 0, 
							label: 'Đóng', 
							val: 'X'
						}]
					});*/
				}
				
			}
		});
		
		return false;
    });
});
</script>

<?php
}
?>