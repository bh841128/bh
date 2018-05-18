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
                    $data = $request->cookies[$name]->value;
                } else {
                    $data = $default;
                }
                break;
            case "get":
                $data = $request->get($name, $default);
                break;
            case "post":
                $data = $request->post($name, $default);
                break;
            default: //先获取post参数，如果为空，再获取get参数。
                $data = $request->post($name, $default);
                if (empty($data)) {
                    $data = $request->get($name, $default);
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
	 
	 static public function createtable($list,$filename,$header=array()){    
		header("Content-type:application/vnd.ms-excel");    
		header("Content-Disposition:filename=".$filename.".xls");    
		$teble_header = implode("\t",$header);  
		$strexport = $teble_header."\r";  
		foreach ($list as $row){    
			foreach($row as $key=>$value){  
				$strexport.=$value."\t";     
			}  
			$strexport.="\r";   
	  
		}    
		$strexport=iconv('UTF-8',"GB2312//IGNORE",$strexport); 
		//exit($strexport);		
		return $strexport;     
	}   
	
}
