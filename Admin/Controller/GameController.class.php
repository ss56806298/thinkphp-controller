<?php
	namespace Admin\Controller;
	
	/*
	* GameController 是以下控制器的基控制器，保证操作以下控制器的时候已经登录一个游戏账号
	* MasterController（玩家资料）, MonsterController（英雄资料）, MaterialController（素材资料）, 
	* WeaponController（武器资料）, ArmorController（护甲资料）, HelmetController（头盔资料）, DungeonController（快速通关） 
	*/
	class GameController extends CommonController{
		protected $db;			// 记录当前连接的数据库
		protected $userId;		// 当前账号的 userId
		
		// 所用到的 CSV
		protected $activeCsv;
		protected $armorCsv;
		protected $chainCsv;
		protected $composeCsv;
		protected $eliteCsv;
		protected $helmetCsv;
		protected $materialCsv;
		protected $monsterCsv;
		protected $normalCsv;
		protected $levelCsv;
		protected $passiveCsv;
		protected $vipCsv;
		protected $weaponCsv;
		
		// 所用到的数据表
		protected $table = array(
			"game_master"		=> "game_master",
			"vip_information"	=> "vip_information",
			"user_master"		=> "user_master",
			"user_monster"		=> "user_monster",
			"user_material"		=> "user_material",
			"user_arm"			=> "user_arm",
			"user_guard"		=> "user_guard",
			"dungeon_data"		=> "dungeon_data",
			"user_unit"			=> "user_unit",
		);
		
		// 将变量与 CSV 建立联系
		private $_csv = array(
			"activeCsv"		=> "active_skill.csv",
			"armorCsv"		=> "armor.csv",
			"chainCsv"		=> "chain_skill.csv",
			"composeCsv"	=> "compose_monster.csv",
			"eliteCsv"		=> "elite_dungeon.csv",
			"helmetCsv"		=> "helmet.csv",
			"materialCsv"	=> "material_drop.csv",
			"monsterCsv"	=> "monster.csv",
			"normalCsv"		=> "normal_dungeon.csv",
			"levelCsv"		=> "user_exp_level.csv",
			"passiveCsv"	=> "passive_skill.csv",
			"vipCsv"		=> "vip_bonus.csv",
			"weaponCsv"		=> "weapon.csv",
		);
		
		public function __construct (){
			parent::__construct();
			
			// 如果 session 中不存在 open_id ，则跳转到账号列表
			// open_id 在登录游戏账号的时候生成
			if(!session("open_id")){
				$this->error("请先选择您要操作的游戏账号", U("Account/index"));
				return ;
			}
			
			// 分区的编号，例如 1 区此处的值将为 1
			$serverNum = session("server_num");
			// 渠道名字，例如 shadowpower
			$platform = strtoupper(session("platform"));
			// 组合成配置项的值，完整的配置项参见 /resource/Common/Conf/config.php
			$configName = "DB_" . $serverNum;
			// 记录当前连接的数据库，使用方法见 /resource/ThinkPHP/Library/Think/Model.class.php 中的 db 方法
			$this->db = M()->db($serverNum, $configName);
			
			// 将数据表添加相应的后缀
			foreach ($this->table as &$value){
				$value .= C($configName)["DB_SUFFIX"];
			}
			
			$where = array(
				"open_id"	=> session("open_id")
			);
			$this->userId = $this->db->table($this->table["user_master"])->where($where)->getField("user_id");	// 得到 userId，连缀写法，可参见手册 http://document.thinkphp.cn/manual_3_2.html
			$account = D("Accounts")->getData($this->mgId, session("account"), session("platform"), session("server_num"), session("os"));	// 得到账号
			// 如果账号中没有 user_id 的话，则获取 user_id 并保存
			if(is_null($account["user_id"])){
				D("Accounts")->saveUserId($account, $this->userId);
			}
			
			// 记录日志
			$this->logsInfo = session("account") . ", " . session("platform") . ", " . session("server_num") . ", " . session("os") . ", " . $this->userId;
			
			// 读取 CSV，并放到缓存中
			foreach ($this->_csv as $k => $v){
				$this->$k = RedisController::getArray($v);
				if($this->$k === false){
					RedisController::setArray($v);	
					$this->$k = RedisController::getArray($v);
				}	
			}
		}
		
		/*
		* 得到队列中的武器、护甲、头盔、英雄，队列中存在的不能删除
		*/
		public function getUnitArr (){
			$units = $this->db->table($this->table["user_unit"])->where(array("user_id" => $this->userId))->select();
			
			foreach ($units as $unit){
				$unitArr[] = $unit["arm_item_id"];	
				$unitArr[] = $unit["helmet_item_id"];	
				$unitArr[] = $unit["armor_item_id"];	
				$unitArr[] = $unit["user_monster_id1"];	
				$unitArr[] = $unit["user_monster_id2"];	
				$unitArr[] = $unit["user_monster_id3"];	
				$unitArr[] = $unit["user_monster_id4"];	
			}
			
			return $unitArr;
		}
		
		/*
		* 查找方法，用于页面顶部按 ID 或 名字查找，子控制器中会调用
		*/
		protected function search($data = [], $input = "", $primaryId = "id", $secondId = "name"){
			$search = [];
			
			foreach ($data as $value){
				if(stripos($value[$primaryId], $input) !== false || stripos($value[$secondId], $input) !== false){
					$value["id"] = $value[$primaryId];
					$search[] = $value;
				}
			}
			
			return $search;
		}
	}