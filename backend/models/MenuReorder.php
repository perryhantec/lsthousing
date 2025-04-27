<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use \common\models\Config;

class MenuReorder extends Model
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
                                  ->where(['MID'=>$this->MID])
                                  ->orderBy('seq')
                                  ->all();
      foreach($models as $model){
        $array_one = [];
        $array_one['id'] = $model->id;
        $array_one['content'] = $model->name;

        $this->array[] = $array_one;
      }

      $this->menu = \common\models\Menu::findOne($this->MID);
    }

    public function saveContent(){
      if ($this->validate()) {
        $lists = explode("-", $this->seq);
        $seq = 0;
        foreach($lists as $list){
          $id = $this->array[$list]['id'];
          $model = \common\models\Menu::findOne($id);
          $model->seq = $seq;
          $model->save();
          $seq++;
        }

        return true;
      }
      return false;
    }


}
