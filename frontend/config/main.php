<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'language' => \common\models\Config::GetLanguage(),
    'sourceLanguage' => 'en-US',
    'timeZone' => 'Asia/Hong_Kong',
    
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'components' => [
        'request' => [
            'class' => 'common\components\Request',
            'web'=> '/frontend/web',
            'enableCsrfValidation' => false
        ],
        'authClientCollection' => [
            'class' => 'yii\authclient\Collection',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-frontend',
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
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                ''                                            => 'site/index',
                'home'                                        => 'site/index',
                'search'                                      => 'site/search',
                'project_search'                              => 'site/project-search',
                'contact'                                     => 'site/contact',
                'login'                                       => 'site/login',
                'login-otp'                                   => 'site/login-otp',
                'logout'                                      => 'site/logout',
                'forget-password'                             => 'site/forget-password',
                'reset-password'                              => 'site/reset-password',
                'registration'                                => 'site/registration',
                'my'                                          => 'my/index',
                'my/<action:\w+>'                             => 'my/<action>',
                'application'                                 => 'application/index',
                'application/<action:\w+>'                    => 'application/<action>',
                'household-activity'                          => 'household-activity/index',
                'household-activity/<action:\w+>'             => 'household-activity/<action>',
                'rental-payment'                              => 'rental-payment/index',
                'rental-payment/<action:\w+>'                 => 'rental-payment/<action>',
                'about-us'                                    => 'about-us/index',
                'about-us/<action:\w+>'                       => 'about-us/<action>',
                'lst-housing-new-project'                     => 'pagetype11/index',
                'lst-housing-project'                         => 'pagetype12/index',
                'test'                                        => 'test/index',
                'test/<action:\w+>'                           => 'test/<action>',
                '<page:[a-zA-Z0-9-]+>/<alias:detail>'         => 'site/type4detail',
                '<page:[a-zA-Z0-9-]+>/<alias:housing_detail>' => 'site/type11detail',
                '<page:[a-zA-Z0-9-]+>/<alias:apply_detail>'   => 'site/type12detail',
                '<page:[a-zA-Z0-9-]+>/<alias:gallery_detail>' => 'site/type3detail',
                '<page:[a-zA-Z0-9-]+>/<alias:job>'            => 'site/type8detail',
                '<page:[a-zA-Z0-9-]+>/<alias:tender>'         => 'site/type9detail',
                '<page:[a-zA-Z0-9-]+>'                        => 'site/page',
            ],
        ],
        'formatter' => [
            'dateFormat' => (\common\models\Config::GetLanguage() == 'zh-TW' ? 'yyyy年MM月dd日' : 'dd/MM/yyyy'),
  /*
            'decimalSeparator' => ',',
            'thousandSeparator' => ' ',
  */
        ],
        'reCaptcha' => [
            'class' => 'himiklab\yii2\recaptcha\ReCaptchaConfig',
            'siteKeyV3' => '6LdrmHIgAAAAAPnABgLIbc6QrwlF4614m0EED35h',
            'secretV3' => '6LdrmHIgAAAAAKEV8GE_-chenpdKQ7KPZkGbOimO',
        ],
    ],
    'params' => $params,
];
