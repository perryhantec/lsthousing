<?php
namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\web\IdentityInterface;

/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $auth_key
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 */
class User extends \common\components\BaseActiveRecord implements IdentityInterface
{
    public $new_password;

    const SCENARIO_CREATE = 'create';

    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 1;

    const ROLE_SUPERADMIN = 10;
    const ROLE_ADMIN = 15;
    const ROLE_MANAGER = 20;
    const ROLE_PRODUCT_MANAGER = 25;
    const ROLE_MEMBER = 30;

    const APP_NO_PREFIX = 'APP';
    const APP_NO_LENGTH = 12;

    const USER_APPL_STATUS_ALLOCATE_UNIT_FAILED = -10;
    const USER_APPL_STATUS_UNALLOCATE_UNIT = 10;
    const USER_APPL_STATUS_ALLOCATED_UNIT = 20;
    const USER_APPL_STATUS_WITHDREW_UNIT = 30;

    const ROLES = [
            self::ROLE_ADMIN => ['admin.general', 'admin.termsAndConditions', 'admin.menu', 'admin.user', 'menu', 'menu.root', 'web.content', 'web.alert', 'product', 'catering', 'delivery.date', 'delivery.option', 'promotion', 'user', 'order', 'order.view', 'order.update_status', 'order.update', 'order.create', 'report', 'donation.online', 'donation.inkind', 'eNewsSubscription'],
            self::ROLE_PRODUCT_MANAGER => ['product']
        ];

//     public $roles = [self::ROLE_ADMIN => 'admin',  self::ROLE_USER=>'user', self::ROLE_MEMBER => 'member'];

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [[
                'area', 'house_type', 'private_type', 'together_type', 'live_year', 'live_month', 'family_member', 'prh', 'prh_location', 'apply_prh_year',
                'apply_prh_month', 'apply_prh_day', 'app_gender'/*, 'app_born_type'*/, 'app_id_type', 'app_marriage_status', 'app_working_status',
                'app_asset', 'single_parents', 'pregnant', 'pregnant_period', 'user_appl_status'
            ], 'integer'],
            [[
                'live_rent', 'app_income', 'app_funding_value', 'app_asset_value', 'app_deposit',
                'total_income', 'total_funding', 'total_asset',
            ], 'number'],
            [[
                'app_no', 'chi_name', 'eng_name', 'email', 'house_type_other', 'together_type_other', 'prh_no', 'app_born_date', 'app_chronic_patient', 'app_id_no',
                'app_career', 'app_asset_type', 'social_worker_name', 'social_worker_email'
            ], 'string', 'max' => 255],

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

            [['address'], 'string'],
            [['phone', 'mobile', 'social_worker_phone'], 'string', 'max' => 8],

            [['room_no', 'start_date', 'withdrew_date'], 'string'],

            // [['name', 'username', 'role'], 'required'],
            // [['name'], 'string', 'max' => 255],
            // ['username', 'unique'],
            // [['username'], 'string', 'max' => 320],
            // ['email', 'email'],
            // [['phone'], 'string', 'max' => 16],

            [['otp'], 'string','min' => 4,'max' => 10],
            [['wrong_count', 'wrong_expire'], 'integer'],

