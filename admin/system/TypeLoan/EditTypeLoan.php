<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/src/entitys/TypeLoan.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/src/DAO/TypeLoanDAO.php');

$typeLoanDAO = new TypeLoanDAO();

if(isset($_GET['id'])) {
	$idLoan = $_GET['id'];
	$aTypeLoan = $typeLoanDAO->getTypeLoanByID($idLoan);
	if($aTypeLoan->getLoanID() != "") { 
	?>
<h3>Cập Nhật Thông Tin</h3>
<div>
    <form name="newad" method="post" action="/admin/control/EditTypeLoanAction.php" onSubmit="return checkaddtypeLoannew();">
    
    	<input type="hidden" name="matypeloan" id="matypeloan" value="<?php echo($aTypeLoan->getLoanID()) ?>" />
        <table>
            <tr>
                <th valign="top">Tên loại hình vay: </th>
                <td><input class="inputtextfield" type="text" name="tentypeloan" maxlength="200" id="tentypeloan" onFocus="showStyle(this)" onBlur="hiddenStyle(this)" value="<?php echo($aTypeLoan->getLoanName()) ?>" /><br>
			<font color="red"><span id="err_tentypeloan"></span></font></td>
            </tr>
            <tr>
                <th colspan="2"><input type="submit" value="Cập nhật" class="btnclra" style="width: 100px;" /></th>
            </tr>
        </table>
	</form>
</div>

<script>
function checkaddtypeLoannew() {
	//var ma = $.trim($('#manganhang').val());
	var ten = $.trim($('#tentypeloan').val());
	if(ten.length == 0) {
		alert("Tên loại hình vay không được bỏ trống");
		//$('#err_tentypeloan').text('Tên loại hình vay không được bỏ trống');
		$('#tentypeloan').focus();
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