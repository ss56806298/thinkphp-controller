$(function (){
	$("#right div a:nth-of-type(2)").on("click", function (){
		var ids = [];
		
		for (i = 1; i < $("#right ul").length; i++){
			input = $("#right").children("ul").eq(i).children("li").eq(0).children("input");
			checked = input.prop("checked");
			if(checked){
				ids.push(input.val());
			}
		}
		
		$.ajax({
			url : "/resource/index.php?m=Admin&c=Account&a=delete",
			data : {"ids" : ids},
			dataType : "text",
			success : function (data){
				window.location.reload();
			}
		});
	});
	
	$("#right ul:nth-of-type(1) li:nth-of-type(1) input").on("click", function() {
		$("#right ul li:nth-of-type(1) input").prop("checked", $(this).prop("checked"));
	});
	
	$("#right ul li:nth-of-type(1) input").on("click", function (){
		flag = 1;
		for (i = 1; i < $("#right ul").length; i++){
			res = $("#right").children("ul").eq(i).children("li").eq(0).children("input").prop("checked");
			if(!res){
				flag = 0;
			}
		}
		
		if(flag){
			$("#right ul:nth-of-type(1) li:nth-of-type(1) input").prop("checked", "checked");
		}else{
			$("#right ul:nth-of-type(1) li:nth-of-type(1) input").removeProp("checked");	
		}
	});
	
	$("#right ul li:nth-of-type(7) a").on("click", function (){
		if($(this).text() == "登录"){
			id = $(this).prop("id");
			account = $(this).parent().prevAll().eq(4).text();
			server_num = parseInt($(this).parent().prevAll().eq(2).text());
			
			that = $(this);
			$.ajax({
				url : "/resource/index.php?m=Admin&c=Account&a=login",
				data : {"id" : id},
				dataType : "text",
				success : function (data){
					if(data == 1){
						$("#right ul li:nth-of-type(7) a").text("登录");
						$("#right ul li:nth-of-type(8)").text("");
						$("#right ul:nth-of-type(1) li:nth-of-type(8)").text("状态");
						that.text("退出");
						that.parent().next().text("已登录");
						$("#account").text(account);
						$("#server_num").text(server_num + " 区");
						
					}else if(data == 2){
						alert("您不具有操作该渠道的权限");
						
					}else{
						alert("登录失败");	
					}
				}
			});
		}
		
		if($(this).text() == "退出"){
			id = $(this).prop("id");
						
			that = $(this);
			$.ajax({
				url : "/resource/index.php?m=Admin&c=Account&a=logout",
				data : {"id" : id},
				dataType : "text",
				success : function (data){
					if(data == 1){
						that.text("登录");
						that.parent().next().text("");
						$("#account").text("未选择");
						$("#server_num").text("未选择");
					}else{
						alert("退出失败");	
					}
				}
			});
		}
	});
});