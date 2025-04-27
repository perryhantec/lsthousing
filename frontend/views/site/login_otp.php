<?php

/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use yii\widgets\Breadcrumbs;
use yii\captcha\Captcha;
use common\widgets\Alert;
use common\models\Config;

$model_general = common\models\General::findOne(1);

$this->title = Yii::t('app', "Login");
Yii::$app->params['page_header_title'] = $this->title;
// Yii::$app->params['page_header_img'] = '/images/page_header_img-shop.jpg';

Yii::$app->params['breadcrumbs'][] = $this->title;

// $this->registerJs(<<<JS
// JS
// );
?>
<?= $this->render('../layouts/_user_header') ?>
        <?= Alert::widget() ?>
        <div class="login-content content">
            <h3><?= Yii::t('app', 'Login') ?></h3>
            <div class="row">
                <div class="col-sm-push-3 col-sm-6">
                    <?php $form = ActiveForm::begin([
                        'id' => 'login-form',
                        'enableAjaxValidation' => false
                    ]); ?>
        <?= $form->errorSummary($model)?>
        <div id="section-1">
            <?= $form->field($model, 'username')->textInput(['autofocus' => true, 'placeholder'=> '請輸入電話號碼']) ?>
            <div class="form-group">
                <div>
                    <?= Html::button('獲取一次性密碼',['class'=>'btn btn-primary','id'=>'request-otp-btn']); ?>
                </div>
            </div>
        <!-- </div> -->
        <!-- <div id="section-2" style="display:none;"> -->
            <?= $form->field($model, 'password_otp')->passwordInput() ?>

            <?=$form->field($model, 'rememberMe')->checkbox()?>

            <div class="form-group">
                <div>
                    <?= Html::button(Yii::t('app', 'Login'), ['class' => 'btn btn-primary', 'id' => 'login-button']) ?>
                </div>
            </div>
        </div>
                    <?php ActiveForm::end(); ?>

                    <p style="text-align: center">
                        <?= Html::a('會員註冊', ['/registration'], ['style' => 'margin-left:15px;']) ?>
                    </p>
                </div>
            </div>
        </div>
<?php
$otpUrl = Url::toRoute(['site/send-otp']);
$loginUrl = Url::toRoute(['site/login-otp']);
$loginSuccessUrl = Url::toRoute('my/application');
$csrf =Yii::$app->request->csrfToken;
$script = <<< JS

    $('button#request-otp-btn').click(function(){
        sendOtp();
    });
    function sendOtp() {
      
        $('#login-form').yiiActiveForm('validateAttribute', 'loginform-username'); //To Validate the phone/username field first before sending the OTP
        setTimeout(function(){
          var username = $('#loginform-username');
          var phone = username.val(); 
          var isPhoneValid = ($('div.field-loginform-username.has-error').length==0);
          if(phone!='' && isPhoneValid){
              $.ajax({
                 url: '$otpUrl',
                 data: {phone: phone,_csrf:'$csrf'},
                 method:'POST',
                 beforeSend:function(){
                        $('button#request-otp-btn').prop('disabled',true);
                    },
                error:function( xhr, err ) {
                            alert('An error occurred, please try again');
                     },
                 complete:function(){
                        $('button#request-otp-btn').prop('disabled',false);
                    },
                 success: function(data){
                            if(data.success==false){
                                alert(data.msg);
                                return false;
                            }else{
                                // $('#section-1').hide();
                                // $('#section-2').show();
                                alert(data.msg);
                            }
                            
                   }
              });
           }
        }, 200);
    }
     $('button#login-button').click(function(){
        login();
    });
    function login(){
        var form = $('#login-form') 
        form.yiiActiveForm('validateAttribute', 'loginform-password'); //To Validate the password/otp field
        setTimeout(function(){
          var otp = $('#loginform-password').val();
          var isOtpValid = ($('div.field-loginform-password.has-error').length==0);
          if(otp!='' && isOtpValid){
              $.ajax({
                 url: '$loginUrl',
                 data:form.serialize(),
                 dataType: 'json',
                 method:'POST',
                 beforeSend:function(){
                        $('button#login-button').prop('disabled',true);
                       },
                 error:function( xhr, err ) {
                         alert('An error occurred, please try again');     
                    },
                 complete:function(){
                        $('button#login-button').prop('disabled',false);
                    },
                 success: function(data){
                            if(data.success==true){
                                alert(data.msg);
                                window.location="$loginSuccessUrl";
                            }else{
                                alert(data.msg);
                            }
                            
                   }
              });
           }
        }, 200);
    }
JS;
$position = \yii\web\View::POS_READY;
$this->registerJs($script, $position);
?>