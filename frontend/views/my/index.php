<?php

/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;
use common\models\Config;

$model_general = common\models\General::findOne(1);

$this->title = Yii::t('app', "My Account");

// Yii::$app->params['page_header_title'] = Yii::t('app', 'LST Shop');
// Yii::$app->params['page_header_img'] = '/images/page_header_img-shop.jpg';

// Yii::$app->params['breadcrumbs'][] = ['label' => Yii::t('app', 'LST Shop'), 'url' => ['/shop']];
Yii::$app->params['breadcrumbs'][] = Yii::t('app', "My Account");

$this->registerJs(<<<JS
JS
);

?>
<?= $this->render('../layouts/_user_header') ?>
    <div class="page-my">
        <div class="content">
<?php if (false) { ?>
            <div class="">
                        <form class="form-horizontal">
                            <div class="form-group">
                                <label for="" class="col-sm-4 control-label"><?= Yii::t('app', 'Email') ?></label>
                                <div class="col-sm-8">
                                    <p class="form-control-static"><?= Html::encode(Yii::$app->user->identity->email) ?></p>
                                </div>
                            </div>
<?php if (Yii::$app->user->identity->oAuth_user == 0) { ?>
                            <div class="form-group">
                                <label for="" class="col-sm-4 control-label"><?= Yii::t('app', 'Password') ?></label>
                                <div class="col-sm-8">
                                    <p class="form-control-static">••••••••</p>
                                </div>
                            </div>
<?php } ?>
                        </form>
            </div>
<?php } ?>
        </div>
    </div>
