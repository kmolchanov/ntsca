<?php

$db = file_exists(__DIR__ . '/db-local.php') ? require(__DIR__ . '/db-local.php') : require(__DIR__ . '/db.php');
$params = file_exists(__DIR__ . '/params-local.php') ? require(__DIR__ . '/params-local.php') : require(__DIR__ . '/params.php');
$mailer = file_exists(__DIR__ . '/mailer-local.php') ? require(__DIR__ . '/mailer-local.php') : require(__DIR__ . '/mailer.php');
$user = file_exists(__DIR__ . '/user-local.php') ? require(__DIR__ . '/user-local.php') : require(__DIR__ . '/user.php');

$config = [
    'id' => 'ntsca',
    'name' => 'NTSCA',
    'language' => 'ru-RU',
    'timeZone' => 'Asia/Bishkek',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'container' => [
        'singletons' => [
            \yii\mail\MailerInterface::class => [
                'class' => \yii\symfonymailer\Mailer::class,
                // send all mails to a file by default.
                'useFileTransport' => true,
                'viewPath' => '@app/mail',
            ],
        ],
    ],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'SfI_7gLNxjcf7QbNDnirVAA4b6pIYbg-',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
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
        'db' => $db,
        'mailer' => $mailer,
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
        'view' => [
            'theme' => [
                'pathMap' => [
                    '@dektrium/user/views' => '@app/views/user'
                ],
            ],
        ],
    ],
    'modules' => [
        'user' => $user,
        'rbac' => [
            'class' => 'dektrium\rbac\RbacWebModule',
            'layout' => '@app/modules/admin/views/layouts/main',
        ],
        'admin' => [
            'class' => 'app\modules\admin\Module',
            'name' => 'Панель управления',
        ],
        'yii2images' => [
            'class' => 'rico\yii2images\Module',
            'imagesStorePath' => 'uploads/images/store',
            'imagesCachePath' => 'uploads/images/cache',
            'graphicsLibrary' => 'Imagick',
            'placeHolderPath' => '@webroot/images/placeHolder.png',
        ],
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
