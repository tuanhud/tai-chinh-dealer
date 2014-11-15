<?php
$email = "";
$namekey = "";
$mobile = "";
$city = "";
$makh = "";

if(isset($_GET['makh'])) {
	$makh = $_GET['makh'];
}

if(isset($_GET['mail'])) {
	$email = $_GET['mail'];
}

if(isset($_GET['name'])) {
	$namekey = $_GET['name'];
}

if(isset($_GET['mob'])) {
	$mobile = $_GET['mob'];
}

if(isset($_GET['city'])) {
	$city = $_GET['city'];
}

$tempsql = "";
$status = "";
if(isset($_GET['st'])) {
	$status = $_GET['st'];
	if($status == 1) {
		$tempsql = " AND D.".CommonVals::$IsAccept."=0";
	} else if($status == 2) {
		$tempsql = " AND D.".CommonVals::$IsLock."=1";
	} else if($status == 3) {
		$tempsql = " AND D.".CommonVals::$IsAccept."=1 AND D.".CommonVals::$IsLock."=0";
	}
}

$datestart = "";
$dateend = "";
if(isset($_GET['start'])) {
	$datestart = $_GET['start'];
	if($datestart != "")
		$tempsql .= " AND D.".CommonVals::$DateRegis." >= ".strtotime($datestart);
}

if(isset($_GET['end'])) {
	$dateend = $_GET['end'];
	if($dateend != "")
		$tempsql .= " AND D.".CommonVals::$DateRegis." <= ".strtotime($dateend);
}
$page = 1;
if(isset($_GET['page'])) {
	$page = $_GET['page'];
}

$arrcountrows = $dealerDao -> getRowDealers($makh, $email, $namekey, $mobile, $city, $tempsql, $aAdminUser->isRoot(), $aAdminUser->getUserID());

$sumrecord = $arrcountrows;
$numrecord = 50;
$pageNumber = intval(($sumrecord / $numrecord));
if(($sumrecord % $numrecord) != 0) {
	$pageNumber++;
}

if($pageNumber == 0) {
	$pageNumber = 1;	
}

if($page > $pageNumber) {
	$page = $pageNumber;
}

//load data
$arrdealer = $dealerDao -> getDealers($makh, $email, $namekey, $mobile, $city, ($page-1)*$numrecord, $numrecord, $tempsql, $aAdminUser->isRoot(), $aAdminUser->getUserID());

?>

<style>
.listviewcontent table {
	width: 900px;
	max-width: 900px;
}

.listviewcontent table td {
	margin-top: 2px;
	border: 1px solid;
	border-radius: 2px 2px 2px 2px;
}

.title {
	text-align: center;
	background-color: #0088cc;
	min-height: 40px;
	-moz-border-radius: 8px 8px 0px 0px;
	-webkit-border-radius: 8px 8px 0px 0px;
	border-radius: 8px 8px 0px 0px;
	color: #FFF;
}

.listviewcontent table tr:hover td {
	background: #FFC;
}

.class-pagination{
		float: right;
		clear: left;
		padding-top: 20px;
	}
	
	.class-pageLabel{
		font-size: 11px;
		font-weight: bold;
		text-transform: uppercase;
	}

	.class-pageNow{
		padding: 5px;
		padding-top: 4px;
		margin: 2px;
		font-size: 11px;
		font-weight: bold;
		border: 1px solid #C0C0C0;
		background-color: #C0C0C0;
		border-radius: 4px;
		box-shadow: 0 0 10px rgba(0,0,0,.1);
		cursor: default;
	}
	
	.class-pageElem{
		padding: 5px;
		padding-top: 4px;
		margin: 2px;
		font-size: 11px;
		font-weight: bold;
		border: 1px solid #C0C0C0;
		box-shadow: 0 0 10px rgba(0,0,0,.2);
		border-radius: 4px;
		background-color: white;
	}

	.class-pageElem:hover{
		padding: 5px;
		margin: 2px;
		font-size: 11px;
		font-weight: bold;
		background-color: #C0C0C0;
		cursor: pointer;
	}
	.submitform {
		background: #004A00;
		text-indent: 1px;
		width:80px;
		height:30px;
		cursor: pointer;
		font-weight: bold;
		font-size: 14px;
	}
