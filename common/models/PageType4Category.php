<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "page_type4_category".
 */
class PageType4Category extends \common\components\BaseActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'page_type4_category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['MID', 'category_id', 'status', 'updated_UID'], 'integer'],
            [Yii::$app->config->getRequiredLanguageAttributes('name'), 'required'],
            [['name_tw', 'name_cn', 'name_en'], 'string', 'max' => 255],
            [['created_at', 'updated_at'], 'safe'],
            [['MID'], 'exist', 'skipOnError' => true, 'targetClass' => Menu::className(), 'targetAttribute' => ['MID' => 'id']],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => PageType4Category::className(), 'targetAttribute' => ['category_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'MID' => Yii::t('app', 'Mid'),
            'category_id' => Yii::t('app', 'Category'),
            'name_tw' => Yii::t('app', 'Name').' '.Yii::t('app', '(Traditional Chinese Version)'),
            'name_cn' => Yii::t('app', 'Name').' '.Yii::t('app', '(Simplified Chinese Version)'),
            'name_en' => Yii::t('app', 'Name').' '.Yii::t('app', '(English Version)'),
            'status' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'updated_UID' => Yii::t('app', 'Updated  Uid'),
        ];
    }

    public function getMenu(){
        return $this->hasOne(Menu::className(), ['id' => 'MID']);
    }

    public function getName() {
        if (Yii::$app->language == 'en' && $this->name_en != "")
            return $this->name_en;
        else if (Yii::$app->language == 'zh-CN' && $this->name_cn != "")
            return $this->name_cn;
        else
            return $this->name_tw;
    }

}
