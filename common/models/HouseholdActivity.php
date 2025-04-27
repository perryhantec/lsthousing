<?php

namespace common\models;

use Yii;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * This is the model class for table "household_activity".
 *
 * @property int $id
 * @property string|null $title
 * @property string|null $date
 * @property string|null $time
 * @property string|null $location
 * @property string|null $close_date
 * @property string|null $name
 * @property string|null $mobile
 * @property int|null $no_of_ppl
 * @property string|null $remarks
 * @property int|null $activity_status
 * @property string|null $created_at
 * @property string $updated_at
 */
class HouseholdActivity extends \yii\db\ActiveRecord
{
    // public $username;

    const ACTIVITY_PENDING = 1;
    const ACTIVITY_FAIL    = 2;
    const ACTIVITY_SUCCESS = 3;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'household_activity';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'no_of_ppl', 'activity_status'], 'integer'],
            [['remarks'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['title', 'date', 'time', 'location', 'close_date', 'name', 'mobile'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => '活動名稱',
            'date' => '日期',
            'time' => '時間',
            'location' => '地點',
            'close_date' => '報名截止日期',
            'name' => '參加者姓名',
            'mobile' => '參加者聯絡電話',
            'no_of_ppl' => '參加者人數',
            'remarks' => '備註',
            'activity_status' => '活動狀態',
            'created_at' => '新增日期',
            'updated_at' => 'Updated At',

            'user_chi_name' => '用戶姓名(中文)',
            'user_eng_name' => '用戶姓名(英文)',
            'user_mobile' => '用戶流動電話號碼',
            'user_email' => '用戶電郵地址',
        ];
    }

    public function sendSubmittedEmail($type = '', $requests = [])
    {
        // return;

        if (!$type) {
            return;
        }

        $this->refresh();
        
        if ($type === 1) {
            $title = '收到住戶活動申請';
            $email_content = '本堂已收到  閣下住戶活動之申請，初步預審後，閣下之申請未能符合基本資格，恕未能作進一步處理。';    
            $sms_content   = '本堂已收到  閣下住戶活動之申請，初步預審後，閣下之申請未能符合基本資格，恕未能作進一步處理。';    
        } elseif ($type === 2) {
            $title = '收到住戶活動申請';
            $email_content = '本堂已收到  閣下住戶活動之申請，初步預審後，閣下之申請符合基本資格，本堂職員將聯絡  閣下作進一步跟進。';    
            $sms_content   = '本堂已收到  閣下住戶活動之申請，初步預審後，閣下之申請符合基本資格，本堂職員將聯絡  閣下作進一步跟進。';    
        }
// send email
        if ($this->user->email || $this->email) {
            $email = $this->user->email ?: $this->email;

            Yii::$app->mailer->compose()
            ->setTo($email)
            ->setFrom(Yii::$app->params['supportEmail'])
            ->setSubject($title)
            ->setHtmlBody($email_content)
            ->send();
        }
// send sms

        $client = new Client([
            'base_uri' => Yii::$app->params['easySmsApiPath'],
        //                 'timeout'  => 2.0,
        ]);

        $ha_sms_model = new HouseholdActivitySms();
        $ha_sms_model->activity_id = $this->id;
        $ha_sms_model->user_id = $this->user_id;
        $ha_sms_model->sent_at = date('Y-m-d H:i:s');
        $ha_sms_model->status = $this->activity_status;

        try {
            // $_address = $this->address;
            // if (substr($_address, 0, 3) == "852")
            //     $_address = substr($_address, 3);
            $_mobile = '852-'.$this->user->mobile;

            $_request_url = Yii::$app->params['easySmsApiPath'].'api/send/'.Yii::$app->params['easySmsUsername'].'/'.md5(Yii::$app->params['easySmsPassword']).'/'.$_mobile.'/'.(urlencode(mb_convert_encoding($sms_content, 'UTF-8')));

            if (YII_ENV_DEV)
                var_dump($_request_url);

            $response = $client->request('GET', $_request_url, [
            ]);

            $xml = simplexml_load_string($response->getBody(), "SimpleXMLElement", LIBXML_NOCDATA);
            $json = json_encode($xml);
            $result = json_decode($json,TRUE);

            if (YII_ENV_DEV)
                var_dump($result);

            if (isset($result['record']) && isset($result['record']['id']) && isset($result['record']['status'])) {
                $ha_sms_model->sent_response = null;
                $ha_sms_model->sent_reference = $result['record']['id'];
                $ha_sms_model->save(false);
                if ($result['record']['status'] == "failed") {
                    return false;
                } else if ($result['record']['status'] == "sent") {
                    return true;
                } else {
                    return null;
                }
            } else if (isset($result['code']) | isset($result['description'])) {
                $ha_sms_model->sent_response = trim((isset($result['description']) ? $result['description'] : '').(isset($result['code']) ? (' #'.$result['code']) : ''));
                $ha_sms_model->save(false);

                return false;
            }

            return false;

        } catch (\GuzzleHttp\Exception\GuzzleException $e) {
            if (YII_ENV_DEV) {
                echo Psr7\Message::toString($e->getRequest());
                echo Psr7\Message::toString($e->getResponse());
            }
            $ha_sms_model->sent_response = Psr7\Message::toString($e->getResponse());
            $ha_sms_model->save(false);

            return false;

        } catch (\yii\base\InvalidArgumentException $e) {
            return false;

        }
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
