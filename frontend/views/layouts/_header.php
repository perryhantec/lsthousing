<?php

use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\bootstrap\NavBar;
use yii\bootstrap\Carousel;
use yii\bootstrap\ActiveForm;
use kartik\nav\NavX;
use common\util\Html;
use common\models\ContactUs;

$contact_model = ContactUs::findOne(1);
?>
<style>
.header-right-topBar-left {background:#e2665c;vertical-align:top;margin:1em 0 0;}
header .header-right-topBar .header-right-topBar-left, header .header-right-topBar .header-right-topBar-right {
    padding: 10px 15px 11px 15px;
}
header .header-right-topBar-left img {
    height: 15px;
}
.xs-header .navbar-header {
    background: #e2665c;
}
</style>
<header>
    <div class="container hidden-xs">
        <div class="header-nav-top">
            <div class="header-row">
                <div class="header-logo">
                    <?= Html::a(Html::img(Yii::getAlias('@web').'/images/housing_logo.jpg', ['class' => 'header-logo-img']), ['/'], ['class' => 'visible-md-inline visible-lg-inline']) ?>
                </div>

                <div class="header-logo" style="margin-left:40px;">
                    <?= Html::a(Html::img(Yii::getAlias('@web').'/images/loksintong_logo.jpg', ['class' => 'header-logo-img']), 'https://www.loksintong.org/', ['class' => 'visible-md-inline visible-lg-inline', 'target' => '_blank']) ?>
                </div>

                <div class="header-right">
                    <div class="header-right-topBar">
                        <div class="header-right-topBar-left">
                            <?= $contact_model->email != "" ? Html::a(Html::img(Yii::getAlias('@web').'/images/header-right-topBar-mail.png'), ('mailto:'.$contact_model->email), ['class' => '']) : '' ?>
                            <?= $contact_model->facebook != "" ? Html::a(Html::img(Yii::getAlias('@web').'/images/header-right-topBar-fb.png'), $contact_model->facebook, ['class' => '', 'target' => '_blank']) : '' ?>
                            <?= $contact_model->instagram != "" ? Html::a(Html::img(Yii::getAlias('@web').'/images/header-right-topBar-ig.png'), $contact_model->instagram, ['class' => '', 'target' => '_blank']) : '' ?>
                            <?= $contact_model->twitter != "" ? Html::a(Html::img(Yii::getAlias('@web').'/images/header-right-topBar-twitter.png'), $contact_model->twitter, ['class' => '', 'target' => '_blank']) : '' ?>
                            <?= $contact_model->youtube != "" ? Html::a(Html::img(Yii::getAlias('@web').'/images/header-right-topBar-youtube.png'), $contact_model->youtube, ['class' => '', 'target' => '_blank']) : '' ?>
                        </div>
                        <div class="header-right-topBar-right flex-list userHeader">
<?php if (Yii::$app->user->isGuest) { ?>
            <ul>
            <?php if (false) { ?>
                <li><?= Html::a(Yii::t('app', 'Cart({num})', ['num' => Yii::$app->order->current->total_qty]), ['/cart']) ?></li>
            <?php } ?>
                <li><?= Html::a(Yii::t('app', 'Login'), ['/login']) ?></li>
            <?php if (false) { ?>
                <li><?= Html::a(Yii::t('app', 'Registration'), ['/registration']) ?></li>
            <?php } ?>
                <li><?= Html::a('會員註冊', ['/registration']) ?></li>
            </ul>
<?php } else { ?>
        <!-- <div class="userHeader"> -->
            <ul>
                <li><?= Yii::t('app', 'Hi, {name}!', ['name' => Yii::$app->user->identity->chi_name]) ?></li>
                <!-- <li><?= Html::a(Yii::t('app', 'My Information'), ['/my/account'])?></li>
                <li><?= Html::a(Yii::t('app', 'Logout'), ['/logout']) ?></li> -->

            <?php if (false) { ?>
                <li><?= Html::a(Yii::t('app', 'Cart({num})', ['num' => Yii::$app->order->current->total_qty]), ['/cart']) ?></li>
            <?php } ?>
                <li>
                    <?= Html::a(Yii::t('app', 'My Account'), 'javascript:void(0)') ?>
                    <ul>
                    <?php if (false) { ?>
                        <li><?= Html::a(Yii::t('app', 'My Orders'), ['/my/orders'])?></li>
                        <li><?= Html::a(Yii::t('app', 'My Addresses'), ['/my/addresses'])?></li>
                    <?php } ?>
                        <!-- <li><?= Html::a('我的申請', ['/my/application'])?></li> -->
                        <li><?= Html::a(Yii::t('app', 'My Information'), ['/my/account'])?></li>
                        <!-- <li><?= Html::a('詳細資料', ['/my/detail'])?></li>
                        <li><?= Html::a('上載文件', ['/my/upload'])?></li> -->
                        <li><?= Html::a(Yii::t('app', 'Logout'), ['/logout']) ?></li>
                    </ul>
                </li>
            </ul>
        <!-- </div> -->
<?php } ?>
                        </div>
                        <div>
                            <?= Html::a(Html::img(Yii::getAlias('@web').'/images/search.jpg', ['class' => 'header-logo-img']), ['/search'], ['class' => 'visible-md-inline visible-lg-inline', 'style'=>'padding:0;margin:0;']) ?>
                        </div>
                        <!-- <div style="color:#cbcbcb;position:relative;">
                            <form>
                                <input type="text" placeholder="搜尋">
                                <div style="position:absolute;top:2px;right:10px;font-size:20px;">
                                    <i class="fa fa-search"></i>
                                </div>
                            </form>
                        </div> -->
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="header-nav hidden-xs">
        <?php NavBar::begin(['brandLabel' => '']); ?>
        <?= NavX::widget([
                'options' => ['class' => 'navbar-nav'],
                'items' => $nav_items,
                'activateParents' => false,
                'encodeLabels' => false
            ]); ?>
        <?php NavBar::end(); ?>
    </div>

    <div class="xs-header visible-xs-block">
        <div class="xs-header-top visible-xs-block">
            <div class="row">
                <div class="pull-left">
                    <?= Html::a(Html::img(Yii::getAlias('@web').'/images/housing_logo.jpg', ['class' => 'xs-header-logo-img', 'style' => 'max-height:70px;']), ['/'], ['class' => '']) ?>
                    <?= Html::a(Html::img(Yii::getAlias('@web').'/images/loksintong_logo.jpg', ['class' => 'xs-header-logo-img', 'style' => 'max-height:70px;']), 'https://loksintong.org', ['class' => '', 'style' => 'margin-left:15px;', 'target' => '_blank']) ?>
                </div>
                <div class="pull-right">
                <?php if (Yii::$app->user->isGuest) { ?>
                    <?= Html::a(Yii::t('app', 'Login'), ['/login'], ['class' => strpos($this->title,Yii::t('app', 'Login')) !== false ? 'active' : ''])
                       .Html::a(Yii::t('app', 'Registration'), ['/registration'], ['class' => strpos($this->title,Yii::t('app', 'Registration')) !== false ? 'active' : '', 'style' => 'margin-left:15px;']);
                    ?>
                <?php } else { ?>
                    <?= Html::a(Yii::t('app', 'My Information'), ['/my/account'], ['class' => strpos($this->title,Yii::t('app', 'My Information').' - '.Yii::t('app', "My Account")) !== false ? 'active' : ''])
                       .Html::a(Yii::t('app', 'Logout'), ['/logout'], ['class' => [], 'style' => 'margin-left:15px;']);
                    ?>
                <?php } ?>
                </div>
            </div>
        </div>

    <?php 
/*
        if (Yii::$app->user->isGuest) {
            $header_right = 
                Html::a(Yii::t('app', 'Login'), ['/login'], ['class' => strpos($this->title,Yii::t('app', 'Login')) !== false ? 'active' : ''])
                .Html::a(Yii::t('app', 'Registration'), ['/registration'], ['class' => strpos($this->title,Yii::t('app', 'Registration')) !== false ? 'active' : '']);
        } else {
            $header_right = 
                Html::a(Yii::t('app', 'My Information'), ['/my/account'], ['class' => strpos($this->title,Yii::t('app', 'My Information').' - '.Yii::t('app', "My Account")) !== false ? 'active' : ''])
                .Html::a(Yii::t('app', 'Logout'), ['/logout'], ['class' => []]);
        }
*/
        $contact_email = $contact_model->email != "" ? Html::a(Html::img(Yii::getAlias('@web').'/images/header-right-topBar-mail.png'), ('mailto:'.$contact_model->email), ['class' => '']) : '';
        $contact_facebook = $contact_model->facebook != "" ? Html::a(Html::img(Yii::getAlias('@web').'/images/header-right-topBar-fb.png'), $contact_model->facebook, ['class' => '', 'target' => '_blank']) : '';
        $contact_instagram = $contact_model->instagram != "" ? Html::a(Html::img(Yii::getAlias('@web').'/images/header-right-topBar-ig.png'), $contact_model->instagram, ['class' => '', 'target' => '_blank']) : '';
        $contact_twitter = $contact_model->twitter != "" ? Html::a(Html::img(Yii::getAlias('@web').'/images/header-right-topBar-twitter.png'), $contact_model->twitter, ['class' => '', 'target' => '_blank']) : '';
        $contact_youtube = $contact_model->youtube != "" ? Html::a(Html::img(Yii::getAlias('@web').'/images/header-right-topBar-youtube.png'), $contact_model->youtube, ['class' => '', 'target' => '_blank']) : '';

        $header_right = '';
        NavBar::begin(['headerContent' => (
            '<div class="xs-header-subNav" style="text-align:left;margin-left:15px;">'
                .$header_right
                .Html::a(Html::img(strpos($this->title,Yii::t('app', 'Search')) !== false ? Yii::getAlias('@web').'/images/search_icon.png': Yii::getAlias('@web').'/images/search_icon.png'), ['/search'], ['class' => strpos($this->title,Yii::t('app', 'Search')) !== false ? 'active' : ''])
                .$contact_email
                .$contact_facebook
                .$contact_instagram
                .$contact_twitter
                .$contact_youtube
            .'</div>')]);?>
            <?= NavX::widget([
                'options' => ['class' => 'navbar-nav'],
                'items' => $xs_nav_items,
                // 'dropDownCaret' => "",
                'activateParents' => false,
                'encodeLabels' => false
            ]); ?>
        <?php NavBar::end(); ?>
    </div>
</header>