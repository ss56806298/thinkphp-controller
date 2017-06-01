<?php if (!defined('THINK_PATH')) exit();?>﻿<!doctype html>
<html>
<head>
	<title>使用说明</title>
	<meta charset="utf-8" />
	<link rel="stylesheet" href="/resource/Public/font-awesome/css/font-awesome.min.css">
	<link rel="stylesheet" href="<?php echo (ADMIN_PUBLIC); ?>/css/helpIndex.css?<?php echo time();?>">
</head>
<body>
	<div id="help">
		<ul>
			<li><a href="#log">1、登录和退出</a></li>	
			<li><a href="#master">2、个人资料的修改</a></li>	
			<li><a href="#monster">3、英雄的添加和删除</a></li>	
			<li><a href="#material">4、素材的添加和删除</a></li>	
			<li><a href="#weapon">5、武器的添加和删除</a></li>	
			<li><a href="#armor">6、护甲的添加和删除</a></li>	
			<li><a href="#helmet">7、头盔的添加和删除</a></li>	
			<li><a href="#dungeon">8、快速通关</a></li>	
		</ul>
		
		<a name="log"></a>
		<h3>1、登录和退出</h3>
		<h4>1.1 登录</h4>
		<img src="<?php echo (ADMIN_PUBLIC); ?>/images/login.png">
		<p>输入用户名、密码和验证码<br>注意：可以勾选“下次自动登录”，方便下次进入后台</p>
		<h4>1.2 退出</h4>
		<img src="<?php echo (ADMIN_PUBLIC); ?>/images/logout.png">
		<p>点击“安全退出”，即可退出后台</p>
		
		<a name="master"></a>
		<h3>2、个人资料的修改</h3>
		<img src="<?php echo (ADMIN_PUBLIC); ?>/images/master.png">
		<p>在上图圈出的地方，<b>单击</b>，然后填入需要的值即可完成修改</p>
		
		<a name="monster"></a>
		<h3>3、英雄的添加和删除</h3>
		<img src="<?php echo (ADMIN_PUBLIC); ?>/images/monster.png">
		<h4>3.1 英雄的添加</h4>
		<p>点击“添加”按钮，即可完成添加操作<br>注意：同一个名字的英雄只能添加一个</p>
		<h4>3.2 英雄的删除</h4>
		<p>点击“删除”按钮，即可完成删除操作<br>注意：如果该英雄在队列当中，则无法删除</p>
		
		<a name="material"></a>
		<h3>4、素材的添加和删除</h3>
		<img src="<?php echo (ADMIN_PUBLIC); ?>/images/material.png">
		<p>在上图圈出的地方，<b>双击</b>，然后输入你希望拥有素材的数量，即可完成素材的添加，输入“0”，代表删除该素材</p>
		
		<a name="weapon"></a>
		<h3>5、武器的添加和删除</h3>
		<img src="<?php echo (ADMIN_PUBLIC); ?>/images/weapon.png">
		<h4>5.1 武器的添加</h4>
		<p>点击“添加”按钮，即可完成添加操作<br>注意：同一个名字的武器只能添加一个</p>
		<h4>5.2 武器的删除</h4>
		<p>点击“删除”按钮，即可完成删除操作<br>注意：如果该武器在队列当中，则无法删除</p>
		
		<a name="armor"></a>
		<h3>6、护甲的添加和删除</h3>
		<img src="<?php echo (ADMIN_PUBLIC); ?>/images/armor.png">
		<h4>6.1 护甲的添加</h4>
		<p>点击“添加”按钮，即可完成添加操作<br>注意：同一个名字的护甲只能添加一个</p>
		<h4>6.2 护甲的删除</h4>
		<p>点击“删除”按钮，即可完成删除操作<br>注意：如果该护甲在队列当中，则无法删除</p>
		
		<a name="helmet"></a>
		<h3>7、头盔的添加和删除</h3>
		<img src="<?php echo (ADMIN_PUBLIC); ?>/images/helmet.png">
		<h4>7.1 头盔的添加</h4>
		<p>点击“添加”按钮，即可完成添加操作<br>注意：同一个名字的头盔只能添加一个</p>
		<h4>7.2 头盔的删除</h4>
		<p>点击“删除”按钮，即可完成删除操作<br>注意：如果该头盔在队列当中，则无法删除</p>
		
		<a name="dungeon"></a>
		<h3>8、快速通关</h3>
		<img src="<?php echo (ADMIN_PUBLIC); ?>/images/dungeon.png">
		<p>选择你需要的关卡，比如说“14-4 寒风的低语”，则该关卡前面的所有关卡都会被选中，该关卡后面的所有关卡都不会被选中，<br>然后点击“提交”按钮<br>
		如果选择了“添加相应的精英副本”复选框，除了该关卡自己对应的精英副本外，其他关卡对应的精英副本也会被添加<p>
	</div>
	
	<div style="height:200px"></div>
</body>
</html>