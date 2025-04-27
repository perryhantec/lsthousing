<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\User;

/**
 * LoginForm is the model behind the login form.
 */
class LoginForm extends Model
{
    const SCENARIO_WEB = "from_web";
    const SCENARIO_APP = "from_app";
    const LOGIN_TYPE_NORMAL = "normal";
    const LOGIN_TYPE_OTP = "otp";
    const OTP_WRONG_LIMIT = 10;
    const OTP_WRONG_EXPIRE_TIME = 60 * 60 * 24;

    public $username;
    public $password_otp;
    public $type;

    public $mobile;
    public $password;
    public $rememberMe = false;
    public $verifyCode;
    public $returnUrl;

    private $_user = false;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['username', 'password_otp'], 'required', 'when' => function ($model) {
                return $model->type == self::LOGIN_TYPE_OTP;
            }],
            // ['username', 'match', 'pattern' => '/^\+?[1-9]\d{1,14}$/'],
            // ['password', 'validatePassword'],
            ['password_otp', 'validatePasswordOtp'],

            // username and password are both required
            [['mobile', 'password'], 'required', 'when' => function ($model) {
                return $model->type == self::LOGIN_TYPE_NORMAL;
            }],
            // [['username'], 'email'],
            // [['username', 'mobile'], 'checkMobile'],

            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
            ['verifyCode', 'captcha', 'on' => self::SCENARIO_WEB],
//             [['verifyCode'], \himiklab\yii2\recaptcha\ReCaptchaValidator::className(), 'secret' => '6LfEFw8UAAAAAGPn6b7Yck8_igt99FOFq4WR7XJJ']


        ];
    }

    public function checkMobile ($attribute) {
        if ($this->type == self::LOGIN_TYPE_OTP) {
            $mobile = $this->username;
        } elseif ($this->type == self::LOGIN_TYPE_NORMAL) {
            $mobile = $this->mobile;
        }

        if (
            (int)$mobile < 40000000 ||
            ((int)$mobile > 69999999 && (int)$mobile < 90000000) ||
            (int)$mobile > 99999999
        ) {
            $this->addError($attribute, '請輸入正確手提電話號碼');
            return false;
        }
    }

    public function attributeLabels()
    {
        return [
            'username' => '流動電話號碼',
            'password_otp' => '一次性密碼',

          'mobile' => '流動電話號碼',
        //   'username' => Yii::t('app', 'Email'),
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
//             if (!$user || !$user->validatePassword($this->password) || $user->role!=User::ROLE_MEMBER) {
            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, Yii::t('app', 'Incorrect mobile or password.'));
            }
        }
    }

    public function validatePasswordOtp($attribute, $params)
    {
        $user = $this->getUser();

        if ($user->wrong_count >= self::OTP_WRONG_LIMIT && $user->wrong_expire > time()) {
            $this->addError($attribute, '錯誤次數已超過限制，請稍後再試');
        }

        if (!$this->hasErrors()) {
            if (!$user || !$user->validatePasswordOtp($this->password_otp)) {
                if (!($user->wrong_count > 0 && $user->wrong_expire > time())) {
                    $user->wrong_expire = time() + self::OTP_WRONG_EXPIRE_TIME;
                }
                $user->wrong_count++;
                $user->save(false);

                $this->addError($attribute, '流動電話號碼 或 一次性密碼 錯誤');
            }
        }
    }

    public function login()
    {
        if ($this->validate()){
            $user = $this->getUser();
            $user->otp = '';            //Remove otp before logging in.
            $user->otp_expire = '';
            $user->wrong_count = 0;
            $user->wrong_expire = 0;
            $user->save(false);

            if (Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600*24*7 : 0)) {
                $this->user->last_login_at=date('Y-m-d H:i:s');
                $this->user->save(false);

                return true;
            }
            // return Yii::$app->user->login($user ,$this->rememberMe ? 3600*24*30 : 0);
        }
        return false;
    }

    /**
     * Logs in a user using the provided username and password.
     * @return boolean whether the user is logged in successfully
     */
/*
    public function login()
    {
        if ($this->validate()) {
            // $user = $this->getUserOtp();
            // $user->otp = '';            //Remove otp before logging in.
            // $user->otp_expire = '';
            // $user->save(false);

            if (Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600*24*7 : 0)) {
                $this->user->last_login_at=date('Y-m-d H:i:s');
                $this->user->save();

                return true;
            }

            return false;

        } else {
            return false;
        }
    }
*/

    public function getUser()
    {
        if ($this->_user === false) {
            if ($this->type == self::LOGIN_TYPE_NORMAL) {
                $this->username = $this->mobile;
            }

            $this->_user = User::findByphone($this->username);
        }

        return $this->_user;
    }
    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
 /*
    public function getUser()
    {
        if ($this->_user === false) {
            // $this->_user = User::findByUsername($this->username);
            $this->_user = User::findByMobile($this->mobile);
        }

        return $this->_user;
    }
*/
/*
    public function getUserOtp()
    {
        if ($this->_user === false) {
            $this->_user = User::findByphone($this->username);
        }

        return $this->_user;
    }
*/
}
