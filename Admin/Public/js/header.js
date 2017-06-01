$(function (){
	$("#header #toggle").on("click", function (){
		if($("#left").css("display") == "block"){
			$("#left").css("display", "none");
			$("#header").css("left", "0px");
			$(this).parent().parent().nextAll("div").css("padding-left", "50px");

		}else{
			$("#left").css("display", "block");
			$("#header").css("left", "220px");
			$(this).parent().parent().nextAll("div").css("padding-left", "350px");
		}
	});
	
	$("#header #search").autocomplete({
		source : function (request, response){
			search = window.location.search.split("&");
			url = window.location.pathname + search[0] + "&" + search[1];
			if(search[2].search("all") != -1){
				url += "&a=searchAll";	
			}else{
				url += "&a=searchHaving";	
			}
			
			$.ajax({
				url : url,
				dataType : "json",
				data : {"input" : request.term},
				success : function (data){
					response($.map(data, function (item){
						return {
							value : item.id + " " + item.name
						}
					}));
				}
			});
		},
		select : function (event, ui){
			search = window.location.search.split("&");
			url = window.location.pathname + search[0] + "&" + search[1];
			if(search[2].search("all") != -1){
				url += "&a=completeAll";	
			}else{
				url += "&a=completeHaving";	
			}
			
			$.ajax({
				url : url,
				dataType : "html",
				data : {"id" : ui.item.value.split(" ")[0]},
				success : function (data){
					$("#right").html(data);
				}
			});	
		}
	});
});