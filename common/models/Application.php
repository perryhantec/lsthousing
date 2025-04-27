<?php

namespace common\models;

use Yii;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7;
use yii\helpers\Html;
use yii\helpers\Url;

class Application extends \yii\db\ActiveRecord
{
    public $app_no;
    public $user_mobile;
    public $user_appl_status;

    public $app_chi_name;
    public $app_eng_name;
    public $app_relationship;
    public $app_special_study;

    public $application_chi_name;
    public $application_eng_name;
    public $application_no;
    public $application_created_at;
    public $application_priority_1;
    public $application_priority_2;
    public $application_priority_3;
    public $application_family_member;

    const STATUS_CANCELED = -100;
    const STATUS_SUBMITED = 50;
    const STATUS_WAITING_FOR_PROCESS = 60;
    const STATUS_CONFIRMED = 70;
    const STATUS_END = 100;

    const APPL_NO_PREFIX = 'LSTH';
    const APPL_NO_LENGTH = 12;
    const MEDIAN_MONTHLY_INCOME = 19600;
    
    const APPL_STATUS_ALLOCATE_UNIT_FAILED = -20;
    const APPL_STATUS_REJECTED = -10;
    const APPL_STATUS_SUBMITED_FORM = 10;
    const APPL_STATUS_UPDATE_SUBMITED_FORM = 15;
    const APPL_STATUS_UPLOAD_FILES = 20;
    const APPL_STATUS_UPLOAD_FILES_AGAIN = 30;
    const APPL_STATUS_FILES_PASSED = 40;
    const APPL_STATUS_ALLOCATED_UNIT = 50;
    const APPL_STATUS_ALLOCATED_OTHER_UNIT = 60;
    const APPL_STATUS_WITHDREW = 70;

    const CIPHERING_VALUE = "AES-128-CTR";  
    const ENCRYPTION_KEY = "LSThousing";
    const IV = "Y2M9gEtLL6xbG6mb";
    // const NOT_APPROVED = 1;
    const APPROVED = 2;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'application';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [[
                'priority_1', 'priority_2', 'priority_3', 'area', 'house_type', 'private_type', 'together_type', 'live_year', 'live_month', 'family_member',
                'prh', 'prh_location', 'apply_prh_year', 'apply_prh_month', 'apply_prh_day', 'app_gender'/*, 'app_born_type'*/, 'app_id_type', 'app_marriage_status',
                'app_working_status', 'app_asset', 'single_parents', 'pregnant', 'pregnant_period', 'user_id', 'application_status'
            ], 'integer'],
            [[
                'live_rent', 'app_income', 'app_funding_value', 'app_asset_value', 'app_deposit',
                'total_income', 'total_funding', 'total_asset',
            ], 'number'],
            [[
                'chi_name', 'eng_name', 'email', 'house_type_other', 'together_type_other', 'prh_no', 'app_born_date', 'app_chronic_patient', 'app_id_no', 'app_career',
                'app_asset_type', 'social_worker_name', 'social_worker_email', 'appl_no'
            ], 'string', 'max' => 255],
            [['app_funding_type', 'm1_funding_type', 'm2_funding_type', 'm3_funding_type', 'm4_funding_type', 'm5_funding_type'], 'each', 'rule' => ['integer']],
            
            [[
                'm1_gender'/*, 'm1_born_type'*/, 'm1_id_type', 'm1_marriage_status', 'm1_special_study', 'm1_working_status', 'm1_asset', 
            ], 'integer'],
            [[
                'm1_income', 'm1_funding_value', 'm1_asset_value', 'm1_deposit',
            ], 'number'],
            [[
                'm1_chi_name', 'm1_eng_name', 'm1_born_date', 'm1_chronic_patient', 'm1_id_no', 'm1_relationship', 'm1_career', 'm1_asset_type',
            ], 'string', 'max' => 255],

            [[
                'm2_gender'/*, 'm2_born_type'*/, 'm2_id_type', 'm2_marriage_status', 'm2_special_study', 'm2_working_status', 'm2_asset', 
            ], 'integer'],
            [[
                'm2_income', 'm2_funding_value', 'm2_asset_value', 'm2_deposit',
            ], 'number'],
            [[
                'm2_chi_name', 'm2_eng_name', 'm2_born_date', 'm2_chronic_patient', 'm2_id_no', 'm2_relationship', 'm2_career', 'm2_asset_type',
            ], 'string', 'max' => 255],
            
            [[
                'm3_gender'/*, 'm3_born_type'*/, 'm3_id_type', 'm3_marriage_status', 'm3_special_study', 'm3_working_status', 'm3_asset', 
            ], 'integer'],
            [[
                'm3_income', 'm3_funding_value', 'm3_asset_value', 'm3_deposit',
            ], 'number'],
            [[
                'm3_chi_name', 'm3_eng_name', 'm3_born_date', 'm3_chronic_patient', 'm3_id_no', 'm3_relationship', 'm3_career', 'm3_asset_type',
            ], 'string', 'max' => 255],

            [[
                'm4_gender'/*, 'm4_born_type'*/, 'm4_id_type', 'm4_marriage_status', 'm4_special_study', 'm4_working_status', 'm4_asset', 
            ], 'integer'],
            [[
                'm4_income', 'm4_funding_value', 'm4_asset_value', 'm4_deposit',
            ], 'number'],
            [[
                'm4_chi_name', 'm4_eng_name', 'm4_born_date', 'm4_chronic_patient', 'm4_id_no', 'm4_relationship', 'm4_career', 'm4_asset_type',
            ], 'string', 'max' => 255],

