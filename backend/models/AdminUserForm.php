<?php

namespace backend\models;

use Yii;
use yii\helpers\ArrayHelper;
use common\models\AdminUser;
use common\models\AdminGroup;

/**
 * AdminUser model
 *
 */
class AdminUserForm extends AdminUser
{
    public $adminGroups_update = [];

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
            [['new_password'], 'string'],
            ['email', 'email'],
            [['role', 'status'], 'integer'],
            ['admin_groups', 'safe'],
            [['new_password'], 'required', 'on' => self::SCENARIO_CREATE],
            ['role', 'default', 'value' => self::ROLE_USER],
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            [['adminGroups_update'], 'each', 'rule' => ['exist', 'skipOnError' => false, 'targetClass' => AdminGroup::className(), 'targetAttribute' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'name' => Yii::t('app', 'Name'),
            'email' => Yii::t('app', 'Email'),
            'username' => Yii::t('app', 'Username'),
            'new_password' => Yii::t('app', 'Password'),
            'password_hash' => Yii::t('app', 'Password'),
            'role' => Yii::t('app', 'Role'),
            'auth_key' => Yii::t('app', 'Authentication Key'),
            'status' => Yii::t('app', 'Status'),
            'adminGroups_update' => Yii::t('app', 'Admin Groups'),
        ];
    }

    public function afterFind()
    {
        parent::afterFind();

        $this->adminGroups_update = ArrayHelper::getColumn($this->adminGroups, 'id');
    }

    public function submit()
    {
        if ($this->save()) {
            $this->unlinkAll('adminGroups', true);
            if (is_array($this->adminGroups_update)) {
                foreach ($this->adminGroups_update as $adminGroup_id) {
                    $agmodel = AdminGroup::findOne($adminGroup_id);
                    if ($agmodel != null)
                        $this->link('adminGroups', $agmodel);
                }
            }

            return true;
        } else {
            return false;
        }
    }

}
