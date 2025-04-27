<?php

/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\helpers\Url;
use yii\captcha\Captcha;
use kartik\form\ActiveForm;
// use yii\bootstrap\ActiveForm;
// use yii\widgets\ActiveForm;
// use kartik\widgets\FileInput;
use common\widgets\Alert;
use common\models\Menu;
// use common\models\Donation;
use common\models\Definitions;

// Yii::$app->params['page_header_img'] = '/images/page_header_img-donation.jpg';

// $menu_model = Menu::findOne(['url' => 'application']);

// if ($menu_model != null) {
//     Yii::$app->params['page_route'] = $menu_model->route;
//     $_subMenus = $menu_model->allSubMenu;

//     $this->title = strip_tags($menu_model->name);
//     Yii::$app->params['page_header_title'] = $menu_model->name;

//     foreach ($_subMenus as $_subMenu) {
//         Yii::$app->params['breadcrumbs'][] = strip_tags($_subMenu->name);
//         if ($_subMenu->banner_image_file_name != "")
//             Yii::$app->params['page_header_img'] = $_subMenu->banner_image_file_name;
//     }
//     if (sizeof($_subMenus) > 0)
//         Yii::$app->params['page_header_title'] = $_subMenus[0]->name;

//     Yii::$app->params['breadcrumbs'][] = $this->title;
// }

$this->title = Yii::t('app', 'My Information').' - '.Yii::t('app', "My Account");

// Yii::$app->params['page_header_title'] = Yii::t('app', 'LST Shop');
// Yii::$app->params['page_header_img'] = '/images/page_header_img-shop.jpg';

// sYii::$app->params['breadcrumbs'][] = ['label' => Yii::t('app', 'LST Shop'), 'url' => ['/shop']];
Yii::$app->params['breadcrumbs'][] = Yii::t('app', "My Account");
Yii::$app->params['breadcrumbs'][] = Yii::t('app', 'My Information');

$this->registerJs(<<<JS
$('#house_type').trigger('change');
$('#together_type').trigger('change');
$('#prh').trigger('change');
disableSubmitButtons();
JS
);

$_labelSpan = Yii::$app->language == 'en' ? 4 : 3;
?>
<?= $this->render('../layouts/_user_header') ?>
			<?= Alert::widget() ?>

    <div class="row">
<?php if (false) { ?>
        <div class="col-md-3">
            <?= $this->render('../layouts/_body_left_nav', ['menus' => $_subMenus[0]->getActiveSubMenu()->orderBy(['seq' => SORT_ASC])->all()]); ?>
        </div>
        <div class="col-md-9 has-sub-nav">
<?php } else { ?>
        <div class="col-sm-12">
<?php } ?>
            <div id="application" class="application content">
                <h3>詳細資料</h3>

                <?= Alert::widget() ?>

