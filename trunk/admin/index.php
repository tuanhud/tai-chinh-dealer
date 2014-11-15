<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/src/common/CommonFuns.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/src/DAO/ManagerUserDAO.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/src/DAO/AuthorizationDAO.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/src/entitys/ManagerUser.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/src/entitys/Authorization.php');

session_start();

date_default_timezone_set("Asia/Saigon");
$host  = $_SERVER['HTTP_HOST'];
$host = "http://$host/";

if(!isset($_SESSION['adminlogintcdealeronline'])) {
	header("Location: login.php");
	return;
}

$aAdminUser = unserialize($_SESSION['adminlogintcdealeronline']);
$authorizationDAO = new AuthorizationDAO();

$authorUser = $authorizationDAO->getInfoAuthorizationUser($aAdminUser->getUserID());
?>
<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml">
<head runat="server">
	<meta name="keywords" content="" />
	<meta name="description" content="" />
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<title>HỆ THỐNG QUẢN LÝ ĐẠI LÝ DÀNH CHO QUẢN TRỊ VIÊN</title>
	<link rel="stylesheet" type="text/css" href="<?php echo($host) ?>css/styledef.css"/>
	<link rel="stylesheet" type="text/css" href="<?php echo($host) ?>css/style_admin.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo($host) ?>css/messi.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo($host) ?>css/jquery-ui.css"/>
    <script type="text/javascript" src="<?php echo($host) ?>js/jquery-1.11.1.js"></script>
    <script type="text/javascript" src="<?php echo($host) ?>js/jquery-ui.js"></script>
    <script type="text/javascript" src="<?php echo($host) ?>js/messi.js"></script>
<?php  
if (isset($_GET['mess']) && $_GET['mess'] == "success") {
?>
   <script>
   	alert("Cập nhật thông tin thành công");
   </script>
<?php
} else if (isset($_GET['mess']) && $_GET['mess'] == "fail") {
?>
   <script>
   	alert("Cập nhật thông tin thất bại");
   </script>
<?php		
}
?>
</head>
<body>

<noscript><h3 style="color:red">Trình duyệt không hổ trợ javascript sẽ có 1 số chức năng không thể thực hiện được vui lòng kiểm tra và bật chế độ hổ trợ javascript</h3></noscript>
<div id="homepage"></div>
<div class="reveal-modal-bg"><div></div></div>
<div id="outer">
    <div id="header">
        
        <div id="nav">
            <ul>
            <?php 
            if ($authorUser->isInsertUser() || $authorUser->isDeleteUser() || $authorUser->isEditUser()) {
            ?>
            	<li>
                    <a href="/admin/?content=user">QL User</a>
                </li>
            <?php 
            }
            ?>
            <?php 
            if ($aAdminUser->isRoot()) {
            ?>
                <li>
                    <a href="/admin/?content=quanli">QL Hệ Thống</a>
                </li>
            <?php 
            }
            ?>
                <li>
                    <a href="/admin/?content=daily">QL Đại Lý</a>
                </li>
                <li>
                    <a href="/admin/?content=quanlykhac">Account Setting</a>
                </li>
                <li>
                    <a href="/admin/control/logout.php">Thoát</a>
                </li>
                <li class="last">
                	<span style="font-size: 17px; color: Red;">Xin chào <?php echo ($aAdminUser->getFullname())?>..!</span>
                </li>
            </ul><br class="clear" />
        </div>
    </div>
    <div id="main">
    	<?php
		if(isset($_GET['content'])) {
			$content = $_GET['content'];
			if($content == "user") {
				include('PageUserManager.php');
			} else if ($content == "quanli") {
				include('PageSystem.php');
			} else if($content == "quanlykhac") {
				include('AdminOther.php');
			} else if($content == "daily") {
				include('PageDealer.php');
			}
		}
		?>
        <!--<div id="sidebar">
            <div class="box">
                <h3>
                    Manage Question
                </h3>
                <div class="dateList">
                    <ul class="svertical">
                        <li class="first"><a href="../admin_question.aspx">All Question</a></li>
                        <li><a href="../admin_add_question.aspx" >New Question</a></li>	
                        <li><a href="../admin_category_question.aspx">Category Question</a></li>
                        <li><a href="../admin_question_table.aspx">Question Table</a></li>
                        <li class="last"><a href="../admin_new_question_table.aspx">New Question Table</a></li>
                    </ul>
                </div>
            </div>
            
        </div>
        <div id="content">
            <div class="box">
                <h3>code o day nua nha dai ca</h3>
                
            </div>
            <br class="clear" />
        </div>-->
        <br class="clear" />
    </div>
</div>
<div id="copyright">
    &copy; Tài Chính Online 2013-2014. Design by dlduynam.<br />Email: dlduynam@gmail.com.<br />Hổ trợ kỷ thuật: 01229.404.007
</div>

</body>
</html>

