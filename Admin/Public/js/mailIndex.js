$(function (){
	$("#mail form p #accounts").autocomplete({
		source : function (request, response){
			term = request.term;
			termArr = term.split(", ");
			input = termArr[termArr.length - 1];
			
			$.ajax({
				url : "/resource/index.php?m=Admin&c=Mail&a=search",
				data : {"input" : input},
				dataType : "json",
				success : function (data){
					for(x in data){
						index = termArr.indexOf(data[x]);
						if(index != -1){
							delete data[x];
						}
					}
					
					response(data);
				}	
			});
		},
		select : function (event, ui){
			term = this.value.split(", ");
			term.pop();
			term.push(ui.item.value);
			
			this.value = term.join(", ") + ", ";
			
			return false;
		}
	});
	
	$("#mail form p #platform").on("change", function (){
		platform = $(this).val();
		
		$.ajax({
			url : "/resource/index.php?m=Admin&c=Mail&a=getServers",
			data : {"platform" : platform},
			dataType : "json",
			success : function (data){
				str = "<option value='0'>请选择</option>";
				
				for(i = 0; i < data.length; i++){
					str += 	"<option value='" + data[i] + "'>" + data[i] + " 区</option>";
				}
				
				$("#server").html(str);
			}	
		});
	});
	
	$("#mail form p a").on("click", function (){
		id = $(this).prev().prop("id");
		$("#mould_" + id).css("display", "block");
	});
	
	$("#mail .mould p a:nth-of-type(1)").on("click", function (){
		$(this).parent().parent().css("display", "none");	
	});
	
	$("#mail .mould p a:nth-of-type(2)").on("click", function (){
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
	
	$("#mail form>a").on("click", function (){
		str = "";
		
		liArr = $("#mail form div ul li");
		
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
		
		label = $("#mail #reward p:last-child label");
		for(i = 0; i < label.length; i++){
			label[i].remove();	
		}
		
		$("#mail #reward p:last-child a:nth-of-type(1)").before(str);
		
		$("#mail #reward p:last-child label input").on("blur", function (){
			val = $(this).val().trim();
			
			if(val <= 0 && val != ""){
				$(this).parent().remove();	
			}
		});
		
		$("#mail #reward").css("display", "block");	
	});
	
	$("#mail #reward").accordion({
		collapsible : true,
		heightStyle : "content",
	});
	
	$("#mail #reward ul li").on("click", function (){
		item_name = $(this).prop("title");
		item_id = $(this).text();
		str = "<label>" + item_name + " " + item_id + "<input type='text'></label>"
		
		$("#mail #reward p:last-child a:nth-of-type(1)").before(str);
		
		$("#mail #reward p:last-child label input").on("blur", function (){
			val = $(this).val().trim();
			
			if(val <= 0 && val != ""){
				$(this).parent().remove();	
			}
		});
	});
	
	$("#mail #reward p:last-child a:nth-of-type(2)").on("click", function (){
		$("#mail #reward").css("display", "none");
	});
	
	$("#mail #reward p:last-child a:nth-of-type(1)").on("click", function (){
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
			height = parseInt($("#mail form div ul li").css("height")) * realNum + "px";
			$("#mail form div").css("display", "block");
			$("#mail form div div").css("height", height);
			$("#mail form div ul").html(str);
		}else{
			$("#mail form div").css("display", "none");
			$("#mail form div div").css("height", "0px");
			$("#mail form div ul").html("<div><div>奖　励</div><ul><li></li></ul></div>");
		}
		
		$("#mail #reward").css("display", "none");
	});
});