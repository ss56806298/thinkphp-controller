$(function (){
	$("#mg_name").focus();
	
	$("#verify_code").on("keyup", function (event){
		var that = $(this);
		$.ajax({
			url : "/resource/index.php?m=Admin&c=Manager&a=checkVerify",
			data : {"verifyCode" : that.val()},
			dataType : "text",
			success : function (data){
				if(data == 1){
					that.next().css("display", "block");	
				}
			}
		});
		
		if(event.which == 13){
			if($("#mg_name").val().length == 0){
				$("#tips").text("用户名不能为空");
				
			}else if($("#mg_pwd").val().length == 0){
				$("#tips").text("密码不能为空");	
				
			}else if($("#verify_code").val().length == 0){
				$("#tips").text("验证码不能为空");
			}
		}
	});
	
	$("#verify").on("click", function (){
		src = $(this).prop("src");
		$(this).prop("src", src + "&r=" + Math.random());	
	});
	
	$("#change").on("click", function (){
		src = $("#verify").prop("src");
		$("#verify").prop("src", src + "&r=" + Math.random());	
	});
	
	$("#login").on("click", function (event){
		if($("#mg_name").val().length == 0){
			$("#tips").text("用户名不能为空");
			event.preventDefault();
			
		}else if($("#mg_pwd").val().length == 0){
			$("#tips").text("密码不能为空");	
			event.preventDefault();
			
		}else if($("#verify_code").val().length == 0){
			$("#tips").text("验证码不能为空");
			event.preventDefault();
		}
	});
});