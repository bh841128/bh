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
use yii\log\Logger;

define("NOLOGIN", 1);
define("NODATA", 2);
define("NOACCESS", 3);
define("ARGSERR", 4);
define("INSERTERR", 5);
define("UPDATEERR", 6);
define("PATINTIDERR", 7);


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
    public function beforeAction($action) {
        Yii::$app->request->enableCsrfValidation = false;
    return parent::beforeAction($action);
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
        header("Access-Control-Allow-Origin: *");
		$username = CUtil::getRequestParam('cookie', 'username', '');
		$skey = CUtil::getRequestParam('cookie', 'skey', '');
		
		//echo("===$username  $skey    ");
		$ret=Login4Hospital::checkLogin($username,$skey);
		//CUtil::logFile("not login====".print_r($ret,true));
        return json_encode($ret);
    }
	
	public function actionLoginOut()
    {
		$ret=array(
		   "ret"=>0,
		   "msg"=>""
		);
        header("Access-Control-Allow-Origin: *");
		CUtil::setCookie("username","");
		CUtil::setCookie("skey","");
        return json_encode($ret);
    }
	
	
	public function actionLoginin()
    {
        header("Access-Control-Allow-Origin: *");
		$username = CUtil::getRequestParam('req', 'username', '');
		$password = CUtil::getRequestParam('req', 'password', '');
		
		$ret=Login4Hospital::loginIn($username,$password);
		
		CUtil::logFile("not login====".print_r($ret,true));
		
        return json_encode($ret);
    }
	
	
    public function actionGetManager()
    {
        $username = CUtil::getRequestParam('cookie', 'username', '');
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
		$ret["msg"]["password"]="";
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
			CUtil::logFile("no data====".print_r($ret,true));
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
        $ret["page"]=$page;
        $ret["size"]=$size;
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
		$arrArgErr=array();
		if(CUtil::getRequestParam('request', 'medical_id', "")!=""){
			$patientInfo[":medical_id"]=CUtil::getRequestParam('request', 'medical_id', "");
		}
		else{
			$arrArgErr["medical_id"]=CUtil::getRequestParam('request', 'medical_id', "");
			$argErr=true; 
		}
		
		if(CUtil::getRequestParam('request', 'sexy', 0)!=0){
			$patientInfo[":sexy"]=CUtil::getRequestParam('request', 'sexy', 0);
		}
		else{
			$arrArgErr["sexy"]=CUtil::getRequestParam('request', 'sexy', 0);
			$argErr=true; 
		}
		
		if(CUtil::getRequestParam('request', 'name', "")!=""){
			$patientInfo[":name"]=CUtil::getRequestParam('request', 'name', "");
		}
		else{
			$arrArgErr["name"]=CUtil::getRequestParam('request', 'name', "");
			$argErr=true; 
		}
		if(CUtil::getRequestParam('request', 'nation', "")!=""){
			$patientInfo[":nation"]=CUtil::getRequestParam('request', 'nation', "");
		}
		else{
			$arrArgErr["nation"]=CUtil::getRequestParam('request', 'nation', "");
			$argErr=true; 
		}
		if(CUtil::getRequestParam('request', 'birthday', "")!=""){
			$patientInfo[":birthday"]=CUtil::getRequestParam('request', 'birthday', "");
		}
		else{
			$arrArgErr["birthday"]=CUtil::getRequestParam('request', 'birthday', "");
			$argErr=true; 
		}
		if(CUtil::getRequestParam('request', 'isSupply', 0)==0){//不提供啦
			$patientInfo[":isSupply"]=CUtil::getRequestParam('request', 'isSupply', 0);
			if(CUtil::getRequestParam('request', 'reason', "")!=""){//不提供就要有reason
				$patientInfo[":reason"]=CUtil::getRequestParam('request', 'reason', "");
			}
			else{
				$arrArgErr["isSupply"]=CUtil::getRequestParam('request', 'isSupply', 0);
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
                $patientInfo[":isSupply"]=1;
				$patientInfo[":province"]=CUtil::getRequestParam('request', 'province', "");
				$patientInfo[":city"]=CUtil::getRequestParam('request', 'city', "");
				$patientInfo[":district"]=CUtil::getRequestParam('request', 'district', "");
				$patientInfo[":address"]=CUtil::getRequestParam('request', 'address', "");
				
				
			}
			else{
				$arrArgErr["isSupply"]=CUtil::getRequestParam('request', 'isSupply', 0);
				$arrArgErr["province"]=CUtil::getRequestParam('request', 'province', "");
				$arrArgErr["city"]=CUtil::getRequestParam('request', 'city', "");
				$arrArgErr["district"]=CUtil::getRequestParam('request', 'district', "");
				$arrArgErr["address"]=CUtil::getRequestParam('request', 'address', "");
				$argErr=true; 
			}
			
		}
		
		$patientInfo[":relate_text"]=CUtil::getRequestParam('request', 'relate_text', "");
		
		if($argErr==true){
			$ret["ret"]=ARGSERR;
            $ret["msg"]=$arrArgErr;
			CUtil::logFile("ARGSERR====".print_r($arrArgErr,true));
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
		$now=time(0);
		
		//$patientInfo[":id"]=$id;

		$patientInfo[":lastmod_manager_id"]=$ret["msg"]["id"];
		$patientInfo[":lastmodtime"]=$now;

		$argErr=false;
		$arrArgErr=array();
		if(CUtil::getRequestParam('request', 'sexy', 0)!=0){
			$patientInfo[":sexy"]=CUtil::getRequestParam('request', 'sexy', 0);
		}
		else{
			$arrArgErr["sexy"]=CUtil::getRequestParam('request', 'sexy', 0);
			$argErr=true; 
		}

		if(CUtil::getRequestParam('request', 'nation', "")!=""){
			$patientInfo[":nation"]=CUtil::getRequestParam('request', 'nation', "");
		}
		else{
			$arrArgErr["nation"]=CUtil::getRequestParam('request', 'nation', "");
			$argErr=true; 
		}
		if(CUtil::getRequestParam('request', 'birthday', "")!=""){
			$patientInfo[":birthday"]=CUtil::getRequestParam('request', 'birthday', "");
		}
		else{
			$arrArgErr["birthday"]=CUtil::getRequestParam('request', 'birthday', "");
			$argErr=true; 
		}
		if(CUtil::getRequestParam('request', 'isSupply', 0)==0){//不提供啦
			$patientInfo[":isSupply"]=CUtil::getRequestParam('request', 'isSupply', 0);
			if(CUtil::getRequestParam('request', 'reason', "")!=""){//不提供就要有reason
				$patientInfo[":reason"]=CUtil::getRequestParam('request', 'reason', "");
			}
			else{
				$arrArgErr["isSupply"]=CUtil::getRequestParam('request', 'isSupply', 0);
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
				$patientInfo[":isSupply"]=1;
			}
			else{
				$arrArgErr["isSupply"]=CUtil::getRequestParam('request', 'isSupply', 0);
				$arrArgErr["province"]=CUtil::getRequestParam('request', 'province', "");
				$arrArgErr["city"]=CUtil::getRequestParam('request', 'city', "");
				$arrArgErr["district"]=CUtil::getRequestParam('request', 'district', "");
				$arrArgErr["address"]=CUtil::getRequestParam('request', 'address', "");
				$argErr=true; 
			}
			
		}
		
		$patientInfo[":relate_text"]=CUtil::getRequestParam('request', 'relate_text', "");
		if(CUtil::getRequestParam('request', 'name', "")!=""){
            $patientInfo[":name"]=CUtil::getRequestParam('request', 'name', "");
        }
        if(CUtil::getRequestParam('request', 'medical_id', "")!=""){
            $patientInfo[":medical_id"]=CUtil::getRequestParam('request', 'medical_id', "");
        }


		if($argErr==true){
			$ret["ret"]=ARGSERR;
            $ret["msg"]=$arrArgErr;
			CUtil::logFile("ARGSERR====".print_r($arrArgErr,true));
            return json_encode($ret);
		}
		CUtil::logFile("ARGS OK====".print_r($patientInfo,true));
		$ret=Patient4Hospital::updatePatientInfo($id,$patientInfo,$ret["msg"]["hospital_id"]);
		if($ret["ret"]!=0){
            $ret["ret"]=UPDATEERR;
            $ret["msg"]=$patientInfo;
			CUtil::logFile("UPDATEERR====".print_r($ret,true));
            return json_encode($ret);
        }
		$name=trim(CUtil::getRequestParam('request', 'name', ""));
		$medical_id=trim(CUtil::getRequestParam('request', 'medical_id', ""));
		HospitalizedRecord::setPatientInfo4Record($id,$name,$medical_id);//修改病例中数据
		
		return json_encode($ret);
	}
	
	
	
	public function actionGetRecord()
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
		
		
        $ret=HospitalizedRecord::getRecordById($id,$ret["msg"]["hospital_id"]);
        if($ret["ret"]!=0){
            $ret["ret"]=NODATA;
            $ret["msg"]="no data";
			CUtil::logFile("not login====".print_r($ret,true));
            return json_encode($ret);
        }
        return json_encode($ret);
    }
	
	
	//status  1:正常 2:上传  3：删除
	public function actionSetRecordText()
    {
        $username = CUtil::getRequestParam('cookie', 'username', '');
        $id = CUtil::getRequestParam('request', 'id', 0);
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
		//operation_before_info,operation_info,operation_after_info,hospitalization_out_info
		
		
		$arrText=array();
		$arrText[":lastmodify_manager_id"]=$ret["msg"]["id"];
		
		
		if(CUtil::getRequestParam('request', 'hospitalization_in_time', 0)!=0){
			$arrText[":hospitalization_in_time"]=CUtil::getRequestParam('request', 'hospitalization_in_time', 0);
		}
		if(CUtil::getRequestParam('request', 'operation_time', 0)!=0){
			$arrText[":operation_time"]=CUtil::getRequestParam('request', 'operation_time', 0);
		}
		if(CUtil::getRequestParam('request', 'hospitalization_out_time', 0)!=0){
			$arrText[":hospitalization_out_time"]=CUtil::getRequestParam('request', 'hospitalization_out_time', 0);
		}
		
		
		
	    if(CUtil::getRequestParam('request', 'operation_info', "")!=""){
			$arrText[":operation_info"]=CUtil::getRequestParam('request', 'operation_info', "");
		}
		if(CUtil::getRequestParam('request', 'operation_before_info', "")!=""){
			$arrText[":operation_before_info"]=CUtil::getRequestParam('request', 'operation_before_info', "");
		}
		if(CUtil::getRequestParam('request', 'operation_after_info', "")!=""){
			$arrText[":operation_after_info"]=CUtil::getRequestParam('request', 'operation_after_info', "");
		}
		if(CUtil::getRequestParam('request', 'hospitalization_out_info', "")!=""){
			$arrText[":hospitalization_out_info"]=CUtil::getRequestParam('request', 'hospitalization_out_info', "");
		}
        $ret=HospitalizedRecord::setRecordText($id,$arrText,$ret["msg"]["hospital_id"]);
        if($ret["ret"]!=0){
            CUtil::logFile("setRecordText err====".print_r($ret,true));
            return json_encode($ret);
        }
        return json_encode($ret);
    }
	
	
	public function actionGetRecordList()
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
		
		if(CUtil::getRequestParam('request', 'status',0)==1||
		   CUtil::getRequestParam('request', 'status',0)==2||
		   CUtil::getRequestParam('request', 'status',0)==3)
		{
			
			$filter["status"]=CUtil::getRequestParam('request', 'status', 0);
		}
		
		CUtil::logFile("$page,$hospital_id===$size=".print_r($filter,true));
        $ret=HospitalizedRecord::getRecordList($page,$hospital_id,$filter,$size);
        if($ret["ret"]!=0){
            $ret["ret"]=NODATA;
            $ret["msg"]="no data";
			CUtil::logFile("not login====".print_r($ret,true));
            return json_encode($ret);
        }
        $ret["page"]=$page;
        $ret["size"]=$size;
        return json_encode($ret);
    }
	
	
	public function actionInsertRecord()
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
		
		
		$record=array();
		
		if(CUtil::getRequestParam('request', 'patient_id', 0)!=0){
			$record[":patient_id"]=CUtil::getRequestParam('request', 'patient_id', 0);
		}
		else{
			$ret["ret"]=ARGSERR;
            $ret["msg"]="no patient_id";
			CUtil::logFile("ARGSERR no patient_id====".print_r($record,true));
            return json_encode($ret);
		}
		
		$result=Patient4Hospital::getPatientById($record[":patient_id"],$ret["msg"]["hospital_id"]);
        if($result["ret"]!=0){
            $ret["ret"]=PATINTIDERR;
            $ret["msg"]=$result;
			CUtil::logFile("getPatientById PATINTIDERR !!====".print_r($ret,true));
            return json_encode($ret);
        }
		CUtil::logFile("ARGSERR no patient_id====".print_r($result,true));
		$now=time(0);
		CUtil::logFile("222222====".print_r($ret,true));
		$record[":hospital_id"]=intval($ret["msg"]["hospital_id"]);
		$record[":patient_id"]=intval($result["msg"]["id"]);
		$record[":patient_name"]=$result["msg"]["name"];
		$record[":medical_id"]=$result["msg"]["medical_id"];
		$record[":manager_id"]=intval($ret["msg"]["id"]);
		$record[":lastmodify_manager_id"]=intval($ret["msg"]["id"]);
		$record[":createtime"]=$now;
		$record[":lastmodifytime"]=$now;
		$argErr=false;
		if(CUtil::getRequestParam('request', 'hospitalization_in_time', 0)!=0){
			$record["hospitalization_in_time"]=CUtil::getRequestParam('request', 'hospitalization_in_time', 0);
		}else{
			$argErr=true;
		}
		if(CUtil::getRequestParam('request', 'operation_time', 0)!=0){
			$record["operation_time"]=CUtil::getRequestParam('request', 'operation_time', 0);
		}else{
			$argErr=true;
		}
		
		if(CUtil::getRequestParam('request', 'hospitalization_out_time', 0)!=0){
			$record["hospitalization_out_time"]=CUtil::getRequestParam('request', 'hospitalization_out_time', 0);
		}else{
			$argErr=true;
		}
		if($argErr==true){
			$ret["ret"]=ARGSERR;
            $ret["msg"]=$record;
			CUtil::logFile("ARGSERR====".print_r($record,true));
            return json_encode($ret);
		}
		
		
		CUtil::logFile("ARGS OK====".print_r($record,true));
		$ret=HospitalizedRecord::insertRecordInfo($record);
		if($ret["ret"]!=0){
            $ret["ret"]=INSERTERR;
            $ret["msg"]=$record;
			CUtil::logFile("INSERTERR====".print_r($ret,true));
            return json_encode($ret);
        }
		return json_encode($ret);
	}
	
	public function actionRecordsTable()
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
		$argErr=false;
		$year=0;
		if(CUtil::getRequestParam('request', 'year', 0)!=0){
			$year=CUtil::getRequestParam('request', 'year', 0);
		}else{
			$argErr=true;
		}
		if($argErr==true){
			$ret["ret"]=ARGSERR;
            
			CUtil::logFile("ARGSERR====".print_r($ret,true));
            return json_encode($ret);
		}
		CUtil::logFile("ARGS OK====".print_r($ret,true));
		$ret=HospitalizedRecord::getRecordsTable($year);
		if($ret["ret"]!=0){
            $ret["ret"]=INSERTERR;
            $ret["msg"]=$year;
			CUtil::logFile("RecordsTable====".print_r($ret,true));
            return json_encode($ret);
        }
		return json_encode($ret);
	}
	public function actionSetRecordsStatus()
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
		$hospital_id=intval($ret["msg"]["hospital_id"]);
		$manager_id=intval($ret["msg"]["id"]);
		
		$argErr=false;
		$ids="";
		$status=1;
		if(CUtil::getRequestParam('request', 'ids', "")!=""){
			$ids=CUtil::getRequestParam('request', 'ids', "");
		}else{
			$argErr=true;
		}
		if(CUtil::getRequestParam('request', 'status', 0)!=0){
			$status=CUtil::getRequestParam('request', 'status', 0);
		}else{
			$argErr=true;
		}
		if($argErr==true){
			$ret["ret"]=ARGSERR;
            $ret["msg"]="$ids $status";
			CUtil::logFile("ARGSERR====$ids $status");
            return json_encode($ret);
		}
		$idarray=explode(",",$ids);
		$ret=HospitalizedRecord::setRecordStatusByIds($idarray,$hospital_id,$status,$manager_id);
		if($ret["ret"]!=0){
            $ret["ret"]=INSERTERR;
            
			CUtil::logFile("RecordsTable====".print_r($ret,true));
            return json_encode($ret);
        }
		return json_encode($ret);
		
		
	}
	
	
	public function actionDownload()
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
		
		if(CUtil::getRequestParam('request', 'status',0)==1||
		   CUtil::getRequestParam('request', 'status',0)==2||
		   CUtil::getRequestParam('request', 'status',0)==3)
		{
			
			$filter["status"]=CUtil::getRequestParam('request', 'status', 0);
		}
		
		CUtil::logFile("$hospital_id===".print_r($filter,true));
        $records=HospitalizedRecord::getRecordList(0,$hospital_id,$filter,0);
        if($ret["ret"]!=0){
            $ret["ret"]=NODATA;
            $ret["msg"]=$records;
			CUtil::logFile("not login====".print_r($records,true));
            return json_encode($ret);
        }
		return json_encode($records);
		
		
		
		
		/*
		
		$cash=array(array('username'=>"bh",'vipnum'=>0,'mobile'=>"13590149774"));
		$filename = '提现记录'.date('YmdHis');  
		$header = array('会员','编号','联系电话');  
		$index = array('username','vipnum','mobile');  
		$data=CUtil::createtable($cash,$filename,$header,$index); 
       
        
        exit($data);*/
    }
}
