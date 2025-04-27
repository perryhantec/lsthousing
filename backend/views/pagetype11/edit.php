<?php

use yii\helpers\Html;
use common\models\Config;
use kartik\widgets\ActiveForm;
use mihaildev\ckeditor\CKEditor;
use mihaildev\elfinder\ElFinder;
use kartik\widgets\DatePicker;
use kartik\widgets\FileInput;
use common\models\Definitions;
use bupy7\cropbox\CropboxWidget;
use kartik\sortable\Sortable;

// $this->title = $model->menu->name.' - '.(($model->isNewRecord)? Yii::t('app', 'Create'):Yii::t('app', 'Update'));
// 
// $this->params['breadcrumbs'][] = ['label' => $model->menu->name, 'url' => ['page/edit','id'=>$model->MID]];
// $this->params['breadcrumbs'][] = $model->menu->name;
// $this->params['breadcrumbs'][] = (($model->isNewRecord)? Yii::t('app', 'Create'):Yii::t('app', 'Update'));

$this->title =  '樂屋新項目 - '.(($model->isNewRecord)? Yii::t('app', 'Create'):Yii::t('app', 'Update'));

$this->params['breadcrumbs'][] = ['label' => '樂屋新項目', 'url' => ['index']];
if (!$model->isNewRecord)
    $this->params['breadcrumbs'][] = ['label' => '樂屋新項目', 'url' => ['update', 'id' => $model->id]];
$this->params['breadcrumbs'][] = (($model->isNewRecord)? Yii::t('app', 'Create'):Yii::t('app', 'Update'));

$crop_width = $model::CROP_WIDTH;
$crop_height = $model::CROP_HEIGHT;

$_file_names = [];
if (!empty($model->file_names))
    $_file_names = json_decode($model->file_names);

//if ($model->menu->route == "our-sharing") {
    $crop_width = 490;
    $crop_height = 285;
//}

