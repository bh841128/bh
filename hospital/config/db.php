<?php

//mysql -h112.74.105.107 -uroot -p123 hospital
return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=112.74.105.107;dbname=hospital',
    'username' => 'root',
    'password' => '123',
    'charset' => 'utf8',

    // Schema cache options (for production environment)
    //'enableSchemaCache' => true,
    //'schemaCacheDuration' => 60,
    //'schemaCache' => 'cache',
];
