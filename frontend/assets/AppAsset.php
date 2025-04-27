<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'fonts/fontawesome/css/all.min.css',
        'fonts/simple-line-icons.css',
        'css/jquery.fancybox.min.css?v=3.5.7',
        'css/site.css?v=1.4.3',
        'css/style.css?v=1.2.2',
        'css/ecommerce.css',
        'css/slick.css',
        'css/slick-theme.css',
      ];
    public $js = [
        'js/script.js?v=1.0.1',
        'js/slick.min.js',
        'js/jquery.fancybox.min.js?v=3.5.7',  
    ];
    public $depends = [
        'yii\web\YiiAsset',
//        'yii\bootstrap4\BootstrapAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset',
    ];
}
