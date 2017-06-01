$(function (){
	$("#role div:nth-of-type(1) a:nth-of-type(2)").on("click", function (){
		ids = [];
		for (i = 1; i < $("#role ul").length; i++){
			res = $("#role").children("ul").eq(i).children("li").eq(0).children("input").prop("checked");
			if(res){
				id = $("#role").children("ul").eq(i).children("li").eq(1).text();
				ids.push(id);
			}
		}
		
		$.ajax({
			url : "/resource/index.php?m=Admin&c=Role&a=unlock",
			data : {"role_ids" : ids},
			success : function (){
				window.location.reload();	
			}
		});
	});
	
	$("#role div:nth-of-type(1) a:nth-of-type(3)").on("click", function (){
		ids = [];
		for (i = 1; i < $("#role ul").length; i++){
			res = $("#role").children("ul").eq(i).children("li").eq(0).children("input").prop("checked");
			if(res){
				id = $("#role").children("ul").eq(i).children("li").eq(1).text();
				ids.push(id);
			}
		}
		
		$.ajax({
			url : "/resource/index.php?m=Admin&c=Role&a=lock",
			data : {"role_ids" : ids},
			dataType : "json",
			success : function (data){
				if(data.length != 0){
					str = "";
					for(i = 0; i < data.length; i++){
						str += data[i] + " ";
					}
					str += "锁定失败，原因：该角色为空";
					alert(str);
				}
				window.location.reload();	
			}
		});
	});
	
	$("#role div:nth-of-type(1) a:nth-of-type(4)").on("click", function (){
		ids = [];
		for (i = 1; i < $("#role ul").length; i++){
			res = $("#role").children("ul").eq(i).children("li").eq(0).children("input").prop("checked");
			if(res){
				id = $("#role").children("ul").eq(i).children("li").eq(1).text();
				ids.push(id);
			}
		}
		
		$.ajax({
			url : "/resource/index.php?m=Admin&c=Role&a=delete",
			data : {"role_ids" : ids},
			dataType : "json",
			success : function (data){
				if(data.length != 0){
					str = "";
					for(i = 0; i < data.length; i++){
						str += data[i] + " ";
					}
					str += "删除失败，原因：该角色非空";
					alert(str);
				}
				window.location.reload();
			}
		});
	});
	
	$("#role ul:nth-of-type(1) li:nth-of-type(1) input").on("click", function() {
		$("#role ul li:nth-of-type(1) input").prop("checked", $(this).prop("checked"));
	});
	
	$("#role ul li:nth-of-type(1) input").on("click", function (){
		flag = 1;
		for (i = 1; i < $("#role ul").length; i++){
			res = $("#role").children("ul").eq(i).children("li").eq(0).children("input").prop("checked");
			if(!res){
				flag = 0;
			}
		}
		
		if(flag){
			$("#role ul:nth-of-type(1) li:nth-of-type(1) input").prop("checked", "checked");
		}else{
			$("#role ul:nth-of-type(1) li:nth-of-type(1) input").removeProp("checked");	
		}
	});
});