<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "home".
 */
class Home extends \common\components\BaseActiveRecord
{
    const HAVE_TOP_YOUTUBE = true;
    const NUM_OF_YOUTUBE = 4;

    public $top_youtube_id=[];
    public $top_youtube_title=[];
    public $top_youtubes=[];

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'home';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status', 'updated_UID'], 'integer'],
            // [Yii::$app->config->getRequiredLanguageAttributes('content'), 'required'],
            [['content_tw', 'content_cn', 'content_en', 'top_youtube'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['top_youtube_id', 'top_youtube_title'], 'each', 'rule' => ['string']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'content_tw' => Yii::t('app', 'Content').' '.Yii::t('app', '(Traditional Chinese Version)'),
            'content_cn' => Yii::t('app', 'Content').' '.Yii::t('app', '(Simplified Chinese Version)'),
            'content_en' => Yii::t('app', 'Content').' '.Yii::t('app', '(English Version)'),
            'top_youtube' => Yii::t('app', 'YouTube'),
            'status' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'updated_UID' => Yii::t('app', 'Updated  Uid'),
        ];
    }

    public function afterFind() {
        parent::afterFind();

        if (!empty($this->top_youtube)) {
            $this->top_youtubes = json_decode($this->top_youtube, true);

            foreach ($this->top_youtubes as $num => $data) {
                $this->top_youtube_id[$num] = $data['id'];
                $this->top_youtube_title[$num] = $data['title'];
            }
        }
    }
    
    public function saveContent()
    {
        if ($this->validate()) {
            $_top_youtube = [];
            for ($num=0; $num<self::NUM_OF_YOUTUBE; $num++) {
                if (isset($this->top_youtube_id[$num]) && $this->top_youtube_id[$num] != "" && isset($this->top_youtube_title[$num]) && $this->top_youtube_title[$num] != "")
                    $_top_youtube[$num] = [
                            'id' => $this->top_youtube_id[$num],
                            'title' => $this->top_youtube_title[$num]
                        ];
            }
            $this->top_youtube = json_encode($_top_youtube, JSON_UNESCAPED_UNICODE);

            $this->save();
            
            return true;
        } else {
            return false;
        }
    }
    
    public function getContent(){
        if (Yii::$app->language == 'en' && !empty($this->content_en)){
            return $this->content_en;
        } else if (Yii::$app->language == 'zh-CN' && !empty($this->content_cn)){
            return $this->content_cn;
        }
        return $this->content_tw;
    }
}
