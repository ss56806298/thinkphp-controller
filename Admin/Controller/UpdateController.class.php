<?php
	namespace Admin\Controller;
	use ZipArchive;
	
	/*
	* 热更新
	*/
	class UpdateController extends CommonController{
		private $_configName;	// 配置文件的名字（带完整路径）
		private $_config;		// 配置文件
		private $_template;		// 模板文件
		private $_platforms;	// 所有的渠道
		private $_path;			// 所有的渠道路径
		
		public function __construct(){
			parent::__construct();
			
			// 初始化操作，相关的常量见 index.php
			// $this->_configName = RES_CONFIG_PATH."/".RES_CONFIG_NAME;
			// $this->_config = require($this->_configName);
			// $this->_template = file_get_contents(TEMPLATE_PATH . "/template.php");
			$platforms = D("PlatformList")->getAllPlatformList();
			foreach ($platforms as $k => $v){
				$this->_platforms[] = $v;
				// $this->_path[$key] = $key . "/";
			}
		}
		
		/*
		* 上传操作
		*/
		public function uploadAction (){
			if(IS_POST){
				$platforms = trim(I("platforms"));
				$os = trim(I("os"));
				$this->logsInfo = $platforms . ", " . $os;
				
				// 上传操作，使用 TP 中的上传类  http://document.thinkphp.cn/manual_3_2.html#upload
				$upload = new \Think\Upload();
				$upload->exts = array("zip");
				$upload->rootPath = UPLOAD_PATH_S;
				$upload->autoSub = false;
				$upload->saveName = "";
				$upload->replace = true;
				
				// 上传，如果上传不成功，给出错误信息
				$info = $upload->uploadOne($_FILES["res"]);
				if(!$info){
					$error = $upload->getError();
					$this->logsInfo .= ", " . $error;
					parent::__destruct();
					
					$this->error($error);
					return;
				}
				
				// 老版本号，数组
				// $oldVersion = explode(".", $this->_config->platform->$platforms->$os->version);
				// // 新版本号，数组
				$newVersion = explode(".", substr(substr($info["savename"], strlen(RES_FREFIX) + 1), 0, strlen($str) - strlen(".zip")));
				// // 如果老版本号和新版本号前三位不一致，给出错误提示
				// if($oldVersion[0] != $newVersion[0] || $oldVersion[1] != $newVersion[1] || $oldVersion[2] != $newVersion[2]){
				// 	$this->error("热更新失败，大版本号不一致");
				// 	return;
				// }
				
				// 转换 size
				if($info["size"] < 1024){
					$info["nice_size"] = $info["size"] . " B";
					
				}else if($info["size"] >= 1024 && $info["size"] < pow(1024, 2)){
					$info["nice_size"] = round(($info["size"] / 1024))	. " KB";
					
				}else if($info["size"] >= pow(1024, 2) && $info["size"] < pow(1024, 3)){
					$info["nice_size"] = round(($info["size"] / pow(1024, 2))) . " MB";
					
				}else{
					$info["nice_size"] = round(($info["size"] / pow(1024, 3))) . " GB";
				}
				
				// 将压缩包拷贝到相应目录
				$file1 = UPLOAD_PATH_S . $info["savename"];
			
				//获取渠道组
				$area = reset(D("PlatformList")->getAreaByPlatform($platforms));

				$file2Path = RES_PATH_S . $area . '/';
				$file2 = $file2Path . $info["savename"];
				$copy = copy($file1, $file2);
				if($copy !== true){
					$this->error("压缩包拷贝失败");
					return;	
				}
				
				// 打开压缩包
				$zip = new ZipArchive();
				$openResult = $zip->open($file2);
				if($openResult !== true){
					$this->error("压缩包打开失败");
					return;
				}
				
				// 解压压缩包
				$extractResult = $zip->extractTo($file2Path);
				if(!$extractResult){
					$this->error("压缩包解压失败");
					return;
				}
				
				// 关闭资源
				$zip->close();
				
				// 删除压缩包
				$unlinkResult = unlink($file2);
				if(!$unlinkResult){
					$this->error("压缩包删除失败");
					return;
				}
				
				// // 将新的版本号赋值给现在的渠道和平台
				// $this->_config->platform->$platforms->$os->version = implode(".", $newVersion);

				//将新的版本号赋值给渠道组
				D("AreaList")->updateAreaVersion($area, implode(".", $newVersion));
				
				// // 将版本号替换到相应的模板中
				// foreach ($this->_config->platform as $key => $value){
				// 	foreach ($value as $k => $v){
				// 		$replace = "<{" . $key . "+" . $k . "}>";
				// 		$this->_template = str_replace($replace, $v->version, $this->_template);
				// 	}	
				// }
				// 将模板文件填充到配置文件当中
				// $res = file_put_contents($this->_configName, $this->_template);
				
				// if($res === false){
				// 	$this->assign("is_post", 2);	
					
				// 	$this->logsInfo .= ", 文件写入失败";
				// }else{
					$this->assign("is_post", 1);
					$this->assign("info", $info);
					$this->assign("version", implode(".", $newVersion));
					$this->assign("plat", $platforms);
					$this->assign("area", $area);
					
					$this->logsInfo .= ", " . $info["savename"];
					$this->logsState = 1;
				// }
				
				$this->assign("platforms", $this->_platforms);
				$this->display();
				
			}else{
				$this->assign("platforms", $this->_platforms);
				$this->display();
			}
		}
		
		/*
		* 得到平台
		*/
		public function platformAction ($platform){
			if(!is_ajax()){
				return ;	
			}
			
			$platforms = D("PlatformList")->getAllPlatformList();
			foreach ($platforms as $k => $v){
				$os[] = $key;	
			}
			
			echo json_encode($os);
		}
		
		/*
		* 得到版本号
		*/
		public function osAction ($platform, $os){
			if(!is_ajax()){
				return ;	
			}
			
			echo $this->_config->platform->$platform->$os->version;
		}
	}