<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\User;

/**
 * RegistrationForm is the model behind the login form.
 */
class UserRegistrationForm extends User
{
    const SCENARIO_WEB = "from_web";
    const SCENARIO_APP = "from_app";

    public $verifyCode;
    public $acknowledge_tc;
    public $re_new_password;

    public $part5_t1;
    public $part5_t2;
    public $part5_t3;
    public $part5_t4;
    public $part5_t5;
    public $part5_t6;
    public $part6_t1;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['chi_name', 'eng_name'], 'trim'],
            [['mobile'], 'string', 'max' => 8],
            [['app_no', 'chi_name', 'eng_name'], 'string', 'max' => 255],
            [['chi_name', 'eng_name', 'mobile', 'new_password', 're_new_password'], 'required'],
            [['email'], 'email'],
            ['mobile', 'unique', 'message' => Yii::t('app', 'This {attribute} has already been taken.')],
            // [['mobile'], 'checkMobile'],

            // [['username'], 'trim'],
            // [['phone'], 'string', 'max' => 16],
            // [['name'], 'string', 'max' => 255],
            // [['name', 'phone', 'username', 'new_password', 're_new_password'], 'required'],
            [['re_new_password'], 'string'],
            // [['username'], 'email'],
            // ['username', 'unique', 'message' => Yii::t('app', 'This {attribute} has already been taken.')],
            ['new_password', 'string', 'min' => 8, 'max' => 160],
            [['new_password'], 'checkNewPassword'],
            // [['new_password'], 'match', 'pattern' => '/^(?=.[a-zA-Z])(?=.[0-9]).*$/', 'message' => 'Password should be combination of alphanumeric character, number and symbol.'],
            // [['new_password'], 'match', 'pattern' => '/^(?=.*?[a-zA-Z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/', 'message' => '密碼必須包含一個 英文字母、數字、符號。'],
            [['new_password'], 'match', 'pattern' => '/^(?=.*?[a-z])(?=.*?[A-Z])(?=.*?[0-9]).{8,}$/', 'message' => '密碼必須為大楷英文、小楷英文及數字的任意組合。'],
            ['verifyCode', 'captcha', 'on' => self::SCENARIO_WEB],
//             ['acknowledge_tc', 'required', 'requiredValue' => 1, 'message' => Yii::t('app', 'Please indicate that you have read and agree to the Terms and Conditions')],
/*
            [['verifyCode'], \himiklab\yii2\recaptcha\ReCaptchaValidator::className(), 'secret' => '6LcV0SoUAAAAAGUn76265Lau1QS_MjhKkwVzbfx7']
*/
            [['part5_t1', 'part5_t2', 'part5_t3', 'part5_t4', 'part5_t5', 'part5_t6'], 'required'],
            [['part6_t1'], 'required'],
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
    
    public function checkNewPassword($attribute, $params)
    {
        if ($this->new_password != $this->re_new_password) {
            $this->addError($attribute, Yii::t('app','These two passwords are not the same.'));
        }
    }

    public function attributeLabels()
    {
        return [
            'chi_name' => '姓名(中文)',
            'eng_name' => '姓名(英文)',
            'mobile' => '流動電話號碼',
            'email' => '電郵地址',

        //   'name' => Yii::t('app', 'Name'),
        //   'phone' => Yii::t('app', 'Phone'),
        //   'email' => Yii::t('app', 'Email'),
        //   'username' => Yii::t('app', 'Email'),
          'new_password' => Yii::t('app', 'Password'),
          're_new_password' => Yii::t('app', 'Re-Password'),
          'verifyCode' => Yii::t('app', 'Verification Code'),
          'acknowledge_tc' => Yii::t('app', 'I have read and agree to the Terms and Conditions and Privacy Policy'),

            'part5_t1'          => '此項聲明及承諾',
            'part5_t2'          => '此項聲明及承諾',
            'part5_t3'          => '此項聲明及承諾',
            'part5_t4'          => '此項聲明及承諾',
            'part5_t5'          => '此項聲明及承諾',
            'part5_t6'          => '此項聲明及承諾',
            'part6_t1'          => '此項聲明',
        ];
    }

    public function attributeHints()
    {
        return [
        ];
    }

    public function submit()
    {
        if ($this->validate()) {
            $this->role = self::ROLE_MEMBER;
            $this->oAuth_user = 0;
            // $this->email = $this->username;
            // $this->user_appl_status = self::UNALLOCATED_UNIT;
            $this->user_appl_status = self::USER_APPL_STATUS_UNALLOCATE_UNIT;

            if ($this->save(false)) {
                $no_of_zero = self::APP_NO_LENGTH - strlen($this->id);
                $this->app_no = str_pad(self::APP_NO_PREFIX, $no_of_zero, '0').$this->id;

                $this->save(false);

                return Yii::$app->user->login($this, 0);
            }
        }
        return false;
    }

}
