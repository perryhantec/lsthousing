<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\widgets\ActiveForm;
use common\models\Definitions;

$this->title =  Yii::t('app','Admin Users').' - '.(($model->isNewRecord)? Yii::t('app', 'Create'):Yii::t('app', 'Update'));

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Admin Users'), 'url' => ['index']];
if (!$model->isNewRecord)
    $this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = (($model->isNewRecord)? Yii::t('app', 'Create'):Yii::t('app', 'Update'));
?>
<br>
<div class="modal-content">
    <div class="modal-body">
        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'status')->dropDownList(Definitions::getStatus()); ?>

        <hr />

        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

        <hr />

        <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'new_password')->textInput(['type'=>"password"]) ?>

        <?= $form->field($model, 'role')->dropDownList(Definitions::getAdminRole(false, Yii::$app->user->identity->role)); ?>

        <hr />

        <?= $form->field($model, 'adminGroups_update')->checkboxList(ArrayHelper::htmlEncode(Definitions::getAdminGroup())); ?>

        <p>&nbsp;</p>

        <div class="form-group">
            <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div><!-- /.modal-content -->
