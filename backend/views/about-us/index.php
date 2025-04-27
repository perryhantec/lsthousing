<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use kartik\grid\GridView;
use kartik\editable\Editable;
use common\models\Definitions;
use common\models\AboutUs;
use kartik\widgets\DatePicker;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UsersDataProvider */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '關於樂屋';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="users-index">
    <p>
      <?= Html::a(Yii::t('app',"Create {modelClass}",['modelClass'=>'關於樂屋']),['create'],
            ['class' => 'btn btn-success']);
                  ?>
    </p>

    <?php Pjax::begin(['id'=>'about-us-pjax']); ?>

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
                              'weekStart' => 0,
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
          'attribute' => 'show_year',
          'vAlign'=>'middle',
          'headerOptions'=>['class'=>'kv-sticky-column'],
          'contentOptions'=>['class'=>'kv-sticky-column', 'style'=>'width: 10%;'],
        ],
        [
          'header' => Yii::t('app','Reorder'),
          'format' => 'raw',
          'vAlign'=>'middle',
          'width' => '10%',
          'value'=> function($model){
                      return Html::a(Yii::t('app',"Reorder"),['reorder'],
                                      ['class' => 'popupModal btn btn-default btn-xs']);
                    },
          'headerOptions'=>['class'=>'kv-sticky-column'],
          'contentOptions'=>['class'=>'kv-sticky-column'],
        ],
        [
            'attribute' => 'status',
            'vAlign'=>'middle',
            'filter' => Definitions::getStatus(),
            'value' => function($model){
                      return Definitions::getStatus($model->status);
            },
            'headerOptions'=>['class'=>'kv-sticky-column'],
            'contentOptions'=>['class'=>'kv-sticky-column', 'style'=>'width: 10%;'],
        ],
      [
        'class' => 'backend\components\ActionColumn',
        // 'template'=> '{view} {update} {application-request-files} {application-response-files} {application-visit} {update-visit}',
        'template'=> '{update} {enabled} {disabled} {delete}',
        'contentOptions'=>['style'=>['width'=>'5%','white-space' => 'nowrap']],
        'buttons' => [

        ],
        'visibleButtons' => [
          'disabled' => function ($model) { return $model->status >= $model::STATUS_1; },
          'enabled' => function ($model) { return $model->status == $model::STATUS_0; },
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