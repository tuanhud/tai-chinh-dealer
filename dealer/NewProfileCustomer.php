<?php
$typeLoanDAO = new TypeLoanDAO();
$typeLoanList = $typeLoanDAO->getTypeLoans(0);
?>
<div>
	<div style="width: 100%; text-align: center;"><h1 style="font-size: 24px; text-transform: uppercase;">Login hồ sơ mới</h1></div><br />
    <form name="createprofilecustomerdealer" id="createprofilecustomerdealer" action="/control/CreateProfileDealer.php" method="post" enctype="multipart/form-data">
        <div style="width: 500px; margin: auto;">
            <div style="padding: 0px 30px 10px;">
                <table style="font-size: 12px">
                	<tr>
                        <td class="info-basic-bold" width="300px">Tên khách hàng</td>
                        <td><input type="hidden" name="act" value="add" /><input style="height:30px; width:280px" name="From_NameCus" id="From_NameCus" type="text" size="40" maxlength="500"><br><span id="errnamecus" class="showms"></td>
                    </tr>
                    <tr>
                        <td class="info-basic-bold" width="300px">Số điện thoại</td>
                        <td><input style="height:30px; width:280px" name="From_phoneCus" id="From_phoneCus" type="text" size="40" maxlength="100"><br><span id="errphonecus" class="showms"></td>
                    </tr>
                    <tr>
                        <td class="info-basic-bold" valign="top">Khu vực</td>
                        <td><select id="ProvinceIDcus" name="From_Provincecus" style="height:30px; width:288px; padding:5px;">
                            <option selected="selected" value="">--Chọn--</option>
                            <option value="Hà Nội">Hà Nội</option><option value="Hồ Chí Minh">TP HCM</option><option value="Cần Thơ">TP Cần Thơ</option><option value="Đà Nẵng">TP Đà Nẵng</option><option value="Hải Phòng">TP Hải Phòng</option><option value="An Giang">An Giang</option><option value="Vũng Tàu">Bà Rịa - Vũng Tàu</option><option value="Bắc Giang">Bắc Giang</option><option value="Bắc Kạn">Bắc Kạn</option><option value="Bạc Liêu">Bạc Liêu</option><option value="Bắc Ninh">Bắc Ninh</option><option value="Bến Tre">Bến Tre</option><option value="Bình Định">Bình Định</option><option value="Bình Dương">Bình Dương</option><option value="Bình Phước">Bình Phước</option><option value="Bình Thuận">Bình Thuận</option><option value="Cà Mau">Cà Mau</option><option value="Cao Bằng">Cao Bằng</option><option value="Đăk Lăk">Đăk Lăk</option><option value="Đak Nông">Đak Nông</option><option value="Điện Biên">Điện Biên</option><option value="Đồng Nai">Đồng Nai</option><option value="Đồng Tháp">Đồng Tháp</option><option value="Gia Lai">Gia Lai</option><option value="Hà Giang">Hà Giang</option><option value="Hà Nam">Hà Nam</option><option value="Hà Tĩnh">Hà Tĩnh</option><option value="Hải Dương">Hải Dương</option><option value="Hậu Giang">Hậu Giang</option><option value="Hòa Bình">Hòa Bình</option><option value="Hưng Yên">Hưng Yên</option><option value="Khánh Hòa">Khánh Hòa</option><option value="Kiên Giang">Kiên Giang</option><option value="Kon Tum">Kon Tum</option><option value="Lai Châu">Lai Châu</option><option value="Lâm Đồng">Lâm Đồng</option><option value="Lạng Sơn">Lạng Sơn</option><option value="Lào Cai">Lào Cai</option><option value="Long An">Long An</option><option value="Nam Định">Nam Định</option><option value="Nghệ An">Nghệ An</option><option value="Ninh Bình">Ninh Bình</option><option value="Ninh Thuận">Ninh Thuận</option><option value="Phú Thọ">Phú Thọ</option><option value="Phú Yên">Phú Yên</option><option value="Quảng Bình">Quảng Bình</option><option value="Quảng Nam">Quảng Nam</option><option value="Quảng Ngãi">Quảng Ngãi</option><option value="Quảng Ninh">Quảng Ninh</option><option value="Quảng Trị">Quảng Trị</option><option value="Sóc Trăng">Sóc Trăng</option><option value="Sơn La">Sơn La</option><option value="Tây Ninh">Tây Ninh</option><option value="Thái Bình">Thái Bình</option><option value="Thái Nguyên">Thái Nguyên</option><option value="Thanh Hóa">Thanh Hóa</option><option value="Thừa Thiên Huế">Thừa Thiên Huế</option><option value="Tiền Giang">Tiền Giang</option><option value="Trà Vinh">Trà Vinh</option><option value="Tuyên Quang">Tuyên Quang</option><option value="Vĩnh Long">Vĩnh Long</option><option value="Vĩnh Phúc">Vĩnh Phúc</option><option value="Yên Bái">Yên Bái</option></select><br><span id="errcontrycus" class="showms"></td>
                    </tr>
                    <tr>
                        <td class="info-basic-bold" valign="top">Sản phẩm</td>
                        <td><select name="form_typeloan" id="form_typeloan"  style="height:30px; width:288px; padding:5px;"><option value="">Vui Lòng Chọn</option>
                        	<?php
							foreach ($typeLoanList as $atypeLoan) {
								
							?>
								<option value="<?php echo ($atypeLoan->getLoanID()); ?>"><?php echo ($atypeLoan->getLoanName()); ?></option>
							<?php
							}
							?>
                        </select><br><span id="errtypeloan" class="showms"></td>
                    </tr>
                    <tr>
                        <td class="info-basic-bold" valign="top">Thông tin khách hàng</td>
                        <td></td>
                    </tr>
                    <tr>
                    	<td colspan="2"><textarea name="form_infointro" id="form_infointro" class="form_infointro" style="resize:none; width: 100%; height: 100px; font-family: Arial, Helvetica, sans-serif;" rows="4"></textarea><br><span id="errinfocus" class="showms"></td>
                    </tr>
                    <tr>
                        <td class="info-basic-bold" valign="top">Upload hồ sơ khách hàng trực tuyến</td>
                        <td><input type="file" name="filenameprofile[]" id="filenameprofile" multiple="multiple" /><br><span style="font-size:10px; color: #06F;">Dung lượng cho phép tối đa là 2MB và *.rar , *.zip, *.jpg, *.png, *.doc, *.xls</span><br /><span id="errfileprofile" class="showms"></td>
                    </tr>
                    <tr>
                    	<td colspan="2" align="center"><input type="submit" value="Login" class="btn-menu-action" style="width: 100px; line-height: 20px;" /></td>
                    </tr>
                </table>
            </div>
            <div class="cl"></div>
        </div>
    </form>
