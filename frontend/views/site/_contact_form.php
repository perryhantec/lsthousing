<?php

/* @var $this yii\web\View */
use yii\helpers\Html;
use kartik\form\ActiveForm;
use yii\captcha\Captcha;
?>
<script src="https://www.google.com/recaptcha/api.js"></script>
<h3><?= Yii::t('web', 'Please fill in the form')?></h3>
<div>
<?php $form = ActiveForm::begin([
                'id'=>'contact-us-form',
                'options' => [ 'enctype' => 'multipart/form-data'],
                'enableAjaxValidation'=>false,
                'enableClientValidation' => true,
                'type' => ActiveForm::TYPE_HORIZONTAL,
                'formConfig' => ['labelSpan' => 2, 'deviceSize' => ActiveForm::SIZE_SMALL]
            ]); ?>

    <?= $form->field($model, 'name')->textInput()->label(Yii::t('web', '{0}:', [$model->getAttributeLabel('name')]));  ?>

    <?= $form->field($model, 'phone')->textInput()->label(Yii::t('web', '{0}:', [$model->getAttributeLabel('phone')]));  ?>

    <?= $form->field($model, 'email')->textInput()->label(Yii::t('web', '{0}:', [$model->getAttributeLabel('email')])); ?>

    <?= $form->field($model, 'body')->textArea(['rows'=>4])->label(Yii::t('web', '{0}:', [$model->getAttributeLabel('body')])); ?>
    
    <?= $form->field($model, 'reCaptcha')->widget(
      \himiklab\yii2\recaptcha\ReCaptcha3::className(),
      [
        //'siteKey' => '6LdrmHIgAAAAAPnABgLIbc6QrwlF4614m0EED35h',
        'action' => 'contact'
      ]
    )->label(false) ?>
<?php if (0) { ?>
    <?= $form->field($model, 'verifyCode')->widget(Captcha::className(), [
        'template' => '<div class="row"><div id="captcha-image" class="col-lg-4">{image}</div><div class="col-lg-8">{input}</div></div>',
    ])->label(Yii::t('web', '{0}:', [$model->getAttributeLabel('verifyCode')])); ?>
<?php } ?>
    <div class="row">
        <div class="col-sm-2 col-sm-push-2">
          <?= Html::submitButton(Yii::t('app','Submit'), ['class' => 'btn btn-primary']);?>
<?php if (0) { ?>
          <?= Html::button('重新整理', ['class' => 'btn btn-primary', 'name' => 'login-button', 'onclick' => 'refreshImage();']) ?>
<?php } ?>
        </div>
    </div>

<?php ActiveForm::end(); ?>
</div>
<script>
// function refreshImage() {
//     let captchaImage = $('#loginform-verifycode-image').attr('src');
//     let newCaptchaImage = '<img id="loginform-verifycode-image" src="' + captchaImage + '" alt />';
// 
//     $('#captcha-image').empty().html(newCaptchaImage);
// };
function onSubmit(token) {
  document.getElementById("contact-us-form").submit();
  console.log('abc');
}
</script>