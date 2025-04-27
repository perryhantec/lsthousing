<?php

namespace common\models;

use Yii;
use yii\web\UploadedFile;
use yii\helpers\Json;
use Imagine\Image\Box;
use Imagine\Image\Point;
use yii\imagine\Image;
use yii\imagine\BaseImage;

/**
 * This is the model class for table "page_type4".
 */
class PageType11 extends \common\components\BaseActiveRecord
{
    const HAS_CATEGORY = false;
    const CROP_IMAGE_FILE = false;

    public $top_media_type=self::TMT_IMAGE;

    const TMT_IMAGE = 1;
    const TMT_YOUTUBE = 2;

    public $picture_file_names=[];
    public $upload_files=[];
    public $image_file;
    public $crop_info;

    public $crop_width;
    public $crop_height;

    const IMAGE_FILE_MAX_WIDTH = 720;
    const IMAGE_FILE_MAX_HEIGHT = 720;
    const CROP_WIDTH = 720;
    const CROP_HEIGHT = 480;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'page_type11';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title_tw', 'title_cn', 'title_en'], 'trim'],
            // [['MID', 'category_id', 'status', 'updated_UID'], 'integer'],
            [['MID', 'housing_status', 'number_of_housing', 'status', 'updated_UID'], 'integer'],
            [['crop_width', 'crop_height'], 'integer'],
            [['image_file_name', 'file_names', 'picture_file_names', 'display_at', 'created_at', 'updated_at'], 'safe'],
            [['display_at'], 'required'],
            // [Yii::$app->config->getRequiredLanguageAttributes(['title', 'content']), 'required'],
            [Yii::$app->config->getRequiredLanguageAttributes(['title']), 'required'],
            // [['content_tw', 'content_cn', 'content_en', 'image_file_name', 'file_names'], 'string'],
            [['expect_apply_date', 'expect_live_date', 'content_tw', 'content_cn', 'content_en', 'image_file_name', 'file_names'], 'string'],
            [['upload_files'], 'image', 'skipOnEmpty' => true, 'mimeTypes' => 'image/png, image/jpeg, image/gif', 'minWidth' => 240, 'minHeight' => 180, 'maxFiles' => 10],
            [['image_file'], 'file', 'skipOnEmpty' => true, 'mimeTypes' => 'image/png, image/jpeg, image/gif'],
            [['author', 'title_tw', 'title_cn', 'title_en', 'youtube_id'], 'string', 'max' => 255],
            [['summary_tw', 'summary_cn', 'summary_en'], 'string'],
            [['crop_info', 'top_media_type'], 'safe'],
            ['image_file', 'checkClickCrop'],
            [['MID'], 'exist', 'skipOnError' => true, 'targetClass' => Menu::className(), 'targetAttribute' => ['MID' => 'id']],
            // [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => PageType4Category::className(), 'targetAttribute' => ['category_id' => 'id']],
        ];
    }

    public function checkClickCrop($attribute, $params)
    {
        if (self::CROP_IMAGE_FILE && $this->image_file != NULL && $this->top_media_type == self::TMT_IMAGE && Json::decode($this->crop_info)==NULL) {
            $this->addError($attribute, Yii::t('app', "Please click 'Crop'."));
        }
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'MID' => Yii::t('app', 'Mid'),
            'display_at' => Yii::t('app', 'Display At'),
            'author' => Yii::t('app', 'Author'),
            // 'category_id' => Yii::t('app', 'Category'),
            'image_file' => Yii::t('app', 'Thumbnail'),
            'image_file_name' => Yii::t('app', 'Thumbnail'),
            'youtube_id' => Yii::t('app', 'YouTube ID'),
            'top_media_type' => Yii::t('app', 'Thumbnail Media Type'),
            'title' => Yii::t('app', 'Title'),
            'title_tw' => Yii::t('app', 'Title').' '.Yii::t('app', '(Traditional Chinese Version)'),
            'title_cn' => Yii::t('app', 'Title').' '.Yii::t('app', '(Simplified Chinese Version)'),
            'title_en' => Yii::t('app', 'Title').' '.Yii::t('app', '(English Version)'),
            'summary_tw' => Yii::t('app', 'Summary').' '.Yii::t('app', '(Traditional Chinese Version)'),
            'summary_cn' => Yii::t('app', 'Summary').' '.Yii::t('app', '(Simplified Chinese Version)'),
            'summary_en' => Yii::t('app', 'Summary').' '.Yii::t('app', '(English Version)'),
            'content_tw' => Yii::t('app', 'Content').' '.Yii::t('app', '(Traditional Chinese Version)'),
            'content_cn' => Yii::t('app', 'Content').' '.Yii::t('app', '(Simplified Chinese Version)'),
            'content_en' => Yii::t('app', 'Content').' '.Yii::t('app', '(English Version)'),
            'housing_status' => '項目狀態',
            'expect_apply_date' => '申請日期',
            'expect_live_date' => '入伙日期',
            'number_of_housing' => '提供社會房屋單位數目',
            'file_names' => Yii::t('app', 'Images'),
            'upload_files' => Yii::t('app', 'Images'),
            'status' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'updated_UID' => Yii::t('app', 'Updated UID'),
        ];
    }

    public function afterFind()
    {
        parent::afterFind();

        if ($this->youtube_id != null)
            $this->top_media_type = self::TMT_YOUTUBE;

        if ($this->file_names != "")
            $this->picture_file_names = json_decode($this->file_names, true);

    }

    public function saveContent()
    {
        if ($this->upload_files!=NULL) {
            $this->upload_files = UploadedFile::getInstances($this, 'upload_files');
        }

        if ($this->validate()) {

            $file_names = [];
            foreach ($this->picture_file_names as $file_name => $title) {
                if ($file_name != "")
                    $file_names[$file_name] = $title;
            }
            $this->file_names = json_encode($file_names, JSON_UNESCAPED_UNICODE);

            if ($this->save()) {
                if ($this->top_media_type == self::TMT_YOUTUBE) {
                    $this->image_file_name = null;

                } else if ($this->top_media_type == self::TMT_IMAGE) {
                    $this->youtube_id = null;

                    if ($this->image_file != NULL) {
                        $_image_filename = $this->id.'.'.$this->image_file->getExtension();
                        $_image_file_path = $this->imagePath . '/' . $_image_filename;

                        $this->image_file_name = $this->imageDisplayPath.$_image_filename.'?'.time();

                        if (self::CROP_IMAGE_FILE) {
                            $this->saveImage($_image_file_path);

                        } else {
                            $image = Image::getImagine()->open($this->image_file->tempName);
                            $imageSize = getimagesize($this->image_file->tempName);

                            if ($imageSize[0] < self::IMAGE_FILE_MAX_WIDTH && $imageSize[1] < self::IMAGE_FILE_MAX_HEIGHT) {
                                $this->image_file->saveAs($_image_file_path);

                            } else {
                                if ($imageSize[0] > $imageSize[1]) {
                                    $newSizeImage = new Box(self::IMAGE_FILE_MAX_WIDTH, floor(($imageSize[1] / $imageSize[0]) * self::IMAGE_FILE_MAX_WIDTH));
                                } else {
                                    $newSizeImage = new Box(floor(($imageSize[0] / $imageSize[1]) * self::IMAGE_FILE_MAX_HEIGHT), self::IMAGE_FILE_MAX_HEIGHT);
                                }
                                $image->resize($newSizeImage)
                                    ->save($_image_file_path, ['quality' => 100]);
                            }
                        }
                    }
                }
                if ($this->upload_files!=NULL) {
                    foreach($this->upload_files as $k=>$v){
                        $_filename = Yii::$app->security->generateRandomString(32) . '_' . time().'.'.$v->extension;

                        Image::thumbnail($v->tempName, 240, 180)
                            ->save($this->fileThumbPath.$_filename, ['quality' => 100]);

                        $v->saveAs($this->filePath.$_filename);

                        $file_names[$_filename] = $v->baseName;
                    }
                    $this->file_names = json_encode($file_names, JSON_UNESCAPED_UNICODE);
                }

                $this->save(false);
            }
            return true;
        } else {
            return false;
        }
    }

    public function saveImage($image_path)
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

        $image->resize($newSizeImage)
            ->crop($cropPointImage, $cropSizeImage)
            ->save($image_path, ['quality' => 100]);
    }

    public function getFilePath(){
        return Config::PageType11FilePath($this->id);
    }

    public function getFileDisplayPath(){
        return Config::PageType11FileDisplayPath($this->id);
    }

    public function getFileThumbPath(){
        return Config::PageType11FileThumbPath($this->id);
    }

    public function getFileThumbDisplayPath(){
        return Config::PageType11FileThumbDisplayPath($this->id);
    }

    public function getImagePath(){
        return Config::PageType11ImagePath();
    }

    public function getImageDisplayPath(){
        return Config::PageType11ImageDisplayPath();
    }

    public function getMenu(){
        return $this->hasOne(Menu::className(), ['id' => 'MID']);
    }

    public function getTitle(){
        if (Yii::$app->language == 'en' && $this->title_en != "")
            return $this->title_en;
        else if (Yii::$app->language == 'zh-CN' && $this->title_cn != "")
            return $this->title_cn;
        return $this->title_tw;
    }
    public function getSummary(){
        $result = $this->summary_tw;
        if (Yii::$app->language == 'en' && $this->summary_en != "")
            $result = $this->summary_en;
        else if (Yii::$app->language == 'zh-CN' && $this->summary_cn != "")
            $result = $this->summary_cn;

        if ($result == "") {
            $result = mb_substr(trim(str_replace(["\r\n", "\n", "&nbsp;", "  "], ' ', html_entity_decode(strip_tags($this->content)))), 0, 150);
            if ($result != "")
                $result .= "...";
        }

        return $result;
    }
    public function getContent(){
        if (Yii::$app->language == 'en' && $this->content_en != "")
            return $this->content_en;
        else if (Yii::$app->language == 'zh-CN' && $this->content_cn != "")
            return $this->content_cn;
        return $this->content_tw;
    }

}
