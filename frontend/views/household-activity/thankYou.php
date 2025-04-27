<?php

/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\helpers\Url;
use common\widgets\Alert;
use common\models\Menu;

// Yii::$app->params['page_header_img'] = '/images/page_header_img-donation.jpg';

$menu_model = Menu::findOne(['url' => 'household-activity']);

if ($menu_model != null) {
    Yii::$app->params['page_route'] = $menu_model->route;
    $_subMenus = $menu_model->allSubMenu;

    $this->title = strip_tags($menu_model->name);
    Yii::$app->params['page_header_title'] = $menu_model->name;

    foreach ($_subMenus as $_subMenu) {
        Yii::$app->params['breadcrumbs'][] = strip_tags($_subMenu->name);
        if ($_subMenu->banner_image_file_name != "")
            Yii::$app->params['page_header_img'] = $_subMenu->banner_image_file_name;
    }
    if (sizeof($_subMenus) > 0)
        Yii::$app->params['page_header_title'] = $_subMenus[0]->name;

    Yii::$app->params['breadcrumbs'][] = $this->title;
}

?>
    <div class="row">
<?php if (sizeof($_subMenus) > 0) { ?>
        <div class="col-sm-3">
            <?= $this->render('../layouts/_body_left_nav', ['menus' => $_subMenus[0]->getActiveSubMenu()->orderBy(['seq' => SORT_ASC])->all()]); ?>
        </div>
        <div class="col-sm-9 has-sub-nav">
<?php } else { ?>
        <div class="col-sm-12">
<?php } ?>
            <div id="in-kind-donation" class="content in-kind-donation in-kind-donation--thankyou>">
                <h3><?= $menu_model->name ?></h3>

                <?= Alert::widget() ?>

                <p>感謝您的申請！</p>
                <p><?= Yii::t('in-kind-donation', "We will contact you as soon as possible.") ?></p>

            </div>
        </div>
    </div>