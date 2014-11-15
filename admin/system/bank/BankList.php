<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/src/entitys/Bank.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/src/DAO/BankDAO.php');

$bankDao = new BankDAO();

$listBank = $bankDao->getBanks(-1);

?>
<div style="width: 100%; height: 30px; line-height: 30px; text-align: center; color: #0C9; font-weight: bold; margin-bottom: 10px;">
    <h1>Danh Sách Ngân Hàng</h1>
</div>
<div class="album_content">
	<form action="/admin/control/BankUpdateInfo.php" method="post" id="form_manager_action">
        <div class="the-buttom-edit-manager">
            <?php /*?><input type="hidden" name="act" id="id_action" value=""/><img src="../images/lockicon.png" width="25px" class="class-image-clock-buttom" />&nbsp;&nbsp;<img src="../images/unclockicon.png" width="25px" class="class-image-unclock-buttom" /><?php */?>
        </div>
        <div style="clear:both; height:10px;"></div>
        <div style="min-width: 100%;" class="listviewcontent">
            <table class="table-view-manager" cellspacing="1" cellpadding="0" border="0" style="width: 1120px;">
                <tr class="title_tr">
                    <th class="title" width="35px">STT</th>
                    <th class="title" width="50px">Detail</th>
                    <th class="title" width="50px">Lock</th>
                    <th class="title" width="150px">Mã Ngân Hàng</th>
                    <th class="title">Tên Ngân Hàng</th>
                    <th class="title" width="100px">Logo</th>
                    <th class="title" width="100px">Ngày Tạo</th>
                    <th class="title" width="100px">Ngày C.Nhật</th>
                </tr>
                <?php
                $i = 1;
                foreach($listBank as $aBank) {
                ?>
                <tr>
                    <td align="center"><?php echo($i) ?></td>
                    <td align="center"><a href="/admin/?content=quanli&p=edit-bank&id=<?php echo($aBank->getBankID()) ?>"><img src="/images/icon-detail.gif" width="20px" style="cursor: pointer;" idpr="<?php echo($aBank->getBankID()) ?>" class="class-detail-link" title="Cập nhật ngân hàng" /></a></td>
                    <td align="center"><?php if(!$aBank->isLock()) { ?><img src="/images/unclockicon.png" width="20px"  style="cursor: pointer;" class="class-display-link" idpr="<?php echo($aBank->getBankID()) ?>" /><?php } else { ?><img class="class-hiden-link" idpr="<?php echo($aBank->getBankID()) ?>" src="../images/lockicon.png" width="20px" style="cursor: pointer;" /><?php } ?></td>
                    <td align="center"><?php echo($aBank->getBankID()) ?></td>
                    <td><?php echo($aBank->getBankName()) ?></td>
                    <td align="center"><img width="95px;" src="/<?php echo($aBank->getBankLogo()) ?>" /></td>
                    <td align="center"><?php echo(CommonFuns::int_to_date($aBank->getDateCreated())) ?></td>
                    <td align="center"><?php echo(CommonFuns::int_to_date($aBank->getDateUpdate())) ?></td>
                </tr>
                <?php
                $i++;
                }
                ?>
            </table>
        </div>
        <div style="clear:both; height:15px;"></div>
	</form>
</div>
<script>
$(document).ready(function(e) {
    $(document).on('click', '.class-image-clock-buttom', function() {
		if($('.idcheckmanager:checked').length != 0) submitformmanager('lock');
		else alert('Vui lòng chọn thông tin cần cập nhật');
	});

	$(document).on('click', '.class-image-unclock-buttom', function() {
		if($('.idcheckmanager:checked').length != 0) submitformmanager('unlock');
		else alert('Vui lòng chọn thông tin cần cập nhật');
	});

	function submitformmanager(value) {
		$('#id_action').val(value);
		$('#form_manager_action').submit();
	}
	
	$(document).on('click', '.class-display-link', function() {
		elem = $(this);
		id = elem.attr('idpr');
		showWaiting();
		$.ajax({
			type: "POST",
			url: "/admin/control/ajax/AjaxUpdateInfoBank.php",
			data:{'action': 'lock', idpe: id},
			success: function(response) {
				if(response == 'success') {
					elem.parent().html('<img class="class-hiden-link" idpr="' + id + '" src="../images/lockicon.png" width="20px" style="cursor: pointer;" title="" />').hide().fadeIn(700);
				} else {
					alert("Cập nhật thất bại");
				}
				hideWaiting();
			}
		});
	});
	
	$(document).on('click', '.class-hiden-link', function() {
		elem = $(this);
		id = elem.attr('idpr');
		showWaiting();
		$.ajax({
			type: "POST",
			url: "/admin/control/ajax/AjaxUpdateInfoBank.php",
			data:{'action': 'unlock', idpe: id},
			success: function(response){
				if(response == 'success') {
					elem.parent().html('<img src="../images/unclockicon.png" width="20px" title="" style="cursor: pointer;" class="class-display-link" idpr="' + id + '" />').hide().fadeIn(700);
				} else {
					alert("Cập nhật thất bại");
				}
				hideWaiting();
			}
		});
	});

	function showWaiting() {
		$(".reveal-modal-bg").show();
	}

	function hideWaiting() {
		$(".reveal-modal-bg").hide();
	}
});
</script>