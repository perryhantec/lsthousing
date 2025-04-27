<?php

use yii\widgets\Breadcrumbs;
use yii\helpers\Html;
use yii\helpers\Url;

// Yii::$app->params['page_header_title'] = '項目搜尋';
$this->title = '項目搜尋';

// Yii::$app->params['breadcrumbs'][] = strip_tags($this->title);

// Yii::$app->params['page_route'] = 'project_search';

// foreach ($results as $result) {
//   echo $result->title_tw.'<br />';
// }
?>
    <?= $this->render('_project_search_menu', []) ?>
    <div class="content">
        <div class="page-header">
            <div class="headline">
                <h3 class="title"><?= $this->title ?></h3>
            </div>
        </div>

<?php if (count($model_pt12) < 1) { ?>
<div>
<?php if (false) { ?>
    <?= $model == NULL || $model->content == "" ? Yii::t('app', '<i>Coming Soon</i>') : $model->content ?>
<?php } ?>
    <?= Yii::t('app', '<i>沒有資料</i>') ?>
</div>
<?php } else { ?>
    <!-- Start Post -->
    <div class="news-posts">
    <?php foreach($model_pt12 as $model):?>
      <!-- Post Content -->
      <div id="post-<?= $model->id ?>" class=" post-content">
        <div class="post-title"><?= Html::a($model->title, [($model->menu->url.'/apply_detail'), 'id' => $model->id]) ?></div>
<?php if (false) { ?>
        <div class="post-display_at"><?= Yii::$app->formatter->format($model->display_at, 'date') ?></div>
<?php } ?>
        <?php if ($model->youtube_id != '' || $model->image_file_name != '') { ?>
        <div class="row">
          <div class="col-sm-4 col-sm-push-8 col-lg-3 col-lg-push-9">
<?php if ($model->top_media_type == $model::TMT_YOUTUBE) { ?>
            <div class="post-youtube"><iframe src="//www.youtube.com/embed/<?= $model->youtube_id ?>?rel=0&amp;showinfo=0" frameborder="0" gesture="media" allow="encrypted-media" allowfullscreen></iframe></div>
<?php } else if ($model->image_file_name != '') { ?>
            <div class="post-image"><?= Html::a(Html::img($model->image_file_name), [($model->menu->url.'/apply_detail'), 'id' => $model->id]) ?></div>
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
                <div class="post-more"><?= Html::a(Yii::t('web', 'Detail'), [($model->menu->url.'/apply_detail'), 'id' => $model->id]) ?></div>
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

<?php } ?>

    </div>
