<?php
	// 开启调试模式
	define("APP_DEBUG", true);
	
	// 前台静态资源路径
	define("HOME_PUBLIC", "/resource/Home/Public");
	
	// 后台静态资源路径
	define("ADMIN_PUBLIC", "/thinkphp-controller/Admin/Public");
	
	// CSV 路径
	define("CSV_PATH", "Admin/Public/csv");
	
	// 热更新模板路径
	define("TEMPLATE_PATH", "Admin/Public/template");
	
	// 热更新资源路径
	define("RES_PATH", "../original_server/resource/update");
	
	// 热更新资源路径，带斜杠
	define("RES_PATH_S", "../original_server/resource/update/");
	
	// 热更新资源前缀
	define("RES_PREFIX", "update_res_");
	
	// 热更新配置文件路径
	define("RES_CONFIG_PATH", "../original_server");
	
	// 热更新配置文件名字
	define("RES_CONFIG_NAME", "config.php");
	
	// 头像路径，带斜杠
	define("HEADER_PATH_S", "Admin/Public/headers/");
	
	// 默认头像
	define("DEFAULT_HEADER", HEADER_PATH_S."default.jpg");
	
	// Redis 前缀
	define("REDIS_PREFIX", "resource_");
	
	// 上传路径
	define("UPLOAD_PATH_S", "Uploads/");
	
	// CSV 路径
	define("CSV_PATH_S", "The_Wall/app/resource/csv/");
	
	// 网站是否关闭
	define("IS_CLOSE", 0);
	
	// 后台 Logs
	define("ADMIN_LOGS_S", "Admin/Logs/");
	
	// 引入 ThinkPHP 核心类库文件
	require "ThinkPHP/ThinkPHP.php";