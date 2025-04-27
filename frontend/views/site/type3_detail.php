<?php

use yii\widgets\Breadcrumbs;
use common\widgets\Alert;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use common\models\Config;

$model_general = common\models\General::findOne(1);

Yii::$app->params['page_route'] = $model_album->menu->route;
Yii::$app->params['page_header_title'] = $model_album->menu->name;

$_subMenus = $model_album->menu->allSubMenu;
foreach ($_subMenus as $_subMenu) {
    Yii::$app->params['breadcrumbs'][] = strip_tags($_subMenu->name);
    if ($_subMenu->banner_image_file_name != "")
        Yii::$app->params['page_header_img'] = $_subMenu->banner_image_file_name;
}
if (sizeof($_subMenus) > 0)
    Yii::$app->params['page_header_title'] = $_subMenus[0]->name;
if ($model_album->menu->banner_image_file_name != "")
    Yii::$app->params['page_header_img'] = $model_album->menu->banner_image_file_name;

Yii::$app->params['breadcrumbs'][] = ['label' => $model_album->menu->name, 'url' => ['/'.$model_album->menu->route]];
Yii::$app->params['breadcrumbs'][] = $model_album->name;

$this->title = $model_album->name.' - '.$model_album->menu->name;

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
<?= \newerton\fancybox3\FancyBox::widget([
		    'target' => '[data-fancybox]',
		    'config' => []
		]); ?>
            <div class="content">
                <div class="page-header">
                    <div class="headline">
                        <h3 class="title"><?= $model_album->name ?></h3>
                    </div>
                </div>
                <p><?= nl2br($model_album->description) ?></p>
                <div class="row">
<?php

        $i = 0;
        foreach($model_photos as $index=>$model) {

            $i++;
?>
                    <div class="pagetype3-post-container col-xs-6 col-sm-6 col-md-4 col-lg-4" id="post-<?= $model->id ?>">
                        <div class="pagetype3-post">
                            <?= Html::a('', $model->image, ['style' => 'background-image:url('.$model->thumb.')', 'data' => ['fancybox' => 'photo', 'caption' => $model->name]]) ?>
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
                <p class="post-content-back text-center"><?= Html::a(Yii::t('app', 'Back'), Yii::$app->request->referrer ?: ['/'.$model_album->menu->route], ['class' => 'btn btn-primary']) ?></p>
            </div>
    </div>
</div>
