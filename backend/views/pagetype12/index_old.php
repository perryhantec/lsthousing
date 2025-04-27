<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;
use common\models\Definitions;
use common\models\PageType12;
use kartik\widgets\DatePicker;
use kartik\grid\GridView;
use kartik\editable\Editable;


$this->title = $searchModel->menu->allLanguageName;
?>

<p>
<?= Html::a(Yii::t('app', "Create"),['create', 'id' => $searchModel->MID],
      ['class' => 'btn btn-success',

            ]);
            ?>
&nbsp;
<?= $searchModel::HAS_CATEGORY ? Html::a(Yii::t('app', "Category"),['category', 'id' => $searchModel->MID],
      ['class' => 'btn btn-primary',]) : '' ?>
&nbsp;

</p>

<?php Pjax::begin(['id'=>'pagetype12-pjax']); ?>

<?php
$gridColumns =
[
    /*[
      'class' => 'kartik\grid\SerialColumn',
      'contentOptions'=>['style'=>'width: 5%;'],
    ],*/

    [
      'class' => 'kartik\grid\EditableColumn',
      'attribute' => 'display_at',
      'filter' => DatePicker::widget([
                      'model'=>$searchModel,
                      'attribute'=>'display_at',
                      'type' => DatePicker::TYPE_INPUT,
                      'pluginOptions' => [
                          'autoclose'=>true,
                          'format' => 'yyyy-mm-dd'
                      ]
                    ]),
      'vAlign'=>'middle',
      'readonly' => true,
      'headerOptions'=>['class'=>'kv-sticky-column', 'style'=>'width: 15%;'],
      'contentOptions'=>['class'=>'kv-sticky-column'],
      'editableOptions'=> ['formOptions' => ['action' => ['pagetype12/edit_grid']]]

    ],
/*
    [
      'class' => 'kartik\grid\EditableColumn',
      'attribute' => 'author',
      'vAlign'=>'middle',
      'readonly' => false,
      'headerOptions'=>['class'=>'kv-sticky-column'],
      'contentOptions'=>['class'=>'kv-sticky-column', 'style'=>'width: 10%;'],
      'editableOptions'=> ['formOptions' => ['action' => ['pagetype4/edit_grid']]]

    ],
*/
    // [
    //   'class' => 'kartik\grid\EditableColumn',
    //   'attribute' => 'category_id',
    //   'format' => 'raw',
    //   'filter' => Definitions::getPageType4Category(false, $searchModel->MID, Yii::$app->language),
    //   'value' => function($model){
    //     return Definitions::getPageType4Category($model->category_id, $model->MID, Yii::$app->language);
    //   },
    //   'vAlign'=>'middle',
    //   'readonly' => true,
    //   'headerOptions'=>['class'=>'kv-sticky-column', 'style'=>'width: 25%;'],
    //   'contentOptions'=>['class'=>'kv-sticky-column'],
    //   'editableOptions'=> [
    //     'inputType' => Editable::INPUT_DROPDOWN_LIST,
    //     'data' => Definitions::getPageType4Category(false, $searchModel->MID, Yii::$app->language),
    //     'formOptions' =>[
    //       'action' => [
    //         'pagetype4/edit_grid'
    //       ],
    //     ],
    //     ],
    //   'visible' => $searchModel::HAS_CATEGORY
    // ],
    [
      'class' => 'kartik\grid\EditableColumn',
      'attribute' => Yii::$app->config->getRequiredLanguageAttribute('title'),
      'vAlign'=>'middle',
      'readonly' => true,
      'headerOptions'=>['class'=>'kv-sticky-column', 'style'=>'width: 65%;'],
      'contentOptions'=>['class'=>'kv-sticky-column'],
      'editableOptions'=> [
        'size'=>'md',
        'inputType' => Editable::INPUT_TEXTAREA,
        'formOptions' => ['action' =>
          ['pagetype12/edit_grid']
        ]
      ]

    ],
    /*[
      'class' => 'kartik\grid\EditableColumn',
      'attribute' => 'summary',
      'vAlign'=>'middle',
      'readonly' => true,
      'headerOptions'=>['class'=>'kv-sticky-column'],
      'contentOptions'=>['class'=>'kv-sticky-column', 'style'=>'width: 10%;'],
      'editableOptions'=> ['formOptions' => ['action' => ['pagetype4/edit_grid']]]

    ],
    /*
    [
      'class' => 'kartik\grid\EditableColumn',
      'attribute' => 'content',
      'vAlign'=>'middle',
      'readonly' => true,
      'format' => 'raw',
      'value' => function($model){
        return mb_substr($model->content, 0, 200);
      },
      'headerOptions'=>['class'=>'kv-sticky-column'],
      'contentOptions'=>['class'=>'kv-sticky-column', 'style'=>'width: 40%;'],
      'editableOptions'=> ['formOptions' => ['action' => ['pagetype4/edit_grid']]]

    ],
    */
    [
      'attribute' => 'status',
      'vAlign'=>'middle',
      'filter' => Definitions::getStatus(),
      'value' => function($model){
          return Definitions::getStatus($model->status);
      },
      'width' => '10%',
      'headerOptions'=>['class'=>'kv-sticky-column'],
      'contentOptions'=>['class'=>'kv-sticky-column'],
    ],
    [
      'class' => 'backend\components\ActionColumn',
      'template'=>'{update} {enabled} {disabled} {delete}',
      'width' => '10%',
      'headerOptions'=>['style'=>'width: 10%;'],
/*
      'buttons' => [
        'update' => function ($url, $model, $key) {
              return $model->status != 0 ? Html::a('<span class="glyphicon glyphicon-pencil"></span>', ['update', 'id'=>$model->id], ['title' => Yii::t('app', 'Update'),
                ]) : '';
          },
        'delete' => function($url, $model) {
          return Html::a('<span class="glyphicon glyphicon-trash"></span>', ['delete', 'id' => $model['id']], [
                  'title' => Yii::t('app', 'Delete'), 'data-confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),'data-method' => 'post']);
          },

        ],
*/
        'visibleButtons' => [
            'enabled' => function ($model) { return $model->status == 0; },
            'disabled' => function ($model) { return $model->status != 0; },
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
        'pjax'=>false, // pjax is set to always true for this demo
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
<?php Pjax::end(); ?>