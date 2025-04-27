<?php

namespace common\models;

use Yii;
use yii\helpers\Json;
use Imagine\Image\Box;
use Imagine\Image\Point;
use yii\imagine\Image;

/**
 * This is the model class for table "about_us".
 *
 * @property int $id
 * @property int|null $seq
 * @property int|null $show_year
 * @property int|null $start_year
 * @property int|null $end_year
 * @property string|null $color
 * @property string|null $icon
 * @property string|null $disscription
 * @property string|null $images
 * @property int|null $status
 * @property string|null $created_at
 * @property string $updated_at
 */
class AboutUs extends \yii\db\ActiveRecord
{
    const STATUS_0 = 0;
    const STATUS_1 = 1;

    const CROP_WIDTH = 46;
    const CROP_HEIGHT = 36;
    const HAVE_ICON = true;
    const HAVE_IMAGE_TUMB = true;

    // public $upload_files=[];
    public $picture_file_names=[];

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'about_us';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            // [['seq', 'show_year', 'start_year', 'end_year', 'status'], 'integer'],
            [['seq', 'show_year', 'status'], 'integer'],
            [['description', 'file_names'], 'string'],
            [['created_at', 'updated_at', 'picture_file_names'], 'safe'],
            [['color', 'icon_file_name'], 'string', 'max' => 255],

            // [['image_file'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, JPG, jpeg, JPEG, PNG'],
            // [['crop_width', 'crop_height'], 'integer'],
            // ['crop_info', 'safe'],
            // ['image_file', 'checkClickCrop'],
        ];
    }

    public function checkClickCrop($attribute, $params)
    {
        if($this->image_file != NULL && Json::decode($this->crop_info)==NULL){
            $this->addError($attribute, "Please click 'Crop'.");
        }
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'seq' => '排列',
            'show_year' => '顯示年份',
            // 'start_year' => 'Start Year',
            // 'end_year' => 'End Year',
            'color' => '顏色',
            'icon_file_name' => 'Icon',
            'description' => '內容',
            'file_names' => '圖像',
            'status' => '狀態',
            'created_at' => '新增日期',
            'updated_at' => 'Updated At',

            // 'image_file' => Yii::t('app', 'Default Banner'),
        ];
    }

    public function afterFind() {
        parent::afterFind();

        if (!empty($this->file_names))
            $this->picture_file_names = json_decode($this->file_names, true);

    }

    public function getIconImagePath(){
        return Config::AboutUsIconImagePath();
    }

    public function getIconDisplayPath(){
        if ($this->icon_file_name != "")
            return Config::AboutUsIconImageDisplayPath().$this->icon_file_name;
    }

    public function getFileThumbPath(){
        return Config::AboutUsFileThumbPath($this->id);
    }

    public function getFileThumbDisplayPath(){
        return Config::AboutUsFileThumbDisplayPath($this->id);
    }

    public function getFilePath(){
        return Config::AboutUsFilePath($this->id);
    }

    public function getFileDisplayPath(){
        return Config::AboutUsFileDisplayPath($this->id);
    }
}
