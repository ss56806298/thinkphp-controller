<?php
	namespace Admin\Model;
	use Think\Model;
	
	class AccountsModel extends Model{
		/*
		* 得到唯一的一条数据
		*/
		public function getData($mgId, $account, $platform, $serverNum, $os){
			$where = array(
				"mg_id"			=> $mgId,
				"account"		=> $account,
				"platform"		=> $platform,
				"server_num"	=> $serverNum,
				"os"			=> $os
			);
			return $this->where($where)->find();
		}
		
		/*
		* 根据 ID 得到数据
		*/
		public function getDataById($id){
			$where = array(
				"id" => $id	
			);
			
			return $this->where($where)->find();
		}
		
		/*
		* 根据 mgId 得到对应的记录个数
		*/
		public function getCountById($mgId){
			$where = array(
				"mg_id"	=> $mgId
			);
			return $this->where($where)->count();
		}
		
		/*
		* 根据 mgId 得到带有限制条件的记录
		*/
		public function getDataByIdWithLimit($mgId, $limit){
			$where = array(
				"mg_id"	=> $mgId
			);
			
			return $this->where($where)->order("account")->limit($limit)->select();
		}
		
		/*
		* 添加多条数据
		*/
		public function addDatas($mgId, $account, $datas, $platform){
			foreach ($datas as $value){
				
				// if(!in_array($value["platform"], $platforms)){
				// 	continue;
				// }
				
				$data = array(
					"mg_id"			=> $mgId,
					"account"		=> $account,
					"platform"		=> $platform,
					"server_num"	=> $value["server_num"],
					"os"			=> $value["os"],
					"open_id"		=> $value["open_id"]
				);
				
				$this->add($data);
			}	
		}
		
		/*
		* 更新 userId
		*/
		public function saveUserId($data, $userId){
			$where = array(
				"mg_id"		=> $data["mg_id"],
				"account"	=> $data["account"],
				"platform"	=> $data["platform"],
				"server_num"=> $data["server_num"],
				"os"		=> $data["os"],
			);
			
			$this->where($where)->setField("user_id", $userId);
		}
		
		/*
		* 根据 mgId 和 account 删除数据
		*/
		public function deleteDatas($mgId, $account){
			$where = array(
				"mg_id"		=> $mgId,
				"account"	=> $account
			);
			$this->where($where)->delete();
		}
		
		/*
		* 根据 ID 删除记录
		*/
		public function deleteDataByIds($ids){
			foreach($ids as $key => $val){
				$where = array(
					"id" => $val
				);	
				
				$this->where($where)->delete();
			}
		}
	}