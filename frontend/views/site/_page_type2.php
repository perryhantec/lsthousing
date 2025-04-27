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


$searchModel = new frontend\models\PageType2Search;
$searchModel->MID = $MID;

$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
$dataProvider->pagination->setPage($page-1);
$model_pt5 = $dataProvider->getModels();


$url_temp = explode("?", Yii::$app->request->absoluteUrl);
$url = $url_temp[0];

$current_page = $dataProvider->pagination->getPage()+1;
$page_count = $dataProvider->pagination->getPageCount();
$total_count = $dataProvider->getTotalCount();

if($page_count==0){
  $current_page = 0;
}

$i = 0;
?>
<?= \newerton\fancybox3\FancyBox::widget([
		    'target' => '[data-fancybox]',
		    'config' => []
		]); ?>

<!--<div class="row pull-right">
  Page: <?= $current_page?>/<?= $page_count?> &nbsp; Total: <?=$total_count?>
</div>-->
    <!-- Start Post -->
<div class="video-posts">
    <div class="row">
<?php
    $i = 1;
    foreach($model_pt5 as $model){ ?>
        <div class="col-sm-6">
            <div class="video-post">
                <div class="post-content <?= $i % 4 <= 2 & $i % 4 > 0 ? 'post-content-odd-row' : 'post-content-even-row' ?>">
                    <div class="post-video">
<?= \wbraganca\videojs\VideoJsWidget::widget([
        'options' => [
            'class' => 'video-js vjs-default-skin vjs-big-play-centered vjs-16-9',
            'poster' => $model->image_file_name,
            'controls' => true,
            'preload' => 'none',
            'style' => "width: 100%;",
            'data' => [
                'setup' => [
                ],
            ],
        ],
        'tags' => [
            'source' => [
                ['src' => $model->FileDisplayPath.$model->file_name]
            ]
        ]
    ]);
?>
                    </div>
                    <h4 class="post-title"><?= $model->title ?></h4>
                    <div class="post-footer">
                        <div class="post-display_at"><?= Yii::$app->formatter->format($model->display_at, 'date') ?></div>
                    </div>
                </div>
            </div>
        </div>
        <?= $i++ % 2 == 0 ? '<div class="clearfix hidden-xs"></div>' : '' ?>
<?php } ?>
    </div>
</div>
<p>&nbsp;</p>
  <div class="row page-no-selection">
    <?php if($current_page != 1 && $page_count != 0):?>
      <a class="btn page-no-selection-btn" href="<?= Url::to(['/'.$current_route]).'?page_no='.($current_page-1)?>"><i class="fa fa-angle-left"></i></a>
    <?php endif;?>
    <?php
    $page_max = 10;
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
