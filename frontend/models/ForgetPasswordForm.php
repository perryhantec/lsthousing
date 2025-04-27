<?php
namespace frontend\models;

use Yii;
use common\models\General;
use common\models\User;
use yii\base\Model;

/**
 * Password reset request form
 */
class ForgetPasswordForm extends Model
{
    public $username;
    public $email;
    public $verifyCode;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // ['username', 'filter', 'filter' => 'trim'],
            // ['username', 'required'],
            // ['username', 'email'],
            // ['username', 'exist',
            //     'targetClass' => '\common\models\User',
            //     'filter' => ['status' => User::STATUS_ACTIVE],
            //     'message' => Yii::t('app', 'There is no user with such email.')
            // ],
            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'exist',
                'targetClass' => '\common\models\User',
                'filter' => ['status' => User::STATUS_ACTIVE],
                'message' => Yii::t('app', 'There is no user with such email.')
            ],

            ['verifyCode', 'captcha'],
        ];
    }

    public function attributeLabels()
    {
        return [
          'username' => Yii::t('app', 'Email'),
          'email' => Yii::t('app', 'Email'),
          'verifyCode' => Yii::t('app', 'Verification Code'),
        ];
    }

    /**
     * Sends an email with a link, for resetting the password.
     *
     * @return boolean whether the email was send
     */
    public function sendEmail()
    {
        /* @var $user User */
        $user = User::findOne([
            'status' => User::STATUS_ACTIVE,
            // 'username' => $this->username,
            'email' => $this->email,
            // 'oAuth_user' => 0
        ]);

        $model_general = General::findOne(1);

        if ($user) {
            if (!User::isPasswordResetTokenValid($user->password_reset_token)) {
                $user->generatePasswordResetToken();
            }

            if ($user->save(false)) {
                // if ($user->email) {
                    return \Yii::$app->mailer->compose(['html' => 'passwordResetToken-html', 'text' => 'passwordResetToken-text'], ['user' => $user])
                    ->setFrom([\Yii::$app->params['supportEmail'] => $model_general->name])
                    ->setTo($user->email)
                    ->setSubject(Yii::t('mail', 'Password reset for {0}', [$model_general->name]))
                    ->send();
                // }
            }
        }

        return false;
    }
}
