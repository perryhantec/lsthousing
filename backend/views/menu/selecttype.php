<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
$menu_name = \common\models\Menu::getMenuName($model->MID);
$this->title = $menu_name['name_cn'].' - '.Yii::t('app', 'Select Page Type');
?>

<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span></button>
  <h4 class="modal-title"><?= $this->title ?></h4>
</div>
<div class="modal-body">
  <?php $form = ActiveForm::begin([
			'id' => 'select-page-type-form',
			'options' => ['role' => 'form'],
		]); ?>

  <?= $form->field($model, 'type')->dropDownList(\common\models\Definitions::getPageType()); ?>

  <div class="form-group">
      <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
  </div>

  <?php ActiveForm::end(); ?>
</div>
</div>
