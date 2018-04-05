<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'language' => 'vi',
    'bootstrap' => ['languagepicker'],
    'sourceLanguage' => 'vi',

    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],

        'languagepicker' => [
            'class' => 'lajax\languagepicker\Component',
            'languages' => [/*'en-US', */'vi-VN'],       // List of available languages (icons only)
            'cookieName' => 'language',                         // Name of the cookie.
            //'cookieDomain' => 'localhost',                    // Domain of the cookie.
                'expireDays' => 64,                                 // The expiration time of the cookie is 64 days.
//                'callback' => function() {
//                    if (!\Yii::$app->user->isGuest) {
//                        $user = \Yii::$app->user->identity;
//                        $user->language = \Yii::$app->language;
//                        $user->save();
//                    }
//                }
        ],

        'i18n' => [
            'translations' => [
                'frontend*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@common/messages',
                ],
                'backend*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@common/messages',
                ],
            ],
        ],

//        'authManager' => [
//            //'class' => 'yii\rbac\PhpManager', // or use 'yii\rbac\DbManager'
//            'class' => 'yii\rbac\DbManager', // or use 'yii\rbac\DbManager'
//        ],
//        'authManager' => [
//            'class' => 'yii\rbac\PhpManager',
//            'defaultRoles' => ['admin','editor','user'], // here define your roles
//            //'authFile' => '@console/data/rbac.php' //the default path for rbac.php | OLD CONFIGURATION
//            'itemFile' => '@console/data/items.php', //Default path to items.php | NEW CONFIGURATIONS
//            'assignmentFile' => '@console/data/assignments.php', //Default path to assignments.php | NEW CONFIGURATIONS
//            'ruleFile' => '@console/data/rules.php', //Default path to rules.php | NEW CONFIGURATIONS
//        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
            'defaultRoles' => ['guest'],
        ],


    ],
    'modules' => [
        'giiMongo' => [
            'class' => 'yii\gii\Module',
            'generators' => [
                'mongoDbModel' => [
                    'class' => 'yii\mongodb\gii\model\Generator'
                ]
            ],
        ],

        'admin' => [
            'class' => 'mdm\admin\Module',
            'layout' => 'left-menu',
            'mainLayout' => '@app/views/layouts/main.php',
        ]
    ],

    'as access' => [
        'class' => 'mdm\admin\components\AccessControl',
        'allowActions' => [
            'site/*',
            // Cho phép sửa password
//            'usermanager/forgot',
//            'usermanager/resetpassword',
//            'usermanager/congratulation',
//            'usermanager/resetpw',

            //'usermanager/*',
            //'admin/*',
            'some-controller/some-action',
            // The actions listed here will be allowed to everyone including guests.
            // So, 'admin/*' should not appear here in the production, of course.
            // But in the earlier stages of your development, you may probably want to
            // add a lot of actions here until you finally completed setting up rbac,
            // otherwise you may not even take a first step.
        ]
    ],
];
