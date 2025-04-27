<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\widgets\ActiveForm;
use kartik\select2\Select2;
use common\models\Definitions;

$this->title =  Yii::t('app','Admin Groups').' - '.(($model->isNewRecord)? Yii::t('app', 'Create'):Yii::t('app', 'Update'));

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Admin Groups'), 'url' => ['index']];
if (!$model->isNewRecord)
    $this->params['breadcrumbs'][] = $model->name;
$this->params['breadcrumbs'][] = (($model->isNewRecord)? Yii::t('app', 'Create'):Yii::t('app', 'Update'));

$this->registerJs(<<<JS
$('[type="checkbox"][name="AdminGroupForm[editMenu_update][]"]').change(function() {
    var _this_t = $(this).data('label');
    var _this_checked = $(this).is(':checked');
    $('[type="checkbox"][name="AdminGroupForm[editMenu_update][]"]')
        .not(this)
        .filter(function(){ return $(this).data('label').indexOf(_this_t) === 0; })
        .prop('checked', _this_checked)
        .prop('disabled', _this_checked);
});
$('[type="checkbox"][name="AdminGroupForm[editMenu_update][]"]:checked').change();
JS
);
?>
<br>
<div class="modal-content">
    <div class="modal-body">
        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'status')->dropDownList(Definitions::getStatus()); ?>

        <hr />

        <?= $form->field($model, 'name')->textInput(['maxlength' => true]); ?>

        <hr />

        <div class="form-group">
            <label class="control-label"><?= Yii::t('app', 'Can Manage {model}', ['model' => Yii::t('app', 'Model')]) ?></label>
            
            <div class="row">
                <div class="col-sm-3">
                    <?= $form->field($model, 'canManageUser')->checkbox(); ?>
                    <?= $form->field($model, 'canManageApplication')->checkbox(); ?>
                    <?= $form->field($model, 'canManageMark')->checkbox(); ?>
                    <?= $form->field($model, 'canManageVisit')->checkbox(); ?>
                    <?= $form->field($model, 'canManageRequestFile')->checkbox(); ?>
                    <?= $form->field($model, 'canManageResponseFile')->checkbox(); ?>
                    <?= $form->field($model, 'canManageApprove')->checkbox(); ?>
                    <?= $form->field($model, 'canManageAllocate')->checkbox(); ?>
                </div>
                <div class="col-sm-3">
                    <?= $form->field($model, 'canManageRental')->checkbox(); ?>
                    <?= $form->field($model, 'canManageAbout')->checkbox(); ?>
                    <?= $form->field($model, 'canManageProject')->checkbox(); ?>
                    <?= $form->field($model, 'canManageNewProject')->checkbox(); ?>
                </div>
                <div class="col-sm-3">
                    <?= $form->field($model, 'canManageHome')->checkbox(); ?>
                    <?= $form->field($model, 'canManageContactus')->checkbox(); ?>
                </div>
                <div class="col-sm-3">
                    <?= $form->field($model, 'canManageGeneral')->checkbox(); ?>
                    <?= $form->field($model, 'canManageMenu')->checkbox(); ?>
                    <?= $form->field($model, 'canManageAdmin')->checkbox(); ?>
                </div>
            </div>
        </div>

        <hr />

        <?= $form->field($model, 'editMenu_update')->checkboxList((Definitions::getParentMenuList()), [
            'item' => function($index, $label, $name, $checked, $value) {
                $label = Html::encode($label);
                return "<div class='checkbox'><label><input type='checkbox' name='{$name}' value='{$value}' data-index='{$index}' data-label='{$label}'".($checked?" checked":'')."> {$label}</label></div>";
            }
        ]); ?>

        <hr />

        <?= $form->field($model, 'adminUsers_update')->widget(Select2::classname(), [
                'data' => ArrayHelper::htmlEncode(Definitions::getAdminUser(false, true, true)),
                'options' => [
                    'multiple' => true
                ],
                'pluginOptions' => [
                ],
            ]); ?>

        <p>&nbsp;</p>

        <div class="form-group">
            <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div><!-- /.modal-content -->
