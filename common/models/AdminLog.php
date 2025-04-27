<?php

namespace common\models;

use Yii;

class AdminLog extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'admin_log';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['message'], 'required'],
            [['admin_user_id', 'menu_id'], 'integer'],
            [['message'], 'string'],
            [['ip'], 'string', 'max' => 15],
            [['created_at'], 'safe'],
            [['admin_user_id'], 'exist', 'skipOnError' => true, 'targetClass' => AdminUser::className(), 'targetAttribute' => ['admin_user_id' => 'id']],
            [['menu_id'], 'exist', 'skipOnError' => true, 'targetClass' => Menu::className(), 'targetAttribute' => ['menu_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'adminUser' => Yii::t('app', 'User Name'),
            'message' => Yii::t('app', 'Log'),
            'ip' => Yii::t('app', 'IP Address'),
            'menu_id' => Yii::t('app', 'Page'),
            'status' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Date'),
        ];
    }

    public function getAdminUser()
    {
        return $this->hasOne(AdminUser::className(), ['id' => 'admin_user_id']);
    }

    public function getMenu()
    {
        return $this->hasOne(Menu::className(), ['id' => 'menu_id']);
    }

}