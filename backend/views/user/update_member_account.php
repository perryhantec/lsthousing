<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use mihaildev\elfinder\InputFile;
use common\models\Definitions;

$this->title = Yii::t('app', 'Update Member Account');

$this->params['breadcrumbs'][] = $this->title;
?>
<br>
 <div class="modal-content">
   <div class="modal-body">
   <?php $form = ActiveForm::begin(); ?>

   <?= $form->field($model, 'name')->textInput() ?>

   <?= $form->field($model, 'username')->textInput() ?>

   <?= $form->field($model, 'new_password')->textInput(['type'=>"password"]) ?>

   <?= $form->field($model, 'status')->dropDownList(Definitions::getStatus()); ?>

   <div class="form-group">
       <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
   </div>

   <?php ActiveForm::end(); ?>
 </div>
</div><!-- /.modal-content -->
