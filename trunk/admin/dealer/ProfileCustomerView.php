<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/src/entitys/TypeLoan.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/src/entitys/Status.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/src/entitys/ProfileCustomer.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/src/DAO/ProfileCustomerDAO.php');

include_once($_SERVER['DOCUMENT_ROOT'].'/src/DAO/TypeLoanDAO.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/src/DAO/StatusDAO.php');

$profileDAO = new ProfileCustomerDAO();
$statusDAO = new StatusDAO();
$typeLoanDAO = new TypeLoanDAO();

/*

function getProfiles($emailsr, $namesr, $statussr, $city, $typeloan, $tempsql, $start, $lenght) {
	$con = new ConnectDB();
	
	$sql = "Select p.idpro,r.idcode,p.namecustomer,p.province,tl.namepurp,p.statusquo,p.datecreate,p.dateupdate FROM profilecustomer as p, registrationbank AS r, purposeloan AS tl WHERE p.loantype=tl.idpurpose AND p.regis_email=r.regis_email AND r.idcode LIKE '%".$emailsr."%' AND p.namecustomer LIKE '%".$namesr."%' AND p.statusquo LIKE '%".$statussr."%' AND p.province LIKE '%".$city."%' AND p.loantype LIKE '%".$typeloan."%' ".$tempsql."  ORDER BY p.datecreate DESC LIMIT ".$start.",".$lenght;
	return $con -> getvalueString($sql);
}

function getRowsProfile($emailsr, $namesr, $statussr, $city, $typeloan, $tempsql) {
	$con = new ConnectDB();
	
	$sql = "Select COUNT(*) FROM profilecustomer as p, registrationbank AS r WHERE p.regis_email=r.regis_email AND r.idcode LIKE '%".$emailsr."%' AND p.namecustomer LIKE '%".$namesr."%' AND p.statusquo LIKE '%".$statussr."%' AND p.province LIKE '%".$city."%' AND p.loantype LIKE '%".$typeloan."%' ".$tempsql;
	return $con -> getvalueString($sql);
}

function int_to_date($int)
{
    $time  = date("d/m/Y", $int);
    return $time;
}*/

$namesr = "";
$emailsr = "";
$statussr = "";
$datestart = "";
$dateend = "";
$city = "";
$typeloan = "";

if(isset($_GET['mail'])) {
	$emailsr = $_GET['mail'];
}

if(isset($_GET['name'])) {
	$namesr = $_GET['name'];
}

if(isset($_GET['sta'])) {
	$statussr = $_GET['sta'];
}

if(isset($_GET['city'])) {
	$city = $_GET['city'];
}

if(isset($_GET['tl'])) {
	$typeloan = $_GET['tl'];
}

$page = 1;
if(isset($_GET['page'])) {
	$page = $_GET['page'];
}

$tempsql = "";
if(isset($_GET['start'])) {
	$datestart = $_GET['start'];
	if($datestart != "")
		$tempsql .= " AND P.".CommonVals::$datecreate." >= ".strtotime($datestart);
}

if(isset($_GET['end'])) {
	$dateend = $_GET['end'];
	if($dateend != "")
		$tempsql .= " AND P.".CommonVals::$datecreate." <= ".strtotime($dateend);
}

$arrcountrows = $profileDAO->getRowsProfile($aAdminUser->isRoot(), $aAdminUser->getUserID(), $emailsr, $namesr, $statussr, $city, $typeloan, $tempsql);
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
$arrprofile = $profileDAO->getProfilesByUserManager($aAdminUser->isRoot(), $aAdminUser->getUserID(), $emailsr, $namesr, $statussr, $city, $typeloan, $tempsql, ($page-1)*$numrecord, $numrecord);

