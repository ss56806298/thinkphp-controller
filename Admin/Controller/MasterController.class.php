<?php
	namespace Admin\Controller;
	
	/*
	* 账号资料
	*/
	class MasterController extends GameController{
		private $_table;
		private $_vipTable;
		
		public function __construct(){
			parent::__construct();
			
			// 初始化，方便后面使用
			$this->_table = $this->table["game_master"];
			$this->_vipTable = $this->table["vip_information"];	
		}
				
		/*
		* 显示个人资料
		*/
		public function infoAction (){
			$gameMaster = $this->db->table($this->_table)->where(array("user_id" => $this->userId))->find();
			$vipInfo = $this->db->table($this->_vipTable)->where(array("user_id" => $this->userId))->find();
			$vipLevel = !is_null($vipInfo) ? $vipInfo["level"] : 0;
			
			$this->assign("game_master", $gameMaster);
			$this->assign("vip_level", $vipLevel);
			
			$this->display();	
		}
		
		/*
		* 昵称
		*/
		public function nicknameAction ($nickname){
			if(!is_ajax()){
				return ;	
			}
			
			$this->logsInfo .= $this->logsSep . $nickname;
			
			$res = $this->db->table($this->_table)->where(array("user_id" => $this->userId))->save(array("nickname" => $nickname));
			
			if($res !== false){
				$this->logsState = 1;
			}
		}
		
		/*
		* VIP 等级
		*/
		public function vipLevelAction ($vip_level){
			if(!is_ajax()){
				return ;	
			}
			
			$this->logsInfo .= $this->logsSep . $vip_level;
			
			$where = array(
				"user_id" => $this->userId
			);
			
			$data = array(
				"level" => $vip_level,
				"exp" => $this->vipCsv[$vip_level + 1]["accumulate_pay"]
			);
			
			$res = $this->db->table($this->_vipTable)->where($where)->save($data);
			
			if($res !== false){
				$this->logsState = 1;
			}
		}
		
		/*
		* 玩家等级
		*/
		public function levelAction ($level){
			if(!is_ajax()){
				return ;	
			}
			
			$this->logsInfo .= $this->logsSep . $level;
			
			$userExpLevel = $this->levelCsv;
			$levelArr = $userExpLevel[$level];
			
			$gameMaster = $this->db->table($this->_table);
			$gameMaster->level = (int)$levelArr["level"];
			$gameMaster->exp = (int)$levelArr["accumulate_exp"];
			$gameMaster->max_stamina = (int)$levelArr["max_stamina_num"];
			$gameMaster->hp = (int)$levelArr["hp"];
			$gameMaster->attack = (int)$levelArr["attack"];
			$gameMaster->defense = (int)$levelArr["defense"];
			$res = $gameMaster->where(array("user_id" => $this->userId))->save();
			
			if($res !== false){
				$this->logsState = 1;
			}
			
			echo json_encode($levelArr);
		}
		
		/*
		* 体力
		*/
		public function staminaAction ($stamina){
			if(!is_ajax()){
				return ;	
			}
			
			$this->logsInfo .= $this->logsSep . $stamina;
			
			$res = $this->db->table($this->_table)->where(array("user_id" => $this->userId))->save(array("stamina" => $stamina));
			
			if($res !== false){
				$this->logsState = 1;
			}
		}
		
		/*
		* 符石
		*/
		public function stoneFreeAction ($stone_free){
			if(!is_ajax()){
				return ;	
			}
			
			$this->logsInfo .= $this->logsSep . $stone_free;
			
			$res = $this->db->table($this->_table)->where(array("user_id" => $this->userId))->save(array("stone_free" => $stone_free));
			
			if($res !== false){
				$this->logsState = 1;
			}
		}
		
		/*
		* 金币
		*/
		public function coinAction ($coin){
			if(!is_ajax()){
				return ;	
			}
			
			$this->logsInfo .= $this->logsSep . $coin;
			
			$res = $this->db->table($this->_table)->where(array("user_id" => $this->userId))->save(array("coin" => $coin));
			
			if($res !== false){
				$this->logsState = 1;
			}
		}
		
		/*
		* 扫荡券
		*/
		public function skipTicketAction ($skip_ticket){
			if(!is_ajax()){
				return ;	
			}
			
			$this->logsInfo .= $this->logsSep . $skip_ticket;
			
			$res = $this->db->table($this->_table)->where(array("user_id" => $this->userId))->save(array("skip_ticket" => $skip_ticket));
			
			if($res !== false){
				$this->logsState = 1;
			}
		}
		
		/*
		* 天梯点
		*/
		public function ladderPointsAction ($ladder_points){
			if(!is_ajax()){
				return ;	
			}
			
			$this->logsInfo .= $this->logsSep . $ladder_points;
			
			$res = $this->db->table($this->_table)->where(array("user_id" => $this->userId))->save(array("ladder_points" => $ladder_points));
			
			if($res !== false){
				$this->logsState = 1;
			}
		}
		
		/*
		* 公会币
		*/
		public function girudoCoinAction ($girudo_coin){
			if(!is_ajax()){
				return ;	
			}
			
			$this->logsInfo .= $this->logsSep . $girudo_coin;
			
			$res = $this->db->table($this->_table)->where(array("user_id" => $this->userId))->save(array("girudo_coin" => $girudo_coin));
			
			if($res !== false){
				$this->logsState = 1;
			}
		}
	}