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
			if($patientInfo[":sexy"]!=1&&$patientInfo[":sexy"]!=2){
				$argErr=true; 
			}
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
		if(!CUtil::is_json($patientInfo[":relate_text"])){
            $arrArgErr["relate_text"]=$patientInfo[":relate_text"];
            $argErr=true; 
        }
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
			if($patientInfo[":sexy"]!=1&&$patientInfo[":sexy"]!=2){
				$argErr=true; 
			}
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

        if(!CUtil::is_json($patientInfo[":relate_text"])){
            $arrArgErr["relate_text"]=$patientInfo[":relate_text"];
            $argErr=true; 
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
			CUtil::logFile("no data====".print_r($ret,true));
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
		
		
		
	    if(CUtil::getRequestParam('request', 'operation_info', "")!=""&&
		CUtil::is_json(CUtil::getRequestParam('request', 'operation_info', ""))){
			$arrText[":operation_info"]=CUtil::getRequestParam('request', 'operation_info', "");
		}
		if(CUtil::getRequestParam('request', 'operation_before_info', "")!=""&&
		CUtil::is_json(CUtil::getRequestParam('request', 'operation_before_info', ""))){
			$arrText[":operation_before_info"]=CUtil::getRequestParam('request', 'operation_before_info', "");
		}
		if(CUtil::getRequestParam('request', 'operation_after_info', "")!=""&&
		CUtil::is_json(CUtil::getRequestParam('request', 'operation_after_info', ""))){
			$arrText[":operation_after_info"]=CUtil::getRequestParam('request', 'operation_after_info', "");
		}
		if(CUtil::getRequestParam('request', 'hospitalization_out_info', "")!=""&&
		CUtil::is_json(CUtil::getRequestParam('request', 'hospitalization_out_info', ""))){
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
            $ret["msg"]="ARGSERR";
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
			CUtil::logFile("not login==$username==".print_r($ret,true));
            return json_encode($ret);
        }
		$hospital_id=intval($ret["msg"]["hospital_id"]);
		$manager_id=intval($ret["msg"]["id"]);
		
		$argErr=false;
		$ids=0;
		$status=1;
		if(CUtil::getRequestParam('request', 'ids', 0)!=0){
			$ids=CUtil::getRequestParam('request', 'ids', 0);
		}else{
			$argErr=true;
		}
		if(CUtil::getRequestParam('request', 'status', 0)!=0){
			$status=CUtil::getRequestParam('request', 'status', 0);
			if($status!=2&&$status!=3){
				$argErr=true;
			}
		}else{
			$argErr=true;
		}
		if($argErr==true){
			$ret["ret"]=ARGSERR;
            $ret["msg"]="$ids $status";
			CUtil::logFile("ARGSERR==$username==$ids $status");
            return json_encode($ret);
		}
		
		
		$record=HospitalizedRecord::getRecordById($ids,$hospital_id);
        if($record["ret"]!=0){
            $ret["ret"]=NODATA;
            $ret["msg"]="no data";
			CUtil::logFile("no data=$username===".print_r($ret,true));
            return json_encode($ret);
        }
		
		if(CUtil::is_json($record["msg"]["operation_before_info"])&&
			CUtil::is_json($record["msg"]["operation_info"])&&
			CUtil::is_json($record["msg"]["operation_after_info"])&&
			CUtil::is_json($record["msg"]["hospitalization_out_info"])){
			$arrtemp1 = json_decode($record["msg"]["operation_before_info"]); 
			$arrtemp2 = json_decode($record["msg"]["operation_info"]); 
			$arrtemp3 = json_decode($record["msg"]["operation_after_info"]); 
			$arrtemp4 = json_decode($record["msg"]["hospitalization_out_info"]); 
			//CUtil::logFile(print_r( json_decode($record["msg"]["operation_before_info"]),true)."  ".count($arrtemp1)." ".count($arrtemp2)." ".count($arrtemp3)." ".count($arrtemp4)." ");
			if(count($arrtemp1)<=0||count($arrtemp2)<=0||count($arrtemp3)<=0||count($arrtemp4)<=0){
				
				$ret["ret"]=RECORDERR;
				$ret["msg"]="RECORDERR";
				CUtil::logFile("no data=$username===".print_r($record,true));
				return json_encode($ret);
			}
		}
		else{
			$ret["ret"]=RECORDERR;
            $ret["msg"]="RECORDERR";
			CUtil::logFile("no data=$username===".print_r($record,true));
            return json_encode($ret);
		}
		
		
		
		
		$idarray=array($ids);
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
		
		
		$filter["status"]=2;
		
		CUtil::logFile("$hospital_id===".print_r($filter,true));
        $records=HospitalizedRecord::getRecordList(0,$hospital_id,$filter,0);
        if($ret["ret"]!=0){
            $ret["ret"]=NODATA;
            $ret["msg"]=$records;
			CUtil::logFile("not login====".print_r($records,true));
            return json_encode($ret);
        }
		//return json_encode($records);
		
		$arrPatients=array();
		$table=array();
		foreach ($records["msg"] as $key=>$value){   
        
            if(array_key_exists($value["patient_id"],$arrPatients)){
               // CUtil::logFile("666666666666". print_r($value,true));  
                
                continue;
            }
            $fuck=Patient4Hospital::getPatientById($value["patient_id"],$value["hospital_id"]);
            if($fuck["ret"]!=0){
                continue;
            }
			$arrPatients[$value["patient_id"]]=$fuck["msg"];
            $arrPatients[$value["patient_id"]]["hospital_name"]=Hospital::getHospitalById($arrPatients[$value["patient_id"]]["hospital_id"])["name"];

           
		}
       
         CUtil::logFile(print_r($arrPatients,true));

/*
arrPatients
 (
            [id] => 48
            [hospital_id] => 2
            [medical_id] => 2
            [name] => 费如雪
            [nation] => 汉族
            [birthday] => 2018-05-16
            [province] => 河北
            [city] => 邯郸市
            [district] => 大名县
            [address] => 地瓜山
            [reason] => hello world
            [isSupply] => 0
            [relate_text] => {"姓名":"联系人2","与患者关系":"父亲","联系人电话":"96325","联系人电话-不能提供":1,"联系人电话-不能提供-原因":"根本没有电话","联系人电话(号码二)":"63333"}
            [status] => 1
            [lastmod_manager_id] => 2
            [sexy] => 2
            [createtime] => 1526477715
            [uploadtime] => 0
            [lastmodtime] => 1526552521
            [create_manager_id] => 2
            [hospital_name] => 上海交通大学医学院附属上海儿童医学中心
        )

records
(
                    [id] => 25
                    [patient_id] => 48
                    [patient_name] => 费如雪
                    [hospitalization_in_time] => 1526601600
                    [operation_time] => 1526601600
                    [hospitalization_out_time] => 1526601600
                    [operation_before_info] => {"既往心脏病手术次数":"2","既往心脏病手术时间-1":"2018-05-18","既往心脏病手术时间-2":"2018-05-18","既往心脏病手术时间-3":"2018-05-18","既往心脏病手术时间-4":"2018-05-18","既往先心病信息-其他":"aaa","身高":"","体重":"","术前血氧饱和度":"","术前血氧饱和度-不能提供-原因":"","术前血氧饱和度-右上肢":"","术前血氧饱和度-左上肢":"","术前血氧饱和度-右下肢":"","术前血氧饱和度-左下肢":"","术后血氧饱和度":"","术后血氧饱和度-不能提供-原因":"","术后血氧饱和度-右上肢":"","术后血氧饱和度-左上肢":"","术后血氧饱和度-右下肢":"","术后血氧饱和度-左下肢":"","专科检查-其他":"","术前诊断":"","术前诊断-出生胎龄":"","术前诊断-出生体重":"","术前诊断-产前明确诊断":"2","术前诊断-术前一般危险因素":"1"}
                    [operation_info] => 
                    [operation_after_info] => 
                    [hospitalization_out_info] => 
                    [createtime] => 1526583645
                    [lastmodifytime] => 1526584097
                    [hospital_id] => 2
                    [manager_id] => 2
                    [lastmodify_manager_id] => 2
                    [uploadtime] => 1526603155
                    [status] => 1
                    [medical_id] => 2
                )





*/

     
        $header = array("医院名称","上传时间","病案号","姓名","性别","民族","出生日期","省","市","县","地址","联系人姓名","与患者关系","联系人电话","其他联系电话（号码二）","其他联系电话（号码三）","入院日期","出院日期","手术日期","既往先心病手术次数","第一次既往先心病手术时间","第一次既往先心病手术医院","第一次既往先心病手术名称","第一次其他","第二次既往先心病手术时间","第二次既往先心病手术医院","第二次既往先心病手术名称","第二次其他","第三次既往先心病手术时间","第三次既往先心病手术医院","第三次既往先心病手术名称","第三次其他","第四次既往先心病手术时间","第四次既往先心病手术医院","第四次既往先心病手术名称","第四次其他","身高","体重","术前右上肢血氧饱和度","术前右下肢血氧饱和度","术前左上肢血氧饱和度","术前左下肢血氧饱和度","术后右上肢血氧饱和度","术后右下肢血氧饱和度","术后左上肢血氧饱和度","术后左下肢血氧饱和度","专科检查-MRI","专科检查-心导管","专科检查-造影","专科检查-其他","术前诊断","术前诊断-其他","出生时胎龄","出生体重","产前明确诊断","术前一般危险因素","术前一般危险因素-其他","非心脏畸形","非心脏畸形-其他","与术前诊断一致","手术诊断","手术诊断-其他","主要手术名称","主要手术名称-其他","手术医生","手术用时","手术年龄","手术状态","手术方式","手术路径","手术路径-其他","延迟关胸","延迟关胸时间","体外循环","是否计划","停搏液","停搏液类型","体外循环时间","主动脉阻断时间","二次或多次体外循环","残余畸形","增加循环辅助时间","出血","二次或多次体外循环-其他","深低温停循环","深低温停循环时间","单侧脑灌注","单侧脑灌注时间","术后住院时间","术后监护室停留时间","出监护室日期","累计有创辅助通气时间","围手术期血液制品输入","红细胞","新鲜冰冻血浆","血浆冷沉淀","血小板","自体血","术后并发症","术后并发症-其他","出院时状态","自动出院日期","自动出院主要原因","自动出院其他原因","死亡日期","死亡主要原因","其他死亡原因","治疗费用","出院备注");		
		
        $filename = '病例记录';  
      
       // CUtil::logFile(print_r($records,true));
        $table=array();
        foreach ($records["msg"] as $key=>$value){   
            $ele=array();
            $patient=$arrPatients[$value["patient_id"]];
            $ele["医院名称"]=$patient["hospital_name"];
            $ele["上传时间"]=date("Y-m-d H:i:s",intval($value["uploadtime"]));
            $ele["病案号"]=$value["medical_id"];
          
            $ele["姓名"]=$patient["name"];
            $ele["性别"]=$patient["sexy"]==1?"男":"女";
            $ele["民族"]=$patient["nation"];
            $ele["出生日期"]=$patient["birthday"];
            $ele["省"]=$patient["province"];
            $ele["市"]=$patient["city"];
            $ele["县"]=$patient["district"];
            $ele["地址"]=$patient["address"];
            $relate_text=json_decode($patient["relate_text"],true);
            foreach ($relate_text as $k=>$v){  
                $ele[$k]=$v;
            }
			
			
            $ele["入院日期"]=date("Y-m-d",intval($value["hospitalization_in_time"]));
            $ele["出院日期"]=date("Y-m-d",intval($value["hospitalization_out_time"]));
            $ele["手术日期"]=date("Y-m-d",intval($value["operation_time"]));
            $operation_before_info=json_decode($value["operation_before_info"],true);
            foreach ($operation_before_info as $k=>$v){  
                $ele[$k]=$v;
            }
			$operation_info=json_decode($value["operation_info"],true);
            foreach ($operation_info as $k=>$v){  
                $ele[$k]=$v;
            }
			$operation_after_info=json_decode($value["operation_after_info"],true);
            foreach ($operation_after_info as $k=>$v){  
                $ele[$k]=$v;
            }
			$hospitalization_out_info=json_decode($value["hospitalization_out_info"],true);
            foreach ($hospitalization_out_info as $k=>$v){  
                $ele[$k]=$v;
            }
			
			
			$table[]=$ele;
        }
        CUtil::logFile(print_r($table,true));
        $data=CUtil::createtable($table,$filename,$header); 
         exit($data);

        /*
		
		$cash=array(array('username'=>"bh",'vipnum'=>0,'mobile'=>"13590149774"));
		$filename = '提现记录'.date('YmdHis');  
		$header = array('会员','编号','联系电话');  
		$index = array('username','vipnum','mobile');  
		$data=CUtil::createtable($cash,$filename,$header,$index); 
       
        
        exit($data);*/
    }
}