$this->registerJs(<<<JS
    $('.pagetype11-image_file-img')
        .popover({trigger: 'hover', placement: 'top'})
        .click(function() {
            $('input[name="'+$(this).attr("data-input-name")+'"]').val("");
            $(this).parents('.form-group').remove();
            $('.field-pagetype11-image_file').show();
        });
    $('.pagetype11-picture_file_names-remove')
        .click(function() {
            $(this).parents('li').remove();
        });
    $('[name="PageType11[top_media_type]"]').change(function() {
            $('.pt11-top_media_type-detail').hide();
            $('.pt11-top_media_type-detail-'+$(this).val()).show();
        });
JS
);
$this->registerCss('
.cropbox .workarea-cropbox {
    transform: scale(0.5);
    transform-origin: top left;
    margin-bottom: -'.abs((($crop_height+100)/2)-20).'px;
}
.workarea-cropbox, .bg-cropbox {
    width: '.($crop_width+100).'px;
    height: '.($crop_height+100).'px;
}
');

?>
<?php $form = ActiveForm::begin([
    //'enableAjaxValidation' => true,
    'options' => ['enctype' => 'multipart/form-data']]);
?>
<div class="box <?= ($model->isNewRecord) ? 'box-success' : 'box-primary' ?>">
    <div class="box-body">
        <?php // $form->field($model, 'author')->textInput() ?>

        <?= $model::HAS_CATEGORY ? $form->field($model, 'category_id')->dropDownList(Definitions::getPageType11Category(false,$model->MID,NULL),
            [
                'prompt'=>Yii::t('app', 'Please Select'),
            ]
        ) : '' ?>

        <?= $form->field($model, 'display_at')->widget(DatePicker::classname(), [
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

        <?php
            foreach (Yii::$app->config->getAllLanguageAttributes('title') as $attr_name)
                echo $form->field($model, $attr_name)->textInput();
        ?>

        <hr />

        <?= $form->field($model, 'top_media_type')->dropDownList([$model::TMT_IMAGE => Yii::t('app', 'Image'), $model::TMT_YOUTUBE => Yii::t('app', 'YouTube')],
            [
            ]
        ) ?>

        <div class="pt11-top_media_type-detail pt11-top_media_type-detail-<?= $model::TMT_IMAGE ?>"<?= $model->top_media_type != $model::TMT_IMAGE ? ' style="display:none"' : '' ?>>
            <?= $form->field($model, 'image_file_name')->hiddenInput()->label(false); ?>
            <?php if (!empty($model->image_file_name)) { ?>
            <div class="form-group field-pagetype11-image_file_name">
                <label class="control-label" for="pagetype11-image_file_name"><?= Yii::t('app', 'Thumbnail') ?></label>
                <div class="form-control-static">
                    <?= Html::tag('span', Html::img(Yii::$app->urlManager->createUrl('../'.$model->image_file_name)), [
                            'class' => "image-remove-trigger pagetype11-image_file-img thumbnail",
                            'title' => Yii::t('app', 'Remove'),
                            'data-input-name' => 'PageType11[image_file_name]',
                            'data-toggle' => "popover",
                            'data-content' => Yii::t('app', 'Click to remove image'),
                        ]) ?>
                </div>
            </div>
            <?php } ?>
<?php if ($model::CROP_IMAGE_FILE) { ?>
            <span class="field-pagetype11-image_file"<?= ($model->image_file_name != "" ? ' style="display: none;"' : '') ?>>(<?= Yii::t('app', 'Please remember to click \'Crop\'');?>)</span>
            <?=
            $form->field($model, 'image_file', ['options' => ['style' => ($model->image_file_name != "" ? 'display: none;' : '')]])->widget(CropboxWidget::className(), [
                'croppedDataAttribute' => 'crop_info',
                'pluginOptions' => [
                    'variants' => [
                        [
                            'width' => $crop_width,
                            'height' => $crop_height
                        ],

                    ],
                ],

            ]);
            ?>
            <?= $form->field($model, 'crop_width')->hiddenInput(['value'=> $crop_width])->label(false); ?>
            <?= $form->field($model, 'crop_height')->hiddenInput(['value'=> $crop_height])->label(false); ?>
<?php } else { ?>
            <?= $form->field($model, 'image_file', ['options' => ['class' => 'form-group ', 'style' => ($model->image_file_name == "" ? "":"display:none")]])->widget(FileInput::classname(), [
                    'options' => ['accept' => 'image/png, image/jpeg, image/gif', 'multiple' => false],
                    'pluginOptions' => [
                        'previewFileType' => 'any',
                        'showUpload' => false,
                    ]
                ]);
            ?>
<?php } ?>
        </div>

        <div class="pt11-top_media_type-detail pt11-top_media_type-detail-<?= $model::TMT_YOUTUBE ?>" <?= $model->top_media_type != $model::TMT_YOUTUBE ? ' style="display:none"' : '' ?>>
            <?= $form->field($model, 'youtube_id', ['addon' => ['prepend' => ['content' => 'https://www.youtube.com/watch?v=']]])->textInput() ?>
        </div>

        <hr />

        <?php
            foreach (Yii::$app->config->getAllLanguageAttributes('summary') as $attr_name)
                echo $form->field($model, $attr_name)->textArea(['rows' => '2']);
        ?>

        <?= 
            $form->field($model, 'housing_status')->dropDownList(Definitions::getHousingStatus(),
            [
                'prompt'=>Yii::t('app', 'Please Select'),
            ]
            );
        ?>

        <?= $form->field($model, 'expect_apply_date')->textInput(); ?>

        <?= $form->field($model, 'expect_live_date')->textInput(); ?>

        <?= $form->field($model, 'number_of_housing')->textInput([
            'type' => 'number',
        ]);?>

        <hr />

        <?php
            foreach (Yii::$app->config->getAllLanguageAttributes('content') as $attr_name)
                echo $form->field($model, $attr_name)->widget(CKEditor::className(), [
                    'editorOptions' => ElFinder::ckeditorOptions('elfinder', ['preset' => 'full', 'contentsCss' => Yii::$app->params['ckeditorOptionsContentsCss'], 'bodyClass' => 'content', 'allowedContent' => true]),
                    ]);
        ?>

        <hr />

        <div class="form-group">
            <label class="control-label" for="pagetype11-upload_files"><?= Yii::t('app', 'Images') ?></label>
        </div>
        <?php if (sizeof($model->picture_file_names) > 0) { ?>
            <div class="form-group field-pagetype11-file_names">
                <div class="form-control-static">
            <?php
                echo $form->field($model, 'picture_file_names[]')->hiddenInput()->label(false);

                $_picture_file_names_items = [];
                foreach ($model->picture_file_names as $_file_name => $_file_description) {
                    $_picture_file_names_items[] = [
                        'content' => ('<div class="grid-item text-center">'.Html::img($model->fileThumbDisplayPath.$_file_name, ['class' => 'thumbnail', 'style' => 'display: inline-block;']).'<br>'.$form->field($model, 'picture_file_names['.$_file_name.']', ['options' => ['style' => 'margin-bottom:0']])->textInput(['value' => $_file_description])->label(false).'<button type="button" class="btn btn-xs btn-danger pagetype11-picture_file_names-remove">'.Yii::t('app', 'Remove').'</button></div>')
                    ];
            }
            echo Sortable::widget([
//                 'showHandle' => true,
                'type' => Sortable::TYPE_GRID,
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

    </div>

    <div class="box-footer">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

</div>
 <?php ActiveForm::end(); ?>
