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
        echo "Hello World!!!!!";
    }
	
	public function actionLoginin()
    {
		$username = CUtil::getRequestParam('req', 'username', '');
		$password = CUtil::getRequestParam('req', 'password', '');
		$b=Login4Hospital::loginIn($username,$password);
		$ret=array();
		$ret["username"]=$username ;
		$ret["password"]=$password ;
		if($b)
		{
			$ret["ret"]=0;
		}
		else
		{
			$ret["ret"]=1;
			
		}
        print_r($ret);
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
