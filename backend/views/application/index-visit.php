<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use kartik\grid\GridView;
use kartik\editable\Editable;
use common\models\Definitions;
use kartik\widgets\DatePicker;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UsersDataProvider */
/* @var $dataProvider yii\data\ActiveDataProvider */

// $extra_text = '';

// if (isset($action)) {
//   if ($action == 'request') {
//     $extra_text = '要求上載文件 - 請先選擇';
//   } elseif ($action == 'response') {
//     $extra_text = '已提交上載文件 - 請先選擇';
//   } elseif ($action == 'visit') {
//     $extra_text = '家訪紀錄 - 請先選擇';
//   }  
// }

$this->title = '家訪紀錄';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="users-index">
<?php if (false) { ?>
    <p>
      <?= Html::a(Yii::t('app',"Create {modelClass}",['modelClass'=>'申請表']),['create'],
            ['class' => 'btn btn-success']);
                  ?>
    </p>
<?php } ?>

    <?php Pjax::begin(['id'=>'application-visit-pjax']); ?>

    <?php
    $gridColumns =
    [
        [
          'attribute' => 'date',
          'label' => Yii::t('app', 'Created At'),
          'width' => '10%',
          'format' => 'raw',
          'filter' => DatePicker::widget([
                          'model'=>$searchModel,
                          'attribute'=>'date',
                          'type' => DatePicker::TYPE_INPUT,
                          'options' => ['autocomplete' => 'off'],
                          'pluginOptions' => [
                              'autoclose'=>true,
                              // 'weekStart' => 0,
                              'format' => 'yyyy-mm-dd'
                          ]
                        ]),
          'value' => function($model){
  //                  return Yii::$app->formatter->asDate($model->created_at, 'long');
                    return ($model->created_at) ? date('Y-m-d',strtotime($model->created_at)) : '';
          },
          'vAlign'=>'middle',
          'headerOptions'=>['class'=>'kv-sticky-column'],
          'contentOptions'=>['class'=>'kv-sticky-column'],
        ],
        [
          'attribute' => 'appl_no',
          'vAlign'=>'middle',
          'headerOptions'=>['class'=>'kv-sticky-column'],
          'contentOptions'=>['class'=>'kv-sticky-column', 'style'=>'width: 10%;'],
        ],
        [
          'label' => '申請人數',
          'attribute' => 'family_member',
          'vAlign'=>'middle',
          'headerOptions'=>['class'=>'kv-sticky-column'],
          'contentOptions'=>['class'=>'kv-sticky-column', 'style'=>'width: 10%;'],
        ],
        [
          'attribute' => 'chi_name',
          'vAlign'=>'middle',
          'headerOptions'=>['class'=>'kv-sticky-column'],
          'contentOptions'=>['class'=>'kv-sticky-column', 'style'=>'width: 10%;'],
        ],
        [
          'attribute' => 'eng_name',
          'vAlign'=>'middle',
          'headerOptions'=>['class'=>'kv-sticky-column'],
          'contentOptions'=>['class'=>'kv-sticky-column', 'style'=>'width: 10%;'],
        ],
        [
          'attribute' => 'mobile',
          'vAlign'=>'middle',
          'headerOptions'=>['class'=>'kv-sticky-column'],
          'contentOptions'=>['class'=>'kv-sticky-column', 'style'=>'width: 10%;'],
          'value' => function($model){
              return '';
          },
        ],
        // [
        //   'attribute' => 'visit_date',
        //   'width' => '10%',
        //   'format' => 'raw',
        //   'filter' => DatePicker::widget([
        //                   'model'=>$searchModel,
        //                   'attribute'=>'visit_date',
        //                   'type' => DatePicker::TYPE_INPUT,
        //                   'options' => ['autocomplete' => 'off'],
        //                   'pluginOptions' => [
        //                       'autoclose'=>true,
        //                       'weekStart' => 0,
        //                       'format' => 'yyyy-mm-dd'
        //                   ]
        //                 ]),
        //   'vAlign'=>'middle',
        //   'headerOptions'=>['class'=>'kv-sticky-column'],
        //   'contentOptions'=>['class'=>'kv-sticky-column'],
        // ],
        [
          'attribute' => 'visit_date',
          'filter' => DatePicker::widget([
                          'model'=>$searchModel,
                          'attribute'=>'visit_date',
                          'type' => DatePicker::TYPE_INPUT,
                          'options' => ['autocomplete' => 'off'],
                          'pluginOptions' => [
                              'autoclose'=>true,
                              'format' => 'yyyy-mm-dd'
                          ]
                        ]),
          'vAlign'=>'middle',
          'headerOptions'=>['class'=>'kv-sticky-column', 'style'=>'width: 10%;'],
          'contentOptions'=>['class'=>'kv-sticky-column'],
          // 'editableOptions'=> ['formOptions' => ['action' => ['pagetype4/edit_grid']]]
        ],
        [
            'attribute' => 'application_status',
            'vAlign'=>'middle',
            'filter' => Definitions::getApplicationStatus(),
            'value' => function($model){
                      return Definitions::getApplicationStatus($model->application_status);
            },
            'headerOptions'=>['class'=>'kv-sticky-column'],
            'contentOptions'=>['class'=>'kv-sticky-column', 'style'=>'width: 10%;'],
        ],
      [
        'class' => 'backend\components\ActionColumn',
        // 'template'=> '{view} {update} {application-request-files} {application-response-files} {application-visit} {update-visit}',
        'template'=> '{view} {update} {update-visit}',
        'contentOptions'=>['style'=>['width'=>'15%','white-space' => 'nowrap']],
        'buttons' => [
          'view' => function ($url, $model, $key) {
            return  Html::a('檢視申請資料', $url, ['class' => 'btn btn-info btn-xs']);
          },
          'update' => function ($url, $model, $key) {
            return  Html::a('更改狀態', $url, ['class' => 'btn btn-warning btn-xs']);
          },
          'update-visit' => function ($url, $model, $key) {
            return  Html::a('更新家訪紀錄', $url, ['class' => 'btn btn-primary btn-xs']);
          },
        ],
        'visibleButtons' => [
          // 'view' => function ($model) { return $model->application_status == $model::APPL_STATUS_SUBMITED_FORM; },
          // 'update' => function ($model) { return $model->application_status == $model::APPL_STATUS_SUBMITED_FORM; },
        ]
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