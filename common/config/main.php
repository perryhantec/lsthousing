<?php

return [
    'language' => '',
    'sourceLanguage' => 'en-US',
    'timeZone' => 'Asia/Hong_Kong',

    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            'transport' => [
                  'class' => 'Swift_SmtpTransport',
                  'host' => 'mail.lsthousing.org',
                  'username' => 'noreply@lsthousing.org',
                  'password' => '5+Ec57p5Kv',
                  'port' => '587',
                  'encryption' => 'tls',
                  //fix with 	\vendor\swiftmailer\swiftmailer\lib\classes\Swift\Transport\StreamBuffer.php
                   //                    You could disable the SSL check by modifying the function "_establishSocketConnection" in StreamBuffer.php. Add these lines before stream_socket_client command:
                   //
                   // $options['ssl']['verify_peer'] = FALSE;
                   // $options['ssl']['verify_peer_name'] = FALSE;
            ],
        ],
        'reCaptcha' => [
          'name' => 'reCaptcha',
          'class' => 'himiklab\yii2\recaptcha\ReCaptcha',
          'siteKey' => '',
          'secret' => '',
        ],

        'i18n' => [
          'translations' => [
              'app' => [
                  'class' => 'yii\i18n\PhpMessageSource',
                  'sourceLanguage' => 'en-US',
                  'basePath' => '@common/messages',
                  'fileMap' => [
                     'app' => 'app.php',
                   ],
              ],
              'definitions' => [
                  'class' => 'yii\i18n\PhpMessageSource',
                  'sourceLanguage' => 'en-US',
                  'basePath' => '@common/messages',
                  'fileMap' => [
                     'definitions' => 'definitions.php',
                   ],
              ],
              'error_msg' => [
                  'class' => 'yii\i18n\PhpMessageSource',
                  'sourceLanguage' => 'en-US',
                  'basePath' => '@common/messages',
                  'fileMap' => [
                     'error_msg' => 'error_messages.php',
                   ],
              ],
              '*' => [
                  'class' => 'yii\i18n\PhpMessageSource',
                  'sourceLanguage' => 'en-US',
                  'basePath' => '@common/messages',
              ],
          ],
        ],
//         'formatter' => [
//             'defaultTimeZone' => 'Asia/Hong_Kong',
//             'timeZone' => 'Asia/Hong_Kong',
//             'dateFormat' => 'yyyy-MM-dd',
//             'datetimeFormat' => 'yyyy-MM-dd HH:mm:ss',
//             'decimalSeparator' => '.',
//             'thousandSeparator' => '',
// //             'currencyCode' => 'HKD',
//             'numberFormatterOptions' => [
//                 NumberFormatter::MIN_FRACTION_DIGITS => 0,
//                 NumberFormatter::MAX_FRACTION_DIGITS => 2,
//             ],
//             'numberFormatterSymbols' => [
//                 NumberFormatter::CURRENCY_SYMBOL => '$',
//             ]
//         ],
        'config' => [
            'class' => '\common\models\Config',
        ],
    ],
    'modules' => [
        'gridview' =>  [
           'class' => '\kartik\grid\Module',
           // enter optional module parameters below - only if you need to
           // use your own export download action or custom translation
           // message source
            'downloadAction' => 'gridview/export/download',
            'i18n' => [
                'class' => 'yii\i18n\PhpMessageSource',
                'basePath' => '@common/messages',
                'forceTranslation' => false
            ]
        ],
    ],

];
