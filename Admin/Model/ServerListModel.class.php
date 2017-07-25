<?php
	namespace Admin\Model;
	use Think\Model;
	
	class ServerListModel extends Model{
		protected $dbName = "identity_manager";
		protected $tablePrefix = "";
		/**
		* 获取所有的服务器信息
		*/
		public function getAllServerList() {
			$where = array();

			return $this->where($where)->getField('server_num', true);
		}
	}