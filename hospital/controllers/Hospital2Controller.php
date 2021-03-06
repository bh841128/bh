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

    ///////////////////////////////////////////////////////////////////////
    function actionExportExcel(){
        $username = CUtil::getRequestParam('cookie', 'username', '');
        $skey = CUtil::getRequestParam('cookie', 'skey', '');
        $ret=Login4Hospital::checkLogin($username,$skey);
       
        if($ret["ret"]!=0){
            $ret["ret"]=NOLOGIN;
            $ret["msg"]="not login";
            return json_encode($ret);
        }
		
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
            //基本资料
            "医院名称"      =>  "患者资料.hospital_name",
            "上传时间"      =>  ["format_date_time", "住院记录.uploadtime"],
            "病案号"        =>  "患者资料.medical_id",
            "姓名"          =>  "患者资料.name",
            "性别"          =>  ["format_xingbie", "患者资料.sexy"],
            "民族"          =>  "患者资料.nation",
            "出生日期"      =>  "患者资料.birthday",
            "省"            =>  "患者资料.province",
            "市"            =>  "患者资料.city",
            "县"            =>  "患者资料.district",
            "地址"          =>  "患者资料.address",
            "联系人姓名"     =>  "联系人资料.联系人姓名",
            "与患者关系"     =>  "联系人资料.与患者关系",
            "联系人电话"     =>  "联系人资料.联系人电话",
            "其他联系电话（号码二）" =>"联系人资料.联系人电话(号码二)",
            "其他联系电话（号码三）" =>"联系人资料.联系人电话(号码三)",

            //入院 收入 出院日期
            "入院日期"              =>["format_date", "住院记录.hospitalization_in_time"],
            "出院日期"              =>["format_date", "住院记录.hospitalization_out_time"],
            "手术日期"              =>["format_date", "住院记录.operation_time"],

            //术前信息
            "既往先心病手术次数"=>"住院记录.术前信息.既往心脏病手术次数",
            "第一次既往先心病手术时间"=>"住院记录.术前信息.既往心脏病手术时间-1",
            "第一次既往先心病手术医院"=>"住院记录.术前信息.既往心脏病手术医院-1",
            "第一次既往先心病手术名称"=>"住院记录.术前信息.既往心脏病手术名称-1",
            "第一次其他"=>"",
            "第二次既往先心病手术时间"=>"住院记录.术前信息.既往心脏病手术时间-2",
            "第二次既往先心病手术医院"=>"住院记录.术前信息.既往心脏病手术医院-2",
            "第二次既往先心病手术名称"=>"住院记录.术前信息.既往心脏病手术名称-2",
            "第二次其他"=>"",
            "第三次既往先心病手术时间"=>"住院记录.术前信息.既往心脏病手术时间-3",
            "第三次既往先心病手术医院"=>"住院记录.术前信息.既往心脏病手术医院-3",
            "第三次既往先心病手术名称"=>"住院记录.术前信息.既往心脏病手术名称-3",
            "第三次其他"=>"",
            "第四次既往先心病手术时间"=>"住院记录.术前信息.既往心脏病手术时间-4",
            "第四次既往先心病手术医院"=>"住院记录.术前信息.既往心脏病手术医院-4",
            "第四次既往先心病手术名称"=>"住院记录.术前信息.既往心脏病手术名称-4",
            "第四次其他"=>"",
            "身高"=>"住院记录.术前信息.身高    厘米",
            "体重"=>"住院记录.术前信息.体重    千克",
            "术前血氧饱和度"=>"住院记录.术前信息.术前血氧饱和度    %",
            "术前右上肢血氧饱和度"=>"住院记录.术前信息.术前血氧饱和度-右上肢    %",
            "术前右下肢血氧饱和度"=>"住院记录.术前信息.术前血氧饱和度-右下肢    %",
            "术前左上肢血氧饱和度"=>"住院记录.术前信息.术前血氧饱和度-左上肢    %",
            "术前左下肢血氧饱和度"=>"住院记录.术前信息.术前血氧饱和度-左下肢    %",
            "术后血氧饱和度"=>"住院记录.术前信息.术后血氧饱和度    %",
            "术后右上肢血氧饱和度"=>"住院记录.术前信息.术后血氧饱和度-右上肢    %",
            "术后右下肢血氧饱和度"=>"住院记录.术前信息.术后血氧饱和度-右下肢    %",
            "术后左上肢血氧饱和度"=>"住院记录.术前信息.术后血氧饱和度-左上肢    %",
            "术后左下肢血氧饱和度"=>"住院记录.术前信息.术后血氧饱和度-左下肢    %",
            "专科检查-MRI"=>["has_not","住院记录.术前信息.专科检查-MRI"],
            "专科检查-心导管"=>["has_not","住院记录.术前信息.专科检查-心导管"],
            "专科检查-造影"=>["has_not","住院记录.术前信息.专科检查-造影"],
            "其他专科检查"=>"住院记录.术前信息.专科检查-其他",
            "术前诊断"=>["format_2level_data", "住院记录.术前信息.术前诊断"],
            "其他术前诊断"=>"住院记录.术前信息.术前诊断-其他",
            "出生时胎龄"=>"住院记录.术前信息.专科检查-出生胎龄    周",
            "出生体重"=>"住院记录.术前信息.专科检查-出生体重    千克",
            "产前明确诊断"=>"住院记录.术前信息.专科检查-产前明确诊断",
            "术前一般危险因素"=>["format_2level_data", "住院记录.术前信息.术前一般危险因素"],
            "其他术前一般危险因素"=>"住院记录.术前信息.术前一般危险因素-其他",
            "非心脏畸形"=>["format_2level_data", "住院记录.术前信息.非心脏畸形"],
            "其他非心脏畸形"=>"住院记录.术前信息.非心脏畸形-其他",

            //手术信息
            "手术诊断"=>["format_2level_data", "住院记录.手术信息.手术诊断"],
            "与术前诊断一致"=>["yes_no2","住院记录.手术信息.与术前诊断一致"],
            "其他手术诊断"=>"住院记录.手术信息.手术诊断-其他",
            "主要手术名称"=>["format_2level_data", "住院记录.手术信息.主要手术名称"],
            "其他主要手术名称"=>"住院记录.手术信息.主要手术名称-其他",
            "手术医生"=>"住院记录.手术信息.手术医生",
            "手术用时"=>"住院记录.手术信息.手术用时    分钟",
            "手术年龄"=>"住院记录.手术信息.手术年龄    岁/月",
            "手术状态"=>"住院记录.手术信息.手术状态",
            "手术方式"=>"住院记录.手术信息.手术方式",
            "手术路径"=>"住院记录.手术信息.手术路径",
            "其他手术路径"=>"住院记录.手术信息.手术路径-其他",
            "延迟关胸"=>["yes_no2","住院记录.手术信息.延迟关胸"],
            "延迟关胸时间"=>"住院记录.手术信息.延迟关胸时间    天",
            "体外循环"=>["yes_no2","住院记录.手术信息.体外循环"],
            "体外循环是否计划"=>"住院记录.手术信息.是否计划",
            "停搏液"=>["yes_no2","住院记录.手术信息.停搏液"],
            "停搏液类型"=>"住院记录.手术信息.停搏液类型",
            "停搏液温度"=>"住院记录.手术信息.停搏液温度",
            "体外循环时间"=>"住院记录.手术信息.体外循环时间    分钟",
            "主动脉阻断时间"=>"住院记录.手术信息.主动脉阻断时间    分钟",
            "二次或多次体外循环"=>["yes_no2","住院记录.手术信息.是否二次或多次体外循环"],
            "二次或多次体外循环原因"=>"住院记录.手术信息.是否二次或多次体外循环-原因",
            "深低温停循环"=>["yes_no2","住院记录.手术信息.深低温停循环"],
            "深低温停循环时间"=>"住院记录.手术信息.深低温停循环时间    分钟",
            "单侧脑灌注"=>["yes_no2","住院记录.手术信息.单侧脑灌注"],
            "单侧脑灌注时间"=>"住院记录.手术信息.单侧脑灌注时间    分钟",


            //术后信息
            "术后住院时间"=>"住院记录.术后信息.术后住院时间    天",
            "术后监护室停留时间"=>"住院记录.术后信息.术后监护室停留时间    天",
            "出监护室日期"=>"住院记录.术后信息.出监护室日期",
            "累计有创辅助通气时间"=>"住院记录.术后信息.累计有创辅助通气时间    小时",
            "围手术期血液制品输入"=>["yes_no2","住院记录.术后信息.围手术期血液制品输入（累计）"],
            "红细胞"=>"住院记录.术后信息.红细胞    单位",
            "新鲜冰冻血浆"=>"住院记录.术后信息.新鲜冰冻血浆    毫升",
            "血浆冷沉淀"=>"住院记录.术后信息.血浆冷沉淀    单位",
            "血小板"=>"住院记录.术后信息.血小板    单位",
            "自体血"=>"住院记录.术后信息.自体血    毫升",
            "术后并发症"=>["format_2level_data", "住院记录.术后信息.术后并发症"],
            "其他术后并发症"=>"住院记录.术后信息.术后并发症-其他",

            //出院资料
            "出院时状态"=>"住院记录.出院资料.出院时状态",
            "自动出院日期"=>"住院记录.出院资料.自动出院日期",
            "自动出院主要原因"=>"住院记录.出院资料.自动出院主要原因",
            "自动出院其他原因"=>"住院记录.出院资料.自动出院其他原因",
            "死亡日期"=>"住院记录.出院资料.死亡日期",
            "死亡主要原因"=>"住院记录.出院资料.死亡主要原因",
            "其他死亡原因"=>"住院记录.出院资料.其他死亡原因",
            "治疗费用"=>"住院记录.出院资料.治疗费用    元",
            "出院备注"=>"住院记录.出院资料.出院备注",
        ];

        $excel_values = [];
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
            unset($data["患者资料"]["relate_text"]);
            unset($data["住院记录"]["operation_before_info"]);
            unset($data["住院记录"]["operation_info"]);
            unset($data["住院记录"]["operation_after_info"]);
            unset($data["住院记录"]["hospitalization_out_info"]);
            self::preProcessData($data);
            
            $excel_row = [];
            foreach($excel_header_config as $excel_field => $data_source){
                $excel_row[$excel_field] = self::getDataValue($data, $excel_field, $data_source);
            }
            
            $excel_values[] = $excel_row;
        }
        $excel_headers = [];
        foreach($excel_header_config as $field => $data_source){
            $head = $field;
            if (is_array($data_source)){
                $data_source = $data_source[1];
            }
            if (preg_match('/    /',$data_source)){
                $post_fix    = preg_replace('/.*    /','',$data_source);
                $head .= "($post_fix)";
            }
            $excel_headers[] = $head;
        }
        $excel_fields = array_keys($excel_header_config);
        $data=self::createtable($excel_values, '住院记录', $excel_fields, $excel_headers); 
        exit($data);
    }
    static public function preProcessData(&$record){
        $data_inputs = &$record["住院记录"]["术前信息"];
        //术前信息
        for ($i = 1; $i <= $data_inputs["既往心脏病手术次数"]; $i++){
            if ($data_inputs["既往心脏病手术时间-不能提供-".$i] > 0){
                $data_inputs["既往心脏病手术时间-".$i] = "";
            }
            if ($data_inputs["既往心脏病手术医院-不能提供-".$i] > 0){
                $data_inputs["既往心脏病手术医院-".$i] = "";
            }
            if ($data_inputs["既往心脏病手术名称-不能提供-".$i] > 0){
                $data_inputs["既往心脏病手术名称-".$i] = "";
            }
        }
        for ($i = $data_inputs["既往心脏病手术次数"]+1; $i <= 4; $i++){
            $data_inputs["既往心脏病手术时间-不能提供-".$i] = "";
            $data_inputs["既往心脏病手术时间-".$i] = "";
            $data_inputs["既往心脏病手术医院-不能提供-".$i] = "";
            $data_inputs["既往心脏病手术医院-".$i] = "";
            $data_inputs["既往心脏病手术名称-不能提供-".$i] = "";
            $data_inputs["既往心脏病手术名称-".$i] = "";
        }
        if ($data_inputs["术前血氧饱和度-不能提供"] == 0){
            $data_inputs["术前血氧饱和度-不能提供-原因"] = "";
        }
        else{
            $data_inputs["术前血氧饱和度"] = "";
            $data_inputs["术前血氧饱和度-右上肢"] = "";
            $data_inputs["术前血氧饱和度-左上肢"] = "";
            $data_inputs["术前血氧饱和度-右下肢"] = "";
            $data_inputs["术前血氧饱和度-左下肢"] = "";
        }
        if ($data_inputs["术后血氧饱和度-不能提供"] == 0){
            $data_inputs["术后血氧饱和度-不能提供-原因"] = "";
        }
        else{
            $data_inputs["术后血氧饱和度"] = "";
            $data_inputs["术后血氧饱和度-右上肢"] = "";
            $data_inputs["术后血氧饱和度-左上肢"] = "";
            $data_inputs["术后血氧饱和度-右下肢"] = "";
            $data_inputs["术后血氧饱和度-左下肢"] = "";
        }
        if ($data_inputs["专科检查-是否其他"] == 0){
            $data_inputs["专科检查-其他"] = "";
        }
        if ($data_inputs["专科检查-出生胎龄-不能提供"]){
            $data_inputs["专科检查-出生胎龄"] = "";
        }
        if ($data_inputs["专科检查-术前一般危险因素"] == 0){
            $data_inputs["术前一般危险因素"] = "";
            $data_inputs["术前一般危险因素-其他"] = "";
        }
        if ($data_inputs["专科检查-非心脏畸形"] == 0){
            $data_inputs["非心脏畸形"] = "";
            $data_inputs["非心脏畸形-其他"] = "";
        }

        //手术信息
        $data_inputs = &$record["住院记录"]["手术信息"];
        if ($data_inputs["与术前诊断一致"] == 1){
            $data_inputs["手术诊断"] = "";
            $data_inputs["手术诊断-其他"] = "";
        }
        if ($data_inputs["延迟关胸"] == 0){
            $data_inputs["延迟关胸时间"] = "";
        }
        if ($data_inputs["体外循环"] == 0){
            $data_inputs["是否计划"] = "";
            $data_inputs["停搏液"] = "";
            $data_inputs["停搏液类型"] = "";
            $data_inputs["停搏液温度"] = "";
            $data_inputs["体外循环时间"] = "";
            $data_inputs["主动脉阻断时间"] = "";
            $data_inputs["主动脉阻断时间-不能提供"] = "";
            $data_inputs["主动脉阻断时间-不能提供-原因"] = "";
            $data_inputs["是否二次或多次体外循环"] = "";
            $data_inputs["是否二次或多次体外循环-原因"] = "";
        }
        else {
            if ($data_inputs["停搏液"] == 0){
                $data_inputs["停搏液类型"] = "";
                $data_inputs["停搏液温度"] = "";
            }
            if ($data_inputs["主动脉阻断时间-不能提供"] == 0){
                $data_inputs["主动脉阻断时间-不能提供-原因"] = "";
            }
            else{
                $data_inputs["主动脉阻断时间"] = "";
            }
            if ($data_inputs["是否二次或多次体外循环"] == 0){
                $data_inputs["是否二次或多次体外循环-原因"] = "";
            }
        }
        if ($data_inputs["深低温停循环"] == 0){
            $data_inputs["深低温停循环时间"] = "";
        }
        if ($data_inputs["单侧脑灌注"] == 0){
            $data_inputs["单侧脑灌注时间"] = "";
        }

        //术后信息
        $data_inputs = &$record["住院记录"]["术后信息"];
        if ($data_inputs["当天进出监护室内"] == 0){
            $data_inputs["出监护室日期"] = "";
            $data_inputs["术后监护室停留时间"] = "";
        }
        if ($data_inputs["围手术期血液制品输入（累计）"] == 0){
            $data_inputs["红细胞"] = "";
            $data_inputs["新鲜冰冻血浆"] = "";
            $data_inputs["血浆冷沉淀"] = "";
            $data_inputs["血小板"] = "";
            $data_inputs["自体血"] = "";
        }
        if ($data_inputs["是否术后并发症"] == 0){
            $data_inputs["术后并发症"] = "";
            $data_inputs["术后并发症-其他"] = "";
        }

        //出院资料
        $data_inputs = &$record["住院记录"]["出院资料"];
        if ($data_inputs["出院时状态"] == "存活"){
            $data_inputs["死亡日期"] = "";
            $data_inputs["死亡主要原因"] = "";
            $data_inputs["自动出院日期"] = "";
            $data_inputs["自动出院主要原因"] = "";
        }
        else if ($data_inputs["出院时状态"] == "死亡"){
            $data_inputs["自动出院日期"] = "";
            $data_inputs["自动出院主要原因"] = "";
        }
        else if ($data_inputs["出院时状态"] == "自动出院"){
            $data_inputs["死亡日期"] = "";
            $data_inputs["死亡主要原因"] = "";
        }
    }
    static public function getDataValue($record, $excel_field, $data_source){
        if (is_string($data_source)){
            $data_source = preg_replace('/    .*/','',$data_source);
            
            $value = self::getValueByJsonPath($record, $data_source);;
            return $value;
        }
        $func_name   = $data_source[0];
        if (!method_exists(__CLASS__, $func_name)){
            return "";
        }
        $value = self::$func_name($record, $excel_field, $data_source[1]);
        return $value;
    }
    static public function format_date($record, $excel_field, $data_source){
        $value = self::getDataValue($record, $excel_field, $data_source);
        if ($value == ""){
            return "";
        }
        $value = intval($value);
        $date = date("Y-m-d", $value);
        if ($date < "1900-01-01"){
            return "";
        }
        return $date;
    }
    static public function format_date_time($record, $excel_field, $data_source){
        $value = self::getDataValue($record, $excel_field, $data_source);
        if ($value == ""){
            return "";
        }
        $value = intval($value);
        $date = date("Y-m-d H:i:s", $value);
        if ($date < "1900-01-01 00:00:00"){
            return "";
        }
        return $date;
    }
    static public function format_xingbie($record, $excel_field, $data_source){
        $value = self::getDataValue($record, $excel_field, $data_source);
        if ($value == ""){
            return "";
        }
        $value = intval($value);
        return $value==1?"男":"女";
    }
    static public function has_not($record, $excel_field, $data_source){
        $value = self::getDataValue($record, $excel_field, $data_source);
        if (empty($value)){
            return "无";
        }
        $value = intval($value);
        return $value==0?"无":"有";
    }
    static public function yes_no($record, $excel_field, $data_source){
        $value = self::getDataValue($record, $excel_field, $data_source);
        if ($value == ""){
            return "";
        }
        if (empty($value)){
            return "否";
        }
        $value = intval($value);
        return $value==0?"否":"是";
    }
    static public function yes_no2($record, $excel_field, $data_source){
        $value = self::getDataValue($record, $excel_field, $data_source);
        if (empty($value)){
            return "否";
        }
        $value = intval($value);
        return $value==0?"否":"是";
    }
    static public function format_2level_data($record, $excel_field, $data_source){
        $datas = self::getDataValue($record, $excel_field, $data_source);
        if (empty($datas)){
            return "";
        }
        $values = [];
        for ($i = 0; $i < count($datas); $i++){
            $values[] = $datas[$i]["key1"]." ".$datas[$i]["key2"];
        }
        return join(",",$values);
    }
    //////////////////////////////////////////////////////////
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
    
    static public function createtable($list,$filename,$excel_fields, $excel_headers){    
        header("Content-type:application/vnd.ms-excel;charset=utf-8");
		header("Content-Disposition:filename=".$filename.".xls");
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
			foreach($excel_fields as $value){
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
    ///////////////////////////////////////////////////////////////////////
}