            [['img'], 'string', 'max' => 2048],
            ['password_hash', 'string', 'max' => 160],
            ['password_reset_token', 'string', 'max' => 43],
            [['new_password'], 'required', 'on' => self::SCENARIO_CREATE],
            // [['name', 'username', 'password_hash', 'auth_key'], 'string'],
            [['password_hash', 'auth_key'], 'string'],
            [['language', 'role', 'oAuth_user', 'status', 'updated_UID'], 'integer'],
            [['new_password', 'created_at', 'last_login_at', 'updated_at'], 'safe'],
            ['role', 'default', 'value' => self::ROLE_MEMBER],
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),

            'app_no' => '申請人編號',
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
            'live_year' => '已居於目前單位(年份)',
            'live_month' => '已居於目前單位(月)',
            'family_member' => '家庭成員數目',
            'prh' => '有沒有申請公屋',
            'prh_no' => '公屋申請編號',
            'prh_location' => '申請公屋地點',
            'apply_prh_year' => '申請公屋日期(年)',
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

            'user_appl_status' => '用戶狀態',

            'otp' => 'One Time Password',

            // 'name' => Yii::t('app', 'Name'),
            // 'phone' => Yii::t('app', 'Phone'),
            // 'email' => Yii::t('app', 'Email'),
            // 'username' => Yii::t('app', 'Username'),
            'new_password' => Yii::t('app', 'Password'),
            'password_hash' => Yii::t('app', 'Password'),
            'role' => Yii::t('app', 'Role'),
            'oAuth_user' => Yii::t('app', 'Is oAuth User'),
            'auth_key' => Yii::t('app', 'Authentication Key'),
            'status' => Yii::t('app', 'Status'),
            'last_login_at' => Yii::t('app', 'Last Login Date'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated Dt'),
            'updated_UID' => Yii::t('app', 'Updated Uid'),

            'appl_no' => '申請編號',
            'project' => '項目名稱',
            'room_no' => '房間編號',
            'application_status' => '申請狀態',
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
    }
    
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->auth_key==NULL) {
                $this->auth_key = \Yii::$app->security->generateRandomString();
            }
            if($this->new_password!=NULL){
              self::setPassword($this->new_password);
            }
            
            $this->app_funding_type = json_encode($this->app_funding_type);
            $this->m1_funding_type  = json_encode($this->m1_funding_type);
            $this->m2_funding_type  = json_encode($this->m2_funding_type);
            $this->m3_funding_type  = json_encode($this->m3_funding_type);
            $this->m4_funding_type  = json_encode($this->m4_funding_type);
            $this->m5_funding_type  = json_encode($this->m5_funding_type);
            
            return true;
        } else {
            return false;
        }
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    public function getUsername(){
        return $this->phone;
    }


    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne([
            'auth_key' => $token
        ]);
    }

    public static function findByPhone($phone)
    {
        return static::findOne([
            'mobile' => $phone,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    public function validatePasswordOtp($password) {
        return ($this->otp === $password && $this->otp_expire >= time());
    }

    /**
     * @inheritdoc
     */
    // public static function findIdentityByAccessToken($token, $type = null)
    // {
    //     return static::find()->joinWith('userTokens')->andWhere(['token' => $token])->one();
    // }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username, $oAuth_user=false)
    {
        // return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE, 'oAuth_user' => ($oAuth_user === false ? 0 : 1)]);
        return static::findOne(['chi_name' => $username, 'status' => self::STATUS_ACTIVE, 'oAuth_user' => ($oAuth_user === false ? 0 : 1)]);
    }

    public static function findByMobile($mobile, $oAuth_user=false)
    {
        // return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE, 'oAuth_user' => ($oAuth_user === false ? 0 : 1)]);
        return static::findOne(['mobile' => $mobile, 'status' => self::STATUS_ACTIVE, 'oAuth_user' => ($oAuth_user === false ? 0 : 1)]);
        // return static::find()->andwhere(['status' => self::STATUS_ACTIVE, 'oAuth_user' => ($oAuth_user === false ? 0 : 1)])
        //     ->andWhere(['or',
        //         ['mobile'=>$mobile_or_email],
        //         ['email'=>$mobile_or_email]
        //     ])->one();
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return boolean
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password) {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password) {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }


    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString(32) . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    public function getRoles()
    {
      return (isset(self::ROLES[$this->role])) ? self::ROLES[$this->role] : [];
    }

    public function checkRole($role)
    {
      if ($this->role == self::ROLE_SUPERADMIN)
        return true;

      if (is_array($role)) {
          foreach ($role as $r) {
              if (in_array($r, $this->roles))
                return true;
          }
          return false;
      } else
          return in_array($role, $this->roles);
    }

    public function getIsShoppingMemberPrice()
    {
        return false;
    }

    public function getOrders()
    {
        return $this->hasMany(Order::className(), ['user_id' => 'id']);
    }

    public function getUserTokens()
    {
        return $this->hasMany(UserToken::className(), ['user_id' => 'id']);
    }

    public function getSubmitedOrders()
    {
        return $this->hasMany(Order::className(), ['user_id' => 'id'])->andWhere(['>=', 'status', Order::STATUS_CHECKOUT_SUBMITED])->orderBy(['checkout_at' => SORT_DESC, 'order_num' => SORT_DESC]);
    }

    public function getUserAddress()
    {
        return $this->hasOne(UserAddress::className(), ['user_id' => 'id']);
    }

    public function getName()
    {
        return $this->chi_name;
    }

    public function getNameWithEmail()
    {
        return $this->chi_name . ($this->email != "" ? (' ('.$this->email.')') : '');
    }

    public function getAddress()
    {
        if ($this->userAddress)
            return $this->userAddress;

        $model = new UserAddress(['user_id' => $this->id]);
        $model->save();
        $model->refresh();

        return $model;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEditableMenus()
    {
        return $this->hasMany(Menu::className(), ['id' => 'menu_id'])->viaTable('menu_edit_user', ['user_id' => 'id']);
    }

    public function generateAccessToken($device_os, $device_uuid, $device_version, $device_token) {
        return UserToken::create($this->id, $device_os, $device_uuid, $device_version, $device_token)->token;
    }

    public function getApplication()
    {
        return $this->hasOne(Application::className(), ['user_id' => 'id'])->where(['>=', 'application_status', Application::APPL_STATUS_SUBMITED_FORM]);
    }
    
    // public function getRentalPayment()
    // {
    //     return $this->hasMany(RentalPayment::className(), ['user_id' => 'id']);
    // }
}
