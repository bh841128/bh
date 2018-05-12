<?php

namespace app\models;

use Yii;
use app\models\CError;
use app\models\CUtil;

class Patient4Hospital {

	static public function getPatientById($id,$hospital_id)
	 {
		 $ret=array(
		   "ret"=>0,
		   
		   "msg"=>""
		);
		
		$sql = "select * from patientInfo where id=:id and hospital_id=:hospital_id ";
		$args=array(':id'=>$id,':hospital_id'=>$hospital_id);
		CUtil::logFile("=====$id  ");
		
		$connection = Yii::$app->db;
		$command = $connection->createCommand($sql,$args);
		$records = $command->queryAll();
		if(count($records)!=1){
			$ret["ret"]=1;
						
			return $ret;
		}
		$ret["msg"]=$records[0];
		return $ret;
	 }

	 
	//status  0:正常 1:上传  2：删除
     static public function setPatientStatusByIds($ids,$hospital_id,$status,$manager_id){
     	$ret=array(
		   "ret"=>0,
		   "msg"=>""
		);
		if($status!=1 && $status!=2){
			$ret["ret"]=100;
			$ret["msg"]="args err!";
			return $ret;
		}
		for($i=0;$i<count($ids);$i++){
			$ids[$i]=intval($ids[$i]);
		}
		$instr=implode(",",$ids);
		$now=time(0);
		$sql="";
		$args="";
		if($status==2){
			$sql="update patientInfo  set status=:status ,lastmod_manager_id=:lastmod_manager_id,lastmodtime=:lastmodtime where  hospital_id=:hospital_id and id in ($instr) and status=0  ";
			$args=array(':status'=>$status,':hospital_id'=>$hospital_id,":lastmod_manager_id"=>$manager_id,":lastmodtime"=>$now);
		}
		else {
		    $sql="update patientInfo  set status=:status ,lastmod_manager_id=:lastmod_manager_id,lastmodtime=:lastmodtime, uploadtime=:uploadtime where  hospital_id=:hospital_id and id in ($instr) and status=0  ";
			$args=array(':status'=>$status,':hospital_id'=>$hospital_id,":lastmod_manager_id"=>$manager_id,":lastmodtime"=>$now,":uploadtime"=>$now);
	
		}
		CUtil::logFile("=====$sql  ".print_r($args,true));
		
     	$connection = Yii::$app->db;
		$command = $connection->createCommand($sql,$args);
		$records = $command->execute();
		if($records!=1){
			$ret["ret"]=1;
			$ret["msg"]="update err!";		
			CUtil::logFile("=====$records  ");			
			return $ret;
		}
		return $ret;

     }

	 
	 
	 /*
	 
	 
	 
	 */
      static public function getPatientList($page,$hospital_id,$filter,$size=10)
	 {
		 $ret=array(
		   "ret"=>0,
		   
		   "msg"=>""
		);

      


/*
		
		$sql = "select * from patientInfo where id=:id";
		$args=array(':id'=>$id);
		CUtil::logFile("=====$id  ");
		
		$connection = Yii::$app->db;
		$command = $connection->createCommand($sql,$args);
		$records = $command->queryAll();
		if(count($records)!=1){
			$ret["ret"]=1;
						
			return $ret;
		}
		$ret["msg"]=$records[0];
		return $ret;*/
		return $ret;
	 }

}
