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
$this->title = Yii::t('app', '{0}', ['要求上載文件 - 檢視']);

$this->params['breadcrumbs'][] = ['label' => '申請表 (請先選擇申請)', 'url' => ['/application/request-file-list']];
$this->params['breadcrumbs'][] = ['label' => '要求上載文件 ('.$model->application->appl_no.')', 'url' => ['index', 'id' => $model->application_id]];

// $this->params['breadcrumbs'][] = ['label' => '要求上載文件', 'url' => ['index']];
$this->params['breadcrumbs'][] = '檢視';
// $this->params['breadcrumbs'][] = Definitions::getApplicationStatus($model->application_status);
?>
<?= \newerton\fancybox3\FancyBox::widget([
		    'target' => '.fancybox',
		    'config' => []
		]); ?>
<div class="order-view">
<?php if (true) { ?>
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
                            'ref_code',
                            [
                                'attribute' => 'appl_no',
                                'value' => function($model){ return $model->application->appl_no; }
                            ],
                            [
                                'attribute' => 'app_status',
                                'value' => function($model){ return Definitions::getAppStatus($model->app_status); }
                            ],
                            'created_at',
                            [
                                'attribute' => 'request',
                                'format' => 'html',
                                'value' => function($model) {
                                    $part7s = Definitions::getPart7ContentWithTitle();
                                    $requests = json_decode($model->request);

                                    $html = '';
                                    foreach ($part7s as $title => $subcontents) {
                                        $html .= '<h3><strong>'.$title.'</strong></h3>';
                                        foreach ($subcontents as $subtitle => $items) {
                                            $html .= '<h4 style="margin-left:15px;"><u>'.$subtitle.'</u></h4>';
                                            foreach ($items as $i => $label) {
                                                if (in_array($i, $requests)) {
                                                    $style = 'color:green;';
                                                    $checked = '<i class="fa fa-check-square"></i>';
                                                } else {
                                                    $style = 'color:#aaa;';
                                                    $checked = '<i class="fa fa-square-o"></i>';
                                                }
                                                $html .= 
                                                '<div style="margin-left:30px;'.$style.'">
                                                    '.$checked.'
                                                    <label>'.$label.'</label>
                                                </div>';
                                            }
                                        }
                                    }

                                    return $html;
                                }
                            ],
                            [
                                'attribute' => 'remarks',
                                'format' => 'html',
                            ],
                        ],
                    ]) ?>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
</div>