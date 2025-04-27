<?php

namespace common\models;

use Yii;
use yii\helpers\Url;
use common\components\UploadedFile;
use common\behaviors\TimestampBehavior;
use common\behaviors\UserLogBehavior;

/**
 * This is the model class for table "file".
 *
 * @property int $id
 * @property string $filename
 * @property string $filepath
 * @property string $auth_key
 * @property int|null $status
 * @property string|null $created_at
 * @property string|null $created_by
 * @property string|null $updated_at
 * @property string|null $updated_by
 *
 * @property StudentApplicationAttachement[] $studentApplicationAttachements
 */
class File extends \yii\db\ActiveRecord {

  const STATUS_ACTIVE = 10;
  const STATUS_TEMP = 11;

  public $filedata;
  public $basename;
  public $extension;

  /**
   * {@inheritdoc}
   */
  public static function tableName() {
    return 'file';
  }

  /**
   * @inheritdoc
   */
  public function behaviors() {
    return [
        TimestampBehavior::class,
        UserLogBehavior::class
    ];
  }

  /**
   * @inheritdoc
   */
  public function rules() {
    return [
        [['basename', 'extension'], 'required']
    ];
  }

  public function beforeValidate() {
    if (is_a($this->filedata, UploadedFile::class)) {
      $this->basename = $this->filedata->getBaseName();
      $this->extension = $this->filedata->getExtension();
    }
    else if (is_a($this->filedata, File::class)) {
      $path_parts = pathinfo($this->filedata->getAbsoluteFilePath());
      $this->basename = $path_parts['basename'];
      $this->extension = $path_parts['extension'];
    }
    else if (is_string($this->filedata)) {
      $path_parts = pathinfo($this->filedata);
      $this->basename = $path_parts['basename'];
    }
    return parent::beforeValidate();
  }

  public function beforeSave($insert) {
    if ($insert) {
      $this->setAuthKey();
      // Set Attribute
      $folder = Yii::$app->security->generateRandomString(6);
      if (!file_exists($this->getAbsoluteFolder().'/'.$folder)) {

        mkdir($this->getAbsoluteFolder().'/'.$folder);
      }
      $this->filename = $this->basename.'.'.$this->extension;
      $this->filepath = $folder.'/'.Yii::$app->security->generateRandomString(12).'.'.$this->extension;

      // Check if file exist
      while (file_exists($this->getAbsoluteFilePath())) {
        $this->filepath = Yii::$app->security->generateRandomString(12).'.'.$this->extension;
      }

      // Save file
      if (is_a($this->filedata, UploadedFile::class)) {
        $this->filedata->saveAs($this->getAbsoluteFilePath());
      }
      else if (is_a($this->filedata, File::class)) {
        copy($this->filedata->getAbsoluteFilePath(), $this->getAbsoluteFilePath());
      }
      else if (is_string($this->filedata)) {
        copy($this->filedata, $this->getAbsoluteFilePath());
      }

      $this->status = self::STATUS_TEMP;
    }
    return parent::beforeSave($insert);
  }

  public function setAuthKey() {
    $this->auth_key = Yii::$app->security->generateRandomString(32);
    // Check if key repeated
    while (File::find()->andWhere(['auth_key' => $this->auth_key])->count() > 0) {
      $this->auth_key = Yii::$app->security->generateRandomString(32);
    }
  }

  public function setActive() {
    $this->status = self::STATUS_ACTIVE;
    $this->updateAttributes(['status']);
  }

  public function duplicate() {
    $file = new File(['filedata' => $this]);
    $file->save();
    return $file;
  }

  /**
   * {@inheritdoc}
   */
  public function attributeLabels() {
    return [
        'id' => Yii::t('app', 'ID'),
        'filename' => Yii::t('app', '名稱'),
        'filepath' => Yii::t('app', '檔案路徑'),
        'auth_key' => Yii::t('app', '密匙'),
        'status' => Yii::t('app', '狀態'),
        'created_at' => Yii::t('app', '建立日期'),
        'created_by' => Yii::t('app', '建立職員'),
        'updated_at' => Yii::t('app', '更新日期'),
        'updated_by' => Yii::t('app', '更新職員')
    ];
  }

  public function download($inline = true) {
    Yii::$app->response->sendFile($this->getAbsoluteFilepath(), $this->filename, ['inline' => $inline]);
  }

  /**
   * {@inheritdoc}
   * @return FileQuery the active query used by this AR class.
   */
  public static function find() {
    return new FileQuery(get_called_class());
  }

  public function getAbsoluteFilePath() {
    if (!empty($this->filepath))
      return File::getAbsoluteFolder().'/'.$this->filepath;
  }

  public static function getAbsoluteFolder() {
    return Yii::getAlias('@content').'/files';
  }

}
