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
class PageType12 extends \common\components\BaseActiveRecord
{
    const HAS_CATEGORY = false;
    const CROP_IMAGE_FILE = false;

    public $top_media_type=self::TMT_IMAGE;

    const TMT_IMAGE = 1;
    const TMT_YOUTUBE = 2;

    public $picture_file_names=[];
    public $upload_files=[];
    public $poster_file;
    public $image_file;
    public $crop_info;

    public $crop_width;
    public $crop_height;

    const IMAGE_FILE_MAX_WIDTH = 720;
    const IMAGE_FILE_MAX_HEIGHT = 720;
    const POSTER_FILE_MAX_WIDTH = 1200;
    const POSTER_FILE_MAX_HEIGHT = 1200;
    const CROP_WIDTH = 720;
    const CROP_HEIGHT = 480;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'page_type12';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title_tw', 'title_cn', 'title_en'], 'trim'],
            // [['MID', 'category_id', 'status', 'updated_UID'], 'integer'],
            [['MID', 'district_id', 'avl_no_of_people_min', 'avl_no_of_people_max', 'avl_no_of_application', 'avl_no_of_live_year', 'is_open', 'status', 'updated_UID'], 'integer'],
            [['crop_width', 'crop_height'], 'integer'],
            // [['image_file_name', 'file_names', 'picture_file_names', 'display_at', 'created_at', 'updated_at'], 'safe'],
            [['poster_file_name', 'remarks', 'image_file_name', 'file_names', 'picture_file_names', 'display_at', 'created_at', 'updated_at'], 'safe'],
            [['display_at'], 'required'],
            // [Yii::$app->config->getRequiredLanguageAttributes(['title', 'content']), 'required'],
            [Yii::$app->config->getRequiredLanguageAttributes(['title']), 'required'],
            // [['content_tw', 'content_cn', 'content_en', 'image_file_name', 'file_names'], 'string'],
            [['content_tw', 'content_cn', 'content_en', 'image_file_name', 'file_names', 'poster_file_name', 'housing_location', 'housing_rent', 'remarks'], 'string'],
            [['upload_files'], 'image', 'skipOnEmpty' => true, 'mimeTypes' => 'image/png, image/jpeg, image/gif', 'minWidth' => 240, 'minHeight' => 180, 'maxFiles' => 10],
            [['poster_file', 'image_file'], 'file', 'skipOnEmpty' => true, 'mimeTypes' => 'image/png, image/jpeg, image/gif'],
            // [['author', 'title_tw', 'title_cn', 'title_en', 'youtube_id', 'apply_date', 'close_apply_date'], 'string', 'max' => 255],
            [['author', 'title_tw', 'title_cn', 'title_en', 'youtube_id'], 'string', 'max' => 255],
            [['summary_tw', 'summary_cn', 'summary_en'], 'string'],
            [['crop_info', 'top_media_type'], 'safe'],
            // ['image_file', 'checkClickCrop'],
            [['poster_file', 'image_file'], 'checkClickCrop'],
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
            'poster_file'               => '項目海報',
            'poster_file_name'          => '項目海報',
            'district_id'               => '地區',
            'housing_location'          => '地點',
            'housing_rent'              => '預期租金',
            'avl_no_of_people_min'      => '最低可供入住人數',
            'avl_no_of_people_max'      => '最高可供入住人數',
            'avl_no_of_application'     => '可供申請單位數目',
            'avl_no_of_live_year'       => '可供居住年期',
            'remarks'                   => '備註',
            'file_names' => Yii::t('app', 'Images'),
            'upload_files' => Yii::t('app', 'Images'),

            // 'apply_date' => '申請日期',
            // 'close_apply_date' => '截止申請日期',
            'is_open' => '開放狀態',
            'status' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'updated_UID' => Yii::t('app', 'Updated UID'),
        ];
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->avl_no_of_people_min > $this->avl_no_of_people_max) {
                $this->avl_no_of_people_max = $this->avl_no_of_people_min;
            }
            // $this->updated_at=date('Y-m-d H:i:s');
            return true;
        } else {
            return false;
        }
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

                
                if ($this->poster_file != NULL) {
                    $_image_filename = $this->id.'.'.$this->poster_file->getExtension();
                    $_image_file_path = $this->posterPath . '/' . $_image_filename;

                    $this->poster_file_name = $this->posterDisplayPath.$_image_filename.'?'.time();

                    if (self::CROP_IMAGE_FILE) {
                        $this->saveImage($_image_file_path);

                    } else {
                        $poster_image = Image::getImagine()->open($this->poster_file->tempName);
                        $imageSize = getimagesize($this->poster_file->tempName);

                        if ($imageSize[0] < self::POSTER_FILE_MAX_WIDTH && $imageSize[1] < self::POSTER_FILE_MAX_HEIGHT) {
                            $this->poster_file->saveAs($_image_file_path);

                        } else {
                            if ($imageSize[0] > $imageSize[1]) {
                                $newSizeImage = new Box(self::POSTER_FILE_MAX_WIDTH, floor(($imageSize[1] / $imageSize[0]) * self::POSTER_FILE_MAX_WIDTH));
                            } else {
                                $newSizeImage = new Box(floor(($imageSize[0] / $imageSize[1]) * self::POSTER_FILE_MAX_HEIGHT), self::POSTER_FILE_MAX_HEIGHT);
                            }
                            $poster_image->resize($newSizeImage)
                                ->save($_image_file_path, ['quality' => 100]);
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
        return Config::PageType12FilePath($this->id);
    }

    public function getFileDisplayPath(){
        return Config::PageType12FileDisplayPath($this->id);
    }

    public function getFileThumbPath(){
        return Config::PageType12FileThumbPath($this->id);
    }

    public function getFileThumbDisplayPath(){
        return Config::PageType12FileThumbDisplayPath($this->id);
    }

    public function getImagePath(){
        return Config::PageType12ImagePath();
    }

    public function getImageDisplayPath(){
        return Config::PageType12ImageDisplayPath();
    }

    public function getPosterPath(){
        return Config::PageType12PosterPath();
    }

    public function getPosterDisplayPath(){
        return Config::PageType12PosterDisplayPath();
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
