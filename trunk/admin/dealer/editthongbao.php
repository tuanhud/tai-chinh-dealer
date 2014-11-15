<?php
require_once ("../src/db/connectdatabase.php");
function getData($id) {
	$con = new ConnectDB();
	
	$sql = "Select titletb, message, datecreate, isuse FROM thongbaodealer WHERE id='".$id."'";
	return $con -> getvalueString($sql);
}

if(isset($_GET['id'])) {
	$id = $_GET['id'];
	$arrdata = getData($id);
	if(count($arrdata) > 0) {
		
?>
<h3>Cập Nhật Thông Báo</h3>
<div style="color: red;">
<?php
	if(isset($_GET['mess'])) {
		echo($_GET['mess']);
	}
?>
</div>
<div style="width: 850px;">
	<form action="../src/control/adminadvertise.php" method="post" onSubmit="return checkvalue();">
    	<table width="850px">
            <tr>
                <td>Tiêu Đề</td>
            </tr>
            <tr>
                <td><textarea style="padding:5px;width:840px;" id="tieude" name="tieude" rows="3"><?php echo($arrdata[0][0]) ?></textarea><br><font color="red"><span id="err_title"></span></font></td>
            </tr>
            <tr>
                <td>Nội Dung</td>
            </tr>
            <tr>
                <td><textarea id="form_content" name="form_content" rows="20" cols="200" style="width: 850px; max-width:850px; min-width:850px;" class="tinymce"><?php echo($arrdata[0][1]) ?></textarea><br><font color="red"><span id="err_cautraloi"></span></font></td>
            </tr>
            <tr>
               	<th><input type="hidden" name="idre" value="<?php echo($id) ?>" /><input type="hidden" name="acc" value="edit" /><input type="submit" value="Cập Nhật" style="border-radius: 5px; padding:5px; width:100px; background:#03F; color:#FFF; font-weight:bold; cursor:pointer;" /></th>
            </tr>
        </table>
    </form>
</div>
<script>
function checkvalue() {
	var title = $.trim($('#tieude').val());
	var mess = $.trim($('#form_content').val());
	
	if(title == "") {
		$('#err_title').html("Vui lòng nhập tiêu đề thông báo");
		$('#tieude').focus();
		return false;
	} else {
		$('#err_title').html("");
	}
	
	if(mess == "") {
		$('#err_cautraloi').html("Vui lòng nhập nội dung thông báo");
		$('#form_content').focus();
		return false;
	} else {
		$('#err_cautraloi').html("");
	}
	
	return true;
}
</script>
<?php

	}
}
?>