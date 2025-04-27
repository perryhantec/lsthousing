<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "test".
 *
 * @property int $id
 * @property string|null $response
 * @property string|null $created_at
 * @property string $updated_at
 */
class Test extends \yii\db\ActiveRecord
{
    public $upload_files;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'test';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['response'], 'string'],
            [['upload_files', 'created_at', 'updated_at'], 'safe'],

            // [['upload_files'], 'required', 'message' => '請上載上述文件'],
            // [['upload_files'], 'file', 'skipOnEmpty' => true, 'mimeTypes' => 'image/png, image/jpeg, application/pdf', 'maxFiles' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'response' => 'Response',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public function submit() {
        $this->response = json_encode($this->upload_files, JSON_UNESCAPED_UNICODE);
        $this->save();
    }


    public function getFilePath(){
        return Config::TestFilePath($this->id);
    }

    public function getFileDisplayPath(){
        return Config::TestFileDisplayPath($this->id);
    }

    public function getFileThumbPath(){
        return Config::TestFileThumbPath($this->id);
    }

    public function getFileThumbDisplayPath(){
        return Config::TestFileThumbDisplayPath($this->id);
    }
}
