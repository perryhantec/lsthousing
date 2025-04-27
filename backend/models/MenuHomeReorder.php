<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use \common\models\Config;

class MenuHomeReorder extends Model
{
    public $MID;
    public $menu;
    public $array = [];
    public $seq;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
          ['seq', 'safe'],
        ];
    }

    public function attributeLabels()
    {
        return [
          'array' => Yii::t('app', 'Array'),
        ];
    }
    public function setContent(){
      $models = \common\models\Menu::find()
                                  ->where(['display_home'=>1])
                                  ->orderBy(['home_seq' => SORT_ASC])
                                  ->all();
      foreach($models as $model){
        $array_one = [];
        $array_one['id'] = $model->id;
        $array_one['content'] = $model->name_tw.' '.$model->name_cn.' '.$model->name_en;

        $this->array[] = $array_one;
      }
    }

    public function saveContent(){
      if ($this->validate()) {
        $lists = explode("-", $this->seq);
        $seq = 0;
        foreach($lists as $list){
          $id = $this->array[$list]['id'];
          $model = \common\models\Menu::findOne($id);
          $model->home_seq = $seq;
          $model->save();
          $seq++;
        }

        return true;
      }
      return false;
    }


}
