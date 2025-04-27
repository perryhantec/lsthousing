<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use mihaildev\ckeditor\CKEditor;

$this->title = $model->menu->allLanguageName.' - ' .(($model->isNewRecord)? Yii::t('app', 'Create'):Yii::t('app', 'Update')).Yii::t('app', 'Category');

$this->params['breadcrumbs'][] = ['label' => $model->menu->allLanguageName, 'url' => ['index','id'=>$model->MID]];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Category'), 'url' => ['category','id'=>$model->MID]];
$this->params['breadcrumbs'][] = (($model->isNewRecord)? Yii::t('app', 'Create'):Yii::t('app', 'Update')).Yii::t('app', 'Category');
?>
<?php $form = ActiveForm::begin([
    //'enableAjaxValidation' => true,
    'options' => ['enctype' => 'multipart/form-data']]);
?>
<div class="box <?= ($model->isNewRecord) ? 'box-success' : 'box-primary' ?>">
    <div class="box-body">

        <?php
            foreach (Yii::$app->config->getAllLanguageAttributes('name') as $attr_name)
                echo $form->field($model, $attr_name)->textInput();
        ?>

    </div>

    <div class="box-footer">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

</div>
<?php ActiveForm::end(); ?>
