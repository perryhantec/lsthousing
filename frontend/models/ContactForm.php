<?php

namespace frontend\models;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class ContactForm extends Model
{
    public $name;
    public $phone;
    public $email;
    public $body;
    // public $verifyCode;
    public $reCaptcha;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // name, email, subject and body are required
            // [['name', 'phone', 'email', 'body'], 'required'],
            [['name', 'phone', 'body'], 'required'],
            // email has to be a valid email address
            ['body', 'string', 'max'=>1000],
            ['phone', 'number'],
            ['email', 'email'],
            // verifyCode needs to be entered correctly
            // ['verifyCode', 'captcha'],
            [['reCaptcha'], \himiklab\yii2\recaptcha\ReCaptchaValidator3::className(),
              //'secret' => '6LdrmHIgAAAAAKEV8GE_-chenpdKQ7KPZkGbOimO',
              'threshold' => 0.5,
              'action' => 'contact',
              //'uncheckedMessage' => 'Please confirm that you are not a bot.'
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
          'name' => Yii::t('web', 'Name'),
          'phone' => Yii::t('web', 'Phone'),
          'email' => Yii::t('web', 'Email'),
          'body' => Yii::t('web', 'Message'),
          // 'verifyCode' => Yii::t('app', 'Verification Code'),
          'reCaptcha' => Yii::t('app', 'Verification Code'),
        ];
    }

    /**
     * Sends an email to the specified email address using the information collected by this model.
     *
     * @param  string  $email the target email address
     * @return boolean whether the email was sent
     */
     public function sendEmail()
     {
         return Yii::$app->mailer->compose('contact_us', [
                 'model' => $this,
                 'name' => $this->name,
                 'phone' => $this->phone,
                 'email' => $this->email,
                 'body' => $this->body])
                 ->setTo(Yii::$app->params['contactEmail'])
                 ->setFrom(Yii::$app->params['supportEmail'])
                //  ->setReplyTo($this->email)
                 ->setSubject('來自網站的聯絡我們')
                 ->send();
     }
}
