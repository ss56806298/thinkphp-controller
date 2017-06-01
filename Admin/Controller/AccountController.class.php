<?php
	namespace Admin\Controller;
	
	/*
	* 账号资料
	*/
	class AccountController extends CommonController{
		/*
		* 账号列表，显示所有的账号
		*/
		public function indexAction (){
			// 分页，调用 TP 中的分页类  http://document.thinkphp.cn/manual_3_2.html#data_page
			$count = D("Accounts")->getCountById($this->mgId);
			$page = new \Think\Page($count, $this->scount);
			$show = $page->show();
			
			// 得到分页之后的结果，并且添加是否登录的标志
			$accounts = D("Accounts")->getDataByIdWithLimit($this->mgId, $page->firstRow . ',' . $page->listRows);
			foreach ($accounts as &$account){
				if($account["account"] == session("account") && $account["platform"] == session("platform") && $account["server_num"] == session("server_num") && $account["os"] == session("os")){
					$account["is_login"] = 1;	
				}else{
					$account["is_login"] = 0;	
				}
			}
			
			$this->assign("accounts", $accounts);
			$this->assign("page", $show);
			$this->display();
		}
		
		/*
		* 添加账号
		*/
		public function addAction (){
			// IS_POST 表示是否从表单提交
			if(IS_POST){
				$account = trim(I("account"));
				$this->logsInfo = $account;
				
				list($accountId, $platform) = D("UserAccountManager")->getDataByAccount($account);
				if(is_null($accountId)){	// 不存在 accountId，给出提示
					$this->assign("tips", 1);
					$this->display();
					return;
				}
				
				$result = D("UserRegisterInfo")->getDataById($accountId);

				if(is_array($result) && empty($result)){	// 未完成新手引导，给出提示
					$this->assign("tips", 2);
					$this->display();
					return;	
				}
				
				// 删除原来的 account
				D("Accounts")->deleteDatas($this->mgId, $account);
				
				$roleId = D("Managers")->getRoleIdById($this->mgId);	// 得到角色 ID
				// $platforms = D("Roles")->getPlatforms($roleId);			// 得到该角色可以操作的渠道

				// 添加 account
				D("Accounts")->addDatas($this->mgId, $account, $result, $platform);
				
				$this->logsState = 1;
				parent::__destruct();
				
				redirect(U("index"));
				
			}else{
				$this->display();
			}
		}
		
		/*
		* 白名单
		*/
		public function whiteAction (){
			if(IS_POST){
				$account = trim(I("account"));
				$this->logsInfo = $account;
				
				$accountId = D("UserAccountManager")->getDataByAccount($account);
				if(is_null($accountId)){	// 不存在 accountId，给出提示
					$this->assign("tips", 1);
					$this->display();
					return;
				}
				
//				$result = D("UserRegisterInfo")->getDataById($accountId);
//				if(is_array($result) && empty($result)){
//					$this->assign("tips", 2);	// 未完成新手引导，给出提示
//					$this->display();
//					return;	
//				}
				
				// 更新白名单
				D("UserAccountManager")->saveWhiteById($accountId);
				
				$this->assign("tips", 3);
				
				$this->logsState = 1;
			}
				
			$this->display();
		}
		
		/*
		* 删除账号
		*/
		public function deleteAction ($ids = []){
			D("Accounts")->deleteDataByIds($ids);
		}
		
		/*
		* 登录账号
		*/
		public function loginAction ($id = 0){
			if(!is_ajax()){
				return ;
			}
			
			$this->logsInfo = $id;
			
			$account = D("Accounts")->getDataById($id);
			if(is_null($account)){	// 该账号不存在，返回 0
				echo 0;	
				return ;
			}
			
			$roleId = D("Managers")->getRoleIdById($this->mgId);
			$platforms = D("Roles")->getPlatforms($roleId);
			// if(!in_array($account["platform"], $platforms)){	// 没有访问该渠道的权限，返回 2
			// 	echo 2;
			// 	return;	
			// }
			
			// 登录成功，相关数据存入 session
			session("account", $account["account"]);
			session("platform", $account["platform"]);
			session("server_num", $account["server_num"]);
			session("os", $account["os"]);
			session("open_id", $account["open_id"]);
			
			$this->logsState = 1;
			
			echo 1;
		}
		
		/*
		* 退出
		*/
		public function logoutAction ($id){
			if(!is_ajax()){
				return ;
			}
			
			$this->logsInfo = $id;
			
			// 清空 session
			session("account", -1);
			session("platform", -1);
			session("server_num", -1);
			session("os", -1);
			session("open_id", null);
			
			$this->logsState = 1;
			
			echo 1;	
		}
	}