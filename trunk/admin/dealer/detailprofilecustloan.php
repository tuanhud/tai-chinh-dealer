<?php
require_once ("../src/db/connectdatabase.php");

function getProfileCus($idpro) {
	$con = new ConnectDB();
	
	$sql = "Select p.idpro, p.regis_email, p.namecustomer, p.province, tl.namepurp, p.infopro, p.linkfileattach, p.inforequest, p.statusquo, p.amount1, p.amount2, p.amount3, p.isgnore, p.datecreate, p.dateupdate, p.phonenumber FROM profilecustomer AS p, purposeloan AS tl WHERE p.loantype=tl.idpurpose AND p.idpro=".$idpro;
	return $con -> getvalueString($sql);
}

function int_to_date($int)
{
    $time  = date("d/m/Y", $int);
    return $time;
}

if(isset($_GET['rei'])) {
	$idpro = $_GET['rei'];
	$arrprofile = getProfileCus($idpro);
	if(count($arrprofile) > 0) {
?>
<style>
.reveal-modal-bg { 
	position: fixed; 
	height: 100%;
	width: 100%;
	background: #000;
	background: rgba(0,0,0,.8);
	z-index: 100;
	display: none;
	top: 0;
	left: 0; 
}
#showlistbankdeletedlightbox {
	display: none;
	top: 0px; 
	left: 50%;
	margin-left: -300px;
	width: 600px;
	background: #eee url(../modal-gloss.png) no-repeat -200px -80px;
	position: absolute;
	z-index: 101;
	padding: 0px 0px 0px;
	-moz-border-radius: 5px;
	-webkit-border-radius: 5px;
	border-radius: 5px;
	-moz-box-shadow: 0 0 10px rgba(0,0,0,.4);
	-webkit-box-shadow: 0 0 10px rgba(0,0,0,.4);
	-box-shadow: 0 0 10px rgba(0,0,0,.4);
}

#showlistbankdeletedlightbox .close-reveal-modal {
	font-size: 22px;
	line-height: .5;
	position: absolute;
	top: 8px;
	right: 11px;
	color: #aaa;
	text-shadow: 0 -1px 1px rbga(0,0,0,.6);
	font-weight: bold;
	cursor: pointer;
} 
.reveal-modal-title {
    background: url('../images/box-title-blue.jpg') repeat-x;
    height: 50px;
    text-align: center;
	-moz-border-radius: 5px;
	-webkit-border-radius: 5px;
}

.reveal-modal-title h1 {
    color: white;
}

