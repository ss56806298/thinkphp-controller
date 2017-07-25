<?php
	namespace Admin\Model;
	use Think\Model;
	
	class AreaListModel extends Model{
		protected $dbName = "identity_manager";
		protected $tablePrefix = "";
		/**
		* 获取所有的服务器信息
		*/
		public function updateAreaVersion($area, $version) {
			$where = array(
				"area"	=> $area
			);	
			$data = array(
				"version"	=> $version
			);
			$this->where($where)->save($data);	
		}
	}