<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

$this->title = Yii::t('app','Login');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <h1><?= $this->title?></h1>

    <p><?= Yii::t('app','Please fill out the following fields to login:');?></p>

    <?php $form = ActiveForm::begin([
        'id' => 'login-form',
        'options' => [ 'enctype' => 'multipart/form-data'],
    ]); ?>

    <?= $form->field($model, 'username')->textInput(['value' => 'admin']) ?>

    <?= $form->field($model, 'password')->passwordInput(['value' => '12345678']) ?>

    <?= $form->field($model, 'verifyCode', ['inputOptions' => ['autocomplete' => 'off']])->widget(Captcha::className(), [
        'template' => '<div class="row"><div id="captcha-image" class="col-lg-4">{image}</div><div class="col-lg-8">{input}</div></div>',
    ]) ?>
    
    <div class="form-group">
      <?= Html::submitButton(Yii::t('app', 'Login'), ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
      <?= Html::button('重新整理', ['class' => 'btn btn-primary', 'name' => 'login-button', 'onclick' => 'refreshImage();']) ?>
      <?= Html::a(Yii::t('app', 'Forgot Password'), ['site/requestpasswordreset'], ['class' => 'btn'])?>
    </div>
    <?php ActiveForm::end(); ?>

</div>
<script>
function refreshImage() {
    let captchaImage = $('#loginform-verifycode-image').attr('src');
    let newCaptchaImage = '<img id="loginform-verifycode-image" src="' + captchaImage + '" alt />';

    $('#captcha-image').empty().html(newCaptchaImage);
};
</script>
