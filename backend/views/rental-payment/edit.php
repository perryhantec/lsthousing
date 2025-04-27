<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use mihaildev\ckeditor\CKEditor;
use mihaildev\elfinder\ElFinder;
use common\models\Definitions;
use common\models\User;
use kartik\widgets\FileInput;
use kartik\sortable\Sortable;


// $model->application = Application::findOne(['id' => $aid]);

$this->title =  '住戶上載交租文件 ('.$model->user->chi_name.') - '.(($model->isNewRecord)? Yii::t('app', 'Create'):Yii::t('app', 'Update'));

$this->params['breadcrumbs'][] = ['label' => '住戶上載交租文件 (請先選擇申請)', 'url' => ['/user/rental-payment-list']];
$this->params['breadcrumbs'][] = ['label' => '住戶上載交租文件 ('.$model->user->chi_name.')', 'url' => ['index', 'id' => $model->user_id]];

// if (!$model->isNewRecord)
//     $this->params['breadcrumbs'][] = ['label' => $model->application->appl_no, 'url' => ['update', 'id' => $model->application->id]];
$this->params['breadcrumbs'][] = (($model->isNewRecord)? Yii::t('app', 'Create'):Yii::t('app', 'Update'));
?>
<br>
 <div class="modal-content">
   <div class="modal-body">
   <?php $form = ActiveForm::begin(); ?>
     <?php if (false && !$model->isNewRecord) { ?>
     <div class="box-tools pull-right">
        <?=  Html::a('申請表詳細', ['application/view', 'id' => $model->application->id], ['class' => 'btn btn-sm btn-info pull-right']) ?>
    </div>
    <?php } ?>
     <h3>基本資料</h3>
<?php
  $chi_name = isset($model->user->application->chi_name) ? $model->user->application->chi_name : '';
  $eng_name = isset($model->user->application->eng_name) ? $model->user->application->eng_name : '';
?>
     <?= $form->field($model, 'appl_no')->textInput(['value' => $model->user->application->appl_no,'disabled' => true]) ?>
     <?= $form->field($model, 'chi_name')->textInput(['value' => $chi_name,'disabled' => true]) ?>
     <?= $form->field($model, 'eng_name')->textInput(['value' => $eng_name,'disabled' => true]) ?>
     <?= $form->field($model, 'mobile')->textInput(['value' => $model->user->application->mobile,'disabled' => true]) ?>
     <?= $form->field($model, 'user_appl_status')->textInput(['value' => Definitions::getUserApplicationStatus($model->user->user_appl_status),'disabled' => true]) ?>
     <hr />

    <h3>用戶已上載文件</h3>
    <div class="row">
        <?php
          $i = 0; 
          foreach ($model->picture_file_names as $_file_name => $_file_description) {
        ?>

          <div class="col-md-6" style="margin-bottom:15px;font-size:16px;">
              <?= ++$i.'. '.Html::a($_file_description, $model->fileDisplayPath.$_file_name, ['target'=>'_blank']) ?>
          </div>
        <?php } ?>
    </div>
    <hr />
    <?= $form->field($model, 'payment_year')->textInput(['type' => 'number', 'placeholder' => '請輸入年份']) ?>
    <?= $form->field($model, 'payment_month')->textInput(['type' => 'number', 'placeholder' => '請輸入月份']) ?>

   <div class="form-group">
       <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
   </div>

   <?php ActiveForm::end(); ?>
 </div>
</div><!-- /.modal-content -->
