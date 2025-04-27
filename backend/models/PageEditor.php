<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use common\models\PageType;
use yii\helpers\Html;
use common\models\Menu;


class PageEditor
{
// Backend Menu
  public function generate_menus(){
    $models = Menu::find()
                ->where(['MID'=>null])
                ->orderBy('seq')
                ->all();
    return $models;
  }

  public function generate_menus_lv2($MID){
    $models = Menu::find()
                ->where(['MID'=>$MID])
                ->andWhere(['!=', 'page_type', '0'])
                ->orderBy('seq')
                ->all();
    return $models;
  }



}
