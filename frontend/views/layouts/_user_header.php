<?php

use yii\helpers\Html;
use common\models\Config;

if (Yii::$app->layout != "app") {
?>
<div class="row">
    <div class="col-xs-12">
        <div class="userHeader">
<?php if (Yii::$app->user->isGuest) { ?>
        <?php if (true) { ?>
            <ul>
            <?php if (false) { ?>
                <li><?= Html::a(Yii::t('app', 'Cart({num})', ['num' => Yii::$app->order->current->total_qty]), ['/cart']) ?></li>
            <?php } ?>
                <li><?= Html::a('客戶密碼登錄', ['/login']) ?></li>
            <?php if (false) { ?>
                <li><?= Html::a(Yii::t('app', 'Registration'), ['/registration']) ?></li>
            <?php } ?>
            <li><?= Html::a('一次性密碼登錄', ['/login-otp']) ?></li>
            </ul>
        <?php } ?>
<?php } else { ?>
        <?php if (false) { ?>
            <ul>
                <li><?= Yii::t('app', 'Hi, {name}!', ['name' => Yii::$app->user->identity->name]) ?></li>
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
                        <li><?= Html::a(Yii::t('app', 'My Information'), ['/my/account'])?></li>
                        <li><?= Html::a(Yii::t('app', 'Logout'), ['/logout']) ?></li>
                    </ul>
                </li>
            </ul>
        <?php } ?>
<?php } ?>
        </div>
    </div>
</div>
<?php } ?>