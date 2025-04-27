<?php
use common\widgets\Alert;
use yii\helpers\Html;
use yii\widgets\Pjax;
use kartik\grid\GridView;
use kartik\editable\Editable;
use common\models\Definitions;
use common\models\User;
use kartik\widgets\DatePicker;

$this->title = '最新未閱讀住戶上載交租文件一覽';

?>
<?= Alert::widget() ?>
<div class="users-index">
    <?php Pjax::begin(['id'=>'rental-payment-list-pjax']); ?>

    <?php
    $gridColumns =
    [
        [
          'attribute' => 'date',
          'label' => '新增日期',
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
          'attribute' => 'is_read',
          'vAlign'=>'middle',
          'filter' => Definitions::getIsRead(),
          'headerOptions'=>['class'=>'kv-sticky-column'],
          'contentOptions'=>['class'=>'kv-sticky-column', 'style'=>'width: 7%;'],
          'value' => function($model){
              return Definitions::getIsRead($model->is_read);
          },
        ],
        [
          'attribute' => 'appl_no',
          'vAlign'=>'middle',
          'headerOptions'=>['class'=>'kv-sticky-column'],
          'contentOptions'=>['class'=>'kv-sticky-column', 'style'=>'width: 10%;'],
          'value' => function($model){
              return ($model->user->application->appl_no) ?: '';
          },
        ],
        [
          'attribute' => 'project',
          'filter' => Definitions::getProjectName(),
          'vAlign'=>'middle',
          'headerOptions'=>['class'=>'kv-sticky-column'],
          'contentOptions'=>['class'=>'kv-sticky-column', 'style'=>'width: 18%;'],
          'value' => function($model){
              return Definitions::getProjectName($model->user->application->project);
          },
        ],
        [
          'attribute' => 'room_no',
          'vAlign'=>'middle',
          'headerOptions'=>['class'=>'kv-sticky-column'],
          'contentOptions'=>['class'=>'kv-sticky-column', 'style'=>'width: 8%;'],
          'value' => function($model){
              return ($model->user->application->room_no) ?: '';
          },
        ],
        [
          'attribute' => 'chi_name',
          'vAlign'=>'middle',
          'headerOptions'=>['class'=>'kv-sticky-column'],
          'contentOptions'=>['class'=>'kv-sticky-column', 'style'=>'width: 10%;'],
          'value' => function($model){
              return ($model->user->application->chi_name) ?: '';
          },
        ],
        [
          'attribute' => 'eng_name',
          'vAlign'=>'middle',
          'headerOptions'=>['class'=>'kv-sticky-column'],
          'contentOptions'=>['class'=>'kv-sticky-column', 'style'=>'width: 10%;'],
          'value' => function($model){
              return ($model->user->application->eng_name) ?: '';
          },
        ],
        [
          'attribute' => 'mobile',
          'vAlign'=>'middle',
          'headerOptions'=>['class'=>'kv-sticky-column'],
          'contentOptions'=>['class'=>'kv-sticky-column', 'style'=>'width: 10%;'],
          'value' => function($model){
            // return ($model->user->application->mobile) ?: '';
            return '';
          },
        ],
        [
          'attribute' => 'payment_year',
          'vAlign'=>'middle',
          'headerOptions'=>['class'=>'kv-sticky-column'],
          'contentOptions'=>['class'=>'kv-sticky-column', 'style'=>'width: 7%;'],
        ],
        [
          'attribute' => 'payment_month',
          'vAlign'=>'middle',
          'headerOptions'=>['class'=>'kv-sticky-column'],
          'contentOptions'=>['class'=>'kv-sticky-column', 'style'=>'width: 7%;'],
        ],
        // [
        //   'attribute' => 'user_appl_status',
        //   'vAlign'=>'middle',
        //   'filter' => Definitions::getUserApplicationStatus(),
        //   'headerOptions'=>['class'=>'kv-sticky-column'],
        //   'contentOptions'=>['class'=>'kv-sticky-column', 'style'=>'width: 10%;'],
        //   'value' => function($model){
        //     return Definitions::getUserApplicationStatus($model->user->user_appl_status);
        //   },
        // ],
        [
          'attribute' => 'files',
          'vAlign'=>'middle',
          'format' => 'raw',
          'headerOptions'=>['class'=>'kv-sticky-column'],
          'contentOptions'=>['class'=>'kv-sticky-column', 'style'=>'width: 10%;'],
          'value' => function($model){
            $files = json_decode($model->files, true);
            $data = '';
            $i = 1;
            if (count($files) > 0) {
              foreach ($files as $_file_name => $_file_description) {
                $url = $model->fileDisplayPath.$_file_name;
                $data .= $i++.'. '.Html::a($_file_description, $url, ['target'=>'_blank', 'onclick' => 'reloadPage(event,"'.$url.'");'])."\n";
              }
            }

            return $data;
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
          'template'=> '{read} {rental-payment}',
          'contentOptions'=>['style'=>['width'=>'10%','white-space' => 'nowrap']],
          'buttons' => [
            'read' => function($url, $model, $key) {
              return Html::a('已閱讀', $url, ['class' => 'btn btn-xs btn-success']);
            },
            'rental-payment' => function($url, $model, $key) {
              $url = str_replace('/admin/site','/admin',$url);
              $url = str_replace('id='.$model->id,'id='.$model->user_id,$url);
  
              return Html::a('住戶上載交租文件', $url, ['class' => 'btn btn-xs btn-primary']);
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

  </div>
  <script>
  function reloadPage(e, url) {
    e.preventDefault();
    // prevent render wrong view, i.e. application/index  
    window.open(url);
  }
</script>
