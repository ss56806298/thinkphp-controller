$(function (){
	
	$("#cdkey form p a").on("click", function (){
		id = $(this).prev().prop("id");
		$("#mould_" + id).css("display", "block");
	});
	
	$("#cdkey .mould p a:nth-of-type(1)").on("click", function (){
		$(this).parent().parent().css("display", "none");	
	});
	
	$("#cdkey .mould p a:nth-of-type(2)").on("click", function (){
		id = $(this).prop("name");
		label = $(this).parent("p").prev("ul").children("li").children("label");
		
		for (i = 0; i < label.length; i++){
			if(label[i]["firstElementChild"]["checked"]){
				input = "<input type='radio' name='" + id + "'>";
				val = label[i]["innerHTML"].substr(input.length);
				val = val.replace(/&lt;/g, "<");
				val = val.replace(/&gt;/g, ">");
				$("#" + id).val(val);
			}
		}
		
		$(this).parent().parent().css("display", "none");
	});
	
	$("#cdkey form>a").on("click", function (){
		str = "";
		
		liArr = $("#cdkey form div ul li");
		
		for(i = 0; i < liArr.length; i++){
			text = liArr[i].textContent.split(" ");
			
			if(text[0] == ""){
				break;	
			}
			
			item_name = text[0];
			item_id = text[1];
			item_num = text[2];
			
			str += "<label>" + item_name + " " + item_id + "<input type='text' value='" + item_num + "'></label>"
		}
		
		label = $("#cdkey #reward p:last-child label");
		for(i = 0; i < label.length; i++){
			label[i].remove();	
		}
		
		$("#cdkey #reward p:last-child a:nth-of-type(1)").before(str);
		
		$("#cdkey #reward p:last-child label input").on("blur", function (){
			val = $(this).val().trim();
			
			if(val <= 0 && val != ""){
				$(this).parent().remove();	
			}
		});
		
		$("#cdkey #reward").css("display", "block");	
	});
	
	$("#cdkey #reward").accordion({
		collapsible : true,
		heightStyle : "content",
	});
	
	$("#cdkey #reward ul li").on("click", function (){
		item_name = $(this).prop("title");
		item_id = $(this).text();
		str = "<label>" + item_name + " " + item_id + "<input type='text'></label>"
		
		$("#cdkey #reward p:last-child a:nth-of-type(1)").before(str);
		
		$("#cdkey #reward p:last-child label input").on("blur", function (){
			val = $(this).val().trim();
			
			if(val <= 0 && val != ""){
				$(this).parent().remove();	
			}
		});
	});
	
	$("#cdkey #reward p:last-child a:nth-of-type(2)").on("click", function (){
		$("#cdkey #reward").css("display", "none");
	});
	
	$("#cdkey #reward p:last-child a:nth-of-type(1)").on("click", function (){
		str = "";
		
		labelArr = $(this).prevAll("label");
		realNum = 0;
		for(i = labelArr.length - 1; i >= 0; i--){
			label = labelArr[i];
			
			item_name = label.innerText.split(" ")[0];
			item_id = label.innerText.split(" ")[1];
			item_num = label.firstElementChild.value;
			
			if(!item_num){
				continue;	
			}
			
			if(item_num <= 0){
				continue;	
			}
			
			realNum++;
			str += "<li>" + 
				"<span>" + item_name + " </span>" + 
				"<span>" + item_id + " </span>" + 
				"<span>" + item_num + " </span>" + 
				"<input type='hidden' name='item_ids[]' value='" + item_id + "'>" + 
				"<input type='hidden' name='item_nums[]' value='" + item_num + "'>" + 
			"</li>";
		}
		
		if(realNum > 0){
			height = parseInt($("#cdkey form div ul li").css("height")) * realNum + "px";
			$("#cdkey form div").css("display", "block");
			$("#cdkey form div div").css("height", height);
			$("#cdkey form div ul").html(str);
		}else{
			$("#cdkey form div").css("display", "none");
			$("#cdkey form div div").css("height", "0px");
			$("#cdkey form div ul").html("<div><div>奖　励</div><ul><li></li></ul></div>");
		}
		
		$("#cdkey #reward").css("display", "none");
	});
});