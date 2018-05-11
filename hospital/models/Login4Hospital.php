<?php

namespace app\models;

use Yii;
use app\models\CError;
use app\models\CUtil;


class Login4Hospital {
	
	 static public function getSkey($username,$password)
	 {
		 $skey=md5(md5($username)."".$password);
		 return $skey;
	 }
	
     static public function checkLogin($username,$skey)
	 {
		 
		 return true;
	 }
	 
	 
	 
	 static public function loginIn($username,$password)
	 {
		$sql = "select * from hospital_manager";
		$connection = Yii::$app->db;
		$command = $connection->createCommand($sql);
		$records = $command->queryAll();
		 
		 return true;
	 }

}