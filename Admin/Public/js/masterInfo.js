$(function (){
	// 昵称
	$("#nickname").on({
		"focus" : function (){
			$(this).css("color", "#333");	
		},
		"blur" : function (){
			var nickname = $(this).text();
			
			first = nickname.search(/\d/);
			if(first == 0){
				$(this).css("color", "#ff0000");
				alert("昵称不可使用数字开头");
				return;	
			}
			
			chinese = nickname.match(/[\u4e00-\u9fa5]/g);
			char = nickname.match(/[a-zA-Z]/g);
			number = nickname.match(/\d/g);
			
			chinese_length = chinese ? chinese.length * 2 : 0;
			char_length = char ? char.length : 0;
			number_length = number ? number.length : 0;
			
			length = chinese_length + char_length + number_length;
			if(length < 4){
				$(this).css("color", "#ff0000");
				alert("昵称过短");
				return;
			}
			if(length > 14){
				$(this).css("color", "#ff0000");
				alert("昵称过长");
				return;	
			}
			
			$.ajax({
				url : "/resource/index.php?m=Admin&c=Master&a=nickname",
				data : {"nickname" : nickname},
			});
		}
	});
	
	// VIP 等级
	$("#vip_level").on({
		"focus" : function (){
			$(this).css("color", "#333");
		},
		"blur" : function (){
			var vip_level = $(this).text();
				
			if(isNaN(vip_level)){
				$(this).css("color", "#ff0000");
				alert("VIP 等级必须是数字！");
				return;	
			}
			
			if(vip_level < 0 || vip_level > 15){
				$(this).css("color", "#ff0000");
				alert("VIP 等级必须在 0 - 15 之间！");
				return;
			}
			
			$.ajax({
				url : "/resource/index.php?m=Admin&c=Master&a=vipLevel",
				data : {"vip_level" : vip_level},	
			});
		}
	});
	
	// 玩家等级
	$("#level").on({
		"focus" : function (){
			$(this).css("color", "#333");	
		},
		"blur" : function (){
			var level = $(this).text();
				
			if(isNaN(level)){
				$(this).css("color", "#ff0000");
				alert("玩家等级必须是数字！");
				return;	
			}
			
			if(level < 1 || level > 90){
				$(this).css("color", "#ff0000");
				alert("玩家等级必须在 1 - 90 之间！");
				return;
			}
			
			$.ajax({
				url : "/resource/index.php?m=Admin&c=Master&a=level",
				data : {"level" : level},
				dataType : "json",
				success : function (data){
					$("#exp").text(data["accumulate_exp"]);
					$("#max_stamina").text(data["max_stamina_num"]);
					$("#hp").text(data["hp"]);
					$("#attack").text(data["attack"]);
					$("#defense").text(data["defense"]);
				}	
			});
		}
	});
	
	// 体力
	$("#stamina").on({
		"focus" : function (){
			$(this).css("color", "#333");	
		},
		"blur" : function (){
			var stamina = $(this).text();
				
			if(isNaN(stamina)){
				$(this).css("color", "#ff0000");
				alert("体力必须是数字！");
				return;	
			}
			
			if(stamina < 0 || stamina > 999){
				$(this).css("color", "#ff0000");
				alert("体力必须在 0 - 999 之间！");
				return;
			}
			
			$.ajax({
				url : "/resource/index.php?m=Admin&c=Master&a=stamina",
				data : {"stamina" : stamina},	
			});
		}
	});
	
	// 符石
	$("#stone_free").on({
		"focus" : function (){
			$(this).css("color", "#333");	
		},
		"blur" : function (){
			var stone_free = $(this).text();
				
			if(isNaN(stone_free)){
				$(this).css("color", "#ff0000");
				alert("符石必须是数字！");
				return;	
			}
			
			if(stone_free < 0 || stone_free > 100000){
				$(this).css("color", "#ff0000");
				alert("符石必须在 0 - 100000 之间！");
				return;
			}
			
			$.ajax({
				url : "/resource/index.php?m=Admin&c=Master&a=stoneFree",
				data : {"stone_free" : stone_free},	
			});
		}
	});
	
	// 金币
	$("#coin").on({
		"focus" : function (){
			$(this).css("color", "#333");	
		},
		"blur" : function (){
			var coin = $(this).text();
				
			if(isNaN(coin)){
				$(this).css("color", "#ff0000");
				alert("金币必须是数字！");
				return;	
			}
			
			if(coin < 0 || coin > 10000000){
				$(this).css("color", "#ff0000");
				alert("金币必须在 0 - 10,000,000 之间！");
				return;
			}
			
			$.ajax({
				url : "/resource/index.php?m=Admin&c=Master&a=coin",
				data : {"coin" : coin},
			});
		}
	});
	
	// 扫荡券
	$("#skip_ticket").on({
		"focus" : function (){
			$(this).css("color", "#333");	
		},
		"blur" : function (){
			var skip_ticket = $(this).text();
				
			if(isNaN(skip_ticket)){
				$(this).css("color", "#ff0000");
				alert("扫荡券必须是数字！");
				return;	
			}
			
			if(skip_ticket < 0 || skip_ticket > 999){
				$(this).css("color", "#ff0000");
				alert("扫荡券必须在 0 - 999 之间！");
				return;
			}
			
			$.ajax({
				url : "/resource/index.php?m=Admin&c=Master&a=skipTicket",
				data : {"skip_ticket" : skip_ticket},	
			});
		}
	});
	
	// 天梯点
	$("#ladder_points").on({
		"focus" : function (){
			$(this).css("color", "#333");	
		},
		"blur" : function (){
			var ladder_points = $(this).text();
				
			if(isNaN(ladder_points)){
				$(this).css("color", "#ff0000");
				alert("天梯点必须是数字！");
				return;	
			}
			
			if(ladder_points < 0 || ladder_points > 65535){
				$(this).css("color", "#ff0000");
				alert("天梯点必须在 0 - 65535 之间！");
				return;
			}
			
			$.ajax({
				url : "/resource/index.php?m=Admin&c=Master&a=ladderPoints",
				data : {"ladder_points" : ladder_points},
			});
		}
	});
	
	// 公会币
	$("#girudo_coin").on({
		"focus" : function (){
			$(this).css("color", "#333");	
		},
		"blur" : function (){
			var girudo_coin = $(this).text();
				
			if(isNaN(girudo_coin)){
				$(this).css("color", "#ff0000");
				alert("公会币必须是数字！");
				return;	
			}
			
			if(girudo_coin < 0 || girudo_coin > 65535){
				$(this).css("color", "#ff0000");
				alert("公会币必须在 0 - 65535 之间！");
				return;
			}
			
			$.ajax({
				url : "/resource/index.php?m=Admin&c=Master&a=girudoCoin",
				data : {"girudo_coin" : girudo_coin},
			});
		}
	});
});