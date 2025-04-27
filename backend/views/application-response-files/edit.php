<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use mihaildev\ckeditor\CKEditor;
use mihaildev\elfinder\ElFinder;
use common\models\Definitions;
use common\models\Application;
use common\models\File;
use kartik\widgets\FileInput;
use kartik\sortable\Sortable;

// $model->application = Application::findOne(['id' => $aid]);

$this->title =  '已提交上載文件 ('.$model->application->appl_no.') - '.(($model->isNewRecord)? Yii::t('app', 'Create'):Yii::t('app', 'Update'));

$this->params['breadcrumbs'][] = ['label' => '申請表 (請先選擇申請)', 'url' => ['/application/response-file-list']];
$this->params['breadcrumbs'][] = ['label' => '已提交上載文件 ('.$model->application->appl_no.')', 'url' => ['index', 'id' => $model->application_id]];


$files = File::find()->where(['in', 'auth_key', $model->file_keys])->asArray()->all();
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
     <?= $form->field($model, 'application_no')->textInput(['value' => $model->application->appl_no,'disabled' => true]) ?>
     <?= $form->field($model, 'ref_code')->textInput(['value' => $model->applicationRequestFiles->ref_code,'disabled' => true]) ?>
     <hr />
    <h3>已要求上載文件</h3>
    <?php
      // echo $form->errorSummary($model);
      $part7s = Definitions::getPart7ContentWithTitle();
      $requests = json_decode($model->applicationRequestFiles->request);
      $response_result = $model->response_result ? json_decode($model->response_result, true) : [];
      $html = '';

      // foreach ($part7s as $title => $subcontents) {
      //   $html .= '<h3><strong>'.$title.'</strong></h3>';
      //   foreach ($subcontents as $subtitle => $items) {
      //     $html .= '<h4 style="margin-left:15px;"><u>'.$subtitle.'</u></h4>';
      //     foreach ($items as $i => $label) {
      //       // $html .= $form->field($model, 'i'.$i)->checkbox(['label' => $label,'value' => $i, 'style' => 'margin-left:30px;'])->label(false);
      //       $html .= '<div>'.$label.'</div>';
      //     }
      //   }
      // }

      $first_access_title_1 = true;
      $first_access_title_2 = true;
      $first_access_subtitle_1 = true;
      $first_access_subtitle_2 = true;
      $first_access_subtitle_3 = true;
      $first_access_subtitle_4 = true;
      
      $title_gp = Definitions::getPart7TitleGroup();
      $subtitle_gp = Definitions::getPart7SubtitleGroup();
      
      foreach ($requests as $request) {
          $i = $j = 0;
  
          foreach ($part7s as $title => $subcontents) {
              if ($i == 0 && in_array($request, $title_gp[0]) && $first_access_title_1) {
                  $html .= '<h3 style="margin-top:20px;margin-bottom:10px;"><strong>'.$title.'</strong></h3>';
                  $first_access_title_1 = false;
              } elseif ($i == 1 && in_array($request, $title_gp[1]) && $first_access_title_2) {
                  $html .= '<h3 style="margin-top:20px;margin-bottom:10px;"><strong>'.$title.'</strong></h3>';
                  $first_access_title_2 = false;
              }
              foreach ($subcontents as $subtitle => $items) {
                  $k = $j + 1;
                  $field = 's'.$k;
                  $model->$field = isset($response_result[$field]) ? $response_result[$field] : '';

                  if ($j == 0 && in_array($request, $subtitle_gp[0]) && $first_access_subtitle_1) {
                      $html .= '<h4 style="margin-left:15px;"><u>'.$subtitle.'</u></h4>';
                      $html .= $form->field($model, $field)->dropDownList(Definitions::getFileStatus(),[
                        'prompt'=>Yii::t('app', 'Please Select'),
                        'style'=>'margin-left:15px;width:100px;'
                      ])->label(false);
                      $first_access_subtitle_1 = false;
                  } elseif ($j == 1 && in_array($request, $subtitle_gp[1]) && $first_access_subtitle_2) {
                      $html .= '<h4 style="margin-left:15px;"><u>'.$subtitle.'</u></h4>';
                      $html .= $form->field($model, $field)->dropDownList(Definitions::getFileStatus(),[
                        'prompt'=>Yii::t('app', 'Please Select'),
                        'style'=>'margin-left:15px;width:100px;'
                      ])->label(false);
                      $first_access_subtitle_2 = false;
                  } elseif ($j == 2 && in_array($request, $subtitle_gp[2]) && $first_access_subtitle_3) {
                      $html .= '<h4 style="margin-left:15px;"><u>'.$subtitle.'</u></h4>';
                      $html .= $form->field($model, $field)->dropDownList(Definitions::getFileStatus(),[
                        'prompt'=>Yii::t('app', 'Please Select'),
                        'style'=>'margin-left:15px;width:100px;'
                      ])->label(false);
                      $first_access_subtitle_3 = false;
                  } elseif ($j == 3 && in_array($request, $subtitle_gp[3]) && $first_access_subtitle_4) {
                      $html .= '<h4 style="margin-left:15px;"><u>'.$subtitle.'</u></h4>';
                      $html .= $form->field($model, $field)->dropDownList(Definitions::getFileStatus(),[
                        'prompt'=>Yii::t('app', 'Please Select'),
                        'style'=>'margin-left:15px;width:100px;'
                      ])->label(false);
                      $first_access_subtitle_4 = false;
                  } elseif ($j > 3 &&  in_array($request, $subtitle_gp[$j])) {
                      $html .= '<h4 style="margin-left:15px;"><u>'.$subtitle.'</u></h4>';
                      $html .= $form->field($model, $field)->dropDownList(Definitions::getFileStatus(),[
                        'prompt'=>Yii::t('app', 'Please Select'),
                        'style'=>'margin-left:15px;width:100px;'
                      ])->label(false);
                  }
      
                  foreach ($items as $index => $label) {
                      if ($index == $request) {
                          $html .= '<div style="margin-left:30px;color:green;"><i class="fa fa-check-square"></i> '.$label.'</div>';
                      }
                  }
                  $j++;
              }
              $i++;
          }
      }

      echo $html;
    ?>
    <hr />

    <h3>申請者已上載文件</h3>

    <div class="row">
        <?php
          $i = 1;
          // $file_paths = []; 
          foreach ($files as $file) {
            if (isset($file['filepath']) && $file['filepath'] != false) {
        ?>
              <div style="padding:0 20px;margin-bottom:15px;font-size:16px;">
              <?php
                $single_line_title = ''; 
                if (isset($model->picture_file_names[$i]['title']) && $model->picture_file_names[$i]['title'] > 0) {
                  $single_line_title = Definitions::getPart7ContentWithTitleSingleLine($model->picture_file_names[$i]['title']);
                }
              ?>
                  <?= $i.'. '.$single_line_title ?>
                  <p><?= Html::a($file['filename'], $model->fileDisplayPath.$file['filepath'], ['target'=>'_blank']) ?></p>
              </div>
        <?php
              // $file_paths[] = $model->fileDisplayPath.$file['filepath'];
              // $file_paths[] = $file['filepath'];
            }
            $i++;
          } 
          // echo '<pre>';
          // print_r($file_paths);
          // echo '</pre>';
        ?>
    </div>
    <hr />

   <div class="form-group">
       <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
   </div>

   <?php ActiveForm::end(); ?>
 </div>
</div><!-- /.modal-content -->