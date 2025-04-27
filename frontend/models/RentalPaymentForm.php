<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\imagine\Image;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;
use common\models\RentalPayment;
// use common\models\User;
// use common\models\PageType12;

class RentalPaymentForm extends RentalPayment
{


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return  [
            [['user_id', 'is_read'], 'integer'],
            [['files'], 'string'],
            [['files', 'created_at', 'updated_at'], 'safe'],
            // [['payment_date'], 'string', 'max' => 255],
            [['payment_year'], 'integer', 'min' => 1970, 'max' => date("Y") + 1],
            [['payment_month'], 'integer', 'min' => 1, 'max' => 12],
            [['payment_year', 'payment_month'], 'required'],

            [['upload_files'], 'required', 'message' => '請上載上述文件'],
            [['upload_files'], 'file', 'skipOnEmpty' => true, 'mimeTypes' => 'image/png, image/jpeg, application/pdf', 'maxFiles' => 3],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return ArrayHelper::merge(
            parent::attributeLabels(),
            [

            ]
        );
    }

    public function saveContent()
    {
        if ($this->upload_files!=NULL) {
            $this->upload_files = UploadedFile::getInstances($this, 'upload_files');
        }

        if ($this->validate()) {

            $files = [];
            foreach ($this->picture_file_names as $file_name => $title) {
                if ($file_name != "")
                    $files[$file_name] = $title;
            }
            $this->files = json_encode($files, JSON_UNESCAPED_UNICODE);
            $this->user_id = Yii::$app->user->id;
            $this->is_read = RentalPayment::IS_READ_NO;

            if ($this->save()) {
                if ($this->upload_files!=NULL) {
                    foreach($this->upload_files as $k=>$v){
// echo '<pre>';
// print_r($v);
// echo '</pre>';
                        $_filename = Yii::$app->security->generateRandomString(32) . '_' . time().'.'.$v->extension;

                        // Image::thumbnail($v->tempName, 240, 180)
                        //     ->save($this->fileThumbPath.$_filename, ['quality' => 100]);

                        $v->saveAs($this->filePath.$_filename);

                        $files[$_filename] = $v->baseName.'.'.$v->extension;
                    }
                    $this->files = json_encode($files, JSON_UNESCAPED_UNICODE);
                }
                // exit();
                $this->save(false);
            }

            return true;
        } else {
            return false;
        }
    }
}
