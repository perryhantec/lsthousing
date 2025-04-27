<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "contact_us".
 *
 * @property integer $id
 * @property string $company_name
 * @property string $address
 * @property string $phone
 * @property string $fax
 * @property string $email
 * @property string $website
 * @property string $created_at
 * @property string $updated_at
 * @property integer $updated_UID
 */
class ContactUs extends \common\components\BaseActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'contact_us';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // [Yii::$app->config->getRequiredLanguageAttributes(['company_name', 'address']), 'required'],
            [['company_name_tw', 'address_tw'], 'required'],
//             [['email'], 'required'],
            [['company_name_tw', 'company_name_cn', 'company_name_en', 'website', 'phone', 'fax', 'whatsapp', 'facebook', 'instagram', 'twitter', 'youtube'], 'string', 'max' => 255],
            [['facebook', 'instagram', 'twitter', 'youtube'], 'url'],
            [['content_tw', 'content_cn', 'content_en'], 'string'],
            [['googlemap'], 'string', 'max' => 510],
            [['address_tw', 'address_cn', 'address_en'], 'string'],
            [['email'], 'email'],
            [['website'], 'url'],
            [['created_at', 'updated_at'], 'safe'],
            [['updated_UID'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'company_name' => Yii::t('app', 'Company Name'),
            'company_name_en' => Yii::t('app', 'Company Name').' '.Yii::t('app', '(English Version)'),
            'company_name_cn' => Yii::t('app', 'Company Name').' '.Yii::t('app', '(Simplified Chinese Version)'),
            'company_name_tw' => Yii::t('app', 'Company Name').' '.Yii::t('app', '(Traditional Chinese Version)'),
            'address' => Yii::t('web', 'Address'),
            'address_en' => Yii::t('web', 'Address').' '.Yii::t('app', '(English Version)'),
            'address_cn' => Yii::t('web', 'Address').' '.Yii::t('app', '(Simplified Chinese Version)'),
            'address_tw' => Yii::t('web', 'Address').' '.Yii::t('app', '(Traditional Chinese Version)'),
            'phone' => Yii::t('web', 'Phone'),
            'fax' => Yii::t('web', 'Fax'),
            'email' => Yii::t('web', 'Email'),
            'website' => Yii::t('web', 'Website'),
            'whatsapp' => Yii::t('web', 'WhatsApp'),
            'facebook' => Yii::t('web', 'Facebook'),
            'instagram' => Yii::t('web', 'Instagram'),
            'twitter' => Yii::t('web', 'Twitter'),
            'youtube' => Yii::t('web', 'YouTube Channel'),
            'googlemap' => Yii::t('app', 'Google Map Embed Link'),
            'content_en' => Yii::t('app', 'Content').' '.Yii::t('app', '(English Version)'),
            'content_cn' => Yii::t('app', 'Content').' '.Yii::t('app', '(Simplified Chinese Version)'),
            'content_tw' => Yii::t('app', 'Content').' '.Yii::t('app', '(Traditional Chinese Version)'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated Dt'),
            'updated_UID' => Yii::t('app', 'Updated  Uid'),
        ];
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            $this->updated_at=date('Y-m-d H:i:s');
            if(isset(Yii::$app->user->id)){
              $this->updated_UID=Yii::$app->user->id;
            }
            return true;
        } else {
            return false;
        }
    }

    public function getCompany_name() {
        if (Yii::$app->language == 'en' && !empty($this->company_name_en)){
            return $this->company_name_en;
        } else if (Yii::$app->language == 'zh-CN' && !empty($this->company_name_cn)){
            return $this->company_name_cn;
        }
        return $this->company_name_tw;
    }

    public function getAddress() {
        if (Yii::$app->language == 'en' && !empty($this->address_en)){
            return $this->address_en;
        } else if (Yii::$app->language == 'zh-CN' && !empty($this->address_cn)){
            return $this->address_cn;
        }
        return $this->address_tw;
    }

    public function getContent() {
        if (Yii::$app->language == 'en' && !empty($this->content_en)){
            return $this->content_en;
        } else if (Yii::$app->language == 'zh-CN' && !empty($this->content_cn)){
            return $this->content_cn;
        }
        return $this->content_tw;
    }

}
