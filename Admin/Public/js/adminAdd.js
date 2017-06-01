$(function (){
	$("#mg_name").on({
		"keyup" : function (){
			that = $(this);
			$.ajax({
				url : "/resource/index.php?m=Admin&c=Admin&a=mgName",
				data : {"mg_name" : that.val()},
				dataType : "text",
				success : function (data){
					if(data == 1){
						that.next().text("用户名不可以为空");	
					}else if(data == 2){
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
	
	$("#mg_pwd").on("blur", function (){
		if($(this).val() == ""){
			$(this).next().text("密码不可以为空");	
		}else{
			$(this).next().text("");	
		}
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