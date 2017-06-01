$(function (){
	$("#mg_true_name").on({
		"focus" : function (){
			$(this).next().text("");
		},
		"blur" : function (){
			if($(this).val() == ""){
				$(this).next().text("真实姓名不可以为空");	
			}else{
				$(this).next().text("");	
			}
		}
	});
	
	$("#mg_name").on({
		"keyup" : function (){
			that = $(this);
			mg_id = $("#save form p:nth-of-type(1) input").val();
			$.ajax({
				url : "/resource/index.php?m=Admin&c=Admin&a=mgNameSave",
				data : {
					"mg_id"	: mg_id,
					"mg_name" : that.val()
				},
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