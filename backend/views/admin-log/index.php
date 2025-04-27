<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use kartik\grid\GridView;
use kartik\editable\Editable;
use common\models\Definitions;
use common\models\Menu;
use yii\web\JsExpression;
use backend\components\AccessRule;

$this->title = Yii::t('app', 'Admin Logs');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="admin-log-index">

    <?php Pjax::begin(['id'=>'admin-log-pjax']); ?>

    <?php
    $gridColumns =
    [
      [
          'attribute' => 'date',
          'label' => Yii::t('app', 'Date'),
          'vAlign' => 'middle',
          'value' => function($model){
              return $model->created_at;
          },
          'headerOptions'=>['class'=>'kv-sticky-column'],
          'contentOptions'=>['class'=>'kv-sticky-column', 'style'=>'width: 15%;'],
      ],
      [
          'attribute' => 'message',
          'vAlign' => 'middle',
          'headerOptions'=>['class'=>'kv-sticky-column'],
          'contentOptions'=>['class'=>'kv-sticky-column', 'style'=>'width: 40%;'],
      ],
      [
          'attribute' => 'menu_id',
          'label' => Yii::t('app', 'Page'),
          'vAlign'=>'middle',
          'value' => function($model){
              return $model->menu !== null ? $model->menu->nameWithSubmenu : '-';
          },
          'filter' => Menu::getAllMenusForDropdown(null, false),
          'headerOptions'=>['class'=>'kv-sticky-column'],
          'contentOptions'=>['class'=>'kv-sticky-column', 'style'=>'width: 20%;'],
      ],
      [
          'attribute' => 'admin_user_id',
          'header' => Yii::t('app', 'Admin User'),
          'vAlign'=>'middle',
          'format' => 'raw',
          'value' => function($model) {
                    return ($model->adminUser != null && $model->adminUser->role >= Yii::$app->user->identity->role) ? (AccessRule::checkRole(['admin.user']) ? Html::a($model->adminUser->name, ['/admin-user/view', 'id' => $model->adminUser->id]) : $model->adminUser->name) : '-';
              },
          'filterType' => GridView::FILTER_SELECT2,
          'filterWidgetOptions' =>  [
                    'initValueText' => ($searchModel->adminUser != null && $searchModel->adminUser->role >= Yii::$app->user->identity->role) ? [$searchModel->adminUser->id => $searchModel->adminUser->name] : null,
                    'options' => ['placeholder' => ''],
                    'pluginOptions' => [
                        'allowClear' => true,
                        'minimumInputLength' => 2,
                        'ajax' => [
                            'url' => \yii\helpers\Url::to(['/admin-user/select2-search']),
                            'dataType' => 'json',
                            'data' => new JsExpression('function(params) { return {q:params.term}; }')
                        ],
                        'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                        'templateResult' => new JsExpression('function (user) { return user.text; }'),
                        'templateSelection' => new JsExpression('function (user) { return user.text; }'),
                    ],
                ],
          'headerOptions'=>['class'=>'kv-sticky-column'],
          'contentOptions'=>['class'=>'kv-sticky-column', 'style'=>'width: 10%;'],
      ],
      [
          'attribute' => 'ip',
          'vAlign'=>'middle',
          'headerOptions'=>['class'=>'kv-sticky-column'],
          'contentOptions'=>['class'=>'kv-sticky-column', 'style'=>'width: 15%;'],
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