<?php $form = ActiveForm::begin([
                'id' => 'user-application-form',
                'action' => Url::current(['_lang' => null]),
                'type' => ActiveForm::TYPE_HORIZONTAL,
                'formConfig' => ['labelSpan' => $_labelSpan, 'deviceSize' => ActiveForm::SIZE_SMALL],
                'options' => ['class' => 'disable-submit-buttons'],
                // 'options' => ['enctype' => 'multipart/form-data']

                // 'method' => 'post',
                // 'action' => ['/'],
                // 'fieldConfig' => [
                //     'options' => [
                //         'tag' => false,
                //     ],
                // ],
                // 'enableAjaxValidation' => true,
                // 'enableClientValidation' => false,
                // 'enableClientScript' => false,
                // 'validateOnSubmit' => false
            ]); ?>
                <section>
                    <h2><strong><u>第一部份 申請人資料</u></strong></h2>
                    <?= $form->field($model, 'fix_chi_name')->textInput(['value' => $model->chi_name,'disabled' => true]); ?>
                    <?= $form->field($model, 'fix_eng_name')->textInput(['value' => $model->eng_name,'disabled' => true]); ?>
                    <?= $form->field($model, 'phone')->textInput(['type' => 'tel','placeholder' => '請輸入8個數字']); ?>
                    <?= $form->field($model, 'fix_mobile')->textInput(['value' => $model->mobile,'type' => 'tel','placeholder' => '請輸入8個數字','disabled' => true]); ?>
                    <?= $form->field($model, 'address')->textArea(['rows' => 3]); ?>
                    <?= $form->field($model, 'area')->textInput(['placeholder' => '平方呎']); ?>
                    <?= $form->field($model, 'fix_email')->textInput(['value' => $model->email,'type' => 'email','disabled' => true]); ?>
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
                    <?= $form->field($model, 'family_member')->textInput(['type' => 'number','placeholder' => '請輸入人數']); ?>
                    <?= $form->field($model, 'prh')->radioList(Definitions::getPrh(),['id' => 'prh','onchange' => 'prh(this);']); ?>
                    <?= $form->field($model, 'prh_no')->textInput(['placeholder' => '例: U-9999999-9 (G-1422505-G-1423543)','id' => 'prh_no']); ?>
                    <div class="form-group">
                        <div class="col-sm-9 col-sm-offset-3 form-ps">如公屋申請編號以「U」為起首，請填寫由房屋署提供之最新「G」起首的分配編號。</div>
                    </div>
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
                        <?= $form->field($model, 'app_special_study')->checkbox(['disabled' => true]); ?>

                        <?= $form->field($model, 'app_working_status')->dropdownList(Definitions::getWorkingStatus(),['prompt'=>Yii::t('app', 'Please Select')]); ?>
                        <?= $form->field($model, 'app_career')->textInput(); ?>
                        <?= $form->field($model, 'app_income')->textInput(['type' => 'number','step' => '0.01','placeholder' => '$，可輸入小數位','id' => 'app_income','onchange' => 'setTotalIncome();']); ?>
                        <div class="form-group">
                            <div class="col-sm-9 col-sm-offset-3 form-ps">收入包括：工作所得的入息及其他收入（即包括薪酬、雙薪／假期工資、工作津貼、花紅／獎金／佣金／小賬、提供服務的收費、經商／投資利潤、贍養費、親友的資助、定期存款和股票等的利息收益、租金收入、每月領取的退休金／孤兒寡婦金或恩恤金），但不包括申請人及其同住人士須支付的強制性僱員強積金供款、由政府提供的經濟援助、慈善捐款，以及關愛基金援助項目提供的支援等。</div>
                        </div>
                        <?= $form->field($model, 'app_funding_type')->dropdownList(Definitions::getFundingType(),['prompt'=>Yii::t('app', 'Please Select')]); ?>
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
                            if ($form->validate($model) && $model->family_member >= 2) {
                                $m1_btn_symbol = 'minus';
                                $m1_class = '';
                            } else {
                                $m1_btn_symbol = 'plus';
                                $m1_class = 'collapse';
                            }
                        ?>
                        <h3>
                            <em>家庭成員 1 </em>
                            <button type="button" data-toggle="collapse" data-target="#m1" onclick='toggleIcon(this);'><i class="fa fa-<?= $m1_btn_symbol ?>"></i></button>
                        </h3>
                        <div id="m1" class="<?= $m1_class ?>">
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
                            <?= $form->field($model, 'm1_funding_type')->dropdownList(Definitions::getFundingType(),['prompt'=>Yii::t('app', 'Please Select')]); ?>
                            <?= $form->field($model, 'm1_funding_value')->textInput(['type' => 'number','placeholder' => '$， 可輸入小數位','id' => 'm1_funding_value','onchange' => 'setTotalFunding();']); ?>
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
                                $m2_class = '';
                            } else {
                                $m2_btn_symbol = 'plus';
                                $m2_class = 'collapse';
                            }
                        ?>
                        <h3>
                            <em>家庭成員 2 </em>
                            <button type="button" data-toggle="collapse" data-target="#m2" onclick='toggleIcon(this);'><i class="fa fa-<?= $m2_btn_symbol ?>"></i></button>
                        </h3>

                        <div id="m2" class="<?= $m2_class ?>">
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
                            <?= $form->field($model, 'm2_funding_type')->dropdownList(Definitions::getFundingType(),['prompt'=>Yii::t('app', 'Please Select')]); ?>
                            <?= $form->field($model, 'm2_funding_value')->textInput(['type' => 'number','placeholder' => '$， 可輸入小數位','id' => 'm2_funding_value','onchange' => 'setTotalFunding();']); ?>
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
                            if ($model->family_member >= 3) {
                                $m3_btn_symbol = 'minus';
                                $m3_class = '';
                            } else {
                                $m3_btn_symbol = 'plus';
                                $m3_class = 'collapse';
                            }
                        ?>
                        <h3>
                            <em>家庭成員 3 </em>
                            <button type="button" data-toggle="collapse" data-target="#m3" onclick='toggleIcon(this);'><i class="fa fa-<?= $m3_btn_symbol ?>"></i></button>
                        </h3>

                        <div id="m3" class="<?= $m3_class ?>">
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
                            <?= $form->field($model, 'm3_funding_type')->dropdownList(Definitions::getFundingType(),['prompt'=>Yii::t('app', 'Please Select')]); ?>
                            <?= $form->field($model, 'm3_funding_value')->textInput(['type' => 'number','placeholder' => '$， 可輸入小數位','id' => 'm3_funding_value','onchange' => 'setTotalFunding();']); ?>
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
                            if ($model->family_member >= 4) {
                                $m4_btn_symbol = 'minus';
                                $m4_class = '';
                            } else {
                                $m4_btn_symbol = 'plus';
                                $m4_class = 'collapse';
                            }
                        ?>
                        <h3>
                            <em>家庭成員 4 </em>
                            <button type="button" data-toggle="collapse" data-target="#m4" onclick='toggleIcon(this);'><i class="fa fa-<?= $m4_btn_symbol ?>"></i></button>
                        </h3>

                        <div id="m4" class="<?= $m4_class ?>">
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
                            <?= $form->field($model, 'm4_funding_type')->dropdownList(Definitions::getFundingType(),['prompt'=>Yii::t('app', 'Please Select')]); ?>
                            <?= $form->field($model, 'm4_funding_value')->textInput(['type' => 'number','placeholder' => '$， 可輸入小數位','id' => 'm4_funding_value','onchange' => 'setTotalFunding();']); ?>
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
                            if ($model->family_member >= 5) {
                                $m5_btn_symbol = 'minus';
                                $m5_class = '';
                            } else {
                                $m5_btn_symbol = 'plus';
                                $m5_class = 'collapse';
                            }
                        ?>
                        <h3>
                            <em>家庭成員 5 </em>
                            <button type="button" data-toggle="collapse" data-target="#m5" onclick='toggleIcon(this);'><i class="fa fa-<?= $m5_btn_symbol ?>"></i></button>
                        </h3>

                        <div id="m5" class="<?= $m5_class ?>">
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
                            <?= $form->field($model, 'm5_funding_type')->dropdownList(Definitions::getFundingType(),['prompt'=>Yii::t('app', 'Please Select')]); ?>
                            <?= $form->field($model, 'm5_funding_value')->textInput(['type' => 'number','placeholder' => '$， 可輸入小數位','id' => 'm5_funding_value','onchange' => 'setTotalFunding();']); ?>
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
                    <?= $form->field($model, 'total_income')->textInput(['type' => 'number','step' => '0.01','placeholder' => '$，可輸入小數位','id' => 'total_income']); ?>
                    <?= $form->field($model, 'total_funding')->textInput(['type' => 'number','step' => '0.01','placeholder' => '$，可輸入小數位','id' => 'total_funding']); ?>
                    <?= $form->field($model, 'total_asset')->textInput(['type' => 'number','step' => '0.01','placeholder' => '$，可輸入小數位','id' => 'total_asset']); ?>
                </section>
                <hr />
                <section>
                    <h2><strong><u>第四部份 機構轉介</u></strong></h2>

                    <?= $form->field($model, 'social_worker_name')->textInput(); ?>
                    <?= $form->field($model, 'social_worker_phone')->textInput(['type' => 'tel']); ?>
                    <?= $form->field($model, 'social_worker_email')->textInput(['type' => 'email']); ?>
                </section>
                <hr />
