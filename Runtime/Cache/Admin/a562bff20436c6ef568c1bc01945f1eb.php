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
	
<link rel="stylesheet" href="<?php echo (ADMIN_PUBLIC); ?>/css/roleAdd.css?<?php echo time();?>">
<script src="<?php echo (ADMIN_PUBLIC); ?>/js/roleAdd.js?<?php echo time();?>"></script>

<div id="add" class="right">
	<form action="/resource/index.php?m=Admin&amp;c=Role&amp;a=add" method="post">
		<p>
			<?php if($tips == 1): ?><span class="error">操作失败，角色名不可以为空</span>
			<?php elseif($tips == 2): ?>
				<span class="error">操作失败，该角色名已存在</span><?php endif; ?>
		</p>
		<p>
			<label for="role_name">角 色 名</label>
			<input type="text" id="role_name" name="role_name">
			<span class="error"></span>
		</p>
		<fieldset>
			<legend>选择角色成员</legend>
			<ul>
				<?php if(is_array($managers)): $i = 0; $__LIST__ = $managers;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$manager): $mod = ($i % 2 );++$i;?><li>
						<?php if($manager["mg_islock"] == 1): ?><label class="error">
								<input type="checkbox" name="manager[]" value="<?php echo ($manager["mg_id"]); ?>">
								<?php echo ($manager["mg_name"]); ?>-<?php echo ($manager["mg_true_name"]); ?>-<?php echo ($manager["role_name"]); ?>
							</label>	
						<?php else: ?>
							<label>
								<input type="checkbox" name="manager[]" value="<?php echo ($manager["mg_id"]); ?>">
								<?php echo ($manager["mg_name"]); ?>-<?php echo ($manager["mg_true_name"]); ?>-<?php echo ($manager["role_name"]); ?>
							</label><?php endif; ?>
					</li><?php endforeach; endif; else: echo "" ;endif; ?>
			</ul>
		</fieldset>	
		<fieldset>
			<legend>选择角色权限</legend>
			<?php if(is_array($all_power)): $i = 0; $__LIST__ = $all_power;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$power): $mod = ($i % 2 );++$i;?><ul>
					<li>
						<label>
							<input type="checkbox" name="power[]" value="<?php echo ($power["pow_id"]); ?>">
							<?php echo ($power["pow_name"]); ?>
						</label>
					</li>
					<?php if(is_array($power['pow_child'])): $i = 0; $__LIST__ = $power['pow_child'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$pow): $mod = ($i % 2 );++$i;?><li>
							<label>
								<input type="checkbox" name="power[]" value="<?php echo ($pow["pow_id"]); ?>">
								<?php echo ($pow["pow_name"]); ?>
							</label>
						</li><?php endforeach; endif; else: echo "" ;endif; ?>
				</ul><?php endforeach; endif; else: echo "" ;endif; ?>
		</fieldset>
		<fieldset>
			<legend>选择渠道权限</legend>
			<ul>
				<li>
					<label>
						<input type="checkbox">
						全部渠道
					</label>
				</li>
				<?php if(is_array($platforms)): $i = 0; $__LIST__ = $platforms;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li>
						<?php if($vo['checked'] == 1): ?><label>
								<input type="checkbox" name="platforms[]" value="<?php echo ($vo["platform"]); ?>" checked="checked">
								<?php echo ($vo["platform"]); ?>	
							</label>
						<?php else: ?>
							<label>
								<input type="checkbox" name="platforms[]" value="<?php echo ($vo["platform"]); ?>">
								<?php echo ($vo["platform"]); ?>	
							</label><?php endif; ?>
					</li><?php endforeach; endif; else: echo "" ;endif; ?>
			</ul>
		</fieldset>
		<fieldset>
			<legend>是否可以修改版本号</legend>
			<label><input type="radio" name="version_edit" value="1"> 是</label>
			<label><input type="radio" name="version_edit" value="0" checked="checked"> 否</label>	
		</fieldset>
		<input type="submit" name="submit" id="submit" value="提　交">	
	</form>
</div>

﻿</body>
</html>