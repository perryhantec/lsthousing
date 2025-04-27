<?php

namespace frontend\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use common\models\User;

class UserAccountDetailForm extends User
{
    public $user_project;
    public $user_room_no;
    public $user_start_date;
    public $old_password;
    public $new_password;
    public $re_new_password;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['chi_name', 'eng_name', 'mobile'], 'required'],
            [['chi_name', 'eng_name'], 'trim'],
            [['mobile'], 'string', 'max' => 8],
            [['chi_name', 'eng_name'], 'string', 'max' => 255],
            [['email'], 'email'],
            ['mobile', 'unique', 'message' => Yii::t('app', 'This {attribute} has already been taken.')],
            [['mobile'], 'checkMobile'],


            // [['name', 'email', 'phone'], 'required'],
            // [['phone'], 'string', 'max' => 16],
            // [['name'], 'string', 'max' => 255],
            // [['username', 'email'], 'trim'],
            [['chi_name'], 'required', 'when' => function($model) {
                return $model->oAuth_user == 1;
            }],
            [['eng_name'], 'required', 'when' => function($model) {
                return $model->oAuth_user == 1;
            }],
            [['mobile'], 'required', 'when' => function($model) {
                return $model->oAuth_user == 1;
            }],


            // [['email'], 'required', 'when' => function($model) {
            //     return $model->oAuth_user == 1;
            // }],
            // [['email'], 'email'],
            // [['username'], 'required', 'when' => function($model) {
            //     return $model->oAuth_user != 1;
            // }],
            // ['username', 'unique', 'message' => Yii::t('app', 'This {attribute} has already been taken.')],
            // [['username'], 'email', 'when' => function($model) {
            //     return $model->oAuth_user != 1;
            // }],
            [['old_password'], 'required', 'when' => function($model) {
                return $model->new_password != "" || $model->re_new_password != "";
            }, 'whenClient' => "function (attribute, value) {
                return $('[name=\"UserAccountDetailForm[new_password]\"]').val() != '' || $('[name=\"UserAccountDetailForm[re_new_password]\"]').val() != '';
            }"],
            [['old_password'], 'checkOldPassword'],
            ['new_password', 'string', 'min' => 8, 'max' => 160],
            [['new_password', 're_new_password'], 'checkNewPassword'],
            // [['new_password'], 'match', 'pattern' => '/^(?=.*?[a-zA-Z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/', 'message' => '密碼必須包含一個 英文字母、數字、符號。'],
            [['new_password'], 'match', 'pattern' => '/^(?=.*?[a-z])(?=.*?[A-Z])(?=.*?[0-9]).{8,}$/', 'message' => '密碼必須為大楷英文、小楷英文及數字的任意組合。'],
          ];
    }

    public function checkMobile ($attribute) {
        if (
            (int)$this->mobile < 40000000 ||
            ((int)$this->mobile > 69999999 && (int)$this->mobile < 90000000) ||
            (int)$this->mobile > 99999999
        ) {
            $this->addError($attribute, '請輸入正確電話號碼');
            return false;
        }
    }

    public function checkOldPassword($attribute, $params)
    {
        if($this->old_password != "" && !self::validatePassword($this->old_password)) {
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
        //   'name' => Yii::t('app', 'Name'),
        //   'phone' => Yii::t('app', 'Phone'),
        //   'email' => Yii::t('app', 'Email'),
        //   'username' => Yii::t('app', 'Email'),

        'ua_status' => '用戶狀態',
        'user_project' => '項目',
        'user_room_no' => '房間編號',
        'user_start_date' => '起租日期',

        'chi_name' => '姓名(中文)',
        'eng_name' => '姓名(英文)',
        'mobile' => '流動電話號碼',
        'email' => '電郵地址',

          'old_password' => Yii::t('app', 'Current password (leave blank to leave unchanged)'),
          'new_password' => Yii::t('app', 'New password (leave blank to leave unchanged)'),
          're_new_password' => Yii::t('app', 'Confirm new password'),
        ];
    }

    public function submit(){
        if ($this->validate()) {
            if ($this->oAuth_user != 1) {
                if ($this->new_password == "" || ($this->new_password != "" && self::validatePassword($this->old_password))) {
                    return $this->save(false);
                }
            } else
                return $this->save(false);
        }
        return false;
    }

}
