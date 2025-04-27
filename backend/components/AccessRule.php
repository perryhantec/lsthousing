<?php

namespace backend\components;

use Yii;
use common\models\AdminUser;

class AccessRule extends \yii\filters\AccessRule
{

    /** @inheritdoc */
    protected function matchRole($user)
    {
        if (empty($this->roles)) {
            return true;
        }
        if (self::checkRole($this->roles)) {
          return true;
        }
        return false;
    }

    public static function checkRole($roles)
    {
        $result = false;
        foreach ($roles as $role) {
            switch($role){
                case '*':
                    $result |= true;
                case '?':
                    $result |= Yii::$app->user->isGuest;
                case '@':
                    $result |= !Yii::$app->user->isGuest;
                case '$':
                    $result |= !Yii::$app->user->isGuest;
                default:
                    $result |= !Yii::$app->user->isGuest && Yii::$app->user->identity->checkRole($role);
            }
        }
        return $result;
    }
}
