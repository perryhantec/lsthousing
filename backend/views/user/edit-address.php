<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use mihaildev\elfinder\InputFile;
use common\models\Definitions;

$this->title =  Yii::t('app','Users').' - '.Yii::t('app', 'Update Address Information');

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Users'), 'url' => ['index']];
if (!$model->isNewRecord)
    $this->params['breadcrumbs'][] = ['label' => $model->user->name, 'url' => ['view', 'id' => $model->user->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update Address Information');
?>
<br>
 <div class="modal-content">
   <div class="modal-body">
   <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'billing_name')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'billing_phone')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'billing_email')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'billing_address1')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'billing_address2')->textInput(['maxlength' => true])->label(false) ?>

        <?= $form->field($model, 'billing_address_district')->dropDownList(Definitions::getDeliveryAddressDistrictWithGroup(), ['prompt' => ''])->label(false); ?>

        <hr />

        <?= $form->field($model, 'delivery_name')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'delivery_phone')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'delivery_address1')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'delivery_address2')->textInput(['maxlength' => true])->label(false) ?>

        <?= $form->field($model, 'delivery_address_district')->dropDownList(Definitions::getDeliveryAddressDistrictWithGroup(), ['prompt' => ''])->label(false); ?>


   <div class="form-group">
       <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
   </div>

   <?php ActiveForm::end(); ?>
 </div>
</div><!-- /.modal-content -->
