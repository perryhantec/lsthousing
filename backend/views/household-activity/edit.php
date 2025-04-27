<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use mihaildev\elfinder\InputFile;
use common\models\Definitions;

$this->title =  '住戶活動 - '.(($model->isNewRecord)? Yii::t('app', 'Create'):Yii::t('app', 'Update'));

$this->params['breadcrumbs'][] = ['label' => '住戶活動', 'url' => ['index']];
if (!$model->isNewRecord)
    $this->params['breadcrumbs'][] = ['label' => '住戶活動', 'url' => ['update', 'id' => $model->id]];
$this->params['breadcrumbs'][] = (($model->isNewRecord)? Yii::t('app', 'Create'):Yii::t('app', 'Update'));
?>
<br>
 <div class="modal-content">
   <div class="modal-body">
   <?php $form = ActiveForm::begin(); ?>
     <?= $form->field($model, 'user_chi_name')->textInput(['value' => $model->user->chi_name,'disabled' => true]) ?>
     <?= $form->field($model, 'user_eng_name')->textInput(['value' => $model->user->eng_name,'disabled' => true]) ?>
     <?= $form->field($model, 'user_mobile')->textInput(['value' => $model->user->mobile,'disabled' => true]) ?>
     <?= $form->field($model, 'user_email')->textInput(['value' => $model->user->email,'disabled' => true]) ?>
     <?= $form->field($model, 'title')->textInput(['value' => $model->title,'disabled' => true]) ?>
     <?= $form->field($model, 'date')->textInput(['value' => $model->date,'disabled' => true]) ?>
     <?= $form->field($model, 'time')->textInput(['value' => $model->time,'disabled' => true]) ?>
     <?= $form->field($model, 'location')->textInput(['value' => $model->location,'disabled' => true]) ?>
     <?= $form->field($model, 'close_date')->textInput(['value' => $model->close_date,'disabled' => true]) ?>
     <?= $form->field($model, 'name')->textInput(['value' => $model->name,'disabled' => true]) ?>
     <?= $form->field($model, 'mobile')->textInput(['value' => $model->mobile,'disabled' => true]) ?>
     <?= $form->field($model, 'no_of_ppl')->textInput(['value' => $model->no_of_ppl,'disabled' => true]) ?>
     <?= $form->field($model, 'remarks')->textArea(['value' => $model->remarks,'rows' => 5,'disabled' => true]) ?>
     <hr />
     <?= $form->field($model, 'activity_status')->dropDownList(Definitions::getHouseholdActivityStatus(),['prompt'=>Yii::t('app', 'Please Select')]) ?>

   <div class="form-group">
       <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
   </div>

   <?php ActiveForm::end(); ?>
 </div>
</div><!-- /.modal-content -->
