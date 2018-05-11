<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\CUtil;
use app\models\Login4Hospital;


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

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionHelloWorld()
    {
        CUtil::setCookie("aaa","2222");
        echo "Hello World!!!!!";
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
	
	
	public function actionListSessions()
    {
		$aaa = CUtil::getRequestParam('get', 'aaa', '2');
		echo "aaa = $aaa".PHP_EOL;
		$sql = "select * from session";
		$connection = Yii::$app->db;
		$command = $connection->createCommand($sql);
		$records = $command->queryAll();
		print_r($records);
    }

}
