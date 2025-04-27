<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
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
<?php if (false) { ?>
    <p>
      <?= Html::a(Yii::t('app',"Create {modelClass}",['modelClass'=>Yii::t('app','Users')]),['create'],
            ['class' => 'btn btn-success']);
                  ?>
    </p>
<?php } ?>
    <?php Pjax::begin(['id'=>'menu-pjax']); ?>

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
          'vAlign'=>'middle',
          'headerOptions'=>['class'=>'kv-sticky-column'],
          'contentOptions'=>['class'=>'kv-sticky-column', 'style'=>'width: 10%;'],
          'value' => function($model){
            return ($model->application->application_status) ? Definitions::getApplicationStatus($model->application->application_status): '';
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
            $url = str_replace('/admin/user','/admin/application',$url);
            $url = str_replace('id='.$model->id,'id='.$model->application->id,$url);
            
            return Html::a('檢視申請資料', $url, ['class' => 'btn btn-xs btn-info', 'onclick' => 'reloadPage(event,"'.$url.'");']);
          },

          'rental-payment' => function($url, $model, $key) {
            $url = str_replace('/admin/user','/admin',$url);

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