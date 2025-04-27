<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\imagine\Image;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;
use common\models\Application;
use common\models\User;
use common\models\PageType12;
use common\models\ApplicationMark;

class ApplicationForm extends Application
{
    // public $upload_files=[];
    // public $verifyCode;
    // public $part5_t1;
    // public $part5_t2;
    // public $part5_t3;
    // public $part5_t4;
    // public $part5_t5;
    // public $part5_t6;
    // public $part6_t1;
    public $app_chi_name;
    public $app_eng_name;
    public $app_relationship;
    public $app_special_study;
    public $create_form = true;
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return  [
//            [[
//                'priority_1', 'priority_2', 'priority_3', 'house_type', 'private_type', 'together_type', 'prh', 'prh_location',
//                'app_gender'/*, 'app_born_type'*/, 'app_id_type', 'app_marriage_status', 'app_working_status', 'app_asset', 'single_parents', 'pregnant', 'user_id', 'application_status',
//            ], 'integer'],
//            [['pregnant_period'], 'integer', 'min' => 16],
//            [['area', 'family_member'], 'integer', 'min' => 1],
//            [[
//                'live_rent', 'app_income', 'app_funding_value', 'app_asset_value', 'app_deposit',
//                'total_income', 'total_funding', 'total_asset',
//            ], 'number', 'min' => 0],
//
//
//            [['live_year'], 'integer', 'min' => 0, 'max' => 21],
//            [['live_month'], 'integer', 'min' => 1, 'max' => 11],
//            [['apply_prh_year'], 'integer', 'min' => 1970, 'max' => date("Y")],
//            [['apply_prh_month'], 'integer', 'min' => 1, 'max' => 12],
//            [['apply_prh_day'], 'integer', 'min' => 1, 'max' => 31],
//            [[
//                'chi_name', 'eng_name', 'phone', 'mobile', 'email', 'house_type_other', 'together_type_other', 'prh_no', 'app_born_date', 'app_chronic_patient',
//                'app_career', 'app_asset_type', 'social_worker_name', 'social_worker_email', 'appl_no'
//            ], 'string', 'max' => 255],
//            [['app_id_no',], 'string', 'max' => 20],
//            [['app_funding_type', 'm1_funding_type', 'm2_funding_type', 'm3_funding_type', 'm4_funding_type', 'm5_funding_type'], 'each', 'rule' => ['integer']],
//
//            [[
//                'm1_gender'/*, 'm1_born_type'*/, 'm1_id_type', 'm1_marriage_status', 'm1_special_study', 'm1_working_status','m1_asset',
//            ], 'integer'],
//            [['m1_income', 'm1_funding_value', 'm1_asset_value', 'm1_deposit'], 'number', 'min' => 0],
//
//            [[
//                'm1_chi_name', 'm1_eng_name', 'm1_born_date', 'm1_chronic_patient', 'm1_relationship', 'm1_career', 'm1_asset_type',
//            ], 'string', 'max' => 255],
//            [['m1_id_no',], 'string', 'max' => 20],
//
//            [[
//                'm2_gender'/*, 'm2_born_type'*/, 'm2_id_type', 'm2_marriage_status', 'm2_special_study', 'm2_working_status','m2_asset',
//            ], 'integer'],
//            [['m2_income', 'm2_funding_value', 'm2_asset_value', 'm2_deposit'], 'number', 'min' => 0],
//
//            [[
//                'm2_chi_name', 'm2_eng_name', 'm2_born_date', 'm2_chronic_patient', 'm2_relationship', 'm2_career', 'm2_asset_type',
//            ], 'string', 'max' => 255],
//            [['m2_id_no',], 'string', 'max' => 20],
//
//            [[
//                'm3_gender'/*, 'm3_born_type'*/, 'm3_id_type', 'm3_marriage_status', 'm3_special_study', 'm3_working_status','m3_asset',
//            ], 'integer'],
//            [['m3_income', 'm3_funding_value', 'm3_asset_value', 'm3_deposit'], 'number', 'min' => 0],
//
//            [[
//                'm3_chi_name', 'm3_eng_name', 'm3_born_date', 'm3_chronic_patient', 'm3_relationship', 'm3_career', 'm3_asset_type',
//            ], 'string', 'max' => 255],
//            [['m3_id_no',], 'string', 'max' => 20],
//
//            [[
//                'm4_gender'/*, 'm4_born_type'*/, 'm4_id_type', 'm4_marriage_status', 'm4_special_study', 'm4_working_status','m4_asset',
//            ], 'integer'],
//            [['m4_income', 'm4_funding_value', 'm4_asset_value', 'm4_deposit'], 'number', 'min' => 0],
//
//            [[
//                'm4_chi_name', 'm4_eng_name', 'm4_born_date', 'm4_chronic_patient', 'm4_relationship', 'm4_career', 'm4_asset_type',
//            ], 'string', 'max' => 255],
//            [['m4_id_no',], 'string', 'max' => 20],
//
//            [[
//                'm5_gender'/*, 'm5_born_type'*/, 'm5_id_type', 'm5_marriage_status', 'm5_special_study', 'm5_working_status','m5_asset',
//            ], 'integer'],
//            [['m5_income', 'm5_funding_value', 'm5_asset_value', 'm5_deposit'], 'number', 'min' => 0],
//
//            [[
//                'm5_chi_name', 'm5_eng_name', 'm5_born_date', 'm5_chronic_patient', 'm5_relationship', 'm5_career', 'm5_asset_type',
//            ], 'string', 'max' => 255],
//            [['m5_id_no',], 'string', 'max' => 20],
//
//            [['address'], 'string'],
//            [['phone', 'mobile', 'social_worker_phone'], 'string', 'max' => 8],

           [[
               'priority_1', 'priority_2', 'priority_3', 'house_type', 'private_type', 'together_type', 'prh', 'prh_location',
               'app_gender'/*, 'app_born_type'*/, 'app_id_type', 'app_marriage_status', 'app_working_status', 'app_asset', 'single_parents', 'pregnant', 'user_id', 'application_status',
           ], 'safe'],
           [['pregnant_period'], 'safe'],
           [['area'], 'safe'],
           [[
               'live_rent', 'app_income', 'app_funding_value', 'app_asset_value', 'app_deposit',
               'total_income', 'total_funding', 'total_asset',
           ], 'safe'],
           [['live_year'], 'safe'],
           [['live_month'], 'safe'],
           [['apply_prh_year'], 'safe'],
           [['apply_prh_month'], 'safe'],
           [['apply_prh_day'], 'safe'],
           [[
               'phone', 'email', 'house_type_other', 'together_type_other', 'prh_no', 'app_born_date', 'app_chronic_patient',
               'app_career', 'app_asset_type', 'social_worker_name', 'social_worker_email', 'appl_no'
           ], 'safe'],
           [['app_id_no',], 'safe'],
           [['app_funding_type', 'm1_funding_type', 'm2_funding_type', 'm3_funding_type', 'm4_funding_type', 'm5_funding_type'], 'safe'],
           [[
               'm1_gender'/*, 'm1_born_type'*/, 'm1_id_type', 'm1_marriage_status', 'm1_special_study', 'm1_working_status','m1_asset',
           ], 'safe'],
           [['m1_income', 'm1_funding_value', 'm1_asset_value', 'm1_deposit'], 'safe'],

           [[
               'm1_chi_name', 'm1_eng_name', 'm1_born_date', 'm1_chronic_patient', 'm1_relationship', 'm1_career', 'm1_asset_type',
           ], 'safe'],
           [['m1_id_no',], 'safe'],

           [[
               'm2_gender'/*, 'm2_born_type'*/, 'm2_id_type', 'm2_marriage_status', 'm2_special_study', 'm2_working_status','m2_asset',
           ], 'safe'],
           [['m2_income', 'm2_funding_value', 'm2_asset_value', 'm2_deposit'], 'safe'],

           [[
               'm2_chi_name', 'm2_eng_name', 'm2_born_date', 'm2_chronic_patient', 'm2_relationship', 'm2_career', 'm2_asset_type',
           ], 'safe'],
           [['m2_id_no',], 'safe'],

           [[
               'm3_gender'/*, 'm3_born_type'*/, 'm3_id_type', 'm3_marriage_status', 'm3_special_study', 'm3_working_status','m3_asset',
           ], 'safe'],
           [['m3_income', 'm3_funding_value', 'm3_asset_value', 'm3_deposit'], 'safe'],

           [[
               'm3_chi_name', 'm3_eng_name', 'm3_born_date', 'm3_chronic_patient', 'm3_relationship', 'm3_career', 'm3_asset_type',
           ], 'safe'],
           [['m3_id_no',], 'safe'],

           [[
               'm4_gender'/*, 'm4_born_type'*/, 'm4_id_type', 'm4_marriage_status', 'm4_special_study', 'm4_working_status','m4_asset',
           ], 'safe'],
           [['m4_income', 'm4_funding_value', 'm4_asset_value', 'm4_deposit'], 'safe'],

           [[
               'm4_chi_name', 'm4_eng_name', 'm4_born_date', 'm4_chronic_patient', 'm4_relationship', 'm4_career', 'm4_asset_type',
           ], 'safe'],
           [['m4_id_no',], 'safe'],

           [[
               'm5_gender'/*, 'm5_born_type'*/, 'm5_id_type', 'm5_marriage_status', 'm5_special_study', 'm5_working_status','m5_asset',
           ], 'safe'],
           [['m5_income', 'm5_funding_value', 'm5_asset_value', 'm5_deposit'], 'safe'],

           [[
               'm5_chi_name', 'm5_eng_name', 'm5_born_date', 'm5_chronic_patient', 'm5_relationship', 'm5_career', 'm5_asset_type',
           ], 'safe'],
           [['m5_id_no',], 'safe'],

            // [['phone'], 'checkPhone'],
            // [['mobile'], 'checkMobile'],
            // [['social_worker_phone'], 'checkSocialWorkerPhone'],
            // [['email', 'social_worker_email'], 'email'],

            [['family_member'], 'integer', 'min' => 1],

            [['family_member'], 'checkFamilyMember'],

            /**** part 1 ***/

            [['chi_name'], 'required', 'when' => function ($model) {
                return !$model->eng_name;
            }, 'message' => '如果沒有姓名(英文)，姓名(中文)不能為空白'],
            [['eng_name'], 'required', 'when' => function ($model) {
                return !$model->chi_name;
            }, 'message' => '如果沒有姓名(中文)，姓名(英文)不能為空白'],

            [['mobile', 'family_member'], 'required'],

            [['m1_chi_name'], 'required', 'when' => function ($model) {
                return $model->family_member >= 2 && !$model->m1_eng_name;
            }, 'message' => '如果家庭成員多於一人以及沒有家庭成員 1 - 英文姓名，家庭成員 1 - 中文姓名不能為空白'],
            [['m1_eng_name'], 'required', 'when' => function ($model) {
                return $model->family_member >= 2 && !$model->m1_chi_name;
            }, 'message' => '如果家庭成員多於一人以及沒有家庭成員 1 - 中文姓名，家庭成員 1 - 英文姓名不能為空白'],

            [['m2_chi_name'], 'required', 'when' => function ($model) {
                return $model->family_member >= 3 && !$model->m2_eng_name;
            }, 'message' => '如果家庭成員多於二人以及沒有家庭成員 2 - 英文姓名，家庭成員 2 - 中文姓名不能為空白'],
            [['m2_eng_name'], 'required', 'when' => function ($model) {
                return $model->family_member >= 3 && !$model->m2_chi_name;
            }, 'message' => '如果家庭成員多於二人以及沒有家庭成員 2 - 中文姓名，家庭成員 2 - 英文姓名不能為空白'],

            [['m3_chi_name'], 'required', 'when' => function ($model) {
                return $model->family_member >= 4 && !$model->m3_eng_name;
            }, 'message' => '如果家庭成員多於三人以及沒有家庭成員 3 - 英文姓名，家庭成員 3 - 中文姓名不能為空白'],
            [['m3_eng_name'], 'required', 'when' => function ($model) {
                return $model->family_member >= 4 && !$model->m3_chi_name;
            }, 'message' => '如果家庭成員多於三人以及沒有家庭成員 3 - 中文姓名，家庭成員 3 - 英文姓名不能為空白'],

            [['m4_chi_name'], 'required', 'when' => function ($model) {
                return $model->family_member >= 5 && !$model->m4_eng_name;
            }, 'message' => '如果家庭成員多於四人以及沒有家庭成員 4 - 英文姓名，家庭成員 4 - 中文姓名不能為空白'],
            [['m4_eng_name'], 'required', 'when' => function ($model) {
                return $model->family_member >= 5 && !$model->m4_chi_name;
            }, 'message' => '如果家庭成員多於四人以及沒有家庭成員 4 - 中文姓名，家庭成員 4 - 英文姓名不能為空白'],

            [['m5_chi_name'], 'required', 'when' => function ($model) {
                return $model->family_member >= 6 && !$model->m5_eng_name;
            }, 'message' => '如果家庭成員多於五人以及沒有家庭成員 5 - 英文姓名，家庭成員 5 - 中文姓名不能為空白'],
            [['m5_eng_name'], 'required', 'when' => function ($model) {
                return $model->family_member >= 6 && !$model->m5_chi_name;
            }, 'message' => '如果家庭成員多於五人以及沒有家庭成員 5 - 中文姓名，家庭成員 5 - 英文姓名不能為空白'],
/*
            [[
                'chi_name', 'eng_name', 'mobile', 'address', 'area', 'house_type', 'live_rent', 'live_year',
                'family_member', 'prh'
            ], 'required'],
            [['priority_2'], 'checkPriority2'],
            [['priority_3'], 'checkPriority3'],
            [['house_type_other'], 'required', 'when' => function ($model) {
                return $model->house_type == 6;
            }, 'message' => '如果現時居住房屋種類選擇其他，{attribute} 不能為空白'],
            [['private_type'], 'required', 'when' => function ($model) {
                return $model->house_type == 1;
            }, 'message' => '如果現時居住房屋種類選擇租住私人樓宇，{attribute} 不能為空白'],
            [['together_type'], 'required', 'when' => function ($model) {
                return $model->house_type == 3;
            }, 'message' => '如果現時居住房屋種類選擇與家人同住，{attribute} 不能為空白'],
            [['together_type_other'], 'required', 'when' => function ($model) {
                return $model->house_type == 3 && $model->together_type == 2;
            }, 'message' => '如果現時居住房屋種類選擇與家人同住及同住房屋種類選擇其他，{attribute} 不能為空白'],
            [['prh_no'], 'required', 'when' => function ($model) {
                return $model->prh == 1;
            }, 'message' => '如果選擇有居住公屋，{attribute} 不能為空白'],
            [['prh_location'], 'required', 'when' => function ($model) {
                return $model->prh == 1;
            }, 'message' => '如果選擇有居住公屋，{attribute} 不能為空白'],
            [['apply_prh_year'], 'required', 'when' => function ($model) {
                return $model->prh == 1;
            }, 'message' => '如果選擇有居住公屋，{attribute} 不能為空白'],
            [['apply_prh_month'], 'required', 'when' => function ($model) {
                return $model->prh == 1;
            }, 'message' => '如果選擇有居住公屋，{attribute} 不能為空白'],
            [['apply_prh_day'], 'required', 'when' => function ($model) {
                return $model->prh == 1;
            }, 'message' => '如果選擇有居住公屋，{attribute} 不能為空白'],
*/
            /**** part 2 & 3 ***/
            // applicant
/*
            [[
                'app_gender', 'app_born_date', 'app_id_type', 'app_id_no', 'app_marriage_status', 'app_working_status',
                'app_income', 'app_asset', 'app_deposit',
            ], 'required'],
            [['app_career'], 'required', 'when' => function ($model) {
                return $model->app_working_status == 1 || $model->app_working_status == 2;
            }, 'message' => '如果上面選擇全職或兼職，{attribute} 不能為空白'],
            [['app_funding_value'], 'required', 'when' => function ($model) {
                return $model->app_funding_type > 0;
            }, 'message' => '如果上面選擇任何選項的資助，{attribute} 不能為空白'],
            [['app_asset_type', 'app_asset_value'], 'required', 'when' => function ($model) {
                return $model->app_asset == 1;
            }, 'message' => '如果上面選擇有資產，{attribute} 不能為空白'],

            // family member 1
            [[
                'm1_chi_name', 'm1_eng_name', 'm1_gender', 'm1_born_date', 'm1_id_type', 'm1_id_no', 'm1_relationship',
                'm1_marriage_status', 'm1_working_status', 'm1_income', 'm1_asset', 'm1_deposit',
            ], 'required', 'when' => function ($model) {
                return $model->family_member >= 2;
            }, 'message' => '如果家庭成員多於一人，{attribute} 不能為空白'],
            [['m1_career'], 'required', 'when' => function ($model) {
                return $model->m1_working_status == 1 || $model->m1_working_status == 2;
            }, 'message' => '如果家庭成員多於一人及上面選擇全職或兼職，{attribute} 不能為空白'],
            [['m1_funding_value'], 'required', 'when' => function ($model) {
                return $model->family_member >= 2 && $model->m1_funding_type > 0;
            }, 'message' => '如果家庭成員多於一人及上面選擇任何選項的資助，{attribute} 不能為空白'],
            [['m1_asset_type', 'm1_asset_value'], 'required', 'when' => function ($model) {
                return $model->family_member >= 2 && $model->m1_asset == 1;
            }, 'message' => '如果家庭成員多於一人及上面選擇有資產，{attribute} 不能為空白'],

            // family member 2
            [[
                'm2_chi_name', 'm2_eng_name', 'm2_gender', 'm2_born_date', 'm2_id_type', 'm2_id_no', 'm2_relationship',
                'm2_marriage_status', 'm2_working_status', 'm2_income', 'm2_asset', 'm2_deposit',
            ], 'required', 'when' => function ($model) {
                return $model->family_member >= 3;
            }, 'message' => '如果家庭成員多於一人，{attribute} 不能為空白'],
            [['m2_career'], 'required', 'when' => function ($model) {
                return $model->m2_working_status == 1 || $model->m2_working_status == 2;
            }, 'message' => '如果家庭成員多於一人及上面選擇全職或兼職，{attribute} 不能為空白'],
            [['m2_funding_value'], 'required', 'when' => function ($model) {
                return $model->family_member >= 3 && $model->m2_funding_type > 0;
            }, 'message' => '如果家庭成員多於一人及上面選擇任何選項的資助，{attribute} 不能為空白'],
            [['m2_asset_type', 'm2_asset_value'], 'required', 'when' => function ($model) {
                return $model->family_member >= 3 && $model->m2_asset == 1;
            }, 'message' => '如果家庭成員多於一人及上面選擇有資產，{attribute} 不能為空白'],

            // family member 3
            [[
                'm3_chi_name', 'm3_eng_name', 'm3_gender', 'm3_born_date', 'm3_id_type', 'm3_id_no', 'm3_relationship',
                'm3_marriage_status', 'm3_working_status', 'm3_income', 'm3_asset', 'm3_deposit',
            ], 'required', 'when' => function ($model) {
                return $model->family_member >= 4;
            }, 'message' => '如果家庭成員多於一人，{attribute} 不能為空白'],
            [['m3_career'], 'required', 'when' => function ($model) {
                return $model->m3_working_status == 1 || $model->m3_working_status == 2;
            }, 'message' => '如果家庭成員多於一人及上面選擇全職或兼職，{attribute} 不能為空白'],
            [['m3_funding_value'], 'required', 'when' => function ($model) {
                return $model->family_member >= 4 && $model->m3_funding_type > 0;
            }, 'message' => '如果家庭成員多於一人及上面選擇任何選項的資助，{attribute} 不能為空白'],
            [['m3_asset_type', 'm3_asset_value'], 'required', 'when' => function ($model) {
                return $model->family_member >= 4 && $model->m3_asset == 1;
            }, 'message' => '如果家庭成員多於一人及上面選擇有資產，{attribute} 不能為空白'],
            
            // family member 4
            [[
                'm4_chi_name', 'm4_eng_name', 'm4_gender', 'm4_born_date', 'm4_id_type', 'm4_id_no', 'm4_relationship',
                'm4_marriage_status', 'm4_working_status', 'm4_income', 'm4_asset', 'm4_deposit',
            ], 'required', 'when' => function ($model) {
                return $model->family_member >= 5;
            }, 'message' => '如果家庭成員多於一人，{attribute} 不能為空白'],
            [['m4_career'], 'required', 'when' => function ($model) {
                return $model->m4_working_status == 1 || $model->m4_working_status == 2;
            }, 'message' => '如果家庭成員多於一人及上面選擇全職或兼職，{attribute} 不能為空白'],
            [['m4_funding_value'], 'required', 'when' => function ($model) {
                return $model->family_member >= 5 && $model->m4_funding_type > 0;
            }, 'message' => '如果家庭成員多於一人及上面選擇任何選項的資助，{attribute} 不能為空白'],
            [['m4_asset_type', 'm4_asset_value'], 'required', 'when' => function ($model) {
                return $model->family_member >= 5 && $model->m4_asset == 1;
            }, 'message' => '如果家庭成員多於一人及上面選擇有資產，{attribute} 不能為空白'],

            // family member 5
            [[
                'm5_chi_name', 'm5_eng_name', 'm5_gender', 'm5_born_date', 'm5_id_type', 'm5_id_no', 'm5_relationship',
                'm5_marriage_status', 'm5_working_status', 'm5_income', 'm5_asset', 'm5_deposit',
            ], 'required', 'when' => function ($model) {
                return $model->family_member >= 6;
            }, 'message' => '如果家庭成員多於一人，{attribute} 不能為空白'],
            [['m5_career'], 'required', 'when' => function ($model) {
                return $model->m5_working_status == 1 || $model->m5_working_status == 2;
            }, 'message' => '如果家庭成員多於一人及上面選擇全職或兼職，{attribute} 不能為空白'],
            [['m5_funding_value'], 'required', 'when' => function ($model) {
                return $model->family_member >= 6 && $model->m5_funding_type > 0;
            }, 'message' => '如果家庭成員多於一人及上面選擇任何選項的資助，{attribute} 不能為空白'],
            [['m5_asset_type', 'm5_asset_value'], 'required', 'when' => function ($model) {
                return $model->family_member >= 6 && $model->m5_asset == 1;
            }, 'message' => '如果家庭成員多於一人及上面選擇有資產，{attribute} 不能為空白'],
            
            // other
            [['single_parents', 'pregnant', 'total_income', 'total_funding', 'total_asset'], 'required'],
            [['pregnant_period'], 'required', 'when' => function ($model) {
                return $model->pregnant == 1;
            }, 'message' => '如果上面選擇有懷孕16週或以上成員，{attribute} 不能為空白'],
*/
            /**** part 4 ***/
            // [['social_worker_name', 'social_worker_phone', 'social_worker_email'], 'required'],
            // [['social_worker_name', 'social_worker_email'], 'required'],
            /**** part 5 ***/
            // [['part5_t1', 'part5_t2', 'part5_t3', 'part5_t4', 'part5_t5', 'part5_t6'], 'required'],
            /**** part 6 ***/
            // [['part6_t1'], 'required'],
        ];
    }

    public function checkPriority2 ($attribute) {
        if ($this->priority_2 > 0 && $this->priority_2 == $this->priority_1) {
            $this->addError($attribute, '不能選擇相同的「樂屋」');
            return false;
        }
    }

    public function checkPriority3 ($attribute) {
        if ($this->priority_3 > 0 && ($this->priority_3 == $this->priority_1 || $this->priority_3 == $this->priority_2)) {
            $this->addError($attribute, '不能選擇相同的「樂屋」');
            return false;
        }
    }

    public function checkChiName ($attribute) {
        if (!(preg_match('/^[\x{4e00}-\x{9fa5}]+$/u', $this->chi_name) > 0 || preg_match('/[\x{4e00}-\x{9fa5}]/u', $this->chi_name) > 0)) {
            $this->addError($attribute, '請輸入中文');
            return false;
        }
    }

    public function checkPhone ($attribute) {
        if ((int)$this->phone < 10000000 || (int)$this->phone > 99999999) {
            $this->addError($attribute, '請輸入正確住宅電話號碼');
            return false;
        }
    }

    public function checkMobile ($attribute) {
        if (
            (int)$this->mobile < 40000000 ||
            ((int)$this->mobile > 69999999 && (int)$this->mobile < 90000000) ||
            (int)$this->mobile > 99999999
        ) {
            $this->addError($attribute, '請輸入正確手提電話號碼');
            return false;
        }
    }

    public function checkSocialWorkerPhone ($attribute) {
        if (
            (int)$this->social_worker_phone < 40000000 ||
            ((int)$this->social_worker_phone > 69999999 && (int)$this->social_worker_phone < 90000000) ||
            (int)$this->social_worker_phone > 99999999
        ) {
                $this->addError($attribute, '請輸入正確轉介社工聯絡電話號碼');
            return false;
        }
    }

    public function checkFamilyMember ($attribute) {
        $page_type_12s = PageType12::find()->where(['>=', 'avl_no_of_people_max', (int)$this->family_member])->andWhere(['status' => 1])->asArray()->all();

        if (count($page_type_12s) == 0) {
            $this->addError($attribute, '居住人數超出限制');
            return false;
        }
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return ArrayHelper::merge(
            parent::attributeLabels(),
            [
            ]
        );
    }

    public function setApplicationMark()
    {
        $mark_model = new ApplicationMark();

        $mark_model->application_id = $this->id;
        $mark_model->i1             = $this->getI1Mark();
        $mark_model->i2             = $this->getI2Mark();
        $mark_model->i3             = $this->getI3Mark();
        $mark_model->i4             = $this->getI4Mark();
        $mark_model->i5             = $this->getI5Mark();
        $mark_model->i6             = $this->getI6Mark();
        $mark_model->i7             = $this->getI7Mark();
        $mark_model->i8             = $this->getI8Mark();
        $mark_model->i9             = $this->getI9Mark();
        $mark_model->i10            = $this->getI10Mark();
        $mark_model->i11            = $this->getI11Mark();
        $mark_model->i12            = $this->getI12Mark();
        $mark_model->i13            = $this->getI13Mark();
        $mark_model->i14            = 0;
        // $mark_model->total          = $mark_model->i1  + $mark_model->i2  + $mark_model->i3  + $mark_model->i4  +
        //                               $mark_model->i5  + $mark_model->i6  + $mark_model->i7  + $mark_model->i8  +
        //                               $mark_model->i9  + $mark_model->i10 + $mark_model->i11 + $mark_model->i12 +
        //                               $mark_model->i13 + $mark_model->i14;

        $mark_model->save(false);
    }

    public function getI1Mark()
    {
        $i1_fields = ['app_id_type','m1_id_type','m2_id_type','m3_id_type','m4_id_type','m5_id_type'];

        $i1_app_count = 0;
        $i1_count = 0;

        foreach ($i1_fields as $field) {
            if (isset($this->$field) && (int)$this->$field === 1) {
                $i1_count++;

                if ($field == 'app_id_type') {
                    $i1_app_count++;
                }
            }
        }

        if ((int)$this->family_member > 1 && $i1_count == (int)$this->family_member) {
            $i1_mark = 3;
        } elseif ((int)$this->family_member > 1 && $i1_count >= (int)$this->family_member / 2) {
            $i1_mark = 2;
        } elseif ($i1_app_count === 1 && $i1_count === 1) {
            $i1_mark = 1;
        } else {
            $i1_mark = 0;
        }

        return $i1_mark;
    }

    public function getI2Mark()
    {
        // $i2_fields = ['app_born_type','m1_born_type','m2_born_type','m3_born_type','m4_born_type','m5_born_type'];
        $i2_fields = ['app_born_date','m1_born_date','m2_born_date','m3_born_date','m4_born_date','m5_born_date'];

        $i2_count = 0;
        $target_age = 60;

        // foreach ($i2_fields as $field) {
        //     if (isset($this->$field) && (int)$this->$field === 2) {
        //         $i2_count++;
        //     }
        // }

        foreach ($i2_fields as $field) {
            if (isset($this->$field)) {
                $dates = explode('/', $this->$field);

                if (!$dates || count($dates) != 3) {
                    continue;
                }

                $year = (int)$dates[2];
                $month = (int)$dates[1];
                $day = (int)$dates[0];

                if ((int)date('Y') - $year > $target_age) {
                    $i2_count++;
                } else if ((int)date('Y') - $year == $target_age) {
                    if ((int)date('m') > $month) {
                        $i2_count++;
                    } else if ((int)date('m') == $month) {
                        if ((int)date('d') >= $day) {
                            $i2_count++;
                        }   
                    }
                }
            }
        }

        $i2_mark = $i2_count;

        return $i2_mark;
    }

    public function getI3Mark()
    {
        // $i3_fields = ['app_born_type','m1_born_type','m2_born_type','m3_born_type','m4_born_type','m5_born_type'];
        $i3_fields = ['app_born_date','m1_born_date','m2_born_date','m3_born_date','m4_born_date','m5_born_date'];

        $i3_count = 0;
        $target_age = 17;

        // foreach ($i3_fields as $field) {
        //     if (isset($this->$field) && (int)$this->$field === 1) {
        //         $i3_count++;
        //     }
        // }

        foreach ($i3_fields as $field) {
            if (isset($this->$field)) {
                $dates = explode('/', $this->$field);

                if (!$dates || count($dates) != 3) {
                    continue;
                }

                $year = (int)$dates[2];
                $month = (int)$dates[1];
                $day = (int)$dates[0];

                if ((int)date('Y') - $year < $target_age) {
                    $i3_count++;
                } else if ((int)date('Y') - $year == $target_age) {
                    if ((int)date('m') < $month) {
                        $i3_count++;
                    } else if ((int)date('m') == $month) {
                        if ((int)date('d') < $day) {
                            $i3_count++;
                        }   
                    }
                }
            }
        }

        $i3_mark = $i3_count;

        return $i3_mark;
    }

    public function getI4Mark()
    {
        $i4_fields = ['app_funding_type','m1_funding_type','m2_funding_type','m3_funding_type','m4_funding_type','m5_funding_type'];

        $i4_count = 0;

        foreach ($i4_fields as $field) {
            if (in_array(4, $this->$field)) {
                $i4_count++;
            }
        }

        $i4_mark = ($i4_count >= 1) ? 1 : 0;

        return $i4_mark;
    }

    public function getI5Mark()
    {
        $i5_fields = ['m1_special_study','m2_special_study','m3_special_study','m4_special_study','m5_special_study'];

        $i5_count = 0;

        foreach ($i5_fields as $field) {
            if (isset($this->$field) && (int)$this->$field === 1) {
                $i5_count++;
            }
        }

        $i5_mark = ($i5_count >= 1) ? 1 : 0;

        return $i5_mark;
    }

    public function getI6Mark()
    {
        $i6_mark = (int)$this->single_parents === 1 ? 1 : 0;

        return $i6_mark;
    }

    public function getI7Mark()
    {
        $i7_fields = ['app_funding_type','m1_funding_type','m2_funding_type','m3_funding_type','m4_funding_type','m5_funding_type'];

        $i7_count = 0;

        foreach ($i7_fields as $field) {
            if (isset($this->$field) && in_array(1, $this->$field)) {
                $i7_count++;
            }
        }

        if ($this->total_income <= self::MEDIAN_MONTHLY_INCOME * 0.55 || $i7_count >= 1) {
            $i7_mark = 3;
        } elseif ($this->total_income <= self::MEDIAN_MONTHLY_INCOME * 0.65) {
            $i7_mark = 2;
        } elseif ($this->total_income <= self::MEDIAN_MONTHLY_INCOME * 0.75) {
            $i7_mark = 1;
        } else {
            $i7_mark = 0;
        }

        return $i7_mark;
    }

    public function getI8Mark()
    {
        $total_income = (int)$this->total_income;

        if ($this->live_rent >= $total_income * 0.5) {
            $i8_mark = 3;
        } elseif ($this->live_rent >= $total_income * 0.4 && $this->live_rent < $total_income * 0.5) {
            $i8_mark = 2;
        } elseif ($this->live_rent >= $total_income * 0.3 && $this->live_rent < $total_income * 0.4) {
            $i8_mark = 1;
        } else {
            $i8_mark = 0;
        }

        return $i8_mark;
    }

    public function getI9Mark()
    {
        $i9_fields = ['app_funding_type','m1_funding_type','m2_funding_type','m3_funding_type','m4_funding_type','m5_funding_type'];

        $i9_count = 0;

        foreach ($i9_fields as $field) {
            if (isset($this->$field) && count($this->$field) >= 1) {
                $i9_count++;
            }
        }

        $i9_mark = ($i9_count == 0) ? 2 : 0;

        return $i9_mark;
    }

    public function getI10Mark()
    {
        $i10_fields = ['app_funding_type','m1_funding_type','m2_funding_type','m3_funding_type','m4_funding_type','m5_funding_type'];

        $i10_count = 0;

        foreach ($i10_fields as $field) {
            if (isset($this->$field) && count($this->$field) >= 1 && !in_array(4, $this->$field)) {
                $i10_count++;
            }
        }

        $i10_mark = ($i10_count >= 1) ? 1 : 0;

        return $i10_mark;
    }

    public function getI11Mark()
    {
        $result = (int)$this->live_rent / (int)$this->family_member;

        if ($result <= 40) {
            $i11_mark = 3;
        } elseif ($result > 40 && $result <= 55) {
            $i11_mark = 2;
        } elseif ($result > 55 && $result <= 70) {
            $i11_mark = 1;
        } else {
            $i11_mark = 0;
        }

        return $i11_mark;
    }

    public function getI12Mark()
    {
        $five_years = 60 * 60 * 24 * 365 * 5;
        $four_years = 60 * 60 * 24 * 365 * 4;
        $three_years = 60 * 60 * 24 * 365 * 3;

        $appl_model = self::findOne(['id' => $this->id]);

        if (strtotime($appl_model->created_at) - strtotime($this->apply_prh_year.'-'.$this->apply_prh_month) >= $five_years) {
            $i12_mark = 3;
        } elseif (strtotime($appl_model->created_at) - strtotime($this->apply_prh_year.'-'.$this->apply_prh_month) >= $four_years) {
            $i12_mark = 2;
        } elseif (strtotime($appl_model->created_at) - strtotime($this->apply_prh_year.'-'.$this->apply_prh_month) >= $three_years) {
            $i12_mark = 1;
        } else {
            $i12_mark = 0;
        }

        return $i12_mark;
    }

    public function getI13Mark()
    {
        if ($this->house_type == 1) {
            $i13_mark = 3;
        } elseif ($this->house_type == 2) {
            $i13_mark = 2;
        } elseif ($this->house_type == 3 || $this->house_type == 4 || $this->house_type == 5) {
            $i13_mark = 1;
        } else {
            $i13_mark = 0;
        }

        return $i13_mark;
    }

    /*
    public function updateUser()
    {
        $user_model = User::findOne(['id' => Yii::$app->user->id]);

        // $user_model->chi_name            = $_this->chi_name;
        // $user_model->eng_name            = $_this->eng_name;
        $user_model->phone               = $this->phone;
        // $user_model->mobile              = $_this->mobile;
        $user_model->address             = $this->address;
        $user_model->area                = $this->area;
        // $user_model->email               = $_this->email;
        $user_model->house_type          = $this->house_type;
        $user_model->house_type_other    = $this->house_type_other;
        $user_model->private_type        = $this->private_type;
        $user_model->together_type       = $this->together_type;
        $user_model->together_type_other = $this->together_type_other;
        $user_model->live_rent           = $this->live_rent;
        $user_model->live_year           = $this->live_year;
        $user_model->live_month          = $this->live_month;
        $user_model->family_member       = $this->family_member;
        $user_model->prh                 = $this->prh;
        $user_model->prh_no              = $this->prh_no;
        $user_model->prh_location        = $this->prh_location;
        $user_model->apply_prh_year      = $this->apply_prh_year;
        $user_model->apply_prh_month     = $this->apply_prh_month;
        $user_model->apply_prh_day       = $this->apply_prh_day;
        $user_model->app_gender          = $this->app_gender;
        $user_model->app_born_date       = $this->app_born_date;
        // $user_model->app_born_type       = $this->app_born_type;
        $user_model->app_id_type         = $this->app_id_type;
        $user_model->app_id_no           = $this->app_id_no;
        $user_model->app_marriage_status = $this->app_marriage_status;
        $user_model->app_chronic_patient = $this->app_chronic_patient;
        $user_model->app_working_status  = $this->app_working_status;
        $user_model->app_career          = $this->app_career;
        $user_model->app_income          = $this->app_income;
        $user_model->app_funding_type    = $this->app_funding_type;
        $user_model->app_funding_value   = $this->app_funding_value;
        $user_model->app_asset           = $this->app_asset;
        $user_model->app_asset_type      = $this->app_asset_type;
        $user_model->app_asset_value     = $this->app_asset_value;
        $user_model->app_deposit         = $this->app_deposit;

        $user_model->m1_chi_name         = $this->m1_chi_name;
        $user_model->m1_eng_name         = $this->m1_eng_name;
        $user_model->m1_gender           = $this->m1_gender;
        $user_model->m1_born_date        = $this->m1_born_date;
        // $user_model->m1_born_type        = $this->m1_born_type;
        $user_model->m1_id_type          = $this->m1_id_type;
        $user_model->m1_id_no            = $this->m1_id_no;
        $user_model->m1_relationship     = $this->m1_relationship;
        $user_model->m1_marriage_status  = $this->m1_marriage_status;
        $user_model->m1_chronic_patient  = $this->m1_chronic_patient;
        $user_model->m1_special_study    = $this->m1_special_study;
        $user_model->m1_working_status   = $this->m1_working_status;
        $user_model->m1_career           = $this->m1_career;
        $user_model->m1_income           = $this->m1_income;
        $user_model->m1_funding_type     = $this->m1_funding_type;
        $user_model->m1_funding_value    = $this->m1_funding_value;
        $user_model->m1_asset            = $this->m1_asset;
        $user_model->m1_asset_type       = $this->m1_asset_type;
        $user_model->m1_asset_value      = $this->m1_asset_value;
        $user_model->m1_deposit          = $this->m1_deposit;

        $user_model->m2_chi_name         = $this->m2_chi_name;
        $user_model->m2_eng_name         = $this->m2_eng_name;
        $user_model->m2_gender           = $this->m2_gender;
        $user_model->m2_born_date        = $this->m2_born_date;
        // $user_model->m2_born_type        = $this->m2_born_type;
        $user_model->m2_id_type          = $this->m2_id_type;
        $user_model->m2_id_no            = $this->m2_id_no;
        $user_model->m2_relationship     = $this->m2_relationship;
        $user_model->m2_marriage_status  = $this->m2_marriage_status;
        $user_model->m2_chronic_patient  = $this->m2_chronic_patient;
        $user_model->m2_special_study    = $this->m2_special_study;
        $user_model->m2_working_status   = $this->m2_working_status;
        $user_model->m2_career           = $this->m2_career;
        $user_model->m2_income           = $this->m2_income;
        $user_model->m2_funding_type     = $this->m2_funding_type;
        $user_model->m2_funding_value    = $this->m2_funding_value;
        $user_model->m2_asset            = $this->m2_asset;
        $user_model->m2_asset_type       = $this->m2_asset_type;
        $user_model->m2_asset_value      = $this->m2_asset_value;
        $user_model->m2_deposit          = $this->m2_deposit;
        
        $user_model->m3_chi_name         = $this->m3_chi_name;
        $user_model->m3_eng_name         = $this->m3_eng_name;
        $user_model->m3_gender           = $this->m3_gender;
        $user_model->m3_born_date        = $this->m3_born_date;
        // $user_model->m3_born_type        = $this->m3_born_type;
        $user_model->m3_id_type          = $this->m3_id_type;
        $user_model->m3_id_no            = $this->m3_id_no;
        $user_model->m3_relationship     = $this->m3_relationship;
        $user_model->m3_marriage_status  = $this->m3_marriage_status;
        $user_model->m3_chronic_patient  = $this->m3_chronic_patient;
        $user_model->m3_special_study    = $this->m3_special_study;
        $user_model->m3_working_status   = $this->m3_working_status;
        $user_model->m3_career           = $this->m3_career;
        $user_model->m3_income           = $this->m3_income;
        $user_model->m3_funding_type     = $this->m3_funding_type;
        $user_model->m3_funding_value    = $this->m3_funding_value;
        $user_model->m3_asset            = $this->m3_asset;
        $user_model->m3_asset_type       = $this->m3_asset_type;
        $user_model->m3_asset_value      = $this->m3_asset_value;
        $user_model->m3_deposit          = $this->m3_deposit;
        
        $user_model->m4_chi_name         = $this->m4_chi_name;
        $user_model->m4_eng_name         = $this->m4_eng_name;
        $user_model->m4_gender           = $this->m4_gender;
        $user_model->m4_born_date        = $this->m4_born_date;
        // $user_model->m4_born_type        = $this->m4_born_type;
        $user_model->m4_id_type          = $this->m4_id_type;
        $user_model->m4_id_no            = $this->m4_id_no;
        $user_model->m4_relationship     = $this->m4_relationship;
        $user_model->m4_marriage_status  = $this->m4_marriage_status;
        $user_model->m4_chronic_patient  = $this->m4_chronic_patient;
        $user_model->m4_special_study    = $this->m4_special_study;
        $user_model->m4_working_status   = $this->m4_working_status;
        $user_model->m4_career           = $this->m4_career;
        $user_model->m4_income           = $this->m4_income;
        $user_model->m4_funding_type     = $this->m4_funding_type;
        $user_model->m4_funding_value    = $this->m4_funding_value;
        $user_model->m4_asset            = $this->m4_asset;
        $user_model->m4_asset_type       = $this->m4_asset_type;
        $user_model->m4_asset_value      = $this->m4_asset_value;
        $user_model->m4_deposit          = $this->m4_deposit;
        
        $user_model->m5_chi_name         = $this->m5_chi_name;
        $user_model->m5_eng_name         = $this->m5_eng_name;
        $user_model->m5_gender           = $this->m5_gender;
        $user_model->m5_born_date        = $this->m5_born_date;
        // $user_model->m5_born_type        = $this->m5_born_type;
        $user_model->m5_id_type          = $this->m5_id_type;
        $user_model->m5_id_no            = $this->m5_id_no;
        $user_model->m5_relationship     = $this->m5_relationship;
        $user_model->m5_marriage_status  = $this->m5_marriage_status;
        $user_model->m5_chronic_patient  = $this->m5_chronic_patient;
        $user_model->m5_special_study    = $this->m5_special_study;
        $user_model->m5_working_status   = $this->m5_working_status;
        $user_model->m5_career           = $this->m5_career;
        $user_model->m5_income           = $this->m5_income;
        $user_model->m5_funding_type     = $this->m5_funding_type;
        $user_model->m5_funding_value    = $this->m5_funding_value;
        $user_model->m5_asset            = $this->m5_asset;
        $user_model->m5_asset_type       = $this->m5_asset_type;
        $user_model->m5_asset_value      = $this->m5_asset_value;
        $user_model->m5_deposit          = $this->m5_deposit;
        
        $user_model->single_parents      = $this->single_parents;
        $user_model->pregnant            = $this->pregnant;
        $user_model->pregnant_period     = $this->pregnant_period;
        $user_model->total_income        = $this->total_income;
        $user_model->total_funding       = $this->total_funding;
        $user_model->total_asset         = $this->total_asset;
        $user_model->social_worker_name  = $this->social_worker_name;
        $user_model->social_worker_phone = $this->social_worker_phone;
        $user_model->social_worker_email = $this->social_worker_email;

        $user_model->save(false);
    }
    */
}
