<?php

/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;
use common\models\Config;
use common\models\Definitions;
use common\models\User;

$model_general = common\models\General::findOne(1);

$this->title = Yii::t('app', 'My Information').' - '.Yii::t('app', "My Account");

// Yii::$app->params['page_header_title'] = Yii::t('app', 'LST Shop');
// Yii::$app->params['page_header_img'] = '/images/page_header_img-shop.jpg';

// sYii::$app->params['breadcrumbs'][] = ['label' => Yii::t('app', 'LST Shop'), 'url' => ['/shop']];
// Yii::$app->params['breadcrumbs'][] = Yii::t('app', "My Account");
Yii::$app->params['breadcrumbs'][] = Yii::t('app', "My Account");
Yii::$app->params['breadcrumbs'][] = Yii::t('app', 'My Information');

$this->registerJs(<<<JS
disableSubmitButtons();
JS
);
// Yii::$app->user->identity->img != "" ? Yii::$app->user->identity->img : "http://0.gravatar.com/avatar/640f436c8d5986130f28d0a5dc8c6b86?s=70&amp;d=mm&amp;r=g"
?>
<?= $this->render('../layouts/_user_header') ?>
			<?= Alert::widget() ?>
    <div class="page-my-account">
        <div class="content">
            <div class="">
<?php $form = ActiveForm::begin([
        'options' => ['class' => 'disable-submit-buttons'],
        // 'enableClientValidation' => true,
        // 'enableClientScript' => true,
        // 'validateOnSubmit' => false,
        // 'enableAjaxValidation' => false
]); ?>
        <?php
        // = $form->field($model, 'ua_status')->textInput(['value' => Definitions::getUserApplicationStatus($model->user_appl_status), 'disabled' => true]);
        ?>
<?php 
        if ($model->user_appl_status >= User::USER_APPL_STATUS_ALLOCATED_UNIT) {
            echo $form->field($model, 'user_project')->textInput(['value' => Definitions::getProjectName($model->application->project), 'disabled' => true]);
            echo $form->field($model, 'user_room_no')->textInput(['value' => $model->room_no, 'disabled' => true]);
            echo $form->field($model, 'user_start_date')->textInput(['value' => $model->start_date, 'disabled' => true]);
        }
?>
        <div class="text-right" style="margin-top:10px;"><span style="color: #b20000;">*</span>號欄位, 必須填寫</div>
        <?= $form->field($model, 'chi_name')->textInput(); ?>
        <?= $form->field($model, 'eng_name')->textInput(); ?>
        <?= $form->field($model, 'mobile')->textInput(['disabled'=>true]); ?>
<?php if (Yii::$app->user->identity->oAuth_user == 1) { ?>
        <?= $form->field($model, 'email', ['options' => ['class' => 'form-group']])->textInput()->input('email', ['placeholder' => ""]); ?>
<?php } else { ?>
        <?= $form->field($model, 'email', ['options' => ['class' => 'form-group']])->textInput()->input('email', ['placeholder' => ""]); ?>
        <legend><?= Yii::t('app', 'Password change') ?></legend>
        <div class="pull-right"><i class="fa fa-eye-slash" style="color:#888;" onclick="showPassword(this);"></i></div>
        <?= $form->field($model, 'old_password')->textInput(['type'=>"password"]); ?>
        <div class="pull-right"><i class="fa fa-eye-slash" style="color:#888;" onclick="showPassword(this);"></i></div>
        <?= $form->field($model, 'new_password')->textInput(['type'=>"password"])->label('新密碼（留空不變，必須為大楷英文、小楷英文及數字的<span class="red">任意</span>組合）'); ?>
        <div class="pull-right"><i class="fa fa-eye-slash" style="color:#888;" onclick="showPassword(this);"></i></div>
        <?= $form->field($model, 're_new_password')->textInput(['type'=>"password"]); ?>
<?php } ?>
                <p>
                    <?= Html::submitButton(Yii::t('app', 'SAVE CHANGES'), ['class' => 'btn btn-dark']) ?>
                </p>
                <p>&nbsp;</p>
<?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
<script>
function showPassword(_this){
  if ($(_this).hasClass('fa-eye-slash')) {
    $(_this).removeClass('fa-eye-slash').addClass('fa-eye').closest('div').next().find('input[type="password"]').attr('type','text');
  } else if ($(_this).hasClass('fa-eye')) {
    $(_this).removeClass('fa-eye').addClass('fa-eye-slash').closest('div').next().find('input[type="text"]').attr('type','password');
  }
}
</script>
