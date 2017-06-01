<?php
	namespace Admin\Controller;
	
	/*
	* 快速通关
	*/
	class DungeonController extends GameController {
		private $_table;				// 当前操作的数据表
		private $_dungeonData;			// 来自数据库
		private $_normalType = 1;		// 普通副本类型
		private $_eliteType = 2;		// 精英副本类型
		private $_normalDungeon;		// 来自 normal_dungeon.csv
		private $_eliteDungeon;			// 来自 elite_dungeon.csv
		private $_normals;				// 经 normal_dungeon 按副本顺序整理
		private $_elitePrefix = "ELD";	// 精英副本的前缀
		
		public function __construct (){
			parent::__construct();
			
			$this->_table = $this->table["dungeon_data"];
			
			// 筛选没有删除的普通副本
			$where = array(
				"user_id"		=> $this->userId,
				"dungeon_type"	=> $this->_normalType,
				"delete_time"	=> array("EXP", "IS NULL")
			);
			$this->_dungeonData = $this->db->table($this->_table)->where($where)->select();
			
			$this->_normalDungeon = $this->normalCsv;
			$this->_eliteDungeon = $this->eliteCsv;
			$dungeons[] = "NMD00019";	// 按副本出现的顺序存储
			while(1){
				$lastDungeon = $dungeons[count($dungeons) - 1];
				if($lastDungeon == "END"){
					break;	
				}
				
				$dungeons[] = $this->_normalDungeon[$lastDungeon]["next_dungeon_id1"];
			}
			array_pop($dungeons);		// 删除最后一个无效的 "END"
			
			foreach ($dungeons as $dungeon){
				$this->_normals[$this->_normalDungeon[$dungeon]["area_id"]][$dungeon] = $this->_normalDungeon[$dungeon];
			}
		}
		
		/*
		* 显示所有的副本
		*/
		public function indexAction (){
			if(IS_POST){
				// 清空普通副本
				$where = array(
					"user_id"	=> $this->userId,
					"dungeon_type"	=> $this->_normalType,
					"delete_time"	=> array("EXP", "IS NULL")
				);
				$this->db->table($this->_table)->where($where)->delete();
				
				// 清空精英副本
				$where = array(
					"user_id"	=> $this->userId,
					"dungeon_type"	=> $this->_eliteType
				);
				$this->db->table($this->_table)->where($where)->delete();
				
				// 添加普通副本
				$dungeons = I("dungeon");
				$lastDungeon = array_pop($dungeons);
				foreach ($dungeons as $dungeon){
					$data["user_id"] = $this->userId;
					$data["area_num_id"] = $this->_normalType . substr($this->_normalDungeon[$dungeon]["area_id"], 3);
					$data["dungeon_num_id"] = $this->_normalType . substr($dungeon, 3);
					$data["area_id"] = $this->_normalDungeon[$dungeon]["area_id"];
					$data["dungeon_id"] = $dungeon;
					$data["dungeon_type"] = $this->_normalType;
					$data["clear_cnt"] = 1;
					$data["today_play_cnt"] = 0;
					$data["today_clear_cnt"] = 0;
					$data["play_cnt"] = 1;
					$data["reset_cnt"] = 0;
					$data["state"] = 2;
					$data["star"] = 3;
					$data["quest1"] = 1;
					$data["quest2"] = 1;
					$data["quest3"] = 1;
					$data["last_clear_time"] = date("Y-m-d H:i:s", time());
					$data["last_start_time"] = date("Y-m-d H:i:s", time());
					$data["create_time"] = date("Y-m-d H:i:s", time());
					$data["update_time"] = date("Y-m-d H:i:s", time());
					
					$this->db->table($this->_table)->add($data);
				}
				
				// 添加普通副本最后一关
				$data["user_id"] = $this->userId;
				$data["area_num_id"] = $this->_normalType . substr($this->_normalDungeon[$lastDungeon]["area_id"], 3);
				$data["dungeon_num_id"] = $this->_normalType . substr($lastDungeon, 3);
				$data["area_id"] = $this->_normalDungeon[$lastDungeon]["area_id"];
				$data["dungeon_id"] = $lastDungeon;
				$data["dungeon_type"] = $this->_normalType;
				$data["clear_cnt"] = 0;
				$data["today_play_cnt"] = 0;
				$data["today_clear_cnt"] = 0;
				$data["play_cnt"] = 0;
				$data["reset_cnt"] = 0;
				$data["state"] = 0;
				$data["star"] = 0;
				$data["quest1"] = 0;
				$data["quest2"] = 0;
				$data["quest3"] = 0;
				$data["last_clear_time"] = date("Y-m-d H:i:s", time());
				$data["last_start_time"] = date("Y-m-d H:i:s", time());
				$data["create_time"] = date("Y-m-d H:i:s", time());
				$data["update_time"] = date("Y-m-d H:i:s", time());
				$this->db->table($this->_table)->add($data);
			
				$where = array(
					"user_id"		=> $this->userId,
					"dungeon_type"	=> $this->_normalType,
					"delete_time"	=> array("EXP", "IS NULL")
				);
				$this->_dungeonData = $this->db->table($this->_table)->where($where)->select();
				
				// 添加精英副本
				if(I("elite") == "elite"){
					foreach ($dungeons as $dungeon){
						$eliteDungeons[] = $this->_elitePrefix . substr($dungeon, 3);	
					}
					
					foreach ($eliteDungeons as $eliteDungeon){
						$data["user_id"] = $this->userId;
						$data["area_num_id"] = $this->_eliteType . substr($this->_eliteDungeon[$eliteDungeon]["area_id"], 3);
						$data["dungeon_num_id"] = $this->_eliteType . substr($eliteDungeon, 3);
						$data["area_id"] = $this->_eliteDungeon[$eliteDungeon]["area_id"];
						$data["dungeon_id"] = $eliteDungeon;
						$data["dungeon_type"] = $this->_eliteType;
						$data["clear_cnt"] = 1;
						$data["today_play_cnt"] = 0;
						$data["today_clear_cnt"] = 0;
						$data["play_cnt"] = 1;
						$data["reset_cnt"] = 0;
						$data["state"] = 2;
						$data["star"] = 3;
						$data["quest1"] = 1;
						$data["quest2"] = 1;
						$data["quest3"] = 1;
						$data["last_clear_time"] = date("Y-m-d H:i:s", time());
						$data["last_start_time"] = date("Y-m-d H:i:s", time());
						$data["create_time"] = date("Y-m-d H:i:s", time());
						$data["update_time"] = date("Y-m-d H:i:s", time());
						
						$this->db->table($this->_table)->add($data);
					}
				}
				$this->assign("is_post", 1);
				
				$this->logsInfo .= $this->logsSep . $lastDungeon . $this->logsSep . (empty(I("elite")) ? "n" : "y");
				$this->logsState = 1;
			}
			
			foreach ($this->_dungeonData as $dungeonData){
				$this->_normals[$dungeonData["area_id"]][$dungeonData["dungeon_id"]]["is_having"] = 1;
			}
			
			$this->assign("normal_dungeons", $this->_normals);
			$this->assign("dungeon_num", count($this->_dungeonData));
			$this->display();
		}	
	}