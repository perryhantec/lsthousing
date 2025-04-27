<?php

/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use yii\widgets\Breadcrumbs;
use yii\captcha\Captcha;
use common\widgets\Alert;
use common\models\Config;
use common\models\Definitions;

$model_general = common\models\General::findOne(1);

$this->title = Yii::t('app', 'Registration');
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
            <div class="pull-right" style="margin-top:10px;"><span style="color: #b20000;">*</span>號欄位, 必須填寫</div>
            <h3><?= Yii::t('app', 'Registration') ?></h3>
            <div class="row">
                <div class="col-sm-push-3 col-sm-6">
                    <?php $form = ActiveForm::begin([
                        'id' => 'registration-form',
                        // 'enableAjaxValidation' => false,
                        'validateOnSubmit' => false,
                    ]); ?>

                    <?= $form->field($registration_model, 'chi_name')->textInput(); ?>
                    <?= $form->field($registration_model, 'eng_name')->textInput(); ?>

                    <?= $form->field($registration_model, 'mobile')->textInput(); ?>
                    <?= $form->field($registration_model, 'email')->textInput(['placeholder' => "電郵會用作重設密碼之用"]); ?>
<?php if (false) { ?>
                    <?= $form->field($registration_model, 'username')->textInput()->input('email', ['placeholder' => ""]); ?>
<?php } ?>
                    <div class="pull-right"><i class="fa fa-eye-slash" style="color:#888;" onclick="showPassword(this);"></i></div>
                    <?= $form->field($registration_model, 'new_password')->passwordInput()->label('密碼 (必須為大楷英文、小楷英文及數字的<span class="red">任意</span>組合)'); ?>
                    <div class="pull-right"><i class="fa fa-eye-slash" style="color:#888;" onclick="showPassword(this);"></i></div>
                    <?= $form->field($registration_model, 're_new_password')->passwordInput(); ?>

                    <hr />

                    <?php /* $form->field($registration_model, 'verifyCode')->widget(Captcha::className(), [
                        'template' => '<div class="row"><div class="col-xs-4 text-center">{image}</div><div class="col-xs-8">{input}</div></div>',
                        'options' => ['placeholder' => $registration_model->getAttributeLabel('verifyCode'), 'class' => 'form-control'],
                    ])->label(false); */ ?>

                    <?php /* $form->field($registration_model, 'acknowledge_tc')->checkbox(); */ ?>

                    <section>
                        <?= $form->field($registration_model, 'part5_t1', ['options' =>  ['class' => 'terms']])->checkbox(['label' => Definitions::getPart5Terms(1),'uncheck' => null]); ?>
                        <?= $form->field($registration_model, 'part5_t2', ['options' =>  ['class' => 'terms']])->checkbox(['label' => Definitions::getPart5Terms(2),'uncheck' => null]); ?>
                        <?= $form->field($registration_model, 'part5_t3', ['options' =>  ['class' => 'terms']])->checkbox(['label' => Definitions::getPart5Terms(3),'uncheck' => null]); ?>
                        <?= $form->field($registration_model, 'part5_t4', ['options' =>  ['class' => 'terms']])->checkbox(['label' => Definitions::getPart5Terms(4),'uncheck' => null]); ?>
                        <?= $form->field($registration_model, 'part5_t5', ['options' =>  ['class' => 'terms']])->checkbox(['label' => Definitions::getPart5Terms(5),'uncheck' => null]); ?>
                        <?= $form->field($registration_model, 'part5_t6', ['options' =>  ['class' => 'terms']])->checkbox(['label' => Definitions::getPart5Terms(6),'uncheck' => null]); ?>
                        <div class="clearfix"></div>
                    </section>
                    <hr />
                    <section class="part6">
                        <ol>
                            <li>九龍樂善堂（下稱「本堂」）及其代表會使用透過樂善堂社會房屋計劃-「樂屋」（下稱「項目」）申請表格所獲得有關你的資料（下稱「資料」）作下列用途及與下列直接有關的用途：
                                <ol>
                                    <li>辦理及審批在本項目下申請人遞交的申請，並在有需要時就與本項目有關的事宜聯絡你；</li>
                                    <li>執行本項目及進行與本申請有關的審核及調查，包括根據政府及審核期間(包括但不限於家庭、面談、電話查詢等)所提供之個人及家庭成員資料，與你在本申請表提供的資料作核對，以確定申請人及／或家庭成員是否符合本目的受惠資格；</li>
                                    <li>作統計及研究用途，其目的包括但不限於了解項目向受惠對象提供援助的成效及受惠對象的居住環境情況，而得的統計數字及研究結果，不會以能辨識任何資料當事人或其中任何人的身份的形式顯示；及</li>
                                    <li>作法律規定、授權或許可的用途。</li>
                                </ol>
                            </li>
                            <li>提供個人資料純屬自願，但你如果沒有提供足夠和正確的資料，本堂及其代表可能無法處理申請人遞交的申請，而致請被拒。</li>
                        </ol>
                        <?= $form->field($registration_model, 'part6_t1', ['options' =>  ['class' => 'terms']])->checkbox(['label' => Definitions::getPart6Terms(1),'uncheck' => null]); ?>
                        <div class="clearfix"></div>
                    </section>

                    <hr />

                    <?= $form->field($registration_model, 'verifyCode', ['inputOptions' => ['autocomplete' => 'off']])->widget(Captcha::className(), [
                        'template' => '<div class="row"><div id="captcha-image" class="col-xs-5 text-center">{image}</div><div class="col-xs-7">{input}</div></div>',
                        'options' => ['placeholder' => $registration_model->getAttributeLabel('verifyCode'), 'class' => 'form-control'],
                    ])->label(false); ?>
                    
                    <div class="form-group">
                      <?= Html::submitButton(Yii::t('app', 'Register'), ['class' => 'btn btn-primary', 'name' => 'registration-button']) ?>
                      <?= Html::button('重新整理', ['class' => 'btn btn-primary', 'name' => 'login-button', 'onclick' => 'refreshImage();']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
<script>
function refreshImage() {
    let captchaImage = $('#userregistrationform-verifycode-image').attr('src');
    let newCaptchaImage = '<img id="userregistrationform-verifycode-image" src="' + captchaImage + '" alt />';

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