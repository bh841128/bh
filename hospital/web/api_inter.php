<?php
namespace app\models;
defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../vendor/yiisoft/yii2/Yii.php';

$config = require __DIR__ . '/../config/web.php';
use Yii;
use app\models\CUtil;
CUtil::checkMobile("111");
exit;
$ret_check_login = Hospital::checkLogin();
print_r($ret_check_login);