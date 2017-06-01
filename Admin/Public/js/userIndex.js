$(function (){
	$("#mg_name").on({
		"keyup" : function (){
			that = $(this);
			$.ajax({
				url : "/resource/index.php?m=Admin&c=User&a=mgName",
				data : {"mg_name" : that.val()},
				dataType : "text",
				success : function (data){
					if(data == 1){
						that.next().text("用户名不可以为空");	
					}else if(data == 3){
						that.next().text("该用户名已存在");	
					}else{
						that.next().text("");	
					}
				}	
			});	
		},
		"blur" : function (){
			if($(this).val() == ""){
				$(this).next().text("用户名不可以为空");	
			}	
		}
	});
	
	$("#old_pwd").on("blur", function (){
		that = $(this);
		$.ajax({
			url : "/resource/index.php?m=Admin&c=User&a=oldPwd",
			data : {"old_pwd" : that.val()},
			dataType : "text",
			success : function (data){
				if(data == 1 || data == 2){
					that.next().text("");	
				}else{
					that.next().text("密码错误");	
				}	
			}	
		});
	});
	
	$("#mg_pwd_again").on("blur", function (){
		mg_pwd = $(this).parent().prev().children("input").val();
		mg_pwd_again = $(this).val();
		
		if(mg_pwd == mg_pwd_again){
			$(this).next().text("");		
		}else{
			$(this).next().text("两次密码不一致");		
		}
	});
});