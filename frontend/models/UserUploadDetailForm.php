<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\imagine\Image;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;
use common\models\ApplicationRequestFiles;
use common\models\ApplicationResponseFiles;

class UserUploadDetailForm extends ApplicationResponseFiles
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['application_id', 'user_id', 'request_id', 'application_status'], 'integer'],
            [['response', 'picture_file_names', 'created_at', 'updated_at'], 'safe'],
            [['response'], 'string'],
            [['application_id', 'request_id'], 'required'],
            [[
                's1',  's2',  's3',  's4',  's5',  's6',  's7', 's8', 's9', 's10',
                's11', 's12', 's13', 's14', 's15', 's16', 's17'
            ], 'integer'],
            [['upload_files'], 'safe'],
            // [['upload_files'], 'required', 'message' => '請上載上述文件'],
            // [['upload_files'], 'file', 'skipOnEmpty' => true, 'mimeTypes' => 'image/png, image/jpeg, application/pdf', 'maxFiles' => 50],
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
                // 'upload_files' => Yii::t('in-kind-donation', 'Images'),
                // 'verifyCode' => Yii::t('app', 'Verification Code'),
                // 'part5_t1'          => '此項聲明及承諾',
            ]
        );
    }

    // public function afterFind()
    // {
    //     parent::afterFind();

    //     if ($this->response != "")
    //         $this->picture_file_names = json_decode($this->response, true);

    // }

    public function submit() {
        if ($this->validate()) {
            $req_model = ApplicationRequestFiles::findOne($this->request_id);
            $req_model->app_status = ApplicationRequestFiles::RESQ_APP_STATUS_SUBMITTED;
            $req_model->save(false);

            $this->user_id = Yii::$app->user->id;
            $this->response = json_encode($this->upload_files, JSON_UNESCAPED_UNICODE);
            $this->save(false);

            return true;
        }
    }

    public function sendEmail()
    {
        return Yii::$app->mailer->compose('upload_file', [
                'model' => $this,
                'appl_no' => $this->application->appl_no,
                'chi_name' => $this->application->chi_name,
                'eng_name' => $this->application->eng_name,
                'mobile' => $this->application->mobile])
                ->setTo(Yii::$app->params['contactEmail'])
                ->setFrom(Yii::$app->params['supportEmail'])
               //  ->setReplyTo($this->email)
                ->setSubject('此申請者已上載文件')
                ->send();
    }
/*
    public function saveContent()
    {
        if ($this->upload_files!=NULL) {
            $this->upload_files = UploadedFile::getInstances($this, 'upload_files');
        }

        if ($this->validate()) {

            $response = [];
            foreach ($this->picture_file_names as $file_name => $title) {
                if ($file_name != "")
                    $response[$file_name] = $title;
            }
            $this->response = json_encode($response, JSON_UNESCAPED_UNICODE);
            $this->user_id = Yii::$app->user->id;

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

                        $response[$_filename] = $v->baseName.'.'.$v->extension;
                    }
                    $this->response = json_encode($response, JSON_UNESCAPED_UNICODE);
                }
                // exit();

                $this->save(false);
            }

            $req_model = ApplicationRequestFiles::findOne($this->request_id);
            $req_model->app_status = ApplicationRequestFiles::RESQ_APP_STATUS_SUBMITTED;
            $req_model->save(false);

            return true;
        } else {
            return false;
        }
    }
*/
}
