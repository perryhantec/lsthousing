<?php

/* @var $this yii\web\View */
use yii\helpers\ArrayHelper;
// use yii\helpers\Html;
use yii\helpers\Url;
// use yii\bootstrap\ActiveForm;
use kartik\form\ActiveForm;
use yii\widgets\Breadcrumbs;
use kartik\widgets\FileInput;
use common\widgets\Alert;
use common\models\Config;
use common\models\Definitions;
use common\models\Test;
use common\components\MultipleInput;
use unclead\multipleinput\TabularColumn;
use yii\web\JsExpression;
use kartik\icons\Icon;
use common\models\File;
use common\utils\Html;

$model_general = common\models\General::findOne(1);

$this->title = '上載文件 - 詳細';

// Yii::$app->params['page_header_title'] = Yii::t('app', 'LST Shop');
// Yii::$app->params['page_header_img'] = '/images/page_header_img-shop.jpg';

// Yii::$app->params['breadcrumbs'][] = ['label' => Yii::t('app', 'LST Shop'), 'url' => ['/shop']];
Yii::$app->params['breadcrumbs'][] = Yii::t('app', "My Account");
Yii::$app->params['breadcrumbs'][] = ['label' => '上載文件 - 總覽', 'url' => ['upload']];
Yii::$app->params['breadcrumbs'][] = '上載文件 - 詳細';

$this->registerJs(<<<JS
JS
);

?>
<?= $this->render('../layouts/_user_header') ?>
    <div class="page-my">
        <div class="content">
            <div class="">
                
<div>

<?php 
    $form = ActiveForm::begin([
        'id' => 'test-form',
        'options'=>['enctype'=>'multipart/form-data','onsubmit' => 'submitForm(event)'],
        // 'enableAjaxValidation' => false,
    ]);
    echo $form->errorSummary($model);
/*
    // echo $form->field($model, 'upload_files[]')->fileInput(['accept' => 'image/png, image/jpeg, application/pdf', 'multiple' => true])->label(false);
    echo $form->field($model, 'upload_files[]')->widget(FileInput::classname(), [
        'options' => ['accept' => 'image/png, image/jpeg, application/pdf', 'multiple' => true],
        'pluginOptions' => [
            // 'showPreview' => false,
            'previewFileType' => 'any',

            // 'showCaption' => false,
            'showRemove' => false,
            // 'showUpload' => false,
            'showUpload' => true,
            // 'browseClass' => 'btn btn-primary btn-block',
            'browseIcon' => '<i class="fa fa-file"></i> ',
            'browseLabel' => '選擇文件',
            'uploadUrl' => Url::to(['/test/upload', 'id' => 2]),
            // 'uploadExtraData' => [
            //     'album_id' => 20,
            //     'cat_id' => 'Nature'
            // ],
            // "uploadAsync" => true,
            'maxFileSize'=> 209715200,
            'maxFileCount' => 50
        ]
    ])->label(false);
    */
?>

<div class="box box-success">
    <div class="box-header with-border">
      <h3 class="box-title"><?= Icon::show('file-o').Yii::t('app', '文件') ?></h3>
    </div>
    <div class="box-body">
      <?=
      $form->field($model, 'upload_files')->widget(MultipleInput::class, [
          'columns' => [
              [
                  'name' => 'id',
                  'type' => TabularColumn::TYPE_HIDDEN_INPUT
              ], [
                  'name' => 'file_key',
                  'type' => TabularColumn::TYPE_HIDDEN_INPUT
              ], [
                  'name' => 'upload_file',
                  'type' => FileInput::class,
                  'headerOptions' => [
                      'class' => 'success',
                  ],
                  'title' => '上傳',
                  'options' => function($data) {
                    return[
                        'pluginOptions' => [
//                            'initialPreview' => $data['file_id'] ? Url::to(['attachement-download', 'id' => $data['id'], 'attribute' => 'file_id', 'auth_key' => File::findOne($data['file_id'])]) : '',
                            'initialPreviewAsData' => true,
                            'initialPreviewShowDelete' => false,
                            'uploadUrl' => Url::to(['/test/upload']),
                        ],
                        'pluginEvents' => [
                            'fileuploaded' => new JsExpression('function(event, data){var tr = $(this).closest("tr");tr.find("input[name$=\"[file_key]\"]").val(data.response.data.auth_key);}'),
                            'fileclear' => new JsExpression('function(event, data){var tr = $(this).closest("tr");tr.find("input[name$=\"[file_key]\"]").val("");}'),
                        ],
                    ];
                  }
              ], [
                  'name' => 'remarks',
                  'title' => Yii::t('app', '備註'),
                  'type' => TabularColumn::TYPE_TEXT_INPUT,
                  'headerOptions' => [
                      'class' => 'success',
                  ]
              ],
          ]
      ])->label(false);
      ?>
    </div>
  </div>

</div>
<?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
<?= Html::a(Yii::t('app', 'Back'), Yii::$app->request->referrer, ['class' => 'btn btn-primary', 'style' => 'margin-left:10px;']) ?>
<?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
<script>
function submitForm(e) {
    // e.preventDefault();
}
</script>