<?php

$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'timeZone'=>'America/Bogota',
    'language' => 'es-ES',
    'components' => [
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
            'itemTable' => 'items',
            'itemChildTable' => 'items_hijos',
            'assignmentTable' => 'asignaciones',
        ],
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => '_q0hLQME77sqP3OERcMhfQQ0d5dRoZ8N',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\Usuarios',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            // 'transport' => [
            //    'class' => 'Swift_SmtpTransport',
            //     'constructArgs' => ['localhost', 25],
            //     'plugins' => [
            //         [
            //             'class' => 'Swift_Plugins_ThrottlerPlugin',
            //             'constructArgs' => [20],
            //         ],
            //     ],
            // ],
            // 'useFileTransport' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => require(__DIR__ . '/db.php'),
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = 'yii\debug\Module';

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = 'yii\gii\Module';
}
$config['modules']['gridview'] = '\kartik\grid\Module';

return $config;
