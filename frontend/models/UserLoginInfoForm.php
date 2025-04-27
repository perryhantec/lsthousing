<?php

namespace frontend\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use common\models\User;

class UserLoginInfoForm extends User
{
    public $old_password;
    public $new_password;
    public $re_new_password;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // [['username', 'email'], 'trim'],
            // [['email'], 'required', 'when' => function($model) {
            //     return $model->oAuth_user == 1;
            // }],
            // [['email'], 'email'],
            // [['username', 'old_password'], 'required', 'when' => function($model) {
            //     return $model->oAuth_user != 1;
            // }],
            // ['username', 'unique'],
            // [['username'], 'email', 'when' => function($model) {
            //     return $model->oAuth_user != 1;
            // }],
            [['mobile'], 'string', 'max' => 8],
            // [['mobile'], 'checkMobile'],

            ['new_password', 'string', 'min' => 8, 'max' => 160],
            [['password_hash'], 'string'],
            [['old_password'], 'checkOldPassword'],
            [['new_password', 're_new_password'], 'checkNewPassword'],
          ];
    }

    public function checkOldPassword($attribute, $params)
    {
        if(!self::validatePassword($this->old_password)) {
            $this->addError($attribute, Yii::t('app','Old password is not correct.'));
        }
    }

    public function checkNewPassword($attribute, $params)
    {
        if($this->new_password != $this->re_new_password){
            $this->addError($attribute, Yii::t('app','These two passwords are not the same.'));
        }
    }


    public function attributeLabels()
    {
        return [
        //   'email' => Yii::t('app', 'Email'),
        //   'username' => Yii::t('app', 'Email'),
          'mobile' => '流動電話號碼',
          'password_hash' => Yii::t('app', 'Password'),

          'old_password' => Yii::t('app', 'Old Password'),
          'new_password' => Yii::t('app', 'New Password'),
          're_new_password' => Yii::t('app', 'Re-Password'),

        ];
    }

    public function submit(){
        if ($this->validate()) {
            if ($this->oAuth_user != 1) {
                $this->email = $this->username;
                if (self::validatePassword($this->old_password)) {
                    return $this->save();
                }
            } else
                return $this->save();
        }
        return false;
    }

}
