<?php

namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;

class AdminGroup extends \common\components\BaseActiveRecord
{
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 1;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'admin_group';
    }

    /**
     * {@inheritdoc}
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
            ], 'boolean'],
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
            [['status', 'updated_UID'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'canManageHome'         => Yii::t('app', 'Can Manage {model}', ['model' => Yii::t('app', 'Home')]),
            'canManageContactus'    => Yii::t('app', 'Can Manage {model}', ['model' => Yii::t('app', 'Contact Us')]),
            'canManageUser'         => Yii::t('app', 'Can Manage {model}', ['model' => Yii::t('app', 'Member')]),
            'canManageApplication'  => '可以管理申請表',
            'canManageMark'         => '可以管理評分',
            'canManageVisit'        => '可以管理家訪紀錄',
            'canManageRequestFile'  => '可以管理要求上載文件',
            'canManageResponseFile' => '可以管理已提交上載交件',
            'canManageApprove'      => '可以管理批核清單',
            'canManageAllocate'     => '可以管理編配單位',
            'canManageRental'       => '可以管理住戶上載交租文件',
            'canManageAbout'        => '可以管理關於樂屋',
            'canManageProject'      => '可以管理樂屋新項目',
            'canManageNewProject'   => '可以管理樂屋項目',
            'canManageGeneral'      => Yii::t('app', 'Can Manage {model}', ['model' => Yii::t('app', 'General')]),
            'canManageMenu'         => Yii::t('app', '{0} ({1})', [Yii::t('app', 'Can Manage {model}', ['model' => Yii::t('app', 'Menu')]), Yii::t('app', 'Page Can Be Managed Only')]),
            'canManageAdmin'        => Yii::t('app', 'Can Manage {model}', ['model' => Yii::t('app', 'Admin User & Group')]),
            'status' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'updated_UID' => Yii::t('app', 'Updated  Uid'),
        ];
    }

    public function getAdminUsers()
    {
        return $this->hasMany(AdminUser::className(), ['id' => 'admin_user_id'])->viaTable('admin_group_user', ['admin_group_id' => 'id']);
    }

    public function getCanEditMenus()
    {
        $models = [];

        foreach ($this->menus as $menu_model) {
            $models[] = $menu_model;
            $models = ArrayHelper::merge($models, $menu_model->getAllChildMenus(false));
        }

        return $models;
    }

    public function getRoles()
    {
        $roles = [];

        if ($this->canManageHome) $roles[] = 'page.home';
        if ($this->canManageContactus) $roles[] = 'page.contactus';
        if ($this->canManageUser) $roles[] = 'user';
        if ($this->canManageApplication) $roles[] = 'application';
        if ($this->canManageMark) $roles[] = 'mark';
        if ($this->canManageVisit) $roles[] = 'visit';
        if ($this->canManageRequestFile) $roles[] = 'requestFile';
        if ($this->canManageResponseFile) $roles[] = 'responseFile';
        if ($this->canManageApprove) $roles[] = 'approve';
        if ($this->canManageAllocate) $roles[] = 'allocate';
        if ($this->canManageRental) $roles[] = 'rental';
        if ($this->canManageAbout) $roles[] = 'page.about';
        if ($this->canManageProject) $roles[] = 'page.project';
        if ($this->canManageNewProject) $roles[] = 'page.newProject';
        if ($this->canManageMenu) $roles[] = 'menu';
        if ($this->canManageGeneral) $roles[] = 'page.general';
        if ($this->canManageAdmin) {
            $roles[] = 'admin.user';
            $roles[] = 'admin.group';
        }

/*
        foreach ($this->getAllMenusId($withTopMenus) as $menu_id) {
            $roles[] = 'page.'.$menu_id;
        }
*/

        foreach ($this->menus as $menu_model) {
            $roles[] = 'page.'.$menu_model->id;
            $roles = ArrayHelper::merge($roles, ArrayHelper::getColumn($menu_model->getAllChildMenus(false), function ($model) {
                    return 'page.'.$model['id'];
                }));
            $roles = ArrayHelper::merge($roles, ArrayHelper::getColumn($menu_model->getAllTopMenus(), function ($model) {
                    return 'page.top.'.$model['id'];
                }));
        }

        foreach ($roles as $role){
            $exp_role = explode('.', $role);
            if ($exp_role[0] == 'page') {
                $roles[] = 'page';
                break;
            }
        }

//         var_dump($roles);

        return $roles;
    }

    public function getAllMenus($withTopMenus=false)
    {
        $result = [];

        foreach ($this->menus as $menu_model) {
            $result = ArrayHelper::merge($result, [$menu_model]);
            if ($withTopMenus)
                $result = ArrayHelper::merge($result, $menu_model->getAllTopMenus());
            $result = ArrayHelper::merge($result, $menu_model->getAllChildMenus(false));
        }

        return $result;
    }

    public function getAllMenusId($withTopMenus=false)
    {
        return ArrayHelper::getColumn($this->getAllMenus($withTopMenus), 'id');
    }

    public function getMenus()
    {
        return $this->hasMany(Menu::className(), ['id' => 'menu_id'])->viaTable('menu_edit_group', ['admin_group_id' => 'id']);
    }

}