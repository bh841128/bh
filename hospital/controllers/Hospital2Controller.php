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

define("NOLOGIN", 1);
define("NODATA", 2);
define("NOACCESS", 3);
define("ARGSERR", 4);
define("INSERTERR", 5);
define("UPDATEERR", 6);
define("PATINTIDERR", 7);
define("RECORDERR", 8);
define("SETSTATUS_PATIENTERR", 9);

class Hospital2Controller extends Controller
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

    function actionExportExcel(){
        /*
        $username = CUtil::getRequestParam('cookie', 'username', '');
        $skey = CUtil::getRequestParam('cookie', 'skey', '');
        $ret=Login4Hospital::checkLogin($username,$skey);
       
        if($ret["ret"]!=0){
            $ret["ret"]=NOLOGIN;
            $ret["msg"]="not login";
            return json_encode($ret);
        }*/
        $username = "chaos";
		
		$ret=Login4Hospital::getManager($username);
         if($ret["ret"]!=0){
            $ret["ret"]=NOACCESS;
            $ret["msg"]="no ACCESS";
            return json_encode($ret);
        }
		
		$hospital_id = $ret["msg"]["hospital_id"];
		$filter=array();
		if(CUtil::getRequestParam('request', 'patient_name', "")!=""){
			$filter["patient_name"]=CUtil::getRequestParam('request', 'patient_name', "");
		}
		if(CUtil::getRequestParam('request', 'medical_id', "")!=""){
			$filter["medical_id"]=CUtil::getRequestParam('request', 'medical_id', "");
		}
		
		if(CUtil::getRequestParam('request', 'start_time', 0)!=0){
			$filter["start_time"]=CUtil::getRequestParam('request', 'start_time', 0);
		}
		
		if(CUtil::getRequestParam('request', 'end_time', 0)!=0){
			$filter["end_time"]=CUtil::getRequestParam('request', 'end_time', 0);
		}
		
		$filter["status"]=2;
        $records = HospitalizedRecord::getRecordList(0,$hospital_id,$filter,100000);
        if($ret["ret"]!=0){
            $ret["ret"]=NODATA;
            $ret["msg"]=$records;
            return json_encode($ret);
        }
        $records = $records["msg"];
		
		$obj_patients=array();
		$table=array();
		foreach ($records as $key=>$value){   
            if(array_key_exists($value["patient_id"],$obj_patients)){
                continue;
            }
            $ret=Patient4Hospital::getPatientById($value["patient_id"],$value["hospital_id"]);
            if($ret["ret"]!=0){
                continue;
            }
			$obj_patients[$value["patient_id"]]=$ret["msg"];
            $obj_patients[$value["patient_id"]]["hospital_name"]=Hospital::getHospitalById($obj_patients[$value["patient_id"]]["hospital_id"])["name"];
        }
        return self::exportExcel($obj_patients, $records);
    }
    public static function exportExcel($obj_patients, $records){
        $ret = [
            "records"=>$records,
            "patients"=>$obj_patients,
        ];
        return json_encode($ret);
    }
}