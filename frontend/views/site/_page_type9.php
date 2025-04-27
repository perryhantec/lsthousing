<?php

use yii\helpers\Html;
use yii\helpers\Url;
use common\models\Config;

$basename = basename(\yii\helpers\Url::current());
$basename_temp = explode("?", $basename);
$current_route = $basename_temp[0];

$models = common\models\PageType9::find()->where(['MID' => $MID, 'status' => 1])->andWhere(['<=', 'date', date('Y-m-d')])->andWhere(['>', 'due_at', date('Y-m-d H:i:s')])->orderBy(['num' => SORT_DESC, 'id' => SORT_DESC])->all();

$_last_title = null;
$i = 0;
$j = 0;

?>
<div class="pagetype9-content">
    <h3><?= $title ?></h3>

<p class="text-right">
    <?= Html::a(Yii::t('tender-notice', 'Supplier Registration (LST e-Tendering Website)'), 'https://loksintong.e-tendering.com', ['target' => '_blank']) /* Html::a(Yii::t('tender-notice', 'Supplier Registration'), ['/content/files/Supplier_Registration_Form.pdf'], ['target' => '_blank']) */ ?><br />
    <?= Html::a(Yii::t('tender-notice', 'Download Declaration of Conflict of Interest'), ['/content/files/Declaration_of_Conflict_of_Interest.pdf'], ['target' => '_blank']) ?>
</p>

<div class="table-responsive">
    <table class="table">
        <thead>
            <tr>
                <th><?= Yii::t('tender-notice', 'Date') ?></th>
                <th><?= Yii::t('tender-notice', 'Tender No.') ?></th>
                <th><?= Yii::t('tender-notice', 'Tender Subject') ?></th>
                <th class="text-nowrap"><?= Yii::t('job-opportunity', 'Detail') ?></th>
            </tr>
        </thead>
        <tbody>
<?php

foreach ($models as $model) {
    echo '<tr>';
    echo '<td class="text-nowrap">'.Yii::$app->formatter->asDate($model->date, 'long').'</td>';
    echo '<td class="text-nowrap">'.Html::encode($model->num).'</td>';
    echo '<td>'.Html::encode($model->title).'</td>';
    echo '<td class="text-nowrap">'.Html::a(Yii::t('tender-notice', 'Detail'), [($current_route.'/tender'), 'id' => $model->id, 't' => strtotime($model->due_at)], ['data' => ['fancybox' => '', 'type' => 'ajax']]).'</td>';
    echo '</tr>';
}

?>
        </tbody>
    </table>
</div>
</div>