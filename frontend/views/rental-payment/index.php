<?php

/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use yii\widgets\Breadcrumbs;
use kartik\widgets\FileInput;
use common\widgets\Alert;
use common\models\Config;
use common\models\Definitions;
use common\models\Menu;
use common\models\User;
use common\models\Application;

$menu_model = Menu::findOne(['url' => 'rental-payment']);
$user_model = User::findOne(['id' => Yii::$app->user->id]);

if ($menu_model != null) {
    Yii::$app->params['page_route'] = $menu_model->route;
    $_subMenus = $menu_model->allSubMenu;

    $this->title = strip_tags($menu_model->name);
    Yii::$app->params['page_header_title'] = $menu_model->name;

    foreach ($_subMenus as $_subMenu) {
        Yii::$app->params['breadcrumbs'][] = strip_tags($_subMenu->name);
        if ($_subMenu->banner_image_file_name != "")
            Yii::$app->params['page_header_img'] = $_subMenu->banner_image_file_name;
    }
    if (sizeof($_subMenus) > 0)
        Yii::$app->params['page_header_title'] = $_subMenus[0]->name;

    Yii::$app->params['breadcrumbs'][] = $this->title;
}

$this->registerJs(<<<JS
JS
);

// $app_no = 'LSTH';

// $no_of_zero = User::APP_NO_ZERO - strlen(Yii::$app->user->id);

// echo User::APP_NO_ZERO.'<br />';
// echo Yii::$app->user->id.'<br />';
// echo $no_of_zero.'<br />';
// $app_no = str_pad($app_no, $no_of_zero, '0').Yii::$app->user->id;
// echo $app_no.'<br />';

$_labelSpan = Yii::$app->language == 'en' ? 4 : 3;
?>
    <div class="row">
<?php if (sizeof($_subMenus) > 0) { ?>
        <div class="col-md-3">
            <?= $this->render('../layouts/_body_left_nav', ['menus' => $_subMenus[0]->getActiveSubMenu()->orderBy(['seq' => SORT_ASC])->all()]); ?>
        </div>
        <div class="col-md-9 has-sub-nav">
<?php } else { ?>
        <div class="col-sm-12">
<?php } ?>
            <div id="rental-payment" class="application content">
                <h3><?= $menu_model->name ?></h3>

                <?= Alert::widget() ?>
<?php
if ($user_model->user_appl_status == User::USER_APPL_STATUS_ALLOCATED_UNIT) {
  if ($user_model->application->application_status == Application::APPL_STATUS_ALLOCATED_UNIT) {
?>
<hr />
<h2 class="green"><strong><u>請上載上述文件</u></strong></h2>
<p>住戶可在此上載每月交租文件，如銀行入數紙、網上銀行轉賬截圖等</p>
<ul>
    <li>每次最多上載 3 個檔案</li>
    <li>總上限為 200MB</li>
    <li>可上載文件種類：jpeg，jpg，png，pdf</li>
    <li>檔案只能上載一次</li>
    <li>按住 Ctrl 或 Command 鍵可以選擇多個檔案</li>
    <li>如有查詢，可電郵至 <a href="mailto:housing@loksintong.org">housing@loksintong.org</a></li>
    <li>如文件有誤，本堂職員會通知 閣下再次上載文件</li>
</ul>
<div>
<?php 
    $form = ActiveForm::begin([
        'id' => 'rental-payment-form',
        'options'=>['enctype'=>'multipart/form-data'],
        // 'enableAjaxValidation' => false,
    ]);
    // echo $form->errorSummary($model);

    // echo $form->field($model, 'upload_files[]')->fileInput(['accept' => 'image/png, image/jpeg, application/pdf', 'multiple' => true])->label(false);
    echo $form->field($model, 'upload_files[]')->widget(FileInput::classname(), [
        'options' => ['accept' => 'image/png, image/jpeg, application/pdf', 'multiple' => true],
        'pluginOptions' => [
            // 'showPreview' => false,
            'previewFileType' => 'any',

            // 'showCaption' => false,
            'showRemove' => false,
            'showUpload' => false,
            // 'browseClass' => 'btn btn-primary btn-block',
            'browseIcon' => '<i class="fa fa-file"></i> ',
            'browseLabel' => '選擇文件',
            // 'uploadUrl' => Url::to(['/my/upload-detail', 'id' => 2]),
            // 'uploadExtraData' => [
            //     'album_id' => 20,
            //     'cat_id' => 'Nature'
            // ],
            // "uploadAsync" => true,
            'maxFileSize'=> 209715200,
            'maxFileCount' => 3
        ]
    ])->label(false);
?>
    <?= $form->field($model, 'payment_year')->textInput(['type' => 'number', 'placeholder' => '請輸入年份']) ?>
    <?= $form->field($model, 'payment_month')->textInput(['type' => 'number', 'placeholder' => '請輸入月份']) ?>

</div>
<hr />
<?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
<?= Html::a(Yii::t('app', 'Back'), Yii::$app->request->referrer, ['class' => 'btn btn-primary', 'style' => 'margin-left:10px;']) ?>
<?php ActiveForm::end(); ?>
  <?php } else if ($user_model->application->application_status == Application::APPL_STATUS_ALLOCATED_OTHER_UNIT) { ?>
      <div><em>已編配其他單位</em></div>
  <?php } else if ($user_model->application->application_status == Application::APPL_STATUS_WITHDREW) { ?>
      <div><em>已退租</em></div>
  <?php } else { ?>
      <div><em>未編配單位</em></div>
  <?php } ?>

<?php } else { ?>
    <div><em>未編配單位</em></div>
<?php } ?>

            </div>
        </div>
    </div>