$typeLoanList = $typeLoanDAO->getTypeLoans(0);
$statusList = $statusDAO->getStatuss(0);
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
<link rel="stylesheet" type="text/css" href="/css/jquery-ui.css">
<div style="width: 100%; text-align: center;"><h1>Danh Sách Hồ Sơ</h1></div>
<div>
	<div style="width:600px; float:left;">	
    	<table>
        	<tr>
                <td>Từ Ngày</td>
                <td>Đến Ngày</td>
                <td>Sản Phẩm</td>
                <td>Tỉnh Thành</td>
            </tr>
            <tr>
                <td><input type="text" name="datestart" value="<?php echo($datestart) ?>" placeholder="dd-mm-yyy" id="form_search_datestart" style="width:200px; height: 20px; margin-right:10px;" /></td>
                <td><input type="text" name="dateend" value="<?php echo($dateend) ?>" placeholder="dd-mm-yyy" id="form_search_dateend" style="width:200px; height: 20px; margin-right:10px;" /></td>
                <td><select name="form_typeloan" id="form_typeloan" style="height: 23px; width: 200px;"><option value="">--Tất Cả--</option>
                	<?php
					foreach ($typeLoanList as $atypeLoan) {
						
					?>
                        <option value="<?php echo ($atypeLoan->getLoanID()); ?>" <?php if ($atypeLoan->getLoanID() == $typeloan) {?> selected="selected" <?php } ?>><?php echo ($atypeLoan->getLoanName()); ?></option>
                    <?php
					}
					?>
                	</select>
                </td>
                <td><select id="search_city" name="city" style="width: 200px; height: 23px;">
                            <option selected="selected" value="">--Tất Cả--</option>
                            <option value="Hà Nội">Hà Nội</option><option value="Hồ Chí Minh">TP HCM</option><option value="Cần Thơ">TP Cần Thơ</option><option value="Đà Nẵng">TP Đà Nẵng</option><option value="Hải Phòng">TP Hải Phòng</option><option value="An Giang">An Giang</option><option value="Vũng Tàu">Bà Rịa - Vũng Tàu</option><option value="Bắc Giang">Bắc Giang</option><option value="Bắc Kạn">Bắc Kạn</option><option value="Bạc Liêu">Bạc Liêu</option><option value="Bắc Ninh">Bắc Ninh</option><option value="Bến Tre">Bến Tre</option><option value="Bình Định">Bình Định</option><option value="Bình Dương">Bình Dương</option><option value="Bình Phước">Bình Phước</option><option value="Bình Thuận">Bình Thuận</option><option value="Cà Mau">Cà Mau</option><option value="Cao Bằng">Cao Bằng</option><option value="Đăk Lăk">Đăk Lăk</option><option value="Đak Nông">Đak Nông</option><option value="Điện Biên">Điện Biên</option><option value="Đồng Nai">Đồng Nai</option><option value="Đồng Tháp">Đồng Tháp</option><option value="Gia Lai">Gia Lai</option><option value="Hà Giang">Hà Giang</option><option value="Hà Nam">Hà Nam</option><option value="Hà Tĩnh">Hà Tĩnh</option><option value="Hải Dương">Hải Dương</option><option value="Hậu Giang">Hậu Giang</option><option value="Hòa Bình">Hòa Bình</option><option value="Hưng Yên">Hưng Yên</option><option value="Khánh Hòa">Khánh Hòa</option><option value="Kiên Giang">Kiên Giang</option><option value="Kon Tum">Kon Tum</option><option value="Lai Châu">Lai Châu</option><option value="Lâm Đồng">Lâm Đồng</option><option value="Lạng Sơn">Lạng Sơn</option><option value="Lào Cai">Lào Cai</option><option value="Long An">Long An</option><option value="Nam Định">Nam Định</option><option value="Nghệ An">Nghệ An</option><option value="Ninh Bình">Ninh Bình</option><option value="Ninh Thuận">Ninh Thuận</option><option value="Phú Thọ">Phú Thọ</option><option value="Phú Yên">Phú Yên</option><option value="Quảng Bình">Quảng Bình</option><option value="Quảng Nam">Quảng Nam</option><option value="Quảng Ngãi">Quảng Ngãi</option><option value="Quảng Ninh">Quảng Ninh</option><option value="Quảng Trị">Quảng Trị</option><option value="Sóc Trăng">Sóc Trăng</option><option value="Sơn La">Sơn La</option><option value="Tây Ninh">Tây Ninh</option><option value="Thái Bình">Thái Bình</option><option value="Thái Nguyên">Thái Nguyên</option><option value="Thanh Hóa">Thanh Hóa</option><option value="Thừa Thiên Huế">Thừa Thiên Huế</option><option value="Tiền Giang">Tiền Giang</option><option value="Trà Vinh">Trà Vinh</option><option value="Tuyên Quang">Tuyên Quang</option><option value="Vĩnh Long">Vĩnh Long</option><option value="Vĩnh Phúc">Vĩnh Phúc</option><option value="Yên Bái">Yên Bái</option></select></td>
            </tr>
            <tr>
                <td>Tìm kiếm theo tên:</td>
                <td>Tìm kiếm theo mã đại lý:</td>
                <td>Lọc theo tình trạng:</td>
                <td></td>
            </tr>
            <tr>
                <td><input type="text" name="namesr" value="<?php echo($namesr) ?>" placeholder="Nguyễn Văn A" style="width:200px; height: 20px; margin-right:10px;" id="form_namekey" /></td>
                <td><input type="text" name="emailsr" value="<?php echo($emailsr) ?>" placeholder="DL00001" style="width:200px; height: 20px; margin-right:10px;" id="form_emailkey" /></td>
                <td><select id="form_statussearch" style="height: 23px; width:200px; margin-right:10px;"><option value="">--Tất Cả--</option>
					<?php
					foreach ($statusList as $aStatus) {
						
					?>
                        <option value="<?php echo ($aStatus->getStatusID()); ?>" <?php if ($aStatus->getStatusID() == $statussr) {?> selected="selected" <?php } ?>><?php echo ($aStatus->getStatusName()); ?></option>
                    <?php
					}
					?></select></td>
                <td><input id="form_submitsearch" type="button" style="cursor:pointer ;background-image:url(../images/timkiem.png); width:70px; height:24px; border:0px;" value="" /></td>
            </tr>
        </table>
    </div>
    <div style="clear:both; height:15px;"></div>
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
                <th class="title" width="80px">Ngày Đăng</th>
            	<th class="title">Tên KH</th>
                <th class="title" width="80px">ID Code</th>
                <th class="title" width="150px">Mục Đích Vay</th>
                <th class="title" width="100px">Tỉnh Thành</th>
                <th class="title" width="200px">Trạng Thái</th>
                <th class="title" width="85px">Ngày C.Nhật</th>
                <th class="title" width="80px">Chức Năng</th>
            </tr>
            <?php
			$i = ($page-1)*$numrecord + 1;
			foreach($arrprofile as $profile) {
			?>
            <tr>
            	<td align="center"><?php echo($i) ?></td>
                <td align="center"><?php echo(CommonFuns::int_to_date2($profile->getDateCreateFirst())) ?></td>
            	<td><span style="margin-left:5px; margin-right:5px;"><strong><a href="/admin/?content=daily&p=chi-tiet-ho-so-khach-hang&rei=<?php echo($profile->getIDProfile()) ?>"><?php echo($profile->getNameCustomer()) ?></a></strong></span></td>
                <td align="center"><span style="margin-left:5px; margin-right:5px;"><strong><?php echo($profile->getIDCODE()) ?></strong></span></td>
                <td align="center"><?php echo($profile->getTypeLoan()->getLoanName()) ?></td>
                <td align="center"><?php echo($profile->getProvince()) ?></td>
                <td align="center"><?php if ($profile->getStatus()->getStatusID() != "") { echo($profile->getStatus()->getStatusName()); } else { echo("Hồ sơ Mới");} ?></td>
                <td align="center"><?php if($profile->getDateUpdate() != "") echo(CommonFuns::int_to_date2($profile->getDateUpdate())) ?></td>
                <td align="center"><a href="/admin/?content=daily&p=chi-tiet-ho-so-khach-hang&rei=<?php echo($profile->getIDProfile()) ?>"><img title="Xem chi tiết hồ sơ của <?php echo($profile->getNameCustomer()) ?>" style="cursor:pointer" src="/images/icon-detail.gif" class="class-detail-profile-link" idpro="<?php echo($profile->getIDProfile()) ?>"  height="20" /></a>&nbsp; | &nbsp;<img idpr="<?php echo($profile->getIDProfile()) ?>" class="class-deletequestion-link" src="/images/icon-delete.gif" height="20" title="Xóa" /></td>
            </tr>
            <?php
				$i++;
			}
			?>
        </table>
    </div>
    <div style="clear:both; height:15px;"></div>
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
$('#search_city').val('<?php echo($city) ?>');

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


