<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use common\models\AdminUser;

/**
 * LoginForm is the model behind the login form.
 */
class LoginForm extends Model
{
    public $username;
    public $password;
    public $rememberMe = false;
    public $verifyCode;

    private $_user = false;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['username', 'password'], 'required'],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
            ['verifyCode', 'captcha'],
            //[['verifyCode'], \himiklab\yii2\recaptcha\ReCaptchaValidator::className(), 'secret' => '6Lea6QwUAAAAACMuxpqV77RJ4BjYZPPPtRvs5LQb']

        ];
    }

    public function attributeLabels()
    {
        return [
          'username' => Yii::t('app', 'Username'),
          'password' => Yii::t('app', 'Password'),
          'rememberMe' => Yii::t('app', 'Remember Me'),
          'verifyCode' => Yii::t('app', 'Verification Code'),
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Incorrect username or password.');
            }
        }
    }

    /**
     * Logs in a user using the provided username and password.
     * @return boolean whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {

            if (Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600*24*7 : 0)) {
                $this->_user->last_login_at=date('Y-m-d H:i:s');
                $this->_user->save();

                Yii::$app->adminLog->insert(Yii::t('log', 'User login'));

                return true;
            }

            return false;

        } else {
            return false;
        }
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = AdminUser::findByUsername($this->username);
        }

        return $this->_user;
    }
}
