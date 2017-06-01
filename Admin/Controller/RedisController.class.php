<?php
	namespace Admin\Controller;
	
	class RedisController extends CommonController{
		public static function getInstance(){
			$redis = new \Redis();
			$redis->connect("127.0.0.1");
			return $redis;	
		}
		
		public static function setArray($fileName){
			$data = csvLoader($fileName);
			self::getInstance()->set(REDIS_PREFIX . $fileName, serialize($data));
		}
		
		public static function getArray($fileName){
			$value = self::getInstance()->get(REDIS_PREFIX . $fileName);
			return unserialize($value);
		}
	}