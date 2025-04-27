<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\imagine\Image;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;
use common\models\HouseholdActivity;
// use common\models\User;
// use common\models\PageType12;

class HouseholdActivityForm extends HouseholdActivity
{


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return  [
            [['user_id', 'no_of_ppl', 'activity_status'], 'integer'],
            [['remarks'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['title', 'date', 'time', 'location', 'close_date', 'name', 'mobile'], 'string', 'max' => 255],

            [['mobile'], 'string', 'max' => 8],
            [['mobile'], 'checkMobile'],
            [['title', 'date', 'time', 'location', 'close_date', 'name', 'mobile', 'no_of_ppl'], 'required'],
        ];
    }

    public function checkMobile ($attribute) {
        if ((int)$this->mobile < 10000000 || (int)$this->mobile > 99999999) {
            $this->addError($attribute, '請輸入正確手提電話號碼');
            return false;
        }
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

    public function submit()
    {
        if ($this->validate()) {
            $this->user_id = Yii::$app->user->id;
            $this->activity_status = self::ACTIVITY_PENDING;
            $this->save(false);
            // $this->user_id = Yii::$app->user->id;
            // $this->application_status = self::APPL_STATUS_SUBMITED_FORM;

            // if ($this->save(false)) {
            //     $no_of_zero = self::APPL_NO_LENGTH - strlen($this->id);
            //     $this->appl_no = str_pad(self::APPL_NO_PREFIX, $no_of_zero, '0').$this->id;
    
            //     $this->save(false);

            // }

            // if ($this->upload_files != NULL) {
            //     foreach($this->upload_files as $k=>$v){
            //         $_filename = Yii::$app->security->generateRandomString(32) . '_' . time().'.'.$v->extension;

            //         Image::thumbnail($v->tempName, 180, 180)
            //             ->save($this->imageFilePath.'thumb_'.$_filename, ['quality' => 90]);

            //         $v->saveAs($this->imageFilePath.$_filename);

            //         $file_names[$_filename] = $v->baseName;
            //     }
            //     $this->image_files = json_encode($file_names, JSON_UNESCAPED_UNICODE);

            //     $this->save(false);
            // }

            return true;

        }

        return false;

    }


}
