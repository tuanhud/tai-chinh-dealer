<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/src/db/connectdatabase.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/src/entitys/Dealer.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/src/DAO/DealerDAO.php');
session_start();

$result = '';

if(isset($_SESSION['adminlogintcdealeronline'])) {
	try {
		$dealerDAO = new DealerDAO();
		
		$dealers = $dealerDAO -> getDealersAddForDealer();
		$result = '<tr><th class="title" width="40px"></th><th class="title" width="80px">Mã KH</th><th class="title" width="250px">Email Đại Lý</th><th class="title">Họ Tên Đại Lý</th><th class="title" width="50px">GT</th><th class="title" width="150px">Điện Thoại</th><th class="title" width="150px">Tỉnh Thành</th></tr>';
		
		if (count($dealers) > 0) {
			foreach($dealers as $entry) {
				$gender = "Nữ";
				if($entry->getGender())  {
					$gender = "Nam";
				}
				$result .= '<tr>';
				$result .= '	<td align="center"><input type="checkbox" name="idcheckmanager[]" class="idcheckmanager" value="'.$entry->getEmailDealer().'" /></td>';
				$result .= '	<td align="center">'.$entry->getIDCODE().'</td>';
				$result .= '	<td>'.$entry->getEmailDealer().'</td>';
				$result .= '	<td>'.$entry->getFullname().'</td>';
				$result .= '	<td align="center">'.$gender.'</td>';
				$result .= '	<td align="center">'.$entry->getMobile().'</td>';
				$result .= '	<td align="center">'.$entry->getProvince().'</td>';
				$result .= '</tr>';
			}
		}
	} catch (Exception $e) {
		//echo 'Caught exception: ',  $e->getMessage(), "\n";
		$result = '';
	}
}
echo ($result);
?>