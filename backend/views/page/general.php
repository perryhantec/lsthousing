<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use mihaildev\ckeditor\CKEditor;
use mihaildev\elfinder\ElFinder;
use bupy7\cropbox\CropboxWidget;

$this->title = Yii::t('app', 'General');

$crop_width = $model::CROP_WIDTH;
$crop_height = $model::CROP_HEIGHT;
?>
<?php $form = ActiveForm::begin([
    //'enableAjaxValidation' => true,
    'options' => ['enctype' => 'multipart/form-data']]);
?>
<div class="box box-primary">
    <div class="box-body">

        <?php
            foreach (Yii::$app->config->getAllLanguageAttributes('web_name') as $attr_name)
                echo $form->field($model, $attr_name)->textInput();
        ?>
        <?= $form->field($model, 'description')->textArea() ?>
        <?= $form->field($model, 'keywords')->textArea() ?>
        <hr />
<?php if (false) { ?>
       (<?= Yii::t('app', 'Please remember to click \'Crop\'');?>)
       <?=
        $form->field($model, 'image_file')->widget(CropboxWidget::className(), [
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

        <hr />
<?php } ?>
        <?php
            foreach (Yii::$app->config->getAllLanguageAttributes('copyright') as $attr_name)
                echo $form->field($model, $attr_name)->textInput();
        ?>
        <?php
            if ($model::HAVE_COPYRIGHT_NOTICE) {
                foreach (Yii::$app->config->getAllLanguageAttributes('copyright_notice') as $attr_name)
                    echo $form->field($model, $attr_name)->widget(CKEditor::className(), [
                          'editorOptions' => ElFinder::ckeditorOptions('elfinder', ['preset' => 'full', 'contentsCss' => Yii::$app->params['ckeditorOptionsContentsCss'], 'bodyClass' => 'content', 'allowedContent' => true]),
                    ]);
            }

            if ($model::HAVE_DISCLAIMER) {
                echo '<hr />';
                foreach (Yii::$app->config->getAllLanguageAttributes('disclaimer') as $attr_name)
                    echo $form->field($model, $attr_name)->widget(CKEditor::className(), [
                          'editorOptions' => ElFinder::ckeditorOptions('elfinder', ['preset' => 'full', 'contentsCss' => Yii::$app->params['ckeditorOptionsContentsCss'], 'bodyClass' => 'content', 'allowedContent' => true]),
                    ]);
            }

            if ($model::HAVE_PRIVACY_STATEMENT) {
                echo '<hr />';
                foreach (Yii::$app->config->getAllLanguageAttributes('privacy_statement') as $attr_name)
                    echo $form->field($model, $attr_name)->widget(CKEditor::className(), [
                          'editorOptions' => ElFinder::ckeditorOptions('elfinder', ['preset' => 'full', 'contentsCss' => Yii::$app->params['ckeditorOptionsContentsCss'], 'bodyClass' => 'content', 'allowedContent' => true]),
                    ]);
            }

            echo '<hr />';
            foreach (Yii::$app->config->getAllLanguageAttributes('shop_empty_desc') as $attr_name)
                echo $form->field($model, $attr_name)->widget(CKEditor::className(), [
                      'editorOptions' => ElFinder::ckeditorOptions('elfinder', ['preset' => 'full', 'contentsCss' => Yii::$app->params['ckeditorOptionsContentsCss'], 'bodyClass' => 'content', 'allowedContent' => true]),
                ]);
        ?>

        <hr />

        <?= $form->field($model, 'site_counter')->textInput(['type' => 'number']); ?>
    </div>

    <div class="box-footer">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

</div>
<?php ActiveForm::end(); ?>
