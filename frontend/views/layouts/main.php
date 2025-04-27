<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
// use frontend\assets\AdminLteAsset;
//use yii\bootstrap4\Breadcrumbs;
//use yii\bootstrap4\Html;
//use yii\bootstrap4\Nav;
//use yii\bootstrap4\NavBar;
use common\util\Html;
use common\widgets\Alert;
use common\models\General;
use common\models\Config;
use common\models\Menu;
use kartik\icons\Icon;

AppAsset::register($this);
// AdminLteAsset::register($this);

$model_general = General::findOne(1);

if ($this->title != $model_general->name)
    $this->title = $this->title.' - '.$model_general->name;

$base_name = explode('?', basename(\yii\helpers\Url::current([null])), 2)[0];
$current_MID = \frontend\models\CreatePageMenu::getMID($base_name);
$nav_items = [];

//$nav_items[] = ['label' => Yii::t('web', 'Home'), 'url' => ['/'],  'active' => ($this->context->route == 'site/index'), 'options' => ['style' => ['flex' => (mb_strlen(Yii::t('web', 'Home')) > 2 ? mb_strlen(Yii::t('web', 'Home')) : 3)]]];

$nav_items = array_merge($nav_items, Menu::getAllMenusForFrontendNavX());
//echo count($nav_items);
// $nav_items[] = [ 'label' => Yii::t('web', 'Contact Us'), 'url' => ['/contact'],  'active' => ($this->context->route == 'site/contact'), 'options' => ['style' => ['flex' => (mb_strlen(Yii::t('app', 'Contact Us')) > 2 ? mb_strlen(Yii::t('app', 'Contact Us')) : 3)]]];
$contact = [ 'label' => Yii::t('web', 'Contact Us'), 'url' => ['/contact'],  'active' => ($this->context->route == 'site/contact'), 'options' => ['style' => ['flex' => (mb_strlen(Yii::t('app', 'Contact Us')) > 2 ? mb_strlen(Yii::t('app', 'Contact Us')) : 3)]]];
$my_application = [ 'label' => '我的申請', 'url' => ['/my/application'],  'active' => ($this->context->route == 'my/application'), 'options' => ['style' => ['flex' => (mb_strlen('我的申請') > 2 ? mb_strlen('我的申請') : 3)]]];

if (Yii::$app->user->isGuest) {
    $nav_items[] = $contact;
} else {
    array_splice($nav_items, count($nav_items) - 1, 0, [$my_application]);
    array_splice($nav_items, count($nav_items) - 2, 0, [$contact]);
}
// echo '<pre>';
// print_r($nav_items);
// echo '</pre>';
// exit();
$xs_nav_items = $nav_items;

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php $this->registerCsrfMetaTags() ?>
    <meta name="description" content="<?= $model_general->description ?>">
    <meta name="keywords" content="<?= $model_general->keywords ?>">
    <title><?= Html::encode($this->title) ?></title>
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">
    <link rel="mask-icon" href="/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">
    <?php $this->head() ?>
</head>
<body class="d-flex flex-column h-100">
<?php $this->beginBody() ?>

<?= $this->render('_header', ['nav_items' => $nav_items, 'xs_nav_items' => $xs_nav_items]) ?>

<?php if ($this->context->route == "site/index") { ?>
    <main role="main" class="flex-shrink-0">
        <div class="container">
        <?= Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) ?>
            <?= Alert::widget() ?>
            <?= $content ?>
        </div>
    </main>
<?php } else { ?>
        <div class="main-content-bg">
            <div class="container">
            <?= Breadcrumbs::widget([
                'homeLink' => [
                    'label' => Yii::t('app','Home'),
                    'url' => Yii::$app->homeUrl,
                    'encode' => false
                ],
                'links' => isset(Yii::$app->params['breadcrumbs']) ? Yii::$app->params['breadcrumbs'] : [],
            ]) ?>
                <div class="main-content">
                    <?= $content ?>
                </div>
            </div>
        </div>
<?php } ?>
<?= $this->render('_footer', [])?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage();
