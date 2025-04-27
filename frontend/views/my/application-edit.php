<?php

/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\helpers\Url;
use kartik\form\ActiveForm;
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;
use common\models\Config;
use common\models\Definitions;

$model_general = common\models\General::findOne(1);

$this->title = '我的申請 - 檢視';

// Yii::$app->params['page_header_title'] = Yii::t('app', 'LST Shop');
// Yii::$app->params['page_header_img'] = '/images/page_header_img-shop.jpg';

// Yii::$app->params['breadcrumbs'][] = ['label' => Yii::t('app', 'LST Shop'), 'url' => ['/shop']];
Yii::$app->params['breadcrumbs'][] = Yii::t('app', "My Account");
Yii::$app->params['breadcrumbs'][] = ['label' => '我的申請 - 總覽', 'url' => ['application']];
Yii::$app->params['breadcrumbs'][] = '我的申請 - 檢視';

$this->registerJs(<<<JS
$('#house_type').trigger('change');
$('#together_type').trigger('change');
$('#prh').trigger('change');
JS
);

$_labelSpan = Yii::$app->language == 'en' ? 4 : 3;
?>
<?= $this->render('../layouts/_user_header') ?>
<?= Alert::widget() ?>
    <div class="page-my">
        <div class="content">
            <div class="">

