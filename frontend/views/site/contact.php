<?php

/* @var $this yii\web\View */
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;
use yii\helpers\Html;

Yii::$app->params['page_header_title'] = Yii::t('web', 'Contact Us');
$this->title = strip_tags(Yii::t('web', 'Contact Us'));

Yii::$app->params['page_header_img'] = Yii::getAlias('@web/images/contactUs-header.jpg');

Yii::$app->params['breadcrumbs'][] = $this->title;

?>
<div class="content">
    <?= Alert::widget() ?>
    <?= $this->render('_contact');?>
    <p>&nbsp;</p>
    <?= $this->render('_contact_form',['model'=>$model]);?>
</div>
<div class="sharethis-inline-share-buttons"></div>
