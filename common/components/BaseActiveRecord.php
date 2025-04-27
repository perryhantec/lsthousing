<?php

namespace common\components;

use Yii;

class BaseActiveRecord extends \yii\db\ActiveRecord
{

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            $this->updated_at=date('Y-m-d H:i:s');
            if(isset(Yii::$app->user->id)){
              $this->updated_UID=Yii::$app->user->id;
            }

            return true;
        } else {
            return false;
        }
    }

}
