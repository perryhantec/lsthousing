<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use mihaildev\elfinder\InputFile;
use common\models\Definitions;

$this->title =  Yii::t('app','Users').' - '.(($model->isNewRecord)? Yii::t('app', 'Create'):Yii::t('app', 'Update'));

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Users'), 'url' => ['index']];
if (!$model->isNewRecord)
    $this->params['breadcrumbs'][] = ['label' => $model->chi_name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = (($model->isNewRecord)? Yii::t('app', 'Create'):Yii::t('app', 'Update'));
?>
<br>
 <div class="modal-content">
   <div class="modal-body">
   <?php $form = ActiveForm::begin(); ?>

   <?= $form->field($model, 'status')->dropDownList(Definitions::getStatus()); ?>

   <hr />

   <?= $form->field($model, 'chi_name')->textInput(['maxlength' => true]) ?>
   <?= $form->field($model, 'eng_name')->textInput(['maxlength' => true]) ?>
   <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>
   <?= $form->field($model, 'mobile')->textInput(['maxlength' => true]) ?>

   <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

   <?php // $form->field($model, 'ref_employer_number')->textInput(['maxlength' => true]) ?>

   <hr />

   <?= $form->field($model, 'new_password')->textInput(['type'=>"password"]) ?>

   <?= $form->field($model, 'role')->dropDownList(Definitions::getRole()); ?>

   <?php // $form->field($model, 'is_helper')->checkbox() ?>

   <?php // $form->field($model, 'is_employer')->checkbox() ?>


   <div class="form-group">
       <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
   </div>

   <?php ActiveForm::end(); ?>
 </div>
</div><!-- /.modal-content -->
