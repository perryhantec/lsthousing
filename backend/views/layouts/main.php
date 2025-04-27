<?php

/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;

AppAsset::register($this);
$this->registerCssFile('@web/css/cropbox.css');
$this->registerCssFile('@web/css/site.css?v=1.0.1');

if (isset($this->params['breadcrumbs']) && is_array($this->params['breadcrumbs'])) {
    $this->params['breadcrumbs'] = array_map(function($v){
            if (is_array($v)) {
                if (isset($v['label']))
                    $v['label'] = trim(strip_tags($v['label']));
                return $v;
            }
            return trim(strip_tags($v));
        }, $this->params['breadcrumbs']);
}
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode(strip_tags($this->title)) ?></title>
    <?php $this->head() ?>
    <link rel="icon" type="image/png" href="<?= Yii::getAlias('@web').'/img/icon.png'?>">
</head>



<body class="skin-blue fixed" data-spy="scroll" data-target="#scrollspy">
<?php $this->beginBody() ?>
<!-- MODAL -->
<?php
    yii\bootstrap\Modal::begin(['id' =>'modal',
        //'size' => 'modal-lg',
        //'clientOptions' => ['backdrop' => 'static', 'keyboard' => FALSE]
    ]);
    yii\bootstrap\Modal::end();
?>

<div class="wrapper">
  <header class="main-header">
    <!-- Logo -->
    <a href="<?=Yii::$app->urlManager->createUrl('/')?>" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>Easy</b>Web</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>Easy</b>Web</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top" role="navigation">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle visible-xs-block" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- User Account: style can be found in dropdown.less -->
          <li><?= Html::a(Yii::t('app','Profile'), ['/admin-user/profileview']) ?></li>
          <li><?= Html::a(Yii::t('app','Logout').' ('.Yii::$app->user->identity->username.')', ['/site/logout']) ?></li>
        </ul>
      </div>
    </nav>
  </header>
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <?= $this->render('_menu');?>
    </section>
    <!-- /.sidebar -->
  </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <h1>
          <?= ($this->title)?>
        </h1>
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
      </section>
      <!-- Main content -->
      <div class="content">
          <?php echo Alert::widget() ?>
          <?= $content ?>
      </div>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <footer class="main-footer">
      <div class="row">
        <div class="col-xs-12 col-sm-7 col-md-8 col-lg-9">
          <strong>Copyright © 2021 All Rights Reserved</strong>
        </div>
        <div class="col-xs-12 col-sm-5 col-md-4 col-lg-3 text-right">
          Powered by <a href='http://www.efaith.hk/' target="_blank">eFaith Company Ltd.</a>
        </div>
      </div>
    </footer>

    <div class="control-sidebar-bg"></div>
  </div>
  <!-- ./wrapper -->

<?php $this->endBody() ?>

<script src="<?=Yii::getAlias("@web")?>/js/ajax-modal-popup.js"></script>

</body>
</html>
<?php $this->endPage() ?>
