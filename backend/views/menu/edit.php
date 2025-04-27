<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use mihaildev\ckeditor\CKEditor;
use mihaildev\elfinder\ElFinder;
use mihaildev\elfinder\InputFile;
use kartik\widgets\FileInput;
use yii\web\JsExpression;
use common\models\Definitions;
use bupy7\cropbox\CropboxWidget;

$this->title =  Yii::t('app','Menu').' - '.(($model->isNewRecord)? Yii::t('app', 'Create'):Yii::t('app', 'Update'));

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Menu'), 'url' => ['index']];
if (!$model->isNewRecord)
    $this->params['breadcrumbs'][] = $model->name;
$this->params['breadcrumbs'][] = (($model->isNewRecord)? Yii::t('app', 'Create'):Yii::t('app', 'Update'));

$crop_width = $model::CROP_WIDTH;
$crop_height = $model::CROP_HEIGHT;

$this->registerJs(<<<JS
    $('.menuform-icon_file-img')
        .popover({trigger: 'hover', placement: 'top'})
        .click(function() {
            $('input[name="'+$(this).attr("data-input-name")+'"]').val("");
            $(this).parents('.form-group').remove();
            $('.field-menuform-icon_file').show();
        });
    $('.menuform-image_file-img')
        .popover({trigger: 'hover', placement: 'top'})
        .click(function() {
            $('input[name="'+$(this).attr("data-input-name")+'"]').val("");
            $(this).parents('.form-group').remove();
            $('.field-menuform-image_file').show();
        });
    $('#menuform-page_type')
        .change(function() {
            if ($(this).val() == 0) {
                $("#menuform-page_type-link").show();
                $("#menuform-page_type-non_link").hide();
            } else {
                $("#menuform-page_type-link").hide();
                $("#menuform-page_type-non_link").show();
            }
        });
JS
);
$_MID_selete = Definitions::getParentMenuList();
?>
<?php $form = ActiveForm::begin([
    //'enableAjaxValidation' => true,
    'options' => ['enctype' => 'multipart/form-data']]);
?>
<div class="box <?= ($model->isNewRecord) ? 'box-success' : 'box-primary' ?>">
    <div class="box-body">

        <?= $model->isNewRecord || \backend\components\AccessRule::checkRole(['menu.root']) || in_array($model->MID, array_keys($_MID_selete)) ? $form->field($model, 'MID')->dropDownList($_MID_selete,
                [
                    'prompt'=>Yii::t('app', 'Please Select'),
                ]
            ) : ''; ?>

        <?php
            echo $form->field($model, 'name_tw')->textInput();
            echo $form->field($model, 'name_en')->textInput();

            // $attr_names = Yii::$app->config->getAllLanguageAttributes('name');
            // foreach ($attr_names as $attr_name)
            //     echo $form->field($model, $attr_name)->textInput();

            // if ($_show_url || !in_array('name_en', $attr_names))
            if ($_show_url)
                echo $form->field($model, 'url')->textInput();
        ?>

<?php if (false && $model::HAVE_ICON) { ?>
        <?= $form->field($model, 'icon_file_name')->hiddenInput()->label(false); ?>
        <?php if (!empty($model->icon_file_name)) { ?>
        <div class="form-group field-menuform-icon_file_name">
            <label class="control-label" for="menuform-icon_file_name">Icon</label>
            <div class="form-control-static">
                <?= Html::tag('span', Html::img(Yii::$app->urlManager->createUrl('../'.$model->iconDisplayPath)), [
                        'class' => "image-remove-trigger menuform-icon_file-img thumbnail",
                        'title' => Yii::t('app', 'Remove'),
                        'data-input-name' => 'MenuForm[icon_file_name]',
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
            ])->hint(Yii::t('app', 'Please upload a transparent background image file with line colour <code style="color:#FF911E">#FF911E</code>.'));
        ?>
<?php } ?>

        <?= $form->field($model, 'page_type')->dropDownList(Definitions::getPageType()); ?>

        <div id="menuform-page_type-link" <?= $model->page_type == 0 ? '' : 'style="display:none"' ?>>
            <?= $form->field($model, 'link')->textInput() ?>
            <?= $form->field($model, 'link_target')->checkBox() ?>
        </div>

<?php if (false && $model::TOP_BANNER) { ?>
        <div>
            <?= $form->field($model, 'banner_image_file_name')->hiddenInput()->label(false); ?>
            <?php if (!empty($model->banner_image_file_name)) { ?>
            <div class="form-group field-menuform-banner_image_file_name">
                <label class="control-label" for="menuform-banner_image_file_name">Banner</label>
                <div class="form-control-static">
                    <?= Html::tag('span', Html::img(Yii::$app->urlManager->createUrl('../'.$model->banner_image_file_name)), [
                            'class' => "image-remove-trigger menuform-image_file-img thumbnail",
                            'title' => Yii::t('app', 'Remove'),
                            'data-input-name' => 'MenuForm[banner_image_file_name]',
                            'data-toggle' => "popover",
                            'data-content' => Yii::t('app', 'Click to remove image'),
                        ]) ?>
                </div>
            </div>
            <?php } ?>

            <span class="field-menuform-image_file"<?= ($model->banner_image_file_name != "" ? ' style="display: none;"' : '') ?>>(<?= Yii::t('app', 'Please remember to click \'Crop\'');?>)</span>
            <?=
                $form->field($model, 'image_file', ['options' => ['style' => ($model->banner_image_file_name != "" ? 'display: none;' : '')]])->widget(CropboxWidget::className(), [
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
        </div>

        <hr />
<?php } ?>

        <?= $form->field($model, 'status')->checkbox(['label' => Yii::t('app', 'Show In Menu')]); ?>

        <?= $form->field($model, 'display_home')->checkbox([]); ?>

        <?= $form->field($model, 'show_after_login')->checkbox(['label' => '登入後才顯示']); ?>

    </div>

    <div class="box-footer">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

</div>
<?php ActiveForm::end(); ?>
