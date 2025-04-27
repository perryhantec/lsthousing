<?php

namespace common\components;

use Yii;
use \yii\captcha\CaptchaAction;

class NumberCaptcha extends CaptchaAction
{
    protected function generateVerifyCode()
    {
        if($this->minLength<3)
            $this->minLength=3;
        if($this->maxLength>20)
            $this->maxLength=20;
        if($this->minLength>$this->maxLength)
            $this->maxLength=$this->minLength;
        $length=rand($this->minLength,$this->maxLength);
        $length=6;
        $letters='1234567890';
        $code='';
        for ($i=0; $i<$length; $i++) {
            $code .= $letters[rand(0,9)];
        }

        return $code;
    }

}
