<?php
return array(
	'DB_TYPE'			=> 'mysql',
	'DB_HOST'			=> 'localhost',
	'DB_USER'			=> 'root',
	'DB_PWD'			=> 'ssy123',
	'DB_NAME'			=> 'resource',
	'DB_PREFIX'			=> 'res_',
	
	// 以下是数据库的配置文件，分渠道和区
	// 若要添加新的渠道或区，需添加新的配置
	'DB_100'	=> array(
			'DB_TYPE'	=> 'mysql',
			'DB_HOST'	=> '106.75.20.232',
			'DB_USER'	=> 'root',
			'DB_PWD'	=> 'Misaka!',
			'DB_NAME'	=> 'the_wall_001',
			'DB_SUFFIX'	=> '_001',
	),
	'DB_SHADOWPOWER_4'	=> array(
			'DB_TYPE'	=> 'mysql',
			'DB_HOST'	=> '106.75.20.232',
			'DB_USER'	=> 'root',
			'DB_PWD'	=> 'Misaka!',
			'DB_NAME'	=> 'popolo02_db001',
			'DB_SUFFIX'	=> '_001',
	),
	'DB_TAPTAP_1'		=> array(
			'DB_TYPE'	=> 'mysql',
			'DB_HOST'	=> '106.75.65.121',
			'DB_USER'	=> 'root',
			'DB_PWD'	=> 'Misaka!',
			'DB_NAME'	=> 'the_wall_001',
			'DB_SUFFIX'	=> '_001',
	),
	'DB_TRIAL_1'		=> array(
			'DB_TYPE'	=> 'mysql',
			'DB_HOST'	=> '106.75.20.232',
			'DB_USER'	=> 'root',
			'DB_PWD'	=> 'Misaka!',
			'DB_NAME'	=> 'the_wall_003',
			'DB_SUFFIX'	=> '_003',
	),
	'DB_CHECK_1'		=> array(
			'DB_TYPE'	=> 'mysql',
			'DB_HOST'	=> '106.75.20.232',
			'DB_USER'	=> 'root',
			'DB_PWD'	=> 'Misaka!',
			'DB_NAME'	=> 'the_wall_004',
			'DB_SUFFIX'	=> '_004',
	),
	'DB_YL_1'		=> array(
			'DB_TYPE'	=> 'mysql',
			'DB_HOST'	=> '106.75.65.121',
			'DB_USER'	=> 'root',
			'DB_PWD'	=> 'Misaka!',
			'DB_NAME'	=> 'yxlc_ypw_001',
			'DB_SUFFIX'	=> '_001',
	),
	
	
	'DB_SHADOWPOWER_2_GDB'	=> array(
			'DB_TYPE'		=> 'mysql',
			'DB_HOST'		=> '106.75.20.232',
			'DB_USER'		=> 'root',
			'DB_PWD'		=> 'Misaka!',
			'DB_NAME'		=> 'popolo01_gdb',
	),
	'DB_SHADOWPOWER_4_GDB'	=> array(
			'DB_TYPE'		=> 'mysql',
			'DB_HOST'		=> '106.75.20.232',
			'DB_USER'		=> 'root',
			'DB_PWD'		=> 'Misaka!',
			'DB_NAME'		=> 'popolo02_gdb',
	),
	'DB_TAPTAP_1_GDB'		=> array(
			'DB_TYPE'		=> 'mysql',
			'DB_HOST'		=> '106.75.65.121',
			'DB_USER'		=> 'root',
			'DB_PWD'		=> 'Misaka!',
			'DB_NAME'		=> 'the_wall_gdb',
	),
	'DB_TRIAL_1_GDB'		=> array(
			'DB_TYPE'		=> 'mysql',
			'DB_HOST'		=> '106.75.20.232',
			'DB_USER'		=> 'root',
			'DB_PWD'		=> 'Misaka!',
			'DB_NAME'		=> 'the_wall_gdb3',
	),
	'DB_CHECK_1_GDB'		=> array(
			'DB_TYPE'		=> 'mysql',
			'DB_HOST'		=> '106.75.20.232',
			'DB_USER'		=> 'root',
			'DB_PWD'		=> 'Misaka!',
			'DB_NAME'		=> 'the_wall_gdb4',
	),
	'DB_YL_1_GDB'		=> array(
			'DB_TYPE'	=> 'mysql',
			'DB_HOST'	=> '106.75.65.121',
			'DB_USER'	=> 'root',
			'DB_PWD'	=> 'Misaka!',
			'DB_NAME'	=> 'yxlc_ypw_gdb'
	),
	
	'URL_MODEL'			=> 0,				// URL 模式
	'SHOW_PAGE_TRACE'	=> true,			// 显示页面追踪信息
	'ACTION_SUFFIX'		=> 'Action',		// 操作方法的后缀
	'DEFAULT_MODULE'        =>  'Admin',	// 默认的模块
    'DEFAULT_CONTROLLER'    =>  'Manager',	// 默认的控制器
    'DEFAULT_ACTION'        =>  'login',	// 默认的操作方法
    'PWD_SUFFIX'		=> 'zm',			// 密码的前缀
);