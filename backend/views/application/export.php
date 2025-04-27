<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\web\View;
use yii\web\JsExpression;
use kartik\widgets\ActiveForm;
use kartik\widgets\DatePicker;

$this->title = '批核清單 - '.Yii::t('app', 'Export');

$this->params['breadcrumbs'][] = ['label' => '批核清單', 'url' => ['index']];
$this->params['breadcrumbs'][] = Yii::t('app', 'Export');

?>
<div class="online-donation-export">
<?php $form = ActiveForm::begin(); ?>

<?php if ($pageType == 'popup') { ?>
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><?= $this->title ?></h4>
    </div>
<?php } else if ($pageType == 'page') { ?>
    <div class="modal-content">
<?php } ?>
        <div class="modal-body">

            <?= $form->field($model, 'month')->widget(DatePicker::classname(), [
                'options' => [],
                'type' => 3,
                'removeButton' => false,
                'pluginOptions' => [
                    'autoclose' => true,
                    'format' => 'yyyy-mm',
                    'weekStart' => 0,
        //            'startDate' => date('Y-m-d'),
                    'minViewMode' => "months",
                ]
            ]) ?>

<?php if ($pageType == 'popup') { ?>
            <br />

            <p>
                <?= Html::submitButton(Yii::t('app', 'Submit'), ['class' => 'btn btn-primary']) ?>
            </p>

        </div>
<?php } else if ($pageType == 'page') { ?>
        </div>
    </div>

    <br />

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Submit'), ['class' => 'btn btn-primary']) ?>
    </div>

<?php } ?>

<?php ActiveForm::end(); ?>

</div>