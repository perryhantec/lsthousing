<?php
namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\web\IdentityInterface;
use yii\helpers\ArrayHelper;

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
class AdminUser extends \common\components\BaseActiveRecord implements IdentityInterface
{
    public $new_password;
    public $_roles;
    const SCENARIO_CREATE = 'create';

    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 1;

    const ROLE_SUPERADMIN = 10;
    const ROLE_ADMIN = 20;
    const ROLE_USER = 30;

    const ROLES = [
            self::ROLE_ADMIN => [
                'page',
                'page.allpages',
                'page.home',
                'page.contactus',
                'user',
                'application',
                'mark',
                'visit',
                'requestFile',
                'responseFile',
                'approve',
                'allocate',
                'rental',
                'page.about',
                'page.newProject',
                'page.project',
                'page.general',
                'menu',
                'menu.root',
                'fileBrowser',
                'admin.user',
                'admin.group',
                'admin.log'
            ]
        ];

//     public $roles = [self::ROLE_ADMIN => 'admin',  self::ROLE_USER=>'user', self::ROLE_MEMBER => 'member'];

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'admin_user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'username', 'role'], 'required'],
            [['name'], 'string', 'max' => 255],
            ['username', 'unique'],
            [['username'], 'string', 'max' => 320],
            ['email', 'email'],
            ['password_hash', 'string', 'max' => 160],
            ['password_reset_token', 'string', 'max' => 43],
            [['new_password'], 'required', 'on' => self::SCENARIO_CREATE],
            [['name', 'username', 'password_hash', 'auth_key'], 'string'],
            [['language', 'role', 'status', 'updated_UID'], 'integer'],
            [['new_password', 'created_at', 'last_login_at', 'updated_at'], 'safe'],
            ['role', 'default', 'value' => self::ROLE_USER],
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'email' => Yii::t('app', 'Email'),
            'username' => Yii::t('app', 'Username'),
            'new_password' => Yii::t('app', 'Password'),
            'password_hash' => Yii::t('app', 'Password'),
            'role' => Yii::t('app', 'Role'),
            'auth_key' => Yii::t('app', 'Authentication Key'),
            'status' => Yii::t('app', 'Status'),
            'last_login_at' => Yii::t('app', 'Last Login Date'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated Dt'),
            'updated_UID' => Yii::t('app', 'Updated Uid'),
        ];
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

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
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

    public function getNameWithEmail()
    {
        return $this->name . ($this->email != "" ? (' ('.$this->email.')') : '');
    }

    public function getCanEditMenus()
    {
        if ($this->role == self::ROLE_SUPERADMIN || $this->checkRole('page.allpages'))
            return null;

        $canEditMenus = [];

        foreach ($this->getAdminGroups()->andWhere(['status' => 1])->all() as $adminGroup_model) {
            $canEditMenus = ArrayHelper::merge($canEditMenus, $adminGroup_model->canEditMenus);
        }

        return $canEditMenus;
    }

    public function getCanEditMenusId()
    {
        $canEditMenus = $this->getCanEditMenus();

        if ($canEditMenus == null)
            return null;

        return ArrayHelper::getColumn($canEditMenus, 'id');
    }

    public function getRoles()
    {
        if (isset(self::ROLES[$this->role]))
            return self::ROLES[$this->role];

        $roles = [];

        foreach ($this->getAdminGroups()->andWhere(['status' => 1])->all() as $adminGroup_model) {
            $roles = ArrayHelper::merge($roles, $adminGroup_model->roles);
        }

        $roles = array_unique($roles);

        return $roles;
    }

    public function checkRole($role)
    {
        if ($this->role == self::ROLE_SUPERADMIN)
            return true;

        if ($this->_roles == null)
            $this->_roles = $this->roles;

        if (is_array($role)) {
            foreach ($role as $r) {
                if (in_array($r, $this->_roles))
                    return true;
            }
            return false;
        } else
            return in_array($role, $this->_roles);
    }

    public function getAdminGroups()
    {
        return $this->hasMany(AdminGroup::className(), ['id' => 'admin_group_id'])->viaTable('admin_group_user', ['admin_user_id' => 'id']);
    }

    public function getAdminLogs()
    {
        return $this->hasMany(AdminLog::className(), ['admin_user_id' => 'id']);
    }

    public function getMenuCanEdit()
    {
        return null;
    }

}
