<?php

use yii\helpers\Html;
use yii\helpers\Url;
use common\models\Config;

$basename = basename(\yii\helpers\Url::current());
$basename_temp = explode("?", $basename);
$current_route = $basename_temp[0];

$models = common\models\PageType8::find()->where(['MID' => $MID, 'status' => 1])->andWhere(['<=', 'date', date('Y-m-d')])->andWhere(['>=', 'applicationDeadline', date('Y-m-d')])->orderBy(['updated_at' => SORT_DESC])->all();

$_last_title = null;
$i = 0;
$j = 0;
?>
<div class="pagetype8-content">
    <h3><?= $title ?></h3>
<?php if (Yii::$app->language == 'en') { ?>
    <p>Lok Sin Tong focuses on equal employment opportunities. It ensures that all employees are recruited, trained, promoted and transferred according to their work abilities, skills and performance. They are not based on gender, age and pregnancy. Factors such as disability, marriage or family status and religious background.</p>
    <p>Lok Sin Tong provides excellent environment to persons who want to develop their career in serving the community. We are not only an equal opportunity employer, through our expansion in different service areas, we also offer development opportunities to our staff.</p>

<?php } else { ?>
    <p>樂善堂是注重平等就業機會的機構，確保所有員工的聘用，乃根據他們工作相關工作才能、技巧及表現而作出甄選、培訓、升職及調職安排等，並不會基於性別、年齡、懷孕、殘疾、婚姻或家庭崗位狀況和宗教背景等因素考慮。</p>
    <p>樂善堂提供發展事業的理想環境及進升機會給有意加入的人士服務社群。請瀏覽就業機會的職位資料，看看是否有適合你的職位。</p>

<?php } ?>

<div class="table-responsive">
    <table class="table">
        <thead>
            <tr>
                <th class="text-nowrap"><?= Yii::t('job-opportunity', 'Date') ?></th>
                <th class="text-nowrap"><?= Yii::t('job-opportunity', 'Service<br>Unit') ?></th>
                <th class="text-nowrap"><?= Yii::t('job-opportunity', 'Position') ?></th>
                <th class="text-nowrap"><?= Yii::t('job-opportunity', 'Ref') ?></th>
                <th class="text-nowrap"><?= Yii::t('job-opportunity', 'Application<br>Deadline') ?></th>
                <th class="text-nowrap"><?= Yii::t('job-opportunity', 'Detail') ?></th>
            </tr>
        </thead>
        <tbody>
<?php

foreach ($models as $model) {
    echo '<tr>';
    echo '<td class="text-nowrap">'.Yii::$app->formatter->asDate($model->date, 'long').'</td>';
    echo '<td>'.Html::encode($model->serviceUnit).'</td>';
    echo '<td>'.Html::encode($model->post).'</td>';
    echo '<td>'.Html::encode($model->ref).'</td>';
    echo '<td class="text-nowrap">'.Yii::$app->formatter->asDate($model->applicationDeadline, 'long').'</td>';
    echo '<td>'.Html::a(Yii::t('job-opportunity', 'Detail'), [($current_route.'/job'), 'id' => $model->id, 't' => strtotime($model->applicationDeadline)], ['data' => ['fancybox' => '', 'type' => 'ajax']]).'</td>';
    echo '</tr>';
}

?>
        </tbody>
    </table>
</div>
</div>