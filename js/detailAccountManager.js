// JavaScript Document
$(document).ready(function(e) {
	resize();
	
	$( window ).resize(function() {
		resize();
	});
	
	function resize() {
		$(".box_add_dealer").height($(window).height());
		$(".content_box").height($(".box_add_dealer").height() - $(".box_header").height() - 70);
	}
	
	$(".close_add_dealer").click(function(e) {
		if($('.idcheckmanager:checked').length != 0) {
			if (!confirm("Có sự thay đổi nhưng chưa cập nhật, bạn có thật sự muốn đóng?")) {
				return;
			}
		}
		
		$(".full_box").slideUp(1000, function() {
			$(".full_box").hide();
		});
		$('body').css('overflow', 'auto');
    });
	
	$(window).bind('mousewheel DOMMouseScroll', function(event) {
        if($("body").css("overflow") == "hidden" && !$('.content_box').is(':hover')) {
            event.preventDefault(); 
        }
    });
	
	$(".add_dealer_submit").click(function(e) {
		addDealer();
	});
	
	$(".class-deletedealer-link").click(function(e) {
		if (!confirm("Bạn có thực sự muốn xóa đại lý khỏi người quản lý này?")) {
			return;
		}
		elem = $(this);
		var infoAccount = elem.attr("idpr");
		var userID = "<?php echo ($userID); ?>";
		
		try {
			$(".reveal-modal-bg").show();
			setTimeout(function(){				
				$.ajax({
					type: "POST",
					url: "/admin/control/ajax/AjaxAddDealerForAccount.php",
					data: {'action_dealer': 'delete', 'user': userID, 'emailDealer': infoAccount},
					success: function(response){
						if(response != "success") {
							$(".reveal-modal-bg").hide();
							alert("Cập nhật thông tin đại lý thất bại, vui lòng thử lại sau");
							return false;
						} else {
							$(".reveal-modal-bg").hide();
							alert("Cập nhật thông tin thành công!");
							elem.parent().parent().fadeOut(1000, function() {$(this).remove()});
						}
						return true;
					},
					error: function (textStatus, errorThrown) {
						$(".reveal-modal-bg").hide();
						alert("Cập nhật thông tin đại lý thất bại, vui lòng thử lại sau");
						return false;
					}
				});
			}, 500);
		} catch (ex) {
			$(".reveal-modal-bg").hide();
			$('.add_dealer_submit').removeAttr('disabled');
			alert("Cập nhật thông tin đại lý thất bại, vui lòng thử lại sau");
			return false;
		} 
		
	});
	
	function addDealer() {
		try {
			if($('.idcheckmanager:checked').length == 0) {
				alert("Vui lòng chọn đại lý cần thêm");
				return false;
			}
			$(".reveal-modal-bg").show();
			setTimeout(function(){
				$('.add_dealer_submit').attr('disabled','disabled');
				
				$.ajax({
					type: "POST",
					url: "/admin/control/ajax/AjaxAddDealerForAccount.php",
					data: $("#action_add_new_dealer").serialize(),
					success: function(response){
						if(response != "success") {
							$(".reveal-modal-bg").hide();
							alert("Cập nhật thông tin đại lý thất bại, vui lòng thử lại sau");
							$('.add_dealer_submit').removeAttr('disabled');
							return false;
						} else {
							$(".reveal-modal-bg").hide();
							alert("Cập nhật thông tin thành công!");
							window.location.reload();
							$('.add_dealer_submit').removeAttr('disabled');
						}
						return true;
					},
					error: function (textStatus, errorThrown) {
						$(".reveal-modal-bg").hide();
						$('.add_dealer_submit').removeAttr('disabled');
						alert("Cập nhật thông tin đại lý thất bại, vui lòng thử lại sau");
						return false;
					}
				});
			}, 500);
		} catch (ex) {
			$(".reveal-modal-bg").hide();
			$('.add_dealer_submit').removeAttr('disabled');
			alert("Cập nhật thông tin đại lý thất bại, vui lòng thử lại sau");
			return false;
		} 
	}
		
	$(".add_dealer_for_account").click(function(e) {
		try {
			$(".reveal-modal-bg").show();
			setTimeout(function(){
			
				$(".content_box table").html('<tr><th class="title" width="40px"></th><th class="title" width="80px">Mã KH</th><th class="title" width="250px">Email Đại Lý</th><th class="title">Họ Tên Đại Lý</th><th class="title" width="50px">GT</th><th class="title" width="150px">Điện Thoại</th><th class="title" width="150px">Tỉnh Thành</th></tr>');
				$('body').css('overflow', 'hidden');
				$('.add_dealer_for_account').attr('disabled','disabled');
				$.ajax({
					type: "POST",
					url: "/admin/control/ajax/AjaxLoadPageDealerAddForAccount.php",
					data:{},
					success: function(response){
						if(response != "") {
							$(".content_box table").html(response);
							$(".reveal-modal-bg").hide();
							$(".full_box").slideToggle(1000, function() {
								$(".full_box").show();
							});
						} else {
							$(".reveal-modal-bg").hide();
							alert("Load thông tin đại lý thất bại, vui lòng thử lại sau");
						}
						$('.add_dealer_for_account').removeAttr('disabled');
					},
					error: function (textStatus, errorThrown) {
						$(".reveal-modal-bg").hide();
						$('.add_dealer_for_account').removeAttr('disabled');
						$('body').css('overflow', 'auto');
						alert("Load thông tin đại lý thất bại, vui lòng thử lại sau");
					}
				});
			}, 500);
		} catch (ex) {
			$(".reveal-modal-bg").hide();
			$('.add_dealer_for_account').removeAttr('disabled');
			$('body').css('overflow', 'auto');
			alert("Load thông tin đại lý thất bại, vui lòng thử lại sau");
		} 
		
    });
	
	
	/* box change account manager */
	$(".class-changeaccount-link").click(function(e) {
		try {
			$(".reveal-modal-bg").show();
			
			$("#userDealer").val($(this).attr('idpr'));
			setTimeout(function(){
			
				$(".content_box1 table").html('');
				$('body').css('overflow', 'hidden');
				$.ajax({
					type: "POST",
					url: "/admin/control/ajax/AjaxLoadPageAccountChange.php",
					data:{'userCurrent': '<?php echo($userID) ?>'},
					success: function(response){
						if(response != "") {
							$(".content_box1 table").html(response);
							$(".reveal-modal-bg").hide();
							$(".full_box1").slideToggle(1000, function() {
								$(".full_box1").show();
							});
						} else {
							$(".reveal-modal-bg").hide();
							alert("Load thông tin thất bại, vui lòng thử lại sau");
							$("#userDealer").val('');
						}
					},
					error: function (textStatus, errorThrown) {
						$(".reveal-modal-bg").hide();
						$('body').css('overflow', 'auto');
						alert("Load thông tin thất bại, vui lòng thử lại sau");
						$("#userDealer").val('');
					}
				});
			}, 500);
		} catch (ex) {
			$(".reveal-modal-bg").hide();
			$('.add_dealer_for_account').removeAttr('disabled');
			$('body').css('overflow', 'auto');
			alert("Load thông tin thất bại, vui lòng thử lại sau");
			$("#userDealer").val('');
		} 
    });
	
	$(".close_change_account").click(function(e) {
		if($('.idcheckmanager:checked').length != 0) {
			if (!confirm("Có sự thay đổi nhưng chưa cập nhật, bạn có thật sự muốn đóng?")) {
				return;
			}
		}
		
		$(".full_box1").slideUp(1000, function() {
			$(".full_box1").hide();
		});
		$('body').css('overflow', 'auto');
    });
	
	$(".change_account_submit").click(function(e) {
        if($('.idcheckmanager:checked').length == 0) {
			alert("Bạn chưa thực hiện chọn account thay đổi quản trị");
			return;
		}
		try {
			$(".reveal-modal-bg").show();
			setTimeout(function(){
				$('.change_account_submit').attr('disabled','disabled');
				
				$.ajax({
					type: "POST",
					url: "/admin/control/ajax/AjaxAddDealerForAccount.php",
					data: $("#action_change_dealer").serialize(),
					success: function(response){
						if(response != "success") {
							$(".reveal-modal-bg").hide();
							alert("Cập nhật thông tin thất bại, vui lòng thử lại sau");
							$('.change_account_submit').removeAttr('disabled');
							return false;
						} else {
							$(".reveal-modal-bg").hide();
							alert("Cập nhật thông tin thành công!");
							window.location.reload();
							$('.change_account_submit').removeAttr('disabled');
						}
						return true;
					},
					error: function (textStatus, errorThrown) {
						$(".reveal-modal-bg").hide();
						$('.change_account_submit').removeAttr('disabled');
						alert("Cập nhật thông tin thất bại, vui lòng thử lại sau");
						return false;
					}
				});
			}, 500);
		} catch (ex) {
			$(".reveal-modal-bg").hide();
			$('.change_account_submit').removeAttr('disabled');
			$('body').css('overflow', 'auto');
			alert("Cập nhật thông tin thất bại, vui lòng thử lại sau");
		} 
    });
	
	/*
	box reset password
	*/
	$(".close_resetPassword").click(function(e) {
        $(".full_box2").slideUp(1000, function() {
			$(".full_box2").hide();
		});
		$('body').css('overflow', 'auto');
    });
	
	$(".class_resetPassword").click(function(e) {
        $(".reveal-modal-bg").show();
		
		setTimeout(function(){	
			$(".reveal-modal-bg").hide();
			$(".full_box2").slideToggle(1000, function() {
				$(".full_box2").show();
			});
		}, 500);
    });
	
	$(".changepassword_account_submit").click(function(e) {
        try {
			$(".reveal-modal-bg").show();
			setTimeout(function(){
				$('.changepassword_account_submit').attr('disabled','disabled');
				
				$.ajax({
					type: "POST",
					url: "/admin/control/ajax/AjaxUpdateAccount.php",
					data: $("#action_change_password_account").serialize(),
					success: function(response){
						if(response != "success") {
							$(".reveal-modal-bg").hide();
							alert("Cập nhật thông tin thất bại, vui lòng thử lại sau");
							$('.changepassword_account_submit').removeAttr('disabled');
							return false;
						} else {
							$(".reveal-modal-bg").hide();
							alert("Cập nhật thông tin thành công!");
							window.location.reload();
							$('.changepassword_account_submit').removeAttr('disabled');
						}
						return true;
					},
					error: function (textStatus, errorThrown) {
						$(".reveal-modal-bg").hide();
						$('.changepassword_account_submit').removeAttr('disabled');
						alert("Cập nhật thông tin thất bại, vui lòng thử lại sau");
						return false;
					}
				});
			}, 500);
		} catch (ex) {
			$(".reveal-modal-bg").hide();
			$('.changepassword_account_submit').removeAttr('disabled');
			$('body').css('overflow', 'auto');
			alert("Cập nhật thông tin thất bại, vui lòng thử lại sau");
		} 
    });
	
	$(".class_edit_account").click(function(e) {
        try {
			$(".reveal-modal-bg").show();
			setTimeout(function(){
				$('.class_edit_account').attr('disabled','disabled');
				
				$.ajax({
					type: "POST",
					url: "/admin/control/ajax/AjaxUpdateAccount.php",
					data: $("#form_acction_update_account_info").serialize(),
					success: function(response){
						if(response != "success") {
							$(".reveal-modal-bg").hide();
							alert("Cập nhật thông tin thất bại, vui lòng thử lại sau");
							$('.class_edit_account').removeAttr('disabled');
							return false;
						} else {
							$(".reveal-modal-bg").hide();
							alert("Cập nhật thông tin thành công!");
							window.location.reload();
							$('.class_edit_account').removeAttr('disabled');
						}
						return true;
					},
					error: function (textStatus, errorThrown) {
						$(".reveal-modal-bg").hide();
						$('.class_edit_account').removeAttr('disabled');
						alert("Cập nhật thông tin thất bại, vui lòng thử lại sau");
						return false;
					}
				});
			}, 500);
		} catch (ex) {
			$(".reveal-modal-bg").hide();
			$('.class_edit_account').removeAttr('disabled');
			$('body').css('overflow', 'auto');
			alert("Cập nhật thông tin thất bại, vui lòng thử lại sau");
		} 
    });
	
});