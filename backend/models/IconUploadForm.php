<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\web\UploadedFile;
use common\models\Config;



class IconUploadForm extends Model
{
    /**
     * @var UploadedFile
     */
    public $imageFile;

    public function rules()
    {
        return [
            [['imageFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg, JPG, jpeg, JPEG, PNG'],
        ];
    }

    public function attributeLabels()
    {
        return [
          'imageFile' => Yii::t('app', 'Upload Icon'),
        ];
    }

    public function upload()
    {
      $this->imageFile = UploadedFile::getInstance($this, 'imageFile');
      if($this->imageFile!=NULL){
        if ($this->validate()) {
          $filepath = Config::LogoPath();
          $filepathname = $filepath . 'icon' . '.' . $this->imageFile->extension;
          \common\models\Logo::deleteIcon();
          $this->imageFile->saveAs($filepathname);

          // Image::crop($filepathname, 1920, 558)
          //     ->save($filepathname, ['quality' => 50]);
          return true;
        }
      }
      return false;
    }
}
