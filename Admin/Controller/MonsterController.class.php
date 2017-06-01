<?php
	namespace Admin\Controller;
	
	/*
	* 英雄资料
	*/
	class MonsterController extends GameController {
		private $_table;		// 当前用到的数据表
		private $_monsters;		// 所有用到的英雄，包含是否已经拥有的标志
		private $_composes;		// 所有用到的英雄
		private $_userMonsters;	// 用户拥有的英雄，读取数据库中的数据
		
		public function __construct (){
			parent::__construct();
			
			$this->_table = $this->table["user_monster"];
			
			$composes = $this->composeCsv;
			$monsters = $this->monsterCsv;
			
			// 得到所有用到的英雄的 ID
			$nowMonsterIds = [];
			foreach ($composes as &$compose){
				$compose["monsters"] = explode("|", $compose["monster"]);
				$nowMonsterIds = array_merge($nowMonsterIds, $compose["monsters"]);
			}
			
			// 删除 monsters 中未用到的英雄
			$nowMonsterIds = array_flip($nowMonsterIds);
			foreach ($monsters as $key => $monster){
				if(!isset($nowMonsterIds[$key])){
					unset($monsters[$key]);
				}
			}
			
			// 在 monsters 中添加是否拥有的标志
			$userMonsters = $this->db->table($this->_table)->where(array("user_id" => $this->userId))->select();
			foreach ($userMonsters as $key => $userMonster){
				$monster_id = $userMonster["user_monster"];
				$userMonsters[$monster_id] = array_shift($userMonsters);
				$userMonsters[$monster_id]["name"] = $monsters[$monster_id]["name"];
				$monsters[$monster_id]["isHaving"]	= 1;
			}
			
			$this->_userMonsters = $userMonsters;
			$this->_monsters = $monsters;
			$this->_composes = $composes;
		}
		
		
		/*
		* 所有英雄
		*/
		public function allAction ($page = 0){
			// 将英雄分页
			$monsters = array_slice($this->_monsters, $page * $this->count, $this->count);
			$pageNum = ceil(count($this->_monsters) / $this->count);
			
			$this->assign("monsters", $monsters);
			$this->assign("page", $page);
			$this->assign("pageNum", $pageNum);
			$this->display();
		}
		
		/*
		* 已有英雄
		*/
		public function havingAction ($page = 0){
			// 分页
			$monsters = array_slice($this->_userMonsters, $page * $this->count, $this->count);
			$pageNum = ceil(count($this->_userMonsters) / $this->count);
			
			$this->assign("user_monsters", $monsters);
			$this->assign("page", $page);
			$this->assign("pageNum", $pageNum);
			$this->display();
		}
		
		/*
		* 添加英雄
		*/
		public function addAction ($monster_id){
			if(!is_ajax()){
				return ;	
			}
			
			$this->logsInfo .= $this->logsSep . $monster_id;
			
			// 得到源 ID
			foreach ($this->_composes as $key => $compose){
				if(in_array($monster_id, $compose["monsters"])){
					$id = $key;
					break;
				}
			}
			
			// 判断源 ID 是否存在
			$isHaving = 0;
			foreach ($this->_userMonsters as $key => $userMonster){
				if($userMonster["monster_id"] == $id){
					$isHaving = 1;
					$haveMonster = $key;
					break;
				}
			}
			
			if($isHaving){	// 存在
				$result = array(
					"is_having" => $isHaving,
					"have_monster"	=> $haveMonster
					);
				echo json_encode($result);
			}else{			// 不存在
				$monster = $this->_monsters[$monster_id];
				
				$activeVal = $this->activeCsv[$monster["active_skill_id"]]["skill_value"];
				$chainVal = $this->chainCsv[$monster["chain_skill_id"]]["skill_value"];
				
				$strengthen = (int)round($monster["default_hp"] * 1 + $monster["default_attack"] * 2.25 + $monster["default_defense"] * 4.5 + $monster["critical"] * 0.2 + $monster["missing"] * 0.2 + $activeVal + $chainVal);
				
				$data["user_id"] = $this->userId;
				$data["monster_id"] = $id;
				$data["user_monster"] = $monster["id"];
				$data["state"] = 1;
				$data["attribute"] = (int)$monster["attribute"];
				$data["level"] = 1;
				$data["exp"] = 0;
				$data["hp"] = (int)$monster["default_hp"];
				$data["attack"] = (int)$monster["default_attack"];
				$data["defense"] = (int)$monster["default_defense"];
				$data["critical"] = (int)$monster["critical"];
				$data["missing"] = (int)$monster["missing"];
				$data["rare"] = (int)$monster["rarity"];
				$data["active_skill_id"] = $monster["active_skill_id"];
				$data["active_skill_level"] = 1;
				$data["chain_skill_id"] = $monster["chain_skill_id"];
				$data["chain_skill_level"] = 1;
				$data["grade_level"] = 0;
				$data["equipment1"] = 0;
				$data["equipment2"] = 0;
				$data["equipment3"] = 0;
				$data["equipment4"] = 0;
				$data["equipment5"] = 0;
				$data["equipment6"] = 0;
				$data["equipment_attack"] = 0;
				$data["equipment_hp"] = 0;
				$data["equipment_defense"] = 0;
				$data["equipment_critical"] = 0;
				$data["equipment_missing"] = 0;
				$data["equipment_ap"] = 0;
				$data["strengthen_prediction"] = $strengthen;
				$data["update_time"] = date("Y-m-d H:i:s", time());
				$data["create_time"] = date("Y-m-d H:i:s", time());
				
				$res = $this->db->table($this->_table)->add($data);
				
				if($res !== false){
					$this->logsState = 1;	
				}
				
				$result = array("is_having" => $isHaving);
				echo json_encode($result);
			}
		}
		
		/*
		* 删除英雄
		*/
		public function deleteAction ($monster_id){
			if(!is_ajax()){
				return ;	
			}
			
			$this->logsInfo .= $this->logsSep . $monster_id;
			
			// 得到源 ID
			foreach ($this->_composes as $key => $compose){
				if(in_array($monster_id, $compose["monsters"])){
					$id = $key;
					break;
				}
			}
			
			// 源 ID 在队列中，返回 1，表示不能删除
			if(in_array($id, $this->getUnitArr())){
				echo 1;
				return;
			}
			
			// 删除指定的英雄
			$where = array(
				"user_id"	=> $this->userId,
				"user_monster"	=> $monster_id
			);
			$res = $this->db->table($this->_table)->where($where)->delete();
			
			if($res !== false){
				$this->logsState = 1;	
			}
			
			echo 0;
		}
		
		/*
		* 在所有英雄中查找
		*/
		public function searchAllAction ($input = ""){
			if(!is_ajax()){
				return ;	
			}
			
			echo json_encode($this->search($this->_monsters, $input));
		}
		
		/*
		* 在已有英雄中查找
		*/
		public function searchHavingAction ($input = ""){
			if(!is_ajax()){
				return ;	
			}
			
			echo json_encode($this->search($this->_userMonsters, $input, "user_monster"));
		}
		
		/*
		* 选择查找结果（所有英雄页面）
		*/
		public function completeAllAction ($id = ""){
			if(!is_ajax()){
				return ;	
			}
			
			$data = $this->_monsters[$id];
			
			$str = "<ul>
				<li>编号</li> 
				<li>ID</li>
				<li>名字</li>
				<li>生命值</li>
				<li>攻击力</li>
				<li>防御力</li>
				<li>操作</li>
				<li>状态</li>
			</ul>
			<ul>
				<li>1</li>
				<li>{$data['id']}</li>
				<li>{$data['name']}</li>
				<li>{$data['default_hp']}</li>
				<li>{$data['default_attack']}</li>
				<li>{$data['default_defense']}</li>";
				
			if($data["isHaving"] == 1){
				$str .= 
					"<li><a href='javascript:;'>删除</a></li>
					<li>已拥有</li>
				</ul>";
			}else{
				$str .= 
					"<li><a href='javascript:;'>添加</a></li>
					<li></li>
				</ul>";
			}
					
			echo $str;	
		}
		
		/*
		* 选择查找结果（已有英雄页面）
		*/
		public function completeHavingAction ($id = ""){
			if(!is_ajax()){
				return ;	
			}
			
			$data = $this->_userMonsters[$id];
			
			$str = "<ul>
				<li>编号</li> 
				<li>ID</li>
				<li>名字</li>
				<li>等级</li>
				<li>经验值</li>
				<li>生命值</li>
				<li>攻击力</li>
				<li>防御力</li>
				<li>操作</li>
			</ul>
			<ul>
				<li>1</li>
				<li>{$data['user_monster']}</li>
				<li>{$data['name']}</li>
				<li>{$data['level']}</li>
				<li>{$data['exp']}</li>
				<li>{$data['hp']}</li>
				<li>{$data['attack']}</li>
				<li>{$data['defense']}</li>
				<li><a href='javascript:;'>删除</a></li>
				</ul>";

			echo $str;	
		}
	}