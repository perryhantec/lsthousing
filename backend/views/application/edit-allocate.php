<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use mihaildev\elfinder\InputFile;
use mihaildev\ckeditor\CKEditor;
use mihaildev\elfinder\ElFinder;
use kartik\widgets\DatePicker;
use common\models\Definitions;
use common\models\Application;

$this->title =  '編配單位 - '.(($model->isNewRecord)? Yii::t('app', 'Create'):Yii::t('app', 'Update'));

$this->params['breadcrumbs'][] = ['label' => '編配單位', 'url' => ['allocate-list']];
if (!$model->isNewRecord)
    $this->params['breadcrumbs'][] = ['label' => $model->appl_no, 'url' => ['update-allocate', 'id' => $model->id]];
$this->params['breadcrumbs'][] = (($model->isNewRecord)? Yii::t('app', 'Create'):Yii::t('app', 'Update'));

$this->registerJs(<<<JS
    $('#application_status').on('change',function(){
        if ($(this).val() == $(this).data('unallocated')) {
            $('#application-project').val('').closest('.form-group').hide();
            $('#application-room_no').val('').closest('.form-group').hide();
            $('#application-start_date').val('').closest('.form-group').hide();
            $('#application-withdrew_date').val('').closest('.form-group').hide();
        } else if ($(this).val() == $(this).data('allocated')) {
            $('#application-project').closest('.form-group').show();
            $('#application-room_no').closest('.form-group').show();
            $('#application-start_date').closest('.form-group').show();
            $('#application-withdrew_date').val('').closest('.form-group').hide();
        } else if ($(this).val() == $(this).data('withdrew')) {
            $('#application-project').closest('.form-group').show();
            $('#application-room_no').closest('.form-group').show();
            $('#application-start_date').closest('.form-group').show();
            $('#application-withdrew_date').closest('.form-group').show();
        }
    });
    $('#application_status').trigger('change');
JS
);
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

     <?= $form->field($model, 'application_status')->dropDownList(Definitions::getApplicationStatus(false,3),[
         'id' => 'application_status',
         'data-unallocated' => Application::APPL_STATUS_ALLOCATE_UNIT_FAILED,
         'data-allocated'   => Application::APPL_STATUS_ALLOCATED_UNIT,
         'data-withdrew'    => Application::APPL_STATUS_WITHDREW,
     ]) ?>

     <?= $form->field($model, 'project')->dropdownList(Definitions::getProjectName(),['prompt'=>Yii::t('app', 'Please Select')]); ?>
     <?= $form->field($model, 'room_no')->textInput() ?>
     <?= $form->field($model, 'start_date')->widget(DatePicker::classname(), [
          'options' => [],
          'type' => 3,
          'pluginOptions' => [
              'autoclose'=>true,
              'format' => 'yyyy-mm-dd',
              'weekStart' => 0,
  //            'startDate' => date('Y-m-d'),
              'todayBtn' => "linked",
          ],
      ]);?>
     <?= $form->field($model, 'withdrew_date')->widget(DatePicker::classname(), [
          'options' => [],
          'type' => 3,
          'pluginOptions' => [
              'autoclose'=>true,
              'format' => 'yyyy-mm-dd',
              'weekStart' => 0,
  //            'startDate' => date('Y-m-d'),
              'todayBtn' => "linked",
          ],
      ]);?>

   <div class="form-group">
       <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
   </div>

   <?php ActiveForm::end(); ?>
 </div>
</div><!-- /.modal-content -->
<script>

</script>