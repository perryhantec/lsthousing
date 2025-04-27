<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "application_sms".
 *
 * @property int $id
 * @property int|null $application_id
 * @property int|null $user_id
 * @property string|null $sent_at
 * @property int|null $status
 * @property string|null $sent_response
 * @property string|null $sent_reference
 * @property string|null $created_at
 * @property string $updated_at
 * @property int|null $updated_UID
 */
class ApplicationSms extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'application_sms';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['application_id', 'user_id', 'status', 'updated_UID'], 'integer'],
            [['sent_at', 'created_at', 'updated_at'], 'safe'],
            [['sent_response', 'sent_reference'], 'string', 'max' => 255],
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
            'sent_at' => 'Sent At',
            'status' => 'Status',
            'sent_response' => 'Sent Response',
            'sent_reference' => 'Sent Reference',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'updated_UID' => 'Updated  Uid',
        ];
    }
}
