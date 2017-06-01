$(function (){
	search = window.location.search;
	search = search.split("&", 3);
	search = search[0] + "&" + search[1] + "&" + search[2];
	url = window.location.pathname + search;
	ul = $("#left #menu div ul").find("a[href='" + url + "']").parent().parent();
	if(ul.get(0)){
		ul.parent().css("border-left", "5px solid #19aa8d");
		ul.prev().children("i").removeClass("fa-angle-left").addClass("fa-angle-down");
		ul.css("display", "block");
	}else{
		div = $("#left #menu div").children("a[href='" + url + "']").parent();
		div.css("border-left", "5px solid #19aa8d");
		div.children("a").children("i").removeClass("fa-angle-left").addClass("fa-angle-down");
		div.children("ul").css("display", "block");
	}
	
	$("#left #info div div a").on("click", function (){
		seajs.config({
			alias: {
				"jquery": "jquery.js",
				"dialog": "dialog-plus.js"
			}
		});
		
		seajs.use('dialog', function (dialog) {
			var d = dialog({
				content : "确定要退出吗?",
				ok : function (){
					$.ajax({
						url : "/resource/index.php?m=Admin&c=Manager&a=logout",
						success : function (){
							window.location.href="/resource/index.php?m=Admin&c=Manager&a=login";
						}
					});
				},
				okValue : "确定",
				cancel : function (){
					return true;	
				},
				cancelValue : "取消",
				width : "200px",
			});
			
			d.showModal();
		});	
	});
	
	$("#left #menu div").on({
		"mouseenter" : function (){
			if($(this).children("ul").css("display") == "none"){
				$(this).css("border-left", "5px solid #293846");
			}
		},
		"mouseleave" : function (){
			if($(this).children("ul").css("display") == "none"){
				$(this).css("border-left", "5px solid #2f4050");
			}
		}
	});
});