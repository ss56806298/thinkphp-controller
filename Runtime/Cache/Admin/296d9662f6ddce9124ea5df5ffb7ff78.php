<?php if (!defined('THINK_PATH')) exit();?>﻿﻿<!doctype html>
<html>
<head>
	<title>影力网络</title>
	<meta charset="utf-8" />
	<link rel="stylesheet" href="/resource/Public/font-awesome/css/font-awesome.min.css">
	<link rel="stylesheet" href="/resource/Public/jquery.ui/jquery.ui.css">
	<link rel="stylesheet" href="<?php echo (ADMIN_PUBLIC); ?>/css/common.css?<?php echo time();?>">
	<link rel="stylesheet" href="<?php echo (ADMIN_PUBLIC); ?>/css/header.css?<?php echo time();?>">
	<link rel="stylesheet" href="<?php echo (ADMIN_PUBLIC); ?>/css/left.css?<?php echo time();?>">
	<link rel="stylesheet" href="<?php echo (ADMIN_PUBLIC); ?>/css/right.css?<?php echo time();?>">
	<link rel="stylesheet" href="<?php echo (ADMIN_PUBLIC); ?>/css/pageTp.css?<?php echo time();?>">

	<script src="/resource/Public/jquery/jquery.min.js"></script>
	<script src="/resource/Public/artDialog/js/sea.js"></script>
	<script src="/resource/Public/jquery.ui/jquery.ui.js"></script>
	<script src="<?php echo (ADMIN_PUBLIC); ?>/js/header.js?<?php echo time();?>"></script>
	<script src="<?php echo (ADMIN_PUBLIC); ?>/js/left.js?<?php echo time();?>"></script>
</head>
<body>
	<div id="left">
		<div id="info">
			<img src="<?php echo (session('mg_header')); ?>">
			<div>
				<div>
					<span>真实姓名</span>
					<span><?php echo (session('mg_true_name')); ?></span>
				</div>
				<div>
					<span>当前账号</span>
					<?php if($_SESSION['account']== -1): ?><span id="account">未选择</span>
					<?php else: ?>
						<span id="account"><?php echo (session('account')); ?></span><?php endif; ?>
				</div>
				<div>
					<span>当前分区</span>
					<?php if($_SESSION['server_num']== -1): ?><span id="server_num">未选择</span>
					<?php else: ?>
						<span id="server_num"><?php echo (session('server_num')); ?> 区</span><?php endif; ?>
				</div>
				<div>
					<span>操　　作</span>
					<a href="#">安全退出</a>
				</div>
			</div>
		</div>
		<div id="menu">
			<?php if(is_array($powers)): $i = 0; $__LIST__ = $powers;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$power): $mod = ($i % 2 );++$i;?><div>
					<?php if(in_array(($power["pow_id"]), explode(',',"11"))): ?><a href="<?php echo (U($power["pow_ac"])); ?>" target="_blank"><?php echo ($power["pow_name"]); ?><i class="fa fa-angle-left"></i></a>
					<?php else: ?>
						<a href="<?php echo (U($power["pow_ac"])); ?>"><?php echo ($power["pow_name"]); ?><i class="fa fa-angle-left"></i></a><?php endif; ?>
					<ul>
						<?php if(is_array($power["pow_child"])): $i = 0; $__LIST__ = $power["pow_child"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$child): $mod = ($i % 2 );++$i; if($child["pow_isshow"] == 1): ?><li><a href="<?php echo (U($child["pow_ac"])); ?>"><?php echo ($child["pow_name"]); ?></a></li>
							<?php else: ?>
								<li><a href="<?php echo (U($child["pow_ac"])); ?>" class="hidden"><?php echo ($child["pow_name"]); ?></a></li><?php endif; endforeach; endif; else: echo "" ;endif; ?>	
					</ul>
				</div><?php endforeach; endif; else: echo "" ;endif; ?>
		</div>
	</div>
﻿<div id="header">
	<div>
		<button id="toggle"><i class="fa fa-bars"></i></button>
		<input type="text" id="search" placeholder="请输入 ID 或 名字" />
	</div>
</div>

<link rel="stylesheet" href="<?php echo (ADMIN_PUBLIC); ?>/css/weaponHaving.css?<?php echo time();?>">
<script src="<?php echo (ADMIN_PUBLIC); ?>/js/weaponHaving.js?<?php echo time();?>"></script>

<div id="right">
	<ul>
		<li>编号</li>
		<li>ID</li>
		<li>名字</li>
		<li>等级</li>
		<li>经验值</li>
		<li>攻击力</li>
		<li>防御力</li>	
		<li>操作</li>
	</ul>
	<?php if(is_array($user_arms)): $i = 0; $__LIST__ = $user_arms;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$user_arm): $mod = ($i % 2 );++$i;?><ul>
			<li><?php echo ($i); ?></li>
			<li><?php echo ($user_arm["item_id"]); ?></li>	
			<li><?php echo ($user_arm["name"]); ?></li>	
			<li><?php echo ($user_arm["level"]); ?></li>	
			<li><?php echo ($user_arm["exp"]); ?></li>	
			<li><?php echo ($user_arm["attack"]); ?></li>	
			<li><?php echo ($user_arm["defense"]); ?></li>
			<li><a href="javascript:;">删除</a></li>
		</ul><?php endforeach; endif; else: echo "" ;endif; ?>
	﻿<div id="page">
	<?php $__FOR_START_170707266__=0;$__FOR_END_170707266__=$pageNum;for($i=$__FOR_START_170707266__;$i < $__FOR_END_170707266__;$i+=1){ if($i == $page): ?><a href=<?php echo U("", array("page" => $i));?> class="page_active"><?php echo ($i+1); ?></a>
		<?php else: ?>
			<a href=<?php echo U("", array("page" => $i));?>><?php echo ($i+1); ?></a><?php endif; } ?>
</div>
</div>

﻿</body>
</html>