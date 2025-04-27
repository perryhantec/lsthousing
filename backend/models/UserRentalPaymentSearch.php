<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\User;
use yii\helpers\ArrayHelper;
use yii\db\Expression;

/**
 * UserSearch represents the model behind the search form about `common\models\User`.
 */
class UserRentalPaymentSearch extends User
{
    public $date;
    public $date2;
    public $chi_name;
    public $eng_name;
    public $appl_no;
    public $project;
    public $room_no;
    public $mobile;
    public $application_status;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // [['role', 'status', 'user_appl_status'], 'integer'],
            [['application_status'], 'integer'],
            // [['chi_name', 'eng_name', 'app_no', 'mobile'], 'safe'],

            [['appl_no', 'project', 'room_no', 'chi_name', 'eng_name', 'mobile'], 'safe'],
            [['date', 'date2'], 'safe'],
        ];
    }

    public function attributeLabels()
    {
        return ArrayHelper::merge(
            parent::attributeLabels(),
            [
                'date' => Yii::t('app', 'Created At'),
                'date2' => Yii::t('app', 'Updated At'),
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
        $query = User::find()->andWhere(['>=', 'role', Yii::$app->user->identity->role])
                             ->andWhere(['>=','user_appl_status', User::USER_APPL_STATUS_ALLOCATED_UNIT]);

        // add conditions that should always apply here

        // $dataProvider = new ActiveDataProvider([
        //     'query' => $query,
        // ]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['date2' => SORT_DESC, 'date' => SORT_DESC]],
        ]);
        $dataProvider->sort->attributes['date'] = [
            'asc' => ['application.created_at' => SORT_ASC],
            'desc' => ['application.created_at' => SORT_DESC],
            'default' => SORT_DESC,
            'label' => Yii::t('app', 'Date'),
        ];
        $dataProvider->sort->attributes['date2'] = [
            'asc' => ['application.updated_at' => SORT_ASC],
            'desc' => ['application.updated_at' => SORT_DESC],
            'default' => SORT_DESC,
            'label' => Yii::t('app', 'Updated At'),
        ];
        $dataProvider->sort->attributes['appl_no'] = [
            'asc' => ['application.appl_no' => SORT_ASC],
            'desc' => ['application.appl_no' => SORT_DESC],
            'default' => SORT_DESC,
        ];
        $dataProvider->sort->attributes['project'] = [
            'asc' => ['application.project' => SORT_ASC],
            'desc' => ['application.project' => SORT_DESC],
            'default' => SORT_DESC,
        ];
        $dataProvider->sort->attributes['room_no'] = [
            'asc' => ['application.room_no' => SORT_ASC],
            'desc' => ['application.room_no' => SORT_DESC],
            'default' => SORT_DESC,
        ];
        $dataProvider->sort->attributes['chi_name'] = [
            'asc' => ['application.chi_name' => SORT_ASC],
            'desc' => ['application.chi_name' => SORT_DESC],
            'default' => SORT_DESC,
        ];
        $dataProvider->sort->attributes['eng_name'] = [
            'asc' => ['application.eng_name' => SORT_ASC],
            'desc' => ['application.eng_name' => SORT_DESC],
            'default' => SORT_DESC,
        ];
        $dataProvider->sort->attributes['mobile'] = [
            'asc' => ['application.mobile' => SORT_ASC],
            'desc' => ['application.mobile' => SORT_DESC],
            'default' => SORT_DESC,
        ];
        $dataProvider->sort->attributes['application_status'] = [
            'asc' => ['application.application_status' => SORT_ASC],
            'desc' => ['application.application_status' => SORT_DESC],
            'default' => SORT_DESC,
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->joinWith('application', true);
        // grid filtering conditions
        $query->andFilterWhere([
            'application.application_status' => $this->application_status,
        ]);

        $query->andFilterWhere(['like', 'application.chi_name', $this->chi_name])
            ->andFilterWhere(['like', 'application.eng_name', $this->eng_name])
            ->andFilterWhere(['like', 'application.appl_no', $this->appl_no])
            ->andFilterWhere(['like', 'application.project', $this->project])
            ->andFilterWhere(['like', 'application.room_no', $this->room_no])
            ->andFilterWhere(['like', 'application.mobile', $this->mobile]);

        return $dataProvider;
    }
}
