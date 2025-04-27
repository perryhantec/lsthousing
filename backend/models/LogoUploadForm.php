<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\web\UploadedFile;
use common\models\Config;



class LogoUploadForm extends Model
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
          'imageFile' => Yii::t('app', 'Upload Logo'),
        ];
    }

    public function upload()
    {
      $this->imageFile = UploadedFile::getInstance($this, 'imageFile');

      if($this->imageFile!=NULL){
        if ($this->validate()) {
          $filepath = Config::LogoPath();
          $filepathname = $filepath . 'logo' . '.' . $this->imageFile->extension;
          \common\models\Logo::deleteLogo();
          $this->imageFile->saveAs($filepathname);

          // Image::crop($filepathname, 1920, 558)
          //     ->save($filepathname, ['quality' => 50]);
          return true;
        }
      }
      return false;
    }
}
