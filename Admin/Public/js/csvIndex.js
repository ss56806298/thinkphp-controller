$(function (){
	$("#csv form p #platform").on("change", function (){
		platform = $(this).val();
		
		$.ajax({
			url : "/resource/index.php?m=Admin&c=Csv&a=getServers",
			data : {"platform" : platform},
			dataType : "json",
			success : function (data){
				str = "<option value='-1'>请选择</option>";
				
				if(data.length > 1){
					str += "<option value='0'>全部</option>";	
				}
				
				for(i = 0; i < data.length; i++){
					str += "<option value='" + data[i] + "'>" + data[i] + " 区</option>"	
				}
				
				$("#server").html(str);
			}	
		});
	});
});