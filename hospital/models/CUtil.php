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
	
	
	 static public function setCookie($name,$value,$expire=7200){
		 $cookie = new \yii\web\Cookie();
		$cookie -> name = "$name";        //cookie的名称
		$cookie -> expire = time() + $expire;	   //存活的时间
		$cookie -> httpOnly = true;		   //无法通过js读取cookie
		$cookie -> value = "$value";	   //cookie的值
var_dump($cookie);
echo "123";

		\Yii::$app->response->getCookies()->add($cookie);
     }
     
     static public function logFile($msg, $level = Logger::LEVEL_TRACE, $category="hospital"){
        Yii::getLogger()->log($msg, $level,$category);
     }
	
}
