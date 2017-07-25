<?php
	namespace Admin\Controller;
	
	/*
	* ÉÏ´« CSV
	*/
	class CsvController extends CommonController{
		// Êý×é£¬°üº¬ËùÓÐµÄ CSV ¼°ÆäËùÔÚµÄÂ·¾¶
		// ÖØÒªÌáÐÑ£º
		// ÈôÒ³ÃæÉÏ´« CSV Ê±ÌáÊ¾¡°·Ç·¨ÉÏ´«¡±£¬ÐèÔÚ¸ÃÊý×éÖÐÔö¼Ó¸Ã CSV ¼°Â·¾¶
		private $_csv = array(
			"2016-01.csv"					=> "sign/",
			"2016-02.csv"					=> "sign/",
			"2016-03.csv"					=> "sign/",
			"2016-04.csv"					=> "sign/",
			"2016-05.csv"					=> "sign/",
			"2016-06.csv"					=> "sign/",
			"2016-07.csv"					=> "sign/",
			"2016-08.csv"					=> "sign/",
			"2016-09.csv"					=> "sign/",
			"2016-10.csv"					=> "sign/",
			"2016-11.csv"					=> "sign/",
			"2016-12.csv"					=> "sign/",
			"2017-01.csv"					=> "sign/",
			"2017-02.csv"					=> "sign/",
			"2017-03.csv"					=> "sign/",
			"2017-04.csv"					=> "sign/",
			"2017-05.csv"					=> "sign/",
			"2017-06.csv"					=> "sign/",
			"2017-07.csv"					=> "sign/",
			"2017-08.csv"					=> "sign/",
			"2017-09.csv"					=> "sign/",
			"2017-10.csv"					=> "sign/",
			"2017-11.csv"					=> "sign/",
			"2017-12.csv"					=> "sign/",
			"active_skill.csv"				=> "master/",
			"Alchemy.csv"					=> "plugin/",
			"armor.csv"						=> "master/",
			"balloon.csv"					=> "client/",
			"campaign.csv"					=> "",
			"chain_skill.csv"				=> "master/",
			"compose_monster.csv"			=> "master/",
			"daily_mission.csv"				=> "mission/",
			"dungeon_star.csv"				=> "dungeon/",
			"dungeon_score_mission.csv"		=> "dungeon/",
			"elite_area.csv"				=> "dungeon/",
			"elite_dungeon.csv"				=> "dungeon/",
			"elite_enemy.csv"				=> "dungeon/",
			"elite_map.csv"					=> "dungeon/",
			"enemy_attack_ai.csv"			=> "client/",
			"evolution_user_equipment.csv"	=> "master/",
			"first_gacha.csv"				=> "gacha/",
			"gacha_controller.csv"			=> "gacha/",
			"gacha_info.csv"				=> "gacha/",
			"girudo_shop.csv"				=> "shop/",
			"gold_gacha.csv"				=> "gacha/",
			"gold_good_gacha.csv"			=> "gacha/",
			"helmet.csv"					=> "master/",
			"ladder_reward.csv"				=> "plugin/",
			"legend_area.csv"				=> "dungeon/",
			"legend_dungeon.csv"			=> "dungeon/",
			"legend_enemy.csv"				=> "dungeon/",
			"legend_map.csv"				=> "dungeon/",
			"main_mission.csv"				=> "mission/",
			"material_drop.csv"				=> "master/",
			"message.csv"					=> "mail/",
			"monster.csv"					=> "master/",
			"monster_equipment.csv"			=> "master/",
			"monster_upgrade_stats.csv"		=> "master/",
			"normal_area.csv"				=> "dungeon/",
			"ngword.csv"					=> "",
			"normal_dungeon.csv"			=> "dungeon/",
			"normal_enemy.csv"				=> "dungeon/",
			"normal_gimmick.csv"			=> "dungeon/",
			"normal_map.csv"				=> "dungeon/",
			"normal_shop.csv"				=> "shop/",
			"northeuro_gacha.csv"			=> "gacha/",
			"northeuro_good_gacha.csv"		=> "gacha/",
			"passive_skill.csv"				=> "master/",
			"present.csv"					=> "mail/",
			"pvp_shop.csv"					=> "shop/",
			"resign_stone.csv"				=> "sign/",
			"sanguo_gacha.csv"				=> "gacha/",
			"sanguo_good_gacha.csv"			=> "gacha/",
			"skill_levelup.csv"				=> "master/",
			"skill_reset_cost.csv"			=> "plugin/",
			"special_area.csv"				=> "dungeon/",
			"special_dungeon.csv"			=> "dungeon/",
			"special_enemy.csv"				=> "dungeon/",
			"special_gimmick.csv"			=> "dungeon/",
			"special_map.csv"				=> "dungeon/",
			"special_shop.csv"				=> "shop/",
			"stanimaheal_price.csv"			=> "plugin/",
			"stone_gacha.csv"				=> "gacha/",
			"stone_good_gacha.csv"			=> "gacha/",
			"title.csv"						=> "mail/",
			"sender.csv"					=> "mail/",
			"tutorial_area.csv"				=> "dungeon/",
			"tutorial_dungeon.csv"			=> "dungeon/",
			"tutorial_enemy.csv"			=> "dungeon/",
			"tutorial_map.csv"				=> "dungeon/",
			"redeem.csv"					=> "plugin/",
			"user_exp_level.csv"			=> "master/",
			"user_frame.csv"				=> "master/",
			"user_portrait.csv"				=> "master/",
			"vip_bonus.csv"					=> "plugin/",
			"vip_present.csv"				=> "plugin/",
			"vip_text.csv"					=> "plugin/",
			"weapon.csv"					=> "master/",

			"dungeon_ranking_bonus.csv"		=> "dungeon/",
			"urgent_area.csv" 				=> "dungeon/",
			"urgent_dungeon.csv" 			=> "dungeon/",
			"urgent_enemy.csv" 				=> "dungeon/",
			"urgent_map.csv" 				=> "dungeon/",
			"random_present.csv"  			=> "mail/",
			"gold_gacha.csv"  				=> "mail/",
			"present_gacha_normal.csv"		=> "mail/",
			"story_mission.csv"				=> "mission/",
			"urgent_mission.csv"			=> "mission/",
			"weekly_mission.csv"			=> "mission/",
			"question.csv"					=> "mission/",
			"question_reward.csv"			=> "mission/",
			"month_card.csv"				=> "plugin/",

			//event
			"bulletin.csv"						=> "event/",
			"dungeon_clear.csv"					=> "event/",
			"login_days.csv"					=> "event/",
			"monster_evolution_stars.csv"		=> "event/",			
			"operate_activity.csv"				=> "event/",
			"timed_present.csv"					=> "event/",
			"redeem_cashback.csv"				=> "event/",
			"monster_levelup.csv"				=> "event/",

			"plugin_shop.csv"					=> "shop/",	
			"pvp_season.csv"					=> "pvp/",	

			"monster_upgrade_stats.csv"			=> "master/",
			"second_gacha.csv"  				=> "gacha/",

			'foundation.csv'  					=> "plugin/",	
			'announcement.csv'	  				=> "plugin/",	
			'guide_bonus.csv'   				=> "mission/",
			'guild_ladder_reward.csv' 			=> 'girudo/',
			'guild_season_reward.csv'			=> 'girudo/',	
			'present_gacha_northeuro.csv'		=> 'mail/',
			'season_ranking_reward.csv'			=> 'pvp/',
			'taletown_gacha.csv'				=> 'gacha/',
			'taletown_good_gacha.csv'			=> 'gacha/',
			'payback.csv'						=> 'plugin/'
		);
		
		/*
		* ÉÏ´«Ò³Ãæ
		*/
		public function indexAction(){
			if(IS_POST){
				$platform = trim(I("platform"));
				$serv = (int)trim(I("server"));
				$this->logsInfo = $platform . ", " . $serv;
				
				// ÉÏ´«ÎÄ¼þ£¬µ÷ÓÃ TP µÄÉÏ´«Àà  http://document.thinkphp.cn/manual_3_2.html#upload
				$upload = new \Think\Upload();
				$upload->maxSize = 1024 * 1024;
				$upload->rootPath = UPLOAD_PATH_S;
				$upload->exts = array("csv");
				$upload->autoSub = false;
				$upload->saveName = "";
				$upload->replace = true;
				
				// Èç¹ûÉÏ´«Ê§°Ü£¬¸ø³öÏàÓ¦µÄ´íÎóÌáÊ¾
				$info = $upload->upload();
				if(!$info){
					$error = $upload->getError();
					$this->logsInfo .= ", " . $error;
					parent::__destruct();
					
					$this->error($error);
					return;	
				}
				
				// ½«ËùÓÐµÄÎÄ¼þÃû¼ÇÂ¼µ½ÈÕÖ¾ÎÄ¼þÖÐ
				foreach ($info as $v){
					$this->logsInfo .= 	", " . $v["savename"];
				}
				
				// Î´Ñ¡ÔñÇþµÀ£¬¸ø³ö´íÎóÌáÊ¾
				if($platform === "-1"){
					$this->assign("tips", 1);
					$this->assign("platforms", $this->getPlatforms());
					$this->display();
					return;
				}
				
				// Î´Ñ¡Ôñ·ÖÇø£¬¸ø³ö´íÎóÌáÊ¾
				if($serv === -1){
					$this->assign("tips", 2);
					$this->assign("platforms", $this->getPlatforms());
					$this->display();
					return;
				}
				
				// µÃµ½ËùÓÐµÄ·ÖÇø
				if($serv === 0){
					// ·ÖÇøÑ¡Ôñ¡°È«²¿¡±
					foreach ($this->platform[$platform] as $key => $value){
						$servArr[] = $key;	
					}
				}else{
					// Ñ¡Ôñµ¥¸ö·ÖÇø
					$servArr[] = $serv;	
				}
				
				// µÃµ½ºóÌ¨ËùÓÐÓÃµ½µÄ CSV£¬ÓÃÓÚºóÃæ¸üÐÂ CSV£¬Ê¡È¥ÁËÊÖ¶¯ÉÏ´«µÄÂé·³
				$localCsv = [];
				$dir = opendir(CSV_PATH);
				if($dir){
					while(1){
						$fileName = readdir($dir);
						
						if($fileName === false){
							break;	
						}
						
						$localCsv[] = $fileName;
					}
				}
				
				// ½«ÉÏ´«µÄ CSV ·Ö·¢µ½²»Í¬µÄÇþµÀºÍ·ÖÇø
				foreach ($this->platform[$platform] as $serverNum => $server){
					// µ±Ç°µÄ·ÖÇøÊÇ·ñÔÚÑ¡ÔñµÄ·ÖÇøÖÐ
					if(!in_array($serverNum, $servArr)){
						continue;
					}
					
					// Á¬½Ó Redis£¬µÃµ½ËùÓÐµÄ»º´æ
					$redis = new \Redis();
					$res = $redis->connect($server["url"], $server["redis_port"]);
					$redis->auth($server["redis_pwd"]);
					$redisArr = $redis->keys("*");
					
					// ±éÀúÉÏ´«ÐÅÏ¢£¬·Ö·¢ CSV
					foreach ($info as $key => $file){
						if(isset($this->_csv[$file["savename"]])){
							// Èç¹ûµ±Ç° CSV ´æÔÚÓÚÊý×éµ±ÖÐ£¬Ôò·Ö·¢
							// Á¬½Óµ½·ÖÇøËùÔÚµÄ·þÎñÆ÷
							$conn = ssh2_connect($server["url"]);
							ssh2_auth_password($conn, $server["username"], $server["userpwd"]);
							
							// ·Ö·¢ÎÄ¼þ
							$file1 = UPLOAD_PATH_S . $file["savename"];
							$file2 = $server["csv_path"] . $this->_csv[$file["savename"]] . $file["savename"];
							$send = ssh2_scp_send($conn, $file1, $file2);
							
							// ¼ÇÂ¼½á¹û
							$result[$serverNum][$key]["name"] = $file["savename"];
							$result[$serverNum][$key]["send"] = (int)$send;
							$result[$serverNum][$key]["delete"] = 2;
							
							// Èç¹ûºóÌ¨Ê¹ÓÃÁË¸Ã CSV£¬ÔòÍ¬²½¸Ã CSV ÖÁÏàÓ¦µÄÄ¿Â¼ÏÂ£¬²¢É¾³ý»º´æ
							if(in_array($file["savename"], $localCsv)){
								copy($file1, CSV_PATH . "/" . $file["savename"]);
								RedisController::getInstance()->delete(REDIS_PREFIX . $file["savename"]);
							}
							
						}else{
							// Èç¹ûµ±Ç° CSV ²»´æÔÚÓÚÊý×éµ±ÖÐ£¬Ôò¸ø³öÌáÊ¾¡°·Ç·¨ÉÏ´«¡±
							$result[$serverNum][$key]["name"] = $file["savename"];
							$result[$serverNum][$key]["send"] = 2;
							$result[$serverNum][$key]["delete"] = 2;
						}
						
						// Èô»º´æ´æÔÚ£¬ÔòÉ¾³ýÏàÓ¦µÄ»º´æ				
						foreach ($redisArr as $v){
							if(stripos($v, $file["savename"]) !== false){
								$delete = $redis->delete($v);
								$result[$serverNum][$key]["delete"] = $delete;
							}
						}
					}
				}
				
				// Í³¼Æ½á¹û
				foreach ($result as $key => $value){
					$count[$key]["sendF"] = 0;		// ¼ÇÂ¼ÉÏ´«Ê§°ÜµÄ¸öÊý
					$count[$key]["deleteF"] = 0;	// ¼ÇÂ¼»º´æÉ¾³ýÊ§°ÜµÄ¸öÊý
					
					foreach ($value as $k => $v){
						if($v["send"] == 0){
							$count[$key]["sendF"]++;	
						}
						
						if($v["delete"] == 0){
							$count[$key]["deleteF"]++;	
						}
					}
				}
				
				$this->logsState = 1;
				
				$this->assign("platform", $platform);
				$this->assign("result", $result);
				$this->assign("count", $count);
				$this->assign("file_number", count($info));
			}
			
			$this->assign("platforms", $this->getPlatforms());
			$this->display();
		}
		
		/*
		* µÃµ½ËùÓÐµÄÇþµÀ
		*/
		private function getPlatforms(){
			$platforms = [];
			
			foreach ($this->platform as $key => $value){
				$platforms[] = $key;
			}
			
			return $platforms;	
		}
		
		/*
		* µÃµ½¸ÃÇþµÀÏÂ¶ÔÓ¦µÄËùÓÐ·ÖÇø
		*/
		public function getServersAction($platform = ""){
			if(!is_ajax()){
				return;	
			}
			
			$servers = [];
			
			foreach ($this->platform[$platform] as $key => $value){
				$servers[] = $key;
			}
			
			echo json_encode($servers);
		}
	}