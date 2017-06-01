<?php
	namespace Admin\Model;
	use Think\Model;
	
	class RolesModel extends Model{
		/*
		* ���� ID �õ�����
		*/
		public function getDataById($roleId){
			$where = array(
				"role_id"	=> (int)$roleId
			);
			return $this->where($where)->find();
		}
		
		/*
		* �õ�����
		*/
		public function getCount(){
			return $this->count();
		}
		
		/*
		* �õ����ݣ�������������
		*/
		public function getDataWithLimit($limit){
			return $this->limit($limit)->select();	
		}
		
		/*
		* �õ����еĽ�ɫ��
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
		* �õ����еĽ�ɫ�����������Լ������
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
		* ���� ID �õ���ɫ��
		*/
		public function getNameById($roleId){
			$where = array(
				"role_id"	=> (int)$roleId
			);
			return $this->where($where)->getField("role_name");
		}
		
		/*
		* ���ݽ�ɫ���õ� ID
		*/
		public function getIdByName($roleName){
			$where = array(
				"role_name"	=> $roleName
			);
			return $this->where($where)->getField("role_id");
		}
		
		/*
		* ���� ID �õ� PowIds
		*/
		public function getPowIdsById($roleId){
			$where = array(
				"role_id"	=> (int)$roleId
			);
			return $this->where($where)->getField("pow_ids");
		}
		
		/*
		* ���� ID �õ� PowAc
		*/
		public function getPowAcById($roleId){
			$where = array(
				"role_id"	=> (int)$roleId
			);
			return $this->where($where)->getField("pow_ac");
		}
		
		/*
		* ���� ID �õ� platforms
		*/
		public function getPlatforms($roleId){
			$where = array(
				"role_id"	=> (int)$roleId
			);	
			
			$platforms = $this->where($where)->getField("platforms");
			
			return is_null($platforms) ? [] : explode(",", $platforms);
		}
		
		/*
		* ���� ID �õ� version_edit
		*/
		public function getVersionEditById($roleId){
			$where = array(
				"role_id" => $roleId
			);	
			
			return $this->where($where)->getField("version_edit");
		}
		
		/*
		* �������
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
		* ���� ID ���½�ɫ��
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
		* ���� ID ��������
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
		* ���� ID ɾ������
		*/
		public function deleteDataById($roleId){
			$where = array(
				"role_id"	=> (int)$roleId
			);
			$this->where($where)->delete();	
		}
	}