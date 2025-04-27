<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use mihaildev\elfinder\InputFile;
use mihaildev\ckeditor\CKEditor;
use mihaildev\elfinder\ElFinder;
use kartik\widgets\DatePicker;
use common\models\Definitions;

$this->title =  '批核清單 - '.(($model->isNewRecord)? Yii::t('app', 'Create'):Yii::t('app', 'Update'));

$this->params['breadcrumbs'][] = ['label' => '批核清單', 'url' => ['approve-list']];
if (!$model->isNewRecord)
    $this->params['breadcrumbs'][] = ['label' => $model->appl_no, 'url' => ['approve-visit', 'id' => $model->id]];
$this->params['breadcrumbs'][] = (($model->isNewRecord)? Yii::t('app', 'Create'):Yii::t('app', 'Update'));
?>
<br>
 <div class="modal-content">
   <div class="modal-body">
   <?php $form = ActiveForm::begin(); ?>
   <div class="box-tools pull-right">
        <?=  Html::a('申請表詳細', ['application/view', 'id' => $model->id], ['class' => 'btn btn-sm btn-info pull-right']) ?>
    </div>
    <h3>基本資料</h3>
     <?= $form->field($model, 'application_chi_name')->textInput(['value' => $model->chi_name,'disabled' => true]) ?>
     <?= $form->field($model, 'application_eng_name')->textInput(['value' => $model->eng_name,'disabled' => true]) ?>
     <?= $form->field($model, 'application_no')->textInput(['value' => $model->appl_no,'disabled' => true]) ?>
     <?= $form->field($model, 'application_created_at')->textInput(['value' => date('Y-m-d',strtotime($model->created_at)),'disabled' => true]) ?>
     <?= $form->field($model, 'application_priority_1')->textInput(['value' => Definitions::getProjectName($model->priority_1),'disabled' => true]) ?>
     <?= $form->field($model, 'application_priority_2')->textInput(['value' => $model->priority_2 ? Definitions::getProjectName($model->priority_2) : '-','disabled' => true]) ?>
     <?= $form->field($model, 'application_priority_3')->textInput(['value' => $model->priority_3 ? Definitions::getProjectName($model->priority_3) : '-','disabled' => true]) ?>
     <?= $form->field($model, 'application_family_member')->textInput(['value' => $model->family_member,'disabled' => true]) ?>
     <hr />
     
    <?= $form->field($model, 'approved')->dropDownList(Definitions::getApproved()) ?>

   <div class="form-group">
       <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
   </div>

   <?php ActiveForm::end(); ?>
 </div>
</div><!-- /.modal-content -->
