<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use kartik\grid\GridView;
use kartik\editable\Editable;
use common\models\Definitions;
/* @var $this yii\web\View */
/* @var $searchModel app\models\UsersDataProvider */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Admin Users');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="admin-user-index">

    <p>
      <?= Html::a(Yii::t('app',"Create {modelClass}",['modelClass'=>Yii::t('app','Admin User')]),['create'],
            ['class' => 'btn btn-success']);
                  ?>
    </p>
    <?php Pjax::begin(['id'=>'admin-user-pjax']); ?>

    <?php
    $gridColumns =
    [
        [
          'attribute' => 'name',
          'vAlign'=>'middle',
          'headerOptions'=>['class'=>'kv-sticky-column'],
          'contentOptions'=>['class'=>'kv-sticky-column', 'style'=>'width: 20%;'],
        ],
        [
          'attribute' => 'email',
          'vAlign'=>'middle',
          'format' => 'email',
          'headerOptions'=>['class'=>'kv-sticky-column'],
          'contentOptions'=>['class'=>'kv-sticky-column', 'style'=>'width: 30%;'],
        ],
        [
            'attribute' => 'role',
            'vAlign'=>'middle',
            'filter' => Definitions::getAdminRole(false, Yii::$app->user->identity->role),
            'value' => function($model){
                      return Definitions::getAdminRole($model->role);
            },
            'headerOptions'=>['class'=>'kv-sticky-column'],
            'contentOptions'=>['class'=>'kv-sticky-column', 'style'=>'width: 15%;'],
        ],
        [
            'attribute' => 'adminGroup_id',
            'label' => Yii::t('app', 'Admin Group'),
            'vAlign'=>'middle',
            'format' => 'raw',
            'filter' => Definitions::getAdminGroup(),
            'value' => function($model){
                $array = [];
                foreach ($model->getAdminGroups()->orderBy(['name' => SORT_ASC, 'id' => SORT_DESC])->all() as $adminGroup) {
                    $array[] = $adminGroup->name;
                }
                return Html::ul($array);
            },
            'headerOptions'=>['class'=>'kv-sticky-column'],
            'contentOptions'=>['class'=>'kv-sticky-column', 'style'=>'width: 20%;'],
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
        'template'=> '{view}',
        'contentOptions'=>['style'=>['width'=>'5%','white-space' => 'nowrap']],
        'buttons' => [
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
