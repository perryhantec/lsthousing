<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use mihaildev\elfinder\InputFile;
use common\models\Definitions;
use kartik\widgets\ColorInput;
use mihaildev\ckeditor\CKEditor;
use mihaildev\elfinder\ElFinder;
use bupy7\cropbox\CropboxWidget;
use kartik\widgets\FileInput;
use yii\web\JsExpression;
use kartik\sortable\Sortable;

$this->title =  '關於樂屋 - '.(($model->isNewRecord)? Yii::t('app', 'Create'):Yii::t('app', 'Update'));

$this->params['breadcrumbs'][] = ['label' => '關於樂屋', 'url' => ['index']];
if (!$model->isNewRecord)
    $this->params['breadcrumbs'][] = ['label' => '關於樂屋', 'url' => ['update', 'id' => $model->id]];
$this->params['breadcrumbs'][] = (($model->isNewRecord)? Yii::t('app', 'Create'):Yii::t('app', 'Update'));

$this->registerJs(<<<JS
    $('.about-us-form-icon_file-img')
        .popover({trigger: 'hover', placement: 'top'})
        .click(function() {
            $('input[name="'+$(this).attr("data-input-name")+'"]').val("");
            $(this).parents('.form-group').remove();
            $('.field-aboutusform-icon_file').show();
        });
JS
);

if ($model::HAVE_IMAGE_TUMB)
    $this->registerJs(<<<JS
        $('.about-us-picture_file_names-remove')
            .click(function() {
                $(this).parents('li').remove();
            });
JS
);
?>
<br>
 <div class="modal-content">
   <div class="modal-body">
   <?php $form = ActiveForm::begin([
    //'enableAjaxValidation' => true,
    'options' => ['enctype' => 'multipart/form-data']
   ]); ?>
     <?= $form->field($model, 'show_year')->textInput(['type' => 'number']) ?>
     <?= $form->field($model, 'color')->widget(ColorInput::classname(), ['options' => ['placeholder' => 'Select Color...'],]); ?>

<?php if ($model::HAVE_ICON) { ?>
        <?= $form->field($model, 'icon_file_name')->hiddenInput()->label(false); ?>
        <?php if (!empty($model->icon_file_name)) { ?>
        <div class="form-group field-about-us-icon_file_name">
            <label class="control-label" for="about-us-icon_file_name">Icon</label>
            <div class="form-control-static">
                <?= Html::tag('span', Html::img(Yii::$app->urlManager->createUrl('../'.$model->iconDisplayPath)), [
                        'class' => "image-remove-trigger about-us-form-icon_file-img thumbnail",
                        'title' => Yii::t('app', 'Remove'),
                        'data-input-name' => 'AboutUsForm[icon_file_name]',
                        'data-toggle' => "popover",
                        'data-content' => Yii::t('app', 'Click to remove image'),
                    ]) ?>
            </div>
        </div>
        <?php } ?>
        <?= $form->field($model, 'icon_file', ['options' => ['class' => 'form-group ', 'style' => ($model->iconDisplayPath == "" ? "":"display:none")]])->widget(FileInput::classname(), [
                'options' => ['accept' => 'image/png, image/jpeg, image/gif', 'multiple' => false],
                'pluginOptions' => [
                    'previewFileType' => 'any',
                    'showUpload' => false,
                ]
            ])->hint('請上傳 78 x 60 的圖像');
        ?>
<?php } ?>

        <?= $form->field($model, 'description')->widget(CKEditor::className(), [
              'editorOptions' => ElFinder::ckeditorOptions('elfinder', ['preset' => 'full', 'contentsCss' => Yii::$app->params['ckeditorOptionsContentsCss'], 'bodyClass' => 'content', 'allowedContent' => true]),
            ]);
        ?>

<?php if ($model::HAVE_IMAGE_TUMB) { ?>
        <hr />
        <div class="form-group">
            <label class="control-label" for="about-us-upload_files"><?= Yii::t('app', 'Images') ?></label>
        </div>
        <?php if (sizeof($model->picture_file_names) > 0) { ?>
            <div class="form-group field-about-us-file_names">
                <div class="form-control-static">
            <?php
                echo $form->field($model, 'picture_file_names[]')->hiddenInput()->label(false);

                $_picture_file_names_items = [];
                foreach ($model->picture_file_names as $_file_name => $_file_description) {
                    $_picture_file_names_items[] = [
                        'content' => ('<div class="row"><div class="col-sm-5 col-md-4 col-lg-3">'.Html::img($model->fileThumbDisplayPath.$_file_name, ['class' => 'thumbnail']).'</div><div class="col-sm-7 col-md-8 col-lg-9">'.$form->field($model, 'picture_file_names['.$_file_name.']')->textInput(['value' => $_file_description])->label(false).'<button type="button" class="btn btn-xs btn-danger about-us-picture_file_names-remove">'.Yii::t('app', 'Remove').'</button></div></div>')
                    ];
            }
            echo Sortable::widget([
//                 'showHandle' => true,
                'items' => $_picture_file_names_items
            ]);

            ?>
                </div>
            </div>
        <?php } ?>
        <?= $form->field($model, 'upload_files[]')->widget(FileInput::classname(), [
                'options' => ['accept' => 'image/png, image/jpeg, image/gif', 'multiple' => true],
                'pluginOptions' => [
                    'previewFileType' => 'any',
                    'showUpload' => false,
                ]
            ])->label(false);
        ?>
    <?php } ?>

   <div class="form-group">
       <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
   </div>

   <?php ActiveForm::end(); ?>
 </div>
</div><!-- /.modal-content -->