$(document).on('click', '.class-detail-profile-link', function() {
		elem = $(this);
		var id = elem.attr('idpro');
		openwindowns("/admin/?content=daily&p=chi-tiet-ho-so-khach-hang&rei=" + id);
	});
	
	$('#form_submitsearch').click(function(e) {
        var name = $('#form_namekey').val();
		var email = $('#form_emailkey').val();
		var status = $('#form_statussearch').val();
		var start = $('#form_search_datestart').val();
		var end = $('#form_search_dateend').val();
		var typeloan = $('#form_typeloan').val();
		var city = $('#search_city').val();
		
		openwindowns("/admin/?content=daily&p=ho-so-khach-hang&mail=" + email + "&name=" + name + "&sta=" + status + "&start=" + start + "&end=" + end + "&city=" + city + "&tl=" + typeloan);
    });
	
	$(document).on('click', '.class-pageElem', function() {
		page = $(this).attr('page');
		var name = $('#form_namekey').val();
		var email = $('#form_emailkey').val();
		var status = $('#form_statussearch').val();
		var start = $('#form_search_datestart').val();
		var end = $('#form_search_dateend').val();
		var typeloan = $('#form_typeloan').val();
		var city = $('#search_city').val();
		openwindowns("/admin/?content=daily&p=ho-so-khach-hang&mail=" + email + "&name=" + name + "&sta=" + status + "&start=" + start + "&end=" + end + "&city=" + city + "&tl=" + typeloan + "&page=" + page);
	});
	
	function openwindowns(url) {
		window.location = url;
	}
	
	$(document).on('click', '.class-deletequestion-link', function() {
		elem = $(this);
		id = elem.attr('idpr');
		if(confirm('Bạn thực sự muốn xóa?')) {
			$.ajax({
				type: "POST",
				url: "../src/ajax/ajaxprofileloan.php",
				data:{act: 'del', idpe: id},
				dataType: "json",
				success: function(response){
					if(response == true) {
						alert("Cập nhật dữ liệu thành công");
						elem.parent().parent().remove();
					} else {
						alert("Cập nhật thất bại");
					}
				}
			});
		}
	});
</script>