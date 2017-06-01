<?php
	namespace Admin\Model;
	use Think\Model;
	
	class UserAccountManagerModel extends Model{
		protected $dbName = "identity_manager_uni";
		protected $tablePrefix = "";
		
		/*
		* 得到除 NULL 以外的所有账号
		*/
		public function getDatas(){
			$where["account"] = array("exp", "is not null");
			
			return $this->where($where)->getField("account", true);
		}		
		
		/*
		* 根据账号和密码得到数据
		*/
		public function getDataByAccountAndPwd($account, $pwd){
			$where = array(
				"account"	=> trim($account),
				"ps_yxlc"	=> md5($pwd)
			);
			return $this->where($where)->find();
		}
		
		/*
		* 根据账号得到数据
		*/
		public function getDataByAccount($account){
			$where = array(
				"account"	=> trim($account),
			);
			return [$this->where($where)->getField("account_id"), $this->where($where)->getField("platform")];
		}
		
		/*
		* 根据账号得到账号 ID
		*/
		public function getIdByAccount($account){
			$where = array(
				"account"	=> trim($account),
			);
			return $this->where($where)->getField("account_id");
		}
			
		/*
		* 根据账号和平台得到账号 ID
		*/
		public function getIdByAccountAndPlatform($account, $platform){
			// //如果是官服,改变数据库
			// if ($platform == 'YL') {
			// 	$this->dbName = "identity_manager_ypw";
			// }

			$where = array(
				"account"	=> trim($account),
			);
			return $this->where($where)->getField("account_id");
		}

		/*
		* 更新 white_list
		*/
		public function saveWhiteById($accountId){
			$where = array(
				"account_id"	=> $accountId
			);	
			
			$this->where($where)->setField("white_list", 1);
		}
	}