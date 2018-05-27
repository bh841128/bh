<?php
namespace app\models;

use Yii;
use app\models\CUtil;
use app\models\Login4Hospital;
use app\models\Patient4Hospital;
use app\models\HospitalizedRecord;

class Hospital
{
    public $id;
    public $username;
    public $password;
    public $authKey;
    public $accessToken;

    private static $m_hospitals = [
        ["name"=>"中国医学科学院阜外医院","id"=>"1"],
		["name"=>"上海交通大学医学院附属上海儿童医学中心","id"=>"2"],
		["name"=>"复旦大学附属儿科医院","id"=>"3"],
		["name"=>"中南大学湘雅二医院","id"=>"4"],
		["name"=>"南京市儿童医院","id"=>"5"],
		["name"=>"青岛市妇女儿童医院","id"=>"6"],
		["name"=>"河南省人民医院","id"=>"7"],
		["name"=>"广州市妇女儿童医疗中心","id"=>"8"],
		["name"=>"中国人民解放军第四军医大学第一附属医院","id"=>"9"],
		["name"=>"中国人民解放军第三军医大学","id"=>"10"],
    ];

	public static function getHospitalById($id){
		for ($i = 0; $i < count(self::$m_hospitals); $i++){
			if (self::$m_hospitals[$i]["id"] == $id){
				return self::$m_hospitals[$i];
			}
		}
		return false;
	}
	public static function getHospitalByName($name){
		for ($i = 0; $i < count(self::$m_hospitals); $i++){
			if (self::$m_hospitals[$i]["name"] == $name){
				return self::$m_hospitals[$i];
			}
		}
		return false;
	}

	public static function getAllHospitals(){
		return self::$m_hospitals;
	}

	public static function checkLogin(){
		$ret_client = ["ret"=>0, "msg"=>"OK", "data"=>""];
		$username = CUtil::getRequestParam('cookie', 'username', '');
        $skey = CUtil::getRequestParam('cookie', 'skey', '');
		$ret=Login4Hospital::checkLogin($username,$skey);
		if($ret["ret"]!=0){
			$ret_client["ret"] = $ret["ret"];
			$ret_client["msg"] = "need login";
			return $ret_client;
		}
		$hospital_name = "";
		$hospital_id   = 0;
		$ret=Login4Hospital::getManager($username);
		if ($ret["ret"] == 0){
			$hospital = $ret["msg"]["hospital"];
			$hospital_id = intval($hospital["id"]);
			$hospital_name = $hospital["name"];
		}
		$ret_client["data"] = ["user_name"=>$username, "hospital_name"=>$hospital_name, "hospital_id"=>"$hospital_id"];
		return $ret_client;
	}

	//病人基本信息和某个住院记录
	public static function getPatientAndZhuyuanjilu($patient_id, $zyjl_id){
		$ret_client = ["ret"=>0, "msg"=>"OK", "data"=>["patient"=>[],"zhuyuanjilu"=>[]]];

		$username = CUtil::getRequestParam('cookie', 'username', '');
		$ret=Login4Hospital::getManager($username);
		if ($ret["ret"] != 0){
			return ["ret"=>99, "msg"=>"拉取数据错误，请稍候再试"];
		}
		$hospital_id = $ret["msg"]["hospital_id"];
		$ret=Patient4Hospital::getPatientById($patient_id,$hospital_id);
		if ($ret["ret"] != 0){
			return ["ret"=>99, "msg"=>"拉取数据错误，请稍候再试"];
		}
		$ret_client["data"]["patient"] = $ret["msg"];
		$ret=HospitalizedRecord::getRecordById($id,$ret["msg"]["hospital_id"]);
		if ($ret["ret"] != 0){
			return ["ret"=>99, "msg"=>"拉取数据错误，请稍候再试"];
		}
		$ret_client["data"]["zhuyuanjilu"] = $ret["msg"];
		return $ret_client;
	}
}