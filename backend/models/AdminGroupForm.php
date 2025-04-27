<?php

namespace backend\models;

use Yii;
use yii\helpers\ArrayHelper;
use common\models\Menu;
use common\models\AdminUser;
use common\models\AdminGroup;

/**
 * AdminGroup model
 *
 */
class AdminGroupForm extends AdminGroup
{
    public $adminUsers_update = [];
    public $editMenu_update = [];

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [[
              'canManageHome',
              'canManageContactus',
              'canManageUser',
              'canManageApplication',
              'canManageMark',
              'canManageVisit',
              'canManageRequestFile',
              'canManageResponseFile',
              'canManageApprove',
              'canManageAllocate',
              'canManageRental',
              'canManageAbout',
              'canManageProject',
              'canManageNewProject',
              'canManageGeneral',
              'canManageMenu',
              'canManageAdmin',
            ], 'boolean'],            [['name'], 'string', 'max' => 255],
            [['name'], 'required'],
            [['status'], 'integer'],
            [['adminUsers_update'], 'each', 'rule' => ['exist', 'skipOnError' => false, 'targetClass' => AdminUser::className(), 'targetAttribute' => 'id']],
            [['editMenu_update'], 'each', 'rule' => ['exist', 'skipOnError' => false, 'targetClass' => Menu::className(), 'targetAttribute' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return ArrayHelper::merge(parent::attributeLabels(), [
            'editMenu_update' => Yii::t('app', 'Can Manage {model}', ['model' => Yii::t('app', 'Page')]),
            'adminUsers_update' => Yii::t('app', 'Admin Users'),
        ]);
    }

    public function afterFind()
    {
        parent::afterFind();

        $this->adminUsers_update = ArrayHelper::getColumn($this->adminUsers, 'id');
        $this->editMenu_update = ArrayHelper::getColumn($this->menus, 'id');
    }

    public function submit()
    {
        if ($this->save()) {
            $this->unlinkAll('menus', true);
            if (is_array($this->editMenu_update)) {
                foreach ($this->editMenu_update as $menu_id) {
                    $mmodel = Menu::findOne($menu_id);
                    if ($mmodel != null)
                        $this->link('menus', $mmodel);
                }
            }

            $this->unlinkAll('adminUsers', true);
            if (is_array($this->adminUsers_update)) {
                foreach ($this->adminUsers_update as $adminUser_id) {
                    $aumodel = AdminUser::findOne($adminUser_id);
                    if ($aumodel != null)
                        $this->link('adminUsers', $aumodel);
                }
            }

            return true;
        } else {
            return false;
        }
    }

}
