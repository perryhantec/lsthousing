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

$this->title = Yii::t('app', 'Reset password');
Yii::$app->params['page_header_title'] = $this->title;
Yii::$app->params['page_header_img'] = '/images/page_header_img-shop.jpg';

Yii::$app->params['breadcrumbs'][] = $this->title;

$this->registerJs(<<<JS
JS
);
?>
        <?= Alert::widget() ?>
        <div class="registration-content content">
            <div class="pull-right" style="margin-top:10px;"><span style="color: #b20000;">*</span>號欄位, 必須填寫</div>
            <h3><?= Yii::t('app', 'Reset password') ?></h3>
            <div class="row">
                <div class="col-sm-push-3 col-sm-6">
                    <?php $form = ActiveForm::begin([
                      'options' => ['class' => 'disable-submit-buttons'],
                    ]); ?>

                    <div class="pull-right"><i class="fa fa-eye-slash" style="color:#888;" onclick="showPassword(this);"></i></div>
                    <?= $form->field($model, 'new_password')->textInput(['type'=>"password"])->label('密碼 (必須為大楷英文、小楷英文及數字的<span class="red">任意</span>組合)'); ?>

                    <div class="pull-right"><i class="fa fa-eye-slash" style="color:#888;" onclick="showPassword(this);"></i></div>
                    <?= $form->field($model, 're_new_password')->textInput(['type'=>"password"]); ?>

                    <hr />

                    <?= $form->field($model, 'verifyCode')->widget(Captcha::className(), [
                        'template' => '<div class="row"><div id="captcha-image" class="col-xs-5 text-center">{image}</div><div class="col-xs-7">{input}</div></div>',
                        'options' => ['placeholder' => $model->getAttributeLabel('verifyCode'), 'class' => 'form-control'],
                    ])->label(false); ?>

                    <div class="form-group">
                      <?= Html::submitButton(Yii::t('app', 'Submit'), ['class' => 'btn btn-primary', 'name' => 'registration-button']) ?>
                      <?= Html::button('重新整理', ['class' => 'btn btn-primary', 'name' => 'login-button', 'onclick' => 'refreshImage();']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>
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