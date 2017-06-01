<?php
	namespace Admin\Model;
	use Think\Model;
	
	class ManagersModel extends Model{
		/*
		* 根据 ID 得到数据
		*/
		public function getDataById($mgId){
			$where = array(
				"mg_id"	=> (int)$mgId
			);
			return $this->where($where)->find();
		}
		
		/*
		* 根据角色 ID 得到数据
		*/
		public function getDataByRoleId($roleId){
			$where = array(
				"role_id"	=> (int)$roleId
			);
			return $this->where($where)->select();	
		}
		
		/*
		* 根据 ID 得到角色 ID
		*/
		public function getRoleIdById($mgId){
			$where = array(
				"mg_id"	=> (int)$mgId
			);
			
			return $this->where($where)->getField("role_id");
		}
		
		/*
		* 得到所有的用户名
		*/
		public function getNames(){
			$result = $this->field("mg_name")->select();
			$mgNames = [];
			
			foreach ($result as $res){
				$mgNames[] = strtolower($res["mg_name"]);	
			}	
			
			return $mgNames;
		}
		
		/*
		* 得到所有的用户名，除了他自己本身的
		*/
		public function getNamesExcpteSelf(){
			$result = $this->field("mg_name")->select();
			
			$mgNames = [];
			foreach ($result as $res){
				if($res["mg_name"] != session("mg_name")){
					$mgNames[] = strtolower($res["mg_name"]);	
				}
			}
			
			return $mgNames;
		}
		
		/*
		* 根据 ID 得到用户名
		*/
		public function getNameById($mgId){
			$where = array(
				"mg_id"	=> (int)$mgId
			);
			return $this->where($where)->getField("mg_name");
		}
		
		/*
		* 根据 ID 得到密码
		*/
		public function getPwdById($mgId){
			$where = array(
				"mg_id"	=> (int)$mgId
			);
			return $this->where($where)->getField("mg_pwd");
		}
		
		/*
		* 根据用户名和密码得到数据
		*/
		public function getDataByNameAndPwd($mgName, $mgPwd, $encty = true){
			if($encty){
				$where = array(
					"mg_name" 	=> trim($mgName),
					"mg_pwd"	=> $this->pwdEncryption($mgPwd),
					"mg_islock"	=> 0
				);
			}else{
				$where = array(
					"mg_name" 	=> trim($mgName),
					"mg_pwd"	=> $mgPwd,
					"mg_islock"	=> 0
				);
			}
			
			return $this->where($where)->find();
		}
		
		/*
		* 得到管理员的个数
		*/
		public function getCount($where){
			return $this->where($where)->count();
		}
		
		/*
		* 得到数据（带有限制条件）
		*/
		public function getDataWithLimit($where, $limit){
			return $this->where($where)->limit($limit)->select();
		}
		
		/*
		* 根据 roldId 得到该角色的状态
		* 该角色中所有的管理员都是“正常”的，则该角色的状态值为 0；
		* 该角色中所有的管理员都是“锁定”的，则该角色的状态值为 1；
		* 该角色中有的管理员“正常”，有的管理员“锁定”，则该角色的状态值为 2；
		* 若该角色中没有管理员，则该角色的状态值为 0；
		*/
		public function getStateByRoleId($roleId){
			$where = array(
				"role_id"	=> $roleId
			);
			$islock = $this->where($where)->getField("mg_islock", true);
			$sum = array_sum($islock);
			
			if(is_null($sum) || $sum == 0){
				return 0;
			}else if($sum == count($islock)){
				return 1;	
			}else{
				return 2;	
			}
		}
		
		/*
		* 根据 ID 更新数据
		*/
		public function saveDataById($mgId, $data){
			$where = array(
				"mg_id"	=> (int)$mgId
			);
			return $this->where($where)->save($data);
		}
		
		/*
		* 添加数据
		*/
		public function addData($mgName, $mgPwd, $mgTrueName, $roleId){
			$data = array(
				"mg_name"		=> $mgName,
				"mg_pwd"		=> $this->pwdEncryption($mgPwd),
				"mg_true_name"	=> $mgTrueName,
				"role_id"		=> (int)$roleId,
				"create_time"	=> date("Y-m-d H:i:s")
			);
			return $this->add($data);	
		}
		
		/*
		* 根据 ID 更新上次登录时间
		*/
		public function saveLoginTimeById($mgId){
			$where = array(
				"mg_id"	=> (int)$mgId
			);
			$data = array(
				"last_login_time"	=> date("Y-m-d H:i:s")
			);
			$this->where($where)->save($data);	
		}
		
		/*
		* 密码加密
		*/
		public function pwdEncryption($mgPwd){
			return md5(md5(C("PWD_SUFFIX") . $mgPwd));
		}
		
		/*
		* 根据 IDs 更新锁定的状态
		*/
		public function saveLockStateByIds($mgIds, $isLock){
			foreach ($mgIds as $mgId){
				$where = array(
					"mg_id"		=> (int)$mgId
				);
				$data = array(
					"mg_islock"	=> $isLock
				);
				$this->where($where)->save($data);
			}
		}
		
		/*
		* 根据 RoleIds 更新锁定的状态
		*/
		public function saveLockStateByRoleIds($roleIds, $isLock){
			$result = [];
			
			foreach ($roleIds as $roleId){
				$where = array(
					"role_id"	=> (int)$roleId
				);
				$data = array(
					"mg_islock"	=> $isLock
				);
				$this->where($where)->save($data);
				
				$result[$roleId] = $this->where($where)->count();
			}
			
			return $result;
		}
		
		/*
		* 根据 IDs 更新角色 ID
		*/
		public function saveRoleId($mgIds, $roleId){
			foreach ($mgIds as $mgId){
				$where = array(
					"mg_id"	=> (int)$mgId
				);
				$data = array(
					"role_id"	=> (int)$roleId
				);
				$this->where($where)->save($data);
			}	
		}
		
		/*
		* 根据 IDs 删除数据
		*/
		public function deleteDataByIds($mgIds){
			foreach ($mgIds as $mgId){
				$where = array(
					"mg_id"		=> (int)$mgId
				);
				$this->where($where)->delete();
			}	
		}
	}