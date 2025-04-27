<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use kartik\grid\GridView;
use kartik\editable\Editable;
use common\models\Definitions;
use common\models\Application;
use kartik\widgets\DatePicker;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UsersDataProvider */
/* @var $dataProvider yii\data\ActiveDataProvider */

$appl_model = Application::findOne(['id' => $aid]);

$this->title = '已提交上載文件 ('.$appl_model->appl_no.')';
$this->params['breadcrumbs'][] = ['label' => '申請表 (請先選擇申請)', 'url' => ['/application/response-file-list']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="users-index">
<?php if (false) { ?>
    <p>
      <?= Html::a(Yii::t('app',"Create {modelClass}",['modelClass'=>'要求上載文件']),['create', 'aid' => $appl_model->id],
            ['class' => 'btn btn-success']);
                  ?>
    </p>
<?php } ?>
    <?php Pjax::begin(['id'=>'application-request-files-pjax']); ?>

    <?php
    $gridColumns =
    [
        [
          'attribute' => 'date',
          'label' => '已提交上載文件時間',
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
          'attribute' => 'appl_no',
          'vAlign'=>'middle',
          'headerOptions'=>['class'=>'kv-sticky-column'],
          'contentOptions'=>['class'=>'kv-sticky-column', 'style'=>'width: 10%;'],
          'value' => function($model){
              return ($model->application->appl_no) ?: '';
          },
        ],
        [
          'label' => '申請人數',
          'attribute' => 'family_member',
          'vAlign'=>'middle',
          'headerOptions'=>['class'=>'kv-sticky-column'],
          'contentOptions'=>['class'=>'kv-sticky-column', 'style'=>'width: 10%;'],
          'value' => function($model){
            return ($model->application->family_member) ?: '';
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
            return ($model->application->mobile) ?: '';
          },
        ],
        [
          'attribute' => 'ref_code',
          'vAlign'=>'middle',
          'headerOptions'=>['class'=>'kv-sticky-column'],
          'contentOptions'=>['class'=>'kv-sticky-column', 'style'=>'width: 10%;'],
          'value' => function($model){
            return ($model->applicationRequestFiles->ref_code) ?: '';
          },
        ],
        [
          'attribute' => 'app_status',
          'vAlign'=>'middle',
          'filter' => Definitions::getAppStatus(),
          'headerOptions'=>['class'=>'kv-sticky-column'],
          'contentOptions'=>['class'=>'kv-sticky-column', 'style'=>'width: 10%;'],
          'value' => function($model){
            return Definitions::getAppStatus($model->applicationRequestFiles->app_status);
          },
      ],

        /*
        [
          'attribute' => 'chi_name',
          'vAlign'=>'middle',
          'headerOptions'=>['class'=>'kv-sticky-column'],
          'contentOptions'=>['class'=>'kv-sticky-column', 'style'=>'width: 15%;'],
          'value' => function($model){
              return ($model->application->chi_name) ?: '';
          },
        ],
        [
          'attribute' => 'eng_name',
          'vAlign'=>'middle',
          'headerOptions'=>['class'=>'kv-sticky-column'],
          'contentOptions'=>['class'=>'kv-sticky-column', 'style'=>'width: 15%;'],
          'value' => function($model){
              return ($model->application->eng_name) ?: '';
          },
        ],
        [
          'attribute' => 'total',
          'vAlign'=>'middle',
          'headerOptions'=>['class'=>'kv-sticky-column'],
          'contentOptions'=>['class'=>'kv-sticky-column', 'style'=>'width: 15%;'],
        ],
        */
        [
          'class' => 'backend\components\ActionColumn',
          'template'=> '{update} {download}',
          'contentOptions'=>['style'=>['width'=>'10%','white-space' => 'nowrap']],
          'buttons' => [
            'download' => function ($url, $model, $key) {
              return  Html::a('加入zip', $url, ['class' => 'btn btn-danger btn-xs', 'onclick' => 'reloadPage(event,"'.$url.'");']);
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