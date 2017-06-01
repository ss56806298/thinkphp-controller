$(function (){
	$("#right").on("click",  "a", function (){
		var weapon_id = $(this).parent().prevAll().eq(5).text();
		that = $(this);
		
		seajs.config({
			alias: {
				"jquery": "jquery.js",
				"dialog": "dialog-plus.js"
			}
		});
		
		seajs.use('dialog', function (dialog) {
			var d = dialog({
				content : "您确定要删除武器 " + weapon_id + " 吗？" ,
				ok : function (){
					$.ajax({
						url : "/resource/index.php?m=Admin&c=Weapon&a=delete",
						data : {"weapon_id" : weapon_id},
						dataType : "text",
						success : function (data){
							if(data == 1){
								alert("该武器存在于队列当中，无法删除！");	
							}else{
								window.location.reload();
							}
						}
					});
				},
				okValue : "确定",
				cancel : function (){
					return true;	
				},
				cancelValue : "取消",
				width : "150px",
				height : "40px",
			});
			
			d.showModal();
		});
	});
});