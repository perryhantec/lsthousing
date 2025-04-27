<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Application;
use yii\helpers\ArrayHelper;
use yii\db\Expression;

/**
 * UserSearch represents the model behind the search form about `common\models\User`.
 */
class ApplicationSearch extends Application
{
    public $date;
    // public $date2;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['application_status', 'family_member', 'priority_1', 'priority_2', 'priority_3'], 'integer'],
            [['chi_name', 'eng_name', 'appl_no', 'mobile'], 'safe'],
            // [['date', 'date2'], 'safe'],
            [['date'], 'safe'],
        ];
    }

    public function attributeLabels()
    {
        return ArrayHelper::merge(
            parent::attributeLabels(),
            [
                'date' => Yii::t('app', 'Created At'),
                // 'date2' => Yii::t('app', 'Updated At'),
            ]
        );
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params, $action = false)
    {
        // $query = Application::find()->where(['application_status' => Application::APPL_STATUS_SUBMITED_FORM]);
        if (!$action) {
            $query = Application::find();
            // $query = Application::find()->where(['application_status' => Application::APPL_STATUS_SUBMITED_FORM]);
        } elseif ($action == 'request' || $action == 'response') {
            $query = Application::find()->where(['>=','application_status', Application::APPL_STATUS_UPLOAD_FILES]);
            // $query = Application::find()->where(['application_status' => Application::APPL_STATUS_UPLOAD_FILES])
            //                             ->orWhere(['application_status' => Application::APPL_STATUS_UPLOAD_FILES_AGAIN]);
        } elseif ($action == 'visit') {
            $query = Application::find()->where(['>=','application_status', Application::APPL_STATUS_FILES_PASSED]);
        }

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['date' => SORT_DESC]],
        ]);
        $dataProvider->sort->attributes['date'] = [
            'asc' => ['created_at' => SORT_ASC],
            'desc' => ['created_at' => SORT_DESC],
            'default' => SORT_DESC,
            'label' => Yii::t('app', 'Date'),
        ];
        // $dataProvider->sort->attributes['date2'] = [
        //     'asc' => ['updated_at' => SORT_ASC],
        //     'desc' => ['updated_at' => SORT_DESC],
        //     'default' => SORT_DESC,
        //     'label' => Yii::t('app', 'Date'),
        // ];
        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            // 'role' => $this->role,
            'family_member' => $this->family_member,
            'application_status' => $this->application_status,
            'priority_1' => $this->priority_1,
            'priority_2' => $this->priority_2,
            'priority_3' => $this->priority_3,
        ]);

        $query->andFilterWhere(['=', new Expression('DATE(created_at)'), $this->date]);
        // $query->andFilterWhere(['=', new Expression('DATE(updated_at)'), $this->updated_at]);

        $chi_name = openssl_encrypt($this->chi_name, Application::CIPHERING_VALUE, Application::ENCRYPTION_KEY, 0, Application::IV);
        $eng_name = openssl_encrypt($this->eng_name, Application::CIPHERING_VALUE, Application::ENCRYPTION_KEY, 0, Application::IV);
        $mobile   = openssl_encrypt($this->mobile, Application::CIPHERING_VALUE, Application::ENCRYPTION_KEY, 0, Application::IV);

        $query->andFilterWhere(['like', 'chi_name', $chi_name])
            ->andFilterWhere(['like', 'eng_name', $eng_name])
            ->andFilterWhere(['like', 'appl_no', $this->appl_no])
            ->andFilterWhere(['like', 'mobile', $mobile]);

        return $dataProvider;
    }
}
