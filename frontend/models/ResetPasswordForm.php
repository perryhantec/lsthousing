<?php
namespace frontend\models;

use common\models\User;
use yii\base\InvalidParamException;
use yii\base\Model;
use Yii;

/**
 * Password reset form
 */
class ResetPasswordForm extends Model
{
    public $new_password;
    public $re_new_password;
    public $verifyCode;

    /**
     * @var \common\models\User
     */
    private $_user;


    /**
     * Creates a form model given a token.
     *
     * @param  string                          $token
     * @param  array                           $config name-value pairs that will be used to initialize the object properties
     * @throws \yii\base\InvalidParamException if token is empty or not valid
     */
    public function __construct($token, $config = [])
    {
        if (empty($token) || !is_string($token)) {
            throw new InvalidParamException(Yii::t('app', 'Error! Please try again.'));
        }
        $this->_user = User::findByPasswordResetToken($token);
        if (!$this->_user) {
            throw new InvalidParamException(Yii::t('app', 'Error! Please try again.'));
        }
        parent::__construct($config);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['new_password', 're_new_password'], 'required'],
            ['new_password', 'string', 'min' => 8, 'max' => 160],
            [['new_password', 're_new_password'], 'checkNewPassword'],
            ['verifyCode', 'captcha'],
            [['new_password'], 'match', 'pattern' => '/^(?=.*?[a-z])(?=.*?[A-Z])(?=.*?[0-9]).{8,}$/', 'message' => '密碼必須為大楷英文、小楷英文及數字的任意組合。'],
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
          'new_password' => Yii::t('app', 'New Password'),
          're_new_password' => Yii::t('app', 'Re-Password'),
          'verifyCode' => Yii::t('app', 'Verification Code'),
        ];
    }
    /**
     * Resets password.
     *
     * @return boolean if password was reset.
     */
    public function resetPassword()
    {
        $user = $this->_user;
        $user->setPassword($this->new_password);
        $user->removePasswordResetToken();

        return $user->save(false);
    }
}
