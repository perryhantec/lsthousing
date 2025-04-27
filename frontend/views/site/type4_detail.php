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
            <div class="page-header">
                <div class="headline">
                    <h3 class="title"><?= $model->title ?></h3>
                </div>
            </div>
            <!-- Start Post -->
            <div class="news-post">
                <!-- Post Content -->
                <div class="post-content">
                    <!--<p class="post-time"><?=Yii::$app->formatter->asDate($model->display_at) ?></p>-->
                    <?php if($model->category_id!=NULL && $model->author!=NULL): ?>
                    <div class="meta">
                      <?php if($model->category_id!=NULL): ?>
                        <span class="meta-part"><?= \common\models\Definitions::getPageType4Category($model->category_id, $model->MID, Yii::$app->language) ?></span>
                      <?php endif?>
                      <?php if($model->category_id!=NULL && $model->author!=NULL): ?>
                      &nbsp;&nbsp;|&nbsp;&nbsp;
                      <?php endif?>
                      <?php if($model->author!=NULL): ?>
                        <span class="meta-part"><i class="icon-user"></i> <?=$model->author?></span>
                      <?php endif?>
                    </div>
                    <?php endif?>
                    <div class="post-content-text">
                        <?= $model->content ?>
                    </div>

<?php if (sizeof($model->picture_file_names) > 0) { ?>
<?= \newerton\fancybox3\FancyBox::widget([
		    'target' => '[data-fancybox]',
		    'config' => []
		]); ?>
<div class="page-images">
    <div class="row">
<?php
    $i = 0;

    foreach($model->picture_file_names as $file_name => $file_description) {
        if ($i++ % 2 == 0)
            echo '<div class="clearfix"></div>';
        echo '<div class="col-sm-6"><p class="text-center">';
        echo Html::a(Html::img($model->fileThumbDisplayPath.$file_name), $model->fileDisplayPath.$file_name, ['data' => ['fancybox' => "pageImages", 'caption' => $file_description]]);
        echo '</p></div>';
    }
    ?>
    </div>
</div>
<?php } ?>
                </div>
                <!-- Post Content -->
                <p class="post-content-back text-center"><?= Html::a(Yii::t('app', 'Back'), Yii::$app->request->referrer ?: ['/'.$model->menu->route], ['class' => 'btn btn-primary']) ?></p>
            </div>
            <!-- End Post -->
        </div>
    </div>
</div>
