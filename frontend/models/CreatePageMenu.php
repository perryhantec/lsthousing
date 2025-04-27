<?php

namespace frontend\models;

use Yii;
use common\models\Config;
use \common\models\Menu;

class CreatePageMenu extends Menu
{
    public static function listMenuName(){
      $menu = [];
      $records = Menu::find()
                  ->where(['MID'=>null, 'status' => 1])
                  //->where(['type'=>1])
                  ->orderBy('seq')
                  ->all();

      foreach($records as $record){
        $sub_array = [];
        $sub_array['MID'] = $record->id;
        $sub_array['name_cn'] = $record->name_cn;
        $sub_array['name_en'] = $record->name_en;
        array_push($menu, $sub_array);
      }
      return $menu;
    }

    public static function listMenuLv2Name($MID){
      $menu = [];
      $records = Menu::find()
                  ->where(['MID'=>$MID, 'status' => 1])
                  //->where(['type'=>2, 'MID'=>$MID])
                  ->orderBy('seq')
                  ->all();
      foreach($records as $record){
        $sub_array = [];
        $sub_array['MID'] = $record->id;
        $sub_array['name_cn'] = $record->name_cn;
        $sub_array['name_en'] = $record->name_en;
        array_push($menu, $sub_array);
      }
      return $menu;
    }

    public static function listMenuLv2MID($MID){
      $array_MID = [];
      $records = Menu::find()
                  ->where(['MID'=>$MID, 'status' => 1])
                  //->where(['type'=>2, 'MID'=>$MID])
                  ->orderBy('seq')
                  ->all();
      foreach($records as $record){
        $array_MID[] = $record->id;
      }
      return $array_MID;
    }

    public static function getMID($url_name){
      $record = Menu::find()->where("`url` = :url", [':url' => $url_name])->one();
      return ($record!=NULL)? $record->id:NULL;
    }
}
