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
	
<link rel="stylesheet" href="<?php echo (ADMIN_PUBLIC); ?>/css/updateUpload.css?<?php echo time();?>">
<script src="<?php echo (ADMIN_PUBLIC); ?>/js/updateUpload.js?<?php echo time();?>"></script>

<div id="upload">
	<form action="/resource/index.php?m=Admin&amp;c=Update&amp;a=upload" enctype="multipart/form-data" method="post">
		<p>
			<span>渠道：</span>
			<select id="platforms" name="platforms">
				<option>请选择</option>
				<?php if(is_array($platforms)): $i = 0; $__LIST__ = $platforms;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$platform): $mod = ($i % 2 );++$i;?><option><?php echo ($platform); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
			</select>
			<span>平台：</span>
			<select id="os" name="os">
				<option>请选择</option>	
			</select>
		</p>		
		<p>
			<span>当前版本号：</span>
			<span id="version">未知</span>
		</p>
		<p>
			<span>上 传 资 源：</span>
			<input type="file" name="res" id="file" disabled="disabled">
		</p>
		<p>
			<input type="submit" value="提　交" id="submit" disabled="disabled">	
		</p>
	</form>
	
	<?php if($is_post == 1): ?><div>
			<p>
				<span>状　态</span>
				<span>上传成功</span>
			</p>
			<p>
				<span>版 本 号</span>
				<span><?php echo ($version); ?></span>	
			</p>
			<p>
				<span>渠  道</span>
				<span><?php echo ($plat); ?></span>
			</p>
			<p>
				<span>平  台</span>
				<span><?php echo ($os); ?></span>	
			</p>
			<p>
				<span>资源名称</span>
				<span><?php echo ($info["savename"]); ?></span>	
			</p>
			<p>
				<span>资源大小</span>
				<span><?php echo ($info["nice_size"]); ?></span>	
			</p>
			<p>
				<span>上 传 者</span>
				<span><?php echo (session('mg_true_name')); ?></span>	
			</p>
		</div>
	<?php elseif($is_post == 2): ?>
		<div id="error">
			<p>
				<span>状　态</span>
				<span>上传失败</span>
			</p>
			<p>
				<span>原　因</span>
				<span>文件写入失败</span>
			</p>	
		</div><?php endif; ?>
</div>

﻿</body>
</html>