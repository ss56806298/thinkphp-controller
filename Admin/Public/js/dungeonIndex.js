$(function (){
	$("#dungeon form div div input").on("click", function (){
		$(this).parent().prevAll().children("input").prop("checked", "checked");
		$(this).parent().parent().prevAll().children("div").children("input").prop("checked", "checked");
		$(this).parent().nextAll().children("input").removeProp("checked");
		$(this).parent().parent().nextAll().children("div").children("input").removeProp("checked");
		
		num1 = $(this).parent().prevAll().children("input").length;
		num2 = $(this).parent().parent().prevAll().find("input").length;
		num = num1 + num2 + $(this).prop("checked");
		$("#dungeon_num").text(num);
		
		if(num < 1){
			$(this).prop("checked", "checked");
			$("#dungeon_num").text("1");
			alert("第一关无法取消");
		}
	});
});