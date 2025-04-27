<?php

/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\helpers\Url;
use yii\captcha\Captcha;
use kartik\form\ActiveForm;
// use yii\widgets\ActiveForm;
use kartik\widgets\FileInput;
use common\widgets\Alert;
use common\models\Menu;
// use common\models\Donation;
use common\models\Definitions;
use common\models\User;
use kartik\widgets\DatePicker;

// Yii::$app->params['page_header_img'] = '/images/page_header_img-donation.jpg';

$menu_model = Menu::findOne(['url' => 'household-activity']);
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
            <div id="household-activity" class="application content">
                <h3><?= $menu_model->name ?></h3>

                <?= Alert::widget() ?>

<?php  if ($user_model->user_appl_status == User::USER_APPL_STATUS_ALLOCATED_UNIT) { ?>
<?php $form = ActiveForm::begin([
                'id' => 'household-activity-form',
                'action' => Url::current(['_lang' => null]),
                'type' => ActiveForm::TYPE_HORIZONTAL,
                'formConfig' => ['labelSpan' => $_labelSpan, 'deviceSize' => ActiveForm::SIZE_SMALL],
                // 'options' => ['enctype' => 'multipart/form-data']

                // 'method' => 'post',
                // 'action' => ['/'],
                // 'fieldConfig' => [
                //     'options' => [
                //         'tag' => false,
                //     ],
                // ],
                // 'enableAjaxValidation' => false,
                // 'enableClientValidation' => false,
                // 'enableClientScript' => false,
                'validateOnSubmit' => false
            ]); ?>
                <h1 class="text-center">住戶報名活動表格</h1>
                <hr />
                <section>
                    <?= $form->errorSummary($model) ?>

                    <?= $form->field($model, 'title')->textInput(); ?>
                    <?= $form->field($model, 'date')->widget(DatePicker::classname(), [
                        'options' => [],
                        'type' => 3,
                        'pluginOptions' => [
                            'autoclose'=>true,
                            'format' => 'yyyy-mm-dd',
                            'weekStart' => 0,
                //            'startDate' => date('Y-m-d'),
                            'todayBtn' => "linked",
                        ]
                    ]);?>
                    <?= $form->field($model, 'time')->textInput(); ?>
                    <?= $form->field($model, 'location')->textInput(); ?>
                    <?= $form->field($model, 'close_date')->widget(DatePicker::classname(), [
                        'options' => [],
                        'type' => 3,
                        'pluginOptions' => [
                            'autoclose'=>true,
                            'format' => 'yyyy-mm-dd',
                            'weekStart' => 0,
                //            'startDate' => date('Y-m-d'),
                            'todayBtn' => "linked",
                        ]
                    ]);?>
                    <?= $form->field($model, 'name')->textInput(); ?>
                    <?= $form->field($model, 'mobile')->textInput(); ?>
                    <?= $form->field($model, 'no_of_ppl')->textInput(['type' => 'number']); ?>
                    <?= $form->field($model, 'remarks')->textArea(['rows' => 5]); ?>
                </section>
                <hr />

                <div class="row" style="padding-top: 10px;">
                    <div class="col-sm-<?= (12 - $_labelSpan) ?>">
                      <?= Html::submitButton(Yii::t('app','Submit'), ['class' => 'btn btn-primary']);?>
                    </div>
                </div>

<?php ActiveForm::end(); ?>
<?php } else { ?>
    <div><em>未編配單位</em></div>
<?php } ?>
            </div>
        </div>
    </div>