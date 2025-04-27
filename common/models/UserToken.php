<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use common\utils\Util;

/**
 */
class UserToken extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_token';
    }
    
    public function behaviors() {
        return [
            TimestampBehavior::className(),
        ];
    }

    public function beforeSave($insert) {
        $this->timestamp = Util::dbExpNow();
        return parent::beforeSave($insert);
    }
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'token'], 'required'],
            [['user_id', 'updated_UID'], 'integer'],
            [['token'], 'string', 'max' => 255],
            [['device_os', 'device_uuid', 'device_version', 'device_token'], 'string', 'max' => 255],
            [['timestamp', 'created_at', 'updated_at'], 'safe'],
            [['token'], 'unique'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public static function create($user_id, $device_os, $device_uuid, $device_version, $device_token) {
        if (($model=static::find()->where(['device_uuid' => $device_uuid])->one()) == null) {
            $model = new static(['device_uuid' => $device_uuid]);
            $model->token = Yii::$app->security->generateRandomString(64);
            while (static::find()->andWhere(['token' => $model->token])->count() > 0) {
                $model->token = Yii::$app->security->generateRandomString(64);
            }
        }
        $model->user_id = $user_id;
        $model->device_os = $device_os;
        $model->device_version = $device_version;
        $model->device_token = $device_token;
        
        if ($model->save())
            return $model;
        
        return false;
    }
}
