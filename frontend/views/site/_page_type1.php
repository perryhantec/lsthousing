<?php

use yii\helpers\Html;
use common\models\Config;
use common\models\PageType1;
use branchonline\lightbox\Lightbox;

$model = \common\models\PageType1::findOne(['MID'=>$MID]);

?>
<?php if ($model == NULL || $model->content == "") { ?>
    <?= Yii::t('app', '<i>Coming Soon</i>') ?>
    
<?php } else { ?>
    <?= $model->content ?>
    
    <?php if (sizeof($model->picture_file_names) > 0) { ?>
    <?= \newerton\fancybox3\FancyBox::widget([
    		    'target' => '[data-fancybox]',
    		    'config' => []
    		]); ?>
    <div class="page-images">
        <div class="row">
    <?php
        $i = 0;
    
        foreach($model->picture_file_names as $file_name => $file_description) {
            if ($i++ % 2 == 0)
                echo '<div class="clearfix"></div>';
            echo '<div class="col-sm-6"><p class="text-center">';
            echo Html::a(Html::img($model->fileThumbDisplayPath.$file_name), $model->fileDisplayPath.$file_name, ['data' => ['fancybox' => "pageImages", 'caption' => $file_description]]);
            echo '</p></div>';
        }
        ?>
        </div>
    </div>
    <?php } ?>
<?php } ?>