<?php
namespace Admin\Model;
use Think\Model;

/**
* CDKEY的生成
*/
class CdkeyMasterModel extends Model{
	protected $dbName = "identity_manager";
	protected $tablePrefix = "";

	/**
	* INSERT
	*/
	public function addData($data) {

		$this->add($data);
	}

	/**
	* search
	*/
	public function searchCdkey($cdkey) {
		$where = array(
			'cdkey' => $cdkey
		);

		return $this->where($where)->find();
	}
}