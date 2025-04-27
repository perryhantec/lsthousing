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
Yii::$app->params['breadcrumbs'][] = strip_tags($model->title);

$this->title = strip_tags($model->title).' - '.strip_tags($model->menu->name);

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
            <div class="tender-post">
                <h3><?= $model->title ?></h3>
<?php if (!$print) { ?>
                <div class="table-responsive">
<?php } ?>
                    <table class="table">
                        <tr>
                            <th class="text-nowrap"><?= Yii::t('tender-notice', 'Tender No.') ?></th>
                            <td><?= Html::encode($model->num) ?></td>
                        </tr>
                        <tr>
                            <th class="text-nowrap"><?= Yii::t('tender-notice', 'Tender Subject') ?></th>
                            <td><?= Html::encode($model->title) ?></td>
                        </tr>
                        <tr>
                            <th class="text-nowrap"><?= Yii::t('tender-notice', 'Tender Notice') ?></th>
                            <td><?= $model->content ?: '-' ?></td>
                        </tr>
                        <tr>
                            <th class="text-nowrap"><?= Yii::t('tender-notice', 'General Enquiry') ?></th>
                            <td><?= Yii::$app->formatter->asNtext($model->contact) ?></td>
                        </tr>
                        <tr>
                            <th class="text-nowrap"><?= Yii::t('tender-notice', 'Date of Tender Issue') ?></th>
                            <td><?= Yii::$app->formatter->asDate($model->date, 'long') ?></td>
                        </tr>
                        <tr>
                            <th class="<?= Yii::$app->language == "zh-TW" ? 'text-nowrap' : '' ?>"><?= Yii::t('tender-notice', 'Attachments') ?></th>
                            <td><?php
                                if ($model->attachment_file_names == null || sizeof($model->attachment_file_names) == 0) {
                                    echo '-';
                                } else {
                                    foreach ($model->attachment_file_names as $_file_name => $_file_description) {
                                        echo Html::a($_file_description, $model->fileDisplayPath.$_file_name, ['target' => '_blank'])."<br>";
                                    }
                                } ?></td>
                        </tr>
                        <tr>
                            <td colspan="2">&nbsp</td>
                        </tr>
                        <tr>
                            <th class="<?= Yii::$app->language == "zh-TW" ? 'text-nowrap' : '' ?>"><?= Yii::t('tender-notice', 'Submission of Tenders') ?></th>
                            <td><?= Html::encode($model->putAddr) ?></td>
                        </tr>
                        <tr>
                            <th class="<?= Yii::$app->language == "zh-TW" ? 'text-nowrap' : '' ?>"><?= Yii::t('tender-notice', 'Tender Closing Date & Time') ?></th>
                            <td><?= $model->due_atDisplay ?></td>
                        </tr>
                    </table>
<?php if (!$print) { ?>
                </div>
<?php } ?>
<?php if (!$print) { ?>
                <p class="text-right"><?= Html::a(Yii::t('app', 'Print'), [('/'.$model->menu->route.'/tender'), 'id' => $model->id, 'print' => true], ['class' => 'btn btn-primary', 'target' => '_blank']) ?></p>
<?php } ?>
            </div>
            <!-- End Post -->
<?php if ($layout) { ?>
        </div>
    </div>
</div>
<?php } ?>