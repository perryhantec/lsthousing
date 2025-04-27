<?php

use yii\helpers\Html;
use common\models\Config;
use common\models\PageType10;
use branchonline\lightbox\Lightbox;

$model = \common\models\PageType10::findOne(['MID'=>$MID]);

?>
<?= PageType10::HAVE_TITLE && (isset($model->title) && $model->title != "") ? Html::tag('h3', Html::encode($model->title)) : '' ?>
<?php if (isset($model->top_youtubes) && sizeof($model->top_youtubes) > 0) { ?>
    <div class="page-top_youtube">
        <div class="youtube-box">
            <?= Html::tag('iframe', '', [
                    'src' => "https://www.youtube.com/embed/".$model->top_youtubes[0]['id']."?modestbranding=0&rel=0&showinfo=0",
                    'frameborder' => 0,
                    'allow' => 'accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture',
                    'allowfullscreen' => true,
                    'data' => [
                        'id' => $model->top_youtubes[0]['id'],
                        'title' => $model->top_youtubes[0]['title']
                    ]
                ])
            ?>
        </div>
        <div class="row">
<?php for ($num=1; $num<sizeof($model->top_youtubes); $num++) { ?>
            <div class="col-sm-4">
                <?= Html::a(('<img class="page-top_youtube-thumb" src="http://img.youtube.com/vi/'.$model->top_youtubes[$num]['id'].'/maxresdefault.jpg"><div class="page-top_youtube-title">'.Html::encode($model->top_youtubes[$num]['title']).'</div>'), 'https://youtu.be/'.$model->top_youtubes[$num]['id'], [
                        'target' => '_blank',
                        'data' => [
                            'id' => $model->top_youtubes[$num]['id'],
                            'title' => $model->top_youtubes[$num]['title']
                        ]
                    ]) ?>
            </div>
<?php } ?>
        </div>
    </div>
    <hr />
<?php } ?>
<?= $model == NULL || $model->content == "" ? Yii::t('app', '<i>Coming Soon</i>') : $model->content ?>

<?php if (isset($model->picture_file_names) && sizeof($model->picture_file_names) > 0) { ?>
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