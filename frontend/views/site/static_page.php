<?php

/* @var $this yii\web\View */
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;
use yii\helpers\Html;

if (isset($route) && $route == "disclaimer") {
    $content = $model->disclaimer;
    $this->title = Yii::t('app', 'Disclaimer');
} else if (isset($route) && $route == "privacy-policy") {
    $content = $model->privacy_statement;
    $this->title = Yii::t('app', 'Privacy Policy');
} else if (isset($route) && $route == "copyright-notice") {
    $content = $model->copyright_notice;
    $this->title = Yii::t('app', 'Copyright Notice');
}
Yii::$app->params['breadcrumbs'][] = $this->title;
Yii::$app->params['page_header_title'] = $this->title;

?>
<div class="content">
    <h3><?= $this->title ?></h3>
    <?= $content == "" ? Yii::t('app', '<i>Coming Soon</i>') : $content ?>
</div>
