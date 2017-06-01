$(function (){
	$("#right").on("click", "a", function (){
		var monster_id = $(this).parent().prevAll().eq(6).text();
		that = $(this);
		
		seajs.config({
			alias: {
				"jquery": "jquery.js",
				"dialog": "dialog-plus.js"
			}
		});
		
		seajs.use('dialog', function (dialog) {
			var d = dialog({
				content : "您确定要删除英雄 " + monster_id + " 吗？" ,
				ok : function (){
					$.ajax({
						url : "/resource/index.php?m=Admin&c=Monster&a=delete",
						data : {"monster_id" : monster_id},
						dataType : "text",
						success : function (data){
							if(data == 1){
								alert("该英雄存在于队列当中，无法删除！");	
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