.reveal-modal-main {
    padding: 20px;
	margin-top:-10px;
	min-height: 500px;
	max-height: 500px;
	overflow-y: scroll;
}
</style>
<h3>Chi Tiết Hồ Sơ Khách Hàng <?php echo($arrprofile[0][2]) ?></h3>
<div style="width:900px;">
	<table width="600px">
    	<tr>
        	<th align="left" width="150px">Tên Khách Hàng</th>
            <td><strong><?php echo($arrprofile[0][2]) ?></strong></td>
        </tr>
        <tr><td colspan="2"><hr style="border: 1px solid; margin-top:4px; margin-bottom: 4px;"></td></tr>
        <tr>
        	<th align="left" width="150px">Số điện thoại</th>
            <td><strong><?php echo($arrprofile[0][15]) ?></strong></td>
        </tr>
        <tr><td colspan="2"><hr style="border: 1px solid; margin-top:4px; margin-bottom: 4px;"></td></tr>
        <tr>
        	<th align="left">Tỉnh Thành</th>
            <td><?php echo($arrprofile[0][3]) ?></td>
        </tr>
        <tr><td colspan="2"><hr style="border: 1px solid; margin-top:4px; margin-bottom: 4px;"></td></tr>
        <tr>
        	<th align="left">Loại Vay</th>
            <td><?php echo($arrprofile[0][4]) ?></td>
        </tr>
        <tr><td colspan="2"><hr style="border: 1px solid; margin-top:4px; margin-bottom: 4px;"></td></tr>
        <tr>
        	<th align="left" valign="top">TT Tóm Tắt</th>
            <td><?php echo($arrprofile[0][5]) ?></td>
        </tr>
        <tr><td colspan="2"><hr style="border: 1px solid; margin-top:4px; margin-bottom: 4px;"></td></tr>
        <tr>
        	<th align="left" valign="top">File Đính Kèm</th>
            <td>
                <ol>
                <?php
				if($arrprofile[0][6] != "") {
					echo('<strong>Download file đính kèm</strong><br />');
					$pieces = explode(",", $arrprofile[0][6]);
					foreach($pieces as $tempfile) {
						echo('<li><a href="../'.$tempfile.'">Tập Tin '.$tempfile.'</a></li>');
					}
				} else {
					echo('<strong>Không có file đính kèm</strong><br />');
				}
                ?>
            	</ol>
            </td>
        </tr>
        <tr><td colspan="2"><hr style="border: 1px solid; margin-top:4px; margin-bottom: 4px;"></td></tr>
        <tr>
        	<th align="left">Trạng Thái</th>
            <td><?php echo($arrprofile[0][8]) ?></td>
        </tr>
        <tr><td colspan="2"><hr style="border: 1px solid; margin-top:4px; margin-bottom: 4px;"></td></tr>
        <tr>
        	<th align="left" valign="top">TT Phản Hồi</th>
            <td><?php echo($arrprofile[0][7]) ?></td>
        </tr>
        <tr><td colspan="2"><hr style="border: 1px solid; margin-top:4px; margin-bottom: 4px;"></td></tr>
        <tr>
        	<th align="left">Số Tiền Vay</th>
            <td><?php echo($arrprofile[0][9]) ?></td>
        </tr>
        <tr><td colspan="2"><hr style="border: 1px solid; margin-top:4px; margin-bottom: 4px;"></td></tr>
        <tr>
        	<th align="left">Ngân Hàng Vay</th>
            <td><?php echo($arrprofile[0][10]) ?></td>
        </tr>
        <tr><td colspan="2"><hr style="border: 1px solid; margin-top:4px; margin-bottom: 4px;"></td></tr>
        <tr>
        	<th align="left">Hoa Hồng(%)</th>
            <td><?php echo($arrprofile[0][11]) ?></td>
        </tr>
        <tr><td colspan="2"><hr style="border: 1px solid; margin-top:4px; margin-bottom: 4px;"></td></tr>
        <tr>
        	<th align="left">Ngày Cập Nhật</th>
            <td><?php if ($arrprofile[0][14] != "") echo(int_to_date($arrprofile[0][14])); ?></td>
        </tr>
        
        <tr><td colspan="2"><hr style="border: 1px solid; margin-top:4px; margin-bottom: 4px;"></td></tr>
        <tr>
        	<th colspan="2"><input class="class-edit-detail-profile-link" type="button" value="Chỉnh Sửa" style="border-radius: 5px; padding:5px; width:100px; background:#03F; color:#FFF; font-weight:bold;" /></th>
        </tr>
    </table>
</div>

<div style="clear:both;"></div>
<div class="reveal-modal-bg"></div>
<div id="showlistbankdeletedlightbox">
	<div class="reveal-modal-title"><h1>Cập Nhật Thông Tin Hồ Sơ</h1></div><br />
    <div class="reveal-modal-main">
    	<table>
        	<tr>
            	<th align="left" width="120px">Tên Khách Hàng</th>
                <td><input style="height:30px; width:280px" name="From_NameCus" id="From_NameCus" value="<?php echo($arrprofile[0][2]) ?>" type="text" size="40" maxlength="500"></td>
            </tr>
            <tr>
            	<th align="left" width="120px">Số điện thoại</th>
                <td><input style="height:30px; width:280px" name="From_phoneCus" value="<?php echo($arrprofile[0][15]) ?>" id="From_phoneCus" type="text" size="40" maxlength="100"></td>
            </tr>
            <tr>
            	<th align="left" width="120px">Ngày Đăng</th>
                <td><?php echo(int_to_date($arrprofile[0][13])) ?></td>
            </tr>
            <tr>
            	<th align="left" width="120px" valign="top">TT Tóm Tắt</th>
                <td><?php echo($arrprofile[0][5]) ?></td>
            </tr>
            <tr><td colspan="2"><hr style="border: 1px solid thin; margin-top:4px; margin-bottom: 4px;"></td></tr>
            <tr>
            	<th align="left" width="120px" valign="top">Trạng Thái</th>
                <td>
                <select id="form_statusupdate" style="height: 23px; width:200px; margin-right:10px;"><option value="Chưa Kiểm Tra">Chưa Kiểm Tra</option><option value="Chờ kiểm tra">Chờ kiểm tra</option><option value="Đang kiểm tra">Đang kiểm tra</option><option value="Đang chờ bổ sung">Đang chờ bổ sung</option><option value="Đang thẩm định">Đang thẩm định</option><option value="Hoàn Tất">Hoàn Tất</option><option value="Từ chối">Từ chối</option></select>
                </td>
            </tr>
            <tr>
            	<th align="left" width="120px" valign="top">TT Phản Hồi</th>
                <td><input type="hidden" value="<?php echo($arrprofile[0][7]) ?>" name="inforequesttemp" id="inforequesttemp" /><textarea style="resize:none; width: 100%;" rows="4" name="form-inforequest" class="form-inforequest" id="form-inforequest"></textarea></td>
            </tr>
            <tr>
            	<th align="left" width="120px" valign="top">Số Tiền Vay</th>
                <td><input value="<?php echo($arrprofile[0][9]) ?>" name="form_amoun1" id="form_amoun1" style="height: 23px; width:200px; margin-right:10px; padding:5px;" maxlength="30" /></td>
            </tr>
            <tr>
            	<th align="left" width="120px" valign="top">Ngân Hàng Vay</th>
                <td><input value="<?php echo($arrprofile[0][10]) ?>" name="form_amoun2" id="form_amoun2" style="height: 23px; width:200px; margin-right:10px; padding:5px;" maxlength="500" /></td>
            </tr>
            <tr>
            	<th align="left" width="120px" valign="top">Hoa Hồng</th>
                <td><input value="<?php echo($arrprofile[0][11]) ?>" name="form_amoun2" id="form_amoun3" maxlength="30" style="height: 23px; width:200px; margin-right:10px; padding:5px;" /></td>
            </tr>
            <tr>
                <th colspan="2"><input class="class-update-detail-profile-link" type="button" value="Cập Nhật" style="border-radius: 5px; padding:5px; width:100px; background:#03F; color:#FFF; font-weight:bold;" /></th>
            </tr>
        </table>
    </div>
    <a class="close-reveal-modal">&#215;</a>
