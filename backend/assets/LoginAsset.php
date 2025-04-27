<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class LoginAsset extends AssetBundle
{

  public $basePath = '@webroot/login';
  public $baseUrl = '@web/login';
  public $css = [
    'dist/css/AdminLTE.css',
    'dist/css/skins/_all-skins.min.css',
    'bootstrap/css/bootstrap.min.css',
     'https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css',
     'https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css',

  ];
  public $js = [


  ];
  public $depends = [
      'yii\web\YiiAsset',
      //'yii\bootstrap\BootstrapAsset',
      //'yii\bootstrap\BootstrapPluginAsset',
  ];

}
