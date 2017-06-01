<?php if (!defined('THINK_PATH')) exit();?>﻿<!doctype html>
<html>
<head>
	<title>影力网络</title>
	<meta charset="utf-8" />
	<link rel="stylesheet" href="/resource/Public/particleground/css/particleground.css">
	<link rel="stylesheet" href="/resource/Public/font-awesome/css/font-awesome.min.css">
	<link rel="stylesheet" href="<?php echo (ADMIN_PUBLIC); ?>/css/managerLogin.css?<?php echo time();?>">
	<script src="/resource/Public/jquery/jquery.min.js"></script>
	<script src="/resource/Public/particleground/js/particleground.js"></script>
	<script src="<?php echo (ADMIN_PUBLIC); ?>/js/managerLogin.js?<?php echo time();?>"></script>
</head>
<body>
	<div id="log">
		<div>
			<h2>后台管理系统</h2>		
			
			<form method="post" action="/resource/index.php?m=Admin&amp;c=Manager&amp;a=login">
				<div>
					<label id="tips"><?php echo ($tips); ?></label>	
				</div>
				<div>
					<span>用户名</span>
					<input type="text" id="mg_name" name="mg_name" value=" "/>
				</div>
				<div>
					<span>密　码</span>
					<input type="password" id="mg_pwd" name="mg_pwd" value=""/>
				</div>
				<div>
					<span>验证码</span>
					<input type="text" name="verify_code" id="verify_code" maxLength="4"/>
					<i class="fa fa-check"></i>
					<img src="<?php echo U('verify');?>" name="verify" id="verify">
					<span id="change">换一张</span>
				</div>
				<div>
					<input type="checkbox" id="autolog" name="autolog" checked="checked" value="autolog">
					<label for="autolog">下次自动登录</label>
				</div>
				<div>
					<input type="submit" id="login" name="login" value="立即登录">
				</div>
			</form>	
		</div>
	</div>
</body>
</html>