<?php
$profileCustomerDao = new ProfileCustomerDAO();
$statusDAO = new StatusDAO();

$page = 1;
$namekey = "";
$status = "";
$tempsql = "";
$datestart = "";
$dateend = "";
if(isset($_GET['key'])) {
	$namekey = $_GET['key'];
}

if(isset($_GET['sta'])) {
	$status = $_GET['sta'];
}

if(isset($_GET['page'])) {
	$page = $_GET['page'];
}

$tempsql = "";
$datestart = "";
$dateend = "";
if(isset($_GET['start'])) {
	$datestart = $_GET['start'];
	if($datestart != "")
		$tempsql .= " AND P.datecreate >= ".strtotime($datestart." 00:00");
}

if(isset($_GET['end'])) {
	$dateend = $_GET['end'];
	if($dateend != "")
		$tempsql .= " AND P.datecreate <= ".strtotime($dateend." 23:59");
}

$arrcountrows = $profileCustomerDao -> getRowRecordsCustomIndex($email, $namekey, $status, $tempsql);
$sumrecord = $arrcountrows;//$arrcountrows[0][0];
$numrecord = 30;
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

$arrcustom = $profileCustomerDao -> profileRecordsCustomIndex($email, $namekey, $status, $tempsql, ($page-1)*$numrecord, $numrecord);

$statusList = $statusDAO->getStatuss(0);
?>
<style>
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
	
	.class-headertable {
		height: 30px;
		margin: auto;
		background: rgb(136, 169, 67);
	}
	
	.submitform {
		background: #88A943;
		text-indent: 1px;
		width:80px;
		height:30px;
		cursor: pointer;
		font-weight: bold;
		font-size: 14px;
	}
	
	.class-content-records th {
		color: #FFF;
	}
	
	.class-content-records table tr {height: 30px;min-height: 30px;}
	.class-content-records table tr {display: table-row;vertical-align: inherit;border-color: inherit;} 
	.class-content-records table tr th, .class-content-records table tr td {border: 1px solid #98bf21;}
		
	#form_statussearch {
		height: 30px;
		border-radius: 3px;
	}
</style>

<script>
$(document).ready(function(e) {
    $( "#form_search_datestart" ).datepicker({
		defaultDate: "+1w",
		changeMonth: true,
		changeYear: true,
		numberOfMonths: 3,
		dateFormat: 'dd-mm-yy',
		onClose: function( selectedDate ) {
			$( "#form_search_dateend" ).datepicker( "option", "minDate", selectedDate );
		}
	});
	$( "#form_search_dateend" ).datepicker({
		defaultDate: "+1w",
		changeMonth: true,
		changeYear: true,
		numberOfMonths: 3,
		dateFormat: 'dd-mm-yy',
		onClose: function( selectedDate ) {
			$( "#form_search_datestart" ).datepicker( "option", "maxDate", selectedDate );
		}
	});
});
</script>

<div>
	<div style="width:600px; float:left;">	
    	<table style="font-size: 12px">
            <tr>
                <td>Từ ngày:</td>
                <td>Đến ngày:</td>
                <td>Tìm kiếm tên khách hàng:</td>
                <td>Tìm kiếm theo tình trạng hồ sơ:</td>
                <td></td>
            </tr>
            <tr>
                <td><input type="text" name="datestart" value="<?php echo($datestart) ?>" placeholder="dd-mm-yyy" id="form_search_datestart" style="width:100px; margin-right:10px;" /></td>
                <td><input type="text" name="dateend" value="<?php echo($dateend) ?>" placeholder="dd-mm-yyy" id="form_search_dateend" style="width:100px; margin-right:10px;" /></td>
                <td><input type="text" name="namesr" placeholder="Nguyễn Văn A" style="width:200px; margin-right:10px;" id="form_namekey" value="<?php echo($namekey) ?>" /></td>
                <td><select id="form_statussearch" style="width:200px; margin-right:10px;"><option value="">--Tất Cả--</option>
                <?php
				foreach ($statusList as $aStatus) {
				?>
					<option value="<?php echo ($aStatus->getStatusID()); ?>" <?php if ($aStatus->getStatusID() == $status) {?> selected="selected" <?php } ?>><?php echo ($aStatus->getStatusName()); ?></option>
				<?php
				}
				?>
                </select></td>
                <td><div class="btn-menu-action" style="width: 70px;" id="form_submitsearch">Tìm Kiếm</div></td>
            </tr>
        </table>
    </div>
    <div style="float:right; margin-top: 21px; font-size: 13px; margin-right: 10px;"><div id="formaddnewprofilecustom" class="btn-menu-action" style="width: 130px;">Login hồ sơ mới</div></div>

