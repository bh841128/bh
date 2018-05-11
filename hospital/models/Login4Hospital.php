<?php

namespace app\models;

use Yii;
use app\models\CError;
use app\models\CUtil;


class Login4Hospital {
	
	 static public function getPass4S($username,$password)
	 {
		 
		 $pass=md5(md5($username)."".$password);
		
		 return $pass;
	 }
	 
	 static public function getskey($username,$password)
	 {
		 
		 $skey=md5(md5($username).time(0).$password);
		
		 return $skey;
	 }
	
	
	
	
     static public function checkLogin($username,$skey)
	 {
		 $ret=array(
		   "ret"=>0,
		   
		   "msg"=>""
		);
		$now=time(0);
		$sql = "select * from session where username=:username  and skey=:skey and time+7200>:now";
		$args=array(':username'=>$username,':skey'=>$skey,":now"=>$now);
		CUtil::logFile("$username  $skey   $now   $sql");
		
		$connection = Yii::$app->db;
		$command = $connection->createCommand($sql,$args);
		$records = $command->queryAll();
		if(count($records)!=1){
			$ret["ret"]=1;
						
			return $ret;
		}
		 return $ret;
	 }
	 
	 
	 
	 static public function loginIn($username,$password)
	 {
		$ret=array(
		   "ret"=>0,
		   "skey"=>"",
		   "msg"=>""
		);
		
		$pass=Login4Hospital::getPass4S($username,$password);
		$skey=Login4Hospital::getskey($username,$password);
		$sql = "select * from hospital_manager where username=:username  and password=:pass";
		//Mytable::findBySql($sql,[':username'=>$username,':pass'=>$pass])->all();   
		
		$args=array(':username'=>$username,':pass'=>$pass);
		//echo("$username  $password   $sql");
		CUtil::logFile("$username  $password   $sql");
		$connection = Yii::$app->db;
		$command = $connection->createCommand($sql,$args);
		$records = $command->queryAll();
		if(count($records)!=1){
			$ret["ret"]=1;
			return $ret;
		}
		
		if($records [0]["username"]==$username&&
		  $records [0]["password"]== $pass)
		{
			$ret["ret"]=0;
			$ret["username"]=$username;
			$ret["skey"]=$skey;
			$args=array(':username'=>$username,':skey'=>$skey,":time"=>time(0));
			$sql="replace into session (`username`,`skey`,`time`) values (:username,:skey,:time)";
			$command = $connection->createCommand($sql,$args);
			$count=$records = $command->execute();
			if($count==0){
				CUtil::logFile("insert session err!! $sql  ".print_r($args,true));
			}
			CUtil::setCookie("username",$username);
			CUtil::setCookie("skey",$skey);
		}
		else {
			$ret["ret"]=1;
			return $ret;
		}
		
		 return $ret;
	 }

}