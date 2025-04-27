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

$url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http").'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']; 
$url = urlencode($url);
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
<?php if (false) { ?>
            <div class="social-media">
                <div class="pull-right">
                    <a href="https://www.facebook.com/sharer/sharer.php?u=<?= $url ?>&display=popup" target="_blank">
                        <img src="../images/fb.png" alt="Facebook Share" style="width:30px;" />
                    </a>
                    <a href="https://api.whatsapp.com/send?text=<?= $url ?>" data-action="share/whatsapp/share" target="_blank">
                        <img src="../images/wts.png" alt="Whatsapp Share" style="width:30px;" />
                    </a>
                    </div>
                <div class="clearfix"></div>
            </div>
<?php } ?>
            <!-- Start Post -->
            <div class="news-post">
                <!-- Post Content -->
                <div class="post-content">
                    <!--<p class="post-time"><?=Yii::$app->formatter->asDate($model->display_at) ?></p>-->
                    <?php if($model->author!=NULL): ?>
                    <div class="meta">
                      <?php if($model->author!=NULL): ?>
                      &nbsp;&nbsp;|&nbsp;&nbsp;
                      <?php endif?>
                      <?php if($model->author!=NULL): ?>
                        <span class="meta-part"><i class="icon-user"></i> <?=$model->author?></span>
                      <?php endif?>
                    </div>
                    <?php endif?>
                    <div class="post-content-text">
                        <?= $model->summary ?>
                    </div>
                <?php if ($model->poster_file_name != '') {
                    \newerton\fancybox3\FancyBox::widget([
                        'target' => '[data-poster-fancybox]',
                        'config' => []
                    ]);
                ?>
                    <div class="post-content-text">
                        <div class="col-sm-3 post-content-text-label">項目海報</div>
                        <div class="col-sm-9"><?= Html::a(Html::img($model->poster_file_name, ['style'=>'max-width:300px;']), $model->poster_file_name, ['data' => ['poster-fancybox' => "pageImages", 'caption' => '']]) ?></div>
                        <div class="clearfix"></div>
                    </div>
                <?php } ?>
                    <div class="post-content-text">
                        <div class="col-sm-3 post-content-text-label">地點</div>
                        <div class="col-sm-9"><?= $model->housing_location ?></div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="post-content-text">
                        <div class="col-sm-3 post-content-text-label">預期租金</div>
                        <div class="col-sm-9"><?= $model->housing_rent ?></div>
                        <div class="clearfix"></div>
                    </div>
<?php
    if ($model->avl_no_of_people_max > $model->avl_no_of_people_min) {
        $avl_no_of_people = (int)$model->avl_no_of_people_min.' - '.$model->avl_no_of_people_max.'人';
    } else {
        $avl_no_of_people = (int)$model->avl_no_of_people_min.'人';
    }
?>
                    <div class="post-content-text">
                        <div class="col-sm-3 post-content-text-label">可供入住人數</div>
                        <div class="col-sm-9"><?= $avl_no_of_people ?></div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="post-content-text">
                        <div class="col-sm-3 post-content-text-label">可供申請單位數目</div>
                        <div class="col-sm-9"><?= $model->avl_no_of_application ?></div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="post-content-text">
                        <div class="col-sm-3 post-content-text-label">可供居住年期</div>
                        <div class="col-sm-9"><?= $model->avl_no_of_live_year ?></div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="post-content-text">
                        <div class="col-sm-3 post-content-text-label">備註</div>
                        <div class="col-sm-9"><?= $model->remarks ?></div>
                        <div class="clearfix"></div>
                    </div>

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
                <p class="post-content-back text-center">
                <?php if ($model->is_open == 1) { ?>
                    <?= Html::a('申請', ['/application', 'preferred' => $model->id], ['class' => 'btn btn-success']) ?>
                <?php } ?>
                    <?= Html::a(Yii::t('app', 'Back'), Yii::$app->request->referrer ?: ['/'.$model->menu->route], ['class' => 'btn btn-primary']) ?>
                </p>
            </div>
            <!-- End Post -->
        </div>
    </div>
</div>
