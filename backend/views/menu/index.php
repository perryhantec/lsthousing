<?php

use yii\helpers\Html;
use common\models\Definitions;
use yii\widgets\Pjax;
use kartik\grid\GridView;
use kartik\editable\Editable;
use backend\components\AccessRule;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\MenuCreationDataProvider */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Menu');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="menu-creation-index">

  <p>
    <?= Html::a(Yii::t('app',"Create"),['menu/create'],
          ['class' => 'btn btn-success']);
                ?>
    &nbsp;
<?php if (AccessRule::checkRole(['page.allpages'])) { ?>
    <?= Html::a(Yii::t('app',"Reorder"),['menu/reorder'],
          ['class' => 'popupModal btn btn-default']);
    ?>
    &nbsp;
<?php } ?>
<?php if (AccessRule::checkRole(['page.home'])) { ?>
    <?= Html::a(Yii::t('app',"Home Reorder"),['menu/home-reorder'],
          ['class' => 'popupModal btn btn-default']);
    ?>
<?php } ?>
    &nbsp;
  </p>

  <?php Pjax::begin(['id'=>'menu-pjax']); ?>

  <?php

$gridColumns =
    [
/*
      [
        'class' => 'kartik\grid\SerialColumn',
        'contentOptions'=>['style'=>'width: 5%;'],
      ],
*/
      [
        'class' => 'kartik\grid\EditableColumn',
          'attribute' => 'MID',
          'vAlign'=>'middle',
          'readonly' => true,
            'format' => 'raw',
          'filter' => Definitions::getParentMenuList(),
          'value' => function($model){
                    return ($model->MID!=NULL)? strip_tags($model->menu->name):'';
          },
          'headerOptions'=>['class'=>'kv-sticky-column', 'style'=>'width: 15%;'],
          'contentOptions'=>['class'=>'kv-sticky-column'],
          'editableOptions'=> [
              'inputType' => Editable::INPUT_DROPDOWN_LIST,
              'data' => Definitions::getParentMenuList(),
              'formOptions' => [
                  'action' => ['menu/edit_grid']
              ]
          ]
      ]
    ];

$attr_names = Yii::$app->config->getAllLanguageAttributes('name');
foreach ($attr_names as $attr_name)
    $gridColumns[] =
          [
            'class' => 'kartik\grid\EditableColumn',
            'attribute' => $attr_name,
            'vAlign'=>'middle',
            'readonly' => true,
//             'format' => 'html',
            'headerOptions'=>['class'=>'kv-sticky-column', 'style'=>'width: '.(45/sizeof($attr_names)).'%;'],
            'contentOptions'=>['class'=>'kv-sticky-column'],
            'editableOptions'=> [
                'size'=>'md',
                'formOptions' => [
                    'action' => ['menu/edit_grid']
                ]
            ]
          ];

$gridColumns = array_merge($gridColumns, [
      [
        'class' => 'kartik\grid\EditableColumn',
        'attribute' => 'page_type',
        'vAlign'=>'middle',
        'readonly' => true,
        'format' => 'raw',
        'filter' => Definitions::getPageType(),
        'value' => function($model){
                  return Definitions::getPageType($model->page_type);
        },
        'headerOptions'=>['class'=>'kv-sticky-column', 'style'=>'width: 10%;'],
        'contentOptions'=>['class'=>'kv-sticky-column'],
        'editableOptions'=> [
            'inputType' => Editable::INPUT_DROPDOWN_LIST,
            'data' => Definitions::getPageType(),
            'formOptions' => [
                'action' => ['menu/edit_grid']
            ]
        ]
      ],
      [
        'class' => 'kartik\grid\EditableColumn',
        'attribute' => 'status',
        'header'=>Yii::t('app','Show In Menu'),
        'vAlign'=>'middle',
        'readonly' => true,
        'format' => 'raw',
        'filter' => Definitions::getBooleanDescription(),
        'value' => function($model) {
            return Definitions::getBooleanDescription($model->status);
/*
          $value = $model->status;

          return Html::checkBox($model->status, $model['status'],
            ['onchange'=>"js:
                        $.ajax({
                          url: '". \Yii::$app->getUrlManager()->createUrl('menu/updatestatus?id='.$model->id) ."',
                          success: function (data) {
                              $('#menu-pjax').load(document.URL +  ' #menu-pjax');
                            }
                        });"
          ]);
*/
        },
        'headerOptions'=>['class'=>'kv-sticky-column', 'nowrap'=> true, 'style'=>'width: 5%;'],
        'contentOptions'=>['class'=>'kv-sticky-column'],
        'editableOptions'=> [

          ],
      ],
      [
        'class' => 'kartik\grid\EditableColumn',
        'header'=>Yii::t('app','Reorder'),
        'format' => 'raw',
        'readonly' => true,
        'value'=> function($model){
                    return sizeof($model->subMenu) > 0 ?
                     Html::a(Yii::t('app',"Reorder"),['menu/reorder','id'=>$model->id],
                          ['class' => 'popupModal btn btn-default btn-xs']):"";
                },
        'headerOptions'=>['class'=>'kv-sticky-column', 'style'=>'width: 5%;'],
        'contentOptions'=>['class'=>'kv-sticky-column'],
        'editableOptions'=> [
        ],

      ],
      [
        'class' => 'backend\components\ActionColumn',
        'template'=>'{update}',
        'width' => '10%',
        'contentOptions'=>['style'=>'width: 10%;', 'nowrap' => true],
/*
        'buttons' => [
          'update' => function ($url, $model, $key) {
                return  Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, ['title' => Yii::t('app', 'Update'),
                  ]) ;
            },
          'delete' => function($url, $model) {
            return Html::a('<span class="glyphicon glyphicon-trash"></span>', ['delete', 'id' => $model['id']], [
                    'title' => Yii::t('app', 'Delete'), 'data-confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),'data-method' => 'post']);
            },

          ],
*/
      ],
  ]);

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
