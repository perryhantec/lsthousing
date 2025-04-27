<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use common\models\Config;
use common\models\Definitions;
use common\models\PageType3;
use common\models\PageType3Photo;

$basename = basename(\yii\helpers\Url::current());
$basename_temp = explode("?", $basename);
$current_route = $basename_temp[0];


$basename = basename(\yii\helpers\Url::current());
$basename_temp = explode("?", $basename);
$current_route = $basename_temp[0];

$page = 1;
if(isset($_GET['page_no'])){
  $page = $_GET['page_no'];
}


$searchModel = new frontend\models\PageType3Search;
$searchModel->MID = $MID;
$searchModel->year = isset($_GET['year']) ? $_GET['year'] : null;

$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
$dataProvider->pagination->setPage($page-1);
$model_pt3 = $dataProvider->getModels();

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
                <?= Html::dropDownList('year', $searchModel->year, Definitions::getPageType3DisplayAtAllYear($searchModel->MID), ['class' => 'form-control', 'prompt' => Yii::t('app', '- All -'), 'onchange' => 'window.location="?year="+this.value']) ?>
            </div>
        </div>
    </div>
</div>
<?php if ($total_count < 1) { ?>
<div>
    <?= $model == NULL || $model->content == "" ? Yii::t('app', '<i>Coming Soon</i>') : $model->content ?>
</div>
<?php } else { ?>
<div class="photo-albums">
  <div class="row">
<?php

    $i = 0;
    foreach($model_pt3 as $model) {
        $i++;
?>
    <div class="pagetype3-cover-post-container col-xs-6 col-sm-6 col-md-4 col-lg-4" id="post-<?= $model->id ?>">
        <div class="pagetype3-cover">
            <div class="pagetype3-cover-image">
                <a href="<?= Url::to([$current_route.'/gallery_detail', 'id' => $model->id]) ?>" style="background-image: url(<?= $model->coverPhoto ? $model->coverPhoto->thumb : '' ?>)">
                </a>
            </div>
            <div class="pagetype3-cover-description">
                <h5 class="pagetype3-cover-title">
                    <a href="<?= Url::to([$current_route.'/gallery_detail', 'id' => $model->id]) ?>">
                        <?= $model->name ?>
                    </a>
                </h5>
                <div class="pagetype3-cover-date"><?= Yii::$app->formatter->format($model->display_at, 'date') ?></div>
            </div>
        </div>
    </div>
<?php

        if ($i%3 == 0)
            echo '<div class="clearfix visible-lg-block visible-md-block"></div>';
        if ($i%2 == 0)
            echo '<div class="clearfix visible-xs-block visible-sm-block"></div>';

    }
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