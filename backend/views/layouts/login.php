<?php

/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\LoginAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;

LoginAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <link rel="icon" type="image/png" href="<?= Yii::getAlias('@web').'/img/icon.png'?>">

</head>
<body class="hold-transition login-page">
<?php $this->beginBody() ?>
<div class="login-box">
  <div class="login-logo">
    <a href="<?=Yii\helpers\Url::to(['site/login'])?>">
      <?= yii\helpers\Html::img(Yii::getAlias('@web').'/img/logo.png')?>
    </a>
  </div>
  <?php echo Alert::widget() ?>
  <div class="login-box-body">
    <?= $content ?>
  </div>
</div>


<footer class="footer">
    <div class="container">
        <p class="pull-left">Copyright © 2021 All Rights Reserved</p>
        <p class="pull-right">Powered by <a href='http://www.efaith.hk/'>eFaith Company Ltd.</a></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
