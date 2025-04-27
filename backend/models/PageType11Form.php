<?php

namespace backend\models;

use Yii;
use yii\web\UploadedFile;
use yii\helpers\Json;
use yii\helpers\ArrayHelper;
use yii\imagine\Image;
use Imagine\Image\Box;
use Imagine\Image\Point;
use common\models\PageType11;
use common\models\Config;
use common\models\Menu;

class PageType11Form extends PageType11
{
//    public $MID;
    public $icon_file;
    public $upload_files=[];
    public $picture_file_names=[];


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // [['seq', 'show_year', 'start_year', 'end_year', 'status'], 'integer'],
            [['seq', 'show_year', 'status', 'MID'], 'integer'],
            [['description', 'file_names'], 'string'],
            [['created_at', 'updated_at', 'picture_file_names'], 'safe'],
            [['color', 'icon_file_name'], 'string', 'max' => 255],

            [['icon_file'], 'file', 'skipOnEmpty' => true, 'mimeTypes' => 'image/png, image/jpeg, image/gif', 'maxFiles' => 1],
            [['upload_files'], 'image', 'skipOnEmpty' => true, 'mimeTypes' => 'image/png, image/jpeg, image/gif', 'minWidth' => 240, 'minHeight' => 180, 'maxFiles' => 10],


            // [['image_file'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, JPG, jpeg, JPEG, PNG'],
            // [['crop_width', 'crop_height'], 'integer'],
            // ['crop_info', 'safe'],
            // ['image_file', 'checkClickCrop'],
        ];        
    }
    
    /**
     * @inheritdoc
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

            'icon_file' => Yii::t('app', 'Icon'),
        ];
    }

    // public function afterSave($insert, $changedAttributes)
    // {
    //     
    //     if (parent::afterSave($insert, $changedAttributes)) {
    //         self::updateSeq($this->MID);
    //         return true;
    //     } else {
    //         return false;
    //     }
    // }

    public function saveContent()
    {
        if ($this->upload_files!=NULL) {
            $this->upload_files = UploadedFile::getInstances($this, 'upload_files');
        }
        $this->icon_file = UploadedFile::getInstance($this, 'icon_file');

        // die('123');
        if ($this->validate()) {          
            $file_names = [];
            foreach ($this->picture_file_names as $file_name => $title) {
                if ($file_name != "")
                    $file_names[$file_name] = $title;
            }
            $this->file_names = json_encode($file_names, JSON_UNESCAPED_UNICODE);
            // die('456');
            if ($this->save()){
                // die('abc');
                if ($this->icon_file!=NULL) {
                    // die('def');
                    $this->icon_file_name = $this->id.'.'.$this->icon_file->extension;
                    $this->icon_file->saveAs($this->iconImagePath.$this->icon_file_name);
                    $this->icon_file = null;
                    $this->save(false);
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

                    $this->save(false);
                }
            }

            return true;
        } else {
            return false;
        }
    }
}
