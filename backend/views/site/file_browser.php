<?php

use yii\helpers\Html;
use mihaildev\elfinder\ElFinder;

$this->title = Yii::t('app', 'File Browser');

?>

<div class="site-file-broswer">
<?php
    echo ElFinder::widget([
//         'language' => 'zh_TW',
        'controller' => 'elfinder',
        'containerOptions' => [
            'class' => 'site-file-browser-elfinder',
            'style' => 'height: 600px',
        ]
    ]);
?>
</div>
