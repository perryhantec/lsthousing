<?php

/* @var $this yii\web\View */
use yii\helpers\Html;
use common\models\ContactUs;

$model = ContactUs::findOne(1);
?>

<div class="information">
  <?php if($model->googlemap!=""):?>
    <iframe src="<?= $model->googlemap ?>" width="100%" height="350" frameborder="0" style="border:0" allowfullscreen></iframe>
  <?php endif;?>

  <?php if($model->address!=NULL):?>
  <div class="row">
      <div class="col-sm-2 info-label"><?=Yii::t('web','{0}:',[Yii::t('web','Address')])?></div>
      <div class="col-sm-10"><?=Yii::$app->formatter->asNtext($model->address)?></div>
  </div>
  <?php endif;?>

  <?php if($model->phone!=NULL):?>
  <div class="row">
      <div class="col-sm-2 info-label"><?=Yii::t('web','{0}:',[Yii::t('web','Phone')])?></div>
      <div class="col-sm-10"><?=Html::encode($model->phone)?></div>
  </div>
  <?php endif;?>

  <?php if($model->fax!=NULL):?>
  <div class="row">
      <div class="col-sm-2 info-label"><?=Yii::t('web','{0}:',[Yii::t('web','Fax')])?></div>
      <div class="col-sm-10"><?=Html::encode($model->fax)?></div>
  </div>
  <?php endif;?>

  <?php if($model->website!=NULL):?>
  <div class="row">
      <div class="col-sm-2 info-label"><?=Yii::t('web','{0}:',[Yii::t('web','Website')])?></div>
      <div class="col-sm-10"><?=Html::a($model->website, $model->website, ['target' => '_blank']) ?></div>
  </div>
  <?php endif;?>

  <?php if($model->email!=NULL):?>
  <div class="row">
      <div class="col-sm-2 info-label"><?=Yii::t('web','{0}:',[Yii::t('web','Email')])?></div>
      <div class="col-sm-10"><?=Html::a($model->email, 'mailto:'.$model->email, ['target' => '_top']) ?></div>
  </div>
  <?php endif;?>
  </dl>

</div>