</style>
<link rel="stylesheet" type="text/css" href="../css/jquery-ui.css">
<script type="text/javascript" src="../js/jquery-uicaledate.js"></script>
<div style="width: 100%; text-align: center; margin-bottom: 10px;"><h1>Danh Sách Đại Lý</h1></div>
<div>
	<div style="width:600px; float:left;">	
    	<table>
        	<tr>
                <td>Tham Gia Từ Ngày</td>
                <td>Đến Ngày</td>
                <td>Mã Khách Hàng</td>
                <td>Tỉnh Thành</td>
                <td></td>
            </tr>
            <tr>
                <td><input type="text" name="datestart" value="<?php echo($datestart) ?>" placeholder="dd-mm-yyy" id="form_search_datestart" style="width:200px; height: 20px; margin-right:10px;" /></td>
                <td><input type="text" name="dateend" value="<?php echo($dateend) ?>" placeholder="dd-mm-yyy" id="form_search_dateend" style="width:200px; height: 20px; margin-right:10px;" /></td>
                <td><input type="text" name="makh" value="<?php echo($makh) ?>" placeholder="DL00001" id="form_search_makh" style="width:100px; height: 20px; margin-right:10px;" /></td>
                <td><select id="search_city" name="city" style="width: 200px; height: 20px;">
                            <option selected="selected" value="">Toàn quốc</option>
                            <option value="Hà Nội">Hà Nội</option><option value="Hồ Chí Minh">TP HCM</option><option value="Cần Thơ">TP Cần Thơ</option><option value="Đà Nẵng">TP Đà Nẵng</option><option value="Hải Phòng">TP Hải Phòng</option><option value="An Giang">An Giang</option><option value="Vũng Tàu">Bà Rịa - Vũng Tàu</option><option value="Bắc Giang">Bắc Giang</option><option value="Bắc Kạn">Bắc Kạn</option><option value="Bạc Liêu">Bạc Liêu</option><option value="Bắc Ninh">Bắc Ninh</option><option value="Bến Tre">Bến Tre</option><option value="Bình Định">Bình Định</option><option value="Bình Dương">Bình Dương</option><option value="Bình Phước">Bình Phước</option><option value="Bình Thuận">Bình Thuận</option><option value="Cà Mau">Cà Mau</option><option value="Cao Bằng">Cao Bằng</option><option value="Đăk Lăk">Đăk Lăk</option><option value="Đak Nông">Đak Nông</option><option value="Điện Biên">Điện Biên</option><option value="Đồng Nai">Đồng Nai</option><option value="Đồng Tháp">Đồng Tháp</option><option value="Gia Lai">Gia Lai</option><option value="Hà Giang">Hà Giang</option><option value="Hà Nam">Hà Nam</option><option value="Hà Tĩnh">Hà Tĩnh</option><option value="Hải Dương">Hải Dương</option><option value="Hậu Giang">Hậu Giang</option><option value="Hòa Bình">Hòa Bình</option><option value="Hưng Yên">Hưng Yên</option><option value="Khánh Hòa">Khánh Hòa</option><option value="Kiên Giang">Kiên Giang</option><option value="Kon Tum">Kon Tum</option><option value="Lai Châu">Lai Châu</option><option value="Lâm Đồng">Lâm Đồng</option><option value="Lạng Sơn">Lạng Sơn</option><option value="Lào Cai">Lào Cai</option><option value="Long An">Long An</option><option value="Nam Định">Nam Định</option><option value="Nghệ An">Nghệ An</option><option value="Ninh Bình">Ninh Bình</option><option value="Ninh Thuận">Ninh Thuận</option><option value="Phú Thọ">Phú Thọ</option><option value="Phú Yên">Phú Yên</option><option value="Quảng Bình">Quảng Bình</option><option value="Quảng Nam">Quảng Nam</option><option value="Quảng Ngãi">Quảng Ngãi</option><option value="Quảng Ninh">Quảng Ninh</option><option value="Quảng Trị">Quảng Trị</option><option value="Sóc Trăng">Sóc Trăng</option><option value="Sơn La">Sơn La</option><option value="Tây Ninh">Tây Ninh</option><option value="Thái Bình">Thái Bình</option><option value="Thái Nguyên">Thái Nguyên</option><option value="Thanh Hóa">Thanh Hóa</option><option value="Thừa Thiên Huế">Thừa Thiên Huế</option><option value="Tiền Giang">Tiền Giang</option><option value="Trà Vinh">Trà Vinh</option><option value="Tuyên Quang">Tuyên Quang</option><option value="Vĩnh Long">Vĩnh Long</option><option value="Vĩnh Phúc">Vĩnh Phúc</option><option value="Yên Bái">Yên Bái</option>  
                        </select></td>
                <td></td>
            </tr>
            <tr>
                <td>Tìm Kiếm Tên:</td>
                <td>Tìm Kiếm Email:</td>
                <td>Tìm Kiếm SĐT:</td>
                <td>TK Tình Trạng:</td>
                <td></td>
            </tr>
            <tr>
                <td><input type="text" name="namesr" placeholder="Nguyễn Văn A" style="width:200px; height: 20px; margin-right:10px;" id="form_namekey" /></td>
                <td><input type="text" name="emailsr" placeholder="abc@gmail.com" style="width:200px; height: 20px; margin-right:10px;" id="form_emailkey" /></td>
                <td><input type="text" name="phonesr" placeholder="0909123456" style="width:100px; height: 20px; margin-right:10px;" id="form_phonekey" /></td>
                <td><select id="form_statussearch" style="height: 23px; width:200px; margin-right:10px;"><option value="">--Tất Cả--</option><option value="1">Chưa Kích Hoạt</option><option value="2">Danh Sách Bị Khóa</option><option value="3">Danh Sách Đang Hoạt Động</option></select></td>
                <td><input id="form_submitsearch" type="button" style="cursor:pointer ;background-image:url(../images/timkiem.png); width:70px; height:24px; border:0px;" value="" /></td>
            </tr>
        </table>
    </div>
    <div style="clear:both; height:15px;"></div>
    <div style="float:right">
    	<strong>Chú Thích:</strong> <img src="/images/activity.jpg" title="Tài Khoản Mới Cần Kích Hoạt" />Kích Hoạt &nbsp;&nbsp;<img src="/images/unclockicon.png" title="Tài Khoản Đang Được Phép Sử Dụng" />TK Không Khóa &nbsp;&nbsp;<img src="/images/lockicon.png" title="Tài Khoản Không Được Phép Sử Dụng" /> TK Bị Khóa
    </div>
    <div style="clear:both;"></div>
    <div class="class-pagination">
        <span class="class-pageLabel">Trang</span>
        <?php if($page == 1) { ?>
        <span title="Trang 1" page="1" class="class-pageNow">1</span>
        <?php } else { ?>
        <span title="Trang 1" page="1" class="class-pageElem">1</span>
        <?php }?>
        <?php if ($pageNumber != 1) { for($i = 2; $i <= $pageNumber; $i++) { ?>
        <?php if($i == $page) { ?>
        <span title="Trang <?php echo($i) ?>" page="<?php echo($i) ?>" class="class-pageNow"><?php echo($i) ?></span>
        <?php } else { ?>
        <span title="Trang <?php echo($i) ?>" page="<?php echo($i) ?>" class="class-pageElem"><?php echo($i) ?></span>
        <?php }?>
        <?php }}?>
    </div>
    <div style="clear:both; height:10px;"></div>
    
    <div class="listviewcontent" style="width: 1100px; max-width: 1100px;">
    	<table style="width: 1100px; max-width: 1100px;">
        	<tr>
            	<th class="title" width="40px">STT</th>
                <th class="title" width="100px">Mã KH</th>
            	<th class="title">Họ Tên Đại Lý</th>
                <th class="title" width="230px" style="max-width: 230px;">Email</th>
                <th class="title" width="40px">GT</th>
                <th class="title" width="100px">Điện Thoại</th>
                <th class="title" width="100px">Tỉnh Thành</th>
                <th class="title" width="100px">Chức Năng</th>
            </tr>
            <?php
			$i = ($page-1)*$numrecord + 1;
			foreach($arrdealer as $entry) {
			?>
            <tr>
            	<td align="center"><?php echo($i) ?></td>
                <td align="center"><?php if($entry->isAccept()) { ?><a href="/admin/?content=daily&p=ho-so-khach-hang&mail=<?php echo($entry->getIDCODE()) ?>" title="Xem danh sách hồ sơ của <?php echo($entry->getFullname()) ?>"><strong><?php echo($entry->getIDCODE()) ?></strong></a><?php }?></td>
            	<td><span style="margin-left:5px; margin-right:5px;"><strong><a title="Xem thông tin chi tiết của đại lý <?php echo($entry->getFullname()) ?>" href="/admin/?content=daily&p=chi-tiet-dai-ly&id=<?php echo($entry->getEmailDealer()) ?>"><?php echo($entry->getFullname()) ?></a></strong></span></td>
                <td align="center"><strong><?php echo($entry->getEmailDealer()) ?></strong></td>
                <td align="center"><?php if($entry->getGender()) echo("Nam"); else echo("Nữ"); ?></td>
                <td align="center"><strong><?php echo($entry->getMobile()) ?></strong></td>
                <td align="center"><?php echo($entry->getProvince()) ?></td>
                <td align="center"><?php if(!$entry->isAccept()) { echo('<img src="/images/activity.jpg" style="cursor:pointer;" title="Kích Hoạt" class="class-kichhoat-link" idacc="'.$entry->getEmailDealer().'" />'); } else { if(!$entry->isLock()) { echo('<img src="/images/unclockicon.png" style="cursor:pointer;" title="Khóa Tài Khoản" class="class-lockacc-link" idacc="'.$entry->getEmailDealer().'" />'); } else { echo('<img src="/images/lockicon.png" style="cursor:pointer;" title="Mở Khóa Tài Khoản" class="class-unlockacc-link" idacc="'.$entry->getEmailDealer().'" />'); } } ?> | <a href="/admin/?content=daily&p=chi-tiet-dai-ly&id=<?php echo($entry->getEmailDealer()) ?>"><img style="cursor:pointer;" title="Xem Chi Tiết Thông Tin Cá Nhân" src="/images/icon-edit.gif" width="20px"></a></td>
            </tr>
            <?php
				$i++;
			}
			?>
        </table>
    </div>
    
    <div style="clear:both;"></div>
    <div class="class-pagination">
        <span class="class-pageLabel">Trang</span>
        <?php if($page == 1) { ?>
        <span title="Trang 1" page="1" class="class-pageNow">1</span>
        <?php } else { ?>
        <span title="Trang 1" page="1" class="class-pageElem">1</span>
        <?php }?>
        <?php if ($pageNumber != 1) { for($i = 2; $i <= $pageNumber; $i++) { ?>
        <?php if($i == $page) { ?>
        <span title="Trang <?php echo($i) ?>" page="<?php echo($i) ?>" class="class-pageNow"><?php echo($i) ?></span>
        <?php } else { ?>
        <span title="Trang <?php echo($i) ?>" page="<?php echo($i) ?>" class="class-pageElem"><?php echo($i) ?></span>
        <?php }?>
        <?php }}?>
    </div>
    <div style="clear:both; height:15px;"></div>
