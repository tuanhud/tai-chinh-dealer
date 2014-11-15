<?php
require_once('../../phpmailer/class.phpmailer.php');

function smtpmailer($subject, $body) { 
	// Khai báo tạo PHPMailer
	$mail = new PHPMailer();
	//Khai báo gửi mail bằng SMTP
	$mail->IsSMTP();
	$mail->CharSet = 'UTF-8';
	//Tắt mở kiểm tra lỗi trả về, chấp nhận các giá trị 0 1 2
	// 0 = off không thông báo bất kì gì, tốt nhất nên dùng khi đã hoàn thành.
	// 1 = Thông báo lỗi ở client
	// 2 = Thông báo lỗi cả client và lỗi ở server
	$mail->SMTPDebug  = 0;
	
	$mail->Debugoutput = "html"; // Lỗi trả về hiển thị với cấu trúc HTML
	$mail->Host       = "smtp.gmail.com"; //host smtp để gửi mail
	$mail->Port       = 465; // cổng để gửi mail
	$mail->SMTPSecure = "ssl"; //Phương thức mã hóa thư - ssl hoặc tls
	$mail->SMTPAuth   = true; //Xác thực SMTP
	$mail->Username   = "noreply.dlduynam@gmail.com"; // Tên đăng nhập tài khoản Gmail
	$mail->Password   = "daoleduynam"; //Mật khẩu của gmail
	$mail->SetFrom("noreply.dlduynam@gmail.com", "My Web"); // Thông tin người gửi
	$mail->AddReplyTo("noreply.dlduynam@gmail.com","My Web");// Ấn định email sẽ nhận khi người dùng reply lại.
	$mail->AddAddress("dlduynam@gmail.com", "Đào Lê Duy Nam");//Email của người nhận info@gmgroup.vn Tài Chính Online
	$mail->Subject = $subject; //Tiêu đề của thư
	$mail->MsgHTML($body); //Nội dung của bức thư.
	// $mail->MsgHTML(file_get_contents("email-template.html"), dirname(__FILE__));
	// Gửi thư với tập tin html
	//$mail->AltBody = "This is a plain-text message body";//Nội dung rút gọn hiển thị bên ngoài thư mục thư.
	//$mail->AddAttachment("images/attact-tui.gif");//Tập tin cần attach
	
	//Tiến hành gửi email và kiểm tra lỗi
	if(!$mail->Send()) {
	  return false;
	} else {
	  return true;
	}
}
?>