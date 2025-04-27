<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "application_request_files".
 *
 * @property int $id
 * @property int|null $application_id
 * @property string|null $files
 * @property string|null $remarks
 */
class ApplicationRequestFiles extends \yii\db\ActiveRecord
{
    public $i1; public $i2; public $i3; public $i4; public $i5; public $i6; public $i7;
    public $i8; public $i9; public $i10;public $i11;public $i12;public $i13;public $i14;
    public $i15;public $i16;public $i17;public $i18;public $i19;public $i20;public $i21;
    public $i22;public $i23;public $i24;public $i25;public $i26;public $i27;public $i28;
    public $check_files;

    const RESQ_APP_STATUS_SUBMITTED = 2;
    const RESQ_PREFIX = 'RESQ';
    const RESQ_LENGTH = 12;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'application_request_files';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [[
                'i1',  'i2',  'i3',  'i4',  'i5',  'i6',  'i7',
                'i8',  'i9',  'i10', 'i11', 'i12', 'i13', 'i14',
                'i15', 'i16', 'i17', 'i18', 'i19', 'i20', 'i21',
                'i22', 'i23', 'i24', 'i25', 'i26', 'i27', 'i28',
            ], 'integer'],
            [['application_id', 'user_id', 'app_status'], 'integer'],
            [['request', 'remarks', 'ref_code'], 'string'],
            // [['check_files'], 'checkFiles', 'skipOnEmpty' => false, 'skipOnError' => false],
            [['check_files'], 'checkFiles', 'skipOnEmpty' => false],
            [['created_at', 'updated_at'], 'safe'],
        ];
    }

    public function checkFiles($attribute) {
        $chosed = [];
        for ($i = 1;$i < 29;$i++) {
            $field = 'i'.$i;
            if ($this->$field > 0) {
                $chosed[] = $this->$field;
            }
        }

        if (count($chosed) == 0) {
            $this->addError($attribute,'請選擇至少一項要求上載文件');
        }
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
            'request' => '要求上載文件內容',
            'remarks' => '給申請者的訊息',
            'ref_code' => '參考編號',
            'app_status' => '申請者狀態',
            'created_at' => '要求上載文件時間',

            'appl_no' => '申請編號',
            'application_chi_name' => '申請人姓名(中文)',
            'application_eng_name' => '申請人姓名(英文)',
            'application_no' => '申請編號',
            'application_created_at' => '評審日期',
            'application_priority_1' => '入住計劃(第一優先選擇)',
            'application_priority_2' => '入住計劃(第二優先選擇)',
            'application_priority_3' => '入住計劃(第三優先選擇)',
            'application_family_member' => '申請入住人數',

            'chi_name' => '姓名(中文)',
            'eng_name' => '姓名(英文)',
            'mobile' => '流動電話號碼',
        ];
    }

    public function submit()
    {
        $chosed = [];
        for ($i = 1;$i < 29;$i++) {
            $field = 'i'.$i;
            if ($this->$field > 0) {
                $chosed[] = $this->$field;
            }
        }

        $this->request = json_encode($chosed);

        if ($this->save(false)) {
            $no_of_zero = self::RESQ_LENGTH - strlen($this->id);
            $this->ref_code = str_pad(self::RESQ_PREFIX, $no_of_zero, '0').$this->id;

            $this->save(false);
        }

        return true;
    }

    public function getApplication()
    {
        return $this->hasOne(Application::className(), ['id' => 'application_id']);
    }

    public function getApplicationResponseFiles()
    {
        return $this->hasOne(ApplicationResponseFiles::className(), ['request_id' => 'id']);
    }

}
