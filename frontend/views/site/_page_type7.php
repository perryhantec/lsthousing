<?php

use yii\helpers\Html;
use yii\helpers\Url;
use common\models\Config;

$models = common\models\PageType7::find()->where(['MID' => $MID, 'status' => 1])->orderBy(['seq' => SORT_ASC])->all();

$_last_title = null;
$i = 0;
$j = 0;
?>
<?= \newerton\fancybox3\FancyBox::widget([
		    'target' => '[data-fancybox]',
		    'config' => []
		]); ?>
<div class="pagetype7-content">
<?php

foreach ($models as $model) {
    if ($_last_title != $model->title) {
        if ($i++ != 0)
            echo '</div><p>&nbsp;</p>';
        echo '<h3>'.$model->title.'</h3><div class="row">';
        $j = 0;
    }

    echo '<div class="col-xs-6 col-sm-4 col-md-3">';
    echo '<div class="pagetype7-box">';
    echo $model->photo_thumbPath != null ? Html::a(Html::img($model->photo_thumbPath, []), $model->photo_path, ['data' => ['fancybox' => ""]]) : '';
    echo '<p>'.Yii::$app->formatter->asNtext($model->name).'</p>';
    echo '</div>';
    echo '</div>';

    if ($j++ > 0) {
        if ($j % 2 == 0)
            echo '<div class="clearfix visible-xs-block"></div>';
        if ($j % 3 == 0)
            echo '<div class="clearfix visible-sm-block"></div>';
        if ($j % 4 == 0)
            echo '<div class="clearfix visible-md-block visible-lg-block"></div>';
    }

    $_last_title = $model->title;
}

?>
</div>
</div>