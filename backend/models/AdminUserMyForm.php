<?php
namespace backend\models;

use Yii;
use yii\base\NotSupportedException;
use common\models\AdminUser;

/**
 * AdminUser model
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $auth_key
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 */
class AdminUserMyForm extends AdminUser
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
            [['name', 'email', 'username', 'role'], 'required'],
            ['username', 'unique'],
            ['username', 'string', 'min' => 4, 'max' => 20],
            ['new_password', 'string', 'min' => 8, 'max' => 160],
            ['re_new_password', 'string', 'min' => 8, 'max' => 160],
            ['email', 'email'],
            [['old_password'], 'required'],
            [['name', 'username', 'password_hash', 'auth_key'], 'string'],
            [['role', 'status', 'updated_UID'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            [['new_password', 're_new_password'], 'checkNewPassword'],
          ];
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
          'id' => Yii::t('app', 'ID'),
          'name' => Yii::t('app', 'Name'),
          'email' => Yii::t('app', 'Email'),
          'username' => Yii::t('app', 'AdminUsername'),
          'password_hash' => Yii::t('app', 'Password'),
          'role' => Yii::t('app', 'Role'),
          'auth_key' => Yii::t('app', 'Authentication Key'),
          'status' => Yii::t('app', 'Status'),
          'created_at' => Yii::t('app', 'Created At'),
          'updated_at' => Yii::t('app', 'Updated Dt'),
          'updated_UID' => Yii::t('app', 'Updated Uid'),

          'old_password' => Yii::t('app', 'Password'),
          'new_password' => Yii::t('app', 'New Password'),
          're_new_password' => Yii::t('app', 'Re-Password'),

        ];
    }

    public function submit(){
      if ($this->validate()) {
        if(self::validatePassword($this->old_password)){
          if($this->new_password!=NULL){
            self::setPassword($this->new_password);
          }
          return $this->save();
        }else{

        }
      }
      return false;
    }

}
