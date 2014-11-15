<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/src/db/connectdatabase.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/src/entitys/ManagerUser.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/src/DAO/ManagerUserDAO.php');
session_start();

$result = '';
if(isset($_SESSION['adminlogintcdealeronline'])) {
	try {
		
		if(isset($_POST['userCurrent'])) {
			$managerUserDAO = new ManagerUserDAO();
			
			$accounts = $managerUserDAO -> getInfoPageChangeAccount($_POST['userCurrent']);
			$result = '<tr><th class="title" width="40px"></th><th class="title" width="80px">ID Acount</th><th class="title">Tên Account</th></tr>';
			
			if (count($accounts) > 0) {
				foreach($accounts as $entry) {
					$result .= '<tr>';
					$result .= '	<td align="center"><input type="radio" name="idcheckmanager" class="idcheckmanager" value="'.$entry->getUserID().'" /></td>';
					$result .= '	<td align="center">'.$entry->getUserID().'</td>';
					$result .= '	<td>'.$entry->getFullname().'</td>';
					$result .= '</tr>';
				}
			}
		}
	} catch (Exception $e) {
		//echo 'Caught exception: ',  $e->getMessage(), "\n";
		$result = '';
	}
}
echo ($result);
?>