</div>

<div style="clear:both;"></div>
<div>
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
    <div class="class-content-records">
    	<table width="980px" cellpadding="0" cellspacing="0" style="font-size: 12px; border-collapse: collapse; margin-left:5px;">
        	<tr>
            	<th class="class-headertable" width="30px">STT</th>
            	<th class="class-headertable" width="170px">Tên khách hàng</th>
                <th class="class-headertable" width="110px">Ngày login</th>
                <th class="class-headertable" width="100px">Khu vực</th>
                <th class="class-headertable" width="140px">Tình trạng</th>
                <th class="class-headertable" width="110px">Ngày cập nhật</th>
                <th class="class-headertable" width="160px">Tổ chức cho vay</th>
                <th class="class-headertable" width="160px">Sản phẩm</th>
            </tr>
            <?php
			$i = ($page-1)*$numrecord + 1;
			foreach($arrcustom as $entry) {
				$nameCustomer = rewriteTextUrl(stripUnicode($entry->getNameCustomer()));
			?>
            <tr>
            	<td align="center"><span><?php echo($i) ?></span></td>
            	<td><span style="margin-left: 5px; margin-right:5px;"><a href="/quanly/chi-tiet-ho-so/<?php echo($entry->getIDProfile()) ?>/<?php echo($nameCustomer) ?>.html" title="Xem chi tiết hồ sơ của <?php echo($entry->getNameCustomer()) ?>"><?php echo($entry->getNameCustomer()) ?></a></span></td>
                <td align="center"><span><?php echo(CommonFuns::int_to_date2($entry->getDateCreate())) ?></span></td>
                <td align="center"><span><?php echo($entry->getProvince()) ?></span></td>
                <td align="center"><span><?php echo($entry->getStatus()->getStatusName()) ?></span></td>
                <td align="center"><span><?php if($entry->getDateUpdate() != "") echo(CommonFuns::int_to_date2($entry->getDateUpdate())); ?></span></td>
                <td align="center"><span><?php echo($entry->getBankLoan()) ?></span></td>
                <td align="center"><span><?php echo($entry->getTypeLoan()->getLoanName()) ?></span></td>
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
</div>
<script>
$(document).ready(function(e) {
    $(document).on("click", "#form_submitsearch", function() { 
		var namekey = $('#form_namekey').val();
		var status = $('#form_statussearch').val();
		var startdate = $('#form_search_datestart').val();
		var enddate = $('#form_search_dateend').val();
		
		openlink('/quanly/profile_search/key_' + namekey + '/status_' + status + '/start_' + startdate + '/end_' + enddate + '/1.html');
	});
	
	function openlink(slink) {
		window.location = slink;
	}
	
	$(document).on("click", ".class-pageElem", function() {
		var page = $(this).attr('page');
		var namekey = $('#form_namekey').val();
		var status = $('#form_statussearch').val();
		var startdate = $('#form_search_datestart').val();
		var enddate = $('#form_search_dateend').val();
		
		openlink('/quanly/profile_search/key_' + namekey + '/status_' + status + '/start_' + startdate + '/end_' + enddate + '/' + page + '.html');
	});
	
	$(document).on("click", "#formaddnewprofilecustom", function() {
		openlink('/quanly/new-profile.html');
	});
});
</script>