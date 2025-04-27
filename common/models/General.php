<?php

namespace common\models;

use Yii;
use yii\helpers\Json;
use Imagine\Image\Box;
use Imagine\Image\Point;
use yii\imagine\Image;

/**
 * This is the model class for table "general".
 */
class General extends \common\components\BaseActiveRecord
{
    public $lang;
    public $image_file;
    public $crop_info;

    public $crop_width;
    public $crop_height;

    const CROP_WIDTH = 700;
    const CROP_HEIGHT = 190;

    const HAVE_COPYRIGHT_NOTICE = true;
    const HAVE_DISCLAIMER = true;
    const HAVE_PRIVACY_STATEMENT = true;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'general';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // [Yii::$app->config->getAllLanguageAttributes(['web_name', 'copyright']), 'required'],
            [['web_name_tw', 'copyright_tw'], 'required'],
            [['web_name_tw', 'web_name_cn', 'web_name_en', 'copyright_tw', 'copyright_cn', 'copyright_en'], 'string', 'max' => 255],
            [['copyright_notice_tw', 'copyright_notice_cn', 'copyright_notice_en', 'disclaimer_tw', 'disclaimer_cn', 'disclaimer_en', 'privacy_statement_tw', 'privacy_statement_cn', 'privacy_statement_en', 'shop_empty_desc_tw', 'shop_empty_desc_cn', 'shop_empty_desc_en'], 'string'],
            [['description', 'keywords'], 'string'],
            [['banner_image_file_name'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['site_counter', 'updated_UID'], 'integer'],
            [['image_file'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, JPG, jpeg, JPEG, PNG'],
            [['crop_width', 'crop_height'], 'integer'],
            ['crop_info', 'safe'],
            ['image_file', 'checkClickCrop'],
        ];
    }

    public function checkClickCrop($attribute, $params)
    {
        if($this->image_file != NULL && Json::decode($this->crop_info)==NULL){
            $this->addError($attribute, "Please click 'Crop'.");
        }
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'web_name_en' => Yii::t('app', 'Website Name').' '.Yii::t('app', '(English Version)'),
            'web_name_cn' => Yii::t('app', 'Website Name').' '.Yii::t('app', '(Simplified Chinese Version)'),
            'web_name_tw' => Yii::t('app', 'Website Name').' '.Yii::t('app', '(Traditional Chinese Version)'),
            'description' => Yii::t('app', 'Description'),
            'keywords' => Yii::t('app', 'Keywords'),
            'copyright_en' => Yii::t('app', 'Copyright').' '.Yii::t('app', '(English Version)'),
            'copyright_cn' => Yii::t('app', 'Copyright').' '.Yii::t('app', '(Simplified Chinese Version)'),
            'copyright_tw' => Yii::t('app', 'Copyright').' '.Yii::t('app', '(Traditional Chinese Version)'),
            'copyright_notice_en' => Yii::t('app', 'Copyright Notice').' '.Yii::t('app', '(English Version)'),
            'copyright_notice_cn' => Yii::t('app', 'Copyright Notice').' '.Yii::t('app', '(Simplified Chinese Version)'),
            'copyright_notice_tw' => Yii::t('app', 'Copyright Notice').' '.Yii::t('app', '(Traditional Chinese Version)'),
            'privacy_statement_en' => Yii::t('app', 'Privacy Policy').' '.Yii::t('app', '(English Version)'),
            'privacy_statement_cn' => Yii::t('app', 'Privacy Policy').' '.Yii::t('app', '(Simplified Chinese Version)'),
            'privacy_statement_tw' => Yii::t('app', 'Privacy Policy').' '.Yii::t('app', '(Traditional Chinese Version)'),
            'disclaimer_en' => Yii::t('app', 'Disclaimer').' '.Yii::t('app', '(English Version)'),
            'disclaimer_cn' => Yii::t('app', 'Disclaimer').' '.Yii::t('app', '(Simplified Chinese Version)'),
            'disclaimer_tw' => Yii::t('app', 'Disclaimer').' '.Yii::t('app', '(Traditional Chinese Version)'),
            'shop_empty_desc_en' => Yii::t('app', 'Empty Shop Content').' '.Yii::t('app', '(English Version)'),
            'shop_empty_desc_cn' => Yii::t('app', 'Empty Shop Content').' '.Yii::t('app', '(Simplified Chinese Version)'),
            'shop_empty_desc_tw' => Yii::t('app', 'Empty Shop Content').' '.Yii::t('app', '(Traditional Chinese Version)'),
            'site_counter' => Yii::t('app', 'Total Visits'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated Dt'),
            'updated_UID' => Yii::t('app', 'Updated  Uid'),
            'image_file' => Yii::t('app', 'Default Banner'),
            'banner_image_file_name' => Yii::t('app', 'Default Banner'),
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

    public function saveContent()
    {
        if ($this->validate() && $this->save()) {
            if ($this->image_file!=NULL) {
                $this->banner_image_file_name = Config::MenuBannerImageDisplayPath().'0.'.$this->image_file->getExtension();
                $this->saveImage();
                $this->save();
            }
            return true;
        } else {
            return false;
        }
    }

    public function saveImage()
    {
        // open image
        $image = Image::getImagine()->open($this->image_file->tempName);

        // rendering information about crop of ONE option
        $cropInfo = Json::decode($this->crop_info)[0];
        $cropInfo['dWidth'] = (int)$cropInfo['dWidth']; //new width image
        $cropInfo['dHeight'] = (int)$cropInfo['dHeight']; //new height image
        $cropInfo['x'] = $cropInfo['x']; //begin position of frame crop by X
        $cropInfo['y'] = $cropInfo['y']; //begin position of frame crop by Y

        //saving the image
        $newSizeImage = new Box($cropInfo['dWidth'], $cropInfo['dHeight']);
        $cropSizeImage = new Box($this->crop_width, $this->crop_height); //frame size of crop
        $cropPointImage = new Point($cropInfo['x'], $cropInfo['y']);
        $pathImage = $this->imagePath . '0.' . $this->image_file->getExtension();

        $image->resize($newSizeImage)
            ->crop($cropPointImage, $cropSizeImage)
            ->save($pathImage, ['quality' => 100]);
    }

    public function getImagePath(){
        return Config::MenuBannerImagePath();
    }

    public function getName() {
        if (Yii::$app->language == 'en' && !empty($this->web_name_en)) {
            return $this->web_name_en;
        } else if (Yii::$app->language == 'zh-CN' && !empty($this->web_name_cn)) {
            return $this->web_name_cn;
        }
        return $this->web_name_tw;
    }

    public function getWeb_name() {
        if (Yii::$app->language == 'en' && !empty($this->web_name_en)) {
            return $this->web_name_en;
        } else if (Yii::$app->language == 'zh-CN' && !empty($this->web_name_cn)) {
            return $this->web_name_cn;
        }
        return $this->web_name_tw;
    }

    public function getCopyright() {
        if (Yii::$app->language == 'en' && !empty($this->copyright_en)) {
            return $this->copyright_en;
        } else if (Yii::$app->language == 'zh-CN' && !empty($this->copyright_cn)) {
            return $this->copyright_cn;
        }
        return $this->copyright_tw;
    }

    public function getCopyright_notice() {
        if (Yii::$app->language == 'en' && !empty($this->copyright_notice_en)) {
            return $this->copyright_notice_en;
        } else if (Yii::$app->language == 'zh-CN' && !empty($this->copyright_notice_cn)) {
            return $this->copyright_notice_cn;
        }
        return $this->copyright_notice_tw;
    }

    public function getPrivacy_statement() {
        if (Yii::$app->language == 'en' && !empty($this->privacy_statement_en)) {
            return $this->privacy_statement_en;
        } else if (Yii::$app->language == 'zh-CN' && !empty($this->privacy_statement_cn)) {
            return $this->privacy_statement_cn;
        }
        return $this->privacy_statement_tw;
    }

    public function getDisclaimer() {
        if (Yii::$app->language == 'en' && !empty($this->disclaimer_en)) {
            return $this->disclaimer_en;
        } else if (Yii::$app->language == 'zh-CN' && !empty($this->disclaimer_cn)) {
            return $this->disclaimer_cn;
        }
        return $this->disclaimer_tw;
    }

    public function getShop_empty_desc() {
        if (Yii::$app->language == 'en' && !empty($this->shop_empty_desc_en)) {
            return $this->shop_empty_desc_en;
        } else if (Yii::$app->language == 'zh-CN' && !empty($this->shop_empty_desc_cn)) {
            return $this->shop_empty_desc_cn;
        }
        return $this->shop_empty_desc_tw;
    }

    public function getSiteCounter() {
        $this->site_counter++;
        $this->update();
        return $this->site_counter;
    }
}
