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

<link rel="stylesheet" href="<?php echo (ADMIN_PUBLIC); ?>/css/mailIndex.css?<?php echo time();?>"/>
<script src="<?php echo (ADMIN_PUBLIC); ?>/js/mailIndex.js?<?php echo time();?>"></script>

<div id="mail" class="right">
	<form action="/resource/index.php?m=Admin&amp;c=Mail&amp;a=index" method="post">
		<?php if($error == 1): ?><span>账号不能为空</span>
		<?php elseif($error == 2): ?>
			<span>请选择渠道</span>
		<?php elseif($error == 3): ?>
			<span>请选择分区</span>
		<?php elseif($error == 4): ?>
			<span>标题不能为空</span>
		<?php elseif($error == 5): ?>
			<span>内容不能为空</span>
		<?php elseif($error == 6): ?>
			<span>署名不能为空</span>
		<?php elseif($error == 7): ?>
			<span>有效期不能为空</span>
		<?php elseif($error == 8): ?>
			<span>奖励不能为空</span>
		<?php elseif($error == 9): ?>
			<span>奖励不能超过 4 种</span><?php endif; ?>
		<p>
			<label for="accounts">账　号</label>
			<textarea id="accounts" name="accounts"></textarea>
		</p>
		<p>
			<label for="platform">渠　道</label>
			<select id="platform" name="platform">
				<option value="0">请选择</option>
				<?php if(is_array($platforms)): $i = 0; $__LIST__ = $platforms;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo); ?>"><?php echo ($vo); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
			</select>
			<label for="server">分　区</label>
			<select id="server" name="server">
				<option value="0">请选择</option>	
			</select>
			<label for="os">平　台</label>
			<select id="os" name="os">
				<option value="0">自动判断</option>
				<option value="Android">Android</option>	
				<option value="ios">ios</option>	
			</select>
		</p>
		<p>
			<label for="title">标　题</label>
			<input id="title" name="title" value="每日封测奖励">
			<a href="javascript:;">选 择 模 板</a>
		</p>
		<p>
			<label for="message">内　容</label>
			<textarea id="message" name="message">封测期间，每日赠送符石和扫荡券。快去召唤英雄吧~</textarea>
			<a href="javascript:;">选 择 模 板</a>
		</p>
		<p>
			<label for="sender">署　名</label>
			<input id="sender" name="sender" readonly="readonly" value="《英雄连城》开发团队">
			<a href="javascript:;">选 择 模 板</a>	
		</p>
		<p>
			<label for="expiry">有效期</label>
			<input id="expiry" name="expiry" value="30">
			<span>天</span>
		</p>
		<div>
			<div>奖　励</div>
			<ul><li></li></ul>
		</div>
		<a href="javascript:;" class="btn btn-success" id="add_reward">添 加 奖 励</a>
		<input type="submit" value="提　交">	
	</form>
	<div id="mould_title" class="mould">
		<ul>
			<?php if(is_array($titles)): $i = 0; $__LIST__ = $titles;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li><label><input type="radio" name="title"><?php echo ($vo["content"]); ?></label></li><?php endforeach; endif; else: echo "" ;endif; ?>
		</ul>
		<p><a href="javascript:;">取消</a><a href="javascript:;" name="title">确定</a></p>
	</div>
	<div id="mould_message" class="mould">
		<ul>
			<?php if(is_array($messages)): $i = 0; $__LIST__ = $messages;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li><label><input type="radio" name="message"><?php echo ($vo["content"]); ?></label></li><?php endforeach; endif; else: echo "" ;endif; ?>
		</ul>
		<p><a href="javascript:;">取消</a><a href="javascript:;" name="message">确定</a></p>
	</div>
	<div id="mould_sender" class="mould">
		<ul>
			<?php if(is_array($senders)): $i = 0; $__LIST__ = $senders;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li><label><input type="radio" name="sender"><?php echo ($vo["content"]); ?></label></li><?php endforeach; endif; else: echo "" ;endif; ?>
		</ul>
		<p><a href="javascript:;">取消</a><a href="javascript:;" name="sender">确定</a></p>
	</div>
	<div id="reward">
		<?php if(is_array($reward)): $i = 0; $__LIST__ = $reward;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><p><?php echo ($reward_name["$key"]["name"]); ?></p>
			<ul>
				<?php if(is_array($vo)): $i = 0; $__LIST__ = $vo;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><li title="<?php echo ($v["name"]); ?>"><?php echo ($key); ?></li><?php endforeach; endif; else: echo "" ;endif; ?>
			</ul><?php endforeach; endif; else: echo "" ;endif; ?>
		<p><a href="javascript:;">确定</a><a href="javascript:;">取消</a></p>
	</div>
	<div id="result">
		<?php if(is_array($result)): $i = 0; $__LIST__ = $result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i; if($vo['flag'] == 0): ?><p class="error"><span><?php echo ($vo["account"]); ?></span><span><?php echo ($platform); ?></span><span><?php echo ($server); ?> 区</span><span><?php echo ((isset($vo["os"]) && ($vo["os"] !== ""))?($vo["os"]):"全平台"); ?></span><span>未找到该账号</span></p>
			<?php elseif($vo['flag'] == 2): ?>
				<p class="error"><span><?php echo ($vo["account"]); ?></span><span><?php echo ($platform); ?></span><span><?php echo ($server); ?> 区</span><span><?php echo ((isset($vo["os"]) && ($vo["os"] !== ""))?($vo["os"]):"全平台"); ?></span><span>该账号存在于多个平台</span></p>
			<?php else: ?>
				<p><span><?php echo ($vo["account"]); ?></span><span><?php echo ($platform); ?></span><span><?php echo ($server); ?> 区</span><span><?php echo ($vo["os"]); ?></span><span>成功</span></p><?php endif; endforeach; endif; else: echo "" ;endif; ?>
	</div>
</div>
	
﻿</body>
</html>