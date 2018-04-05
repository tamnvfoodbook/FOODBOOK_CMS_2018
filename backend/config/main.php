<?php
/*phpinfo();
die();*/

use kartik\mpdf\Pdf;
date_default_timezone_set('Asia/Bangkok');

$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'modules' => [
        'gridview' =>  [
            'class' => '\kartik\grid\Module',
            // enter optional module parameters below - only if you need to
            // use your own export download action or custom translation
            // message source
             'downloadAction' => 'gridview/export/download',
            // 'i18n' => []
        ],
//        'debug' => [
//            'class' => 'yii\debug\Module',
//        ],


    ],
    'timeZone' => 'Asia/Bangkok',
    'components' => [
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,            
            'identityCookie' => [            
            'name' => '_backendUser', // unique for backend            
            'path'=>'/advanced/backend/web'  // correct path for the backend app.
            ]
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning','info'],
                    'categories' => [
                        'yii\db\*',
                        'yii\web\HttpException:*',
                        'application'
                    ],
                    'logFile' => '@runtime/logs/app.log',
                ],
            ],
        ],

        'errorHandler' => [
            'errorAction' => 'site/error',
        ],

        'assetManager' => [
            'bundles' => [
                'dmstr\web\AdminLteAsset' => [
                    'skin' => 'skin-blue',
//                    'skin' => 'skin-green-light',
                ],
            ],
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'useFileTransport'=> false,
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'mail.ipos.vn',
                'username' => 'mobile@ipos.vn',
                'password' => 'aBcd123$',
                //'port' => '25',
                //'encryption' => 'tls',
            ],
        ],

        'session' => [
            'name' => 'PHPBACKSESSID',
            'savePath' => __DIR__ . '/../tmp',
        ],

        'pdf' => [
            'class' => Pdf::classname(),
            'format' => Pdf::FORMAT_A4,
            'orientation' => Pdf::ORIENT_PORTRAIT,
            'destination' => Pdf::DEST_BROWSER,
            // refer settings section for all configuration options
        ],

    ],

//    'on beforeRequest' => function ($event) {
//        if(!Yii::$app->request->isSecureConnection){
//            // add some filter/exemptions if needed ..
//            $url = Yii::$app->request->getAbsoluteUrl();
//            $url = str_replace('http:', 'https://', $url);
//            Yii::$app->getResponse()->redirect($url);
//            Yii::$app->end();
//        }
//    },

    'params' => $params,
];
