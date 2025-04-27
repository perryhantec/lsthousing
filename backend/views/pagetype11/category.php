<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;
use kartik\grid\GridView;
use kartik\editable\Editable;


$this->title = $searchModel->menu->allLanguageName. ' - ' .Yii::t('app', 'Category');

$this->params['breadcrumbs'][] = ['label' => $searchModel->menu->allLanguageName, 'url' => ['index','id'=>$searchModel->MID]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Category');
?>

<p>
<?= Html::a(Yii::t('app', "Create Category"),['category_create', 'id' => $searchModel->MID],
      ['class' => 'btn btn-success']);
            ?>
&nbsp;


</p>

<?php Pjax::begin(['id'=>'pagetype4-category-pjax']); ?>

<?php

$gridColumns = [];

$attrs_name = Yii::$app->config->getAllLanguageAttributes('name');
foreach ($attrs_name as $attr_name)
    $gridColumns[] =
        [
            'class' => 'kartik\grid\EditableColumn',
            'attribute' => $attr_name,
            'vAlign'=>'middle',
            'readonly' => true,
            'headerOptions'=>['class'=>'kv-sticky-column', 'style'=>('width: '.(90/sizeof($attrs_name)).'%;')],
            'contentOptions'=>['class'=>'kv-sticky-column'],
        ];

$gridColumns[] = [
      'class' => 'backend\components\ActionColumn',
      'template' =>'{category_update} {category_delete}',
      'contentOptions' => ['style'=>'width: 10%;'],
    ];

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
<?php Pjax::end(); ?></div>
