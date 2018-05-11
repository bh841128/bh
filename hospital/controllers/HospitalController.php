<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\CUtil;
use app\models\Login4Hospital;
use yii\log\Logger;

define("NOLOGIN", 1);


class HospitalController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

  
	

     public function actionGetManager()
    {
        $username = CUtil::getRequestParam('request', 'username', '');
        $skey = CUtil::getRequestParam('cookie', 'skey', '');
        $ret=Login4Hospital::checkLogin($username,$skey);
        CUtil::logFile("====".print_r($ret,true));
        if($ret["ret"]!=0){
            $ret["ret"]=NOLOGIN;
            $ret["msg"]="not login";
            return json_encode($ret);
        }
        $ret=Login4Hospital::getManager($username);
        
        return json_encode($ret);
    }

    public function actionModpwd()
    {
        $username = CUtil::getRequestParam('request', 'username', '');
        $newpassword = CUtil::getRequestParam('request', 'newpassword', '');
        $oldpassword = CUtil::getRequestParam('request', 'oldpassword', '');
        
        //echo("===$username  $skey    ");
        $ret=Login4Hospital::modpassword($username,$oldpassword,$newpassword);
        
        return json_encode($ret);
    }

	public function actionCheckLogin()
    {
		$username = CUtil::getRequestParam('cookie', 'username', '');
		$skey = CUtil::getRequestParam('cookie', 'skey', '');
		
		//echo("===$username  $skey    ");
		$ret=Login4Hospital::checkLogin($username,$skey);
		
        return json_encode($ret);
    }
	
	
	public function actionLoginin()
    {
		$username = CUtil::getRequestParam('req', 'username', '');
		$password = CUtil::getRequestParam('req', 'password', '');
		$ret=Login4Hospital::loginIn($username,$password);
		
		
		
        return json_encode($ret);
    }
	
	
	

}
