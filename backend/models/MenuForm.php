<?php

namespace backend\models;

use Yii;
use yii\web\UploadedFile;
use yii\helpers\Json;
use yii\helpers\ArrayHelper;
use yii\imagine\Image;
use Imagine\Image\Box;
use Imagine\Image\Point;
use common\models\Menu;
use common\models\Config;

class MenuForm extends Menu
{
    public $image_file;
    public $crop_info;

    public $crop_width;
    public $crop_height;

    public $icon_file;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        $_rules = [
            [Yii::$app->config->getAllLanguageAttributes('name'), 'trim'],
            [['MID', 'seq', 'home_seq', 'page_type', 'link_target', 'display_home', 'status', 'updated_UID'], 'integer'],
            [Yii::$app->config->getAllLanguageAttributes('name'), 'required'],
            [['url'], 'unique'],
            [['url', 'page_type'], 'required'],
            [['link'], 'string'],
            [['url', 'name_tw', 'name_cn', 'name_en', 'banner_image_file_name', 'icon_file_name'], 'string', 'max' => 255],
            [['updated_at'], 'safe'],
            [['image_file'], 'file', 'skipOnEmpty' => true, 'mimeTypes' => 'image/png, image/jpeg, image/gif'],
            [['icon_file'], 'file', 'skipOnEmpty' => true, 'mimeTypes' => 'image/png, image/jpeg, image/gif', 'maxFiles' => 1],
            ['crop_info', 'safe'],
            [['crop_width', 'crop_height'], 'integer'],
            ['image_file', 'checkClickCrop'],
        ];

        $_canEditMenusId = Yii::$app->user->identity->canEditMenusId;
        if ($_canEditMenusId != null)
            $_rules[] = ['MID', 'in', 'range' => $_canEditMenusId];

        if (!\backend\components\AccessRule::checkRole(['menu.root']))
            $_rules[] = ['MID', 'required'];

        return $_rules;
    }

    public function checkClickCrop($attribute, $params)
    {
        if ($this->image_file != NULL && Json::decode($this->crop_info)==NULL) {
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
            'MID' => Yii::t('app', 'Belong to'),
            'name_tw' => Yii::t('app', 'Name').' '.Yii::t('app', '(Traditional Chinese Version)'),
            'name_cn' => Yii::t('app', 'Name').' '.Yii::t('app', '(Simplified Chinese Version)'),
            // 'name_en' => Yii::t('app', 'Name').' '.Yii::t('app', '(English Version)'),
            'name_en' => Yii::t('app', 'Name').' (英文版本 -- 用作生成網址)',
            'url' => Yii::t('app', 'URL'),
            'page_type' => Yii::t('app', 'Page Type'),
            'link' => Yii::t('app', 'Link'),
            'link_target' => Yii::t('app', 'New Window'),
            'display_member' => Yii::t('app', 'For Member Only'),
            'display_home' => Yii::t('app', 'Show In Home Page'),
            'status' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated Dt'),
            'updated_UID' => Yii::t('app', 'Updated UID'),
            'image_file' => Yii::t('app', 'Banner'),
            'banner_image_file_name' => Yii::t('app', 'Banner'),
            'icon_file' => Yii::t('app', 'Icon'),
        ];
    }

    public function afterSave($insert, $changedAttributes)
    {
        if (parent::afterSave($insert, $changedAttributes)) {
            self::updateSeq($this->MID);
            return true;
        } else {
            return false;
        }
    }

    public function saveContent()
    {
        $this->image_file = UploadedFile::getInstance($this, 'image_file');
        $this->icon_file = UploadedFile::getInstance($this, 'icon_file');

        if ($this->url == "" && Yii::$app->config->checkLanguageSupported('en'))
            $this->url = $this->name_en;
        $this->url = strtolower(preg_replace('/\s+/', '-', preg_replace("/[^A-Za-z0-9 -]/", '', strip_tags($this->url))));

        if ($this->url == "")
            $this->url = strval($this->id);

        if ($this->validate() && $this->save()) {
            if ($this->icon_file!=NULL) {
                $this->icon_file_name = $this->id.'.'.$this->icon_file->extension;
                $this->icon_file->saveAs($this->iconImagePath.$this->icon_file_name);
                $this->icon_file = null;
                $this->save(false);
            }
            if ($this->image_file!=NULL) {
                $this->banner_image_file_name = Config::MenuBannerImageDisplayPath().$this->id.'.'.$this->image_file->getExtension();
                $this->saveImage();
                $this->save(false);
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
        $pathImage = $this->imagePath . $this->id . '.' . $this->image_file->getExtension();

        $image->resize($newSizeImage)
            ->crop($cropPointImage, $cropSizeImage)
            ->save($pathImage, ['quality' => 100]);
    }

}
