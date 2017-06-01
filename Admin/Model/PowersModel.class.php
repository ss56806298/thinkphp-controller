<?php
	namespace Admin\Model;
	use Think\Model;
	
	class PowersModel extends Model{
		/*
		* 得到所有数据
		*/
		public function getData($powIds = []){
			$result = $this->order("pow_sort")->select();
			$powers = [];
			foreach ($result as &$res){
				if(in_array($res["pow_id"], $powIds)){
					$res["checked"] = 1;	
				}
				
				if($res["pow_pid"] == 0){
					$powers[$res["pow_id"]] = $res;
				}else{
					$powers[$res["pow_pid"]]["pow_child"][$res["pow_id"]] = $res;
				}
			}
			
			return $powers;	
		}
		
		/*
		* 根据 IDs 得到数据
		*/
		public function getDataByIds($ids){
			$powers = [];
			$ids = explode(",", $ids);
			foreach ($ids as $id){
				$where = array(
					"pow_id"	=> $id
				);
				$powers[] = $this->where($where)->find();
			}
			
			$tmp = [];
			foreach ($powers as $key => $value){
				$tmp[$value["pow_sort"]] = $value;
			}
			ksort($tmp);
			$powers = $tmp;
			
			$result = [];
			foreach ($powers as $power){
				if($power["pow_pid"] == 0){
					$result[$power["pow_id"]] = $power;
				}else{
					$result[$power["pow_pid"]]["pow_child"][$power["pow_id"]] = $power;
				}
			}
			
			return $result;
		}
		
		/*
		* 根据 IDs(array) 得到 IDs(string) 和 AC
		*/
		public function getPowIdsAndAc($ids){
			array_walk($ids, function (&$value, $key){
				$value = (int)$value;
			});
			
			$powIds = "";
			$powAc = "";
			for($i = 0; $i < count($ids); $i++){
				$powIds .= $ids[$i] . ",";
				$powAc  .= $this->getAcById($ids[$i]) . ",";
			}
			$powIds = substr($powIds, 0, strlen($powIds) - 1);
			$powAc  = substr($powAc , 0, strlen($powAc)  - 1);
			
			$result = array(
				"pow_ids"	=> $powIds,
				"pow_ac"	=> $powAc
			);
			
			return $result;
		}
		
		/*
		* 根据 ID 得到 AC
		*/
		public function getAcById($powId){
			$where = array(
				"pow_id"	=> (int)$powId
			);
			return $this->where($where)->getField("pow_ac");
		}
	}