<?php

namespace common\models;

use Yii;
use yii\web\UploadedFile;
// use yii\imagine\Image;

/**
 * This is the model class for table "application_response_files".
 *
 * @property int $id
 * @property int|null $application_id
 * @property int|null $user_id
 * @property int|null $request_id
 * @property string|null $response
 * @property string|null $created_at
 * @property string $updated_at
 */
class ApplicationResponseFiles extends \yii\db\ActiveRecord
{
    public $picture_file_names=[];
    public $file_keys=[];
    public $upload_files;
    public $s1; public $s2; public $s3; public $s4; public $s5; public $s6; public $s7; public $s8; public $s9; public $s10;
    public $s11;public $s12;public $s13;public $s14;public $s15;public $s16;public $s17;
    public $application_status;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'application_response_files';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['application_id', 'user_id', 'request_id', 'application_status'], 'integer'],
            [['response', 'response_result', 'picture_file_names', 'created_at', 'updated_at'], 'safe'],
            [['response', 'response_result'], 'string'],
            // [['upload_files'], 'image', 'skipOnEmpty' => true, 'mimeTypes' => 'image/png, image/jpeg, image/jpg, application/pdf', 'minWidth' => 240, 'minHeight' => 180, 'maxFiles' => 10],
            // [['application_id', 'request_id'], 'required'],
            [[
                's1',  's2',  's3',  's4',  's5',  's6',  's7', 's8', 's9', 's10',
                's11', 's12', 's13', 's14', 's15', 's16', 's17'
            ], 'integer'],
            [[
                's1',  's2',  's3',  's4',  's5',  's6',  's7', 's8', 's9', 's10',
                's11', 's12', 's13', 's14', 's15', 's16', 's17'
            ], 'required', 'when' => function ($model) {
                for ($i = 1; $i <= 17; $i++) {
                    $field = 's'.$i;
                    if (isset($model->$field)) {
                        return true;
                    }
                }
                return false;
            }],

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
            'application_id' => 'Application ID',
            'user_id' => 'User ID',
            'request_id' => 'Request ID',
            'response' => 'Response',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',

            'appl_no' => '申請編號',
            'ref_code' => '參考編號',
            'app_status' => '申請者狀態',
            'application_no' => '申請編號',
            'application_status' => '申請狀態',
            's1'  => '此項', 's2'  => '此項', 's3'  => '此項', 's4'  => '此項', 's5'  => '此項', 's6'  => '此項', 
            's7'  => '此項', 's8'  => '此項', 's9'  => '此項', 's10' => '此項', 's11' => '此項', 's12' => '此項', 
            's13' => '此項', 's14' => '此項', 's15' => '此項', 's16' => '此項', 's17' => '此項',

            'chi_name' => '姓名(中文)',
            'eng_name' => '姓名(英文)',
            'mobile' => '流動電話號碼',
        ];
    }
    
    public function afterFind()
    {
        parent::afterFind();

        if ($this->response != "") {
            $this->picture_file_names = json_decode($this->response, true);
            if ($this->picture_file_names) {
                foreach ($this->picture_file_names as $file) {
                    $this->file_keys[] = $file['file_key'];
                }    
            }
        }
    }

    public function submit()
    {
        $response_result = [];
        $all_pass = true;
        for ($i = 1; $i <= 17; $i++) {
            $field = 's'.$i;
            if (isset($this->$field)) {
                $response_result[$field] = $this->$field;
                if ($this->$field != 1) {
                    $all_pass = false;
                }
            }
        }
        $this->response_result = json_encode($response_result);
        $this->save(false);

        if (!$all_pass) {
            $appl_model = Application::findOne($this->application);
            $appl_model->application_status = Application::APPL_STATUS_UPLOAD_FILES_AGAIN;
            $appl_model->save(false);
        }
        return true;
    }

    public function getApplication()
    {
        return $this->hasOne(Application::className(), ['id' => 'application_id']);
    }

    public function getApplicationRequestFiles()
    {
        return $this->hasOne(ApplicationRequestFiles::className(), ['id' => 'request_id']);
    }

    // public function getFilePath(){
    //     return Config::ResponseFilePath($this->id);
    // }

    // public function getFileDisplayPath(){
    //     return Config::ResponseFileDisplayPath($this->id);
    // }

    // public function getFileThumbPath(){
    //     return Config::ResponseFileThumbPath($this->id);
    // }

    // public function getFileThumbDisplayPath(){
    //     return Config::ResponseFileThumbDisplayPath($this->id);
    // }

    public function getFilePath(){
        return Config::FileFilePath($this->id);
    }

    public function getFileDisplayPath(){
        // return Config::FileFileDisplayPath($this->id);
        return Config::FileFileDisplayPath($this->id);
    }

    public function getFileThumbPath(){
        return Config::FileFileThumbPath($this->id);
    }

    public function getFileThumbDisplayPath(){
        return Config::FileFileThumbDisplayPath($this->id);
    }
}
