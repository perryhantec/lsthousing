<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\DetailView;
use common\models\Definitions;
// use common\models\UserDelivery;
use common\models\Order;
use kartik\grid\GridView;
use yii\data\ActiveDataProvider;
use backend\components\AccessRule;

/* @var $this yii\web\View */
/* @var $model common\models\Order */

$this->title = Yii::t('app', '{0}: {1}', [Yii::t('app', 'User'), $model->nameWithEmail]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->nameWithEmail;

?>
<?= \newerton\fancybox3\FancyBox::widget([
		    'target' => '.fancybox',
		    'config' => []
		]); ?>
<div class="order-view">

    <div class="row">
        <div class="col-md-6">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title"><?= Yii::t('app', 'Personal Information') ?></h3>
                    <div class="box-tools pull-right">
                        <?= $model->id != false && Yii::$app->user->identity->id ? Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-sm btn-primary pull-right']) : '' ?>
                    </div>
                </div>
                <div class="box-body">
                    <?= DetailView::widget([
                        'model' => $model,
                        'template' => '<tr><th style="width: 20%; text-align: right; vertical-align: top;"{captionOptions}>{label}</th><td{contentOptions}>{value}</td></tr>',
                        'attributes' => [
                            [
                                'attribute' => 'chi_name',
                            ],
                            'eng_name',
                            'app_no',
                            [
                                'attribute' => 'phone',
                                'value' => function($model) { return $model->phone ?: '-'; }
                            ],
                            'mobile',
                            [
                                'attribute' => 'email',
                                'value' => function($model) { return $model->email ?: '-'; }
                            ],
                            // [
                            //     'attribute' => 'user_appl_status',
                            //     'value' => Definitions::getUserApplicationStatus($model->user_appl_status),
                            // ],

/*
                            [
                                'attribute' => 'oAuth_user',
                                'label' => Yii::t('app', 'Login with facebook'),
                                'value' => Definitions::getBooleanDescription($model->oAuth_user),
                            ],
*/
                        ],
                    ]) ?>
                </div>
            </div>
            <br />
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title"><?= Yii::t('app', 'Login Information') ?></h3>
                    <div class="box-tools pull-right">
                        <?= false && $model->id != Yii::$app->user->identity->id ? Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-sm btn-primary pull-right']) : '' ?>
                    </div>
                </div>
                <div class="box-body">
                    <?= DetailView::widget([
                        'model' => $model,
                        'template' => '<tr><th style="width: 20%; text-align: right; vertical-align: top;"{captionOptions}>{label}</th><td{contentOptions}>{value}</td></tr>',
                        'attributes' => [
                            [
                                'attribute' => 'status',
                                'value' => Definitions::getStatus($model->status),
                            ],
                            [
                                'attribute' => 'role',
                                'value' => Definitions::getRole($model->role),
                            ],
/*
                            [
                                'attribute' => 'created_at',
                                'value' => function($model) {
                                    return (strtotime($model->created_at) > 1533052800) ? $model->created_at : '-'; // 1533052800 => strtotime("2018-08-01 00:00:00")
                                }
                            ],
*/
                            // 'last_login_at',
/*
                            [
                                'attribute' => 'lang',
                                'value' => Definitions::getLanguage($model->lang),
                            ],
*/
/*
                            [
                                'attribute' => 'optout_of_marketing',
                                'value' => function($model) {
                                    return Definitions::getBooleanDescription($model->optout_of_marketing);
                                }
                            ],
*/
                        ],
                    ]) ?>
                </div>
            </div>
        </div>
<?php if (false) { ?>
        <div class="col-md-6">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title"><?= Yii::t('app', 'Address Information') ?></h3>
                    <div class="box-tools pull-right">
                        <?= $model->id != Yii::$app->user->identity->id ? Html::a(Yii::t('app', 'Update'), ['update-address', 'id' => $model->id], ['class' => 'btn btn-sm btn-primary pull-right']) : '' ?>
                    </div>
                </div>
                <div class="box-body">
                    <?= DetailView::widget([
                        'model' => $model->address,
                        'template' => '<tr><th style="width: 20%; text-align: right; vertical-align: top;"{captionOptions}>{label}</th><td{contentOptions}>{value}</td></tr>',
                        'attributes' => [
                            'billing_name',
                            'billing_phone',
                            'billing_email',
                            [
                                'label' => Yii::t('app', 'Billing Address'),
                                'format' => 'raw',
                                'value' => function($view_model) {
                                    return Html::encode($view_model->billing_address1).(!empty($view_model->billing_address2) ? ("<br />".Html::encode($view_model->billing_address2)) : '')."<br />".Definitions::getDeliveryAddressDistrict($view_model->billing_address_district);
                                }
                            ],
                            'delivery_name',
                            'delivery_phone',
                            [
                                'label' => Yii::t('app', 'Shipping Address'),
                                'format' => 'raw',
                                'value' => function($view_model) {
                                    return Html::encode($view_model->delivery_address1).(!empty($view_model->delivery_address2) ? ("<br />".Html::encode($view_model->delivery_address2)) : '')."<br />".Definitions::getDeliveryAddressDistrict($view_model->delivery_address_district);
                                }
                            ],
                        ],
                    ]) ?>
                </div>
            </div>
        </div>
<?php } ?>
    </div>

<?php if (false && AccessRule::checkRole(['order'])) { ?>
    <br />
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title"><?= Yii::t('app', 'Order History') ?></h3>
            <div class="box-tools pull-right">
                <?= Html::a(Yii::t('app', 'Create'), ['/order/create', 'uid' => $model->id], ['class' => 'btn btn-sm btn-success pull-right']) ?>
            </div>
        </div>
        <div class="box-body">
           <?= GridView::widget([
                  'dataProvider' => new ActiveDataProvider([
                        'query' => $model->getOrders()->andWhere(['NOT', ['order_num' => null]]),
                        'sort'=> ['defaultOrder' => ['checkout_at' => SORT_DESC]],
                        'pagination' => [
                            'defaultPageSize' => 20,
                            'pageParam' => 'order-page',
                            'pageSizeParam' => 'order-pageSize'
                        ],
                    ]),
                  'persistResize' => true,
                  'responsiveWrap' => false,
                  'columns' => [
                      [
                          'attribute' => 'order_num',
                          'vAlign'=>'middle',
                          'format' => 'raw',
                          'value' => function($model) {
                                return Html::tag('code', '#'.$model->order_num, ['class' => 'order-num']);
                            },
                          'headerOptions'=>['class'=>'kv-sticky-column'],
                          'contentOptions'=>['class'=>'kv-sticky-column', 'style'=>'width: 10%;'],
                      ],
                      [
                          'attribute' => 'status',
                          'vAlign'=>'middle',
                          'value' => function($model){
                              return Definitions::getOrderStatus($model->status);
                          },
                          'headerOptions'=>['class'=>'kv-sticky-column'],
                          'contentOptions'=>['class'=>'kv-sticky-column', 'style'=>'width: 15%;'],
                      ],
                      [
                          'attribute' => 'total_qty',
                          'header' => Yii::t('app', 'Total Qty'),
                          'vAlign'=>'middle',
                          'headerOptions'=>['class'=>'kv-sticky-column'],
                          'contentOptions'=>['class'=>'kv-sticky-column', 'style'=>'width: 7%;'],
                      ],
                      [
                          'attribute' => 'total_amount',
                          'header' => Yii::t('app', 'Amount'),
                          'vAlign'=>'middle',
                          'value' => function($model){
                              return Yii::$app->formatter->asCurrency($model->total_amount);
                          },
                          'headerOptions'=>['class'=>'kv-sticky-column'],
                          'contentOptions'=>['class'=>'kv-sticky-column', 'style'=>'width: 8%;'],
                      ],
                      [
                          'attribute' => 'checkout_at',
                          'vAlign'=>'middle',
                          'headerOptions'=>['class'=>'kv-sticky-column'],
                          'contentOptions'=>['class'=>'kv-sticky-column', 'style'=>'width: 15%;'],
                      ],
                      [
                          'attribute' => 'delivery_method',
                          'vAlign'=>'middle',
                          'value' => function($model){
                              return Definitions::getOrderDeliveryMethod($model->delivery_method);
                          },
                          'headerOptions'=>['class'=>'kv-sticky-column'],
                          'contentOptions'=>['class'=>'kv-sticky-column', 'style'=>'width: 10%;'],
                      ],
                      [
                          'attribute' => 'payment_done',
                          'vAlign'=>'middle',
                          'value' => function($model){
                              return Definitions::getBooleanDescription($model->payment_done);
                          },
                          'headerOptions'=>['class'=>'kv-sticky-column'],
                          'contentOptions'=>['class'=>'kv-sticky-column', 'style'=>'width: 5%;'],
                      ],
                      [
                        'class' => 'backend\components\ActionColumn',
                        'template'=>'{view} {update-status}',
                        'width' => '10%',
                        'contentOptions'=>['style'=>['width'=>'10%','white-space' => 'nowrap']],
                        'buttons' => [
                                'view' => function ($url, $model, $key) {
                                    return Html::a(Yii::t('app', 'View'), ['/order/view', 'id' => $key], ['class' => 'btn btn-info btn-xs']);
                                },
                                'update-status' => function ($url, $model, $key) {
                                    return Html::a(Yii::t('app', 'Change Status'), ['/order/update-status', 'id' => $key, 'rb' => Url::current()], ['class' => 'popupModal btn btn-warning btn-xs']);
                                },
                            ],
                        'visibleButtons' => [
                                'update-status' => function ($model) { return $model->status >= $model::STATUS_ORDER_SUBMITED || $model->status == $model::STATUS_CANCELED; },
                            ]
                      ],
                    ]
              ]); ?>
        </div>
    </div>

<?php } ?>

</div>
