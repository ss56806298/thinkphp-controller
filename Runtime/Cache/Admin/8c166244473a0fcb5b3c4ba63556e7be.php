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
	
<link rel="stylesheet" href="<?php echo (ADMIN_PUBLIC); ?>/css/userIndex.css?<?php echo time();?>">
<script src="<?php echo (ADMIN_PUBLIC); ?>/js/userIndex.js?<?php echo time();?>"></script>

<div id="user">
	<form action="/resource/index.php?m=Admin&amp;c=User&amp;a=index" method="post" enctype="multipart/form-data">
		<p>
			<?php if($tips == 1): ?><span>操作失败，用户名不能为空</span>
			<?php elseif($tips == 2): ?>
				<span>操作失败，用户名已存在</span>
			<?php elseif($tips == 3): ?>
				<span>操作失败，旧密码错误</span>
			<?php elseif($tips == 4): ?>
				<span>操作失败，两次输入的密码不一致</span>
			<?php elseif($tips == 5): ?>
				<span><?php echo ($error); ?></span><?php endif; ?>
		</p>
		<p>
			<label for="mg_true_name">真实姓名</label>
			<input type="text" id="mg_true_name" name="mg_true_name" disabled="disabled" value="<?php echo (session('mg_true_name')); ?>">
		</p>
		<p>
			<label for="mg_name">用 户 名</label>
			<input type="text" id="mg_name" name="mg_name" value="<?php echo (session('mg_name')); ?>">
			<span></span>
		</p>
		<p>
			<label for="old_pwd">旧 密 码</label>
			<input type="password" id="old_pwd" name="old_pwd" value="">
			<span></span>
		</p>
		<p>
			<label for="mg_pwd">新 密 码</label>
			<input type="password" id="mg_pwd" name="mg_pwd" value="">
			<span>* 留空为不修改</span>
		</p>
		<p>
			<label for="mg_pwd_again">确认密码</label>
			<input type="password" id="mg_pwd_again" name="mg_pwd_again" value="">
			<span></span>
		</p>
		<p>
			<label for="mg_header">更换头像</label>
			<input type="file" id="mg_header" name="mg_header">
		</p>
		<p>
			<input type="submit" id="submit" value="提　交">
		</p>	
	</form>
</div>

﻿</body>
</html>