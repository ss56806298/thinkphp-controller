<?php
	namespace Admin\Controller;
	use Think\Controller;
	
	/*
	* 基控制器
	*/
	class CommonController extends Controller{
		protected $mgId;			// 管理员 ID
		protected $scount;			// 账号中每一页的个数
		protected $count;			// 其他地方每一页的个数
		protected $logsInfo = "";	// 日志的信息
		protected $logsSep = " | ";	// 日志的分隔符
		protected $logsState = 0;	// 状态，0：未成功，1：成功
		
		// 平台（包括渠道和分区）
		// 主要用于热更新、版本号、上传 CSV、发送邮件
		protected $platform = array(
			"shadowpower"	=> array(
				"2"	=> array(
					"url"		=> "106.75.20.232",
					"username"	=> "root",
					"userpwd"	=> "Emiria!",
					"csv_path"	=> "/home/wwwroot/default/The_Wall/app/resource/csv/",
					"redis_port"=> "6370",
					"redis_pwd"	=> "eMiRiA",
				),
				"4"	=> array(
					"url"		=> "106.75.20.232",
					"username"	=> "root",
					"userpwd"	=> "Emiria!",
					"csv_path"	=> "/home/wwwroot/default82/The_Wall/app/resource/csv/",
					"redis_port"=> "6390",
					"redis_pwd"	=> "Ying20Li16!!!",
				),
			),
			"TapTap"		=> array(
				"1"	=> array(
					"url"		=> "106.75.65.121",
					"username"	=> "root",
					"userpwd"	=> "Emiria!",
					"csv_path"	=> "/home/wwwroot/default/The_Wall/app/resource/csv/",
					"redis_port"=> "6381",
					"redis_pwd"	=> "eMiRiA",
				),
			),
			"Trial"			=> array(
				"1"	=> array(
					"url"		=> "106.75.20.232",
					"username"	=> "root",
					"userpwd"	=> "Emiria!",
					"csv_path"	=> "/home/wwwroot/default84/The_Wall/app/resource/csv/",
					"redis_port"=> "6381",
					"redis_pwd"	=> "",
				),
			),
			"Check"			=> array(
				"1"	=> array(
					"url"		=> "106.75.20.232",
					"username"	=> "root",
					"userpwd"	=> "Emiria!",
					"csv_path"	=> "/home/wwwroot/default88/The_Wall/app/resource/csv/",
					"redis_port"=> "6391",
					"redis_pwd"	=> "Ying20Li16!!!",
				),
			),
			"YL"			=> array(
				"1"	=> array(
					"url"		=> "106.75.65.121",
					"username"	=> "root",
					"userpwd"	=> "Emiria!",
					"csv_path"	=> "/home/wwwroot/default84/The_Wall/app/resource/csv/",
					"redis_port"=> "6383",
					"redis_pwd"	=> "eMiRiA!",
				),
			)
		);
		
		// 通用的控制器/操作方法，不会放在角色的权限列表中
		// 安全性主要通过操作方法中 is_ajax() 方法判断，防止用户输入 URL 直接访问
		// 重要提醒：
		// 当添加一个新的 ajax 操作方法的时候，一定要在此数组中增加一个元素，格式是“控制器/操作方法”，否则会触发构造函数中的第三个判断
		private $_commonAc = array(
			"Account/delete",
			"Account/login",
			"Account/logout",
			"Master/nickname",
			"Master/vipLevel",
			"Master/level",
			"Master/stamina",
			"Master/stoneFree",
			"Master/coin",
			"Master/skipTicket",
			"Master/ladderPoints",
			"Master/girudoCoin",
			"Material/add",
			"Material/searchAll",
			"Material/searchHaving",
			"Material/completeAll",
			"Material/completeHaving",
			"Monster/add",
			"Monster/delete",
			"Monster/searchAll",
			"Monster/searchHaving",
			"Monster/completeAll",
			"Monster/completeHaving",
			"Weapon/add",
			"Weapon/delete",
			"Weapon/searchAll",
			"Weapon/searchHaving",
			"Weapon/completeAll",
			"Weapon/completeHaving",
			"Armor/add",
			"Armor/delete",
			"Armor/searchAll",
			"Armor/searchHaving",
			"Armor/completeAll",
			"Armor/completeHaving",
			"Helmet/add",
			"Helmet/delete",
			"Helmet/searchAll",
			"Helmet/searchHaving",
			"Helmet/completeAll",
			"Helmet/completeHaving",
			"Update/platform",
			"Update/os",
			"User/mgName",
			"User/oldPwd",
			"Admin/unlock",
			"Admin/lock",
			"Admin/delete",
			"Admin/move",
			"Admin/mgName",
			"Admin/mgNameSave",
			"Role/unlock",
			"Role/lock",
			"Role/delete",
			"Role/roleName",
			"Role/roleNameSave",
			"Csv/getServers",
			"Mail/search",
			"Mail/getServers",
			"Mail/mould",
			"Version/saveVersion",
		);
		
		public function __construct (){
			parent::__construct();
			
			// 网站是否关闭，该常量在 index.php 中配置
			if(IS_CLOSE){
				redirect(U("Close/index"));	
			}
			
			// 不存在 mg_id ，说明是非法进入，跳转到登录界面
			// mg_id 在登录成功之后生成
			if(!session("mg_id")){
				redirect(U("Manager/login"));	
			}
			
			// 当前访问的页面不在权限列表当中，并且不在通用控制器/操作方法当中，则抛出警告
			if (!in_array($this->getAc(), $this->getPowAc(session("mg_id"))) && !in_array($this->getAc(), $this->_commonAc)){
				echo "error";	// 该语句没有实际作用，只是为了方便调试
				$this->error("error");
			}
			
			$this->mgId = session("mg_id");	// 全局的 ID，后面会经常用到
			$this->scount = 12;
			$this->count = 13;
			
			$this->assign("powers", $this->getPowers());	// 得到用户所有的权限，并在左边显示
		}
		
		/*
		* 析构函数，主要记录日志
		*/		
		public function __destruct(){
			parent::__destruct();
			
			// 日志的基本信息，包括 ID 和 IP
			$logsBase = $this->mgId . $this->logsSep . get_client_ip();
			// 详细的日志信息
			$logsInfo = empty($this->logsInfo) ? $this->logsInfo : $this->logsSep . $this->logsInfo . $this->logsSep . $this->logsState;
			// 记录日志的级别
			$logsLevel = "INFO";
			// 日志文件的位置，常量在 index.php 中
			$logsFile = ADMIN_LOGS_S . date("Y-m", time()) . "/" . date("Y-m-d", time()) . ".log";
			
			\Think\Log::write($logsBase . $logsInfo . "\r\n", $logsLevel, "", $logsFile);	
		}
		
		/*
		* 得到管理员所有的权限，用于页面左边菜单的显示
		*/
		private function getPowers (){
			$roleId = D("Managers")->getRoleIdById($this->mgId);
			
			$powIds = D("Roles")->getPowIdsById($roleId);
			
			$powers = D("Powers")->getDataByIds($powIds);
			
			return $powers;
		}
		
		/*
		* 得到当前访问页面的控制器和操作方法
		*/
		private function getAc(){
			$queryStr = $_SERVER["QUERY_STRING"];
			parse_str($queryStr);
			return $c ."/" . $a;
		}
		
		/*
		* 得到管理员的权限，以数组的形式返回，用于判断是否有权限访问该页面
		*/
		private function getPowAc ($mgId){
			$roleId = D("Managers")->getRoleIdById($mgId);
			
			$powAc = D("Roles")->getPowAcById($roleId);
			
			return explode(",", $powAc);
		}
	}