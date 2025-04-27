<?php

namespace common\components;

use Yii;
use common\models\User;

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

    function checkRole($roles)
    {
        $result = false;
        foreach ($roles as $role) {
            switch($role){
                case '*':
                    $result |= true;
                case '?':
                    $result |= Yii::$app->user->isGuest;
                case '@':
                    $result |= !Yii::$app->user->isGuest && Yii::$app->user->identity->role != User::ROLE_MEMBER;
                case '$':
                    $result |= !Yii::$app->user->isGuest;
                default:
                    $result |= !Yii::$app->user->isGuest && Yii::$app->user->identity->checkRole($role);
            }
        }
        return $result;
    }
}