<?php if (false) { ?>
                <section>
                    <h2><strong><u>第五部份 申請人聲明及承諾</u></strong></h2>

                    <?= $form->field($model, 'part5_t1', ['options' =>  ['class' => 'terms']])->checkbox(['label' => Definitions::getPart5Terms(1),'uncheck' => null]); ?>
                    <?= $form->field($model, 'part5_t2', ['options' =>  ['class' => 'terms']])->checkbox(['label' => Definitions::getPart5Terms(2),'uncheck' => null]); ?>
                    <?= $form->field($model, 'part5_t3', ['options' =>  ['class' => 'terms']])->checkbox(['label' => Definitions::getPart5Terms(3),'uncheck' => null]); ?>
                    <?= $form->field($model, 'part5_t4', ['options' =>  ['class' => 'terms']])->checkbox(['label' => Definitions::getPart5Terms(4),'uncheck' => null]); ?>
                    <?= $form->field($model, 'part5_t5', ['options' =>  ['class' => 'terms']])->checkbox(['label' => Definitions::getPart5Terms(5),'uncheck' => null]); ?>
                    <?= $form->field($model, 'part5_t6', ['options' =>  ['class' => 'terms']])->checkbox(['label' => Definitions::getPart5Terms(6),'uncheck' => null]); ?>
                    <div class="clearfix"></div>
                </section>
                <hr />
                <section class="part6">
                    <h2><strong><u>第六部份 收集個人資料聲明</u></strong></h2>
                    <ol>
                        <li>九龍樂善堂（下稱「本堂」）及其代表會使用透過樂善堂社會房屋計劃-「樂屋」（下稱「項目」）申請表格所獲得有關你的資料（下稱「資料」）作下列用途及與下列直接有關的用途：
                            <ol>
                                <li>辦理及審批在本項目下申請人遞交的申請，並在有需要時就與本項目有關的事宜聯絡你；</li>
                                <li>執行本項目及進行與本申請有關的審核及調查，包括根據政府及審核期間(包括但不限於家庭、面談、電話查詢等)所提供之個人及家庭成員資料，與你在本申請表提供的資料作核對，以確定申請人及／或家庭成員是否符合本目的受惠資格；</li>
                                <li>作統計及研究用途，其目的包括但不限於了解項目向受惠對象提供援助的成效及受惠對象的居住環境情況，而得的統計數字及研究結果，不會以能辨識任何資料當事人或其中任何人的身份的形式顯示；及</li>
                                <li>作法律規定、授權或許可的用途。</li>
                            </ol>
                        </li>
                        <li>提供個人資料純屬自願，但你如果沒有提供足夠和正確的資料，本堂及其代表可能無法處理申請人遞交的申請，而致請被拒。</li>
                    </ol>
                    <?= $form->field($model, 'part6_t1', ['options' =>  ['class' => 'terms']])->checkbox(['label' => Definitions::getPart6Terms(1),'uncheck' => null]); ?>
                    <div class="clearfix"></div>
                </section>

                <hr />
<?php } ?>

