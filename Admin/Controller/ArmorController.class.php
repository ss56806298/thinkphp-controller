<?php
	namespace Admin\Controller;
	
	/*
	* 护甲资料
	*/
	class ArmorController extends GameController {
		private $_table;		// 当前操作的数据表
		private $_armors;		// 所有的护甲，包含是否拥有的标志
		private $_userGuards;	// 用户已经拥有的护甲，读取数据库的数据
		
		const GUARD_TYPE = 2;	// 护甲的类型
		
		public function __construct (){
			parent::__construct();
			
			$this->_table = $this->table["user_guard"];
			
			$armors = $this->armorCsv;
			
			$where = array(
				"user_id"	=> $this->userId,
				"guard_type"	=> self::GUARD_TYPE
			);
			$userGuards = $this->db->table($this->_table)->where($where)->select();
			// 处理 armors，方便后续操作
			foreach ($userGuards as $key => $userGuard){
				$guard_id = $userGuard["item_id"];
				$userGuards[$guard_id] = array_shift($userGuards);
				$userGuards[$guard_id]["name"] = $armors[$guard_id]["name"];
				$armors[$guard_id]["isHaving"] = 1;
			}
			
			$this->_armors = $armors;
			$this->_userGuards = $userGuards;
		}
		
		
		/*
		* 所有护甲
		*/
		public function allAction ($page = 0){
			// 分页
			$armors = array_slice($this->_armors, $page * $this->count, $this->count);
			$pageNum = ceil(count($this->_armors) / $this->count);
			
			$this->assign("armors", $armors);
			$this->assign("page", $page);
			$this->assign("pageNum", $pageNum);
			$this->display();
		}
		
		/*
		* 已有护甲
		*/
		public function havingAction ($page = 0){
			// 分页
			$userGuard = array_slice($this->_userGuards, $page * $this->count, $this->count);
			$pageNum = ceil(count($this->_userGuards) / $this->count);
			
			$this->assign("user_guards", $userGuard);
			$this->assign("page", $page);
			$this->assign("pageNum", $pageNum);
			$this->display();
		}
		
		/*
		* 添加护甲
		*/
		public function addAction ($armor_id){
			if(!is_ajax()){
				return ;	
			}
			
			$this->logsInfo .= $this->logsSep . $armor_id;
			
			// 判断源 ID 是否存在
			$isHaving = 0;
			foreach ($this->_userGuards as $key => $userGuard){
				if($userGuard["guard_id"] == $this->_armors[$armor_id]["no"]){
					$isHaving = 1;
					$haveArmor = $key;
					break;
				}
			}
			
			if($isHaving){	// 存在
				$result = array(
					"is_having" => $isHaving,
					"have_armor"	=> $haveArmor
					);
				echo json_encode($result);
			}else{			// 不存在
				$armor = $this->_armors[$armor_id];
				
				$passiveVal = $this->passiveCsv[$armor["passive_skill_id"]]["skill_value"];
				
				$strengthen = round($armor["default_attack"] * 2.25 + $armor["default_defense"] * 4.5 + $armor["miss"] * 0.2 + $passiveVal);
				
				$data["user_id"] = $this->userId;
				$data["guard_id"] = (int)$armor["no"];
				$data["item_id"] = $armor["id"];
				$data["guard_type"] = (int)self::GUARD_TYPE;
				$data["level"] = 1;
				$data["exp"] = 0;
				$data["passive_skill_id"] = $armor["passive_skill_id"];
				$data["passive_skill_level"] = 1;
				$data["attack"] = (int)$armor["default_attack"];
				$data["defense"] = (int)$armor["default_defense"];
				$data["missing"] = (int)$armor["miss"];
				$data["rare"] = (int)$armor["rarity"];
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
		* 删除护甲
		*/
		public function deleteAction ($armor_id){
			if(!is_ajax()){
				return ;	
			}
			
			$this->logsInfo .= $this->logsSep . $armor_id;
			
			// 护甲已经存在队列中，返回 1，表示不能删除
			if(in_array($this->_armors[$armor_id]["no"], $this->getUnitArr())){
				echo 1;
				return;	
			}
			
			$where = array(
				"user_id"	=> $this->userId,
				"item_id"	=> $armor_id
			);
			$res = $this->db->table($this->_table)->where($where)->delete();
			
			if($res !== false){
				$this->logsState = 1;
			}
			echo 0;
		}
		
		/*
		* 查找护甲（所有护甲页面）
		*/
		public function searchAllAction ($input = ""){
			if(!is_ajax()){
				return ;	
			}
			
			echo json_encode($this->search($this->_armors, $input));
		}
		
		/*
		* 查找护甲（已有护甲页面）
		*/
		public function searchHavingAction ($input = ""){
			if(!is_ajax()){
				return ;	
			}
			
			echo json_encode($this->search($this->_userGuards, $input, "item_id"));	
		}
		
		/*
		* 选择查找结果（所有护甲页面）
		*/
		public function completeAllAction ($id = ""){
			if(!is_ajax()){
				return ;	
			}
			
			$data = $this->_armors[$id];
			
			$str = "<ul>
				<li>编号</li> 
				<li>ID</li>
				<li>名字</li>
				<li>攻击力</li>
				<li>防御力</li>
				<li>操作</li>
				<li>状态</li>
			</ul>
			<ul>
				<li>1</li>
				<li>{$data['id']}</li>
				<li>{$data['name']}</li>
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
		* 选择查找结果（已有护甲页面）
		*/
		public function completeHavingAction ($id = ""){
			if(!is_ajax()){
				return ;	
			}
			
			$data = $this->_userGuards[$id];
			
			$str = "<ul>
				<li>编号</li> 
				<li>ID</li>
				<li>名字</li>
				<li>等级</li>
				<li>经验值</li>
				<li>攻击力</li>
				<li>防御力</li>
				<li>操作</li>
			</ul>
			<ul>
				<li>1</li>
				<li>{$data['item_id']}</li>
				<li>{$data['name']}</li>
				<li>{$data['level']}</li>
				<li>{$data['exp']}</li>
				<li>{$data['attack']}</li>
				<li>{$data['defense']}</li>
				<li><a href='javascript:;'>删除</a></li>
			</ul>";
					
			echo $str;	
		}
	}