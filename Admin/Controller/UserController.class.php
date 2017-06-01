<?php
	namespace Admin\Controller;
	
	class UserController extends CommonController {
		public function indexAction (){
			if(IS_POST){
				$mgName = trim(I("mg_name"));
				$oldPwd = I("old_pwd");
				$mgPwd = I("mg_pwd");
				$mgPwdAgain = I("mg_pwd_again");
				$data = [];
				
				$this->logsInfo = $mgName . ", " . $mgPwd;
				
				// 用户名判断
				if($mgName == ""){
					$this->assign("tips", 1);
					$this->display();
					return;	
				}
				
				if(in_array(strtolower($mgName), D("Managers")->getNamesExcpteSelf())){
					$this->assign("tips", 2);
					$this->display();
					return;
				}
				
				if($mgName != session("mg_name")){
					$data["mg_name"] = $mgName;
				}
				
				// 密码判断
				if($mgPwd != ""){
					if(D("Managers")->pwdEncryption($oldPwd) != D("Managers")->getPwdById($this->mgId)){
						$this->assign("tips", 3);
						$this->display();
						return;	
					}
					
					if($mgPwd != $mgPwdAgain){
						$this->assign("tips", 4);
						$this->display();
						return;		
					}
					
					$data["mg_pwd"] = D("Managers")->pwdEncryption($mgPwd);
				}
				
				// 头像判断
				if($_FILES["mg_header"]["error"] == 0){
					$upload = new \Think\Upload();
					$upload->maxSize	= 2 * 1024 * 1024;
					$upload->exts		= array("jpg", "png", "jpeg", "gif");
					$upload->rootPath	= HEADER_PATH_S;
					$upload->autoSub	= false;
					$info = $upload->uploadOne($_FILES["mg_header"]);
					
					if(!$info){
						$this->assign("tips", 5);
						$this->assign("error", $upload->getError());
						$this->display();
						return;		
					}
					
					$url = HEADER_PATH_S . $info["savename"];
					$data["mg_header"] = $url;
				}
				
				// data 不为空，表示有需要更新的字段
				if(!empty($data)){
					if(D("Managers")->saveDataById($this->mgId, $data)){
						if(isset($data["mg_name"])){
							session("mg_name", $data["mg_name"]);	
						}
						
						if(isset($data["mg_header"])){
							session("mg_header", $data["mg_header"]);	
						}
					}
				}
				
				$this->logsState = 1;
				
				if(isset($data["mg_name"]) || isset($data["mg_pwd"])){
					$this->success("修改成功，请重新登录", U("Manager/login"));
				}else{
					$this->display();
				}
				
			}else{
				$this->display();	
			}
		}
		
		public function mgNameAction ($mg_name){
			if(!is_ajax()){
				return ;	
			}
			
			if ($mg_name == ""){
				echo 1;	
			}else if(strtolower($mg_name) == strtolower(session("mg_name"))){
				echo 2;	
			}else if(in_array(strtolower($mg_name), D("Managers")->getNamesExcpteSelf())){
				echo 3;	
			}else{
				echo 4;	
			}
		}
		
		public function oldPwdAction ($old_pwd){
			if(!is_ajax()){
				return ;	
			}
			
			if($old_pwd == ""){
				echo 1;	
			}else if(D("Managers")->pwdEncryption($old_pwd) == D("Managers")->getPwdById($this->mgId)){
				echo 2;	
			}else{
				echo 3;	
			}
		}
	}