</div>
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
		
		$('#createprofilecustomerdealer').submit(function(e) {
			var namecus = $.trim($('#From_NameCus').val());
			var phonecus = $.trim($('#From_phoneCus').val());
			var country = $('#ProvinceIDcus').val();
			var tloan = $('#form_typeloan').val();
			var infointro = CKEDITOR.instances['form_infointro'].getData();
			
			
			if(namecus.length == 0) {
				$('#errnamecus').html('Vui lòng nhập tên khách hàng');
				$('#From_NameCus').focus();
				return false;
			} else {
				$('#errnamecus').html('');
			}
			
			if(phonecus.length == 0) {
				$('#errphonecus').html('Vui lòng nhập số điện thoại khách hàng');
				$('#From_phoneCus').focus();
				return false;
			} else {
				$('#errphonecus').html('');
			}
			
			if(country == "") {
				$('#errcontrycus').html('Vui lòng chọn tỉnh thành của khách hàng');
				$('#ProvinceIDcus').focus();
				return false;
			} else {
				$('#errcontrycus').html('');
			}
			
			if(tloan == "") {
				$('#errtypeloan').html('Vui lòng chọn loại hình khách hàng muốn vay');
				$('#form_typeloan').focus();
				return false;
			} else {
				$('#errtypeloan').html('');
			}
			
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