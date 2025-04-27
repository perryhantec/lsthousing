<?php

namespace frontend\assets;

use yii\web\AssetBundle;

class AdminLteAsset extends AssetBundle {

  public $sourcePath = '@vendor/almasaeed2010/adminlte/dist';
  public $css = [
      'css/skins/skin-green.min.css',
      'css/skins/skin-blue.min.css',
      'css/AdminLTE.min.css',
  ];
  public $js = [
      'js/adminlte.min.js'
  ];
  public $depends = [
      'yii\web\JqueryAsset'
  ];

}
