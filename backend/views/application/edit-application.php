<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use mihaildev\elfinder\InputFile;
use common\models\Definitions;

$this->title =  '申請表 - '.(($model->isNewRecord)? Yii::t('app', 'Create'):Yii::t('app', 'Update'));

$this->params['breadcrumbs'][] = ['label' => '申請表', 'url' => ['index']];
if (!$model->isNewRecord)
    $this->params['breadcrumbs'][] = ['label' => $model->appl_no, 'url' => ['update', 'id' => $model->id]];
$this->params['breadcrumbs'][] = (($model->isNewRecord)? Yii::t('app', 'Create'):Yii::t('app', 'Update'));
?>
<br>
 <div class="modal-content">
   <div class="modal-body">
   <?php $form = ActiveForm::begin(); ?>
   <div class="box-tools pull-right">
        <?=  Html::a('申請表詳細', ['application/view', 'id' => $model->id], ['class' => 'btn btn-sm btn-info pull-right']) ?>
    </div>

     <section>
        <h2><strong><u>第一部份 申請人資料</u></strong></h2>
        <?= $form->errorSummary($model) ?>
        <?= $form->field($model, 'application_no')->textInput(['value' => $model->appl_no,'disabled' => true]) ?>
        <?= $form->field($model, 'priority_1')->dropdownList(Definitions::getProjectName(),['prompt'=>Yii::t('app', 'Please Select')]); ?>
        <?= $form->field($model, 'priority_2')->dropdownList(Definitions::getProjectName(),['prompt'=>Yii::t('app', 'Please Select')]); ?>
        <?= $form->field($model, 'priority_3')->dropdownList(Definitions::getProjectName(),['prompt'=>Yii::t('app', 'Please Select')]); ?>
        <?= $form->field($model, 'chi_name')->textInput(); ?>
        <?= $form->field($model, 'eng_name')->textInput(); ?>
        <?= $form->field($model, 'phone')->textInput(['type' => 'tel','placeholder' => '請輸入8個數字']); ?>
        <?= $form->field($model, 'mobile')->textInput(['type' => 'tel','placeholder' => '請輸入8個數字']); ?>
        <?= $form->field($model, 'address')->textArea(['rows' => 3]); ?>
        <?= $form->field($model, 'area')->textInput(['placeholder' => '平方呎']); ?>
        <?= $form->field($model, 'email')->textInput(['type' => 'email']); ?>
        <?= $form->field($model, 'house_type')->dropdownList(Definitions::getHouseType(),['prompt'=>Yii::t('app', 'Please Select'),'id' => 'house_type']); ?>
        <?= $form->field($model, 'house_type_other')->textInput(['id' => 'house_type_other']); ?>
        <?= $form->field($model, 'private_type')->dropdownList(Definitions::getPrivateType(),['prompt'=>Yii::t('app', 'Please Select'),'id' => 'private_type']); ?>
        <?= $form->field($model, 'together_type')->dropdownList(Definitions::getTogetherType(),['prompt'=>Yii::t('app', 'Please Select'),'id' => 'together_type']); ?>
        <?= $form->field($model, 'together_type_other')->textInput(['id' => 'together_type_other']); ?>
        <?= $form->field($model, 'live_rent')->textInput(['type' => 'number','step' => '0.01','placeholder' => '港幣$，可輸入小數位']); ?>
        <?php
        // = $form->field($model, 'live_year')->textInput(['type' => 'number','step' => '0.01','placeholder' => '以年為單位，可輸入小數位']);
        ?>
        <?= $form->field($model, 'live_year')->dropdownList(Definitions::getLiveYear(),['prompt'=>Yii::t('app', 'Please Select')]); ?>
        <?= $form->field($model, 'live_month')->dropdownList(Definitions::getLiveMonth(),['prompt'=>Yii::t('app', 'Please Select')]); ?>
        <?= $form->field($model, 'family_member')->textInput(['type' => 'number','placeholder' => '請輸入人數（包括申請人在內）']); ?>
        <?= $form->field($model, 'prh')->radioList(Definitions::getPrh(),['id' => 'prh']); ?>
        <?= $form->field($model, 'prh_no')->textInput(['placeholder' => '例: U-9999999-9 (G-1422505-G-1423543)','id' => 'prh_no']); ?>
        <?= $form->field($model, 'prh_location')->dropdownList(Definitions::getPrhLocation(),['prompt'=>Yii::t('app', 'Please Select'),'id' => 'prh_location']); ?>
        <?= $form->field($model, 'apply_prh_year')->textInput(['type' => 'number','placeholder' => '請輸入年份','id' => 'apply_prh_year']); ?>
        <?= $form->field($model, 'apply_prh_month')->textInput(['type' => 'number','placeholder' => '請輸入月份','id' => 'apply_prh_month']); ?>
        <?= $form->field($model, 'apply_prh_day')->textInput(['type' => 'number','placeholder' => '請輸入月份','id' => 'apply_prh_day']); ?>
    </section>
    <hr />

    <section>
        <h2><strong><u>第二部份 家庭成員資料 及 第三部份 入息及資產淨值</u></strong></h2>
        <div>
            <h3><em>申請人</em></h3>
            <?= $form->field($model, 'app_chi_name')->textInput(['value' => '同上','disabled' => true]); ?>
            <?= $form->field($model, 'app_eng_name')->textInput(['value' => '同上','disabled' => true]); ?>
            <?= $form->field($model, 'app_gender')->radioList(Definitions::getGender()); ?>
            <?= $form->field($model, 'app_born_date')->textInput(['placeholder' => '日/月/年']); ?>
            <?php
            // = $form->field($model, 'app_born_type')->dropdownList(Definitions::getBornType(),['prompt'=>Yii::t('app', 'Please Select')]);
            ?>
            <?= $form->field($model, 'app_id_type')->dropdownList(Definitions::getIdType(),['prompt'=>Yii::t('app', 'Please Select')]); ?>
            <?= $form->field($model, 'app_id_no')->textInput(); ?>
            <?= $form->field($model, 'app_relationship')->textInput(['value' => '不適用','disabled' => true]); ?>
            <?= $form->field($model, 'app_marriage_status')->dropdownList(Definitions::getMarriageStatus(),['prompt'=>Yii::t('app', 'Please Select')]); ?>
            <?= $form->field($model, 'app_chronic_patient')->textArea(['rows' => 3]); ?>
            <?php /*= $form->field($model, 'app_special_study')->checkbox(['disabled' => true]);*/ ?>
            <?= $form->field($model, 'app_working_status')->dropdownList(Definitions::getWorkingStatus(),['prompt'=>Yii::t('app', 'Please Select')]); ?>
            <?= $form->field($model, 'app_career')->textInput(); ?>
            <?= $form->field($model, 'app_income')->textInput(['type' => 'number','step' => '0.01','placeholder' => '$，可輸入小數位']); ?>
            <?= $form->field($model, 'app_funding_type')->checkboxList(Definitions::getFundingType()); ?>
            <?= $form->field($model, 'app_funding_value')->textInput(['type' => 'number','step' => '0.01','placeholder' => '$，可輸入小數位']); ?>
            <?= $form->field($model, 'app_asset')->radioList(Definitions::getAsset()); ?>
            <?= $form->field($model, 'app_asset_type')->textInput(); ?>
            <?= $form->field($model, 'app_asset_value')->textInput(['type' => 'number','step' => '0.01','placeholder' => '$，可輸入小數位']); ?>
            <?= $form->field($model, 'app_deposit')->textInput(['type' => 'number','step' => '0.01','placeholder' => '$，可輸入小數位']); ?>
        </div>
        <hr />

        <div class="family-member">
            <?php 
                if ($model->family_member >= 2) {
                    $m1_btn_symbol = 'minus';
                    $m1_class = 'in';
                } else {
                    $m1_btn_symbol = 'plus';
                    $m1_class = '';
                }
            ?>
            <h3>
                <em>家庭成員 1 </em>
                <button type="button" data-toggle="collapse" data-target="#m1" onclick='toggleIcon(this);'><i class="fa fa-<?= $m1_btn_symbol ?>"></i></button>
            </h3>

            <div id="m1" class="collapse <?= $m1_class ?>">
                <?= $form->field($model, 'm1_chi_name')->textInput(); ?>
                <?= $form->field($model, 'm1_eng_name')->textInput(); ?>
                <?= $form->field($model, 'm1_gender')->radioList(Definitions::getGender()); ?>
                <?= $form->field($model, 'm1_born_date')->textInput(['placeholder' => '日/月/年']); ?>
                <?php
                // = $form->field($model, 'm1_born_type')->dropdownList(Definitions::getBornType(),['prompt'=>Yii::t('app', 'Please Select')]);
                ?>
                <?= $form->field($model, 'm1_id_type')->dropdownList(Definitions::getIdType(),['prompt'=>Yii::t('app', 'Please Select')]); ?>
                <?= $form->field($model, 'm1_id_no')->textInput(); ?>
                <?= $form->field($model, 'm1_relationship')->textInput(); ?>
                <?= $form->field($model, 'm1_marriage_status')->dropdownList(Definitions::getMarriageStatus(),['prompt'=>Yii::t('app', 'Please Select')]); ?>
                <?= $form->field($model, 'm1_chronic_patient')->textArea(['rows' => 3]); ?>
                <?= $form->field($model, 'm1_special_study')->checkbox(); ?>
                <?= $form->field($model, 'm1_working_status')->dropdownList(Definitions::getWorkingStatus(),['prompt'=>Yii::t('app', 'Please Select')]); ?>
                <?= $form->field($model, 'm1_career')->textInput(); ?>
                <?= $form->field($model, 'm1_income')->textInput(['type' => 'number','step' => '0.01','placeholder' => '$，可輸入小數位']); ?>
                <?= $form->field($model, 'm1_funding_type')->checkboxList(Definitions::getFundingType()); ?>
                <?= $form->field($model, 'm1_funding_value')->textInput(['type' => 'number','step' => '0.01','placeholder' => '$， 可輸入小數位']); ?>
                <?= $form->field($model, 'm1_asset')->radioList(Definitions::getAsset()); ?>
                <?= $form->field($model, 'm1_asset_type')->textInput(); ?>
                <?= $form->field($model, 'm1_asset_value')->textInput(['type' => 'number','step' => '0.01','placeholder' => '$，可輸入小數位']); ?>
                <?= $form->field($model, 'm1_deposit')->textInput(['type' => 'number','step' => '0.01','placeholder' => '$，可輸入小數位']); ?>
            </div>
            <hr />
            <?php 
                if ($model->family_member >= 3) {
                    $m2_btn_symbol = 'minus';
                    $m2_class = 'in';
                } else {
                    $m2_btn_symbol = 'plus';
                    $m2_class = '';
                }
            ?>
            <h3>
                <em>家庭成員 2 </em>
                <button type="button" data-toggle="collapse" data-target="#m2" onclick='toggleIcon(this);'><i class="fa fa-<?= $m2_btn_symbol ?>"></i></button>
            </h3>

            <div id="m2" class="collapse <?= $m2_class ?>">
                <?= $form->field($model, 'm2_chi_name')->textInput(); ?>
                <?= $form->field($model, 'm2_eng_name')->textInput(); ?>
                <?= $form->field($model, 'm2_gender')->radioList(Definitions::getGender()); ?>
                <?= $form->field($model, 'm2_born_date')->textInput(['placeholder' => '日/月/年']); ?>
                <?php
                // = $form->field($model, 'm2_born_type')->dropdownList(Definitions::getBornType(),['prompt'=>Yii::t('app', 'Please Select')]);
                ?>
                <?= $form->field($model, 'm2_id_type')->dropdownList(Definitions::getIdType(),['prompt'=>Yii::t('app', 'Please Select')]); ?>
                <?= $form->field($model, 'm2_id_no')->textInput(); ?>
                <?= $form->field($model, 'm2_relationship')->textInput(); ?>
                <?= $form->field($model, 'm2_marriage_status')->dropdownList(Definitions::getMarriageStatus(),['prompt'=>Yii::t('app', 'Please Select')]); ?>
                <?= $form->field($model, 'm2_chronic_patient')->textArea(['rows' => 3]); ?>
                <?= $form->field($model, 'm2_special_study')->checkbox(); ?>
                <?= $form->field($model, 'm2_working_status')->dropdownList(Definitions::getWorkingStatus(),['prompt'=>Yii::t('app', 'Please Select')]); ?>
                <?= $form->field($model, 'm2_career')->textInput(); ?>
                <?= $form->field($model, 'm2_income')->textInput(['type' => 'number','step' => '0.01','placeholder' => '$，可輸入小數位']); ?>
                <?= $form->field($model, 'm2_funding_type')->checkboxList(Definitions::getFundingType()); ?>
                <?= $form->field($model, 'm2_funding_value')->textInput(['type' => 'number','step' => '0.01','placeholder' => '$， 可輸入小數位']); ?>
                <?= $form->field($model, 'm2_asset')->radioList(Definitions::getAsset()); ?>
                <?= $form->field($model, 'm2_asset_type')->textInput(); ?>
                <?= $form->field($model, 'm2_asset_value')->textInput(['type' => 'number','step' => '0.01','placeholder' => '$，可輸入小數位']); ?>
                <?= $form->field($model, 'm2_deposit')->textInput(['type' => 'number','step' => '0.01','placeholder' => '$，可輸入小數位']); ?>
            </div>
            <hr />
            <?php 
                if ($model->family_member >= 4) {
                    $m3_btn_symbol = 'minus';
                    $m3_class = 'in';
                } else {
                    $m3_btn_symbol = 'plus';
                    $m3_class = '';
                }
            ?>
            <h3>
                <em>家庭成員 3 </em>
                <button type="button" data-toggle="collapse" data-target="#m3" onclick='toggleIcon(this);'><i class="fa fa-<?= $m3_btn_symbol ?>"></i></button>
            </h3>

            <div id="m3" class="collapse <?= $m3_class ?>">
                <?= $form->field($model, 'm3_chi_name')->textInput(); ?>
                <?= $form->field($model, 'm3_eng_name')->textInput(); ?>
                <?= $form->field($model, 'm3_gender')->radioList(Definitions::getGender()); ?>
                <?= $form->field($model, 'm3_born_date')->textInput(['placeholder' => '日/月/年']); ?>
                <?php
                // = $form->field($model, 'm3_born_type')->dropdownList(Definitions::getBornType(),['prompt'=>Yii::t('app', 'Please Select')]);
                ?>
                <?= $form->field($model, 'm3_id_type')->dropdownList(Definitions::getIdType(),['prompt'=>Yii::t('app', 'Please Select')]); ?>
                <?= $form->field($model, 'm3_id_no')->textInput(); ?>
                <?= $form->field($model, 'm3_relationship')->textInput(); ?>
                <?= $form->field($model, 'm3_marriage_status')->dropdownList(Definitions::getMarriageStatus(),['prompt'=>Yii::t('app', 'Please Select')]); ?>
                <?= $form->field($model, 'm3_chronic_patient')->textArea(['rows' => 3]); ?>
                <?= $form->field($model, 'm3_special_study')->checkbox(); ?>
                <?= $form->field($model, 'm3_working_status')->dropdownList(Definitions::getWorkingStatus(),['prompt'=>Yii::t('app', 'Please Select')]); ?>
                <?= $form->field($model, 'm3_career')->textInput(); ?>
                <?= $form->field($model, 'm3_income')->textInput(['type' => 'number','step' => '0.01','placeholder' => '$，可輸入小數位']); ?>
                <?= $form->field($model, 'm3_funding_type')->checkboxList(Definitions::getFundingType()); ?>
                <?= $form->field($model, 'm3_funding_value')->textInput(['type' => 'number','step' => '0.01','placeholder' => '$， 可輸入小數位']); ?>
                <?= $form->field($model, 'm3_asset')->radioList(Definitions::getAsset()); ?>
                <?= $form->field($model, 'm3_asset_type')->textInput(); ?>
                <?= $form->field($model, 'm3_asset_value')->textInput(['type' => 'number','step' => '0.01','placeholder' => '$，可輸入小數位']); ?>
                <?= $form->field($model, 'm3_deposit')->textInput(['type' => 'number','step' => '0.01','placeholder' => '$，可輸入小數位']); ?>
            </div>
            <hr />
            <?php 
                if ($model->family_member >= 5) {
                    $m4_btn_symbol = 'minus';
                    $m4_class = 'in';
                } else {
                    $m4_btn_symbol = 'plus';
                    $m4_class = '';
                }
            ?>
            <h3>
                <em>家庭成員 4 </em>
                <button type="button" data-toggle="collapse" data-target="#m4" onclick='toggleIcon(this);'><i class="fa fa-<?= $m4_btn_symbol ?>"></i></button>
            </h3>

            <div id="m4" class="collapse <?= $m4_class ?>">
                <?= $form->field($model, 'm4_chi_name')->textInput(); ?>
                <?= $form->field($model, 'm4_eng_name')->textInput(); ?>
                <?= $form->field($model, 'm4_gender')->radioList(Definitions::getGender()); ?>
                <?= $form->field($model, 'm4_born_date')->textInput(['placeholder' => '日/月/年']); ?>
                <?php
                // = $form->field($model, 'm4_born_type')->dropdownList(Definitions::getBornType(),['prompt'=>Yii::t('app', 'Please Select')]);
                ?>
                <?= $form->field($model, 'm4_id_type')->dropdownList(Definitions::getIdType(),['prompt'=>Yii::t('app', 'Please Select')]); ?>
                <?= $form->field($model, 'm4_id_no')->textInput(); ?>
                <?= $form->field($model, 'm4_relationship')->textInput(); ?>
                <?= $form->field($model, 'm4_marriage_status')->dropdownList(Definitions::getMarriageStatus(),['prompt'=>Yii::t('app', 'Please Select')]); ?>
                <?= $form->field($model, 'm4_chronic_patient')->textArea(['rows' => 3]); ?>
                <?= $form->field($model, 'm4_special_study')->checkbox(); ?>
                <?= $form->field($model, 'm4_working_status')->dropdownList(Definitions::getWorkingStatus(),['prompt'=>Yii::t('app', 'Please Select')]); ?>
                <?= $form->field($model, 'm4_career')->textInput(); ?>
                <?= $form->field($model, 'm4_income')->textInput(['type' => 'number','step' => '0.01','placeholder' => '$，可輸入小數位']); ?>
                <?= $form->field($model, 'm4_funding_type')->checkboxList(Definitions::getFundingType()); ?>
                <?= $form->field($model, 'm4_funding_value')->textInput(['type' => 'number','step' => '0.01','placeholder' => '$， 可輸入小數位']); ?>
                <?= $form->field($model, 'm4_asset')->radioList(Definitions::getAsset()); ?>
                <?= $form->field($model, 'm4_asset_type')->textInput(); ?>
                <?= $form->field($model, 'm4_asset_value')->textInput(['type' => 'number','step' => '0.01','placeholder' => '$，可輸入小數位']); ?>
                <?= $form->field($model, 'm4_deposit')->textInput(['type' => 'number','step' => '0.01','placeholder' => '$，可輸入小數位']); ?>
            </div>
            <hr />
            <?php 
                if ($model->family_member >= 6) {
                    $m5_btn_symbol = 'minus';
                    $m5_class = 'in';
                } else {
                    $m5_btn_symbol = 'plus';
                    $m5_class = '';
                }
            ?>
            <h3>
                <em>家庭成員 5 </em>
                <button type="button" data-toggle="collapse" data-target="#m5" onclick='toggleIcon(this);'><i class="fa fa-<?= $m5_btn_symbol ?>"></i></button>
            </h3>

            <div id="m5" class="collapse <?= $m5_class ?>">
                <?= $form->field($model, 'm5_chi_name')->textInput(); ?>
                <?= $form->field($model, 'm5_eng_name')->textInput(); ?>
                <?= $form->field($model, 'm5_gender')->radioList(Definitions::getGender()); ?>
                <?= $form->field($model, 'm5_born_date')->textInput(['placeholder' => '日/月/年']); ?>
                <?php
                // = $form->field($model, 'm5_born_type')->dropdownList(Definitions::getBornType(),['prompt'=>Yii::t('app', 'Please Select')]);
                ?>
                <?= $form->field($model, 'm5_id_type')->dropdownList(Definitions::getIdType(),['prompt'=>Yii::t('app', 'Please Select')]); ?>
                <?= $form->field($model, 'm5_id_no')->textInput(); ?>
                <?= $form->field($model, 'm5_relationship')->textInput(); ?>
                <?= $form->field($model, 'm5_marriage_status')->dropdownList(Definitions::getMarriageStatus(),['prompt'=>Yii::t('app', 'Please Select')]); ?>
                <?= $form->field($model, 'm5_chronic_patient')->textArea(['rows' => 3]); ?>
                <?= $form->field($model, 'm5_special_study')->checkbox(); ?>
                <?= $form->field($model, 'm5_working_status')->dropdownList(Definitions::getWorkingStatus(),['prompt'=>Yii::t('app', 'Please Select')]); ?>
                <?= $form->field($model, 'm5_career')->textInput(); ?>
                <?= $form->field($model, 'm5_income')->textInput(['type' => 'number','step' => '0.01','placeholder' => '$，可輸入小數位']); ?>
                <?= $form->field($model, 'm5_funding_type')->checkboxList(Definitions::getFundingType()); ?>
                <?= $form->field($model, 'm5_funding_value')->textInput(['type' => 'number','step' => '0.01','placeholder' => '$， 可輸入小數位']); ?>
                <?= $form->field($model, 'm5_asset')->radioList(Definitions::getAsset()); ?>
                <?= $form->field($model, 'm5_asset_type')->textInput(); ?>
                <?= $form->field($model, 'm5_asset_value')->textInput(['type' => 'number','step' => '0.01','placeholder' => '$，可輸入小數位']); ?>
                <?= $form->field($model, 'm5_deposit')->textInput(['type' => 'number','step' => '0.01','placeholder' => '$，可輸入小數位']); ?>
            </div>
        </div>
        <hr />
        <?= $form->field($model, 'single_parents')->radioList(Definitions::getSingleParents()); ?>
        <?= $form->field($model, 'pregnant')->radioList(Definitions::getPregnant()); ?>
        <?= $form->field($model, 'pregnant_period')->textInput(['type' => 'number']); ?>
        <?= $form->field($model, 'total_income')->textInput(['type' => 'number','placeholder' => '$，可輸入小數位']); ?>
        <?= $form->field($model, 'total_funding')->textInput(['type' => 'number','placeholder' => '$，可輸入小數位']); ?>
        <?= $form->field($model, 'total_asset')->textInput(['type' => 'number','placeholder' => '$，可輸入小數位']); ?>
    </section>
    <hr />
    <section>
        <h2><strong><u>第四部份 機構轉介</u></strong></h2>

        <?= $form->field($model, 'social_worker_name')->textInput(); ?>
        <?= $form->field($model, 'social_worker_phone')->textInput(['type' => 'tel']); ?>
        <?= $form->field($model, 'social_worker_email')->textInput(['type' => 'email']); ?>
    </section>
    <hr />

   <div class="form-group">
       <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
   </div>

   <?php ActiveForm::end(); ?>
 </div>
</div><!-- /.modal-content -->
<script>
function toggleIcon(ele) {
    let eleI = $(ele).find('i').first();
    if (eleI.hasClass('fa-plus')){
        eleI.removeClass('fa-plus').addClass('fa-minus');
    } else if (eleI.hasClass('fa-minus')){
        eleI.removeClass('fa-minus').addClass('fa-plus');
    } 
}
</script>
