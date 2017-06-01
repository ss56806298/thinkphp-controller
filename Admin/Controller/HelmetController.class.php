<?php
	namespace Admin\Controller;
	
	/*
	* 头盔资料
	*/
	class HelmetController extends GameController {
		private $_table;		// 当前操作的数据表
		private $_helmets;		// 所有的头盔，包含是否拥有的标志
		private $_userGuards;	// 用户已经拥有的头盔，读取数据库数据
		
		const GUARD_TYPE = 1;	// 头盔类型
		
		public function __construct (){
			parent::__construct();
			
			$this->_table = $this->table["user_guard"];
			
			$helmets = $this->helmetCsv;
			
			$where = array(
				"user_id"	=> $this->userId,
				"guard_type"	=> self::GUARD_TYPE
			);
			$userGuards = $this->db->table($this->_table)->where($where)->select();
			// 处理 helmets，方便后续操作
			foreach ($userGuards as $key => $userGuard){
				$guard_id = $userGuard["item_id"];
				$userGuards[$guard_id] = array_shift($userGuards);
				$userGuards[$guard_id]["name"] = $helmets[$guard_id]["name"];
				$helmets[$guard_id]["isHaving"] = 1;
			}
			
			$this->_userGuards = $userGuards;
			$this->_helmets = $helmets;
		}
		
		
		/*
		* 所有头盔
		*/
		public function allAction ($page = 0){
			// 分页
			$helmets = array_slice($this->_helmets, $page * $this->count, $this->count);
			$pageNum = ceil(count($this->_helmets) / $this->count);
			
			$this->assign("helmets", $helmets);
			$this->assign("page", $page);
			$this->assign("pageNum", $pageNum);
			$this->display();
		}
		
		/*
		* 已有头盔
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
		* 添加头盔
		*/
		public function addAction ($helmet_id){
			if(!is_ajax()){
				return ;	
			}
			
			$this->logsInfo .= $this->logsSep . $helmet_id;
			
			// 判断源 ID 是否存在
			$isHaving = 0;
			foreach ($this->_userGuards as $key => $userGuard){
				if($userGuard["guard_id"] == $this->_helmets[$helmet_id]["no"]){
					$isHaving = 1;
					$haveHelmet = $key;
					break;
				}
			}
			
			if($isHaving){	// 存在
				$result = array(
					"is_having" => $isHaving,
					"have_helmet"	=> $haveHelmet
					);
				echo json_encode($result);
			}else{			// 不存在
				$helmet = $this->_helmets[$helmet_id];
				
				$passiveVal = $this->passiveCsv[$helmet["passive_skill_id"]]["skill_value"];
				
				$strengthen = round($helmet["default_attack"] * 2.25 + $helmet["default_defense"] * 4.5 + $helmet["miss"] * 0.2 + $passiveVal);
				
				$data["user_id"] = $this->userId;
				$data["guard_id"] = (int)$helmet["no"];
				$data["item_id"] = $helmet["id"];
				$data["guard_type"] = (int)self::GUARD_TYPE;
				$data["level"] = 1;
				$data["exp"] = 0;
				$data["passive_skill_id"] = $helmet["passive_skill_id"];
				$data["passive_skill_level"] = 1;
				$data["attack"] = (int)$helmet["default_attack"];
				$data["defense"] = (int)$helmet["default_defense"];
				$data["missing"] = (int)$helmet["miss"];
				$data["rare"] = (int)$helmet["rarity"];
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
		* 删除头盔
		*/
		public function deleteAction ($helmet_id){
			if(!is_ajax()){
				return ;	
			}
			
			$this->logsInfo .= $this->logsSep . $helmet_id;
			
			// 头盔已经存在于队列中，则返回 1，表示不能删除
			if(in_array($this->_helmets[$helmet_id]["no"], $this->getUnitArr())){
				echo 1;
				return;	
			}
			
			$where = array(
				"user_id"	=> $this->userId,
				"item_id"	=> $helmet_id
			);
			$res = $this->db->table($this->_table)->where($where)->delete();
			
			if($res !== false){
				$this->logsState = 1;
			}
			
			echo 0;
		}
		
		/*
		* 查找结果（所有头盔页面）
		*/
		public function searchAllAction ($input = ""){
			if(!is_ajax()){
				return ;	
			}
			
			echo json_encode($this->search($this->_helmets, $input));		
		}
		
		/*
		* 查找结果（已有头盔页面）
		*/
		public function searchHavingAction ($input = ""){
			if(!is_ajax()){
				return ;	
			}
			
			echo json_encode($this->search($this->_userGuards, $input, "item_id"));		
		}
		
		/*
		* 选择查找结果（所有头盔页面）
		*/
		public function completeAllAction ($id = ""){
			if(!is_ajax()){
				return ;	
			}
			
			$data = $this->_helmets[$id];
			
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
		* 选择查找结果（已有头盔页面）
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