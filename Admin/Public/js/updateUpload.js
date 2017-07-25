$(function (){
	$("#upload form p #platforms").on("change", function (){
		if($(this).val() != "请选择"){
			$.ajax({
				url : "/resource/index.php?m=Admin&c=Update&a=platform",
				data : {"platform" : $(this).val()},
				dataType : "json",
				success : function (data){
					str = "<option>请选择</option>";
					for(i = 0; i < data.length; i++){
						str += "<option>" + data[i] + "</option>";	
					}
					// $("#os").html(str);
					$("#file").removeAttr("disabled");
					$("#submit").removeAttr("disabled");
				}	
			});
		}else{
			str = "<option>请选择</option>";
			$("#os").html(str);	
			$("#version").text("未知");
			$("#file").attr("disabled", "disabled");
			$("#submit").attr("disabled", "disabled");
		}
	});
	
	// $("#upload form p #os").on("change", function (){
	// 	if($(this).val() != "请选择"){
	// 		$.ajax({
	// 			url : "/resource/index.php?m=Admin&c=Update&a=os",
	// 			data : {
	// 				"platform" : $("#platforms").val(),
	// 				"os" : $(this).val()
	// 			},
	// 			dataType : "text",
	// 			success : function (data){
	// 				$("#version").text(data);
	// 				$("#file").removeAttr("disabled");
	// 				$("#submit").removeAttr("disabled");
	// 			}	
	// 		});
	// 	}else{
	// 		$("#version").text("未知");
	// 		$("#file").attr("disabled", "disabled");
	// 		$("#submit").attr("disabled", "disabled");
	// 	}
	// });
});