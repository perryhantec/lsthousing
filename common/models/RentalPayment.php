<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "rental_payment".
 *
 * @property int $id
 * @property int|null $user_id
 * @property string|null $files
 * @property string|null $payment_date
 * @property string|null $created_at
 * @property string $updated_at
 */
class RentalPayment extends \yii\db\ActiveRecord
{
    const IS_READ_NO = -1;
    const IS_READ_YES = 1;
    public $picture_file_names=[];
    public $upload_files;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'rental_payment';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'payment_year', 'payment_month', 'is_read'], 'integer'],
            [['files'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['payment_year'], 'integer', 'min' => 1970, 'max' => date("Y") + 1],
            [['payment_month'], 'integer', 'min' => 1, 'max' => 12],
            // [['payment_date'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'files' => '檔案',
            // 'payment_date' => 'Payment Date',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',

            'appl_no' => '申請編號',
            'project' => '項目名稱',
            'room_no' => '房間編號',
            'chi_name' => '姓名(中文)',
            'eng_name' => '姓名(英文)',
            'mobile' => '流動電話號碼',
            'user_appl_status' => '用戶狀態',
            'payment_year' => '交租年份',
            'payment_month' => '交租月份',
            'is_read' => '閱讀狀態',
        ];
    }

    public function afterFind()
    {
        parent::afterFind();

        if ($this->files != "")
            $this->picture_file_names = json_decode($this->files, true);
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getFilePath(){
        return Config::RentalFilePath($this->id);
    }

    public function getFileDisplayPath(){
        return Config::RentalFileDisplayPath($this->id);
    }

    public function getFileThumbPath(){
        return Config::RentalFileThumbPath($this->id);
    }

    public function getFileThumbDisplayPath(){
        return Config::RentalFileThumbDisplayPath($this->id);
    }
}