</div>

<script>
$( "#form_search_datestart" ).datepicker({
	defaultDate: "+1w",
	changeMonth: true,
	changeYear: true,
	numberOfMonths: 2,
	dateFormat: 'dd-mm-yy',
	onClose: function( selectedDate ) {
		$( "#form_search_dateend" ).datepicker( "option", "minDate", selectedDate );
	}
});
$( "#form_search_dateend" ).datepicker({
	defaultDate: "+1w",
	changeMonth: true,
	changeYear: true,
	numberOfMonths: 2,
	dateFormat: 'dd-mm-yy',
	onClose: function( selectedDate ) {
		$( "#form_search_datestart" ).datepicker( "option", "maxDate", selectedDate );
	}
});

$('#form_namekey').val('<?php echo($namekey) ?>');
$('#form_emailkey').val('<?php echo($email) ?>');
$('#form_phonekey').val('<?php echo($mobile) ?>');
$('#form_statussearch').val('<?php echo($status) ?>');
$('#search_city').val('<?php echo($city) ?>');
$(document).ready(function(e) {
    $('#form_submitsearch').click(function(e) {
        var name = $('#form_namekey').val();
		var email = $('#form_emailkey').val();
		var phone = $('#form_phonekey').val();
		var status = $('#form_statussearch').val();
		var startdate = $('#form_search_datestart').val();
		var enddate = $('#form_search_dateend').val();
		var city = $('#search_city').val();
		var makh = $('#form_search_makh').val();
		
		openwindowns('/admin/?content=daily&makh=' + makh + '&mail=' + email + '&name=' + name + '&city=' + city + '&mob=' + phone + '&st=' + status + '&start=' + startdate + '&end=' + enddate);
    });
	
	$(document).on('click', '.class-pageElem', function() {
		page = $(this).attr('page');
		
		var name = $('#form_namekey').val();
		var email = $('#form_emailkey').val();
		var phone = $('#form_phonekey').val();
		var status = $('#form_statussearch').val();
		var startdate = $('#form_search_datestart').val();
		var enddate = $('#form_search_dateend').val();
		var city = $('#search_city').val();
		var makh = $('#form_search_makh').val();
		
		openwindowns('/admin/?content=daily&makh=' + makh + '&mail=' + email + '&name=' + name + '&city=' + city + '&mob=' + phone + '&st=' + status + '&start=' + startdate + '&end=' + enddate + '&&page=' + page);
	});
	
	function openwindowns(url) {
		window.location = url;
	}
	
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
					elem.attr('title', 'Khóa Tài Khoản');
					elem.attr('class', 'class-lockacc-link');
					elem.attr('src', '/images/unclockicon.jpg');
					alert("Cập nhật dữ liệu thành công");
					location.reload();
				} else {
					alert("Cập nhật dữ liệu thất bại");
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
					elem.attr('title', 'Mở Khóa Tài Khoản');
					elem.attr('class', 'class-unlockacc-link');
					elem.attr('src', '/images/lockicon.jpg');
					alert("Cập nhật dữ liệu thành công");
					location.reload();
				} else {
					alert("Cập nhật dữ liệu thất bại");
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
					elem.attr('title', 'Khóa Tài Khoản');
					elem.attr('class', 'class-lockacc-link');
					elem.attr('src', '/images/unclockicon.jpg');
					alert("Cập nhật dữ liệu thành công");
					location.reload();
				} else {
					alert("Cập nhật dữ liệu thất bại");
				}
			}
		});
	});
});
</script>