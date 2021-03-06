<?php

namespace app\models;

use Yii;
use app\models\CError;
use app\models\CUtil;
use app\models\Hospital;

define("TIMEOUT", 172800);
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
	
	
     static public function modpassword($username,$oldpassword,$newpassword)
	 {
		 $ret=array(
		   "ret"=>0,
		   
		   "msg"=>""
		);
		$now=time(0);
        $newpwd=Login4Hospital::getPass4S($username,$newpassword);
        $oldpwd=Login4Hospital::getPass4S($username,$oldpassword);
		$sql = "update hospital_manager set password=:newpassword  where username=:username and password=:oldpassword ";
		$args=array(':username'=>$username,':newpassword'=>$newpwd,":oldpassword"=>$oldpwd);
		CUtil::logFile("$username     $newpassword $oldpassword  $newpwd   $oldpwd");
		
		try{
		$connection = Yii::$app->db;
		$command = $connection->createCommand($sql,$args);
		$records = $command->execute();
		}catch(\Exception $ex){
			$ret["ret"]=2;
			$ret["msg"]=$ex->getCode()."  ".$ex->getMessage();;		
			CUtil::logFile("===== ".$ret["msg"]);			
			return $ret;
		}
		
		if($records!=1){
			$ret["ret"]=1;
			$ret["msg"]="update err!";			
			return $ret;
		}
		CUtil::logFile("=====$records");
		$sql = "delete  from session where username=:username  ";
		$args=array(':username'=>$username);
		$command = $connection->createCommand($sql,$args);
		$records = $command->execute();
        
		return $ret;
	 }

	 static public function getManager($username)
	 {
		 $ret=array(
		   "ret"=>0,
		   
		   "msg"=>""
		);



		$now=time(0);
		$sql = "select * from hospital_manager where username=:username and status=0";
		$args=array(':username'=>$username);
		CUtil::logFile("$username  ");
		
		try{
		$connection = Yii::$app->db;
		$command = $connection->createCommand($sql,$args);
		$record = $command->queryOne();
		}catch(\Exception $ex){
			$ret["ret"]=2;
			$ret["msg"]=$ex->getCode()."  ".$ex->getMessage();;		
			CUtil::logFile("===== ".$ret["msg"]);			
			return $ret;
		}
		
		if(empty($record)){
			$ret["ret"]=1;
						
			return $ret;
		}
		$record["hospital"] = Hospital::getHospitalById($record["hospital_id"]);
		$ret["msg"]=$record;
		 return $ret;
	 }
	
     static public function checkLogin($username,$skey)
	 {
		 $ret=array(
		   "ret"=>0,
		   
		   "msg"=>""
		);
		$now=time(0);
		$sql = "select * from session where username=:username  and skey=:skey and time+".TIMEOUT.">:now";
		$args=array(':username'=>$username,':skey'=>$skey,":now"=>$now);
		CUtil::logFile("$username  $skey   $now   $sql");
		
		try{
		$connection = Yii::$app->db;
		$command = $connection->createCommand($sql,$args);
		$records = $command->queryAll();
		}catch(\Exception $ex){
			$ret["ret"]=2;
			$ret["msg"]=$ex->getCode()."  ".$ex->getMessage();;		
			CUtil::logFile("===== ERR".$ret["msg"]);			
			return $ret;
		}
		
		if(count($records)!=1){
			$ret["ret"]=1;
						
			return $ret;
		}
		$ret["msg"]=$username;
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
		CUtil::logFile("$username  $password    $sql  $pass");
		
		try{
		$connection = Yii::$app->db;
		
		
		$command = $connection->createCommand($sql,$args);
		$records = $command->queryAll();
		}catch(\Exception $ex){
			$ret["ret"]=2;
			$ret["msg"]=$ex->getCode()."  ".$ex->getMessage();;		
			CUtil::logFile("===== ".$ret["msg"]);			
			return $ret;
		}
		
		
		if(count($records)!=1){
			$ret["ret"]=1;
			return $ret;
		}
		
		if($records [0]["username"]==$username&&
		  $records [0]["password"]== $pass)
		{
			$now=time(0);
			$sql = "select * from session where username=:username and time+".TIMEOUT.">:now";
			$args=array(':username'=>$username,":now"=>$now);
			CUtil::logFile("$username     $now   $sql");
			
			try{
			$connection = Yii::$app->db;
			$command = $connection->createCommand($sql,$args);
			$record = $command->queryOne();
			}catch(\Exception $ex){
				$ret["ret"]=2;
				$ret["msg"]=$ex->getCode()."  ".$ex->getMessage();;		
				CUtil::logFile("===== ERR".$ret["msg"]);			
				return $ret;
			}
			if(!empty($record)){//有且和cookie一致就不创建新的skey
				$skey_cookie = CUtil::getRequestParam('cookie', 'skey', '');
				if($skey_cookie==$record["skey"]){//这种不重写cookie和数据库session
					$ret["ret"]=0;
					$ret["username"]=$username;	
					$ret["skey"]=$record["skey"];				
					return $ret;
				}
			}
			
			$ret["ret"]=0;
			$ret["username"]=$username;
			$ret["skey"]=$skey;
			$args=array(':username'=>$username,':skey'=>$skey,":time"=>time(0));
			$sql="replace into session (`username`,`skey`,`time`) values (:username,:skey,:time)";
			
			try{
			$command = $connection->createCommand($sql,$args);
			$count=$records = $command->execute();
			}catch(\Exception $ex){
				$ret["ret"]=2;
				$ret["msg"]=$ex->getCode()."  ".$ex->getMessage();;		
				CUtil::logFile("===== ".$ret["msg"]);			
				return $ret;
			}
			
			if($count==0){
				CUtil::logFile("insert session err!! $sql  ".print_r($args,true));
			}
			CUtil::setCookie("username",$username,TIMEOUT);
			CUtil::setCookie("skey",$skey,TIMEOUT);
		}
		else {
			$ret["ret"]=2;
			return $ret;
		}
		
		 return $ret;
	 }

}