<?php
require_once ("../src/db/connectdatabase.php");
function getDatas($start, $lenght) {
	$con = new ConnectDB();
	
	$sql = "Select id, titletb, sendalldealer, datecreate, isuse FROM thongbaodealer ORDER BY datecreate DESC LIMIT ".$start.",".$lenght;
	return $con -> getvalueString($sql);
}

function getRowData() {
	$con = new ConnectDB();
	
	$sql = "Select COUNT(*) FROM thongbaodealer";
	return $con -> getvalueString($sql);
}

function int_to_date($int)
{
    $time  = date("d/m/Y", $int);
    return $time;
}
$page = 1;
if(isset($_GET['page'])) {
	$page = $_GET['page'];
}

$arrcountrows = getRowData();

$sumrecord = $arrcountrows[0][0];
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

//load data
$arrdealer = getDatas(($page-1)*$numrecord, $numrecord);

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
<h3>Danh Sách Thông Báo</h3>
<div>
	<div style="width: 350px; float:left;"><a href="admin.php?content=daily&amp;as=them-thong-bao"><img src="../images/icon-add.jpg" title="Thêm Thông Báo" />Thêm Thông Báo</a></div>
    <div style="float:right">
    	<strong>Chú Thích:</strong> <img src="../images/unclockicon.png" title="Được Phép Hiển Thị" />Hiển Thị &nbsp;&nbsp;<img src="../images/lockicon.png" title="Không Được Phép Hiển Thị" /> Ẩn
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
    
    <div class="listviewcontent">
    	<table>
        	<tr>
            	<th class="title" width="40px">STT</th>
                <th class="title" width="600px" style="max-width: 600px;">Tiêu đề</th>
            	<th class="title" width="100px">Ngày Đăng</th>
                <th class="title">Chức Năng</th>
            </tr>
            <?php
			$i = ($page-1)*$numrecord + 1;
			foreach($arrdealer as $entry) {
			?>
            <tr>
            	<td align="center"><?php echo($i) ?></td>
                <td style="padding-left:5px; padding-right: 5px;"><a href="admin.php?content=daily&amp;as=chi-tiet-thong-bao&amp;id=<?php echo($entry[0]) ?>" title="Xem Chi Tiết"><?php echo($entry[1]) ?></a></td>
            	<td align="center"><?php echo(int_to_date($entry[3])) ?></td>
                <td align="center"><?php if($entry[4] == "1") { echo('<img src="../images/unclockicon.png" style="cursor:pointer;" title="Click để không cho hiển thị" class="class-lockacc-link" width="20px" idacc="'.$entry[0].'" />'); } else { echo('<img src="../images/lockicon.png" style="cursor:pointer;" width="20px" title="Click để hiển thị" class="class-unlockacc-link" idacc="'.$entry[0].'" />'); } ?> | <a href="admin.php?content=daily&amp;as=chi-tiet-thong-bao&amp;id=<?php echo($entry[0]) ?>"><img style="cursor:pointer;" title="Xem Chi Tiết" src="../images/icon-edit.gif" width="20px"></a>&nbsp; | &nbsp;<img idpr="<?php echo($entry[0]) ?>" class="class-deletequestion-link" src="../images/icon-delete.gif" height="20" title="Xóa" /></td>
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
    <div><a href="admin.php?content=daily&amp;as=them-thong-bao"><img src="../images/icon-add.jpg" title="Thêm Thông Báo" />Thêm Thông Báo</a></div>
    <div style="clear:both;"></div>
</div>

<script>

$(document).ready(function(e) {	
	$(document).on('click', '.class-pageElem', function() {
		page = $(this).attr('page');
		
		openwindowns('admin.php?content=daily&page=' + page);
	});
	
	function openwindowns(url) {
		window.location = url;
	}
	
	$(document).on('click', '.class-lockacc-link', function() {
		elem = $(this);
		idacc = elem.attr('idacc');
		$.ajax({
			url: "../src/ajax/ajaxadvertise.php",
			type: "post",
			data: {act:'lock', idre: idacc},
			dataType:"json",
			success: function(data) {
				if(data == true) {
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
			url: "../src/ajax/ajaxadvertise.php",
			type: "post",
			data: {act:'unlock', idre: idacc},
			dataType:"json",
			success: function(data) {
				if(data == true) {
					alert("Cập nhật dữ liệu thành công");
					location.reload();
				} else {
					alert("Cập nhật dữ liệu thất bại");
				}
			}
		});
	});
	
	$(document).on('click', '.class-deletequestion-link', function() {
		elem = $(this);
		id = elem.attr('idpr');
		if(confirm('Bạn thực sự muốn xóa?')) {
			$.ajax({
				type: "POST",
				url: "../src/ajax/ajaxadvertise.php",
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
});
</script>