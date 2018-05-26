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
        $excel_header_config = [
            "医院名称"      =>  "患者资料.hospital_name",
            "上传时间"      =>["format_date", "住院记录.uploadtime"],
            "病案号"        =>"患者资料.medical_id",
            "姓名"          =>"患者资料.姓名",
            "性别"          =>["format_xingbie", "患者资料.sexy"],
            "民族"          =>"患者资料.nation",
            "出生日期"      =>"患者资料.birthday",
            "省"            =>"患者资料.province",
            "市"            =>"患者资料.city",
            "县"            =>"患者资料.district",
            "地址"          =>"患者资料.address",
            "联系人姓名"    =>"联系人资料.联系人姓名",
            "与患者关系"    =>"联系人资料.与患者关系",
            "联系人电话"    =>"联系人资料.联系人电话",
            "其他联系电话（号码二）" =>"联系人资料.其他联系电话（号码二）",
            "其他联系电话（号码三）" =>"联系人资料.其他联系电话（号码三）",
            "入院日期"              =>["format_date", "住院记录.hospitalization_in_time"],
            "出院日期"              =>["format_date", "住院记录.hospitalization_out_time"],
            "手术日期"              =>["format_date", "住院记录.operation_time"],
            "既往先心病手术次数"=>"",
            "第一次既往先心病手术时间"=>"",
            "第一次既往先心病手术医院"=>"",
            "第一次既往先心病手术名称"=>"",
            "第一次其他"=>"",
            "第二次既往先心病手术时间"=>"",
            "第二次既往先心病手术医院"=>"",
            "第二次既往先心病手术名称"=>"",
            "第二次其他"=>"",
            "第三次既往先心病手术时间"=>"",
            "第三次既往先心病手术医院"=>"",
            "第三次既往先心病手术名称"=>"",
            "第三次其他"=>"",
            "第四次既往先心病手术时间"=>"",
            "第四次既往先心病手术医院"=>"",
            "第四次既往先心病手术名称"=>"",
            "第四次其他"=>"",
            "身高"=>"",
            "体重"=>"",
            "术前右上肢血氧饱和度"=>"",
            "术前右下肢血氧饱和度"=>"",
            "术前左上肢血氧饱和度"=>"",
            "术前左下肢血氧饱和度"=>"",
            "术后右上肢血氧饱和度"=>"",
            "术后右下肢血氧饱和度"=>"",
            "术后左上肢血氧饱和度"=>"",
            "术后左下肢血氧饱和度"=>"",
            "专科检查-MRI"=>"",
            "专科检查-心导管"=>"",
            "专科检查-造影"=>"",
            "专科检查-其他"=>"",
            "术前诊断"=>"",
            "术前诊断-其他"=>"",
            "出生时胎龄"=>"",
            "出生体重"=>"",
            "产前明确诊断"=>"",
            "术前一般危险因素"=>"",
            "术前一般危险因素-其他"=>"",
            "非心脏畸形"=>"",
            "非心脏畸形-其他"=>"",
            "与术前诊断一致"=>"",
            "手术诊断"=>"",
            "手术诊断-其他"=>"",
            "主要手术名称"=>"",
            "主要手术名称-其他"=>"",
            "手术医生"=>"",
            "手术用时"=>"",
            "手术年龄"=>"",
            "手术状态"=>"",
            "手术方式"=>"",
            "手术路径"=>"",
            "手术路径-其他"=>"",
            "延迟关胸"=>"",
            "延迟关胸时间"=>"",
            "体外循环"=>"",
            "是否计划"=>"",
            "停搏液"=>"",
            "停搏液类型"=>"",
            "体外循环时间"=>"",
            "主动脉阻断时间"=>"",
            "二次或多次体外循环"=>"",
            "残余畸形"=>"",
            "增加循环辅助时间"=>"",
            "出血"=>"",
            "二次或多次体外循环-其他"=>"",
            "深低温停循环"=>"",
            "深低温停循环时间"=>"",
            "单侧脑灌注"=>"",
            "单侧脑灌注时间"=>"",
            "术后住院时间"=>"",
            "术后监护室停留时间"=>"",
            "出监护室日期"=>"",
            "累计有创辅助通气时间"=>"",
            "围手术期血液制品输入"=>"",
            "红细胞"=>"",
            "新鲜冰冻血浆"=>"",
            "血浆冷沉淀"=>"",
            "血小板"=>"",
            "自体血"=>"",
            "术后并发症"=>"",
            "术后并发症-其他"=>"",
            "出院时状态"=>"",
            "自动出院日期"=>"",
            "自动出院主要原因"=>"",
            "自动出院其他原因"=>"",
            "死亡日期"=>"",
            "死亡主要原因"=>"",
            "其他死亡原因"=>"",
            "治疗费用"=>"",
            "出院备注"=>"",
        ];
        $excel_values = [];

        header("Content-type:text/html;charset=utf-8");
        for ($i = 0; $i < count($records); $i++){
            $record = $records[$i];
            $data = [];
            $data["患者资料"] = $obj_patients[$record["patient_id"]];
            $data["联系人资料"] = json_decode($data["患者资料"]["relate_text"], true);
            $data["住院记录"] = $record;
            $data["住院记录"]["术前信息"] = json_decode($data["住院记录"]["operation_before_info"], true);
            $data["住院记录"]["手术信息"] = json_decode($data["住院记录"]["operation_info"], true);
            $data["住院记录"]["术后信息"] = json_decode($data["住院记录"]["operation_after_info"], true);
            $data["住院记录"]["出院资料"] = json_decode($data["住院记录"]["hospitalization_out_info"], true);
            
            $excel_row = [];
            echo json_encode($data,true);
            foreach($excel_header_config as $excel_field => $data_source){
                $excel_row[$excel_field] = self::getDataValue($data, $excel_field, $data_source);
            }
            
            $excel_values[] = $excel_row;
        }
        $excel_headers=array_keys($excel_header_config);

        
        $data=self::createtable($excel_values, '住院记录', $excel_headers); 
        exit($data);
    }
    static public function getDataValue($record, $excel_field, $data_source){
        if (is_string($data_source)){
            $value = self::getValueByJsonPath($record, $data_source);;
            echo $data_source."  ".$value.PP_EOL;
            return $value;
        }
        return "";
    }
    static public function getValueByJsonPath($record, $json_path){
        $arrPaths = explode(".", $json_path);
        $tmp_record = $record;
        for ($i = 0; $i < count($arrPaths); $i++){
            $field = $arrPaths[$i];
            if ($field == "" || empty($tmp_record[$field])){
                return "";
            }
            $tmp_record = $tmp_record[$field];
        }
        return $tmp_record;
    }
    static public function createtable($list,$filename,$excel_headers){    
        //header("Content-type:application/vnd.ms-excel;charset=utf-8");
		//header("Content-Disposition:filename=".$filename.".xls");
		$strexport='<html xmlns:x="urn:schemas-microsoft-com:office:excel"><body><table>';
		$strexport.="<tr>";
		foreach($excel_headers as $value){
			$strexport.="<td x:str>";
			$strexport.=$value;
			$strexport.="</td>";
		}
		$strexport.="</tr>";
		
		foreach ($list as $row){
			$strexport.="<tr>";	
			foreach($excel_headers as $value){
                if(array_key_exists($value,$row)){
					$temp=$row[$value];
					$str="";
					if(is_array($temp)){
						foreach($temp as $k=>$v) {
							foreach($v as $k1=>$v1){
								$str=$str.$v1.";";
							}
						}
 
					}else{
						$str=$row[$value];
					}
					$strexport.="<td style=\"vnd.ms-excel.numberformat:@\">";
					$strexport.=$str;
					$strexport.="</td>";
				}
				else{
					$strexport.="<td x:str>";
					$strexport.=$str;
					$strexport.="</td>";
				}				 
					    
			}  
			$strexport.="</tr>"; 
	  
		}	
		return $strexport;     
	}   
}