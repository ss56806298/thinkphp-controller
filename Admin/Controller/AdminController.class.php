<?php
	namespace Admin\Controller;
	
	class AdminController extends CommonController{
		public function indexAction (){
			$roleId = (int)I("role_id");
			if($roleId == 0){
				$where = 1;	
			}else{
				$where = array(
					"role_id"	=> $roleId
				);	
			}
			
			$count = D("Managers")->getCount($where);
			$page = new \Think\Page($count, $this->scount);
			$show = $page->show();
			
			$result = D("Managers")->getDataWithLimit($where, $page->firstRow . "," . $page->listRows);
			foreach ($result as &$res){
				unset($res["mg_pwd"]);
				$res["role_name"] = D("Roles")->getNameById($res["role_id"]);
			}
			
			$this->assign("roles", D("Roles")->select());
			$this->assign("managers", $result);
			$this->assign("page", $show);
			$this->display();
		}
		
		public function addAction (){
			if(IS_POST){
				$mgTrueName = trim(I("mg_true_name"));
				$mgName = trim(I("mg_name"));
				$mgPwd = I("mg_pwd");
				$mgPwdAgain = I("mg_pwd_again");
				$roleId= (int)trim(I("role"));
				
				$this->logsInfo = $mgTrueName . ", " . $mgName . ", " . $mgPwd  . ", " . $mgPwdAgain . ", " . $roleId;
				
				if($mgTrueName == ""){
					$this->assign("tips", 1);
					$this->assign("roles", D("Roles")->select());
					$this->display();
					return;	
				}
				
				if($mgName == ""){
					$this->assign("tips", 2);
					$this->assign("roles", D("Roles")->select());
					$this->display();
					return;	
				}
				
				if(in_array(strtolower($mgName), D("Managers")->getNames())){
					$this->assign("tips", 3);
					$this->assign("roles", D("Roles")->select());
					$this->display();
					return;	
				}
				
				if($mgPwd == ""){
					$this->assign("tips", 4);
					$this->assign("roles", D("Roles")->select());
					$this->display();
					return;	
				}
				
				if($mgPwd != $mgPwdAgain){
					$this->assign("tips", 5);
					$this->assign("roles", D("Roles")->select());
					$this->display();
					return;	
				}
				
				$res = D("Managers")->addData($mgName, $mgPwd, $mgTrueName, $roleId);
				
				if($res !== false){
					$this->logsInfo .= ", " . $res;
					$this->logsState = 1;	
				}
				parent::__destruct();
				
				redirect(U("index"));				
				
			}else{
				$this->assign("roles", D("Roles")->select());
				$this->display();
			}
		}
		
		public function saveAction (){
			if(IS_POST){
				$mgId = (int)I("mg_id");
				$mgTrueName = trim(I("mg_true_name"));
				$mgName = trim(I("mg_name"));
				$mgPwd = I("mg_pwd");
				$mgPwdAgain = I("mg_pwd_again");
				$islock = (int)I("state");
				$roleId= (int)trim(I("role"));
				
				$this->logsInfo = $mgId . ", " . $mgTrueName . ", " . $mgName . ", " . $mgPwd . ", " . $mgPwdAgain . ", " . $islock . ", " . $roleId;
				
				if($mgTrueName == ""){
					$this->assign("tips", 1);
					$this->assign("manager", D("Managers")->getDataById(I("mg_id")));
					$this->assign("roles", D("Roles")->select());
					$this->display();
					return;	
				}
				
				if($mgName == ""){
					$this->assign("tips", 2);
					$this->assign("manager", D("Managers")->getDataById(I("mg_id")));
					$this->assign("roles", D("Roles")->select());
					$this->display();
					return;	
				}
				
				if(in_array(strtolower($mgName), D("Managers")->getNames()) && strtolower($mgName) != D("Managers")->getNameById($mgId)){
					$this->assign("tips", 3);
					$this->assign("manager", D("Managers")->getDataById(I("mg_id")));
					$this->assign("roles", D("Roles")->select());
					$this->display();
					return;	
				}
				
				if($mgPwd != $mgPwdAgain){
					$this->assign("tips", 4);
					$this->assign("manager", D("Managers")->getDataById(I("mg_id")));
					$this->assign("roles", D("Roles")->select());
					$this->display();
					return;	
				}
				
				$data = array(
					"mg_name"		=> $mgName,
					"mg_true_name"	=> $mgTrueName,
					"mg_islock"		=> $islock,
					"role_id"		=> $roleId
				);
				
				if($mgPwd != ""){
					$data["mg_pwd"] = D("Managers")->pwdEncryption($mgPwd);
				}
				
				$res = D("Managers")->saveDataById($mgId, $data);
				if($res !== false && $mgId == $this->mgId){
					session("mg_name", $mgName);
					session("mg_true_name", $mgTrueName);	
				}
				
				if($res !== false){
					$this->logsState = 1;	
				}
				parent::__destruct();
				
				redirect(U("index"));		
			}
			
			$this->assign("manager", D("Managers")->getDataById(I("mg_id")));
			$this->assign("roles", D("Roles")->select());
			$this->display();	
		}
		
		public function unlockAction ($mg_ids = []){
			if(!is_ajax()){
				return ;	
			}
			
			$this->logsInfo = implode(", ", $mg_ids);
			
			D("Managers")->saveLockStateByIds($mg_ids, 0);
			
			$this->logsState = 1;
		}
		
		public function lockAction ($mg_ids = []){
			if(!is_ajax()){
				return ;	
			}
			
			$this->logsInfo = implode(", ", $mg_ids);
			
			D("Managers")->saveLockStateByIds($mg_ids, 1);
			
			$this->logsState = 1;
		}
		
		public function deleteAction ($mg_ids = []){
			if(!is_ajax()){
				return ;	
			}
			
			$this->logsInfo = implode(", ", $mg_ids);
			
			D("Managers")->deleteDataByIds($mg_ids);
			
			$this->logsState = 1;
		}
		
		public function moveAction ($role_id = 0, $mg_ids = []){
			if(!is_ajax()){
				return ;	
			}
			
			$this->logsInfo = $role_id . ", " . implode(", ", $mg_ids);
			
			D("Managers")->saveRoleId($mg_ids, (int)$role_id);
			
			$this->logsState = 1;
		}
		
		public function mgNameAction ($mg_name = ""){
			if(!is_ajax()){
				return ;	
			}
			
			$mgName = strtolower(trim($mg_name));
			
			if($mgName == ""){
				echo 1;	
			}else if(in_array($mgName, D("Managers")->getNames())){
				echo 2;	
			}else{
				echo 3;	
			}
		}
		
		public function mgNameSaveAction ($mg_id = 0, $mg_name = ""){
			if(!is_ajax()){
				return ;	
			}
			
			$mgName = strtolower(trim($mg_name));
			
			if($mgName == ""){
				echo 1;
			}else if($mgName == strtolower(D("Managers")->getNameById($mg_id))){
				echo 2;
			}else if(in_array($mgName, D("Managers")->getNames())){
				echo 3;	
			}else{
				echo 4;	
			}
		}
	}