<?php

namespace app\models;

use Yii;
use app\models\CError;


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
	
	
	 static public function setCookie($name,$value,$time=7200){
		$cookie = new CHttpCookie($name, $value);
		$cookie->expire = time() + $time; // 2 hours 
		Yii::app()->request->cookies[$name] = $cookie;
		 
	 }
	
}
