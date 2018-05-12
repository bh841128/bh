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
define("ARGSERR", 4);
define("INSERTERR", 5);
define("UPDATEERR", 6);



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
        $ret=Patient4Hospital::getPatientList($page,$hospital_id,$filter,$size);
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
		//:hospital_id,:medical_id,:name,:nation,:birthday,:province,:city,:distinct,:address,:reason,:isSupply,:relate_text,
		//:status,:lastmod_manager_id,:sexy,:createtime,:uploadtime,:lastmodtime,:create_manager_id
		$patientInfo=array();
		$now=time(0);
		CUtil::logFile("222222====".print_r($ret,true));
		$patientInfo[":hospital_id"]=intval($ret["msg"]["hospital_id"]);
		$patientInfo[":create_manager_id"]=intval($ret["msg"]["id"]);
		$patientInfo[":lastmod_manager_id"]=intval($ret["msg"]["id"]);
		$patientInfo[":status"]=1;
		$patientInfo[":createtime"]=$now;
		$patientInfo[":lastmodtime"]=$now;
		$patientInfo[":uploadtime"]=0;
		
		$argErr=false;
		
		if(CUtil::getRequestParam('request', 'medical_id', "")!=""){
			$patientInfo[":medical_id"]=CUtil::getRequestParam('request', 'medical_id', "");
		}
		else{
			$argErr=true; 
		}
		
		if(CUtil::getRequestParam('request', 'sexy', 0)!=0){
			$patientInfo[":sexy"]=CUtil::getRequestParam('request', 'sexy', 0);
		}
		else{
			$argErr=true; 
		}
		
		if(CUtil::getRequestParam('request', 'name', "")!=""){
			$patientInfo[":name"]=CUtil::getRequestParam('request', 'name', "");
		}
		else{
			$argErr=true; 
		}
		if(CUtil::getRequestParam('request', 'nation', "")!=""){
			$patientInfo[":nation"]=CUtil::getRequestParam('request', 'nation', "");
		}
		else{
			$argErr=true; 
		}
		if(CUtil::getRequestParam('request', 'birthday', "")!=""){
			$patientInfo[":birthday"]=CUtil::getRequestParam('request', 'birthday', "");
		}
		else{
			$argErr=true; 
		}
		if(CUtil::getRequestParam('request', 'isSupply', 0)!=0){//不提供啦
			$patientInfo[":isSupply"]=CUtil::getRequestParam('request', 'isSupply', 0);
			if(CUtil::getRequestParam('request', 'reason', "")!=""){//不提供就要有reason
				$patientInfo[":reason"]=CUtil::getRequestParam('request', 'reason', "");
			}
			else{
				$argErr=true; 
			}
		}
		else{//提供地址就得他妈的得有
			if(CUtil::getRequestParam('request', 'province', "")!=""&&
				CUtil::getRequestParam('request', 'city', "")!=""&&
				CUtil::getRequestParam('request', 'district', "")!=""&&
				CUtil::getRequestParam('request', 'address', "")!=""
			   )
			{//不提供就要有reason
                $patientInfo[":isSupply"]=0;
				$patientInfo[":province"]=CUtil::getRequestParam('request', 'province', "");
				$patientInfo[":city"]=CUtil::getRequestParam('request', 'city', "");
				$patientInfo[":district"]=CUtil::getRequestParam('request', 'district', "");
				$patientInfo[":address"]=CUtil::getRequestParam('request', 'address', "");
			}
			else{
				$argErr=true; 
			}
			
		}
		
		$patientInfo[":relate_text"]=CUtil::getRequestParam('request', 'relate_text', "");
		
		if($argErr==true){
			$ret["ret"]=ARGSERR;
            $ret["msg"]=$patientInfo;
			CUtil::logFile("ARGSERR====".print_r($patientInfo,true));
            return json_encode($ret);
		}
		CUtil::logFile("ARGS OK====".print_r($patientInfo,true));
		$ret=Patient4Hospital::insertPatientInfo($patientInfo);
		if($ret["ret"]!=0){
            $ret["ret"]=INSERTERR;
            $ret["msg"]=$patientInfo;
			CUtil::logFile("INSERTERR====".print_r($ret,true));
            return json_encode($ret);
        }
		return json_encode($ret);
	}

	public function actionUpdatePatient()
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
		
		//拉取数据by id
		$id=CUtil::getRequestParam('request', 'id', 0);
		
		$result=Patient4Hospital::getPatientById($id,$ret["msg"]["hospital_id"]);
		if($result["ret"]!=0){
			CUtil::logFile("NODATA====".print_r($result,true));
            $result["ret"]=NODATA;
            $result["msg"]="NODATA";
            return json_encode($result);
        }
		
		
		
		$patientInfo=array();
		
		
			//:hospital_id,:medical_id,:name,:nation,:birthday,:province,:city,:distinct,:address,:reason,:isSupply,:relate_text,
		//:status,:lastmod_manager_id,:sexy,:createtime,:uploadtime,:lastmodtime,:create_manager_id
		
		$now=time(0);
		
		//$patientInfo[":id"]=$id;

		$patientInfo[":lastmod_manager_id"]=$ret["msg"]["id"];
		$patientInfo[":lastmodtime"]=$now;

		
		
		//$patientInfo[":hospital_id"]=$ret["msg"]["hospital_id"];
		//$patientInfo[":create_manager_id"]=$ret["msg"]["id"];
		//$patientInfo[":status"]=1;
		//$patientInfo[":createtime"]=$now;
		
		//$patientInfo[":uploadtime"]=0;
		
		$argErr=false;
		
		
		
		if(CUtil::getRequestParam('request', 'medical_id', "")!=""){
			$patientInfo[":medical_id"]=CUtil::getRequestParam('request', 'medical_id', "");
		}
		else{
			$argErr=true; 
		}
		
		if(CUtil::getRequestParam('request', 'sexy', 0)!=0){
			$patientInfo[":sexy"]=CUtil::getRequestParam('request', 'sexy', 0);
		}
		else{
			$argErr=true; 
		}
		
		if(CUtil::getRequestParam('request', 'name', "")!=""){
			$patientInfo[":name"]=CUtil::getRequestParam('request', 'name', "");
		}
		else{
			$argErr=true; 
		}
		if(CUtil::getRequestParam('request', 'nation', "")!=""){
			$patientInfo[":nation"]=CUtil::getRequestParam('request', 'nation', "");
		}
		else{
			$argErr=true; 
		}
		if(CUtil::getRequestParam('request', 'birthday', "")!=""){
			$patientInfo[":birthday"]=CUtil::getRequestParam('request', 'birthday', "");
		}
		else{
			$argErr=true; 
		}
		if(CUtil::getRequestParam('request', 'isSupply', 0)!=0){//不提供啦
			$patientInfo[":isSupply"]=CUtil::getRequestParam('request', 'isSupply', 0);
			if(CUtil::getRequestParam('request', 'reason', "")!=""){//不提供就要有reason
				$patientInfo[":reason"]=CUtil::getRequestParam('request', 'reason', "");
			}
			else{
				$argErr=true; 
			}
		}
		else{//提供地址就得他妈的得有
			if(CUtil::getRequestParam('request', 'province', "")!=""&&
				CUtil::getRequestParam('request', 'city', "")!=""&&
				CUtil::getRequestParam('request', 'district', "")!=""&&
				CUtil::getRequestParam('request', 'address', "")!=""
			   )
			{//不提供就要有reason
				$patientInfo[":province"]=CUtil::getRequestParam('request', 'province', "");
				$patientInfo[":city"]=CUtil::getRequestParam('request', 'city', "");
				$patientInfo[":district"]=CUtil::getRequestParam('request', 'district', "");
				$patientInfo[":address"]=CUtil::getRequestParam('request', 'address', "");
			}
			else{
				$argErr=true; 
			}
			
		}
		
		$patientInfo[":relate_text"]=CUtil::getRequestParam('request', 'relate_text', "");
		
		if($argErr==true){
			$ret["ret"]=ARGSERR;
            $ret["msg"]=$patientInfo;
			CUtil::logFile("ARGSERR====".print_r($patientInfo,true));
            return json_encode($ret);
		}
		CUtil::logFile("ARGS OK====".print_r($patientInfo,true));
		$ret=Patient4Hospital::updatePatientInfo($id,$patientInfo);
		if($ret["ret"]!=0){
            $ret["ret"]=UPDATEERR;
            $ret["msg"]=$patientInfo;
			CUtil::logFile("UPDATEERR====".print_r($ret,true));
            return json_encode($ret);
        }
		return json_encode($ret);
	}
}
