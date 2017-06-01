<?php
namespace Admin\Controller;
use Org\Net\HTTP;
/**
* CDKEY生成
*/
class CdkeyController extends CommonController{
	private $_commonCsv;	// 普通奖励
	private $_materialCsv;	// 素材奖励
	private $_composeCsv;	// 碎片奖励
	private $_monsterCsv;	// 英雄奖励
	private $_presentCsv;	// 礼包奖励
	private $_rewardNameCsv;// 奖励的名字

    private static $_enableCode_mix = [
        "a",
        "b", "2",
        "c", "3",
        "d", "4",
        "e", "5",
        "f", "6",
        "g", "7",
        "h", "8",
        "i", "9",
        "j",
        "k",
        "m",
        "n",
        "p",
        "q",
        "r",
        "s",
        "t",
        "u",
        "v",
        "w",
        "x",
        "y",
        "z",
    ];

	// 当前操作用到的 CSV
	private $_csv = array(
		"_commonCsv"		=> "common.csv",
		"_materialCsv"		=> "material_drop.csv",
		"_composeCsv"		=> "compose_monster.csv",
		"_monsterCsv"		=> "monster.csv",
		"_presentCsv"		=> "present.csv",
		"_rewardNameCsv"	=> "reward_name.csv",
	);

	public function __construct(){
		parent::__construct();
		
		// 缓存
		foreach ($this->_csv as $k => $v){
			$this->$k = RedisController::getArray($v);
			if($this->$k === false){
				RedisController::setArray($v);	
				$this->$k = RedisController::getArray($v);
			}	
		}
	}

	public function indexAction() {
		if (IS_POST) {
			$eventId = I('event_id');						//活动编号
			$eventComment = I('event_comment');				//备注
			$cdkeyNumber = I('cdkey_number');				//产生的CDKEY的数量
			$platform = I('platform');						//平台
			$remainUsedTimes = I('remain_used_times');		//可使用的次数
			$startTime = I('start_time');					//开始时间
			$endTime = I('end_time');						//失效时间
			$itemIds = I("item_ids");						// 奖励的 IDs
			$itemNums = I("item_nums");						// 奖励的数量

			//活动编号为空的话,默认为可以每个玩家都参与的活动
			if (is_numeric($eventId) && ($eventId < 0 || $eventId > 100)) {
				$this->assign("error", 1);
				$this->_assign();
				$this->display();
				return;
			}

			//活动编号为空的话,默认为可以每个玩家都参与的活动
			if (!is_numeric($cdkeyNumber) || $cdkeyNumber <= 0 || $cdkeyNumber > 10000) {
				$this->assign("error", 2);
				$this->_assign();
				$this->display();
				return;
			}

			//剩余次数
			if (!is_numeric($remainUsedTimes) || $remainUsedTimes < 0) {
				$this->assign("error", 3);
				$this->_assign();
				$this->display();
				return;
			}

			$startUxTime = strtotime($startTime);
			$endUxTime = strtotime($endTime);

			//时间的判断
			if (!$startUxTime || !$endUxTime || $startUxTime >= $endUxTime) {
				$this->assign("error", 4);
				$this->_assign();
				$this->display();
				return;
			}

			// 奖励不能为空
			if(empty($itemIds)){
				$this->assign("error", 5);
				$this->_assign();
				$this->display();
				return;
			}
				
			// 奖励的种类不能多于5种
			if(count($itemIds) > 5){
				$this->assign("error", 6);
				$this->_assign();
				$this->display();
				return;
			}

			//数据做成
			$data = array(
				'event_id' => empty($eventId) ? null : $eventId,
				'event_comment' => $eventComment,
				'platform' => (($platform == '0') ? null : $platform),	//为0为全平台使用
				'remain_used_times' => $remainUsedTimes == 0 ? null : $remainUsedTimes, //为0为可以无数次使用
				'receive_start_time' => $startTime,
				'receive_end_time' => $endTime,
				'create_time' => date("Y-m-d H:i:s"),
				'update_time' => date("Y-m-d H:i:s")
			);

			//物品数据做成
			for ($i=1;$i<=5;$i++) {
				$idString = 'item' . $i . '_id';
				$numString = 'item' . $i . '_num';
				if (isset($itemIds[$i-1]) && isset($itemNums[$i-1])) {
					$idContent = $itemIds[$i-1];
					$numContent = $itemNums[$i-1];
				} else {
					$idContent = null;
					$numContent = null;
				}
				$data = array_merge($data, array(
					$idString => $idContent,
					$numString => $numContent
				));
			} 

			$cdkeys = [];

			for ($i=1;$i<=$cdkeyNumber;$i++) {
				$data = array_merge($data, array(
					'cdkey' => $this->createCdkey()
				));

				D("CdkeyMaster")->addData($data);

				$cdkeys[] = $data['cdkey'];
			}
	
			$csvName = date('YmdGis', time());
			$cdkeyCsv = fopen("./Download/{$csvName}.csv", 'w');
			foreach ($cdkeys as $v) {
				fputcsv($cdkeyCsv, [$v]);
			}
			fputcsv($cdkeyCsv, ['END  ']);
			fclose($cdkeyCsv);
			$httpp = new \Org\Net\Http();
			$httpp->download("./Download/{$csvName}.csv");
		}
		//一系列赋值操作
		$this->_assign();
		$this->display();
	}

	/*
	* 赋值操作
	*/
	private function _assign(){
		$this->assign("platforms", $this->_getPlatforms());
		$this->assign("reward", $this->_getReward());
		$this->assign("reward_name", $this->_rewardNameCsv);	
	}

	/**
	* 得到所有渠道
	*/
	private function _getPlatforms() {
		$platforms = D("PlatformList")->getAllPlatformList();
		
		return $platforms;
	}

	/*
	* 得到所有的奖励
	*/
	private function _getReward(){
		$material1 = array_slice($this->_materialCsv, 0, 150, true);	// 素材奖励1
		$material2 = array_slice($this->_materialCsv, 150, 200, true);	// 素材奖励2
		
		// 碎片奖励
		foreach ($this->_composeCsv as $key => $value){
			$tmp = array_shift($this->_composeCsv);
			$tmp["id"] = "MOP" . $tmp["id"];
			$this->_composeCsv[$tmp["id"]] = $tmp;
		}
		
		// 英雄奖励
		$this->_monsterCsv = array_slice($this->_monsterCsv, 49, 200, true);
		
		// 礼包奖励
		foreach ($this->_presentCsv as $key => $value){
			$tmp = array_shift($this->_presentCsv);
			$this->_presentCsv[$tmp["no"]] = $tmp;
		}
		
		$reward["common"] = $this->_commonCsv;			
		$reward["material1"] = $material1;
		$reward["material2"] = $material2;
		$reward["compose"] = $this->_composeCsv;
		$reward["monster"] = $this->_monsterCsv;
		$reward["present"] = $this->_presentCsv;
		return $reward;
	}

	/**
	* 创建一个CDKEY
	*/
	private function createCdkey() {
        $str = '';

        $_enableCode = self::$_enableCode_mix;
        for ($i = 0; $i < 6; $i++) {
            $str .= $_enableCode[array_rand($_enableCode, 1)];
        }

        $result = D("CdkeyMaster")->searchCdkey($str);

        if (!is_null($result)) {
        	return $this->createCdkey();
        }

        return $str;
	}
}