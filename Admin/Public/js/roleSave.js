$(function (){
	$("#role_name").on({
		"keyup" : function (){
			that = $(this);
			role_id = $("#save form p:first-child input").val();
			$.ajax({
				url : "/resource/index.php?m=Admin&c=Role&a=roleNameSave",
				data : {
					"role_id" : role_id,
					"role_name" : that.val()
				},
				dataType : "text",
				success : function (data){
					if(data == 1){
						that.next().text("角色名不可以为空");	
					}else if(data == 3){
						that.next().text("该角色名已存在");	
					}else{
						that.next().text("");	
					}
				}	
			});	
		},
		"blur" : function (){
			if($(this).val() == ""){
				$(this).next().text("角色名不可以为空");	
			}	
		}
	});
	
	$("#save form fieldset ul li:nth-of-type(1) label input").on("click", function() {
		$(this).parent().parent().nextAll("li").find("input").prop("checked", $(this).prop("checked"));
	});
	
	$("#save form fieldset:nth-of-type(1) ul li").not(":first-child").find("input").on("click", function (){
		flag = 0;
		for (i = 1; i < $(this).parents().eq(2).find("input").length; i++){
			res = $(this).parents().eq(2).children("li").eq(i).find("input").prop("checked");
			if(res){
				flag = 1;
				break;
			}
		}
		
		if(flag){
			$(this).parents().eq(2).children("li").eq(0).find("input").prop("checked", "checked");
		}else{
			$(this).parents().eq(2).children("li").eq(0).find("input").removeProp("checked");	
		}
	});
	
	$("#save form fieldset:nth-of-type(2) ul li").not(":first-child").find("input").on("click", function (){
		flag = 1;
		for (i = 1; i < $(this).parents().eq(2).find("input").length; i++){
			res = $(this).parents().eq(2).children("li").eq(i).find("input").prop("checked");
			if(!res){
				flag = 0;
				break;
			}
		}
		
		if(flag){
			$(this).parents().eq(2).children("li").eq(0).find("input").prop("checked", "checked");
		}else{
			$(this).parents().eq(2).children("li").eq(0).find("input").removeProp("checked");	
		}
	});
});