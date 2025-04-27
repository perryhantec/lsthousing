<?php

use yii\widgets\Breadcrumbs;
use yii\helpers\Html;
use yii\helpers\Url;

Yii::$app->params['page_header_title'] = Yii::t('app', 'Search');
$this->title = Yii::t('app', 'Search');

Yii::$app->params['breadcrumbs'][] = strip_tags($this->title);

Yii::$app->params['page_route'] = 'search';

?>
    <div class="content">
        <div class="page-header">
            <div class="headline">
                <h3 class="title"><?= $this->title ?></h3>
            </div>
        </div>
        <script>
          (function() {
            var cx = '000833149445710227786:nd2c_d8szwc';
            var gcse = document.createElement('script');
            gcse.type = 'text/javascript';
            gcse.async = true;
            gcse.src = 'https://cse.google.com/cse.js?cx=' + cx;
            var s = document.getElementsByTagName('script')[0];
            s.parentNode.insertBefore(gcse, s);
          })();
        </script>
        <gcse:search></gcse:search>
    </div>
