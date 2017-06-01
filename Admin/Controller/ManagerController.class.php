<?php
	namespace Admin\Controller;
	use Think\Controller;
	
	class ManagerController extends Controller {
		public function loginAction (){
			if(IS_POST){
				foreach ($_SESSION as $key => $value){
					if(is_array($value) && isset($value["verify_code"])){
						$verify = new \Think\Verify();
						if(!$verify->check(I("verify"))){
							$this->assign("tips", "验证码错误");
							$this->display();
							return;	
						}
					}
				}
				
				$manager = D("Managers")->getDataByNameAndPwd(I("mg_name"), I("mg_pwd"));
				if(is_null($manager)){
					$this->assign("tips", "用户名或密码错误");
					$this->display();
					return;
				}
				
				if(I("autolog") == "autolog"){
					cookie("66352e28994b4afafb9cc81dc13b1820", "66352e28994b4afafb9cc81dc13b1820", 365 * 24 * 3600);	// autolog
					cookie("32046c86d4c9dd7e1d06996ed7ae2be0", $manager["mg_name"], 365 * 24 * 3600);					// mg_name
					cookie("9f910241fcb0f9f75513d249c7c5a6f6", $manager["mg_pwd"], 365 * 24 * 3600);					// mg_pwd
				}else{
					$this->_deleteCookieAndSession();
				}
				
				$this->_setSession($manager);
				
				D("Managers")->saveLoginTimeById($manager["mg_id"]);
				
				redirect(U("Account/index"));
				
			}else{
				if(cookie("66352e28994b4afafb9cc81dc13b1820") == "66352e28994b4afafb9cc81dc13b1820"){
					$mgName = cookie("32046c86d4c9dd7e1d06996ed7ae2be0");
					$mgPwd = cookie("9f910241fcb0f9f75513d249c7c5a6f6");
					$manager = D("Managers")->getDataByNameAndPwd($mgName, $mgPwd, false);
					if(is_null($manager)){
						$this->display();
						return;
					}
					
					$this->_setSession($manager);
					
					D("Managers")->saveLoginTimeById($manager["mg_id"]);
					
					redirect(U("Account/index"));
					
					return ;
				}
				
				$this->_deleteCookieAndSession();
				$this->display();
			}
		}
		
		public function verifyAction (){
			ob_clean();
			$verify = new \Think\Verify();
			$verify->length = 4;
			$verify->useCurve = false;
			$verify->useNoise = false;
			$img = $verify->entry();
		}
		
		public function checkVerifyAction ($verifyCode){
			if(!is_ajax()){
				return ;	
			}
			
			$verify = new \Think\Verify();
			if($verify->check($verifyCode)){
				echo 1;
			}else{
				echo 0;	
			}
		}
		
		public function logoutAction (){
			$this->_deleteCookieAndSession();
		}
		
		private function _setSession($manager){
			session("mg_name", $manager["mg_name"]);
			session("mg_true_name", $manager["mg_true_name"]);
			session("mg_header", is_null($manager["mg_header"]) ? DEFAULT_HEADER : $manager["mg_header"]);
			session("mg_id", $manager["mg_id"]);
			session("account", -1);
			session("platform", -1);
			session("server_num", -1);	
			session("os", -1);	
		}
		
		private function _deleteCookieAndSession(){
			cookie("66352e28994b4afafb9cc81dc13b1820", null);
			cookie("32046c86d4c9dd7e1d06996ed7ae2be0", null);
			cookie("9f910241fcb0f9f75513d249c7c5a6f6", null);
			
			session(null);
		}
	}