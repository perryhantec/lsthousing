<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "application_mark".
 *
 * @property int $id
 * @property int|null $application_id
 * @property int|null $i1
 * @property int|null $i2
 * @property int|null $i3
 * @property int|null $i4
 * @property int|null $i5
 * @property int|null $i6
 * @property int|null $i7
 * @property int|null $i8
 * @property int|null $i9
 * @property int|null $i10
 * @property int|null $i11
 * @property int|null $i12
 * @property int|null $i13
 * @property string|null $i14_description
 * @property int|null $i14
 * @property string|null $created_at
 * @property string $updated_at
 */
class ApplicationMark extends \yii\db\ActiveRecord
{
    public $application_chi_name;
    public $application_eng_name;
    public $application_no;
    public $application_created_at;
    public $application_priority_1;
    public $application_priority_2;
    public $application_priority_3;
    public $application_family_member;
    public $total_p1;
    public $total_p2_p3;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'application_mark';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['application_id', 'i1', 'i2', 'i3', 'i4', 'i5', 'i6', 'i7', 'i8', 'i9', 'i10', 'i11', 'i12', 'i13', 'i14', 'total'], 'integer', 'min' => 0],
            [['i14_description'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
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
            'i1' => '1. 持香港永久性居民身份證人數',
            'i2' => '2. 60歲或以上的長者人數',
            'i3' => '3. 17歲或以下的子女人數',
            'i4' => '4. 家庭中有1名或以上成員, 現正領取政府普通及高額傷殘津貼',
            'i5' => '5. 經兒童體能智力測驗中心評估確定為有特殊學習需要的兒童',
            'i6' => '6. 單親家庭',
            'i7' => '7. 家庭住戶每月收入中位數',
            'i8' => '8. 現時租金佔入息%',
            'i9' => '9. 沒有領取任何政府資助',
            'i10' => '10. 領取一般政府資助，如低收入在職家庭津貼、全額或半額書簿津貼、長者或高齡津貼等',
            'i11' => '11. 人均居住面積',
            'i12' => '12. 輪候公屋年數',
            'i13' => '13. 居住房屋種類',
            'i14_description' => '其他補充資料（0—4分） *社工轉介、衛生問題、鄰里問題及健康問題等',
            'i14' => '上述特殊情況可獲加',
            'total' => '評分',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',

            'chi_name' => '姓名(中文)',
            'eng_name' => '姓名(英文)',
            'appl_no' => '申請編號',
            // 'mobile' => '手提電話',
            'application_chi_name' => '申請人姓名(中文)',
            'application_eng_name' => '申請人姓名(英文)',
            'application_no' => '申請編號',
            'application_created_at' => '評審日期',
            'application_priority_1' => '入住計劃(第一優先選擇)',
            'application_priority_2' => '入住計劃(第二優先選擇)',
            'application_priority_3' => '入住計劃(第三優先選擇)',
            'application_family_member' => '申請入住人數',
            'total_p1' => '第一部份分數',
            'total_p2_p3' => '第二及三部份分數',
            // 'application_status' => '申請狀態',
        ];
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            $this->total = $this->i1  + $this->i2  + $this->i3  + $this->i4  +
                           $this->i5  + $this->i6  + $this->i7  + $this->i8  +
                           $this->i9  + $this->i10 + $this->i11 + $this->i12 +
                           $this->i13 + $this->i14;
            return true;
        } else {
            return false;
        }
    }

    public function getApplication()
    {
        return $this->hasOne(Application::className(), ['id' => 'application_id']);
    }
}
