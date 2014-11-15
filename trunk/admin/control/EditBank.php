<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/src/db/connectdatabase.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/src/control/RedirectForward.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/src/entitys/Bank.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/src/DAO/BankDAO.php');
session_start();

$url = "/admin/?content=quanli&p=edit-bank";
if(isset($_SESSION['adminlogintcdealeronline'])) {
	if(isset($_POST['manganhang']) && isset($_POST['tennganhang'])) {
		$idbank = trim($_POST['manganhang']);
		$newname = trim($_POST['logobanktemp']);
		
		$url .= "&id=".$idbank;
		// up load file image
		// Ấn định  dung lượng file ảnh upload
		define ("MAX_SIZE","2048"); //1MB
		// hàm này đọc phần mở rộng của file. Nó được dùng để kiểm tra nếu
		// file này có phải là file hình hay không.
		function getExtension($str) {
			$i = strrpos($str,".");
			if (!$i) { return ""; }
			$l = strlen($str) - $i;
			$ext = substr($str,$i+1,$l);
			return $ext;
		}
		//This variable is used as a flag. The value is initialized with 0 (meaning no
		// error  found)
		//and it will be changed to 1 if an errro occures.
		//If the error occures the file will not be uploaded.
		$errors=0;
		// lấy tên file upload
		$image=$_FILES['logonganhang']['name'];
		// Nếu nó không rỗng
		if ($image) {
			// Lấy tên gốc của file
			$filename = stripslashes($_FILES['logonganhang']['name']);
			//Lấy phần mở rộng của file
			$extension = getExtension($filename);
			$extension = strtolower($extension);
			// Nếu nó không phải là file hình thì sẽ thông báo lỗi
			if (($extension != "jpg") && ($extension != "jpeg") && ($extension != "png") && ($extension != "gif")) {
				// xuất lỗi ra màn hình
				echo '<h1>Đây không phải là file hình!</h1>';
				$errors=1;
			} else {
				//Lấy dung lượng của file upload
				$size=filesize($_FILES['logonganhang']['tmp_name']);
				if ($size > MAX_SIZE*1024) {
					echo '<h1>Vượt quá dung lượng cho phép!</h1>';
					$errors=1;
				} else {
					// đặt tên mới cho file hình up lên
					$image_name=time().'.'.$extension;
					// gán thêm cho file này đường dẫn
					$newname="images/logobanks/".$image_name;
					// kiểm tra xem file hình này đã upload lên trước đó chưa
					$copied = copy($_FILES['logonganhang']['tmp_name'], "../../".$newname);
					if (!$copied) {
						echo '<h1> File hình này đã tồn tại </h1>';
						$errors=1;
					}
				}
			}
		}
		$namebank = trim($_POST['tennganhang']);
		$bank = new Bank();
		$bankDao = new BankDAO();
		$bank -> setBankID($idbank);
		$bank -> setBankName($namebank);
		$bank -> setBankLogo($newname);
		$bank -> setDateUpdate(time());
		
		if($bankDao -> updateBank($bank)) {
			$url .= "&mess=success";
		} else {
			$url .= "&mess=fail";
		}
	}
}
redirect($url);
?>