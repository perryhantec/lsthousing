<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use \common\models\Config;

class PageType11Reorder extends Model
{
    // public $category_id;
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
      $models = \common\models\PageType11::find()
                                  // ->where(['category_id'=>$this->category_id])
                                  ->orderBy('seq')
                                  ->all();
      foreach($models as $model){
        $array_one = [];
        $array_one['id'] = $model->id;
        $array_one['content'] = $model->title_tw;

        $this->array[] = $array_one;
      }
    }

    public function saveContent(){
      if ($this->validate()) {
        $lists = explode("-", $this->seq);
        $seq = 0;
        foreach($lists as $list){
          $id = $this->array[$list]['id'];
          $model = \common\models\PageType11::findOne($id);
          $model->seq = $seq;
          $model->save(true, ['seq']);
          $seq++;
        }

        return true;
      }
      return false;
    }


}
