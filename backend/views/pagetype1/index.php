<?php

use yii\helpers\Html;
use common\models\Config;
use yii\widgets\ActiveForm;
use mihaildev\ckeditor\CKEditor;
use mihaildev\elfinder\ElFinder;
use kartik\widgets\FileInput;
use kartik\sortable\Sortable;

$this->title = $model->menu->allLanguageName;


if ($model::HAVE_IMAGE_TUMB)
    $this->registerJs(<<<JS
        $('.pagetype1-picture_file_names-remove')
            .click(function() {
                $(this).parents('li').remove();
            });
JS
);

?>

<div class="page-type-1-form">

    <?php $form = ActiveForm::begin([
       //'enableAjaxValidation' => true,
       'options' => ['enctype' => 'multipart/form-data']]);
    ?>

    <?php
        foreach (Yii::$app->config->getAllLanguageAttributes('content') as $attr_name)
            echo $form->field($model, $attr_name)->widget(CKEditor::className(), [
                  'editorOptions' => ElFinder::ckeditorOptions('elfinder', ['preset' => 'full', 'contentsCss' => Yii::$app->params['ckeditorOptionsContentsCss'], 'bodyClass' => 'content', 'allowedContent' => true]),
                ]);
    ?>

    <?php if ($model::HAVE_IMAGE_TUMB) { ?>
        <hr />
        <div class="form-group">
            <label class="control-label" for="pagetype1-upload_files"><?= Yii::t('app', 'Images') ?></label>
        </div>
        <?php if (sizeof($model->picture_file_names) > 0) { ?>
            <div class="form-group field-pagetype1-file_names">
                <div class="form-control-static">
            <?php
                echo $form->field($model, 'picture_file_names[]')->hiddenInput()->label(false);

                $_picture_file_names_items = [];
                foreach ($model->picture_file_names as $_file_name => $_file_description) {
                    $_picture_file_names_items[] = [
                        'content' => ('<div class="row"><div class="col-sm-5 col-md-4 col-lg-3">'.Html::img($model->fileThumbDisplayPath.$_file_name, ['class' => 'thumbnail']).'</div><div class="col-sm-7 col-md-8 col-lg-9">'.$form->field($model, 'picture_file_names['.$_file_name.']')->textInput(['value' => $_file_description])->label(false).'<button type="button" class="btn btn-xs btn-danger pagetype1-picture_file_names-remove">'.Yii::t('app', 'Remove').'</button></div></div>')
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