            [[
                'm5_gender'/*, 'm5_born_type'*/, 'm5_id_type', 'm5_marriage_status', 'm5_special_study', 'm5_working_status', 'm5_asset', 
            ], 'integer'],
            [[
                'm5_income', 'm5_funding_value', 'm5_asset_value', 'm5_deposit',
            ], 'number'],
            [[
                'm5_chi_name', 'm5_eng_name', 'm5_born_date', 'm5_chronic_patient', 'm5_id_no', 'm5_relationship', 'm5_career', 'm5_asset_type',
            ], 'string', 'max' => 255],

            [['mobile', 'address'], 'string'],
            [['phone', 'social_worker_phone'], 'string', 'max' => 8],
            [['created_at', 'updated_at'], 'safe'],

            [['visit_date', 'visit_record', 'room_no', 'start_date', 'withdrew_date', 'reject_reason'], 'string'],
            [['project', 'approved'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'priority_1' => '第一優先選擇',
            'priority_2' => '第二優先選擇',
            'priority_3' => '第三優先選擇',
            'chi_name' => '姓名(中文)',
            'eng_name' => '姓名(英文)',
            'phone' => '住宅電話',
            'mobile' => '手提電話',
            'address' => '居住地址',
            'area' => '單位面積(平方呎)',
            'email' => '電郵地址',
            'house_type' => '現時居住房屋種類',
            'house_type_other' => '其他(請註明)',
            'private_type' => '私人樓宇種類',
            'together_type' => '同住房屋種類',
            'together_type_other' => '其他(請註明)',
            'live_rent' => '過去3個月的平均租金(不包括水電費)',
            'live_year' => '已居於目前單位(年)',
            'live_month' => '已居於目前單位(月)',
            'family_member' => '家庭成員數目',
            'prh' => '有沒有申請公屋',
            'prh_no' => '公屋申請編號',
            'prh_location' => '申請公屋地點',
            'apply_prh_year' => '申請公屋日期(年份)',
            'apply_prh_month' => '申請公屋日期(月)',
            'apply_prh_day' => '申請公屋日期(日)',
            'app_gender' => '性別',
            'app_born_date' => '出生日期(日/月/年)',
            // 'app_born_type' => '',
            'app_id_type' => '身份證明文件類別',
            'app_id_no' => '身份證明文件號碼',
            'app_marriage_status' => '婚姻狀況',
            'app_chronic_patient' => '長期病患(請說明)',
            'app_working_status' => '工作狀況',
            'app_career' => '職業',
            'app_income' => '過去3個月每月平均收入',
            'app_funding_type' => '現正領取的政府資助',
            'app_funding_value' => '資助總額',
            'app_asset' => '個人資產(需遞交相關證明文件)',
            'app_asset_type' => '個人資產種類',
            'app_asset_value' => '個人資產總值',
            'app_deposit' => '存款/現金',

            'm1_chi_name' => '中文姓名',
            'm1_eng_name' => '英文姓名',
            'm1_gender' => '性別',
            'm1_born_date' => '出生日期(日/月/年)',
            // 'm1_born_type' => '',
            'm1_id_type' => '身份證明文件類別',
            'm1_id_no' => '身份證明文件號碼',
            'm1_relationship' => '與申請人關係',
            'm1_marriage_status' => '婚姻狀況',
            'm1_chronic_patient' => '長期病患(請說明)',
            'm1_special_study' => '如為特殊學習需要兒童, 請「✓」',
            'm1_working_status' => '工作狀況',
            'm1_career' => '職業',
            'm1_income' => '過去3個月每月平均收入',
            'm1_funding_type' => '現正領取的政府資助',
            'm1_funding_value' => '資助總額',
            'm1_asset' => '個人資產(需遞交相關證明文件)',
            'm1_asset_type' => '個人資產種類',
            'm1_asset_value' => '個人資產總值',
            'm1_deposit' => '存款/現金',

            'm2_chi_name' => '中文姓名',
            'm2_eng_name' => '英文姓名',
            'm2_gender' => '性別',
            'm2_born_date' => '出生日期(日/月/年)',
            // 'm2_born_type' => '',
            'm2_id_type' => '身份證明文件類別',
            'm2_id_no' => '身份證明文件號碼',
            'm2_relationship' => '與申請人關係',
            'm2_marriage_status' => '婚姻狀況',
            'm2_chronic_patient' => '長期病患(請說明)',
            'm2_special_study' => '如為特殊學習需要兒童, 請「✓」',
            'm2_working_status' => '工作狀況',
            'm2_career' => '職業',
            'm2_income' => '過去3個月每月平均收入',
            'm2_funding_type' => '現正領取的政府資助',
            'm2_funding_value' => '資助總額',
            'm2_asset' => '個人資產(需遞交相關證明文件)',
            'm2_asset_type' => '個人資產種類',
            'm2_asset_value' => '個人資產總值',
            'm2_deposit' => '存款/現金',

            'm3_chi_name' => '中文姓名',
            'm3_eng_name' => '英文姓名',
            'm3_gender' => '性別',
            'm3_born_date' => '出生日期(日/月/年)',
            // 'm3_born_type' => '',
            'm3_id_type' => '身份證明文件類別',
            'm3_id_no' => '身份證明文件號碼',
            'm3_relationship' => '與申請人關係',
            'm3_marriage_status' => '婚姻狀況',
            'm3_chronic_patient' => '長期病患(請說明)',
            'm3_special_study' => '如為特殊學習需要兒童, 請「✓」',
            'm3_working_status' => '工作狀況',
            'm3_career' => '職業',
            'm3_income' => '過去3個月每月平均收入',
            'm3_funding_type' => '現正領取的政府資助',
            'm3_funding_value' => '資助總額',
            'm3_asset' => '個人資產(需遞交相關證明文件)',
            'm3_asset_type' => '個人資產種類',
            'm3_asset_value' => '個人資產總值',
            'm3_deposit' => '存款/現金',

            'm4_chi_name' => '中文姓名',
            'm4_eng_name' => '英文姓名',
            'm4_gender' => '性別',
            'm4_born_date' => '出生日期(日/月/年)',
            // 'm4_born_type' => '',
            'm4_id_type' => '身份證明文件類別',
            'm4_id_no' => '身份證明文件號碼',
            'm4_relationship' => '與申請人關係',
            'm4_marriage_status' => '婚姻狀況',
            'm4_chronic_patient' => '長期病患(請說明)',
            'm4_special_study' => '如為特殊學習需要兒童, 請「✓」',
            'm4_working_status' => '工作狀況',
            'm4_career' => '職業',
            'm4_income' => '過去3個月每月平均收入',
            'm4_funding_type' => '現正領取的政府資助',
            'm4_funding_value' => '資助總額',
            'm4_asset' => '個人資產(需遞交相關證明文件)',
            'm4_asset_type' => '個人資產種類',
            'm4_asset_value' => '個人資產總值',
            'm4_deposit' => '存款/現金',

            'm5_chi_name' => '中文姓名',
            'm5_eng_name' => '英文姓名',
            'm5_gender' => '性別',
            'm5_born_date' => '出生日期(日/月/年)',
            // 'm5_born_type' => '',
            'm5_id_type' => '身份證明文件類別',
            'm5_id_no' => '身份證明文件號碼',
            'm5_relationship' => '與申請人關係',
            'm5_marriage_status' => '婚姻狀況',
            'm5_chronic_patient' => '長期病患(請說明)',
            'm5_special_study' => '如為特殊學習需要兒童, 請「✓」',
            'm5_working_status' => '工作狀況',
            'm5_career' => '職業',
            'm5_income' => '過去3個月每月平均收入',
            'm5_funding_type' => '現正領取的政府資助',
            'm5_funding_value' => '資助總額',
            'm5_asset' => '個人資產(需遞交相關證明文件)',
            'm5_asset_type' => '個人資產種類',
            'm5_asset_value' => '個人資產總值',
            'm5_deposit' => '存款/現金',
            
            'single_parents' => '單親家庭',
            'pregnant' => '家庭成員懷孕滿16週或上',
            'pregnant_period' => '懷孕週期',
            'total_income' => '過去3個月申請人及家庭成員總收入',
            'total_funding' => '過去3個月政府資助總額',
            'total_asset' => '家庭總資產淨值',
            'social_worker_name' => '轉介社工姓名',
            'social_worker_phone' => '聯絡電話',
            'social_worker_email' => '電郵',

            'appl_no' => '申請編號',
            'application_status' => '申請狀態',
            'reject_reason' => '拒絕原因(如適用)',
            'created_at' => '新增日期',
            'updated_at' => '更新日期',

            'app_no' => '申請人編號',
            'user_mobile' => '流動電話號碼',
            'user_appl_status' => '申請人狀態',

            'app_chi_name'      => '中文姓名',
            'app_eng_name'      => '英文姓名',
            'app_relationship'  => '與申請人的關係',
            'app_special_study' => '是否特殊學習需要兒童',
            'application_mark'  => '評分',

            'application_chi_name' => '申請人姓名(中文)',
            'application_eng_name' => '申請人姓名(英文)',
            'application_no' => '申請編號',
            'application_created_at' => '評審日期',
            'application_priority_1' => '入住計劃(第一優先選擇)',
            'application_priority_2' => '入住計劃(第二優先選擇)',
            'application_priority_3' => '入住計劃(第三優先選擇)',
            'application_family_member' => '申請入住人數',

            'visit_date'            => '家訪日期',
            'visit_record'          => '文字紀錄',
            'approved'              => '申請批核狀態',
            'project'               => '項目名稱',
            'room_no'               => '房間編號',
            'start_date'            => '起租日期',
            'withdrew_date'         => '退租日期',
        ];
    }

