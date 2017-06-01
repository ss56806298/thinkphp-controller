<?php
	namespace Admin\Model;
	use Think\Model;
	
	class AccountsModel extends Model{
		/**
		* 获取所有的服务器信息
		*/
		public function getAllServerList() {
			$where = array();

			return $this->where($where)->find();
		}
	}