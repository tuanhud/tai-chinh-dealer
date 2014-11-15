<?php
require_once ("../src/db/connectdatabase.php");

function getIntro($id) {
	$con = new ConnectDB();
	$tbl = " loan_intro_footer";
	$fn = array('header', 'footer');
	$condetion = array('id' => $id);
	return $con -> getvalue($tbl, $fn, $condetion);
}
$id = "info-thong-bao";
$intro = getIntro($id);

if(count($intro) > 0) {
?>
<style>
textarea {
	margin:5px;
	padding:5px;
}
</style>
<h3>Cập Nhật thông tin trang thông báo</h3>
<div style="color: red;">
<?php
	if(isset($_GET['mess'])) {
		echo($_GET['mess']);
	}
?>
</div>
<div style="width: 850px;">
	<form action="../src/control/AdminIntroThongBaoDealer.php" method="post">
        <table>
            <tr>
            	<td valign="top"><div style="clear:both; margin-top: 10px; border: 1px solid; padding: 5px; background: #61C799; border-radius: 5px; color:#FFF">Giới thiệu đầu trang</div></td>
                </tr>
                <tr>
                <td>
                	<textarea id="textfieldcontent" name="textfieldcontent" rows="30" cols="200" style="width: 880px; max-width:880px; min-width:880px;" class="tinymce"><?php echo($intro[0][0]) ?></textarea>
                </td>
            </tr>
            <tr>
            	<td valign="top"><div style="clear:both; margin-top: 10px; border: 1px solid; padding: 5px; background: #61C799; border-radius: 5px; color:#FFF">Giới thiệu cuối trang</div></td>
                </tr>
                <tr>
                <td>
                	<textarea id="textfieldcontentfooter" name="textfieldcontentfooter" rows="30" cols="200" style="width: 880px; max-width:880px; min-width:880px;" class="tinymce"><?php echo($intro[0][1]) ?></textarea>
                </td>
            </tr>
            <tr>
            	<th><input type="hidden" name="acc" value="editintro" /><input type="hidden" name="idpre" value="<?php echo($id) ?>" /><input type="submit" value="Cập Nhật" style="border-radius: 5px; padding:5px; width:100px; background:#03F; color:#FFF; font-weight:bold;" /></th>
            </tr>
        </table>
    </form>
</div>
<?php
}
?>