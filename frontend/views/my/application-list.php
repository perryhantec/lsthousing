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

$this->title = '我的申請 - 總覽';

// Yii::$app->params['page_header_title'] = Yii::t('app', 'LST Shop');
// Yii::$app->params['page_header_img'] = '/images/page_header_img-shop.jpg';

// Yii::$app->params['breadcrumbs'][] = ['label' => Yii::t('app', 'LST Shop'), 'url' => ['/shop']];
Yii::$app->params['breadcrumbs'][] = Yii::t('app', "My Account");
Yii::$app->params['breadcrumbs'][] = '我的申請 - 總覽';

$this->registerJs(<<<JS
JS
);

?>
<?= $this->render('../layouts/_user_header') ?>
<?= Alert::widget() ?>
    <div class="page-my">
        <div class="content">
            <div class="">
<style>
.mobile-th{display:none;}
.function a+a{margin-left:5px;}
@media (max-width:980px) {
  thead{display:none;}
  td{display:block;}
  .mobile-th{display:inline-block;}
}
</style>
                <table class="table">
                    <thead>
                        <tr>
                            <th>申請編號</th>
                            <th>申請日期</th>
                            <th>優先選擇 1</th>
                            <th>優先選擇 2</th>
                            <th>優先選擇 3</th>
                            <th>申請狀態</th>
                            <th>功能</th>
                        </tr>
                    </thead>
                    <tbody>
                <?php 
                    if (count($model) > 0) {
                        foreach ($model as $application) {
                ?>
                        <tr>
                            <td><div class="mobile-th">申請編號：</div><?= $application->appl_no ?></td>
                            <td><div class="mobile-th">申請日期：</div><?= date("Y-m-d", strtotime($application->created_at)) ?></td>
                            <td><div class="mobile-th">優先選擇 1：</div><?= Definitions::getProjectName($application->priority_1) ?></td>
                            <td><div class="mobile-th">優先選擇 2：</div><?= Definitions::getProjectName($application->priority_2) ?></td>
                            <td><div class="mobile-th">優先選擇 3：</div><?= Definitions::getProjectName($application->priority_3) ?></td>
                            <td><div class="mobile-th">申請狀態：</div><?= Definitions::getApplicationStatus($application->application_status) ?></td>
                            <td class="function"><div class="mobile-th">功能：</div>
                                <?php
                                    if ($application->application_status == $application::APPL_STATUS_UPDATE_SUBMITED_FORM) {
                                        echo Html::a('更新', ['application-update', 'id' => $application->id]);
                                    }
                                    echo Html::a('檢視', ['application-view', 'id' => $application->id]);
                                    if ($application->application_status >= $application::APPL_STATUS_UPLOAD_FILES && $application->application_status <= $application::APPL_STATUS_UPLOAD_FILES_AGAIN) {
                                        echo Html::a('上載檔案', ['upload', 'id' => $application->id]);
                                    }
                                ?>
                            </td>
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
