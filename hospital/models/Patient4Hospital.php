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
		$ret["msg"]=$records[0];
		return $ret;
	 }

	 
	//status  1:正常 2:上传  3：删除
     static public function setPatientStatusByIds($ids,$hospital_id,$status,$manager_id){
     	$ret=array(
		   "ret"=>0,
		   "msg"=>""
		);
		if($status!=2 && $status!=3){
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
			$sql="update patientInfo  set status=:status ,lastmod_manager_id=:lastmod_manager_id,lastmodtime=:lastmodtime where  hospital_id=:hospital_id and id in ($instr) and status=1  ";
			$args=array(':status'=>$status,':hospital_id'=>$hospital_id,":lastmod_manager_id"=>$manager_id,":lastmodtime"=>$now);
		}
		else {//3
		    $sql="update patientInfo  set status=:status ,lastmod_manager_id=:lastmod_manager_id,lastmodtime=:lastmodtime, uploadtime=:uploadtime where  hospital_id=:hospital_id and id in ($instr) and status=1  ";
			$args=array(':status'=>$status,':hospital_id'=>$hospital_id,":lastmod_manager_id"=>$manager_id,":lastmodtime"=>$now,":uploadtime"=>$now);
	
		}
		CUtil::logFile("=====$sql  ".print_r($args,true));
		
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
		
		
		
		
		if($records==0){
			$ret["ret"]=1;
			$ret["msg"]="update err!";		
			CUtil::logFile("=====$records  ");			
			return $ret;
		}
		return $ret;

    }

	 
	 
	 /*
	 
	 
http://112.74.105.107/hospital/get-patient-list?page=1&size=8&sexy=1&name=ddg&medical_id=gfhfg&relate_name=fghfg&relate_iphone=13590149774&status=1&start_time=0&end_time=99999999

status  1:正常 2:上传  3：删除 
	 
	 */
     static public function getPatientList($page,$hospital_id,$filter,$size=10)
	 {
		 $ret=array(
		   "ret"=>0,
		   
		   "msg"=>""
		);
         CUtil::logFile("=====$page   $hospital_id   $size");
		
        $sql = "select * from patientInfo where hospital_id=:hospital_id and ";
		$args=array(":hospital_id"=>$hospital_id);
		foreach ($filter as $key => $value) {  
			if($key!="start_time"&&$key!="end_time"){
				$sql=$sql." $key=:".$key."  and ";
				$args[":".$key]=$value;
			}
			
		}
		
		if(array_key_exists("end_time",$filter)){
			$sql=$sql." uploadtime<=:end_time  and ";
			$args[":end_time"]=$filter["end_time"];
		}
		if(array_key_exists("start_time",$filter)){
			$sql=$sql." uploadtime>=:start_time   ";
			$args[":start_time"]=$filter["start_time"];
		}else{
			$sql=$sql." uploadtime>=0 ";
		}
		
		$page=$page<1?1:$page;
		$sql=$sql." limit ".($page-1)*$size.",".$size;
        CUtil::logFile("=====$sql  ".print_r($args,true));
		
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
		
		$ret["msg"]=$records;
		return $ret;

	 }
	 
	 
	 
	  static public function insertPatientInfo($patientInfo){
     	$ret=array(
		   "ret"=>0,
		   "msg"=>""
		);
		
		
		$sql="";
		if($patientInfo[":isSupply"]!=0){
			$sql="insert into  patientInfo (hospital_id,medical_id,name,nation,birthday,reason,isSupply,relate_text,`status`,lastmod_manager_id,sexy,createtime,uploadtime,lastmodtime,create_manager_id) values(:hospital_id,:medical_id,:name,:nation,:birthday,:reason,:isSupply,:relate_text,:status,:lastmod_manager_id,:sexy,:createtime,:uploadtime,:lastmodtime,:create_manager_id) ";

		}
		else{
			$sql="insert into  patientInfo (hospital_id,medical_id,name,nation,birthday,province,city,district,address,relate_text,`status`,lastmod_manager_id,sexy,createtime,uploadtime,lastmodtime,create_manager_id,isSupply) values(:hospital_id,:medical_id,:name,:nation,:birthday,:province,:city,:district,:address,:relate_text,:status,:lastmod_manager_id,:sexy,:createtime,:uploadtime,:lastmodtime,:create_manager_id,:isSupply) ";

		}

		CUtil::logFile("=====$sql  ".print_r($patientInfo,true));
		try{
     	$connection = Yii::$app->db;
		$command = $connection->createCommand($sql,$patientInfo);
		$records = $command->execute();
		}catch(\Exception $ex){
			$ret["ret"]=2;
			$ret["msg"]=$ex->getCode()."  ".$ex->getMessage();;		
			CUtil::logFile("===== ".$ret["msg"]);			
			return $ret;
		}
		
		if($records!=1){
			$ret["ret"]=1;
			$ret["msg"]="insert err!";		
			CUtil::logFile("=====$records  ");			
			return $ret;
		}
		return $ret;

    }

	static public function updatePatientInfo($id,$patientInfo,$hospital_id){
     	$ret=array(
		   "ret"=>0,
		   "msg"=>""
		);
		
		/*
[:lastmod_manager_id] => 1
    [:lastmodtime] => 1526151032
   
    [:sexy] => 1
    
    [:nation] => 汉
    [:birthday] => 19841128
    [:isSupply] => 1
    [:reason] => 不给
    [:relate_text] => fdgdf
		*/
		
		$sql="update   patientInfo set ";
		foreach($patientInfo as $key => $value  ){
			$sql=$sql." ".substr($key, 1)."=".$key.",";

		}
		$sql=$sql." create_manager_id=create_manager_id where id=".intval($id)."  and status=1  and hospital_id=$hospital_id ";   
		CUtil::logFile("=====$sql  ".print_r($patientInfo,true));

		try{
     	$connection = Yii::$app->db;
		$command = $connection->createCommand($sql,$patientInfo);
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
			CUtil::logFile("=====$records  ");			
			return $ret;
		}
		return $ret;

     }
}
