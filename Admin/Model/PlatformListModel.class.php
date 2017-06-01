<?php
namespace Admin\Model;
use Think\Model;
	
class PlatformListModel extends Model{
	protected $dbName = "identity_manager";
	protected $tablePrefix = "";
	/**
	* 获取所有的服务器信息
	*/
	public function getAllPlatformList() {
		$where = array(
		);

		return $this->where($where)->getField('platform', true);;

	}
}