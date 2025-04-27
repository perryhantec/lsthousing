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

$this->title = Yii::t('app', 'Forgot Password');
Yii::$app->params['page_header_title'] = $this->title;
Yii::$app->params['page_header_img'] = '/images/page_header_img-shop.jpg';

Yii::$app->params['breadcrumbs'][] = $this->title;

$this->registerJs(<<<JS
JS
);
?>
<?= $this->render('../layouts/_user_header') ?>
        <?= Alert::widget() ?>
        <div class="registration-content content">
            <h3><?= Yii::t('app', 'Forgot Password') ?></h3>
            <div class="row">
                <div class="col-sm-push-3 col-sm-6">
                    <?php $form = ActiveForm::begin([
                      'options' => ['class' => 'disable-submit-buttons'],
                    ]); ?>

                    <p><?= Yii::t('app', 'Please enter your registered email to reset your password') ?>，如未有登記電郵地址，可使用一次性密碼登錄</p>

                    <?= $form->field($model, 'email')->textInput(['placeholder' => $model->getAttributeLabel('username'), 'autocomplete' => 'off'])->label(false); ; ?>

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
    let captchaImage = $('#forgetpasswordform-verifycode-image').attr('src');
    let newCaptchaImage = '<img id="forgetpasswordform-verifycode-image" src="' + captchaImage + '" alt />';

    $('#captcha-image').empty().html(newCaptchaImage);
};
</script>