    public function afterFind()
    {
        parent::afterFind();
        $this->app_funding_type = json_decode($this->app_funding_type);
        $this->m1_funding_type  = json_decode($this->m1_funding_type);
        $this->m2_funding_type  = json_decode($this->m2_funding_type);
        $this->m3_funding_type  = json_decode($this->m3_funding_type);
        $this->m4_funding_type  = json_decode($this->m4_funding_type);
        $this->m5_funding_type  = json_decode($this->m5_funding_type);
        if (!is_array($this->app_funding_type))
            $this->app_funding_type = [];
        if (!is_array($this->m1_funding_type))
            $this->m1_funding_type = [];
        if (!is_array($this->m2_funding_type))
            $this->m2_funding_type = [];
        if (!is_array($this->m3_funding_type))
            $this->m3_funding_type = [];
        if (!is_array($this->m4_funding_type))
            $this->m4_funding_type = [];
        if (!is_array($this->m5_funding_type))
            $this->m5_funding_type = [];

        $this->chi_name  = openssl_decrypt($this->chi_name, self::CIPHERING_VALUE, self::ENCRYPTION_KEY, 0, self::IV);
        $this->eng_name  = openssl_decrypt($this->eng_name, self::CIPHERING_VALUE, self::ENCRYPTION_KEY, 0, self::IV);
        $this->mobile    = openssl_decrypt($this->mobile, self::CIPHERING_VALUE, self::ENCRYPTION_KEY, 0, self::IV);
        $this->app_id_no = openssl_decrypt($this->app_id_no, self::CIPHERING_VALUE, self::ENCRYPTION_KEY, 0, self::IV);

        $this->m1_chi_name = openssl_decrypt($this->m1_chi_name, self::CIPHERING_VALUE, self::ENCRYPTION_KEY, 0, self::IV);
        $this->m1_eng_name = openssl_decrypt($this->m1_eng_name, self::CIPHERING_VALUE, self::ENCRYPTION_KEY, 0, self::IV);
        $this->m1_id_no    = openssl_decrypt($this->m1_id_no, self::CIPHERING_VALUE, self::ENCRYPTION_KEY, 0, self::IV);

        $this->m2_chi_name = openssl_decrypt($this->m2_chi_name, self::CIPHERING_VALUE, self::ENCRYPTION_KEY, 0, self::IV);
        $this->m2_eng_name = openssl_decrypt($this->m2_eng_name, self::CIPHERING_VALUE, self::ENCRYPTION_KEY, 0, self::IV);
        $this->m2_id_no    = openssl_decrypt($this->m2_id_no, self::CIPHERING_VALUE, self::ENCRYPTION_KEY, 0, self::IV); 

        $this->m3_chi_name = openssl_decrypt($this->m3_chi_name, self::CIPHERING_VALUE, self::ENCRYPTION_KEY, 0, self::IV);
        $this->m3_eng_name = openssl_decrypt($this->m3_eng_name, self::CIPHERING_VALUE, self::ENCRYPTION_KEY, 0, self::IV);
        $this->m3_id_no    = openssl_decrypt($this->m3_id_no, self::CIPHERING_VALUE, self::ENCRYPTION_KEY, 0, self::IV);

        $this->m4_chi_name = openssl_decrypt($this->m4_chi_name, self::CIPHERING_VALUE, self::ENCRYPTION_KEY, 0, self::IV);
        $this->m4_eng_name = openssl_decrypt($this->m4_eng_name, self::CIPHERING_VALUE, self::ENCRYPTION_KEY, 0, self::IV);
        $this->m4_id_no    = openssl_decrypt($this->m4_id_no, self::CIPHERING_VALUE, self::ENCRYPTION_KEY, 0, self::IV);

        $this->m5_chi_name = openssl_decrypt($this->m5_chi_name, self::CIPHERING_VALUE, self::ENCRYPTION_KEY, 0, self::IV);
        $this->m5_eng_name = openssl_decrypt($this->m5_eng_name, self::CIPHERING_VALUE, self::ENCRYPTION_KEY, 0, self::IV);
        $this->m5_id_no    = openssl_decrypt($this->m5_id_no, self::CIPHERING_VALUE, self::ENCRYPTION_KEY, 0, self::IV);
    }

    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }
        
        $this->app_funding_type = json_encode($this->app_funding_type);
        $this->m1_funding_type  = json_encode($this->m1_funding_type);
        $this->m2_funding_type  = json_encode($this->m2_funding_type);
        $this->m3_funding_type  = json_encode($this->m3_funding_type);
        $this->m4_funding_type  = json_encode($this->m4_funding_type);
        $this->m5_funding_type  = json_encode($this->m5_funding_type);

        $this->chi_name  = $this->chi_name ? openssl_encrypt($this->chi_name, self::CIPHERING_VALUE, self::ENCRYPTION_KEY, 0, self::IV) : null;
        $this->eng_name  = $this->eng_name ? openssl_encrypt($this->eng_name, self::CIPHERING_VALUE, self::ENCRYPTION_KEY, 0, self::IV) : null;
        $this->mobile    = openssl_encrypt($this->mobile, self::CIPHERING_VALUE, self::ENCRYPTION_KEY, 0, self::IV);
        $this->app_id_no = $this->app_id_no ? openssl_encrypt($this->app_id_no, self::CIPHERING_VALUE, self::ENCRYPTION_KEY, 0, self::IV) : null;

        $this->m1_chi_name = $this->m1_chi_name ? openssl_encrypt($this->m1_chi_name, self::CIPHERING_VALUE, self::ENCRYPTION_KEY, 0, self::IV) : null;
        $this->m1_eng_name = $this->m1_eng_name ? openssl_encrypt($this->m1_eng_name, self::CIPHERING_VALUE, self::ENCRYPTION_KEY, 0, self::IV) : null;
        $this->m1_id_no    = $this->m1_id_no ? openssl_encrypt($this->m1_id_no, self::CIPHERING_VALUE, self::ENCRYPTION_KEY, 0, self::IV) : null;

        $this->m2_chi_name = $this->m2_chi_name ? openssl_encrypt($this->m2_chi_name, self::CIPHERING_VALUE, self::ENCRYPTION_KEY, 0, self::IV) : null;
        $this->m2_eng_name = $this->m2_eng_name ? openssl_encrypt($this->m2_eng_name, self::CIPHERING_VALUE, self::ENCRYPTION_KEY, 0, self::IV) : null;
        $this->m2_id_no    = $this->m2_id_no ? openssl_encrypt($this->m2_id_no, self::CIPHERING_VALUE, self::ENCRYPTION_KEY, 0, self::IV) : null;

        $this->m3_chi_name = $this->m3_chi_name ? openssl_encrypt($this->m3_chi_name, self::CIPHERING_VALUE, self::ENCRYPTION_KEY, 0, self::IV) : null;
        $this->m3_eng_name = $this->m3_eng_name ? openssl_encrypt($this->m3_eng_name, self::CIPHERING_VALUE, self::ENCRYPTION_KEY, 0, self::IV) : null;
        $this->m3_id_no    = $this->m3_id_no ? openssl_encrypt($this->m3_id_no, self::CIPHERING_VALUE, self::ENCRYPTION_KEY, 0, self::IV) : null;

        $this->m4_chi_name = $this->m4_chi_name ? openssl_encrypt($this->m4_chi_name, self::CIPHERING_VALUE, self::ENCRYPTION_KEY, 0, self::IV) : null;
        $this->m4_eng_name = $this->m4_eng_name ? openssl_encrypt($this->m4_eng_name, self::CIPHERING_VALUE, self::ENCRYPTION_KEY, 0, self::IV) : null;
        $this->m4_id_no    = $this->m4_id_no ? openssl_encrypt($this->m4_id_no, self::CIPHERING_VALUE, self::ENCRYPTION_KEY, 0, self::IV) : null;

        $this->m5_chi_name = $this->m5_chi_name ? openssl_encrypt($this->m5_chi_name, self::CIPHERING_VALUE, self::ENCRYPTION_KEY, 0, self::IV) : null;
        $this->m5_eng_name = $this->m5_eng_name ? openssl_encrypt($this->m5_eng_name, self::CIPHERING_VALUE, self::ENCRYPTION_KEY, 0, self::IV) : null;
        $this->m5_id_no    = $this->m5_id_no ? openssl_encrypt($this->m5_id_no, self::CIPHERING_VALUE, self::ENCRYPTION_KEY, 0, self::IV) : null;

        return true;
    }
    
    public function submit()
    {
        if (
            $this->application_status == Application::APPL_STATUS_UPLOAD_FILES_AGAIN && 
            isset($this->applicationResponseFiles) &&
            count($this->applicationResponseFiles) == 0
        ) {
            $this->application_status = Application::APPL_STATUS_UPLOAD_FILES;
        }

        if (
            $this->application_status == Application::APPL_STATUS_ALLOCATE_UNIT_FAILED ||
            $this->application_status == Application::APPL_STATUS_REJECTED
        ) {
            $this->room_no = null;
            $this->start_date = null;
            $this->withdrew_date = null;

            $user_model = User::findOne($this->user_id);
            $user_model->room_no = NULL;
            $user_model->start_date = NULL;
            $user_model->withdrew_date = NULL;
            $user_model->user_appl_status = User::USER_APPL_STATUS_ALLOCATE_UNIT_FAILED;
            $user_model->save(false);
        } else if (
            $this->application_status == Application::APPL_STATUS_ALLOCATED_UNIT ||
            $this->application_status == Application::APPL_STATUS_ALLOCATED_OTHER_UNIT
        ) {
            $this->withdrew_date = null;

            $user_model = User::findOne($this->user_id);
            $user_model->room_no = $this->room_no;
            $user_model->start_date = $this->start_date;
            $user_model->withdrew_date = NULL;
            $user_model->user_appl_status = User::USER_APPL_STATUS_ALLOCATED_UNIT;
            $user_model->save(false);
        } else if ($this->application_status == Application::APPL_STATUS_WITHDREW) {
            $user_model = User::findOne($this->user_id);
            $user_model->withdrew_date = $this->withdrew_date;
            $user_model->user_appl_status = User::USER_APPL_STATUS_WITHDREW_UNIT;
            $user_model->save(false);
        } else {
            $this->room_no = null;
            $this->start_date = null;
            $this->withdrew_date = null;

            $user_model = User::findOne($this->user_id);
            $user_model->room_no = NULL;
            $user_model->start_date = NULL;
            $user_model->withdrew_date = NULL;
            $user_model->user_appl_status = User::USER_APPL_STATUS_UNALLOCATE_UNIT;
            $user_model->save(false);
        }

        $this->save(false);

        return true;
    }

    public function submitApplication()
    {
        // echo '<pre>';
        // var_dump($this->app_funding_type);
        // echo '</pre>';
        // exit();

        $this->save(false);

        return true;
    }

    /*
    public function submitAllocate()
    {
        if (
            $this->application_status == Application::APPL_STATUS_UPLOAD_FILES_AGAIN && 
            isset($this->applicationResponseFiles) &&
            count($this->applicationResponseFiles) == 0
        ) {
            $this->application_status = Application::APPL_STATUS_UPLOAD_FILES;
        }
        
        if ($this->application_status == Application::APPL_STATUS_ALLOCATE_UNIT_FAILED) {
            $this->room_no = null;
            $this->start_date = null;
            $this->withdrew_date = null;

            $user_model = User::findOne($this->user_id);
            $user_model->room_no = NULL;
            $user_model->start_date = NULL;
            $user_model->withdrew_date = NULL;
            $user_model->user_appl_status = User::USER_APPL_STATUS_ALLOCATE_UNIT_FAILED;
            $user_model->save(false);
        }

        if ($this->application_status == Application::APPL_STATUS_ALLOCATED_UNIT) {
            $this->withdrew_date = null;

            $user_model = User::findOne($this->user_id);
            $user_model->room_no = $this->room_no;
            $user_model->start_date = $this->start_date;
            $user_model->withdrew_date = NULL;
            $user_model->user_appl_status = User::USER_APPL_STATUS_ALLOCATED_UNIT;
            $user_model->save(false);
        }

        if ($this->application_status == Application::APPL_STATUS_WITHDREW) {
            $user_model = User::findOne($this->user_id);
            $user_model->withdrew_date = $this->withdrew_date;
            $user_model->user_appl_status = User::USER_APPL_STATUS_WITHDREW_UNIT;
            $user_model->save(false);
        }

        $this->save(false);

        return true;
    }
    */

    public function sendSubmittedEmail($type = '', $requests = [])
    {
        // return;

        if (!$type) {
            return;
        }

        $this->refresh();
        $send_to_admin = false;
        
        if ($type === 1) {
            $title = '收到申請';
            $email_content = '九龍樂善堂已收到 閣下「樂屋」- 過渡性房屋之申請，如有需要，樂善堂職員會與你聯絡。系統發送 請勿回覆，如有任何查詢請致電2272-9888。';
            $sms_content   = '九龍樂善堂已收到 閣下「樂屋」- 過渡性房屋之申請，如有需要，樂善堂職員會與你聯絡。系統發送 請勿回覆，如有任何查詢請致電2272-9888。';

            $send_to_admin = true;
        } elseif ($type === 2) {
/*
            $url = Url::to(['/my/upload'], true);
            $url = str_replace('/admin', '', $url);

            $title = '初審合適者';
            $email_content = 
                '<p>本堂已收到  閣下「樂屋」- 過渡性社會房屋申請，為進一步作審批，請按以下連結遞交批核文件。</p>
                 <p>'.Html::a($url, $url).'</p>';
            $sms_content = '本堂已收到  閣下「樂屋」- 過渡性社會房屋申請，為進一步作審批，請按以下連結遞交批核文件。'.$url;
*/
            $url = 'www.lsthousing.org';

            $title = '要求上載文件';
            $email_content = '為進一步審批 閣下「樂屋」申請，請按以下連結遞交證明文件。'.$url;
            $sms_content = '為進一步審批 閣下「樂屋」申請，請按以下連結遞交證明文件。'.$url;
        } elseif ($type === 3) {
/*            
            $title = '初審不合適者';
            $email_content = '本堂已收到  閣下「樂屋」- 過渡性社會房屋申請，初步預審後，閣下之申請未能符合基本資格，恕未能作進一步處理。';    
            $sms_content   = '本堂已收到  閣下「樂屋」- 過渡性社會房屋申請，初步預審後，閣下之申請未能符合基本資格，恕未能作進一步處理。';    
*/
            $title = '拒絕申請';
            $email_content = '抱歉經審批後，閣下之「樂屋」申請，暫時未能單位編配，將列入後補名單，如日後有合適的項目，本堂職員會再與 閣下聯絡。';
            $sms_content = '抱歉經審批後，閣下之「樂屋」申請，暫時未能單位編配，將列入後補名單，如日後有合適的項目，本堂職員會再與 閣下聯絡。';
        } elseif ($type === 4) {
            $title = '交妥文件';
            $email_content = '閣下申請「樂屋」- 過渡性社會房屋之初步文件資料已交妥, 本堂職員將聯絡  閣下作進一步訪談及跟進。';
            $sms_content   = '閣下申請「樂屋」- 過渡性社會房屋之初步文件資料已交妥, 本堂職員將聯絡  閣下作進一步訪談及跟進。';
        } elseif ($type === 5) {
/*
            $part7s = Definitions::getPart7ContentWithTitle();
            $requests = json_decode($requests);
            $html = '';

            $first_access_title_1 = true;
            $first_access_title_2 = true;
            $first_access_subtitle_1 = true;
            $first_access_subtitle_2 = true;
            $first_access_subtitle_3 = true;
            $first_access_subtitle_4 = true;
            
            $title_gp = Definitions::getPart7TitleGroup();
            $subtitle_gp = Definitions::getPart7SubtitleGroup();
            
            foreach ($requests as $request) {
                $i = $j = 0;
        
                foreach ($part7s as $title => $subcontents) {
                    if ($i == 0 && in_array($request, $title_gp[0]) && $first_access_title_1) {
                        $html .= '<h3 style="margin-top:20px;margin-bottom:10px;"><strong>'.$title.'</strong></h3>';
                        $first_access_title_1 = false;
                    } elseif ($i == 1 && in_array($request, $title_gp[1]) && $first_access_title_2) {
                        $html .= '<h3 style="margin-top:20px;margin-bottom:10px;"><strong>'.$title.'</strong></h3>';
                        $first_access_title_2 = false;
                    }
                    foreach ($subcontents as $subtitle => $items) {
                        if ($j == 0 && in_array($request, $subtitle_gp[0]) && $first_access_subtitle_1) {
                            $html .= '<h4 style="margin-left:15px;"><u>'.$subtitle.'</u></h4>';
                            $first_access_subtitle_1 = false;
                        } elseif ($j == 1 && in_array($request, $subtitle_gp[1]) && $first_access_subtitle_2) {
                            $html .= '<h4 style="margin-left:15px;"><u>'.$subtitle.'</u></h4>';
                            $first_access_subtitle_2 = false;
                        } elseif ($j == 2 && in_array($request, $subtitle_gp[2]) && $first_access_subtitle_3) {
                            $html .= '<h4 style="margin-left:15px;"><u>'.$subtitle.'</u></h4>';
                            $first_access_subtitle_3 = false;
                        } elseif ($j == 3 && in_array($request, $subtitle_gp[3]) && $first_access_subtitle_4) {
                            $html .= '<h4 style="margin-left:15px;"><u>'.$subtitle.'</u></h4>';
                            $first_access_subtitle_4 = false;
                        } elseif ($j > 3 &&  in_array($request, $subtitle_gp[$j])) {
                            $html .= '<h4 style="margin-left:15px;"><u>'.$subtitle.'</u></h4>';
                        }
            
                        foreach ($items as $index => $label) {
                            if ($index == $request) {
                                $html .= '<div style="margin-left:30px;">- '.$label.'</div>';
                            }
                        }
                        $j++;
                    }
                    $i++;
                }
            }

            $url = Url::to(['/my/upload'], true);
            $url = str_replace('/admin', '', $url);

            $title = '未交妥文件';
            $content = '閣下申請「樂屋」- 過渡性社會房屋資料未全，本堂未能作進一步辦理。請按以下連結補交下列批核文件。';    
            $email_content = 
                '<p>閣下申請「樂屋」- 過渡性社會房屋資料未全，本堂未能作進一步辦理。請按以下連結補交下列批核文件。</p>
                 <p>'.Html::a($url, $url).'</p>'.$html;

            $sms_content = '閣下申請「樂屋」- 過渡性社會房屋資料未全，本堂未能作進一步辦理。請按以下連結補交下列批核文件。'.$url;
*/
            $url = 'www.lsthousing.org';
                    
            $title = '(再次)要求上載文件';
            $email_content = '由於 閣下提交之證明文件未全，請按以下連結遞交證明文件。'.$url;    
            $sms_content = '由於 閣下提交之證明文件未全，請按以下連結遞交證明文件。'.$url;    
        } elseif ($type === 6) {
/*
            $title = '收到文件後拒絕';
            $email_content = '經本堂審核  閣下申請「樂屋」- 過渡性社會房屋之初步文件資料後，由於是次項目申請熱烈，暫未能接納  閣下之申請，見諒。請密切留意本堂其他「樂屋」之推出。';    
            $sms_content   = '經本堂審核  閣下申請「樂屋」- 過渡性社會房屋之初步文件資料後，由於是次項目申請熱烈，暫未能接納  閣下之申請，見諒。請密切留意本堂其他「樂屋」之推出。';   
*/
            $title = '拒絕申請';
            $email_content = '抱歉經審批後，閣下之「樂屋」申請，暫時未能單位編配，將列入後補名單，如日後有合適的項目，本堂職員會再與 閣下聯絡。';
            $sms_content = '抱歉經審批後，閣下之「樂屋」申請，暫時未能單位編配，將列入後補名單，如日後有合適的項目，本堂職員會再與 閣下聯絡。';
        } elseif ($type === 7) {
            $title = '成功編配單位';
            $email_content = '閣下「樂屋」申請已通過審批並將進行單位編配，本堂職員稍後會與你聯絡。';
            $sms_content = '閣下「樂屋」申請已通過審批並將進行單位編配，本堂職員稍後會與你聯絡。';
        } 
        // send email
        if ($this->user->email || $this->email) {
            $email = $this->user->email ?: $this->email;

            Yii::$app->mailer->compose()
            ->setTo($email)
            ->setFrom(Yii::$app->params['supportEmail'])
            ->setSubject($title)
            ->setHtmlBody($email_content)
            ->send();
            
            if ($send_to_admin) {
              Yii::$app->mailer->compose()
                ->setTo(Yii::$app->params['supportEmail'])
                ->setFrom(Yii::$app->params['supportEmail'])
                ->setSubject($title)
                ->setHtmlBody('已收到新的申請表')
                ->send();
            }
        }
// send sms

        $client = new Client([
            'base_uri' => Yii::$app->params['easySmsApiPath'],
        //                 'timeout'  => 2.0,
        ]);

        $appl_sms_model = new ApplicationSms();
        $appl_sms_model->application_id = $this->id;
        $appl_sms_model->user_id = $this->user_id;
        $appl_sms_model->sent_at = date('Y-m-d H:i:s');
        $appl_sms_model->status = $this->application_status;

        try {
            // $_address = $this->address;
            // if (substr($_address, 0, 3) == "852")
            //     $_address = substr($_address, 3);
            $_mobile = '852-'.$this->user->mobile;

            $_request_url = Yii::$app->params['easySmsApiPath'].'api/send/'.Yii::$app->params['easySmsUsername'].'/'.md5(Yii::$app->params['easySmsPassword']).'/'.$_mobile.'/'.(urlencode(mb_convert_encoding($sms_content, 'UTF-8')));

            if (YII_ENV_DEV)
                var_dump($_request_url);

            $response = $client->request('GET', $_request_url, [
            ]);

            $xml = simplexml_load_string($response->getBody(), "SimpleXMLElement", LIBXML_NOCDATA);
            $json = json_encode($xml);
            $result = json_decode($json,TRUE);

            if (YII_ENV_DEV)
                var_dump($result);

            if (isset($result['record']) && isset($result['record']['id']) && isset($result['record']['status'])) {
                $appl_sms_model->sent_response = null;
                $appl_sms_model->sent_reference = $result['record']['id'];
                $appl_sms_model->save(false);
                if ($result['record']['status'] == "failed") {
                    return false;
                } else if ($result['record']['status'] == "sent") {
                    return true;
                } else {
                    return null;
                }
            } else if (isset($result['code']) | isset($result['description'])) {
                $appl_sms_model->sent_response = trim((isset($result['description']) ? $result['description'] : '').(isset($result['code']) ? (' #'.$result['code']) : ''));
                $appl_sms_model->save(false);

                return false;
            }

            return false;

        } catch (\GuzzleHttp\Exception\GuzzleException $e) {
            if (YII_ENV_DEV) {
                echo Psr7\Message::toString($e->getRequest());
                echo Psr7\Message::toString($e->getResponse());
            }
            $appl_sms_model->sent_response = Psr7\Message::toString($e->getResponse());
            $appl_sms_model->save(false);

            return false;

        } catch (\yii\base\InvalidArgumentException $e) {
            return false;

        }
    }

    public function getAllApplicationFormField()
    {
        $array = [
            'priority_1', 'priority_2', 'priority_3', 'chi_name', 'eng_name', 'phone', 'mobile', 'address', 'area', 'email',
            'house_type', 'house_type_other', 'private_type', 'together_type', 'together_type_other', 'live_rent', 'live_year',
            'live_month', 'family_member', 'prh', 'prh_no', 'prh_location', 'apply_prh_year', 'apply_prh_month', 'apply_prh_day',
            
            'app_gender', 'app_born_date'/*, 'app_born_type'*/, 'app_id_type', 'app_id_no', 'app_marriage_status', 'app_chronic_patient',
            'app_working_status', 'app_career', 'app_income', 'app_funding_type','app_funding_value', 'app_asset', 'app_asset_type',
            'app_asset_value', 'app_deposit',

            'm1_chi_name', 'm1_eng_name', 'm1_gender', 'm1_born_date'/*, 'm1_born_type'*/, 'm1_id_type', 'm1_id_no', 'm1_relationship',
            'm1_marriage_status', 'm1_chronic_patient', 'm1_special_study', 'm1_working_status', 'm1_career', 'm1_income',
            'm1_funding_type', 'm1_funding_value', 'm1_asset', 'm1_asset_type', 'm1_asset_value', 'm1_deposit',

            'm2_chi_name', 'm2_eng_name', 'm2_gender', 'm2_born_date'/*, 'm2_born_type'*/, 'm2_id_type', 'm2_id_no', 'm2_relationship',
            'm2_marriage_status', 'm2_chronic_patient', 'm2_special_study', 'm2_working_status', 'm2_career', 'm2_income',
            'm2_funding_type', 'm2_funding_value', 'm2_asset', 'm2_asset_type', 'm2_asset_value', 'm2_deposit',

            'm3_chi_name', 'm3_eng_name', 'm3_gender', 'm3_born_date'/*, 'm3_born_type'*/, 'm3_id_type', 'm3_id_no', 'm3_relationship',
            'm3_marriage_status', 'm3_chronic_patient', 'm3_special_study', 'm3_working_status', 'm3_career', 'm3_income',
            'm3_funding_type', 'm3_funding_value', 'm3_asset', 'm3_asset_type', 'm3_asset_value', 'm3_deposit',

            'm4_chi_name', 'm4_eng_name', 'm4_gender', 'm4_born_date'/*, 'm4_born_type'*/, 'm4_id_type', 'm4_id_no', 'm4_relationship',
            'm4_marriage_status', 'm4_chronic_patient', 'm4_special_study', 'm4_working_status', 'm4_career', 'm4_income',
            'm4_funding_type', 'm4_funding_value', 'm4_asset', 'm4_asset_type', 'm4_asset_value', 'm4_deposit',

            'm5_chi_name', 'm5_eng_name', 'm5_gender', 'm5_born_date'/*, 'm5_born_type'*/, 'm5_id_type', 'm5_id_no', 'm5_relationship',
            'm5_marriage_status', 'm5_chronic_patient', 'm5_special_study', 'm5_working_status', 'm5_career', 'm5_income',
            'm5_funding_type', 'm5_funding_value', 'm5_asset', 'm5_asset_type', 'm5_asset_value', 'm5_deposit',

            'single_parents', 'pregnant', 'pregnant_period', 'total_income', 'total_funding', 'total_asset', 'social_worker_name',
            'social_worker_phone', 'social_worker_email',
        ];

        return $array;
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getApplicationSms()
    {
        return $this->hasMany(ApplicationSms::className(), ['application_id' => 'id']);
    }

    public function getApplicationMark()
    {
        return $this->hasOne(ApplicationMark::className(), ['application_id' => 'id']);
    }

    public function getApplicationRequestFiles()
    {
        return $this->hasMany(ApplicationRequestFiles::className(), ['application_id' => 'id']);
    }

    public function getApplicationResponseFiles()
    {
        return $this->hasMany(ApplicationResponseFiles::className(), ['application_id' => 'id']);
    }
}
