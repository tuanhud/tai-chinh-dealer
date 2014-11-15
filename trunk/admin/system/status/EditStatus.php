<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/src/entitys/Status.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/src/DAO/StatusDAO.php');

$statusDAO = new StatusDAO();

if(isset($_GET['id'])) {
	$idStatus = $_GET['id'];
	$aStatus = $statusDAO->getStatusByID($idStatus);
	if($aStatus->getStatusID() != "") { 
	?>
<h3>Cập Nhật Thông Tin</h3>
<div>
    <form name="newad" method="post" action="/admin/control/EditStatusAction.php" onSubmit="return checkaddstatusnew();">
    
    	<input type="hidden" name="mastatus" id="mastatus" value="<?php echo($aStatus->getStatusID()) ?>" />
        <table>
            <tr>
                <th valign="top">Tên Status: </th>
                <td><input class="inputtextfield" type="text" name="tenstatus" maxlength="200" id="tenstatus" onFocus="showStyle(this)" onBlur="hiddenStyle(this)" value="<?php echo($aStatus->getStatusName()) ?>" /><br>
			<font color="red"><span id="err_tentypeloan"></span></font></td>
            </tr>
            <tr>
                <th colspan="2"><input type="submit" value="Cập nhật" class="btnclra" style="width: 100px;" /></th>
            </tr>
        </table>
	</form>
</div>

<script>
function checkaddstatusnew() {
	var ten = $.trim($('#tenstatus').val());
	if(ten.length == 0) {
		alert("Tên status không được bỏ trống");
		$('#tenstatus').focus();
		return false;
	} else {
		$('#err_tentypeloan').text('');
	}
}

function showStyle(field) {
	field.style.backgroundColor = '#FFFFCC';
}

function hiddenStyle(field) {
	field.style.backgroundColor = '#FFFFFF';
}
</script>
<?php
	}
}
?>