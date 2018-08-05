<?php
use yii\mongodb\Connection;


return [
    'components' => [
        'db' => [
            'class' => yii\mongodb\Connection::className(),
            'dsn' => 'mongodb://root:tgEm8ZObfIpzXY2bNBSl@ds159121.mlab.com:59121/task',
        ],
    ],
];


/*
return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mongodb://root:tgEm8ZObfIpzXY2bNBSl@ds159121.mlab.com:59121/task',

];
*/
