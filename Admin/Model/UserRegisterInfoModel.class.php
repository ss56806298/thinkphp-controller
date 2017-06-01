<?php
	namespace Admin\Model;
	use Think\Model;
	
	class UserRegisterInfoModel extends Model{
		protected $dbName = "identity_manager_uni";
		protected $tablePrefix = "";
		
		/*
		* ¸ù¾Ý ID µÃµ½Êý¾Ý
		*/
		public function getDataById($accountId){
			$where = array(
				"account_id"	=> $accountId
			);
			return $this->where($where)->select();
		}
		
		/*
		* ¸ù¾Ý ID, server_num, platform, os µÃµ½ open_id
		*/
		public function getOpenId($accountId, $platform, $serverNum, $os){
			$where = array(
				"account_id"	=> $accountId, 
				"platform"		=> $platform,
				"server_num"	=> $serverNum,
			);
			
			if($os === "0"){
				$count = $this->where($where)->count();
				
				if($count !== "1"){
					return [null, null, $count];

				}else{
					$res = $this->where($where)->find();
					return [$res["open_id"], $res["os"], $count];
				}
				
			}else{
				$where["os"] = $os;
				$res = $this->where($where)->getField("open_id");
				$flag = is_null($res) ? 0 : 1;
				
				return [$res, $os, $flag];
			}
		}
	}