<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use mihaildev\ckeditor\CKEditor;
use mihaildev\elfinder\ElFinder;

$this->title = Yii::t('app', 'Contact Info');
?>
<?php $form = ActiveForm::begin([
    //'enableAjaxValidation' => true,
    'options' => ['enctype' => 'multipart/form-data']]);
?>
<div class="box box-primary">
    <div class="box-body">

        <?php
            foreach (Yii::$app->config->getAllLanguageAttributes('company_name') as $attr_name)
                echo $form->field($model, $attr_name)->textInput();
        ?>
        <hr />

        <?php
            foreach (Yii::$app->config->getAllLanguageAttributes('address') as $attr_name)
                echo $form->field($model, $attr_name)->textArea(['rows'=>'3']);
        ?>
        <hr />

        <?= $form->field($model, 'phone')->textInput() ?>
        <?= $form->field($model, 'fax')->textInput() ?>
        <?= $form->field($model, 'whatsapp')->textInput() ?>
        <?= $form->field($model, 'email')->textInput() ?>
        <?= $form->field($model, 'website')->textInput() ?>
        <?= $form->field($model, 'facebook')->textInput() ?>
        <?= $form->field($model, 'instagram')->textInput() ?>
        <?= $form->field($model, 'twitter')->textInput() ?>
        <?= $form->field($model, 'youtube')->textInput() ?>
        <?= $form->field($model, 'googlemap')->textInput() ?>
        <hr />

        <?php
            foreach (Yii::$app->config->getAllLanguageAttributes('content') as $attr_name)
                echo $form->field($model, $attr_name)->widget(CKEditor::className(), [
                      'editorOptions' => ElFinder::ckeditorOptions('elfinder', ['preset' => 'full', 'contentsCss' => Yii::$app->params['ckeditorOptionsContentsCss'], 'bodyClass' => (' content-index content'), 'allowedContent' => true]),
                    ]);
        ?>

    </div>

    <div class="box-footer">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>
</div>
<?php ActiveForm::end(); ?>
