<?php

namespace app\models;

use Yii;
use app\models\CError;
use app\models\CUtil;

class HospitalizedRecord {

	static public function getRecordById($id,$hospital_id)
	{
		 $ret=array(
		   "ret"=>0,
		   "msg"=>""
		);
		
		$sql = "select * from hospitalized_record where id=:id and hospital_id=:hospital_id ";
		$args=array(':id'=>$id,':hospital_id'=>$hospital_id);
		CUtil::logFile("=====$id  ");
		
		try{
		$connection = Yii::$app->db;
		$command = $connection->createCommand($sql,$args);
		$records = $command->queryAll();
		}catch(\Exception $ex){
			$ret["ret"]=2;
			$ret["msg"]=$ex->getCode()."  ".$ex->getMessage();;		
			CUtil::logFile("catch===== ".$ret["msg"]);			
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
     static public function setRecordStatusByIds($ids,$hospital_id,$status,$manager_id){
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
		if($status==3){
			$sql="update hospitalized_record  set status=:status ,lastmodify_manager_id=:lastmodify_manager_id,lastmodifytime=:lastmodifytime where  hospital_id=:hospital_id and id in ($instr) and status=1   ";
			$args=array(':status'=>$status,':hospital_id'=>$hospital_id,":lastmodify_manager_id"=>$manager_id,":lastmodifytime"=>$now);
		}
		else {//2
		    $sql="update hospitalized_record  set status=:status ,lastmodify_manager_id=:lastmodify_manager_id,lastmodifytime=:lastmodifytime, uploadtime=:uploadtime where  hospital_id=:hospital_id and id in ($instr) and status=1  ";
			$args=array(':status'=>$status,':hospital_id'=>$hospital_id,":lastmodify_manager_id"=>$manager_id,":lastmodifytime"=>$now,":uploadtime"=>$now);
	
		}
		CUtil::logFile("=====$sql  ".print_r($args,true));
		
		try{
     	$connection = Yii::$app->db;
		$command = $connection->createCommand($sql,$args);
		$records = $command->execute();
		}catch(\Exception $ex){
			$ret["ret"]=2;
			$ret["msg"]=$ex->getCode()."  ".$ex->getMessage();;		
			CUtil::logFile("catch ===== ".$ret["msg"]);			
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
	
	
	static public function setRecordText($id,$arrText,$hospital_id){
     	$ret=array(
		   "ret"=>0,
		   "msg"=>""
		);
		$now=time(0);
		
		//operation_before_info,operation_info,operation_after_info,hospitalization_out_info
		$sql="update hospitalized_record  set";
		foreach($arrText as $key => $value  ){
			$sql=$sql." ".substr($key, 1)."=".$key.",";

		}
		$sql=$sql." lastmodifytime=$now where   id =$id and status=1  and hospital_id=$hospital_id ";
		CUtil::logFile("=====$sql  ".print_r($arrText,true));
		try{
     	$connection = Yii::$app->db;
		$command = $connection->createCommand($sql,$arrText);
		$records = $command->execute();
		}catch(\Exception $ex){
			$ret["ret"]=2;
			$ret["msg"]=$ex->getCode()."  ".$ex->getMessage();;		
			CUtil::logFile("catch===== ".$ret["msg"]);			
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
	 static public function setPatientInfo4Record($patient_id,$name,$medical_id){
		 
		$ret=array(
		   "ret"=>0,
		   
		   "msg"=>""
		  
		);
		if($name==""&&$medical_id==""){
			return $ret;
		}
		$sql = "update hospitalized_record set  ";
		if($name!=""){
			$sql=$sql." patient_name='$name',";
		}
		if($medical_id!=""){
			$sql=$sql." medical_id='$medical_id'";
		}
		
		
		$sql=$sql." where patient_id=$patient_id ";
		CUtil::logFile("=====$sql  ");
		try{
     	$connection = Yii::$app->db;
		$command = $connection->createCommand($sql);
		$result = $command->execute();
		}catch(\Exception $ex){
			$ret["ret"]=0;
			$ret["msg"]=$ex->getCode()."  ".$ex->getMessage();;		
			CUtil::logFile("catch ===== ".$ret["msg"]);			
			return $ret;
		}
		
	    $ret["msg"]="setPatientInfo4Record num: $result";
		return $ret;
	 }
	
	 static public function getRecordList($page,$hospital_id,$filter,$size=10)
	 {
		 $ret=array(
		   "ret"=>0,
		   
		   "msg"=>""
		);
         CUtil::logFile("=====$page   $hospital_id   $size");
		$sql_data="select *";
		$sql_count="select count(*) as num";
        $sql = " from hospitalized_record where hospital_id=:hospital_id and ";
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
		$sql .= " order by createtime desc ";
		
		$page=$page<1?1:$page;
		if($size<=0){
			$size=10;
		}
		$sql_data=$sql_data." ".$sql." limit ".($page-1)*$size.",".$size;
		$sql_count=$sql_count." ".$sql;

        CUtil::logFile("=====$sql_data $sql_count  ".print_r($args,true));
		
		try{
		$connection = Yii::$app->db;
		$command = $connection->createCommand($sql_data,$args);
		$records = $command->queryAll();
		}catch(\Exception $ex){
			$ret["ret"]=2;
			$ret["msg"]=$ex->getCode()."  ".$ex->getMessage();;		
			CUtil::logFile("catch ===== ".$ret["msg"]);			
			return $ret;
		}
		$ret["msg"]=$records;

		try{
		$connection = Yii::$app->db;
		$command = $connection->createCommand($sql_count,$args);
		$records = $command->queryAll();
		}catch(\Exception $ex){
			$ret["ret"]=2;
			$ret["msg"]=$ex->getCode()."  ".$ex->getMessage();;		
			CUtil::logFile("catch ===== ".$ret["msg"]);			
			return $ret;
		}
		
		if(count($records)<1){
			$ret["ret"]=1;
			$ret["msg"]="select count err!";		
			CUtil::logFile("=====  ".print_r($records,true));			
			return $ret;
		}
        $ret["total"]=$records[0]["num"];

		
		return $ret;

	}
	 
	
	static public function insertRecordInfo($record){
     	$ret=array(
		   "ret"=>0,
		   "id"=>0,
		   "msg"=>""
		);
		//patient_id,patient_name,hospitalization_in_time,operation_time,hospitalization_out_time,operation_before_info,operation_info,operation_after_info,hospitalization_out_info,createtime,lastmodifytime,hospital_id,manager_id,lastmodify_manager_id,uploadtime,status,medical_id
		/*
		$record[":hospital_id"]=intval($ret["msg"]["hospital_id"]);
		$record[":patient_id"]=intval($result["id"]);
		$record[":patient_name"]=$result["name"];
		$record[":medical_id"]=$result["medical_id"];
		$record[":manager_id"]=intval($ret["msg"]["id"]);
		$record[":lastmodify_manager_id"]=intval($ret["msg"]["id"]);
		$record[":createtime"]=$now;
		$record[":lastmodifytime"]=$now;
		
		*/
		$sql="insert into  hospitalized_record (patient_id,patient_name,hospitalization_in_time,operation_time,hospitalization_out_time,operation_before_info,operation_info,operation_after_info,hospitalization_out_info,createtime,lastmodifytime,hospital_id,manager_id,lastmodify_manager_id,uploadtime,status,medical_id) values ";
		$sql=$sql."(:patient_id,:patient_name,:hospitalization_in_time,:operation_time,:hospitalization_out_time,'','','','',:createtime,:lastmodifytime,:hospital_id,:manager_id,:lastmodify_manager_id,0,1,:medical_id) ";
		CUtil::logFile("=====$sql  ".print_r($record,true));
		try{
     	$connection = Yii::$app->db;
		$command = $connection->createCommand($sql,$record);
		$result = $command->execute();
		}catch(\Exception $ex){
			$ret["ret"]=2;
			$ret["msg"]=$ex->getCode()."  ".$ex->getMessage();;		
			CUtil::logFile("catch ===== ".$ret["msg"]);			
			return $ret;
		}
		
		if($result!= 1){
			$ret["ret"]=1;
			$ret["msg"]="insert err!";		
			CUtil::logFile("=====$result  ");			
			return $ret;
		}
		$arg=array(":lastmodify_manager_id"=>$record[":lastmodify_manager_id"]);
        $sql="select max(id) as id from hospitalized_record where lastmodify_manager_id=:lastmodify_manager_id";
		try{
		$connection = Yii::$app->db;
		$command = $connection->createCommand($sql,$arg);
		$num = $command->queryOne();
		}catch(\Exception $ex){
			$ret["ret"]=2;
			$ret["msg"]=$ex->getCode()."  ".$ex->getMessage();;		
			CUtil::logFile("catch ===== ".$ret["msg"]);			
			return $ret;
		}
		$ret["id"]=$num["id"];
		return $ret;

    }
	
	static public function getRecordsTable($year)
	{
		$ret=array(
		   "ret"=>0,
		   
		   "msg"=>""
		);
        
		
        $sql = "select hospital_id, mon,count(*) from  (SELECT hospital_id, uploadtime,from_unixtime(uploadtime) as `time` , date_format(from_unixtime(uploadtime) , '%Y') as `year`,date_format(from_unixtime(unix_timestamp()) , '%m')  as `mon` FROM hospitalized_record) as h  where year=$year group by  hospital_id,mon; ";
        CUtil::logFile("=====$sql  ");
		
		try{
		$connection = Yii::$app->db;
		$command = $connection->createCommand($sql);
		$records = $command->queryAll();
		}catch(\Exception $ex){
			$ret["ret"]=2;
			$ret["msg"]=$ex->getCode()."  ".$ex->getMessage();;		
			CUtil::logFile("catch ===== ".$ret["msg"]);			
			return $ret;
		}
		
		$ret["msg"]=$records;
		return $ret;

	}


}