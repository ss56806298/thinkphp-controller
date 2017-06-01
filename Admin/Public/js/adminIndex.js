$(function (){
	$("#admin div:nth-of-type(1) a:nth-of-type(2)").on("click", function (){
		ids = [];
		for (i = 1; i < $("#admin ul").length; i++){
			res = $("#admin").children("ul").eq(i).children("li").eq(0).children("input").prop("checked");
			if(res){
				id = $("#admin").children("ul").eq(i).children("li").eq(1).text();
				ids.push(id);
			}
		}
		
		$.ajax({
			url : "/resource/index.php?m=Admin&c=Admin&a=unlock",
			data : {"mg_ids" : ids},
			success : function (){
				window.location.reload();	
			}
		});
	});
	
	$("#admin div:nth-of-type(1) a:nth-of-type(3)").on("click", function (){
		ids = [];
		for (i = 1; i < $("#admin ul").length; i++){
			res = $("#admin").children("ul").eq(i).children("li").eq(0).children("input").prop("checked");
			if(res){
				id = $("#admin").children("ul").eq(i).children("li").eq(1).text();
				ids.push(id);
			}
		}
		
		$.ajax({
			url : "/resource/index.php?m=Admin&c=Admin&a=lock",
			data : {"mg_ids" : ids},
			success : function (){
				window.location.reload();	
			}
		});
	});
	
	$("#admin div:nth-of-type(1) a:nth-of-type(4)").on("click", function (){
		ids = [];
		for (i = 1; i < $("#admin ul").length; i++){
			res = $("#admin").children("ul").eq(i).children("li").eq(0).children("input").prop("checked");
			if(res){
				id = $("#admin").children("ul").eq(i).children("li").eq(1).text();
				ids.push(id);
			}
		}
		
		$.ajax({
			url : "/resource/index.php?m=Admin&c=Admin&a=delete",
			data : {"mg_ids" : ids},
			success : function (){
				window.location.reload();	
			}
		});
	});
	
	$("#admin div:nth-of-type(1) a:nth-of-type(5)").on("click", function (){
		$(this).next("select").css("display", "inline-block");
		
		$(this).next("select").on("change", function (){
			ids = [];
			for (i = 1; i < $("#admin ul").length; i++){
				res = $("#admin").children("ul").eq(i).children("li").eq(0).children("input").prop("checked");
				if(res){
					id = $("#admin").children("ul").eq(i).children("li").eq(1).text();
					ids.push(id);
				}
			}
			
			role_id = $(this).val();
			
			$.ajax({
				url : "/resource/index.php?m=Admin&c=Admin&a=move",
				data : {
					"role_id" : role_id,
					"mg_ids" : ids
				},
				success : function (){
					window.location.reload();	
				}
			});
		});
	});
	
	$("#admin ul:nth-of-type(1) li:nth-of-type(1) input").on("click", function() {
		$("#admin ul li:nth-of-type(1) input").prop("checked", $(this).prop("checked"));
	});
	
	$("#admin ul li:nth-of-type(1) input").on("click", function (){
		flag = 1;
		for (i = 1; i < $("#admin ul").length; i++){
			res = $("#admin").children("ul").eq(i).children("li").eq(0).children("input").prop("checked");
			if(!res){
				flag = 0;
			}
		}
		
		if(flag){
			$("#admin ul:nth-of-type(1) li:nth-of-type(1) input").prop("checked", "checked");
		}else{
			$("#admin ul:nth-of-type(1) li:nth-of-type(1) input").removeProp("checked");	
		}
	});
});