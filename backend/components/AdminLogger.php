<?php

namespace backend\components;

use Yii;
use common\models\AdminLog;


Class AdminLogger
{

    public function insert($message, $menu_id = null)
    {
        $model = new AdminLog([
            'admin_user_id' => Yii::$app->user->id,
            'message' => $message,
            'ip' => Yii::$app->request->userIP,
            'menu_id' => $menu_id
        ]);

        return $model->save();
    }
}
