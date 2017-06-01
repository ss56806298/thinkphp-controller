<?php
	namespace Admin\Controller;
	
	class RoleController extends CommonController{
		public function indexAction (){
			$count = D("Roles")->getCount();
			$page = new \Think\Page($count, $this->scount);
			$show = $page->show();
			$roles = D("Roles")->getDataWithLimit($page->firstRow . "," . $page->listRows);
			
			foreach ($roles as &$v){
				// 0:正常(#333333)，1:锁定(#ff0000)，2:部分锁定(#0000ff)
				$v["state"] = D("Managers")->getStateByRoleId($v["role_id"]);
			}
			
			$this->assign("roles", $roles);
			$this->assign("page", $show);
			$this->display();
		}
		
		public function addAction (){
			if(IS_POST){
				$roleName = trim(I("role_name"));
				$power = I("power");
				$manager = I("manager");
				$platforms = I("platforms");
				$versionEdit = (int)I("version_edit");
				
				$this->logsInfo = $roleName . $this->logsSep . implode(", ", $power) . $this->logsSep . implode(", ", $manager) . $this->logsSep . implode(",", $platforms);			
				
				if($roleName == ""){
					$this->assign("tips", 1);
					$this->assign("managers", $this->_getManagerAll());	
					$this->assign("all_power", D("Powers")->getData());
					$this->display();
					return ;
				}
				
				if(in_array($roleName, D("Roles")->getNames())){
					$this->assign("tips", 2);
					$this->assign("managers", $this->_getManagerAll());	
					$this->assign("all_power", D("Powers")->getData());
					$this->display();
					return ;
				}
				
				$power = D("Powers")->getPowIdsAndAc($power);
				$roleId = D("Roles")->addData($roleName, $power, $platforms, $versionEdit);

				D("Managers")->saveRoleId($manager, $roleId);
				
				$this->logsState = 1;
				parent::__destruct();
				
				redirect(U("index"));
				
			}
			
			$this->assign("managers", $this->_getManagerAll());	
			$this->assign("all_power", D("Powers")->getData());
			$this->assign("platforms", $this->_getHasPlatforms(-1));
			$this->display();	
		}
		
		public function saveAction (){
			if(IS_POST){
				$roleId = (int)I("role_id");
				$roleName = trim(I("role_name"));
				$powers = I("power");
				$platforms = I("platforms");
				$versionEdit = (int)I("version_edit");
				
				$this->logsInfo = $roleId . ", " . $roleName . ", " . implode(", ", $powers) . ", " . implode(", ", $platforms);
				
				$roleNameOld = D("Roles")->getNameById($roleId);
				$roleNames = D("Roles")->getNamesExcpteSelf($roleNameOld);
				
				if($roleName == ""){
					$powers = $this->_getHasPowers($roleId);
					
					$this->assign("tips", 1);
					$this->assign("role_id", $roleId);
					$this->assign("role_name", $roleName);
					$this->assign("powers", $powers);
					$this->display();
					return;	
				}
				
				if(in_array($roleName, $roleNames)){
					$powers = $this->_getHasPowers($roleId);
					
					$this->assign("tips", 2);
					$this->assign("role_id", $roleId);
					$this->assign("role_name", $roleName);
					$this->assign("powers", $powers);
					$this->display();
					return;
				}
				
				D("Roles")->saveNameById($roleId, $roleName);
				
				$power = D("Powers")->getPowIdsAndAc($powers);
				D("Roles")->saveDataById($roleId, $power, $platforms, $versionEdit);
				
				$this->logsState = 1;
				parent::__destruct();
				
				redirect(U("index"));
			}
			
			$roleId = (int)I("role_id");
			$roleName = D("Roles")->getNameById($roleId);
			$powers = $this->_getHasPowers($roleId);
			$platforms = $this->_getHasPlatforms($roleId);
			$versionEdit = D("Roles")->getVersionEditById($roleId);
			
			$checkedAll = 1;
			foreach($platforms as $key => $val){
				if($val["checked"] == 0){
					$checkedAll = 0;	
				}	
			}
			
			$this->assign("role_id", $roleId);
			$this->assign("role_name", $roleName);
			$this->assign("powerss", $powers);
			$this->assign("platforms", $platforms);
			$this->assign("checkedAll", $checkedAll);
			$this->assign("version_edit", $versionEdit);
			$this->display();
		}
		
		public function unlockAction($role_ids = []){
			if(!is_ajax()){
				return ;	
			}
			
			$this->logsInfo = implode(", ", $role_ids);
			
			D("Managers")->saveLockStateByRoleIds($role_ids, 0);
			
			$this->logsState = 1;
		}
		
		public function lockAction($role_ids = []){
			if(!is_ajax()){
				return ;	
			}
			
			$this->logsInfo = implode(", ", $role_ids);
			
			$count = D("Managers")->saveLockStateByRoleIds($role_ids, 1);
			
			$result = [];
			
			foreach ($count as $key => $value){
				if($value == 0){
					$result[] = D("Roles")->getNameById($key);
				}
			}
			
			$this->logsState = 1;
			
			echo json_encode($result);
		}
		
		public function deleteAction($role_ids = []){
			if(!is_ajax()){
				return ;	
			}
			
			$this->logsInfo = implode(", ", $role_ids);
			
			$result = [];
			
			foreach ($role_ids as $key => $value){
				$count = count(D("Managers")->getDataByRoleId($value));
				
				if($count == 0){
					D("Roles")->deleteDataById($value);	
				}else{
					$result[] = D("Roles")->getNameById($value);	
				}
			}
			
			$this->logsState = 1;
			
			echo json_encode($result);
		}
		
		public function roleNameAction ($role_name = ""){
			if(!is_ajax()){
				return ;	
			}
			
			$roleName = trim($role_name);
			
			if($roleName == ""){
				echo 1;
			}else if(in_array($roleName, D("Roles")->getNames())){
				echo 2;	
			}else{
				echo 3;	
			}
		}
		
		public function roleNameSaveAction ($role_id = 0, $role_name = ""){
			if(!is_ajax()){
				return ;	
			}
			
			$roleName = trim($role_name);
			
			if($roleName == ""){
				echo 1;
			}else if($roleName == D("Roles")->getNameById($role_id)){
				echo 2;
			}else if(in_array($roleName, D("Roles")->getNames())){
				echo 3;	
			}else{
				echo 4;	
			}
		}
		
		private function _getManagerAll(){
			$managers = D("Managers")->select();
			foreach ($managers as &$manager){
				unset($manager["mg_pwd"]);
				$manager["role_name"] = D("Roles")->getNameById($manager["role_id"]);
			}
			
			return $managers;
		}
		
		private function _getHasPowers($roleId){
			$powIds = explode(",", D("Roles")->getPowIdsById($roleId));
			return D("Powers")->getData($powIds);
		}
		
		private function _getHasPlatforms($roleId){
			$platforms = [];
			
			$plat = D("Roles")->getPlatforms($roleId);
			
			foreach($this->platform as $k => $v){
				$platforms[] = array(
					"platform" => $k,
					"checked" => (int)in_array($k, $plat)
				);
			}
			
			return $platforms;
		}
	}