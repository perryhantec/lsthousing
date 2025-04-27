<?php

/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;
use common\models\Config;
use common\models\Definitions;

$model_general = common\models\General::findOne(1);

$this->title = '上載文件 - 總覽';

// Yii::$app->params['page_header_title'] = Yii::t('app', 'LST Shop');
// Yii::$app->params['page_header_img'] = '/images/page_header_img-shop.jpg';

// Yii::$app->params['breadcrumbs'][] = ['label' => Yii::t('app', 'LST Shop'), 'url' => ['/shop']];
Yii::$app->params['breadcrumbs'][] = Yii::t('app', "My Account");
Yii::$app->params['breadcrumbs'][] = ['label' => '我的申請 - 總覽', 'url' => ['application']];
Yii::$app->params['breadcrumbs'][] = '上載文件 - 總覽';

$this->registerJs(<<<JS
JS
);

?>
<?= $this->render('../layouts/_user_header') ?>
<?= Alert::widget() ?>
    <div class="page-my">
        <div class="content">
            <div class="">
                <table class="table">
                    <thead>
                        <tr>
                            <th>日期</th>
                            <th>申請編號</th>
                            <th>參考編號</th>
                            <th>狀態</th>
                            <th>動作</th>
                        </tr>
                    </thead>
                    <tbody>
                <?php 
                    if ($appl_model->application_status >= $appl_model::APPL_STATUS_UPLOAD_FILES && $appl_model->application_status <= $appl_model::APPL_STATUS_UPLOAD_FILES_AGAIN && count($model) > 0) {
                        foreach ($model as $req) {
                ?>
                        <tr>
                            <td><?= date("Y-m-d", strtotime($req->created_at)) ?></td>
                            <td><?= $req->application->appl_no ?></td>
                            <td><?= $req->ref_code ?></td>
                            <td><?= Definitions::getAppStatus($req->app_status) ?></td>
                            <td><?= Html::a('按此提交', ['upload-detail', 'id' => $req->id]) ?></td>
                        </tr>
                <?php
                        }
                    } else {
                ?>
                        <tr>
                            <td colspan="5"><em>沒有資料</em></td>
                        </tr>
                <?php
                    }
                ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
