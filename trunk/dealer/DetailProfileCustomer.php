<?php
$profileCustomerDAO = new ProfileCustomerDAO();
$fileProfileDAO = new FileProfileDAO();

if(isset($_GET['id'])) {
	$id = $_GET['id'];
	$arrprodetail = $profileCustomerDAO -> getProfileDetailByIDPro($email, $id);
	if (count($arrprodetail) > 0) {
		
		$fileProfiles = $fileProfileDAO -> getFileProfile($id);
?>
<style>
.class-content-records {border-bottom: 1px solid #98bf21;}
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
</style>
<div style="margin:auto; width:980px; text-align: center;"><h1 style="color:#88A943; text-transform:uppercase; margin:auto;">CHI TIẾT HỒ SƠ KHÁCH HÀNG: <?php echo($arrprodetail[0]->getNameCustomer()) ?></h1></div>
<div style="clear:both; height:15px;"></div>
<div style="font-size: 12px">
	<table width="700px" style="margin:auto; font-size: 12px">
    	<tr>
        	<th width="200px" align="left" valign="top">Họ và tên khách hàng</th>
            <td><strong><?php echo($arrprodetail[0]->getNameCustomer()) ?></strong></td>
        </tr>
        <tr><td colspan="2" class="class-content-records"></td></tr>
        <tr>
        	<th width="200px" align="left" valign="top">Số điện thoại</th>
            <td><strong><?php echo($arrprodetail[0]->getPhoneNumber()) ?></strong></td>
        </tr>
        <tr><td colspan="2" class="class-content-records"></td></tr>
        <tr>
        	<th valign="top" align="left">Khu vực</th>
            <td><?php echo($arrprodetail[0]->getProvince()) ?></td>
        </tr>
        <tr><td colspan="2"  class="class-content-records"></td></tr>
        <tr>
        	<th valign="top" align="left">Sản phẩm</th>
            <td><?php echo($arrprodetail[0]->getTypeLoan()->getLoanName()) ?></td>
        </tr>
        <tr><td colspan="2"  class="class-content-records"></td></tr>
        <tr>
        	<th valign="top" align="left">Ngày đăng</th>
            <td><?php echo(CommonFuns::int_to_date2($arrprodetail[0]->getDateCreateFirst())) ?></td>
        </tr>
        <tr><td colspan="2"  class="class-content-records"></td></tr>
        <tr>
        	<th valign="top" align="left">Trạng thái</th>
            <td><strong><?php echo($arrprodetail[0]->getStatus()->getStatusName()) ?></strong></td>
        </tr>
        <tr><td colspan="2"  class="class-content-records"></td></tr>
        <tr>
        	<th valign="top" align="left">Thông tin chi tiết</th>
            <td>
				<?php echo($arrprodetail[0]->getInfoProfile()."<br/>"); ?>
                <?php
				for ($i = 1; $i < count($arrprodetail); $i++) {
					echo("**************************************<br/>");
					echo("Ngày đăng: ".CommonFuns::int_to_date2($arrprodetail[$i]->getDateCreate())." <br/>");
					echo($arrprodetail[$i]->getInfoProfile()."<br/>");
				}
				?>
            </td>
        </tr>
        <tr><td colspan="2"  class="class-content-records"></td></tr>
        <tr>
        	<th valign="top" align="left">File hồ sơ của khách hàng</th>
            <td>
            	<ol>
            <?php
			for ($i = 0; $i < count($fileProfiles); $i++) {
				echo('<li>&nbsp;&nbsp;<a href="/'.$fileProfiles[$i] -> getLinkFile().'">Hồ sơ '.$fileProfiles[$i] -> getLinkFile().'</a></li>');
			}
			?>
            	</ol>
            </td>
        </tr>
        <tr><td colspan="2"  class="class-content-records"></td></tr>
        <tr>
        	<th valign="top" align="left">Tài Chính Online phản hồi</th>
            <td>
				<?php echo($arrprodetail[0]->getInfoRequest()."<br/>") ?>
                <?php
				for ($i = 1; $i < count($arrprodetail); $i++) {
					if (trim($arrprodetail[$i]->getInfoRequest()) != "") {
						echo("**************************************<br/>");
						echo("Ngày đăng: ".CommonFuns::int_to_date2($arrprodetail[$i]->getDateCreate())." <br/>");
						echo($arrprodetail[$i]->getInfoRequest()."<br/>");
					}
				}
				?>
            </td>
        </tr>
        <tr><td colspan="2"  class="class-content-records"></td></tr>
        <tr>
        	<th valign="top" align="left">Số tiền vay</th>
            <td><strong><?php if ($arrprodetail[0]->getAmountLoan() != "") { echo(CommonFuns::changnumbermoney($arrprodetail[0]->getAmountLoan())) ?> VNĐ <?php } ?></strong></td>
        </tr>
        <tr><td colspan="2"  class="class-content-records"></td></tr>
        <tr>
        	<th align="left" valign="top">Tổ chức cho vay</th>
            <td><strong><?php echo($arrprodetail[0]->getBankLoan()) ?></strong></td>
        </tr>
        <tr><td colspan="2"  class="class-content-records"></td></tr>
        <tr>
        	<th align="left" valign="top">Hoa hồng</th>
            <td><strong><?php if ($arrprodetail[0]->getHoaHong() != "") { echo(CommonFuns::changnumbermoney($arrprodetail[0]->getHoaHong()) )?> VNĐ<?php } ?></strong></td>
        </tr>
        <tr><td colspan="2"  class="class-content-records"></td></tr>
        <tr>
        	<th valign="top" align="left">Ngày cập nhật</th>
            <td><?php if($arrprodetail[0]->getDateUpdate() != "") echo(CommonFuns::int_to_date2($arrprodetail[0]->getDateUpdate())) ?></td>
        </tr>
        <tr><td colspan="2"  class="class-content-records"></td></tr>
        <tr>
        	<th colspan="2"><a href="/quanly/cap-nhat-ho-so/<?php echo($arrprodetail[0]->getIDProfile()) ?>/<?php echo(rewriteTextUrl(stripUnicode($arrprodetail[0]->getNameCustomer()))) ?>.html" data-reveal-id="formaddupdateprofilecustom"><input class="class-button-update" type="button" style="color: #FFF;" value="Cập nhật hồ sơ" /></a></th>
        </tr>
   </table>
</div>
<div style="clear: both; height: 20px;"></div>
<?php
if (count($arrprodetail) > 1) {
?>
<div style="margin:auto; width:980px; text-align: center;"><h2 style="color:#88A943; text-transform:uppercase; margin:auto;">Lịch Sử Giao Dịch</h2></div>
<div style="width: 980px; max-width: 980px;"  class="class-content-records">
	<table width="980px" cellpadding="0" cellspacing="0" style="font-size: 12px; border-collapse: collapse; margin-left:5px;">
        <tr>
            <th class="class-headertable" width="30px">STT</th>
            <th class="class-headertable" width="110px">Ngày login</th>
            <th class="class-headertable" width="140px">Tình trạng</th>
            <th class="class-headertable">Thông tin chi tiết</th>
            <th class="class-headertable" width="250px">Tài Chính Online phản hồi</th>
            <th class="class-headertable" width="110px">Ngày cập nhật</th>
        </tr>
        <?php
		$icount = 1;
		for ($icount = 1; $icount < count($arrprodetail); $icount++) {
		?>
        <tr>
        	<td align="center"><span><?php echo($icount) ?></span></td>
            <td align="center"><span><?php echo(CommonFuns::int_to_date2($arrprodetail[$icount]->getDateCreateFirst())); ?></span></td>
            <td align="center"><span><?php echo($arrprodetail[$icount]->getStatus()->getStatusName()); ?></span></td>
            <td align="left"><span><?php echo($arrprodetail[$icount]->getInfoProfile()); ?></span></td>
            <td align="left"><span><?php echo($arrprodetail[$icount]->getInfoRequest()); ?></span></td>
            <td align="center"><span><?php echo(CommonFuns::int_to_date2($arrprodetail[$icount]->getDateUpdate())); ?></span></td>
        </tr>
        <?php
		}
		?>
    </table>
</div>

<div style="clear: both; height: 20px;"></div>
<?php
}
?>

<style>

.class-headertable {
	height: 30px;
	margin: auto;
	background: rgb(136, 169, 67);
}
.class-content-records th {
	color: #FFF;
}

.class-content-records table tr {height: 30px;min-height: 30px;}
.class-content-records table tr {display: table-row;vertical-align: inherit;border-color: inherit;} 
.class-content-records table tr th, .class-content-records table tr td {border: 1px solid #98bf21;}

.class-button-update {
	border:none;
	background: #88A943;
	text-indent: 1px;
	width: 150px;
	height:30px;
	cursor: pointer;
	font-weight: bold;
	font-size: 12px;
	border-radius: 5px;
}
</style>
<?php
	}
}
?>