<?php if (false) { ?>
                <?= $form->field($model, 'items')->textArea(['rows' => 3])
                        ->label(Yii::t('web', '{0}:', [$model->getAttributeLabel('items')]));  ?>

                <?= $form->field($model, 'old_and_new')->textArea(['rows' => 3])
                        ->label(Yii::t('web', '{0}:', [$model->getAttributeLabel('old_and_new')]));  ?>

                <?= $form->field($model, 'upload_files[]', ['options' => ['class' => 'form-group required']])->widget(FileInput::classname(), [
                        'options' => ['multiple' => true, 'accept' => 'image/*'],
                        'pluginOptions' => [
                            'previewFileType' => 'any',
                            'showUpload' => false,
                        ]
                    ])
                    ->label(Yii::t('web', '{0}:', [$model->getAttributeLabel('upload_files')]))
                    ->hint(Yii::t('in-kind-donation', 'Can upload at most 5 images'));
                ?>

                <hr />

                <?= $form->field($model, 'verifyCode')->widget(Captcha::className(), [
                    'template' => '<div class="row"><div class="col-sm-4">{image}</div><div class="col-sm-8">{input}</div></div>',
                ])->label(Yii::t('web', '{0}:', [$model->getAttributeLabel('verifyCode')])); ?>

                <hr />

                <h4><?= Yii::t('in-kind-donation', 'Materials Donation Guidelines') ?></h4>
                <ul>
                    <li><?= Yii::t('in-kind-donation', 'Do not accept second-hand clothes, footwear, books;') ?></li>
                    <li><?= Yii::t('in-kind-donation', 'Do not accept donated materials which involved danger, pornography, indecency and terrorist elements; also copyright, health, superstition and moral disputes;') ?></li>
                    <li><?= Yii::t('in-kind-donation', 'If you would like to donate household appliances, furniture, electronics, computer equipment, etc., for safety reasons, we shall only receive items that are in good condition, and no installation or maintenance is needed.') ?></li>
                    <li><?= Yii::t('in-kind-donation', 'If you would like to donate food, we shall only receive the item in good packaging, to ensure that it is not contaminated. The expiry date should be at least six months from the date of donation with food safety label.') ?></li>
                </ul>
<?php } ?>

                <div class="row" style="padding-top: 10px;">
                    <div class="col-sm-<?= (12 - $_labelSpan) ?>">
                      <?= Html::submitButton(Yii::t('app', 'SAVE CHANGES'), ['class' => 'btn btn-dark']) ?>
                    </div>
                </div>

<?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
<script>
function toggleIcon(ele) {
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