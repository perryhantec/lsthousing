<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\widgets\ActiveForm;
use kartik\grid\GridView;
use kartik\editable\Editable;
use common\models\Definitions;
use common\models\User;
/* @var $this yii\web\View */
/* @var $searchModel app\models\UsersDataProvider */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '住戶上載交租文件 - 請先選擇'.Yii::t('app', 'Users');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="users-index">
    <?php Pjax::begin(['id'=>'menu-pjax']); ?>

    <div class="row">
      <div class="col-md-12">
        <!-- general form elements -->
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title"><?= Yii::t('app', 'Import')?></h3>
          </div>
          <!-- /.box-header -->
          <!-- form start -->
            <div class="box-body">
              <div class="row">
                <?php $form = ActiveForm::begin([
                    'options' => ['enctype' => 'multipart/form-data']
                    ]) ?>

                  <div class="col-xs-12">
                    <?php
                    foreach($model_application_import->error_excel as $row=>$error){
                      echo $form->errorSummary($error, ['header' => Yii::t('app', 'Row'). ' '. $row]);
                    }
                    ?>
                 </div>
               </div>

              <div class="row">
                <div class="col-xs-12 ">
                  <h4><u>Excel: </u></h4>
                  <p>
                    <b>A</b>:申請編號 <b>B</b>:項目名稱 <b>C</b>:房間編號 <b>D</b>:姓名(中文) <b>E</b>:姓名(英文)
                    <b>F</b>:流動電話號碼 <b>G</b>:起租日期
                    <!-- <b>G</b>:交租年份 <b>H</b>:交租月份 <b>I</b>:起租日期 -->
                  </p>

                  <h4><u>Rule: </u></h4>
                  <p><b>A</b>:申請編號: 如輸入為已有編號 >> 更新, 如有輸入但系統沒有該編號 >> 新增 (編號將為輸入編號), 如沒有輸入編號 >> 新增 (編號將為系統編配)</p>
                  <p><b>B</b>:項目名稱: 請跟據 樂屋項目 >「標題 (繁體版本)」</p>
                  <p><b>D</b>:姓名(中文): 跟E其中一項為必填</p>
                  <p><b>E</b>:姓名(英文): 跟D其中一項為必填</p>
                  <!-- <p><b>F</b>:流動電話號碼: 必填, 只能填寫4、5、6或9字頭的8位數字</p> -->
                  <p><b>F</b>:流動電話號碼: 必填</p>
                  <p><b>G</b>:起租日期: 格式為「'xxxx-xx-xx」, 例: '2019-01-01</p>
                  <p>新增/更新用戶後前台預設密碼為LSThousing2022</p>
                  <p>此匯入只新增/更新用戶基本資料, 如需更改資料, 請到 申請表 > 更改申請表</p>
                  <!-- <p><b>I</b>:起租日期: 格式為「'xxxx-xx-xx」, 例: '2019-01-01</p> -->
                  <?php $url = Yii::getAlias('@web').'/file/application_import_demo.xlsx'; ?>
                  <p><?= Html::a('下載範例', $url, ['download' => true, 'onclick' => 'reloadPage(event,"'.$url.'");'])?></p>
                </div>
                <div class="col-xs-6 col-md-6">
                    <?= $form->field($model_application_import, 'file')->fileInput() ?>
                </div>
              </div>
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
              <?= Html::submitButton(Yii::t('app', 'Submit'), ['class' => 'btn btn-primary']) ?>
            </div>
            <?php ActiveForm::end() ?>

        </div>
      </div>
      
    </div>

    <?php
    $gridColumns =
    [
        [
          'attribute' => 'appl_no',
          'vAlign'=>'middle',
          'headerOptions'=>['class'=>'kv-sticky-column'],
          'contentOptions'=>['class'=>'kv-sticky-column', 'style'=>'width: 10%;'],
          'value' => function($model){
            return ($model->application->appl_no) ?: '';
          },
        ],
        [
          'attribute' => 'project',
          'filter' => Definitions::getProjectName(),
          'vAlign'=>'middle',
          'headerOptions'=>['class'=>'kv-sticky-column'],
          'contentOptions'=>['class'=>'kv-sticky-column', 'style'=>'width: 15%;'],
          'value' => function($model){
            return Definitions::getProjectName($model->application->project);
          },
        ],
        [
          'attribute' => 'room_no',
          'vAlign'=>'middle',
          'headerOptions'=>['class'=>'kv-sticky-column'],
          'contentOptions'=>['class'=>'kv-sticky-column', 'style'=>'width: 10%;'],
          'value' => function($model){
              return ($model->application->room_no) ?: '';
          },
        ],
        [
          'attribute' => 'chi_name',
          'vAlign'=>'middle',
          'headerOptions'=>['class'=>'kv-sticky-column'],
          'contentOptions'=>['class'=>'kv-sticky-column', 'style'=>'width: 10%;'],
          'value' => function($model){
            return ($model->application->chi_name) ?: '';
          },
        ],
        [
          'attribute' => 'eng_name',
          'vAlign'=>'middle',
          'headerOptions'=>['class'=>'kv-sticky-column'],
          'contentOptions'=>['class'=>'kv-sticky-column', 'style'=>'width: 10%;'],
          'value' => function($model){
            return ($model->application->eng_name) ?: '';
          },
        ],
        [
          'attribute' => 'mobile',
          'vAlign'=>'middle',
          'headerOptions'=>['class'=>'kv-sticky-column'],
          'contentOptions'=>['class'=>'kv-sticky-column', 'style'=>'width: 10%;'],
          'value' => function($model){
            // return ($model->application->mobile) ?: '';
            return '';
          },
        ],
        [
          'attribute' => 'application_status',
          'filter' => Definitions::getApplicationStatus(),
          'vAlign'=>'middle',
          'headerOptions'=>['class'=>'kv-sticky-column'],
          'contentOptions'=>['class'=>'kv-sticky-column', 'style'=>'width: 10%;'],
          // 'value' => function($model){
          //   return ($model->application->application_status) ? Definitions::getApplicationStatus($model->application->application_status): '';
          // },
          'value' => function($model){
            return Definitions::getApplicationStatus($model->application->application_status);
          },

        ],
        // [
        //     'attribute' => 'role',
        //     'vAlign'=>'middle',
        //     'filter' => Definitions::getRole(),
        //     'value' => function($model){
        //               return Definitions::getRole($model->role);
        //     },
        //     'headerOptions'=>['class'=>'kv-sticky-column'],
        //     'contentOptions'=>['class'=>'kv-sticky-column', 'style'=>'width: 10%;'],
        // ],
        // [
        //   'attribute' => 'user_appl_status',
        //   'vAlign'=>'middle',
        //   'filter' => Definitions::getUserApplicationStatus(),
        //   'value' => function($model){
        //             return Definitions::getUserApplicationStatus($model->user_appl_status);
        //   },
        //   'headerOptions'=>['class'=>'kv-sticky-column'],
        //   'contentOptions'=>['class'=>'kv-sticky-column', 'style'=>'width: 10%;'],
        // ],
        // [
        //     'attribute' => 'status',
        //     'vAlign'=>'middle',
        //     'filter' => Definitions::getStatus(),
        //     'value' => function($model){
        //               return Definitions::getStatus($model->status);
        //     },
        //     'headerOptions'=>['class'=>'kv-sticky-column'],
        //     'contentOptions'=>['class'=>'kv-sticky-column', 'style'=>'width: 10%;'],
        // ],
      [
        'class' => 'backend\components\ActionColumn',
        'template'=> '{view} {rental-payment}',
        'contentOptions'=>['style'=>['width'=>'5%','white-space' => 'nowrap']],
        'buttons' => [
          'view' => function($url, $model, $key) {
            $url = str_replace('/admin/rental-payment','/admin/application',$url);
            $url = str_replace('id='.$model->id,'id='.$model->application->id,$url);
            
            return Html::a('檢視申請資料', $url, ['class' => 'btn btn-xs btn-info', 'onclick' => 'reloadPage(event,"'.$url.'");']);
          },

          'rental-payment' => function($url, $model, $key) {
            $url = str_replace('/admin/rental-payment','/admin',$url);

            return Html::a('住戶上載交租文件', $url, ['class' => 'btn btn-xs btn-success', 'onclick' => 'reloadPage(event,"'.$url.'");']);
          },
        ],
      ],
    ]

    ?>

     <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns'=>$gridColumns,
            'containerOptions'=>['style'=>'overflow: auto'], // only set when $responsive = false
            'headerRowOptions'=>['class'=>'kartik-sheet-style'],
            'filterRowOptions'=>['class'=>'kartik-sheet-style'],
            'pjax'=>true, // pjax is set to always true for this demo
            'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container',], 'enablePushState' => false],

            // set your toolbar
            'toolbar'=> [
                // ['content'=>
                //     Html::a('<i class="glyphicon glyphicon-plus"></i>', ['create'], ['class'=>'btn btn-success', 'title'=>Yii::t('app', 'Create')])
                // ],
                //'{export}',
                //'{toggleData}',
            ],
            'export'=>[
               'fontAwesome'=>true
           ],
           // parameters from the demo form
           'bordered'=>true,
           'striped'=>false,
           'condensed'=>true,
           'responsive'=>true,
           'responsiveWrap' => false,
           'hover'=>true,
           //'showPageSummary'=>true,
           'panel'=>[
               'type'=>GridView::TYPE_PRIMARY,
               'heading'=> '',
           ],
           'persistResize'=>false,
           //'exportConfig'=>$exportConfig,


        ]); ?>
    <?php Pjax::end(); ?></div>

  </div>
  <script>
  function reloadPage(e, url) {
    e.preventDefault();
    // prevent render wrong view, i.e. application/index  
    window.location.href = url;
  }
</script>