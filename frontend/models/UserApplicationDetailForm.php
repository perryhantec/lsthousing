<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\imagine\Image;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;
use common\models\User;

class UserApplicationDetailForm extends User
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
    public $fix_chi_name;
    public $fix_eng_name;
    public $fix_mobile;
    public $fix_email;
    public $app_chi_name;
    public $app_eng_name;
    public $app_relationship;
    public $app_special_study;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return  [
            // [['name', 'phone', 'email'], 'required'],
            // [['status', 'updated_UID'], 'integer'],
            // [['items', 'old_and_new'], 'required'],
            // [['items', 'old_and_new'], 'string'],
            // [['created_at', 'updated_at'], 'safe'],
            // [['name'], 'string', 'max' => 255],
            // [['phone'], 'string', 'max' => 16],
            // [['email'], 'email'],
            // [['upload_files'], 'file', 'uploadRequired' => true, 'mimeTypes' => 'image/*', 'minFiles' => 1, 'maxFiles' => 5, 'maxSize' => 5000000],
            // ['verifyCode', 'captcha'],

            [[
                'house_type', 'private_type', 'together_type', 'prh', 'prh_location','app_gender'/*, 'app_born_type'*/, 'app_id_type', 'app_marriage_status',
                'app_working_status', 'app_asset', 'single_parents', 'pregnant',
            ], 'integer'],
            [['pregnant_period'], 'integer', 'min' => 16],
            [['area', 'family_member'], 'integer', 'min' => 1],
            [[
                'live_rent', 'app_income', 'app_funding_value', 'app_asset_value', 'app_deposit',
                'total_income', 'total_funding', 'total_asset',
            ], 'number', 'min' => 0],

            [['live_year'], 'integer', 'min' => 0, 'max' => 21],
            [['live_month'], 'integer', 'min' => 1, 'max' => 11],
            [['apply_prh_year'], 'integer', 'min' => 1970, 'max' => date("Y")],
            [['apply_prh_month'], 'integer', 'min' => 1, 'max' => 12],
            [['apply_prh_day'], 'integer', 'min' => 1, 'max' => 31],
            [[
                'phone', 'house_type_other', 'together_type_other', 'prh_no', 'app_born_date', 'app_chronic_patient', 'app_id_no',
                'app_career', 'app_asset_type', 'social_worker_name', 'social_worker_phone', 'social_worker_email'
            ], 'string', 'max' => 255],
            [['app_funding_type', 'm1_funding_type', 'm2_funding_type', 'm3_funding_type', 'm4_funding_type', 'm5_funding_type'], 'each', 'rule' => ['integer']],

            [[
                'm1_gender'/*, 'm1_born_type'*/, 'm1_id_type', 'm1_marriage_status', 'm1_special_study', 'm1_working_status', 'm1_asset',
            ], 'integer'],
            [['m1_income', 'm1_funding_value', 'm1_asset_value', 'm1_deposit'], 'number', 'min' => 0],

            [[
                'm1_chi_name', 'm1_eng_name', 'm1_born_date', 'm1_chronic_patient', 'm1_id_no', 'm1_relationship', 'm1_career', 'm1_asset_type',
            ], 'string', 'max' => 255],

            [[
                'm2_gender'/*, 'm2_born_type'*/, 'm2_id_type', 'm2_marriage_status', 'm2_special_study', 'm2_working_status', 'm2_asset',
            ], 'integer'],
            [['m2_income', 'm2_funding_value', 'm2_asset_value', 'm2_deposit'], 'number', 'min' => 0],

            [[
                'm2_chi_name', 'm2_eng_name', 'm2_born_date', 'm2_chronic_patient', 'm2_id_no', 'm2_relationship', 'm2_career', 'm2_asset_type',
            ], 'string', 'max' => 255],

            [[
                'm3_gender'/*, 'm3_born_type'*/, 'm3_id_type', 'm3_marriage_status', 'm3_special_study', 'm3_working_status', 'm3_asset',
            ], 'integer'],
            [['m3_income', 'm3_funding_value', 'm3_asset_value', 'm3_deposit'], 'number', 'min' => 0],

            [[
                'm3_chi_name', 'm3_eng_name', 'm3_born_date', 'm3_chronic_patient', 'm3_id_no', 'm3_relationship', 'm3_career', 'm3_asset_type',
            ], 'string', 'max' => 255],

            [[
                'm4_gender'/*, 'm4_born_type'*/, 'm4_id_type', 'm4_marriage_status', 'm4_special_study', 'm4_working_status', 'm4_asset',
            ], 'integer'],
            [['m4_income', 'm4_funding_value', 'm4_asset_value', 'm4_deposit'], 'number', 'min' => 0],

            [[
                'm4_chi_name', 'm4_eng_name', 'm4_born_date', 'm4_chronic_patient', 'm4_id_no', 'm4_relationship', 'm4_career', 'm4_asset_type',
            ], 'string', 'max' => 255],

            [[
                'm5_gender'/*, 'm5_born_type'*/, 'm5_id_type', 'm5_marriage_status', 'm5_special_study', 'm5_working_status', 'm5_asset',
            ], 'integer'],
            [['m5_income', 'm5_funding_value', 'm5_asset_value', 'm5_deposit'], 'number', 'min' => 0],

            [[
                'm5_chi_name', 'm5_eng_name', 'm5_born_date', 'm5_chronic_patient', 'm5_id_no', 'm5_relationship', 'm5_career', 'm5_asset_type',
            ], 'string', 'max' => 255],

            [['address'], 'string'],
            [['phone', 'mobile'], 'string', 'max' => 8],
            [['phone'], 'checkPhone'],

            /**** part 1 ***/
            // [[
            //     'chi_name', 'eng_name', 'mobile', 'address', 'area', 'house_type', 'live_rent', 'live_year',
            //     'family_member', 'prh_no', 'prh_location','apply_prh_year', 'apply_prh_month'
            // ], 'required'],
            // [['house_type_other'], 'required', 'when' => function ($model) {
            //     return $model->house_type == 7;
            // }, 'message' => '如果上面選擇其他，{attribute} 不能為空白'],

            /**** part 2 & 3 ***/
            // applicant
            // [[
            //     'app_gender', 'app_born_date', 'app_id_type', 'app_id_no', 'app_marriage_status', 'app_working_status',
            //     'app_income', 'app_asset', 'app_deposit',
            // ], 'required'],
            // [['app_career'], 'required', 'when' => function ($model) {
            //     return $model->app_working_status == 1 || $model->app_working_status == 2;
            // }, 'message' => '如果上面選擇全職或兼職，{attribute} 不能為空白'],
            // [['app_funding_value'], 'required', 'when' => function ($model) {
            //     return $model->app_funding_type > 0;
            // }, 'message' => '如果上面選擇任何選項的資助，{attribute} 不能為空白'],
            // [['app_asset_type', 'app_asset_value'], 'required', 'when' => function ($model) {
            //     return $model->app_asset == 1;
            // }, 'message' => '如果上面選擇有資產，{attribute} 不能為空白'],

            // family member 1
            // [[
            //     'm1_chi_name', 'm1_eng_name', 'm1_gender', 'm1_born_date', 'm1_id_type', 'm1_id_no', 'm1_relationship',
            //     'm1_marriage_status', 'm1_working_status', 'm1_income', 'm1_asset', 'm1_deposit',
            // ], 'required', 'when' => function ($model) {
            //     return $model->family_member > 1;
            // }, 'message' => '如果家庭成員多於一人，{attribute} 不能為空白'],
            // [['m1_career'], 'required', 'when' => function ($model) {
            //     return $model->m1_working_status == 1 || $model->m1_working_status == 2;
            // }, 'message' => '如果家庭成員多於一人及上面選擇全職或兼職，{attribute} 不能為空白'],
            // [['m1_funding_value'], 'required', 'when' => function ($model) {
            //     return $model->family_member > 1 && $model->m1_funding_type > 0;
            // }, 'message' => '如果家庭成員多於一人及上面選擇任何選項的資助，{attribute} 不能為空白'],
            // [['m1_asset_type', 'm1_asset_value'], 'required', 'when' => function ($model) {
            //     return $model->family_member > 1 && $model->m1_asset == 1;
            // }, 'message' => '如果家庭成員多於一人及上面選擇有資產，{attribute} 不能為空白'],

            // other
            // [['single_parents', 'pregnant', 'total_income', 'total_funding', 'total_asset'], 'required'],
            // [['pregnant_period'], 'required', 'when' => function ($model) {
            //     return $model->pregnant == 1;
            // }, 'message' => '如果上面選擇有懷孕16週或以上成員，{attribute} 不能為空白'],
            /**** part 4 ***/
            // [['social_worker_name', 'social_worker_phone', 'social_worker_email'], 'required'],
            /**** part 5 ***/
            // [['part5_t1', 'part5_t2', 'part5_t3', 'part5_t4', 'part5_t5', 'part5_t6'], 'required'],
            /**** part 6 ***/
            // [['part6_t1'], 'required'],
        ];
    }

    public function checkPhone ($attribute) {
        if ((int)$this->phone < 10000000 || (int)$this->phone > 99999999) {
            $this->addError($attribute, '請輸入正確電話號碼');
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
                // 'upload_files' => Yii::t('in-kind-donation', 'Images'),
                // 'verifyCode' => Yii::t('app', 'Verification Code'),
                // 'part5_t1'          => '此項聲明及承諾',
                // 'part5_t2'          => '此項聲明及承諾',
                // 'part5_t3'          => '此項聲明及承諾',
                // 'part5_t4'          => '此項聲明及承諾',
                // 'part5_t5'          => '此項聲明及承諾',
                // 'part5_t6'          => '此項聲明及承諾',
                // 'part6_t1'          => '此項聲明',
                'fix_chi_name'      => '中文姓名',
                'fix_eng_name'      => '英文姓名',
                'fix_mobile'        => '手提電話',
                'fix_email'         => '電郵地址',
                'app_chi_name'      => '中文姓名',
                'app_eng_name'      => '英文姓名',
                'app_relationship'  => '與申請人的關係',
                'app_special_study' => '如為特殊學習需要兒童, 請「✓」',
            ]
        );
    }

    public function submit(){
        if ($this->validate()) {
            if ($this->oAuth_user != 1) {
                // $this->email = $this->username;
                // if ($this->new_password == "" || ($this->new_password != "" && self::validatePassword($this->old_password))) {
                    return $this->save();
                // }
            } else
                return $this->save();
        }
        return false;
    }
}
