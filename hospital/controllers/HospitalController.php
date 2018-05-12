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
use yii\log\Logger;

define("NOLOGIN", 1);
define("NODATA", 2);
define("NOACCESS", 3);


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

  
	

  

    public function actionModpwd()
    {
        $username = CUtil::getRequestParam('request', 'username', '');
        $newpassword = CUtil::getRequestParam('request', 'newpassword', '');
        $oldpassword = CUtil::getRequestParam('request', 'oldpassword', '');
        
        //echo("===$username  $skey    ");
        $ret=Login4Hospital::modpassword($username,$oldpassword,$newpassword);
        CUtil::logFile("not login====".print_r($ret,true));
        return json_encode($ret);
    }

	public function actionCheckLogin()
    {
		$username = CUtil::getRequestParam('cookie', 'username', '');
		$skey = CUtil::getRequestParam('cookie', 'skey', '');
		
		//echo("===$username  $skey    ");
		$ret=Login4Hospital::checkLogin($username,$skey);
		//CUtil::logFile("not login====".print_r($ret,true));
        return json_encode($ret);
    }
	
	
	public function actionLoginin()
    {
		$username = CUtil::getRequestParam('req', 'username', '');
		$password = CUtil::getRequestParam('req', 'password', '');
		$ret=Login4Hospital::loginIn($username,$password);
		
		CUtil::logFile("not login====".print_r($ret,true));
		
        return json_encode($ret);
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
			CUtil::logFile("not login====".print_r($ret,true));
            return json_encode($ret);
        }
        $ret=Login4Hospital::getManager($username);
         if($ret["ret"]!=0){
            $ret["ret"]=NODATA;
            $ret["msg"]="no data";
			CUtil::logFile("not login====".print_r($ret,true));
            return json_encode($ret);
        }
        return json_encode($ret);
    }

	public function actionGetPatient()
    {
        $username = CUtil::getRequestParam('cookie', 'username', '');
        $id = CUtil::getRequestParam('request', 'id', 0);
        $skey = CUtil::getRequestParam('cookie', 'skey', '');
		//登录
        $ret=Login4Hospital::checkLogin($username,$skey);
        CUtil::logFile("====".print_r($ret,true));
        if($ret["ret"]!=0){
            $ret["ret"]=NOLOGIN;
            $ret["msg"]="not login";
			CUtil::logFile("not login====".print_r($ret,true));
            return json_encode($ret);
        }
		
		//获取管理人员信息
		$ret=Login4Hospital::getManager($username);
         if($ret["ret"]!=0){
            $ret["ret"]=NOACCESS;
            $ret["msg"]="no ACCESS";
			CUtil::logFile("not login====".print_r($ret,true));
            return json_encode($ret);
        }
		
		
        $ret=Patient4Hospital::getPatientById($id,$ret["msg"]["hospital_id"]);
        if($ret["ret"]!=0){
            $ret["ret"]=NODATA;
            $ret["msg"]="no data";
			CUtil::logFile("not login====".print_r($ret,true));
            return json_encode($ret);
        }
        return json_encode($ret);
    }
	
	//status  1:正常 2:上传  3：删除
	public function actionSetPatientsStatus()
    {
        $username = CUtil::getRequestParam('cookie', 'username', '');
        $ids = CUtil::getRequestParam('request', 'ids', "");
		$status = CUtil::getRequestParam('request', 'status', 0);
        $skey = CUtil::getRequestParam('cookie', 'skey', '');
		//登录
        $ret=Login4Hospital::checkLogin($username,$skey);
        if($ret["ret"]!=0){
            $ret["ret"]=NOLOGIN;
            $ret["msg"]="not login";
			CUtil::logFile("not login====".print_r($ret,true));
            return json_encode($ret);
        }
		//获取管理人员信息
		$ret=Login4Hospital::getManager($username);
         if($ret["ret"]!=0){
            $ret["ret"]=NOACCESS;
            $ret["msg"]="no ACCESS";
			CUtil::logFile("not login====".print_r($ret,true));
            return json_encode($ret);
        }
		
		$idarray=explode(",",$ids);
        $ret=Patient4Hospital::setPatientStatusByIds($idarray,$ret["msg"]["hospital_id"],$status,$ret["msg"]["id"]);
        if($ret["ret"]!=0){
            CUtil::logFile("setPatientStatusByIds err====".print_r($ret,true));
            return json_encode($ret);
        }
        return json_encode($ret);
    }

	
	public function actionGetPatientList()
    {
        $username = CUtil::getRequestParam('cookie', 'username', '');
        $skey = CUtil::getRequestParam('cookie', 'skey', '');
		//登录
        $ret=Login4Hospital::checkLogin($username,$skey);
        //CUtil::logFile("====".print_r($ret,true));
        if($ret["ret"]!=0){
            $ret["ret"]=NOLOGIN;
            $ret["msg"]="not login";
			CUtil::logFile("not login====".print_r($ret,true));
            return json_encode($ret);
        }
		//获取管理人员信息
		$ret=Login4Hospital::getManager($username);
         if($ret["ret"]!=0){
            $ret["ret"]=NOACCESS;
            $ret["msg"]="no ACCESS";
			CUtil::logFile("not login====".print_r($ret,true));
            return json_encode($ret);
        }
		
		$page = CUtil::getRequestParam('request', 'page', 0);
		$size = CUtil::getRequestParam('request', 'size', 0);
		$size = $size==0?10:$size;
		$status = CUtil::getRequestParam('request', 'status', 0);
		$hospital_id = $ret["msg"]["hospital_id"];
		
		$filter=array();
		if(CUtil::getRequestParam('request', 'name', "")!=""){
			$filter["name"]=CUtil::getRequestParam('request', 'name', "");
		}
		if(CUtil::getRequestParam('request', 'medical_id', "")!=""){
			$filter["medical_id"]=CUtil::getRequestParam('request', 'medical_id', "");
		}
		if(CUtil::getRequestParam('request', 'sexy', 0)==1||
		   CUtil::getRequestParam('request', 'sexy', 0)==2 )
		{
			$filter["sexy"]=CUtil::getRequestParam('request', 'sexy', 0);
		}
		
		if(CUtil::getRequestParam('request', 'relate_name', "")!=""){
			$filter["relate_name"]=CUtil::getRequestParam('request', 'relate_name', "");
		}
		if(CUtil::getRequestParam('request', 'relate_iphone', "")!=""&&
		    CUtil::checkMobile(CUtil::getRequestParam('request', 'relate_iphone', ""))){
			$filter["relate_iphone"]=CUtil::getRequestParam('request', 'relate_iphone', "");
		}
		
		if(CUtil::getRequestParam('request', 'start_time', 0)!=0){
			$filter["start_time"]=CUtil::getRequestParam('request', 'start_time', 0);
		}
		
			
		if(CUtil::getRequestParam('request', 'end_time', 0)!=0){
			$filter["end_time"]=CUtil::getRequestParam('request', 'end_time', 0);
		}
		
		if(CUtil::getRequestParam('request', 'status',0)==1||
		   CUtil::getRequestParam('request', 'status',0)==2||
		   CUtil::getRequestParam('request', 'status',0)==3)
		{
			
			$filter["status"]=CUtil::getRequestParam('request', 'status', 0);
		}
		
		CUtil::logFile("$page,$hospital_id===$size=".print_r($filter,true));
        $ret=Patient4Hospital::getPatientList($page,$hospital_id,$filter,$size=10);
        if($ret["ret"]!=0){
            $ret["ret"]=NODATA;
            $ret["msg"]="no data";
			CUtil::logFile("not login====".print_r($ret,true));
            return json_encode($ret);
        }
        return json_encode($ret);
    }
	
	public function actionInsertPatient()
    {
		$username = CUtil::getRequestParam('cookie', 'username', '');
        $skey = CUtil::getRequestParam('cookie', 'skey', '');
		//登录
        $ret=Login4Hospital::checkLogin($username,$skey);
        //CUtil::logFile("====".print_r($ret,true));
        if($ret["ret"]!=0){
            $ret["ret"]=NOLOGIN;
            $ret["msg"]="not login";
			CUtil::logFile("not login====".print_r($ret,true));
            return json_encode($ret);
        }
		//获取管理人员信息
		$ret=Login4Hospital::getManager($username);
         if($ret["ret"]!=0){
            $ret["ret"]=NOACCESS;
            $ret["msg"]="no ACCESS";
			CUtil::logFile("not login====".print_r($ret,true));
            return json_encode($ret);
        }
		
		
		 return json_encode($ret);
	}

}