<?php if ($model->application_status == $model::APPL_STATUS_UPDATE_SUBMITED_FORM) { ?>
<?php $form = ActiveForm::begin([
    'id' => 'my-application-form',
    'action' => Url::current(['_lang' => null]),
    'type' => ActiveForm::TYPE_HORIZONTAL,
    'formConfig' => ['labelSpan' => $_labelSpan, 'deviceSize' => ActiveForm::SIZE_SMALL],
    'validateOnSubmit' => false
]); 
?>
                    <h2><strong><u>第一部份 申請人資料</u></strong></h2>
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
                    <?= $form->field($model, 'house_type')->dropdownList(Definitions::getHouseType(),['prompt'=>Yii::t('app', 'Please Select'),'id' => 'house_type','onchange' => 'houseType(this);']); ?>
                    <?= $form->field($model, 'house_type_other')->textInput(['id' => 'house_type_other']); ?>
                    <?= $form->field($model, 'private_type')->dropdownList(Definitions::getPrivateType(),['prompt'=>Yii::t('app', 'Please Select'),'id' => 'private_type']); ?>
                    <?= $form->field($model, 'together_type')->dropdownList(Definitions::getTogetherType(),['prompt'=>Yii::t('app', 'Please Select'),'id' => 'together_type','onchange' => 'togetherType(this);']); ?>
                    <?= $form->field($model, 'together_type_other')->textInput(['id' => 'together_type_other']); ?>
                    <?= $form->field($model, 'live_rent')->textInput(['type' => 'number','step' => '0.01','placeholder' => '港幣$，可輸入小數位']); ?>
                    <?php 
                    // = $form->field($model, 'live_year')->textInput(['type' => 'number','step' => '0.01','placeholder' => '以年為單位，可輸入小數位']); 
                    ?>
                    <?= $form->field($model, 'live_year')->dropdownList(Definitions::getLiveYear(),['prompt'=>Yii::t('app', 'Please Select')]); ?>
                    <?= $form->field($model, 'live_month')->dropdownList(Definitions::getLiveMonth(),['prompt'=>Yii::t('app', 'Please Select')]); ?>
                    <?= $form->field($model, 'family_member')->textInput(['type' => 'number','placeholder' => '請輸入人數（包括申請人在內）']); ?>
                    <?= $form->field($model, 'prh')->radioList(Definitions::getPrh(),['id' => 'prh','onchange' => 'prh(this);']); ?>
                    <?= $form->field($model, 'prh_no')->textInput(['placeholder' => '例: U-9999999-9 (G-1422505-G-1423543)','id' => 'prh_no']); ?>
                    <div class="form-group">
                        <div class="col-sm-9 col-sm-offset-3 form-ps">如公屋申請編號以「U」為起首，請填寫由房屋署提供之最新「G」起首的分配編號。</div>
                    </div>
                    <?= $form->field($model, 'prh_location')->dropdownList(Definitions::getPrhLocation(),['prompt'=>Yii::t('app', 'Please Select'),'id' => 'prh_location']); ?>
                    <?= $form->field($model, 'apply_prh_year')->textInput(['type' => 'number','placeholder' => '請輸入年份','id' => 'apply_prh_year']); ?>
                    <?= $form->field($model, 'apply_prh_month')->textInput(['type' => 'number','placeholder' => '請輸入月份','id' => 'apply_prh_month']); ?>
                    <?= $form->field($model, 'apply_prh_day')->textInput(['type' => 'number','placeholder' => '請輸入日期','id' => 'apply_prh_day']); ?>
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
                        <?= $form->field($model, 'app_income')->textInput(['type' => 'number','step' => '0.01','placeholder' => '$，可輸入小數位','id' => 'app_income','onchange' => 'setTotalIncome();']); ?>
                        <div class="form-group">
                            <div class="col-sm-9 col-sm-offset-3 form-ps">收入包括：工作所得的入息及其他收入（即包括薪酬、雙薪／假期工資、工作津貼、花紅／獎金／佣金／小賬、提供服務的收費、經商／投資利潤、贍養費、親友的資助、定期存款和股票等的利息收益、租金收入、每月領取的退休金／孤兒寡婦金或恩恤金），但不包括申請人及其同住人士須支付的強制性僱員強積金供款、由政府提供的經濟援助、慈善捐款，以及關愛基金援助項目提供的支援等。</div>
                        </div>
                        <?= $form->field($model, 'app_funding_type')->checkboxList(Definitions::getFundingType()); ?>
                        <?= $form->field($model, 'app_funding_value')->textInput(['type' => 'number','step' => '0.01','placeholder' => '$，可輸入小數位','id' => 'app_funding_value','onchange' => 'setTotalFunding();']); ?>
                        <?= $form->field($model, 'app_asset')->radioList(Definitions::getAsset()); ?>
                        <div class="form-group">
                            <div class="col-sm-9 col-sm-offset-3 form-ps">個人資產包括：土地、房產(住宅、舖位、車位等)、車輛、的士/小巴牌照、投資(儲蓄基金、基金、股票等)、有或沒有商業登記之業務、貸款等。</div>
                        </div>
                        <?= $form->field($model, 'app_asset_type')->textInput(); ?>
                        <?= $form->field($model, 'app_asset_value')->textInput(['type' => 'number','step' => '0.01','placeholder' => '$，可輸入小數位','id' => 'app_asset_value','onchange' => 'setTotalAsset();']); ?>
                        <?= $form->field($model, 'app_deposit')->textInput(['type' => 'number','step' => '0.01','placeholder' => '$，可輸入小數位','id' => 'app_deposit','onchange' => 'setTotalAsset();']); ?>
                        <div class="form-group">
                            <div class="col-sm-9 col-sm-offset-3 form-ps">包括：活期、定期、港幣、外幣等。</div>
                        </div>
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
                            <?= $form->field($model, 'm1_income')->textInput(['type' => 'number','step' => '0.01','placeholder' => '$，可輸入小數位','id' => 'm1_income','onchange' => 'setTotalIncome();']); ?>
                            <div class="form-group">
                                <div class="col-sm-9 col-sm-offset-3 form-ps">收入包括：工作所得的入息及其他收入（即包括薪酬、雙薪／假期工資、工作津貼、花紅／獎金／佣金／小賬、提供服務的收費、經商／投資利潤、贍養費、親友的資助、定期存款和股票等的利息收益、租金收入、每月領取的退休金／孤兒寡婦金或恩恤金），但不包括申請人及其同住人士須支付的強制性僱員強積金供款、由政府提供的經濟援助、慈善捐款，以及關愛基金援助項目提供的支援等。</div>
                            </div>
                            <?= $form->field($model, 'm1_funding_type')->checkboxList(Definitions::getFundingType()); ?>
                            <?= $form->field($model, 'm1_funding_value')->textInput(['type' => 'number','step' => '0.01','placeholder' => '$， 可輸入小數位','id' => 'm1_funding_value','onchange' => 'setTotalFunding();']); ?>
                            <?= $form->field($model, 'm1_asset')->radioList(Definitions::getAsset()); ?>
                            <div class="form-group">
                                <div class="col-sm-9 col-sm-offset-3 form-ps">個人資產包括：土地、房產(住宅、舖位、車位等)、車輛、的士/小巴牌照、投資(儲蓄基金、基金、股票等)、有或沒有商業登記之業務、貸款等。</div>
                            </div>
                            <?= $form->field($model, 'm1_asset_type')->textInput(); ?>
                            <?= $form->field($model, 'm1_asset_value')->textInput(['type' => 'number','step' => '0.01','placeholder' => '$，可輸入小數位','id' => 'm1_asset_value','onchange' => 'setTotalAsset();']); ?>
                            <?= $form->field($model, 'm1_deposit')->textInput(['type' => 'number','step' => '0.01','placeholder' => '$，可輸入小數位','id' => 'm1_deposit','onchange' => 'setTotalAsset();']); ?>
                            <div class="form-group">
                                <div class="col-sm-9 col-sm-offset-3 form-ps">包括：活期、定期、港幣、外幣等。</div>
                            </div>
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
                            <?= $form->field($model, 'm2_income')->textInput(['type' => 'number','step' => '0.01','placeholder' => '$，可輸入小數位','id' => 'm2_income','onchange' => 'setTotalIncome();']); ?>
                            <div class="form-group">
                                <div class="col-sm-9 col-sm-offset-3 form-ps">收入包括：工作所得的入息及其他收入（即包括薪酬、雙薪／假期工資、工作津貼、花紅／獎金／佣金／小賬、提供服務的收費、經商／投資利潤、贍養費、親友的資助、定期存款和股票等的利息收益、租金收入、每月領取的退休金／孤兒寡婦金或恩恤金），但不包括申請人及其同住人士須支付的強制性僱員強積金供款、由政府提供的經濟援助、慈善捐款，以及關愛基金援助項目提供的支援等。</div>
                            </div>
                            <?= $form->field($model, 'm2_funding_type')->checkboxList(Definitions::getFundingType()); ?>
                            <?= $form->field($model, 'm2_funding_value')->textInput(['type' => 'number','step' => '0.01','placeholder' => '$， 可輸入小數位','id' => 'm2_funding_value','onchange' => 'setTotalFunding();']); ?>
                            <?= $form->field($model, 'm2_asset')->radioList(Definitions::getAsset()); ?>
                            <div class="form-group">
                                <div class="col-sm-9 col-sm-offset-3 form-ps">個人資產包括：土地、房產(住宅、舖位、車位等)、車輛、的士/小巴牌照、投資(儲蓄基金、基金、股票等)、有或沒有商業登記之業務、貸款等。</div>
                            </div>
                            <?= $form->field($model, 'm2_asset_type')->textInput(); ?>
                            <?= $form->field($model, 'm2_asset_value')->textInput(['type' => 'number','step' => '0.01','placeholder' => '$，可輸入小數位','id' => 'm2_asset_value','onchange' => 'setTotalAsset();']); ?>
                            <?= $form->field($model, 'm2_deposit')->textInput(['type' => 'number','step' => '0.01','placeholder' => '$，可輸入小數位','id' => 'm2_deposit','onchange' => 'setTotalAsset();']); ?>
                            <div class="form-group">
                                <div class="col-sm-9 col-sm-offset-3 form-ps">包括：活期、定期、港幣、外幣等。</div>
                            </div>
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
                            <?= $form->field($model, 'm3_income')->textInput(['type' => 'number','step' => '0.01','placeholder' => '$，可輸入小數位','id' => 'm3_income','onchange' => 'setTotalIncome();']); ?>
                            <div class="form-group">
                                <div class="col-sm-9 col-sm-offset-3 form-ps">收入包括：工作所得的入息及其他收入（即包括薪酬、雙薪／假期工資、工作津貼、花紅／獎金／佣金／小賬、提供服務的收費、經商／投資利潤、贍養費、親友的資助、定期存款和股票等的利息收益、租金收入、每月領取的退休金／孤兒寡婦金或恩恤金），但不包括申請人及其同住人士須支付的強制性僱員強積金供款、由政府提供的經濟援助、慈善捐款，以及關愛基金援助項目提供的支援等。</div>
                            </div>
                            <?= $form->field($model, 'm3_funding_type')->checkboxList(Definitions::getFundingType()); ?>
                            <?= $form->field($model, 'm3_funding_value')->textInput(['type' => 'number','step' => '0.01','placeholder' => '$， 可輸入小數位','id' => 'm3_funding_value','onchange' => 'setTotalFunding();']); ?>
                            <?= $form->field($model, 'm3_asset')->radioList(Definitions::getAsset()); ?>
                            <div class="form-group">
                                <div class="col-sm-9 col-sm-offset-3 form-ps">個人資產包括：土地、房產(住宅、舖位、車位等)、車輛、的士/小巴牌照、投資(儲蓄基金、基金、股票等)、有或沒有商業登記之業務、貸款等。</div>
                            </div>
                            <?= $form->field($model, 'm3_asset_type')->textInput(); ?>
                            <?= $form->field($model, 'm3_asset_value')->textInput(['type' => 'number','step' => '0.01','placeholder' => '$，可輸入小數位','id' => 'm3_asset_value','onchange' => 'setTotalAsset();']); ?>
                            <?= $form->field($model, 'm3_deposit')->textInput(['type' => 'number','step' => '0.01','placeholder' => '$，可輸入小數位','id' => 'm3_deposit','onchange' => 'setTotalAsset();']); ?>
                            <div class="form-group">
                                <div class="col-sm-9 col-sm-offset-3 form-ps">包括：活期、定期、港幣、外幣等。</div>
                            </div>
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
                            <?= $form->field($model, 'm4_income')->textInput(['type' => 'number','step' => '0.01','placeholder' => '$，可輸入小數位','id' => 'm4_income','onchange' => 'setTotalIncome();']); ?>
                            <div class="form-group">
                                <div class="col-sm-9 col-sm-offset-3 form-ps">收入包括：工作所得的入息及其他收入（即包括薪酬、雙薪／假期工資、工作津貼、花紅／獎金／佣金／小賬、提供服務的收費、經商／投資利潤、贍養費、親友的資助、定期存款和股票等的利息收益、租金收入、每月領取的退休金／孤兒寡婦金或恩恤金），但不包括申請人及其同住人士須支付的強制性僱員強積金供款、由政府提供的經濟援助、慈善捐款，以及關愛基金援助項目提供的支援等。</div>
                            </div>
                            <?= $form->field($model, 'm4_funding_type')->checkboxList(Definitions::getFundingType()); ?>
                            <?= $form->field($model, 'm4_funding_value')->textInput(['type' => 'number','step' => '0.01','placeholder' => '$， 可輸入小數位','id' => 'm4_funding_value','onchange' => 'setTotalFunding();']); ?>
                            <?= $form->field($model, 'm4_asset')->radioList(Definitions::getAsset()); ?>
                            <div class="form-group">
                                <div class="col-sm-9 col-sm-offset-3 form-ps">個人資產包括：土地、房產(住宅、舖位、車位等)、車輛、的士/小巴牌照、投資(儲蓄基金、基金、股票等)、有或沒有商業登記之業務、貸款等。</div>
                            </div>
                            <?= $form->field($model, 'm4_asset_type')->textInput(); ?>
                            <?= $form->field($model, 'm4_asset_value')->textInput(['type' => 'number','step' => '0.01','placeholder' => '$，可輸入小數位','id' => 'm4_asset_value','onchange' => 'setTotalAsset();']); ?>
                            <?= $form->field($model, 'm4_deposit')->textInput(['type' => 'number','step' => '0.01','placeholder' => '$，可輸入小數位','id' => 'm4_deposit','onchange' => 'setTotalAsset();']); ?>
                            <div class="form-group">
                                <div class="col-sm-9 col-sm-offset-3 form-ps">包括：活期、定期、港幣、外幣等。</div>
                            </div>
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
                            <?= $form->field($model, 'm5_income')->textInput(['type' => 'number','step' => '0.01','placeholder' => '$，可輸入小數位','id' => 'm5_income','onchange' => 'setTotalIncome();']); ?>
                            <div class="form-group">
                                <div class="col-sm-9 col-sm-offset-3 form-ps">收入包括：工作所得的入息及其他收入（即包括薪酬、雙薪／假期工資、工作津貼、花紅／獎金／佣金／小賬、提供服務的收費、經商／投資利潤、贍養費、親友的資助、定期存款和股票等的利息收益、租金收入、每月領取的退休金／孤兒寡婦金或恩恤金），但不包括申請人及其同住人士須支付的強制性僱員強積金供款、由政府提供的經濟援助、慈善捐款，以及關愛基金援助項目提供的支援等。</div>
                            </div>
                            <?= $form->field($model, 'm5_funding_type')->checkboxList(Definitions::getFundingType()); ?>
                            <?= $form->field($model, 'm5_funding_value')->textInput(['type' => 'number','step' => '0.01','placeholder' => '$， 可輸入小數位','id' => 'm5_funding_value','onchange' => 'setTotalFunding();']); ?>
                            <?= $form->field($model, 'm5_asset')->radioList(Definitions::getAsset()); ?>
                            <div class="form-group">
                                <div class="col-sm-9 col-sm-offset-3 form-ps">個人資產包括：土地、房產(住宅、舖位、車位等)、車輛、的士/小巴牌照、投資(儲蓄基金、基金、股票等)、有或沒有商業登記之業務、貸款等。</div>
                            </div>
                            <?= $form->field($model, 'm5_asset_type')->textInput(); ?>
                            <?= $form->field($model, 'm5_asset_value')->textInput(['type' => 'number','step' => '0.01','placeholder' => '$，可輸入小數位','id' => 'm5_asset_value','onchange' => 'setTotalAsset();']); ?>
                            <?= $form->field($model, 'm5_deposit')->textInput(['type' => 'number','step' => '0.01','placeholder' => '$，可輸入小數位','id' => 'm5_deposit','onchange' => 'setTotalAsset();']); ?>
                            <div class="form-group">
                                <div class="col-sm-9 col-sm-offset-3 form-ps">包括：活期、定期、港幣、外幣等。</div>
                            </div>
                        </div>
                    </div>
                    <hr />
                    <?= $form->field($model, 'single_parents')->radioList(Definitions::getSingleParents()); ?>
                    <?= $form->field($model, 'pregnant')->radioList(Definitions::getPregnant()); ?>
                    <?= $form->field($model, 'pregnant_period')->textInput(['type' => 'number']); ?>
                    <?= $form->field($model, 'total_income')->textInput(['type' => 'number','placeholder' => '$，可輸入小數位','id' => 'total_income']); ?>
                    <?= $form->field($model, 'total_funding')->textInput(['type' => 'number','placeholder' => '$，可輸入小數位','id' => 'total_funding']); ?>
                    <?= $form->field($model, 'total_asset')->textInput(['type' => 'number','placeholder' => '$，可輸入小數位','id' => 'total_asset']); ?>
                </section>
                <hr />
                <section>
                    <h2><strong><u>第四部份 機構轉介</u></strong></h2>

                    <?= $form->field($model, 'social_worker_name')->textInput(); ?>
                    <?= $form->field($model, 'social_worker_phone')->textInput(['type' => 'tel']); ?>
                    <?= $form->field($model, 'social_worker_email')->textInput(['type' => 'email']); ?>
                </section>
                <hr />

                <div class="row" style="padding-top: 10px;">
                    <div class="col-sm-<?= (12 - $_labelSpan) ?>">
                      <?= Html::submitButton(Yii::t('app','Submit'), ['class' => 'btn btn-primary']);?>
                    </div>
                </div>
<?php ActiveForm::end(); ?>
<?php } else { ?>
    <div><em>申請審核中</em></div>
<?php } ?>
            </div>
        </div>
    </div>
    <script>
