<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\sortinput\SortableInput;

$this->title = '關於樂屋'.Yii::t('app', 'Reorder');
?>

<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span></button>
  <h4 class="modal-title"><?= $this->title ?></h4>
</div>
<div class="modal-body">
  <?php $form = ActiveForm::begin([
      'enableAjaxValidation' => true,
      'options' => ['enctype' => 'multipart/form-data']
      ]); ?>
  <?php
    echo SortableInput::widget([
         'model' => $model,
         'attribute' => 'seq',
         'hideInput' => true,
         'delimiter' => '-',
         'items' => $model->array,
     ]);
  ?>
  <p>
    <?= Html::submitButton(Yii::t('app', 'Submit'), ['class' => 'btn btn-primary']) ?>
  </p>
  <?php ActiveForm::end(); ?>
</div>
</div>
