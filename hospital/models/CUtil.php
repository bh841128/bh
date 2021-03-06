<?php

namespace app\models;

use Yii;
use app\models\CError;
use yii\log\Logger;

class CUtil {
    static public function getRequestParam($type, $name, $default = 0) {
        $data = NULL;
        $request = Yii::$app->request;
        switch ($type) {
            case "cookie":
                if (isset($request->cookies[$name])) {
                    $data = trim($request->cookies[$name]->value);
                } else {
                    $data = $default;
                }
                break;
            case "get":
                $data = trim($request->get($name, $default));
                break;
            case "post":
                $data = trim($request->post($name, $default));
                break;
            default: //先获取post参数，如果为空，再获取get参数。
                $data = trim($request->post($name, $default));
                if (empty($data)) {
                    $data = trim($request->get($name, $default));
                }
        }
        return $data;
    }
	static public function checkMobile($str) 
	{ 
		if(preg_match("/^1[34578]{1}\d{9}$/",$str)){  
			return true;  
		}else{  
			return false;  
		}  
	} 
		
	 static public function setCookie($name,$value,$expire=7200){
		$cookies = Yii::$app->response->cookies;
 
		$cookies->add(new \yii\web\Cookie([
			'name' => "$name",
			'value' => "$value",
			'expire'=>time()+$expire
		]));
     }
     
     static public function logFile($msg, $level = Logger::LEVEL_ERROR, $category="hospital"){
        Yii::$app->log->traceLevel = 0;
        Yii::getLogger()->log($msg, $level,$category);
     }
	 
	 static public function createtable($list,$filename,$header){    
		header("Content-type:application/vnd.ms-excel;charset=utf-8");    
		header("Content-Disposition:filename=".$filename.".xls"); 
		$header1=array();
		
		//CUtil::logFile("bbbb".print_r($header,true));
		foreach ($header as $k=>$v){
			$header1[]=$k;
		}
		$strexport='<html xmlns:x="urn:schemas-microsoft-com:office:excel"><body><table>';
		
		$strexport.="<tr>";
		foreach($header1 as $value){
			$strexport.="<td x:str>";
			$strexport.=$value;
			$strexport.="</td>";
		}
		$strexport.="</tr>";
		
		foreach ($list as $row){
			$strexport.="<tr>";
            //CUtil::logFile(",,,,,,,,,,".print_r($row,true));			
			foreach($header as $key=>$value){
                if(array_key_exists($value,$row)){
					$temp=$row[$value];
					$str="";
					if(is_array($temp)){
						foreach($temp as $k=>$v) {
							foreach($v as $k1=>$v1){
								$str=$str.$v1.";";
							}
						}
 
					}else{
						$str=$row[$value];
					}
					$strexport.="<td style=\"vnd.ms-excel.numberformat:@\">";
					$strexport.=$str;
					$strexport.="</td>";
				}
				else{
					$strexport.="<td x:str>";
					$strexport.=$str;
					$strexport.="</td>";
				}				 
					    
			}  
			$strexport.="</tr>"; 
	  
		}
		
		/*
		
		
		//CUtil::logFile("aaaaa".print_r($header1,true));
		$teble_header = implode("\t",$header1);  
		$strexport = $teble_header."\r";  
		foreach ($list as $row){
            //CUtil::logFile(",,,,,,,,,,".print_r($row,true));			
			foreach($header as $key=>$value){
                if(array_key_exists($value,$row)){
					$temp=$row[$value];
					$str="";
					if(is_array($temp)){
						foreach($temp as $k=>$v) {
							foreach($v as $k1=>$v1){
								$str=$str.$v1.";";
							}
						}
 
					}else{
						$str=$row[$value];
					}
					$strexport.=("  ".$str)."\t"; 
				}
				else{
					$strexport.="\t"; 
				}				 
					    
			}  
			$strexport.="\r";   
	  
		} */   
		//$strexport=iconv('UTF-8',"GBK//IGNORE",$strexport); 
		//exit($strexport);		
		return $strexport;     
	}   

	static public function is_json($string) {
	    json_decode($string);
	    return (json_last_error() == JSON_ERROR_NONE);
	}
	
}
