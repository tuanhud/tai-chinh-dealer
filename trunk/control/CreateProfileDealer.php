<?php
session_start();
include_once($_SERVER['DOCUMENT_ROOT'].'/src/db/connectdatabase.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/src/model/ChangeURL.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/src/control/RedirectForward.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/src/entitys/Status.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/src/entitys/TypeLoan.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/src/entitys/FileProfile.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/src/entitys/ProfileCustomer.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/src/DAO/ProfileCustomerDAO.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/src/DAO/StatusDAO.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/src/DAO/TypeLoanDAO.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/src/DAO/AuthorizationLinkDealerAccountDAO.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/src/DAO/FileProfileDAO.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/src/DAO/DealerDAO.php');
date_default_timezone_set("Asia/Saigon");

$profileDAO = new ProfileCustomerDAO();
$fileProfileDAO = new FileProfileDAO();
$authorLinkDealerDAO = new AuthorizationLinkDealerAccountDAO();
$dealerDAO = new DealerDAO();


if(isset($_SESSION['taichinhondealer'])) {
	$emailacc = $_SESSION['taichinhondealer'];
	if(isset($_POST['act'])) {
		$act = $_POST['act'];
		
		$mess = "fail";
		
		if($act == "add") {
			if(isset($_POST['From_NameCus']) && isset($_POST['From_Provincecus']) && isset($_POST['form_typeloan']) && isset($_POST['form_infointro']) && isset($_POST['From_phoneCus'])) {
				$nameimagesave = array();
				$newname = "";
				// up load file image
				// Ấn định  dung lượng file ảnh upload
				define ("MAX_SIZE","2048"); //2MB
				// hàm này đọc phần mở rộng của file. Nó được dùng để kiểm tra nếu
				// file này có phải là file hình hay không .
				function getExtension($str) {
					$i = strrpos($str,".");
					if (!$i) { return ""; }
					$l = strlen($str) - $i;
					$ext = substr($str,$i+1,$l);
					return $ext;
				}
				
				$errors=0;
				// lấy tên file upload
				$countfilename = 0;
				foreach ($_FILES['filenameprofile']['tmp_name'] as $key => $tmp_name) {
					$filename = $key.$_FILES['filenameprofile']['name'][$key];
					$file_size =$_FILES['filenameprofile']['size'][$key];
					$file_tmp =$_FILES['filenameprofile']['tmp_name'][$key];
					$file_type=$_FILES['filenameprofile']['type'][$key];
					
					
					$image= $filename;
					
					// Nếu nó không rỗng
					if ($image) {
						// Lấy tên gốc của file
						$filename = stripslashes($image);
						//echo($filename);
						//Lấy phần mở rộng của file
						$extension = getExtension($filename);
						$extension = strtolower($extension);
						// Nếu nó không phải là file hình thì sẽ thông báo lỗi
						if (($extension != "rar") && ($extension != "zip") &&($extension != 'doc') &&($extension != 'docx') && ($extension != 'xls') && ($extension != 'xlsx') && ($extension != 'jpg') && ($extension != 'png')) {
							// xuất lỗi ra màn hình
							//echo '<h1>Đây không phải là file hình!</h1>';
							$errors=1;
							break;
						} else {
							//Lấy dung lượng của file upload
							if ($file_size > MAX_SIZE*1024) {
								//echo '<h1>Vượt quá dung lượng cho phép!</h1>';
								$errors=1;
								break;
							} else {
								// đặt tên mới cho file hình up lên
								$image_name=time().'.'.$extension;
								// gán thêm cho file này đường dẫn
								$newname="profilecutomer/".$image_name;
								// kiểm tra xem file hình này đã upload lên trước đó chưa
								$copied = copy($file_tmp, $newname);
								if (!$copied) {
									//echo '<h1> File này đã tồn tại </h1>';
									$errors=1;
								} else
									array_push($nameimagesave, $newname);
									$countfilename++;
							}
						}
					}
				}
				if($errors == 0) {
					$profile = new ProfileCustomer();
					$idpro = time();
					$profile->setIDProfile($idpro);
					$profile->setDateCreate($idpro);
					$profile->setEmailDealer($emailacc);
					$profile->setNameCustomer(trim($_POST['From_NameCus']));
					$profile->setPhoneNumber(trim($_POST['From_phoneCus']));
					$profile->setProvince(trim($_POST['From_Provincecus']));
					
					$status = new Status();
					$status -> setStatusID("00000000");
					$profile->setStatus($status);
					
					$typeLoan = new TypeLoan();
					$typeLoan->setLoanID(trim($_POST['form_typeloan']));
					
					$profile->setTypeLoan($typeLoan);
					$profile->setInfoProfile(trim($_POST['form_infointro']));
					
					$userManager = $authorLinkDealerDAO->getInfoUserManagerByDealer($emailacc);
					if ($userManager == "") {
						header("Location: /quanly/profile.html&mess=error");
						return;
					}
					$profile->setUserManager($userManager);
					
					$codeID = $dealerDAO->getInfoCodeByDealer($emailacc);
					if ($codeID == "") {
						header("Location: /quanly/profile.html&mess=error");
						return;
					}
					$profile->setIDCODE($codeID);
					
					if($profileDAO->insertProfileDealer($profile)) {
						if(count($nameimagesave) > 0) {
							foreach ($nameimagesave as $link) {
								$fileProfile = new FileProfile();
								$fileProfile->setLinkFile($link);
								$fileProfile->setIdProfile($profile->getIDProfile());
								$fileProfile->setDateCreated($profile->getDateCreate());
								if ($fileProfileDAO->insertFileProfile($fileProfile)) {
									
								}
							}
						}
						header("Location: /quanly/profile.html&mess=success");
						//echo("ok");
						return;
					} else {
						header("Location: /quanly/profile.html&mess=error");
						return;
					}
				} else {
					header("Location: /quanly/profile.html&mess=error");
					return;
				}
			}
		} else if($act == "edit") { // update info
			if(isset($_POST['Form_id']) && isset($_POST['Form_id_date']) && isset($_POST['form_infointro'])) {
				$newname = "";
				$nameimagesave = array();
				// up load file image
				// Ấn định  dung lượng file ảnh upload
				define ("MAX_SIZE","2048"); //2MB
				// hàm này đọc phần mở rộng của file. Nó được dùng để kiểm tra nếu
				// file này có phải là file hình hay không .
				function getExtension($str) {
					$i = strrpos($str,".");
					if (!$i) { return ""; }
					$l = strlen($str) - $i;
					$ext = substr($str,$i+1,$l);
					return $ext;
				}
				
				$errors=0;
				// lấy tên file upload
				$countfilename = 0;
				foreach ($_FILES['filenameprofile']['tmp_name'] as $key => $tmp_name) {
					
					$filename = $key.$_FILES['filenameprofile']['name'][$key];
					$file_size =$_FILES['filenameprofile']['size'][$key];
					$file_tmp =$_FILES['filenameprofile']['tmp_name'][$key];
					$file_type=$_FILES['filenameprofile']['type'][$key];
					
					
					$image= $filename;
					// Nếu nó không rỗng
					if ($image) {
						// Lấy tên gốc của file
						$filename = stripslashes($image);
						//echo($filename);
						//Lấy phần mở rộng của file
						$extension = getExtension($filename);
						$extension = strtolower($extension);
						// Nếu nó không phải là file hình thì sẽ thông báo lỗi
						if (($extension != "rar") && ($extension != "zip") &&($extension != 'doc') &&($extension != 'docx') && ($extension != 'xls') && ($extension != 'xlsx') && ($extension != 'jpg') && ($extension != 'png')) {
							// xuất lỗi ra màn hình
							//echo '<h1>Đây không phải là file hình!</h1>';
							$errors=1;
							break;
						} else {
							//Lấy dung lượng của file upload
							if ($file_size > MAX_SIZE*1024) {
								//echo '<h1>Vượt quá dung lượng cho phép!</h1>';
								$errors=1;
								break;
							} else {
								// đặt tên mới cho file hình up lên
								$image_name=time().'.'.$extension;
								// gán thêm cho file này đường dẫn
								$newname="profilecutomer/".$image_name;
								// kiểm tra xem file hình này đã upload lên trước đó chưa
								$copied = copy($file_tmp, $newname);
								if (!$copied) {
									//echo '<h1> File này đã tồn tại </h1>';
									$errors=1;
								} else
									array_push($nameimagesave, $newname);
									$countfilename++;
							}
						}
					}
				}
				
				$idpro = $_POST['Form_id'];
				if($errors == 0) {
					
					$profile = new ProfileCustomer();
					
					$profile = $profileDAO->getProfileByIDProOnly($idpro, $_POST['Form_id_date']);
					if ($profile->getIDProfile() == "") {
						$_SESSION['mess'] = "fail";
						header("Location: /quanly/cap-nhat-ho-so/".$idpro."/error.html");
						return;
					}
					
					$profile->setInfoProfile(trim($_POST['form_infointro']));
					$profile->setDateUpdate(time());
					$profile->setDateCreate(time());
					
					$userManager = $authorLinkDealerDAO->getInfoUserManagerByDealer($emailacc);
					if ($userManager == "") {
						$_SESSION['mess'] = "fail";
						header("Location: /quanly/cap-nhat-ho-so/".$idpro."/error.html");
						return;
					}
					$profile->setUserManager($userManager);
					
					$codeID = $dealerDAO->getInfoCodeByDealer($emailacc);
					if ($codeID == "") {
						$_SESSION['mess'] = "fail";
						header("Location: /quanly/cap-nhat-ho-so/".$idpro."/error.html");
						return;
					}
					$profile->setIDCODE($codeID);
					
					
					$profile->setInfoProfile(trim($_POST['form_infointro']));
					
					$profileBackup = new ProfileCustomer();
					$profileBackup->setIDProfile($idpro);
					$profileBackup->setDateCreate($_POST['Form_id_date']);
					$profileBackup->setIsBackup(true);
					$profileBackup->setUserBackup($emailacc);
					if($profileDAO->backupProfileDealer($profileBackup)) {
						if ($profileDAO->insertProfileDealer($profile)) {
							if(count($nameimagesave) > 0) {
								foreach ($nameimagesave as $link) {
									$fileProfile = new FileProfile();
									$fileProfile->setLinkFile($link);
									$fileProfile->setIdProfile($profile->getIDProfile());
									$fileProfile->setDateCreated($profile->getDateCreate());
									if ($fileProfileDAO->insertFileProfile($fileProfile)) {
										
									}
								}
							}
							$_SESSION['mess'] = "success";
							header("Location: /quanly/cap-nhat-ho-so/".$idpro."/success.html");
							return;
						} else {
							$_SESSION['mess'] = "fail";
							header("Location: /quanly/cap-nhat-ho-so/".$idpro."/error.html");
							return;
						}
					} else {
						$_SESSION['mess'] = "fail";
						header("Location: /quanly/cap-nhat-ho-so/".$idpro."/error.html");
						return;
					}
				} else {
					$_SESSION['mess'] = "fail";
					header("Location: /quanly/cap-nhat-ho-so/".$idpro."/error.html");
					return;
				}
			}
		} else {
			header("Location: /quanly/profile.html");
			return;
		}
		
		
		
		
	} else {
		header("Location: /quanly/profile.html");
		return;
	}
} else {
	header("Location: /");
	return;
}
?>