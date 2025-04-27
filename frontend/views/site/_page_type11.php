<?php

use yii\helpers\Html;
use yii\helpers\Url;
use common\models\Config;
use common\models\Definitions;

$basename = basename(\yii\helpers\Url::current());
$basename_temp = explode("?", $basename);
$current_route = $basename_temp[0];

$page = 1;
if(isset($_GET['page_no'])){
  $page = $_GET['page_no'];
}


$searchModel = new frontend\models\PageType11Search;
$searchModel->MID = $MID;
$searchModel->year = isset($_GET['year']) ? $_GET['year'] : null;

$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
$dataProvider->pagination->setPage($page-1);
$model_pt11 = $dataProvider->getModels();

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
            <div class="col-sm-9 col-md-10">
                <h3 class="title"><?= $title ?></h3>
            </div>
            <div class="col-xs-4 col-xs-push-8 col-sm-push-0 col-sm-3 col-md-2">
                <?= Html::dropDownList('year', $searchModel->year, Definitions::getPageType11DisplayAtAllYear($searchModel->MID), ['class' => 'form-control', 'prompt' => Yii::t('app', '- All -'), 'onchange' => 'window.location="?year="+this.value']) ?>
            </div>
        </div>
    </div>
</div>
<?php if ($total_count < 1) { ?>
<div>
<?php if (false) { ?>
    <?= $model == NULL || $model->content == "" ? Yii::t('app', '<i>Coming Soon</i>') : $model->content ?>
<?php } ?>
    <?= Yii::t('app', '<i>Coming Soon</i>') ?>
</div>
<?php } else { ?>
<!--<div class="row pull-right">
  Page: <?= $current_page?>/<?= $page_count?> &nbsp; Total: <?=$total_count?>
</div>-->
    <!-- Start Post -->
    <div class="news-posts">
    <?php foreach($model_pt11 as $model):?>
      <!-- Post Content -->
      <div id="post-<?= $model->id ?>" class=" post-content">
        <div class="post-title"><?= Html::a($model->title, [($current_route.'/housing_detail'), 'id' => $model->id]) ?></div>
        <!--div class="post-display_at"><?= Yii::$app->formatter->format($model->display_at, 'date') ?></div-->
        <?php if ($model->youtube_id != '' || $model->image_file_name != '') { ?>
        <div class="row">
          <div class="col-sm-4 col-sm-push-8 col-lg-3 col-lg-push-9">
<?php if ($model->top_media_type == $model::TMT_YOUTUBE) { ?>
            <div class="post-youtube"><iframe src="//www.youtube.com/embed/<?= $model->youtube_id ?>?rel=0&amp;showinfo=0" frameborder="0" gesture="media" allow="encrypted-media" allowfullscreen></iframe></div>
<?php } else if ($model->image_file_name != '') { ?>
            <div class="post-image"><?= Html::a(Html::img($model->image_file_name), [($current_route.'/housing_detail'), 'id' => $model->id]) ?></div>
<?php } ?>
          </div>
          <div class="col-sm-8 col-sm-pull-4 col-lg-9 col-lg-pull-3">
<?php } ?>
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
            <div class="post-summary">
                <?= $model->summary != "" ? ('<p>'.Yii::$app->formatter->asNtext($model->summary).'</p>') : '' ?>
                <div class="post-more"><?= Html::a(Yii::t('web', 'Detail'), [($current_route.'/housing_detail'), 'id' => $model->id]) ?></div>
            </div>
<?php if ($model->youtube_id != '' || $model->image_file_name != '') { ?>
          </div>
        </div>
<?php } ?>
      </div>
      <!-- Post Content -->
    <?php endforeach;?>
    </div>
    <!-- End Post -->
<p>&nbsp;</p>
  <div class="row page-no-selection">
    <?php if($current_page != 1 && $page_count != 0):?>
      <a class="btn page-no-selection-btn" href="<?= Url::to(['/'.$current_route]).'?page_no='.($current_page-1)?>"><i class="fa fa-angle-left"></i></a>
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
      <a class="btn page-no-selection-btn <?= ($page_no==$current_page)? "active":NULL?>" href="<?= Url::to(['/'.$current_route]).'?page_no='.($page_no)?>" ><?=$page_no?></a>
    <?php endfor;?>
    <?php if($current_page < $page_count ):?>
      <a class="btn page-no-selection-btn" href="<?=Url::to(['/'.$current_route]).'?page_no='.($current_page+1)?>"><i class="fa fa-angle-right"></i></a>
    <?php endif;?>
  </div>
<?php } ?>
