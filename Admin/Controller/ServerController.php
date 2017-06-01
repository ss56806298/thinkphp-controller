<?php
	namespace Admin\Controller;
	
	/*
	* 版本号
	*/
	class ServerController extends CommonController{
		private $_configName;	// 配置文件的名字（带完整路径）
		private $_config;		// 配置文件
		private $_template;		// 模板文件
		private $_platforms;	// 数组，包含渠道、平台、大版本号、热更新版本号，页面显示用
		
		public function __construct(){
			parent::__construct();
			
			// 相关常量见 index.php
			$this->_configName = RES_CONFIG_PATH . "/" . RES_CONFIG_NAME;
			$this->_config = require($this->_configName);
			$this->_template = file_get_contents(TEMPLATE_PATH . "/template.php");
		
			foreach($this->_config->platform as $key => $val){
				foreach($val as $k => $v){
					$tmp = explode(".", $v->version);
					
					$this->_platforms[] = array(
						"platform" => $key,
						"os" => $k,
						"version" => "$tmp[0].$tmp[1].$tmp[2]",
						"updateVersion" => $v->version
					);
				}
			}
		}
		
		/*
		* 显示所有的版本号
		*/
		public function indexAction (){
			$this->assign("platforms", $this->_platforms);
			$this->display();	
		}
		
		/*
		* 修改大版本号
		*/
		public function saveVersionAction ($id = 0, $version = 0){
			$this->logsInfo = $id . ", " . $version;
			
			// 判断是否有修改版本号的权限
			$roleId = D("Managers")->getRoleIdById($this->mgId);
			$versionEdit = D("Roles")->getVersionEditById($roleId);
			if($versionEdit == 0){
				echo 1;
				return;	
			}
			
			// 判断输入的版本号格式是否正确
			$pattern = "/^\d[.]\d{1,2}[.]\d{1,2}$/";
			$match = preg_match($pattern, $version);
			if($match == 0){
				echo 2;	
				return;
			}
			
			// 将热更新版本号写入对应的渠道平台
			$platform = $this->_platforms[$id];
			$updateVersion = $version . ".0";
			$this->_config->platform->$platform["platform"]->$platform["os"]->version = $updateVersion;
			
			// 版本号的替换
			foreach ($this->_config->platform as $key => $value){
				foreach ($value as $k => $v){
					$replace = "<{" . $key . "+" . $k . "}>";
					$this->_template = str_replace($replace, $v->version, $this->_template);
				}	
			}
			// 将模板文件填充到配置文件中
			$res = file_put_contents($this->_configName, $this->_template);
			
			if($res == false){
				echo 3;	
			}else{
				echo $updateVersion;
				$this->logsState = 1;
			}	
		}
	}