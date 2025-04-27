<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use common\models\Config;
use common\models\Definitions;
use kartik\widgets\DatePicker;

$basename = basename(\yii\helpers\Url::current());
$basename_temp = explode("?", $basename);
$current_route = $basename_temp[0];

$page = 1;
if(isset($_GET['page_no'])){
  $page = $_GET['page_no'];
}

$searchModel = new frontend\models\PageType5Search;
$searchModel->MID = $MID;
$searchModel->category_id = isset($_GET['category']) ? $_GET['category'] : null;

$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
$dataProvider->pagination->setPage($page-1);
$model_pt5 = $dataProvider->getModels();

$current_page = $dataProvider->pagination->getPage()+1;
$page_count = $dataProvider->pagination->getPageCount();
$total_count = $dataProvider->getTotalCount();

if($page_count==0){
  $current_page = 0;
}

$i = 0;
?>
<div class="page-header">
    <div class="headline">
        <div class="row">
            <div class="col-sm-8 col-md-9">
                <h3 class="title"><?= $title ?></h3>
            </div>
            <div class="col-xs-6 col-xs-push-6 col-sm-push-0 col-sm-4 col-md-3">
                <?= Html::dropDownList('category', $searchModel->category_id, Definitions::getPageType5Category(false, $searchModel->MID), ['class' => 'form-control', 'prompt' => Yii::t('app', '- All -'), 'onchange' => 'window.location="?category="+this.value']) ?>
            </div>
        </div>
    </div>
</div>
<?php if ($total_count < 1) { ?>
<div>
    <?= $model == NULL || $model->content == "" ? Yii::t('app', '<i>Coming Soon</i>') : $model->content ?>
</div>
<?php } else { ?>
<?= \newerton\fancybox3\FancyBox::widget([
		    'target' => '[data-fancybox]',
		    'config' => []
		]); ?>

<!--<div class="row pull-right">
  Page: <?= $current_page?>/<?= $page_count?> &nbsp; Total: <?=$total_count?>
</div>-->
    <!-- Start Post -->
<div class="document-posts">
    <div class="row">
<?php
    $i = 1;
    $_caption_xs_sm = [];
    $_caption_md_lg = [];
    foreach($model_pt5 as $model) {
        $_caption_xs_sm[] = $model;
        $_caption_md_lg[] = $model;
    ?>
        <div class="col-xs-6 col-md-4">
            <div class="document-post-thumb">
                <?= Html::a(Html::img($model->thumb, ['class' => 'thumbnail']), $model->link, ['target'=>'_blank']) ?>
            </div>
        </div>
<?php
    if ($i % 2 == 0) {
        echo '<div class="clearfix visible-xs-block visible-sm-block"></div>';
        foreach ($_caption_xs_sm as $_model_sm) {
?>
        <div class="col-xs-6 visible-xs-block visible-sm-block">
            <div class="document-post">
                <?= $_model_sm->category != null ? Html::tag('div', $_model_sm->category->name, ['class' => 'document-post-category']) : '' ?>
                <h5 class="document-post-title"><?= Html::a($_model_sm->title, $_model_sm->link, ['target'=>'_blank']) ?></h4>
                <?= $_model_sm->display_at != "" ? Html::tag('div', Yii::$app->formatter->format($_model_sm->display_at, 'date', ''), ['class' => 'document-post-date']) : '' ?>
            </div>
        </div>
<?php
        }
        echo '<div class="clearfix visible-xs-block visible-sm-block"></div>';
        $_caption_xs_sm = [];
    }
?>
<?php
    if ($i++ % 3 == 0) {
        echo '<div class="clearfix visible-md-block visible-lg-block"></div>';
        foreach ($_caption_md_lg as $_model_sm) {
?>
        <div class="col-md-4 visible-md-block visible-lg-block">
            <div class="document-post">
                <?= $_model_sm->category != null ? Html::tag('div', $_model_sm->category->name, ['class' => 'document-post-category']) : '' ?>
                <h5 class="document-post-title"><?= Html::a($_model_sm->title, $_model_sm->link, ['target'=>'_blank']) ?></h4>
                <?= $_model_sm->display_at != "" ? Html::tag('div', Yii::$app->formatter->format($_model_sm->display_at, 'date', ''), ['class' => 'document-post-date']) : '' ?>
            </div>
        </div>
<?php
        }
        echo '<div class="clearfix visible-md-block visible-lg-block"></div>';
        $_caption_md_lg = [];
    }
}
echo '<div class="clearfix visible-xs-block visible-sm-block"></div>';
foreach ($_caption_xs_sm as $_model_sm) {
?>
        <div class="col-xs-6 visible-xs-block visible-sm-block">
            <div class="document-post">
                <?= $_model_sm->category != null ? Html::tag('div', $_model_sm->category->name, ['class' => 'document-post-category']) : '' ?>
                <h5 class="document-post-title"><?= Html::a($_model_sm->title, $_model_sm->link, ['target'=>'_blank']) ?></h4>
                <?= $_model_sm->display_at != "" ? Html::tag('div', Yii::$app->formatter->format($_model_sm->display_at, 'date', ''), ['class' => 'document-post-date']) : '' ?>
            </div>
        </div>
<?php
}
echo '<div class="clearfix visible-xs-block visible-sm-block"></div>';
echo '<div class="clearfix visible-md-block visible-lg-block"></div>';
foreach ($_caption_md_lg as $_model_sm) {
?>
        <div class="col-md-4 visible-md-block visible-lg-block">
            <div class="document-post">
                <?= $_model_sm->category != null ? Html::tag('div', $_model_sm->category->name, ['class' => 'document-post-category']) : '' ?>
                <h5 class="document-post-title"><?= Html::a($_model_sm->title, $_model_sm->link, ['target'=>'_blank']) ?></h4>
                <?= $_model_sm->display_at != "" ? Html::tag('div', Yii::$app->formatter->format($_model_sm->display_at, 'date', ''), ['class' => 'document-post-date']) : '' ?>
            </div>
        </div>
<?php
}
echo '<div class="clearfix visible-md-block visible-lg-block"></div>';
?>
    </div>
</div>
<p>&nbsp;</p>
  <div class="row page-no-selection">
    <?php if($current_page != 1 && $page_count != 0):?>
      <a class="btn page-no-selection-btn" href="<?= Url::current(['page_no' => ($current_page-1)]) ?>"><i class="fa fa-angle-left"></i></a>
    <?php endif;?>
    <?php
    $page_max = 6;
    $page_start = 1;
    $page_end = $page_count;

    if($page_count>$page_max && $current_page>=$page_max){
      $page_start=$current_page-$page_max/2;
      if($page_start<=0) $page_start = 1;
    }

    if($current_page!=$page_count){
      $page_end=$current_page+$page_max/2;
      if($page_end>$page_count) $page_end = $page_count;
    }

    for($page_no=$page_start; $page_no<=$page_end; $page_no++):
      ?>
      <a class="btn page-no-selection-btn <?= ($page_no==$current_page)? "active":NULL?>" href="<?= Url::current(['page_no' => $page_no]) ?>" ><?=$page_no?></a>
    <?php endfor;?>
    <?php if($current_page < $page_count ):?>
      <a class="btn page-no-selection-btn" href="<?= Url::current(['page_no' => ($current_page+1)]) ?>"><i class="fa fa-angle-right"></i></a>
    <?php endif;?>
  </div>
<?php } ?>
