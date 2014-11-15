<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/src/db/connectdatabase.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/src/entitys/Status.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/src/DAO/StatusDAO.php');
session_start();

$result = 'fail';
if(isset($_SESSION['adminlogintcdealeronline'])) {
	try {
		if (isset($_POST['action'])) {
			if ($_POST['action'] == "lock") {
				if (isset($_POST['idpe'])) {
					$IDStatus = trim($_POST['idpe']);
					if ($IDStatus != "") {
						$statusDAO = new StatusDao();
						$status = new Status();
						$status->setStatusID($IDStatus);
						$status->setIsLock(true);
						$status->setDateUpdate(time());
						
						if ($statusDAO->lockStatus($status)) {
							$result = 'success';
						}
					}
				}
			} else if ($_POST['action'] == "unlock") {
				if (isset($_POST['idpe'])) {
					$IDStatus = trim($_POST['idpe']);
					if ($IDStatus != "") {
						$statusDAO = new StatusDao();
						$status = new Status();
						$status->setStatusID($IDStatus);
						$status->setIsLock(false);
						$status->setDateUpdate(time());
						
						if ($statusDAO->lockStatus($status)) {
							$result = 'success';
						}
					}
				}
			}
		}
	} catch (Exception $e) {
		//echo 'Caught exception: ',  $e->getMessage(), "\n";
		$result = 'fail';
	}
}
echo ($result);
?>