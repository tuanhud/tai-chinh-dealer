<?php

/*function getDealerInfoByEmail($email) {
	$con = new ConnectDB();
	
	$sql = "SELECT r.idcode, r.regis_email, r.regis_name, r.gender, r.dayofbirth, r.mobile, r.homephone, r.address, r.province, r.dateregis, r.isaccept, r.dateaccept, r.islock, r.companywork, r.addresswork, r.introinfowork, r.introinfokinhnghiem, r.cardnumber, r.bankid, b.bankname FROM registrationbank AS r, banks AS b WHERE r.bankid=b.bankid AND regis_email='".$email."'";
	return $con -> getvalueString($sql);
}

function int_to_date($int)
{
    $time  = date("d/m/Y", $int);
    return $time;
}*/

if(isset($_GET['id'])) {
	$email = $_GET['id'];
	
	$arrdealer = $dealerDao->getDealerInfoByEmail($email);
	
	if(count($arrdealer) > 0) {
?>
<style>
	.abcasakj td {
		border: 1px solid;
		padding: 5px;
	}
</style>
<h3>Chi Tiết Hồ Sơ "<?php echo($arrdealer[0]->getFullname()) ?>"</h3>
<div class="abcasakj">
	<table width="700px">
    	<tr>
        	<td width="150px">Họ Tên Khách Hàng</td>
            <td><strong><?php echo($arrdealer[0]->getFullname()) ?></strong></td>
        </tr>
        <tr>
        	<td>ID Code</td>
            <td><strong><?php echo($arrdealer[0]->getIDCODE()) ?></strong></td>
        </tr>
        <tr>
        	<td>Giới Tính</td>
            <td><?php if($arrdealer[0]->getGender()) echo("Nam"); else echo("Nữ"); ?></td>
        </tr>
        <tr>
        	<td>Email</td>
            <td><strong><?php echo($arrdealer[0]->getEmailDealer()) ?></strong></td>
        </tr>
        <tr>
        	<td>Ngày Sinh</td>
            <td><?php echo(CommonFuns::int_to_date($arrdealer[0]->getDayOfBirth())) ?></td>
        </tr>
        <tr>
        	<td>Điện Thoại</td>
            <td><?php echo($arrdealer[0]->getMobile()) ?></td>
        </tr>
        <tr>
        	<td>ĐT Bàn</td>
            <td><?php echo($arrdealer[0]->getHomePhone()) ?></td>
        </tr>
        <tr>
        	<td>Địa Chỉ</td>
            <td><?php echo($arrdealer[0]->getAddress()) ?></td>
        </tr>
        <tr>
        	<td>Tỉnh Thành</td>
            <td><?php echo($arrdealer[0]->getProvince()) ?></td>
        </tr>
        <tr>
        	<td>Đơn vị công tác</td>
            <td><?php echo($arrdealer[0]->getCompanyWork()) ?></td>
        </tr>
         <tr>
        	<td>Địa chỉ công tác</td>
            <td><?php echo($arrdealer[0]->getAddressWork()) ?></td>
        </tr>
        <tr>
        	<td>Số tài khoản NH</td>
            <td><?php echo($arrdealer[0]->getCardNumber()) ?></td>
        </tr>
        <tr>
        	<td>Tên ngân hàng</td>
            <td><?php echo($arrdealer[0]->getBank()->getBankName()) ?></td>
        </tr>
        <tr>
        	<td valign="top">Chi tiết công việc hiện tại</td>
            <td valign="top"><?php echo($arrdealer[0]->getInfoIntroWork()) ?></td>
        </tr>
        <tr>
        	<td valign="top">Chi tiết kinh nghiệm công việc hiện tại</td>
            <td valign="top"><?php echo($arrdealer[0]->getKinhNghiem()) ?></td>
        </tr>
        <tr>
        	<td>Ngày Đăng Ký</td>
            <td><?php echo(CommonFuns::int_to_date($arrdealer[0]->getDateCreate())) ?></td>
        </tr>
        <tr>
        	<td>Ngày Kích Hoạt</td>
            <td><?php if($arrdealer[0]->isAccept()) echo(CommonFuns::int_to_date($arrdealer[0]->getDateAccept())); ?></td>
        </tr>
        <tr>
        	<td>Trạng Thái</td>
            <td><?php if(!$arrdealer[0]->isAccept()) { echo('Chưa Kích Hoạt'); } else { if(!$arrdealer[0]->isLock()) { echo('Tài Khoản Đang Sử Dụng'); } else { echo('Tài Khoản Đã Bị Khóa'); } } ?></td>
        </tr>
        <tr>
        	<td>Chức Năng</td>
            <td><?php if(!$arrdealer[0]->isAccept()) { echo('<img src="/images/activity.jpg" style="cursor:pointer;" title="Kích Hoạt" class="class-kichhoat-link" idacc="'.$arrdealer[0]->getEmailDealer().'" />'); } else { if(!$arrdealer[0]->isLock()) { echo('<img src="/images/lockicon.png" style="cursor:pointer;" title="Khóa Tài Khoản" class="class-lockacc-link" idacc="'.$arrdealer[0]->getEmailDealer().'" /> | <a href="/admin/?content=daily&p=ho-so-khach-hang&mail='.$arrdealer[0]->getIDCODE().'">Xem Hồ Sơ Khách Hàng Của '.$arrdealer[0]->getFullname().'</a>'); } else { echo('<img src="/images/unclockicon.png" style="cursor:pointer;" title="Mở Khóa Tài Khoản" class="class-unlockacc-link" idacc="'.$arrdealer[0]->getEmailDealer().'" /> | <a href="/admin/?content=daily&p=ho-so-khach-hang&mail='.$arrdealer[0]->getIDCODE().'">Xem Hồ Sơ Khách Hàng Của '.$arrdealer[0]->getFullname().'</a>'); } } ?></td>
        </tr>
    </table>
</div>

<script>

$(document).ready(function(e) {
	$(document).on('click', '.class-kichhoat-link', function() {
		elem = $(this);
		idacc = elem.attr('idacc');
		$.ajax({
			url: "/admin/control/ajax/AjaxDealer.php",
			type: "post",
			data: {act:'acti', idre: idacc},
			dataType:"json",
			success: function(data) {
				if(data == "success") {
					alert("Cập nhật dữ liệu thành công");
					location.reload();
				} else {
					alert("Cập nhật dữ liệu không thất bại");
				}
			}
		});
	});
	
    $(document).on('click', '.class-lockacc-link', function() {
		elem = $(this);
		idacc = elem.attr('idacc');
		$.ajax({
			url: "/admin/control/ajax/AjaxDealer.php",
			type: "post",
			data: {act:'lockacc', idre: idacc},
			dataType:"json",
			success: function(data) {
				if(data == "success") {
					alert("Cập nhật dữ liệu thành công");
					location.reload();
				} else {
					alert("Cập nhật dữ liệu không thất bại");
				}
			}
		});
	});
	
	$(document).on('click', '.class-unlockacc-link', function() {
		elem = $(this);
		idacc = elem.attr('idacc');
		$.ajax({
			url: "/admin/control/ajax/AjaxDealer.php",
			type: "post",
			data: {act:'unlockacc', idre: idacc},
			dataType:"json",
			success: function(data) {
				if(data == "success") {
					alert("Cập nhật dữ liệu thành công");
					location.reload();
				} else {
					alert("Cập nhật dữ liệu không thất bại");
				}
			}
		});
	});
});

</script>

<?php
	}
}

?>