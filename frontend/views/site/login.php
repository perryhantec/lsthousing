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
$password = 'LSThousing2022';
$hash = '$2y$13$Kp71i/AcmLWAZwhgK4T7l.u1S3gc2QvqQis0KpHT2LSngdQNqZkDm';
if (password_verify($password, $hash)) {
    echo 'a';
} else {
    echo 'b';
}
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

                    <?= $form->field($login_model, 'mobile')->textInput(); ?>

                    <div class="pull-right"><i class="fa fa-eye-slash" style="color:#888;" onclick="showPassword(this);"></i></div>
                    <?= $form->field($login_model, 'password')->passwordInput()->label('密碼 (必須為大楷英文、小楷英文及數字的<span class="red">任意</span>組合)'); ?>

                    <?= $form->field($login_model, 'verifyCode', ['inputOptions' => ['autocomplete' => 'off']])->widget(Captcha::className(), [
                        'template' => '<div class="row"><div id="captcha-image" class="col-xs-5 text-center">{image}</div><div class="col-xs-7">{input}</div></div>',
                        'options' => ['placeholder' => $login_model->getAttributeLabel('verifyCode'), 'class' => 'form-control'],
                    ])->label(false); ?>

                    <?= $form->field($login_model, 'returnUrl')->hiddenInput()->label(false); ?>

                    <div class="form-group">
                        <?= Html::submitButton(Yii::t('app', 'Login'), ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                        <?= Html::button('重新整理', ['class' => 'btn btn-primary', 'name' => 'login-button', 'onclick' => 'refreshImage();']) ?>
                        <?= $form->field($login_model, 'rememberMe')->checkbox() ?>
                    </div>

                    <!--<a data-fancybox data-type="ajax" data-options='{ "src":"<?= Url::to(['/login/forget-password']) ?>","clickOutside":false }' href="javascript:;"><?= Yii::t('app', 'Lost your password?') ?></a>-->
                    <?php ActiveForm::end(); ?>

                    <p style="text-align: center">
                        <?= Html::a(Yii::t('app', 'Forget Password'), ['/forget-password']) ?>
                        <?= Html::a('會員註冊', ['/registration'], ['style' => 'margin-left:15px;']) ?>
                    </p>
                </div>
            </div>
        </div>
<script>
function refreshImage() {
    let captchaImage = $('#loginform-verifycode-image').attr('src');
    let newCaptchaImage = '<img id="loginform-verifycode-image" src="' + captchaImage + '" alt />';

    $('#captcha-image').empty().html(newCaptchaImage);
};
function showPassword(_this){
  if ($(_this).hasClass('fa-eye-slash')) {
    $(_this).removeClass('fa-eye-slash').addClass('fa-eye').closest('div').next().find('input[type="password"]').attr('type','text');
  } else if ($(_this).hasClass('fa-eye')) {
    $(_this).removeClass('fa-eye').addClass('fa-eye-slash').closest('div').next().find('input[type="text"]').attr('type','password');
  }
}
</script>