function toggleIcon(ele) {
    console.log('def');
    let eleI = $(ele).find('i').first();
    if (eleI.hasClass('fa-plus')){
        eleI.removeClass('fa-plus').addClass('fa-minus');
    } else if (eleI.hasClass('fa-minus')){
        eleI.removeClass('fa-minus').addClass('fa-plus');
    } 
}
function houseType(ele) {
    if ($(ele).val() == 6) {
        $('#house_type_other').closest('.form-group').show();
    } else {
        $('#house_type_other').closest('.form-group').hide();
    }

    if ($(ele).val() == 1) {
        $('#private_type').closest('.form-group').show();
    } else {
        $('#private_type').closest('.form-group').hide();
    }

    if ($(ele).val() == 3) {
        $('#together_type').closest('.form-group').show();
        togetherType('#together_type');
    } else {
        $('#together_type').closest('.form-group').hide();
        $('#together_type_other').closest('.form-group').hide();
    }
}
function togetherType(ele) {
    if ($(ele).val() == 2) {
        $('#together_type_other').closest('.form-group').show();
    } else {
        $('#together_type_other').closest('.form-group').hide();
    }
}
function prh(ele) {
    let prh;
    $(ele).find('input[type="radio"]').each(function() {
        if ($(this).is(':checked')) {
            prh = $(this).val();
        }
    });

    if (prh == 2) {
        $('#prh_no').val('').attr('disabled',true);
        $('#prh_location').val('').attr('disabled',true);
        $('#apply_prh_year').val('').attr('disabled',true);
        $('#apply_prh_month').val('').attr('disabled',true);
        $('#apply_prh_day').val('').attr('disabled',true);
    } else {
        $('#prh_no').attr('disabled',false);
        $('#prh_location').attr('disabled',false);
        $('#apply_prh_year').attr('disabled',false);
        $('#apply_prh_month').attr('disabled',false);
        $('#apply_prh_day').attr('disabled',false);
    }
}
function setTotalIncome() {
    let eles = ['#app_income','#m1_income','#m2_income','#m3_income','#m4_income','#m5_income'];
    let total = 0, income;

    $.each(eles, function (i, ele) {
        income = parseFloat($(ele).val());
        if (income) {
            total += income;
        }
    });

    $('#total_income').val(total);
}
function setTotalFunding() {
    let eles = ['#app_funding_value','#m1_funding_value','#m2_funding_value','#m3_funding_value','#m4_funding_value','#m5_funding_value'];
    let total = 0, funding;

    $.each(eles, function (i, ele) {
        funding = parseFloat($(ele).val());
        if (funding) {
            total += funding;
        }
    });

    $('#total_funding').val(total);
}
function setTotalAsset() {
    let eles = [
        '#app_asset_value','#m1_asset_value','#m2_asset_value','#m3_asset_value','#m4_asset_value','#m5_asset_value',
        '#app_deposit','#m1_deposit','#m2_deposit','#m3_deposit','#m4_deposit','#m5_deposit'
    ];
    let total = 0, asset;

    $.each(eles, function (i, ele) {
        asset = parseFloat($(ele).val());
        if (asset) {
            total += asset;
        }
    });

    $('#total_asset').val(total);
}
</script>