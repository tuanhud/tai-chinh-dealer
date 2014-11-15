<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/src/db/connectdatabase.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/src/DAO/AuthorizationLinkDealerAccountDAO.php');
session_start();

$result = 'fail';
if(isset($_SESSION['adminlogintcdealeronline'])) {
	try {
		if (isset($_POST['action_dealer'])) {
			if ($_POST['action_dealer'] == "add") {
				if(isset($_POST['user']) && isset($_POST['idcheckmanager'])) {
					$ids = $_POST['idcheckmanager'];
					$userID = $_POST['user'];
					$authorLink = new AuthorizationLinkDealerAccountDAO();
					foreach ($ids as $value) {
						$authorLink->addLinkAuthorForAccount($userID, $value);
					}
					$result = 'success';
				}
			} else if ($_POST['action_dealer'] == "delete") {
				if(isset($_POST['user']) && isset($_POST['emailDealer'])) {
					$authorLink = new AuthorizationLinkDealerAccountDAO();
					if ($authorLink->deleteLinkAuthorForAccount($_POST['user'], $_POST['emailDealer'])) {
						$result = 'success';
					}
				}
			} else if ($_POST['action_dealer'] == "change") {
				if(isset($_POST['userCurrent']) && isset($_POST['userDealer']) && isset($_POST['idcheckmanager'])) {
					$authorLink = new AuthorizationLinkDealerAccountDAO();
					if ($authorLink->changeLinkAuthorForAccount($_POST['userCurrent'], $_POST['idcheckmanager'], $_POST['userDealer'])) {
						$result = 'success';
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