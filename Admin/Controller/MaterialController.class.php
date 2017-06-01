<?php
	namespace Admin\Controller;
	
	class MaterialController extends GameController {
		private $_table;			// 当前操作的数据表
		private $_materialDrops;	// "material_drop.csv" 中的数据，用来得到普通素材
		private $_composes;			// "compose_monster.csv" 中的数据，用来得到英雄碎片
		private $_userMaterials;	// 用户已拥有的素材数据，读取数据库中的数据
		private $_materials;		// 所有的素材
		private $_type = array(		// 记录素材的类型和前缀
			array(
				"type_num"	=> 1,
				"prefix"	=> "MTR",
				"type_name"	=> "材料"
			),
			array(
				"type_num"	=> 2,
				"prefix"	=> "NO",
				"type_name"	=> "英雄装备"
			),
			array(
				"type_num"	=> 3,
				"prefix"	=> "PUM",
				"type_name"	=> "南瓜"
			),
			array(
				"type_num"	=> 4,
				"prefix"	=> "STS",
				"type_name"	=> "强化石"
			),
			array(
				"type_num"	=> 5,
				"prefix"	=> "MOP",
				"type_name"	=> "碎片"
			)
		);
		
		public function __construct(){
			parent::__construct();
			
			$this->_table = $this->table["user_material"];
			
			$this->_materialDrops = $this->materialCsv;
			$this->_composes = $this->composeCsv;
			$this->_userMaterials = $this->db->table($this->_table)->where(array("user_id" => $this->userId))->select();
			
			// 处理数据库中的数据，用 ID 作为键名
			foreach ($this->_userMaterials as $userMaterial){
				$materialId = $userMaterial["item_id"];
				$this->_userMaterials[$materialId] = array_shift($this->_userMaterials);	
			}
			
			// 处理普通的素材数据
			foreach ($this->_materialDrops as $materialDrop){
				$materialId = $materialDrop["material_no"];
				$this->_materials[$materialId]["id"] = $materialId;
				$this->_materials[$materialId]["name"] = $materialDrop["name"];
				$this->_materials[$materialId]["type"] = $this->getTypeName($materialId);
				$this->_materials[$materialId]["num"] = isset($this->_userMaterials[$materialId]) ? $this->_userMaterials[$materialId]["num"] : 0;
			}
			
			// 处理英雄碎片的数据
			foreach ($this->_composes as $compose){
				$materialId = "MOP".$compose["id"];
				$this->_materials[$materialId]["id"] = $materialId;
				$this->_materials[$materialId]["name"] = $compose["name"];
				$this->_materials[$materialId]["type"] = $this->getTypeName($materialId);
				$this->_materials[$materialId]["num"] = isset($this->_userMaterials[$materialId]) ? $this->_userMaterials[$materialId]["num"] : 0;
			}
		}
		
		/*
		* 所有素材
		*/
		public function allAction ($page = 0){
			// 分页
			$materials = array_slice($this->_materials, $page * $this->count, $this->count);
			$pageNum = ceil(count($this->_materials) / $this->count);
			
			$this->assign("materials", $materials);
			$this->assign("page", $page);
			$this->assign("pageNum", $pageNum);
			$this->display();	
		}
		
		/*
		* 已拥有素材
		*/
		public function havingAction ($page = 0){
			// 删除 num 为 0 的素材
			$materials = $this->_materials;
			foreach ($materials as $key => $material){
				if($material["num"] == 0){
					unset($materials[$key]);	
				}
			}
			
			// 分页
			$material = array_slice($materials, $page * $this->count, $this->count);
			$pageNum = ceil(count($materials) / $this->count);
			
			$this->assign("materials", $material);
			$this->assign("page", $page);
			$this->assign("pageNum", $pageNum);
			$this->display();	
		}
		
		/*
		* 添加素材
		*/
		public function addAction ($material_id, $num){
			if(!is_ajax()){
				return ;	
			}
			
			$this->logsInfo .= $this->logsSep . $material_id . ", " . $num;
			
			// num 为 0 表示删除该素材
			if($num == 0){
				$where = array(
					"user_id"	=> $this->userId,
					"item_id"	=> $material_id
				);
				$res = $this->db->table($this->_table)->where($where)->delete();
				
				if($res !== false){
					$this->logsState = 1;	
				}
				
				return;
			}
			
			// 该素材已存在，则更新素材个数
			if(isset($this->_userMaterials[$material_id])){
				$where = array(
					"user_id"	=> $this->userId,
					"item_id"	=> $material_id
				);
				$data = array(
					"num"	=> $num,
					"update_time"	=> date("Y-m-d H:i:s", time()),
				);
				$res = $this->db->table($this->_table)->where($where)->setField($data);
				
				if($res !== false){
					$this->logsState = 1;	
				}
			}else{
				// 该素材不存在，则插入一条新的记录
				$data = array(
					"user_id"	=> $this->userId,
					"item_id"	=> $material_id,
					"type"		=> $this->getTypeNum($material_id),
					"num"		=> $num,
					"create_time"	=> date("Y-m-d H:i:s", time()),
					"update_time"	=> date("Y-m-d H:i:s", time())
				);
				$res = $this->db->table($this->_table)->add($data);	
				
				if($res !== false){
					$this->logsState = 1;	
				}
			}
		}
		
		/*
		* 查找素材（所有素材页面）
		*/
		public function searchAllAction ($input = ""){
			if(!is_ajax()){
				return ;	
			}
			
			echo json_encode($this->search($this->_materials, $input));
		}
		
		/*
		* 查找素材（已有素材页面）
		*/
		public function searchHavingAction ($input = ""){
			if(!is_ajax()){
				return ;	
			}
			
			$materials = $this->_materials;
			foreach ($materials as $key => $material){
				if($material["num"] == 0){
					unset($materials[$key]);	
				}
			}
			
			echo json_encode($this->search($materials, $input));	
		}
		
		/*
		* 选择查找结果（所有素材页面）
		*/
		public function completeAllAction ($id = ""){
			if(!is_ajax()){
				return ;	
			}
			
			$data = $this->_materials[$id];
			
			$str = "<ul> 
				<li>编号</li>
				<li>ID</li>
				<li>名字</li> 
				<li>类型</li>
				<li>拥有量</li>
				<li>最大拥有量</li> 	
			</ul>
			<ul>
				<li>1</li>
				<li>{$data['id']}</li>
				<li>{$data['name']}</li>
				<li>{$data['type']}</li>
				<li contenteditable='true'>{$data['num']}</li>
				<li>999</li>
			</ul>";
					
			echo $str;
		}
		
		/*
		* 选择查找结果（已有素材页面）
		*/
		public function completeHavingAction ($id = ""){
			if(!is_ajax()){
				return ;	
			}
			
			$data = $this->_materials[$id];
			
			$str = "<ul> 
				<li>编号</li>
				<li>ID</li>
				<li>名字</li> 
				<li>类型</li>
				<li>拥有量</li>
				<li>最大拥有量</li> 	
			</ul>
			<ul>
				<li>1</li>
				<li>{$data['id']}</li>
				<li>{$data['name']}</li>
				<li>{$data['type']}</li>
				<li contenteditable='true'>{$data['num']}</li>
				<li>999</li>
			</ul>";
					
			echo $str;
		}
		
		/*
		* 得到类型的数字
		*/
		private function getTypeNum($materialId){
			$prefix = substr($materialId, 0, 3);
			
			foreach ($this->_type as $type){
				if($prefix == $type["prefix"]){
					return $type["type_num"];	
				}	
			}
			return 0;
		}
		
		/*
		* 得到类型的名字
		*/
		private function getTypeName($materialId){
			$prefix = substr($materialId, 0, 3);
			
			foreach ($this->_type as $type){
				if($prefix == $type["prefix"]){
					return $type["type_name"];	
				}	
			}
			return "";
		}
	}