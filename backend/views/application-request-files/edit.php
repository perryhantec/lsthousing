<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use mihaildev\ckeditor\CKEditor;
use mihaildev\elfinder\ElFinder;
use common\models\Definitions;
use common\models\Application;

$appl_model = Application::findOne(['id' => $aid]);

$this->title =  '要求上載文件 ('.$appl_model->appl_no.') - '.(($model->isNewRecord)? Yii::t('app', 'Create'):Yii::t('app', 'Update'));

$this->params['breadcrumbs'][] = ['label' => '申請表 (請先選擇申請)', 'url' => ['/application/request-file-list']];
$this->params['breadcrumbs'][] = ['label' => '要求上載文件 ('.$appl_model->appl_no.')', 'url' => ['index', 'id' => $aid]];

// if (!$model->isNewRecord)
//     $this->params['breadcrumbs'][] = ['label' => $appl_model->appl_no, 'url' => ['update', 'id' => $appl_model->id]];
$this->params['breadcrumbs'][] = (($model->isNewRecord)? Yii::t('app', 'Create'):Yii::t('app', 'Update'));
?>
<br>
 <div class="modal-content">
   <div class="modal-body">
   <?php $form = ActiveForm::begin(); ?>
     <?php if (!$model->isNewRecord) { ?>
     <div class="box-tools pull-right">
        <?=  Html::a('申請表詳細', ['application/view', 'id' => $appl_model->id], ['class' => 'btn btn-sm btn-info pull-right']) ?>
    </div>
    <?php } ?>
    <h3>基本資料</h3>
     <?= $form->field($model, 'application_chi_name')->textInput(['value' => $appl_model->chi_name,'disabled' => true]) ?>
     <?= $form->field($model, 'application_eng_name')->textInput(['value' => $appl_model->eng_name,'disabled' => true]) ?>
     <?= $form->field($model, 'application_no')->textInput(['value' => $appl_model->appl_no,'disabled' => true]) ?>
     <?= $form->field($model, 'application_created_at')->textInput(['value' => date('Y-m-d',strtotime($appl_model->created_at)),'disabled' => true]) ?>
     <?= $form->field($model, 'application_priority_1')->textInput(['value' => Definitions::getProjectName($appl_model->priority_1),'disabled' => true]) ?>
     <?= $form->field($model, 'application_priority_2')->textInput(['value' => $appl_model->priority_2 ? Definitions::getProjectName($appl_model->priority_2) : '-','disabled' => true]) ?>
     <?= $form->field($model, 'application_priority_3')->textInput(['value' => $appl_model->priority_3 ? Definitions::getProjectName($appl_model->priority_3) : '-','disabled' => true]) ?>
     <?= $form->field($model, 'application_family_member')->textInput(['value' => $appl_model->family_member,'disabled' => true]) ?>
     <hr />

    <div>請選擇要求上載文件</div>
    <?php
      $part7s = Definitions::getPart7ContentWithTitle();
      $html = '';

      $alerts = [];
      if ($alert != '') {
        foreach (explode('_', $alert) as $temp_alerts) {
          $temp_alert = explode('-', $temp_alerts);
          $alerts[$temp_alert[0]] = $temp_alert[1];
        }  
      }

      // echo '<pre>';
      // print_r($alerts);
      // echo '</pre>';

      $j = 1;
      foreach ($part7s as $title => $subcontents) {
        $html .= '<h3><strong>'.$title.'</strong></h3>';
        foreach ($subcontents as $subtitle => $items) {
          $warning = '';
          if (isset($alerts[$j])) {
            if ($alerts[$j] == 2) {
              $warning = ' <span style="color:red;">('.Definitions::getFileStatus(2).')</span>';
            } elseif ($alerts[$j] == 3) {
              $warning = ' <span style="color:orange;">('.Definitions::getFileStatus(3).')</span>';
            }
          }

          $html .= '<h4 style="margin-left:15px;"><u>'.$subtitle.'</u>'.$warning.'</h4>';
          foreach ($items as $i => $label) {
            $html .= $form->field($model, 'i'.$i)->checkbox(['label' => $label,'value' => $i, 'style' => 'margin-left:30px;'])->label(false);
          }
          $j++;
        }
      }
      echo $html;
    ?>
    <?= $form->field($model, 'check_files')->hiddenInput(['value' => ''])->label(false); ?>
    <hr />
    <?= $form->field($model, 'remarks')->widget(CKEditor::className(), [
          'editorOptions' => ElFinder::ckeditorOptions('elfinder', ['preset' => 'full', 'contentsCss' => Yii::$app->params['ckeditorOptionsContentsCss'], 'bodyClass' => 'content', 'allowedContent' => true]),
        ]);
    ?>

    <?= $form->field($model, 'application_id')->hiddenInput(['value' => $aid])->label(false); ?>
    <?= $form->field($model, 'user_id')->hiddenInput(['value' => $appl_model->user_id])->label(false); ?>

   <div class="form-group">
       <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
   </div>

   <?php ActiveForm::end(); ?>
 </div>
</div><!-- /.modal-content -->
