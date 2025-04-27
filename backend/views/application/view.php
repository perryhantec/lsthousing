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

// $this->title = Yii::t('app', '{0}: {1}', ['申請表', Definitions::getApplicationStatus($model->application_status)]);
$this->title = Yii::t('app', '{0}', ['申請表']);
$this->params['breadcrumbs'][] = ['label' => '申請表', 'url' => ['index']];
$this->params['breadcrumbs'][] = '檢視';

// $this->params['breadcrumbs'][] = Definitions::getApplicationStatus($model->application_status);

?>
<?= \newerton\fancybox3\FancyBox::widget([
		    'target' => '.fancybox',
		    'config' => []
		]); ?>
<div class="order-view">

    <div class="row">
        <div class="col-md-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">申請人登記資料</h3>
                    <div class="box-tools pull-right">
                        <?=  false && $model->id != Yii::$app->user->identity->id ? Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-sm btn-primary pull-right']) : '' ?>
                    </div>
                </div>
                <div class="box-body">
                    <?= DetailView::widget([
                        'model' => $model,
                        'template' => '<tr><th style="width: 20%; text-align: right; vertical-align: top;"{captionOptions}>{label}</th><td{contentOptions}>{value}</td></tr>',
                        'attributes' => [
                            [
                                'attribute' => 'chi_name',
                                'value' => function($model) { return $model->user->chi_name ?: '-'; }
                            ],
                            [
                                'attribute' => 'eng_name',
                                'value' => function($model) { return $model->user->eng_name ?: '-'; }
                            ],
                            [
                                'attribute' => 'user_mobile',
                                'value' => function($model) { return $model->user->mobile ?: '-'; }
                            ],
                            [
                                'attribute' => 'email',
                                'value' => function($model) { return $model->user->email ?: '-'; }
                            ],
                            [
                                'attribute' => 'app_no',
                                'value' => function($model) { return $model->user->app_no ?: '-'; }
                            ],
/*
                            [
                                'attribute' => 'user_appl_status',
                                'value' => Definitions::getUserApplicationStatus($model->user->user_appl_status),
                            ],
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
        </div>
        <div class="col-md-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">申請資料</h3>
                    <div class="box-tools pull-right">
                        <?=  Html::a('更改狀態', ['application/update', 'id' => $model->id], ['class' => 'btn btn-sm btn-warning pull-right']) ?>
                        <?=  Html::a('評分詳細', ['application-mark/update', 'id' => isset($model->applicationMark->id) ? $model->applicationMark->id : ''], ['class' => 'btn btn-sm btn-primary pull-right','style'=>'margin-right:5px;']) ?>
                    </div>
                </div>
                <div class="box-body">
                    <?= DetailView::widget([
                        'model' => $model,
                        'template' => '<tr><th style="width: 20%; text-align: right; vertical-align: top;"{captionOptions}>{label}</th><td{contentOptions}>{value}</td></tr>',
                        'attributes' => [
                            'appl_no',
                            [
                                'attribute' => 'application_status',
                                'value' => function($model) { return Definitions::getApplicationStatus($model->application_status); }
                            ],
                            [
                                'attribute' => 'application_mark',
                                'value' => function($model) { return isset($model->applicationMark->total) ? $model->applicationMark->total : ''; },
                            ],
                        ],
                    ]) ?>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">第一部份 申請人資料</h3>
                    <div class="box-tools pull-right">
                        <?=  false && $model->id != Yii::$app->user->identity->id ? Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-sm btn-primary pull-right']) : '' ?>
                    </div>
                </div>
                <div class="box-body">
                    <?= DetailView::widget([
                        'model' => $model,
                        'template' => '<tr><th style="width: 20%; text-align: right; vertical-align: top;"{captionOptions}>{label}</th><td{contentOptions}>{value}</td></tr>',
                        'attributes' => [
                            [
                                'attribute' => 'priority_1',
                                'value' => function($model) { return Definitions::getProjectName($model->priority_1); }
                            ],
                            [
                                'attribute' => 'priority_2',
                                'value' => function($model) { return $model->priority_2 ? Definitions::getProjectName($model->priority_2) : '-'; }
                            ],
                            [
                                'attribute' => 'priority_3',
                                'value' => function($model) { return $model->priority_3 ? Definitions::getProjectName($model->priority_3) : '-'; }
                            ],
                            'chi_name',
                            'eng_name',
                            [
                                'attribute' => 'phone',
                                'value' => function($model) { return $model->phone ?: '-'; }
                            ],
                            'mobile',
                            'address',
                            [
                                'attribute' => 'area',
                                'value' => function($model) { return $model->area.' 平方呎'; }
                            ],
                            'email',
                            [
                                'attribute' => 'house_type',
                                'value' => function($model) { return Definitions::getHouseType($model->house_type); }
                            ],
                            [
                                'attribute' => 'house_type_other',
                                'value' => function($model) { return $model->house_type_other ?: '-'; }
                            ],
                            [
                                'attribute' => 'private_type',
                                'value' => function($model) { return Definitions::getPrivateType($model->private_type); }
                            ],
                            [
                                'attribute' => 'together_type',
                                'value' => function($model) { return Definitions::getTogetherType($model->together_type); }
                            ],
                            [
                                'attribute' => 'together_type_other',
                                'value' => function($model) { return $model->together_type_other ?: '-'; }
                            ],
                            [
                                'attribute' => 'live_rent',
                                'value' => function($model) { return '港幣 $'.$model->live_rent; }
                            ],
                            // [
                            //     'attribute' => 'live_year',
                            //     'value' => function($model) { return $model->live_year.' 年'; }
                            // ],
                            [
                                'attribute' => 'live_year',
                                'value' => function($model) { return Definitions::getLiveYear($model->live_year); }
                            ],
                            [
                                'attribute' => 'live_month',
                                'value' => function($model) { return Definitions::getLiveMonth($model->live_month); }
                            ],
                            [
                                'attribute' => 'family_member',
                                'value' => function($model) { return $model->family_member.' 人'; }
                            ],
                            [
                                'attribute' => 'prh',
                                'value' => function($model) { return Definitions::getPrh($model->prh); }
                            ],
                            'prh_no',
                            [
                                'attribute' => 'prh_location',
                                'value' => function($model) { return Definitions::getPrhLocation($model->prh_location); }
                            ],
                            [
                                'attribute' => 'apply_prh_year',
                                'value' => function($model) { return $model->apply_prh_year.' 年'; }
                            ],
                            [
                                'attribute' => 'apply_prh_month',
                                'value' => function($model) { return $model->apply_prh_month.' 月'; }
                            ],
                            [
                                'attribute' => 'apply_prh_day',
                                'value' => function($model) { return $model->apply_prh_day.' 日'; }
                            ],
                        ],
                    ]) ?>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">第二部份 家庭成員資料 及 第三部份 入息及資產淨值</h3>
                    <div class="box-tools pull-right">
                        <?=  false && $model->id != Yii::$app->user->identity->id ? Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-sm btn-primary pull-right']) : '' ?>
                    </div>
                </div>
                <div class="box-body">
                    <h4>申請人</h4>
                    <?= DetailView::widget([
                        'model' => $model,
                        'template' => '<tr><th style="width: 20%; text-align: right; vertical-align: top;"{captionOptions}>{label}</th><td{contentOptions}>{value}</td></tr>',
                        'attributes' => [
                            [
                                'attribute' => 'app_chi_name',
                                'value' => '同上'
                            ],
                            [
                                'attribute' => 'app_eng_name',
                                'value' => '同上'
                            ],
                            [
                                'attribute' => 'app_gender',
                                'value' => function($model) { return Definitions::getGender($model->app_gender); }
                            ],
                            'app_born_date',
                            // [
                            //     'attribute' => 'app_born_type',
                            //     'value' => function($model) { return $model->app_born_type ? Definitions::getBornType($model->app_born_type) : '-'; }
                            // ],
                            [
                                'attribute' => 'app_id_type',
                                'value' => function($model) { return Definitions::getIdType($model->app_id_type); }
                            ],
                            'app_id_no',
                            [
                                'attribute' => 'app_relationship',
                                'value' => '不適用'
                            ],
                            [
                                'attribute' => 'app_marriage_status',
                                'value' => function($model) { return Definitions::getMarriageStatus($model->app_marriage_status); }
                            ],
                            [
                                'attribute' => 'app_chronic_patient',
                                'value' => function($model) { return $model->app_chronic_patient ?: '-'; }
                            ],
                            [
                                'attribute' => 'app_special_study',
                                'value' => '不適用'
                            ],
                            [
                                'attribute' => 'app_working_status',
                                'value' => function($model) { return Definitions::getWorkingStatus($model->app_working_status); }
                            ],
                            [
                                'attribute' => 'app_career',
                                'value' => function($model) { return $model->app_career ?: '-'; }
                            ],
                            [
                                'attribute' => 'app_income',
                                'value' => function($model) { return '$'.$model->app_income; }
                            ],
                            [
                                'attribute' => 'app_funding_type',
                                'format' => 'raw',
                                'value' => function($model) {
                                    $html = '';
                                    if (count($model->app_funding_type) > 0) {
                                        foreach ($model->app_funding_type as $app_funding_type) {
                                            $html .= '<div>'.Definitions::getFundingType($app_funding_type).'</div>';
                                        }
                                    }
                                    
                                    return $html ? $html : '-';
                                }
                            ],
                            [
                                'attribute' => 'app_funding_value',
                                'value' => function($model) { return '$'.$model->app_funding_value; }
                            ],
                            [
                                'attribute' => 'app_asset',
                                'value' => function($model) { return Definitions::getAsset($model->app_asset); }
                            ],
                            [
                                'attribute' => 'app_asset_type',
                                'value' => function($model) { return $model->app_asset_type ?: '-'; }
                            ],
                            [
                                'attribute' => 'app_asset_value',
                                'value' => function($model) { return '$'.$model->app_asset_value; }
                            ],
                            [
                                'attribute' => 'app_deposit',
                                'value' => function($model) { return '$'.$model->app_deposit; }
                            ],
                        ],
                    ]) ?>
                    <hr />
                    <h4>家庭成員 1 <button type="button" data-toggle="collapse" data-target="#m1" onclick='toggleIcon(this);'><i class="fa fa-plus"></i></button></h4>
                    <div id="m1" class="collapse">
                        <?= DetailView::widget([
                            'model' => $model,
                            'template' => '<tr><th style="width: 20%; text-align: right; vertical-align: top;"{captionOptions}>{label}</th><td{contentOptions}>{value}</td></tr>',
                            'attributes' => [
                                'm1_chi_name',
                                'm1_eng_name',
                                [
                                    'attribute' => 'm1_gender',
                                    'value' => function($model) { return Definitions::getGender($model->m1_gender); }
                                ],
                                'm1_born_date',
                                // [
                                //     'attribute' => 'm1_born_type',
                                //     'value' => function($model) { return $model->m1_born_type ? Definitions::getBornType($model->m1_born_type) : '-'; }
                                // ],
                                [
                                    'attribute' => 'm1_id_type',
                                    'value' => function($model) { return Definitions::getIdType($model->m1_id_type); }
                                ],
                                'm1_id_no',
                                'm1_relationship',
                                [
                                    'attribute' => 'm1_marriage_status',
                                    'value' => function($model) { return Definitions::getMarriageStatus($model->m1_marriage_status); }
                                ],
                                [
                                    'attribute' => 'm1_chronic_patient',
                                    'value' => function($model) { return $model->m1_chronic_patient ?: '-'; }
                                ],
                                [
                                    'attribute' => 'm1_special_study',
                                    'value' => function($model) { return $model->m1_special_study === 1 ? '是' : '否'; }
                                ],
                                [
                                    'attribute' => 'm1_working_status',
                                    'value' => function($model) { return Definitions::getWorkingStatus($model->m1_working_status); }
                                ],
                                [
                                    'attribute' => 'm1_career',
                                    'value' => function($model) { return $model->m1_career ?: '-'; }
                                ],
                                [
                                    'attribute' => 'm1_income',
                                    'value' => function($model) { return '$'.$model->m1_income; }
                                ],
                                [
                                    'attribute' => 'm1_funding_type',
                                    'format' => 'raw',
                                    'value' => function($model) {
                                        $html = '';
                                        if (count($model->m1_funding_type) > 0) {
                                            foreach ($model->m1_funding_type as $m1_funding_type) {
                                                $html .= '<div>'.Definitions::getFundingType($m1_funding_type).'</div>';
                                            }
                                        }
                                        
                                        return $html ? $html : '-';
                                    }
                                ],
                                [
                                    'attribute' => 'm1_funding_value',
                                    'value' => function($model) { return '$'.$model->m1_funding_value; }
                                ],
                                [
                                    'attribute' => 'm1_asset',
                                    'value' => function($model) { return Definitions::getAsset($model->m1_asset); }
                                ],
                                [
                                    'attribute' => 'm1_asset_type',
                                    'value' => function($model) { return $model->m1_asset_type ?: '-'; }
                                ],
                                [
                                    'attribute' => 'm1_asset_value',
                                    'value' => function($model) { return '$'.$model->m1_asset_value; }
                                ],
                                [
                                    'attribute' => 'm1_deposit',
                                    'value' => function($model) { return '$'.$model->m1_deposit; }
                                ],
                            ],
                        ]) ?>
                    </div>
                    <hr />
                    <h4>家庭成員 2 <button type="button" data-toggle="collapse" data-target="#m2" onclick='toggleIcon(this);'><i class="fa fa-plus"></i></button></h4>
                    <div id="m2" class="collapse">
                        <?= DetailView::widget([
                            'model' => $model,
                            'template' => '<tr><th style="width: 20%; text-align: right; vertical-align: top;"{captionOptions}>{label}</th><td{contentOptions}>{value}</td></tr>',
                            'attributes' => [
                                'm2_chi_name',
                                'm2_eng_name',
                                [
                                    'attribute' => 'm2_gender',
                                    'value' => function($model) { return Definitions::getGender($model->m2_gender); }
                                ],
                                'm2_born_date',
                                // [
                                //     'attribute' => 'm2_born_type',
                                //     'value' => function($model) { return $model->m2_born_type ? Definitions::getBornType($model->m2_born_type) : '-'; }
                                // ],
                                [
                                    'attribute' => 'm2_id_type',
                                    'value' => function($model) { return Definitions::getIdType($model->m2_id_type); }
                                ],
                                'm2_id_no',
                                'm2_relationship',
                                [
                                    'attribute' => 'm2_marriage_status',
                                    'value' => function($model) { return Definitions::getMarriageStatus($model->m2_marriage_status); }
                                ],
                                [
                                    'attribute' => 'm2_chronic_patient',
                                    'value' => function($model) { return $model->m2_chronic_patient ?: '-'; }
                                ],
                                [
                                    'attribute' => 'm2_special_study',
                                    'value' => function($model) { return $model->m2_special_study === 1 ? '是' : '否'; }
                                ],
                                [
                                    'attribute' => 'm2_working_status',
                                    'value' => function($model) { return Definitions::getWorkingStatus($model->m2_working_status); }
                                ],
                                [
                                    'attribute' => 'm2_career',
                                    'value' => function($model) { return $model->m2_career ?: '-'; }
                                ],
                                [
                                    'attribute' => 'm2_income',
                                    'value' => function($model) { return '$'.$model->m2_income; }
                                ],
                                [
                                    'attribute' => 'm2_funding_type',
                                    'format' => 'raw',
                                    'value' => function($model) {
                                        $html = '';
                                        if (count($model->m2_funding_type) > 0) {
                                            foreach ($model->m2_funding_type as $m2_funding_type) {
                                                $html .= '<div>'.Definitions::getFundingType($m2_funding_type).'</div>';
                                            }
                                        }
                                        
                                        return $html ? $html : '-';
                                    }
                                ],
                                [
                                    'attribute' => 'm2_funding_value',
                                    'value' => function($model) { return '$'.$model->m2_funding_value; }
                                ],
                                [
                                    'attribute' => 'm2_asset',
                                    'value' => function($model) { return Definitions::getAsset($model->m2_asset); }
                                ],
                                [
                                    'attribute' => 'm2_asset_type',
                                    'value' => function($model) { return $model->m2_asset_type ?: '-'; }
                                ],
                                [
                                    'attribute' => 'm2_asset_value',
                                    'value' => function($model) { return '$'.$model->m2_asset_value; }
                                ],
                                [
                                    'attribute' => 'm2_deposit',
                                    'value' => function($model) { return '$'.$model->m2_deposit; }
                                ],
                            ],
                        ]) ?>
                    </div>
                    <hr />
                    <h4>家庭成員 3 <button type="button" data-toggle="collapse" data-target="#m3" onclick='toggleIcon(this);'><i class="fa fa-plus"></i></button></h4>
                    <div id="m3" class="collapse">
                        <?= DetailView::widget([
                            'model' => $model,
                            'template' => '<tr><th style="width: 20%; text-align: right; vertical-align: top;"{captionOptions}>{label}</th><td{contentOptions}>{value}</td></tr>',
                            'attributes' => [
                                'm3_chi_name',
                                'm3_eng_name',
                                [
                                    'attribute' => 'm3_gender',
                                    'value' => function($model) { return Definitions::getGender($model->m3_gender); }
                                ],
                                'm3_born_date',
                                // [
                                //     'attribute' => 'm3_born_type',
                                //     'value' => function($model) { return $model->m3_born_type ? Definitions::getBornType($model->m3_born_type) : '-'; }
                                // ],
                                [
                                    'attribute' => 'm3_id_type',
                                    'value' => function($model) { return Definitions::getIdType($model->m3_id_type); }
                                ],
                                'm3_id_no',
                                'm3_relationship',
                                [
                                    'attribute' => 'm3_marriage_status',
                                    'value' => function($model) { return Definitions::getMarriageStatus($model->m3_marriage_status); }
                                ],
                                [
                                    'attribute' => 'm3_chronic_patient',
                                    'value' => function($model) { return $model->m3_chronic_patient ?: '-'; }
                                ],
                                [
                                    'attribute' => 'm3_special_study',
                                    'value' => function($model) { return $model->m3_special_study === 1 ? '是' : '否'; }
                                ],
                                [
                                    'attribute' => 'm3_working_status',
                                    'value' => function($model) { return Definitions::getWorkingStatus($model->m3_working_status); }
                                ],
                                [
                                    'attribute' => 'm3_career',
                                    'value' => function($model) { return $model->m3_career ?: '-'; }
                                ],
                                [
                                    'attribute' => 'm3_income',
                                    'value' => function($model) { return '$'.$model->m3_income; }
                                ],
                                [
                                    'attribute' => 'm3_funding_type',
                                    'format' => 'raw',
                                    'value' => function($model) {
                                        $html = '';
                                        if (count($model->m3_funding_type) > 0) {
                                            foreach ($model->m3_funding_type as $m3_funding_type) {
                                                $html .= '<div>'.Definitions::getFundingType($m3_funding_type).'</div>';
                                            }
                                        }
                                        
                                        return $html ? $html : '-';
                                    }
                                ],
                                [
                                    'attribute' => 'm3_funding_value',
                                    'value' => function($model) { return '$'.$model->m3_funding_value; }
                                ],
                                [
                                    'attribute' => 'm3_asset',
                                    'value' => function($model) { return Definitions::getAsset($model->m3_asset); }
                                ],
                                [
                                    'attribute' => 'm3_asset_type',
                                    'value' => function($model) { return $model->m3_asset_type ?: '-'; }
                                ],
                                [
                                    'attribute' => 'm3_asset_value',
                                    'value' => function($model) { return '$'.$model->m3_asset_value; }
                                ],
                                [
                                    'attribute' => 'm3_deposit',
                                    'value' => function($model) { return '$'.$model->m3_deposit; }
                                ],
                            ],
                        ]) ?>
                    </div>
                    <hr />
                    <h4>家庭成員 4 <button type="button" data-toggle="collapse" data-target="#m4" onclick='toggleIcon(this);'><i class="fa fa-plus"></i></button></h4>
                    <div id="m4" class="collapse">
                        <?= DetailView::widget([
                            'model' => $model,
                            'template' => '<tr><th style="width: 20%; text-align: right; vertical-align: top;"{captionOptions}>{label}</th><td{contentOptions}>{value}</td></tr>',
                            'attributes' => [
                                'm4_chi_name',
                                'm4_eng_name',
                                [
                                    'attribute' => 'm4_gender',
                                    'value' => function($model) { return Definitions::getGender($model->m4_gender); }
                                ],
                                'm4_born_date',
                                // [
                                //     'attribute' => 'm4_born_type',
                                //     'value' => function($model) { return $model->m4_born_type ? Definitions::getBornType($model->m4_born_type) : '-'; }
                                // ],
                                [
                                    'attribute' => 'm4_id_type',
                                    'value' => function($model) { return Definitions::getIdType($model->m4_id_type); }
                                ],
                                'm4_id_no',
                                'm4_relationship',
                                [
                                    'attribute' => 'm4_marriage_status',
                                    'value' => function($model) { return Definitions::getMarriageStatus($model->m4_marriage_status); }
                                ],
                                [
                                    'attribute' => 'm4_chronic_patient',
                                    'value' => function($model) { return $model->m4_chronic_patient ?: '-'; }
                                ],
                                [
                                    'attribute' => 'm4_special_study',
                                    'value' => function($model) { return $model->m4_special_study === 1 ? '是' : '否'; }
                                ],
                                [
                                    'attribute' => 'm4_working_status',
                                    'value' => function($model) { return Definitions::getWorkingStatus($model->m4_working_status); }
                                ],
                                [
                                    'attribute' => 'm4_career',
                                    'value' => function($model) { return $model->m4_career ?: '-'; }
                                ],
                                [
                                    'attribute' => 'm4_income',
                                    'value' => function($model) { return '$'.$model->m4_income; }
                                ],
                                [
                                    'attribute' => 'm4_funding_type',
                                    'format' => 'raw',
                                    'value' => function($model) {
                                        $html = '';
                                        if (count($model->m4_funding_type) > 0) {
                                            foreach ($model->m4_funding_type as $m4_funding_type) {
                                                $html .= '<div>'.Definitions::getFundingType($m4_funding_type).'</div>';
                                            }
                                        }
                                        
                                        return $html ? $html : '-';
                                    }
                                ],
                                [
                                    'attribute' => 'm4_funding_value',
                                    'value' => function($model) { return '$'.$model->m4_funding_value; }
                                ],
                                [
                                    'attribute' => 'm4_asset',
                                    'value' => function($model) { return Definitions::getAsset($model->m4_asset); }
                                ],
                                [
                                    'attribute' => 'm4_asset_type',
                                    'value' => function($model) { return $model->m4_asset_type ?: '-'; }
                                ],
                                [
                                    'attribute' => 'm4_asset_value',
                                    'value' => function($model) { return '$'.$model->m4_asset_value; }
                                ],
                                [
                                    'attribute' => 'm4_deposit',
                                    'value' => function($model) { return '$'.$model->m4_deposit; }
                                ],
                            ],
                        ]) ?>
                    </div>
                    <hr />
                    <h4>家庭成員 5 <button type="button" data-toggle="collapse" data-target="#m5" onclick='toggleIcon(this);'><i class="fa fa-plus"></i></button></h4>
                    <div id="m5" class="collapse">
                        <?= DetailView::widget([
                            'model' => $model,
                            'template' => '<tr><th style="width: 20%; text-align: right; vertical-align: top;"{captionOptions}>{label}</th><td{contentOptions}>{value}</td></tr>',
                            'attributes' => [
                                'm5_chi_name',
                                'm5_eng_name',
                                [
                                    'attribute' => 'm5_gender',
                                    'value' => function($model) { return Definitions::getGender($model->m5_gender); }
                                ],
                                'm5_born_date',
                                // [
                                //     'attribute' => 'm5_born_type',
                                //     'value' => function($model) { return $model->m5_born_type ? Definitions::getBornType($model->m5_born_type) : '-'; }
                                // ],
                                [
                                    'attribute' => 'm5_id_type',
                                    'value' => function($model) { return Definitions::getIdType($model->m5_id_type); }
                                ],
                                'm5_id_no',
                                'm5_relationship',
                                [
                                    'attribute' => 'm5_marriage_status',
                                    'value' => function($model) { return Definitions::getMarriageStatus($model->m5_marriage_status); }
                                ],
                                [
                                    'attribute' => 'm5_chronic_patient',
                                    'value' => function($model) { return $model->m5_chronic_patient ?: '-'; }
                                ],
                                [
                                    'attribute' => 'm5_special_study',
                                    'value' => function($model) { return $model->m5_special_study === 1 ? '是' : '否'; }
                                ],
                                [
                                    'attribute' => 'm5_working_status',
                                    'value' => function($model) { return Definitions::getWorkingStatus($model->m5_working_status); }
                                ],
                                [
                                    'attribute' => 'm5_career',
                                    'value' => function($model) { return $model->m5_career ?: '-'; }
                                ],
                                [
                                    'attribute' => 'm5_income',
                                    'value' => function($model) { return '$'.$model->m5_income; }
                                ],
                                [
                                    'attribute' => 'm5_funding_type',
                                    'format' => 'raw',
                                    'value' => function($model) {
                                        $html = '';
                                        if (count($model->m5_funding_type) > 0) {
                                            foreach ($model->m5_funding_type as $m5_funding_type) {
                                                $html .= '<div>'.Definitions::getFundingType($m5_funding_type).'</div>';
                                            }
                                        }
                                        
                                        return $html ? $html : '-';
                                    }
                                ],
                                [
                                    'attribute' => 'm5_funding_value',
                                    'value' => function($model) { return '$'.$model->m5_funding_value; }
                                ],
                                [
                                    'attribute' => 'm5_asset',
                                    'value' => function($model) { return Definitions::getAsset($model->m5_asset); }
                                ],
                                [
                                    'attribute' => 'm5_asset_type',
                                    'value' => function($model) { return $model->m5_asset_type ?: '-'; }
                                ],
                                [
                                    'attribute' => 'm5_asset_value',
                                    'value' => function($model) { return '$'.$model->m5_asset_value; }
                                ],
                                [
                                    'attribute' => 'm5_deposit',
                                    'value' => function($model) { return '$'.$model->m5_deposit; }
                                ],
                            ],
                        ]) ?>
                    </div>
                    <hr />
                    <?= DetailView::widget([
                        'model' => $model,
                        'template' => '<tr><th style="width: 20%; text-align: right; vertical-align: top;"{captionOptions}>{label}</th><td{contentOptions}>{value}</td></tr>',
                        'attributes' => [
                            [
                                'attribute' => 'single_parents',
                                'value' => function($model) { return $model->single_parents === 1 ? '是' : '否'; }
                            ],
                            [
                                'attribute' => 'pregnant',
                                'value' => function($model) { return $model->pregnant === 1 ? '是' : '否'; }
                            ],
                            [
                                'attribute' => 'pregnant_period',
                                'value' => function($model) { return $model->pregnant_period ?: '-'; }
                            ],
                            [
                                'attribute' => 'total_income',
                                'value' => function($model) { return '$'.$model->total_income; }
                            ],
                            [
                                'attribute' => 'total_funding',
                                'value' => function($model) { return '$'.$model->total_funding; }
                            ],
                            [
                                'attribute' => 'total_asset',
                                'value' => function($model) { return '$'.$model->total_asset; }
                            ],
                        ],
                    ]) ?>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">第四部份 機構轉介</h3>
                    <div class="box-tools pull-right">
                        <?=  false && $model->id != Yii::$app->user->identity->id ? Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-sm btn-primary pull-right']) : '' ?>
                    </div>
                </div>
                <div class="box-body">
                    <?= DetailView::widget([
                        'model' => $model,
                        'template' => '<tr><th style="width: 20%; text-align: right; vertical-align: top;"{captionOptions}>{label}</th><td{contentOptions}>{value}</td></tr>',
                        'attributes' => [
                            'social_worker_name',
                            'social_worker_phone',
                            'social_worker_email',
                        ],
                    ]) ?>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function toggleIcon(ele) {
        let eleI = $(ele).find('i').first();
        if (eleI.hasClass('fa-plus')){
            eleI.removeClass('fa-plus').addClass('fa-minus');
        } else if (eleI.hasClass('fa-minus')){
            eleI.removeClass('fa-minus').addClass('fa-plus');
        } 
    }
</script>