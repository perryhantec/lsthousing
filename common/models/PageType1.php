<?php

namespace common\models;

use Yii;
use yii\web\UploadedFile;
use yii\imagine\Image;
use yii\imagine\BaseImage;

/**
 * This is the model class for table "page_type1".
 */
class PageType1 extends \common\components\BaseActiveRecord
{
    const HAVE_IMAGE_TUMB = true;

    public $upload_files=[];
    public $picture_file_names=[];

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'page_type1';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['MID', 'status', 'updated_UID'], 'integer'],
            [Yii::$app->config->getRequiredLanguageAttributes('content'), 'required'],
            [['content_tw', 'content_cn', 'content_en', 'file_names'], 'string'],
            [['created_at', 'updated_at', 'picture_file_names'], 'safe'],
            [['upload_files'], 'image', 'skipOnEmpty' => true, 'mimeTypes' => 'image/png, image/jpeg, image/gif', 'minWidth' => 240, 'minHeight' => 180, 'maxFiles' => 10],
            [['MID'], 'exist', 'skipOnError' => true, 'targetClass' => Menu::className(), 'targetAttribute' => ['MID' => 'id']],
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
            'content_tw' => Yii::t('app', 'Content').' '.Yii::t('app', '(Traditional Chinese Version)'),
            'content_cn' => Yii::t('app', 'Content').' '.Yii::t('app', '(Simplified Chinese Version)'),
            'content_en' => Yii::t('app', 'Content').' '.Yii::t('app', '(English Version)'),
            'top_youtube' => Yii::t('app', 'YouTube'),
            'file_names' => Yii::t('app', 'Images'),
            'upload_files' => Yii::t('app', 'Images'),
            'status' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'updated_UID' => Yii::t('app', 'Updated  Uid'),
        ];
    }

    public function afterFind() {
        parent::afterFind();

        if (!empty($this->file_names))
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

    public function getFileThumbPath(){
        return Config::PageType1FileThumbPath($this->id);
    }

    public function getFileThumbDisplayPath(){
        return Config::PageType1FileThumbDisplayPath($this->id);
    }

    public function getFilePath(){
        return Config::PageType1FilePath($this->id);
    }

    public function getFileDisplayPath(){
        return Config::PageType1FileDisplayPath($this->id);
    }

    public function getFiles(){
        return $this->hasMany(PageType4File::className(), ['MID' => 'id']);
    }

    public function getMenu(){
        return $this->hasOne(Menu::className(), ['id' => 'MID']);
    }

    public function getContent(){
        if (Yii::$app->language == 'en'){
            if ($this->content_en == "")
                return '<p>Please refer to Chinese version.</p>';
            return $this->content_en;
        } else if (Yii::$app->language == 'zh-CN' && $this->content_cn != ""){
            return $this->content_cn;
        }
        return $this->content_tw;
    }
}
