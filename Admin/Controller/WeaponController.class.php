<?php
	namespace Admin\Controller;
	
	/*
	* 武器资料
	*/
	class WeaponController extends GameController {
		private $_table;		// 当前操作的数据表
		private $_weapons;		// 所有的武器，包含是否拥有的标志
		private $_userArms;		// 用户已经拥有的武器，读取数据库中数据
		
		public function __construct (){
			parent::__construct();
			
			$this->_table = $this->table["user_arm"];
			
			$weapons = $this->weaponCsv;
			
			$userArms = $this->db->table($this->_table)->where(array("user_id" => $this->userId))->select();
			// 处理 weapons，方便后续操作
			foreach ($userArms as $key => $userArm){
				$arm_id = $userArm["item_id"];
				$userArms[$arm_id] = array_shift($userArms);
				$userArms[$arm_id]["name"] = $weapons[$arm_id]["name"];
				$weapons[$arm_id]["isHaving"] = 1;
			}
			
			$this->_weapons = $weapons;
			$this->_userArms = $userArms;
		}
		
		
		/*
		* 所有武器
		*/
		public function allAction ($page = 0){
			// 分页
			$weapons = array_slice($this->_weapons, $page * $this->count, $this->count);
			$pageNum = ceil(count($this->_weapons) / $this->count);
			
			$this->assign("weapons", $weapons);
			$this->assign("page", $page);
			$this->assign("pageNum", $pageNum);
			$this->display();
		}
		
		/*
		* 已有武器
		*/
		public function havingAction ($page = 0){
			// 分页
			$userArm = array_slice($this->_userArms, $page * $this->count, $this->count);
			$pageNum = ceil(count($this->_userArms) / $this->count);
			
			$this->assign("user_arms", $userArm);
			$this->assign("page", $page);
			$this->assign("pageNum", $pageNum);
			$this->display();
		}
		
		/*
		* 添加武器
		*/
		public function addAction ($weapon_id){
			if(!is_ajax()){
				return ;	
			}
			
			$this->logsInfo .= $this->logsSep . $weapon_id;
			
			// 判断源 ID 是否存在
			$isHaving = 0;
			foreach ($this->_userArms as $key => $userArm){
				if($userArm["weapon_id"] == $this->_weapons[$weapon_id]["no"]){
					$isHaving = 1;
					$haveArm = $key;
					break;
				}
			}
			
			if($isHaving){	// 存在
				$result = array(
					"is_having" => $isHaving,
					"have_arm"	=> $haveArm
					);
				echo json_encode($result);
			}else{			// 不存在
				$weapon = $this->_weapons[$weapon_id];
				
				$activeVal = $this->activeCsv[$weapon["active_skill_id"]]["skill_value"];
				$chainVal = $this->chainCsv[$weapon["chain_skill_id"]]["skill_value"];
				
				$strengthen = round($weapon["default_attack"] * 2.25 + $weapon["default_defense"] * 4.5 + $weapon["critical"] * 0.2 + $activeVal + $chainVal);
				
				$data["user_id"] = $this->userId;
				$data["weapon_id"] = (int)$weapon["no"];
				$data["item_id"] = $weapon["id"];
				$data["arm_type"] = (int)$weapon["weapon_family"];
				$data["level"] = 1;
				$data["exp"] = 0;
				$data["active_skill_id"] = $weapon["active_skill_id"];
				$data["active_skill_level"] = 1;
				$data["chain_skill_id"] = $weapon["chain_skill_id"];
				$data["chain_skill_level"] = 1;
				$data["attack"] = (int)$weapon["default_attack"];
				$data["defense"] = (int)$weapon["default_defense"];
				$data["critical"] = (int)$weapon["critical"];
				$data["rare"] = (int)$weapon["rarity"];
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
		* 删除武器
		*/
		public function deleteAction ($weapon_id){
			if(!is_ajax()){
				return ;	
			}
			
			$this->logsInfo .= $this->logsSep . $weapon_id;
			
			// 该武器已经存在于队列中，返回 1，表示不能删除
			if(in_array($this->_weapons[$weapon_id]["no"], $this->getUnitArr())){
				echo 1;
				return;	
			}
			
			$where = array(
				"user_id"	=> $this->userId,
				"item_id"	=> $weapon_id
			);
			$res = $this->db->table($this->_table)->where($where)->delete();
			
			if($res !== false){
				$this->logsState = 1;
			}
			
			return 0;
		}
		
		/*
		* 查找武器（所有武器页面）
		*/
		public function searchAllAction ($input = ""){
			if(!is_ajax()){
				return ;	
			}
			
			echo json_encode($this->search($this->_weapons, $input));
		}
		
		/*
		* 查找武器（已有武器页面）
		*/
		public function searchHavingAction ($input = ""){
			if(!is_ajax()){
				return ;	
			}
			
			echo json_encode($this->search($this->_userArms, $input, "item_id"));	
		}
		
		/*
		* 选择查找结果（所有武器页面）
		*/
		public function completeAllAction ($id = ""){
			if(!is_ajax()){
				return ;	
			}
			
			$data = $this->_weapons[$id];
			
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
		* 选择查找结果（已有武器页面）
		*/
		public function completeHavingAction ($id = ""){
			if(!is_ajax()){
				return ;	
			}
			
			$data = $this->_userArms[$id];
			
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