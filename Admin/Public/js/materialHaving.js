$(function (){
	$("#right").on("blur", "li", function (){
		var material_id = $(this).prevAll().eq(2).text();
		var num = $(this).text();
			
		if(isNaN(num)){
			$(this).css("color", "#ff0000");
			alert("素材数量必须是数字！");
			return;	
		}
		
		if(num < 0 || num > 999){
			$(this).css("color", "#ff0000");
			alert("素材数量必须在 0 - 999 之间！");
			return;
		}
		
		$.ajax({
			url : "/resource/index.php?m=Admin&c=Material&a=add",
			data : {
				"material_id" : material_id,
				"num" : num
			},
			success : function (){
				if(num == 0){
					window.location.reload();
				}
			}	
		});
	});
});