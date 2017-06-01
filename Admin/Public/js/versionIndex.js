$(function (){
	$("#version ul li:nth-of-type(3)").on({
		"focus" : function (){
			$(this).css("color", "#000000");
			updateVersion = $(this).next().text().split(".");
			oldVersion = updateVersion[0] + "." + updateVersion[1] + "." + updateVersion[2];
		},
		"blur" : function (){
			newVersion = $(this).text();
			id = $(this).prop("id");
			
			if(oldVersion == newVersion){
				return;	
			}
			
			that = $(this);
			$.ajax({
				url : "/resource/index.php?m=Admin&c=Version&a=saveVersion",
				data : {
					"id" : id,
					"version" : newVersion
				},
				dataType : "text",
				success : function (data){
					if(data == 1){
						that.css("color", "#ff0000");
						alert("您没有修改版本号的权限");
						
					}else if(data == 2){
						that.css("color", "#ff0000");
						alert("版本号格式错误");
						
					}else if(data == 3){
						that.css("color", "#ff0000");
						alert("文件写入失败");
						
					}else{
						that.next().text(data);	
					}
				}
			});
		}
	});
});