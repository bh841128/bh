<?php
namespace app\models;
use Yii;
use app\models\CUtil;
CUtil::checkMobile("111");
exit;
$ret_check_login = Hospital::checkLogin();
print_r($ret_check_login);