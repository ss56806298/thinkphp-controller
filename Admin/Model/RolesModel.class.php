<?php
	namespace Admin\Model;
	use Think\Model;
	
	class RolesModel extends Model{
		/*
		* 根据 ID 得到数据
		*/
		public function getDataById($roleId){
			$where = array(
				"role_id"	=> (int)$roleId
			);
			return $this->where($where)->find();
		}
		
		/*
		* 得到个数
		*/
		public function getCount(){
			return $this->count();
		}
		
		/*
		* 得到数据（带限制条件）
		*/
		public function getDataWithLimit($limit){
			return $this->limit($limit)->select();	
		}
		
		/*
		* 得到所有的角色名
		*/
		public function getNames (){
			$roleNames = [];
			
			$result = $this->field("role_name")->select();
			foreach ($result as $res){
				$roleNames[] = $res["role_name"];	
			}
			
			return $roleNames;
		}
		
		/*
		* 得到所有的角色名，除了他自己本身的
		*/
		public function getNamesExcpteSelf ($roleName){
			$roleNames = [];
			
			$result = $this->field("role_name")->select();
			foreach ($result as $res){
				if($res["role_name"] != $roleName){
					$roleNames[] = $res["role_name"];	
				}
			}
			
			return $roleNames;
		}
		
		/*
		* 根据 ID 得到角色名
		*/
		public function getNameById($roleId){
			$where = array(
				"role_id"	=> (int)$roleId
			);
			return $this->where($where)->getField("role_name");
		}
		
		/*
		* 根据角色名得到 ID
		*/
		public function getIdByName($roleName){
			$where = array(
				"role_name"	=> $roleName
			);
			return $this->where($where)->getField("role_id");
		}
		
		/*
		* 根据 ID 得到 PowIds
		*/
		public function getPowIdsById($roleId){
			$where = array(
				"role_id"	=> (int)$roleId
			);
			return $this->where($where)->getField("pow_ids");
		}
		
		/*
		* 根据 ID 得到 PowAc
		*/
		public function getPowAcById($roleId){
			$where = array(
				"role_id"	=> (int)$roleId
			);
			return $this->where($where)->getField("pow_ac");
		}
		
		/*
		* 根据 ID 得到 platforms
		*/
		public function getPlatforms($roleId){
			$where = array(
				"role_id"	=> (int)$roleId
			);	
			
			$platforms = $this->where($where)->getField("platforms");
			
			return is_null($platforms) ? [] : explode(",", $platforms);
		}
		
		/*
		* 根据 ID 得到 version_edit
		*/
		public function getVersionEditById($roleId){
			$where = array(
				"role_id" => $roleId
			);	
			
			return $this->where($where)->getField("version_edit");
		}
		
		/*
		* 添加数据
		*/
		public function addData($roleName, $power, $platforms, $versionEdit){
			$data = array(
				"role_name"	=> $roleName,
				"pow_ids"	=> $power["pow_ids"],
				"pow_ac"	=> $power["pow_ac"],
				"platforms"	=> implode(",", $platforms),
				"version_edit" => (int)$versionEdit
			);
			return $this->add($data);	
		}
		
		/*
		* 根据 ID 更新角色名
		*/
		public function saveNameById($roleId, $roleName){
			$where = array(
				"role_id"	=> (int)$roleId
			);	
			$data = array(
				"role_name"	=> trim($roleName)
			);
			$this->where($where)->save($data);	
		}
		
		/*
		* 根据 ID 更新数据
		*/
		public function saveDataById($roleId, $power, $platforms, $versionEdit){
			$where = array(
				"role_id"	=> (int)$roleId
			);
			$data = array(
				"pow_ids"	=> $power["pow_ids"],
				"pow_ac"	=> $power["pow_ac"],
				"platforms"	=> implode(",", $platforms),
				"version_edit" => (int)$versionEdit
			);
			$this->where($where)->save($data);	
		}
		
		/*
		* 根据 ID 删除数据
		*/
		public function deleteDataById($roleId){
			$where = array(
				"role_id"	=> (int)$roleId
			);
			$this->where($where)->delete();	
		}
	}