</div>
<script src="../ckeditor/ckeditor.js"></script>
<script>
$('#form_statusupdate').val('<?php echo($arrprofile[0][8]) ?>');
$(document).on('click', '.close-reveal-modal', function(e) {
		clostshowbankdeleted();
	});
	
	$(document).on('click', '.reveal-modal-bg', function(e) {
		clostshowbankdeleted();
	});
	
	function clostshowbankdeleted() {
		$('.reveal-modal-bg').hide();
		$('#showlistbankdeletedlightbox').hide();
	}
	$(document).on('click', '.class-edit-detail-profile-link', function(e) {
		$('.reveal-modal-bg').show();
		$('#showlistbankdeletedlightbox').show();
	});
	$('.class-update-detail-profile-link').click(function(e) {
		var inforequest = $('#inforequesttemp').val();
		var id = '<?php echo($idpro) ?>';
		var namecus = $('#From_NameCus').val();
		var phonecus = $('#From_phoneCus').val();
		var status = $('#form_statusupdate').val();
		var contentrequest = CKEDITOR.instances['form-inforequest'].getData();
		var amount1 = $('#form_amoun1').val();
		var re_num = /^([^0-9]*)$/;
		
		if(namecus.length == 0) {
			alert('Vui lòng nhập tên khách hàng');
			$('#From_NameCus').focus();
			return false;
		}
		
		if(phonecus.length == 0) {
			alert('Vui lòng nhập số điện thoại khách hàng');
			$('#From_phoneCus').focus();
			return false;
		}
		
		if(re_num.test(amount1)) {
			alert("Vui lòng nhập số tiền vay và phải là số");
			$('#form_amoun1').focus();
			return false;
		}
		var amount2 = $.trim($('#form_amoun2').val());
		
		var amount3 = $('#form_amoun3').val();
		if(re_num.test(amount3)) {
			alert("Vui lòng nhập phần trăm hoa hồng và phải là số");
			$('#form_amoun3').focus();
			return false;
		}
		$.ajax({
			url: "../src/ajax/ajaxprofileloan.php",
			type: "post",
			data: {act:'edit', rei: id, name: namecus, phone: phonecus, stre: status, cont: contentrequest, amo1: amount1, amo2: amount2, amo3: amount3, ifretemp: inforequest},
			dataType:"json",
			success: function(response) {
				if(response == true) {
					alert("Cập Nhật Hồ Sơ Khách Hàng Thành Công");
					location.reload();
				} else {
					alert("Quá trình cập nhật xảy ra sự cố, vui lòng thử lại");
				}
			}
		});
	});
$(document).ready(function(e) {
	CKEDITOR.replace('form-inforequest');
});
</script>
<?php
	}
}
?>