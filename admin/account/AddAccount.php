<div class="album_content" style="min-height:700px;">
	<div class="info-account">
    	<div style="width: 100%; height: 30px; line-height: 30px; text-align: center; color: #0C9; font-weight: bold; margin-bottom: 10px;">
        	<h1>Thêm Account</h1>
        </div>
        <div style="width: 400px; margin: auto;">
        	<form method="post" id="form_add_account" action="#">
            	<input type="hidden" name="act" value="addAccount" />
                <table>
                    <tr>
                        <td>Username:</td>
                        <td><input type="text" maxlength="200" name="userID" id="userID" /></td>
                    </tr>
                    
                    <tr>
                        <td>Họ Tên:</td>
                        <td><input type="text" maxlength="255" name="fullname" id="fullname" /></td>
                    </tr>
                    
                    <tr>
                        <td>Password:</td>
                        <td><input type="text" maxlength="200" name="password" id="password" /></td>
                    </tr>
                    
                    <tr>
                        <td>Cho phép thêm mới user:</td>
                        <td><input type="checkbox" name="isAddUser" id="isAddUser" /> Cho phép</td>
                    </tr>
                    
                    <tr>
                        <td>Cho phép cập nhật user:</td>
                        <td><input type="checkbox" name="isEditUser" id="isEditUser" /> Cho phép</td>
                    </tr>
                    
                    <tr>
                        <td>Cho phép lock user:</td>
                        <td><input type="checkbox" name="isDeleteUser" id="isDeleteUser" /> Cho phép</td>
                    </tr>
                    
                    <tr>
                        <td>Cho phép chỉnh sửa hồ sơ:</td>
                        <td><input type="checkbox" name="isEditProfile" id="isEditProfile" /> Cho phép</td>
                    </tr>
                    
                    <tr>
                        <td>Cho phép delete hồ sơ:</td>
                        <td><input type="checkbox" name="isDelProfile" id="isDelProfile" /> Cho phép</td>
                    </tr>
                    
                    <tr>
                        <td align="right"><input type="button" class="btnclra add_account_submit" value="Thêm Account" style="width: 120px;" /></td>
                        <td align="left"><input type="reset" value="Reset" class="btnclra" style="width: 120px;" /></td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
</div>
<script>
$(document).ready(function(e) {
    $(".add_account_submit").click(function(e) {
        var userID = $.trim($("#userID").val());
		var fullname = $.trim($("#fullname").val());
		var password = $.trim($("#password").val());
		
		if (userID == "") {
			alert("Vui lòng nhập mã account");	
			return false;
		}
		if (fullname == "") {
			alert("Vui lòng nhập họ tên của account");
			return false;
		}
		if (password == "") {
			alert("Vui lòng nhập password đầu tiên cho account");
			return false;
		}
		
		$(".reveal-modal-bg").show();
		try {
			setTimeout(function(){				
				$.ajax({
					type: "POST",
					url: "/admin/control/ajax/AjaxCheckAccount.php",
					data: {'user': userID},
					success: function(response){
						if(response == "exist") {
							$(".reveal-modal-bg").hide();
							alert("Username của account đã tồn tại, vui lòng kiểm tra lại");
							return false;
						} else if(response != "success") {
							$(".reveal-modal-bg").hide();
							alert("Có lỗi xãy ra, vui lòng kiểm tra lại connect");
							return false;
						} else {
							$("#form_add_account").attr("action", "/admin/control/AdminUpdateAccount.php");
							$("#form_add_account").submit();
							return true;
						}
					},
					error: function (textStatus, errorThrown) {
						$(".reveal-modal-bg").hide();
						alert("Có lỗi xãy ra, vui lòng kiểm tra lại connect");
						return false;
					}
				});
			}, 500);
		} catch (ex) {
			$(".reveal-modal-bg").hide();
			alert("Có lỗi xãy ra, vui lòng kiểm tra lại connect");
			return false;
		} 
		return false;
    });
});
</script>