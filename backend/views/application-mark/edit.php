<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use mihaildev\elfinder\InputFile;
use common\models\Definitions;

$this->title =  '評分 - '.(($model->isNewRecord)? Yii::t('app', 'Create'):Yii::t('app', 'Update'));

$this->params['breadcrumbs'][] = ['label' => '評分', 'url' => ['index']];
if (!$model->isNewRecord)
    $this->params['breadcrumbs'][] = ['label' => $model->application->appl_no, 'url' => ['update', 'id' => $model->id]];
$this->params['breadcrumbs'][] = (($model->isNewRecord)? Yii::t('app', 'Create'):Yii::t('app', 'Update'));
?>
<br>
 <div class="modal-content">
   <div class="modal-body">
   <?php $form = ActiveForm::begin(); ?>
     <div class="box-tools pull-right">
        <?=  Html::a('申請表詳細', ['application/view', 'id' => $model->application->id], ['class' => 'btn btn-sm btn-info pull-right']) ?>
    </div>
    <h2 class="text-center">樂善堂社會房屋計劃 —「樂屋」初步審核評分表</h2>
    <h3>基本資料</h3>
     <?= $form->field($model, 'application_chi_name')->textInput(['value' => $model->application->chi_name,'disabled' => true]) ?>
     <?= $form->field($model, 'application_eng_name')->textInput(['value' => $model->application->eng_name,'disabled' => true]) ?>
     <?= $form->field($model, 'application_no')->textInput(['value' => $model->application->appl_no,'disabled' => true]) ?>
     <?= $form->field($model, 'application_created_at')->textInput(['value' => date('Y-m-d',strtotime($model->created_at)),'disabled' => true]) ?>
     <?= $form->field($model, 'application_priority_1')->textInput(['value' => Definitions::getProjectName($model->application->priority_1),'disabled' => true]) ?>
     <?= $form->field($model, 'application_priority_2')->textInput(['value' => $model->application->priority_2 ? Definitions::getProjectName($model->application->priority_2) : '-','disabled' => true]) ?>
     <?= $form->field($model, 'application_priority_3')->textInput(['value' => $model->application->priority_3 ? Definitions::getProjectName($model->application->priority_3) : '-','disabled' => true]) ?>
     <?= $form->field($model, 'application_family_member')->textInput(['value' => $model->application->family_member,'disabled' => true]) ?>
     <hr />
     <h3>第一部份 家庭資料</h3>
     <?= $form->field($model, 'i1')->textInput(['type' => 'number','placeholder' => '請輸入分數']) ?>
     <?= $form->field($model, 'i2')->textInput(['type' => 'number','placeholder' => '請輸入分數']) ?>
     <?= $form->field($model, 'i3')->textInput(['type' => 'number','placeholder' => '請輸入分數']) ?>
     <?= $form->field($model, 'i4')->textInput(['type' => 'number','placeholder' => '請輸入分數']) ?>
     <?= $form->field($model, 'i5')->textInput(['type' => 'number','placeholder' => '請輸入分數']) ?>
     <?= $form->field($model, 'i6')->textInput(['type' => 'number','placeholder' => '請輸入分數']) ?>
     <hr />
     <?= $form->field($model, 'total_p1')->textInput(['value' => Definitions::getApplicationMarkTotalPart1($model->application_id), 'disabled' => true]) ?>
     <hr />
     <h3>第二部份 收入及資產</h3>
     <?= $form->field($model, 'i7')->textInput(['type' => 'number','placeholder' => '請輸入分數']) ?>
     <?= $form->field($model, 'i8')->textInput(['type' => 'number','placeholder' => '請輸入分數']) ?>
     <?= $form->field($model, 'i9')->textInput(['type' => 'number','placeholder' => '請輸入分數']) ?>
     <?= $form->field($model, 'i10')->textInput(['type' => 'number','placeholder' => '請輸入分數']) ?>
     <hr />
     <h3>第三部份 目前居住環境</h3>
     <?= $form->field($model, 'i11')->textInput(['type' => 'number','placeholder' => '請輸入分數']) ?>
     <?= $form->field($model, 'i12')->textInput(['type' => 'number','placeholder' => '請輸入分數']) ?>
     <?= $form->field($model, 'i13')->textInput(['type' => 'number','placeholder' => '請輸入分數']) ?>
     <hr />
     <?= $form->field($model, 'total_p2_p3')->textInput(['value' => Definitions::getApplicationMarkTotalPart2AndPart3($model->application_id), 'disabled' => true]) ?>
     <hr />
     <h3>第四部份</h3>
     <?= $form->field($model, 'i14_description')->textArea(['rows' => 5]) ?>
     <?= $form->field($model, 'i14')->textInput(['type' => 'number','placeholder' => '請輸入分數']) ?>
     <hr />
     <h3>總分</h3>
     <?= $form->field($model, 'total')->textInput(['type' => 'number', 'disabled' => true]) ?>

   <div class="form-group">
       <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
   </div>

   <?php ActiveForm::end(); ?>
 </div>
</div><!-- /.modal-content -->
