<?php
namespace app\models;
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
}