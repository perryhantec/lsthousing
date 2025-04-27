<?php

use yii\widgets\Breadcrumbs;
use common\widgets\Alert;
use yii\helpers\Html;
use yii\helpers\Url;
use common\models\Config;
use branchonline\lightbox\Lightbox;

$model_general = common\models\General::findOne(1);

Yii::$app->params['page_route'] = $model->menu->route;
Yii::$app->params['page_header_title'] = $model->menu->name;

$_subMenus = $model->menu->allSubMenu;
foreach ($_subMenus as $_subMenu) {
    Yii::$app->params['breadcrumbs'][] = strip_tags($_subMenu->name);
    if ($_subMenu->banner_image_file_name != "")
        Yii::$app->params['page_header_img'] = $_subMenu->banner_image_file_name;
}
if (sizeof($_subMenus) > 0)
    Yii::$app->params['page_header_title'] = $_subMenus[0]->name;
if ($model->menu->banner_image_file_name != "")
    Yii::$app->params['page_header_img'] = $model->menu->banner_image_file_name;

Yii::$app->params['breadcrumbs'][] = ['label' => $model->menu->name, 'url' => ['/'.$model->menu->route]];
Yii::$app->params['breadcrumbs'][] = strip_tags($model->post);

$this->title = strip_tags($model->post).' - '.strip_tags($model->menu->name);

?>
<?php if ($layout) { ?>
<div class="row">
<?php if (sizeof($_subMenus) > 0) { ?>
    <div class="col-md-3">
        <?= $this->render('../layouts/_body_left_nav', ['menus' => $_subMenus[0]->getActiveSubMenu()->orderBy(['seq' => SORT_ASC])->all()]); ?>
    </div>
    <div class="col-md-9 has-sub-nav">
<?php } else { ?>
    <div class="col-sm-12">
<?php } ?>
        <div class="content">
<?php } ?>
            <!-- Start Post -->
            <div class="job-post">
                <h3><?= $model->post ?></h3>
                <div class="table-responsive">
                    <table class="table">
                        <tr>
                            <th class="text-nowrap"><?= Yii::t('job-opportunity', 'Post Date') ?></th>
                            <td><?= Yii::$app->formatter->asDate($model->date, 'long') ?></td>
                        </tr>
                        <tr>
                            <th class="text-nowrap"><?= Yii::t('job-opportunity', 'Service Unit') ?></th>
                            <td><?= Html::encode($model->serviceUnit ?: '-') ?></td>
                        </tr>
                        <tr>
                            <th class="text-nowrap"><?= Yii::t('job-opportunity', 'Position') ?></th>
                            <td><?= Html::encode($model->post ?: '-') ?></td>
                        </tr>
                        <tr>
                            <th class="text-nowrap"><?= Yii::t('job-opportunity', 'Ref') ?></th>
                            <td><?= Html::encode($model->ref ?: '-') ?></td>
                        </tr>
                        <tr>
                            <th class="<?= Yii::$app->language == "zh-TW" ? 'text-nowrap' : '' ?>"><?= Yii::t('job-opportunity', 'Application Deadline') ?></th>
                            <td><?= Yii::$app->formatter->asDate($model->applicationDeadline, 'long') ?></td>
                        </tr>
                        <tr>
                            <th class="<?= Yii::$app->language == "zh-TW" ? 'text-nowrap' : '' ?>"><?= Yii::t('job-opportunity', 'Key Responsibilities') ?></th>
                            <td><?= $model->keyRes ?: '-' ?></td>
                        </tr>
                        <tr>
                            <th class="<?= Yii::$app->language == "zh-TW" ? 'text-nowrap' : '' ?>"><?= Yii::t('job-opportunity', 'Entry Requirements') ?></th>
                            <td><?= $model->entryReq ?: '-' ?></td>
                        </tr>
                        <tr>
                            <th class="<?= Yii::$app->language == "zh-TW" ? 'text-nowrap' : '' ?>"><?= Yii::t('job-opportunity', 'Application Method') ?></th>
                            <td><?= $model->appMethod ?: '-' ?></td>
                        </tr>
                        <tr>
                            <th class="text-nowrap"><?= Yii::t('job-opportunity', 'Remark') ?></th>
                            <td><?= $model->remark ?: '-' ?></td>
                        </tr>
                    </table>
                </div>
            </div>
            <!-- End Post -->
<?php if ($layout) { ?>
        </div>
    </div>
</div>
<?php } ?>