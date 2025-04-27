<?php

use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\helpers\StringHelper;
use common\util\Html;
use common\models\Content;
use common\models\Configuration;
use kartik\icons\Icon;
use common\models\General;
use common\models\ContactUs;

/* @var $this \yii\web\View */
$model_general = General::findOne(1);
$model_contactus = ContactUs::findOne(1);

$this->registerJs(<<<JS
    $(window).scroll(function () {
        if ($(this).scrollTop() > 50) {
            $('#fix-back-to-top').fadeIn();
        } else {
            $('#fix-back-to-top').fadeOut();
        }
    });
    // scroll body to 0px on click
    $('#fix-back-to-top').click(function () {
        $('#fix-back-to-top').tooltip('hide');
        $('body,html').animate({
            scrollTop: 0
        }, 800);
        return false;
    });

JS
);

?>
<footer class="footer mt-auto">
    <div class="container">
        <div class="pull-left"><?= $model_general->copyright_notice ?></div>
        <div class="pull-right"><?= $model_general->copyright ?></div>
    </div>
</footer>
<a id="fix-back-to-top" href="#" class="btn btn-primary btn-lg fix-back-to-top" role="button" style="display:none;"><span class="glyphicon glyphicon-chevron-up"></span></a>
