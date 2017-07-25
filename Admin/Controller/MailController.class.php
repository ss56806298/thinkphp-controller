<?php
	namespace Admin\Controller;
	
	/*
	* 发送邮件
	*/
	class MailController extends CommonController{
		private $_titleCsv;		// 标题
		private $_messageCsv;	// 内容
		private $_senderCsv;	// 署名
		private $_commonCsv;	// 普通奖励
		private $_materialCsv;	// 素材奖励
		private $_composeCsv;	// 碎片奖励
		private $_monsterCsv;	// 英雄奖励
		private $_presentCsv;	// 礼包奖励
		private $_rewardNameCsv;// 奖励的名字
		
		private $_db;			// 记录当前操作的数据库
		
		// 当前操作用到的数据表
		private $_table = array(
			"user_master"		=> "user_master",
			"user_mail_list"	=> "user_mail_list",
			"mail_master"		=> "mail_master"
		);
		
		// 当前操作用到的 CSV
		private $_csv = array(
			"_titleCsv"			=> "title.csv",
			"_messageCsv"		=> "message.csv",
			"_senderCsv"		=> "sender.csv",
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
			
			// 将所有的内容实体化
			foreach ($this->_messageCsv as $key => &$value){
				$value["content"] = htmlspecialchars($value["content"]);
			}
		}
		
		/*
		* 个人邮件
		*/
		// public function indexAction (){
		// 	if(IS_POST){
		// 		$accounts = trim(I("accounts"));	// 账号
		// 		$platform = trim(I("platform"));	// 渠道
		// 		$server = (int)trim(I("server"));	// 分区
		// 		$os = trim(I("os"));				// 平台
		// 		$title = trim(I("title"));			// 标题
		// 		$message = trim(I("message"));		// 内容
		// 		$sender = trim(I("sender"));		// 署名
		// 		$expiry = trim(I("expiry"));		// 有效期
		// 		$itemIds = I("item_ids");			// 奖励的 IDs
		// 		$itemNums = I("item_nums");			// 奖励的数量
				
		// 		$this->logsInfo = $accounts . $this->logsSep . $platform . ", " . $server . ", " . $os . ", " . $title . ", " . $message . ", " . $sender . ", " . $expiry . $this->logsSep . implode(", ", $itemIds) . $this->logsSep . implode(", ", $itemNums);
				
		// 		// 账号为空，给出错误提示
		// 		if($accounts == ""){
		// 			$this->assign("error", 1);
		// 			$this->_assign();
		// 			$this->display();
		// 			return;
		// 		}
				
		// 		// 没有选择渠道，给出错误提示
		// 		if($platform === "0"){
		// 			$this->assign("error", 2);
		// 			$this->_assign();
		// 			$this->display();
		// 			return;
		// 		}
				
		// 		// 没有选择分区，给出错误提示
		// 		if($server === 0){
		// 			$this->assign("error", 3);
		// 			$this->_assign();
		// 			$this->display();
		// 			return;
		// 		}
				
		// 		// 标题为空，给出错误提示
		// 		if($title == ""){
		// 			$this->assign("error", 4);
		// 			$this->_assign();
		// 			$this->display();
		// 			return;
		// 		}
				
		// 		// 内容为空，给出错误提示
		// 		if($message == ""){
		// 			$this->assign("error", 5);
		// 			$this->_assign();
		// 			$this->display();
		// 			return;
		// 		}
				
		// 		// 署名为空，给出错误提示
		// 		if($sender == ""){
		// 			$this->assign("error", 6);
		// 			$this->_assign();
		// 			$this->display();
		// 			return;
		// 		}
				
		// 		// 有效期为空，给出错误提示
		// 		if($expiry == ""){
		// 			$this->assign("error", 7);
		// 			$this->_assign();
		// 			$this->display();
		// 			return;
		// 		}
				
		// 		// 奖励为空，给出错误提示
		// 		if($itemIds == ""){
		// 			$this->assign("error", 8);
		// 			$this->_assign();
		// 			$this->display();
		// 			return;
		// 		}
				
		// 		// 奖励种类超过 4 中，给出错误提示
		// 		if(count($itemIds) > 4){
		// 			$this->assign("error", 9);
		// 			$this->_assign();
		// 			$this->display();
		// 			return;
		// 		}

		// 		// 数据库相关准备工作
		// 		$conf = "DB_" . strtoupper($platform) . "_" . $server;
		// 		$this->_db = M()->db($server, $conf);
		// 		foreach ($this->_table as $k => &$v){
		// 			$v .= C($conf)["DB_SUFFIX"];
		// 		}
				
		// 		// 得到账号数组
		// 		$accountsArr = explode(",", $accounts);
		// 		array_pop($accountsArr);
				
		// 		$result = [];	// 失败的账号
		// 		foreach ($accountsArr as $key => $value){
		// 			$account = trim($value);
		// 			$accountId = D("UserAccountManager")->getIdByAccountAndPlatform($account, $platform);
		// 			list($openId, $osRes, $flag) = D("UserRegisterInfo")->getOpenId($accountId, $platform, $server, $os);
					
		// 			$result[] = array(
		// 				"account"	=> $account,
		// 				"os"		=> $osRes,
		// 				"flag"		=> $flag
		// 			);
					
		// 			if(is_null($openId)){
		// 				continue;	
		// 			}
					
		// 			$where = array(
		// 				"open_id"	=> $openId
		// 			);
		// 			$userId = $this->_db->table($this->_table["user_master"])->where($where)->getField("user_id");
					
		// 			$where = array(
		// 				"user_id"	=> $userId
		// 			);
		// 			$userMailId = $this->_db->table($this->_table["user_mail_list"])->where($where)->count();
					
		// 			list($title_id, $title_text, $message_id, $message_text, $sender_id, $item1_id, $item1_num, $item2_id, $item2_num, $item3_id, $item3_num, $item4_id, $item4_num) = $this->_operData($title, $message, $sender, $itemIds, $itemNums);
					
		// 			$data = array(
		// 				"user_id"			=> (int)$userId,
		// 				"user_mail_id"		=> (int)$userMailId,
		// 				"state"				=> 0,
		// 				"title_id"			=> $title_id,
		// 				"title_text"		=> $title_text,
		// 				"message_id"		=> $message_id,
		// 				"message_text"		=> $message_text,
		// 				"message_replace"	=> null,
		// 				"sender_id"			=> (int)$sender_id,
		// 				"item1_id"			=> $item1_id,
		// 				"item1_num"			=> $item1_num,
		// 				"item2_id"			=> $item2_id,
		// 				"item2_num"			=> $item2_num,
		// 				"item3_id"			=> $item3_id,
		// 				"item3_num"			=> $item3_num,
		// 				"item4_id"			=> $item4_id,
		// 				"item4_num"			=> $item4_num,
		// 				"expiry_date"		=> (int)$expiry,
		// 				"create_time"		=> date("Y-m-d H:i:s"),
		// 				"update_time"		=> date("Y-m-d H:i:s"),
		// 			);
					
		// 			$this->_db->table($this->_table["user_mail_list"])->add($data);
		// 		}
				
		// 		$this->logsState = 1;
				
		// 		$this->assign("result", $result);
		// 		$this->assign("platform", $platform);
		// 		$this->assign("server", $server);
		// 	}

		// 	$this->_assign();
		// 	$this->display();	
		// }
		
		/*
		* 群发邮件
		*/
		public function indexAction (){
			if(IS_POST){
				// $platform = trim(I("platform"));	// 渠道
				$server = (int)trim(I("server"));	// 分区
				$os = (int)trim(I("os"));			// 平台
				$title = trim(I("title"));			// 标题
				$message = trim(I("message"));		// 内容
				$sender = trim(I("sender"));		// 署名
				$start = trim(I("start"));			// 开始时间
				$end = trim(I("end"));				// 结束时间
				$limit = I('limit');				// 限制时间
				$itemIds = I("item_ids");			// 奖励的 IDs
				$itemNums = I("item_nums");			// 奖励的数量
				
				$this->logsInfo = $platform . ", " . $server . ", " . $os . ", " . $title . ", " . $message . ", " . $sender . ", " . $start . ", " . $end . $this->logsSep . implode(", ", $itemIds) . $this->logsSep . implode(", ", $itemNums);
		
				// 未选择渠道，给出错误提示
				// if($platform === "0"){
				// 	$this->assign("error", 1);
				// 	$this->_assign();
				// 	$this->display();
				// 	return;
				// }
				
		
				// 未选择分区，给出错误提示
				if($server === 0){
					$this->assign("error", 2);
					$this->_assign();
					$this->display();
					return;
				}
				
				// 标题为空，给出错误提示
				if($title == ""){
					$this->assign("error", 3);
					$this->_assign();
					$this->display();
					return;
				}
				
				// 内容为空，给出错误提示
				if($message == ""){
					$this->assign("error", 4);
					$this->_assign();
					$this->display();
					return;
				}
				
				// 署名为空，给出错误提示
				if($sender == ""){
					$this->assign("error", 5);
					$this->_assign();
					$this->display();
					return;
				}
				
				// 开始时间为空，给出错误提示
				if($start == ""){
					$this->assign("error", 6);
					$this->_assign();
					$this->display();
					return;
				}
				
				// 结束时间为空，给出错误提示
				if($end == ""){
					$this->assign("error", 7);
					$this->_assign();
					$this->display();
					return;
				}
				
				// 开始时间大于等于结束时间，给出错误提示
				if($start >= $end){
					$this->assign("error", 8);
					$this->_assign();
					$this->display();
					return;
				}
				
				// 奖励为空，给出错误提示
				if($itemIds == ""){
					$this->assign("error", 9);
					$this->_assign();
					$this->display();
					return;
				}
				
				// 奖励的种类大于 4 种，给出错误提示
				if(count($itemIds) > 4){
					$this->assign("error", 10);
					$this->_assign();
					$this->display();
					return;
				}
		
				// 数据库相关准备工作
				$conf = "DB_" . $server . "_GDB";
				$this->_db = M()->db($server, $conf);
				
				$id = $this->_db->table($this->_table["mail_master"])->max("id") + 1;
				
				list($title_id, $title_text, $message_id, $message_text, $sender_id, $item1_id, $item1_num, $item2_id, $item2_num, $item3_id, $item3_num, $item4_id, $item4_num) = $this->_operData($title, $message, $sender, $itemIds, $itemNums);
				
				$data = array(
					"id"				=> $id,
					"state"				=> $os,
					"title_id"			=> $title_id,
					"title_text"		=> $title_text,
					"message_id"		=> $message_id,
					"message_text"		=> $message_text,
					"sender_id"			=> (int)$sender_id,
					"item1_id"			=> $item1_id,
					"item1_num"			=> $item1_num,
					"item2_id"			=> $item2_id,
					"item2_num"			=> $item2_num,
					"item3_id"			=> $item3_id,
					"item3_num"			=> $item3_num,
					"item4_id"			=> $item4_id,
					"item4_num"			=> $item4_num,
					"receive_limit_time"=> empty($limit) ? null : date("Y-m-d H:i:s", strtotime($limit)),
					"receipt_start_time"=> date("Y-m-d H:i:s", strtotime($start)),
					"receipt_end_time"	=> date("Y-m-d H:i:s", strtotime($end)),
					"create_time"		=> date("Y-m-d H:i:s"),
					"update_time"		=> date("Y-m-d H:i:s"),
				);
				
				$res = $this->_db->table($this->_table["mail_master"])->add($data);
				
				$result = 2;
				if($res !== false){
					$this->logsState = 1;
					$result = 1;	
				}
				
				$osRes = ($os == 1) ? "Android & ios" : (($os == 2) ? "Android" : "ios");
				
				$this->assign("result", $result);
				$this->assign("platform", $platform);
				$this->assign("server", $server);
				$this->assign("os", $osRes);
			}
			
			$this->_assign();
			$this->display();	
		}
		
		/*
		* 查找账号，返回查找结果
		*/
		public function searchAction ($input = ""){
			if(!is_ajax()){
				return ;	
			}
			
			$accounts = D("UserAccountManager")->getDatas();
			foreach ($accounts as $key => $value){
				if(stripos($value, $input) === false){
					unset($accounts[$key]);	
				}
			}
			
			echo json_encode($accounts);
		}
		
		/*
		* 得到分区，返回给页面
		*/
		public function getServersAction ($platform = ""){
			if(!is_ajax()){
				return ;	
			}
			
			$servers = [];
			
			foreach ($this->platform[$platform] as $key => $value){
				$servers[] = $key;	
			}	
			
			echo json_encode($servers);
		}
		
		/*
		* 赋值操作
		*/
		private function _assign(){
			// $this->assign("platforms", $this->_getPlatforms());
			$this->assign('servers', $this->_getServers());
			$this->assign("titles", $this->_titleCsv);
			$this->assign("messages", $this->_messageCsv);
			$this->assign("senders", $this->_senderCsv);
			$this->assign("reward", $this->_getReward());
			$this->assign("reward_name", $this->_rewardNameCsv);	
		}

		/*
		* 得到所有服务器数据
		*/
		private function _getServers() {
			$platforms = D("ServerList")->getAllServerList();
			
			return $platforms;
		}

		/*
		* 得到分区
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
		
		/*
		* 处理数据，参数是从页面收集的数据，返回值是数据库需要的数据
		*/
		private function _operData($title = "", $message = "", $sender = "", $itemIds = [], $itemNums = []){
			// 标题
			$title_id = null;
			$title_text = $title;
			foreach ($this->_titleCsv as $kk => $vv){
				if(strcmp($title, $vv["content"]) === 0){
					$title_id = $vv["title_id"];
					$title_text = null;	
					break;
				}	
			}
			
			// 内容
			$message_id = null;
			$message_text = $message;
			foreach ($this->_messageCsv as $kk => $vv){
				if(strcmp($message, $vv["content"]) === 0){
					$message_id = $vv["message_id"];
					$message_text = null;	
					break;
				}	
			}
			
			// 署名
			$sender_id = 1;
			foreach ($this->_senderCsv as $kk => $vv){
				if(strcmp($sender, $vv["content"]) === 0){
					$sender_id = $vv["sender_id"];
					break;
				}	
			}
			
			// 得到奖励的 ID 和 数量
			for($i = 1; $i <= 4; $i++){
				$id = "item" . $i . "_id";
				$num = "item" . $i . "_num";
				$$id = isset($itemIds[$i - 1]) ? $itemIds[$i - 1] : null;
				$$num = isset($itemNums[$i - 1]) ? $itemNums[$i - 1] : null;	
			}	
			
			return [$title_id, $title_text, $message_id, $message_text, $sender_id, $item1_id, $item1_num, $item2_id, $item2_num, $item3_id, $item3_num, $item4_id, $item4_num];
		}
	}