<?php
namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\CUtil;
use app\models\Login4Hospital;
use app\models\Patient4Hospital;
use app\models\HospitalizedRecord;
use app\models\Hospital;
use yii\log\Logger;

class HospitalController extends Controller
{
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
    public function beforeAction($action) {
        Yii::$app->request->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    function checkLogin(){
        $username = CUtil::getRequestParam('cookie', 'username', '');
        $skey = CUtil::getRequestParam('cookie', 'skey', '');
		//登录
        $ret=Login4Hospital::checkLogin($username,$skey);
        if ($ret["ret"] != 0){
            return false;
        }
        return true;
    }

    public function actionGetPatientAndZhuyuanjilu(){
        if (!$this->checkLogin()){
            return ["ret"=>1, "msg"=>"need login"];
        }
        $patient_id = CUtil::getRequestParam('cookie', 'patient_id', 0);
        $zyjl_id = CUtil::getRequestParam('cookie', 'zyjl', 0);
        if ($patient_id == 0 || $zyjl_id){
            return ["ret"=>99, "msg"=>"param error"];
        }
        $ret = Hospital::getPatientAndZhuyuanjilu($patient_id, $zyjl_id);
        return json_encode($ret);
    }
}