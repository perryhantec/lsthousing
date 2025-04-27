<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\AboutUs;
use yii\helpers\ArrayHelper;
use yii\db\Expression;

/**
 * UserSearch represents the model behind the search form about `common\models\User`.
 */
class AboutUsSearch extends AboutUs
{
    public $date;
    public $date2;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['show_year', 'seq', 'status'], 'integer'],
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
    public function search($params)
    {
        // $query = Application::find()->where(['application_status' => Application::APPL_STATUS_SUBMITED_FORM]);
        $query = AboutUs::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['seq' => SORT_ASC,'date2' => SORT_DESC,'date' => SORT_DESC]],
        ]);
        $dataProvider->sort->attributes['date'] = [
            'asc' => ['created_at' => SORT_ASC],
            'desc' => ['created_at' => SORT_DESC],
            'default' => SORT_DESC,
            'label' => Yii::t('app', 'Date'),
        ];
        $dataProvider->sort->attributes['date2'] = [
            'asc' => ['updated_at' => SORT_ASC],
            'desc' => ['updated_at' => SORT_DESC],
            'default' => SORT_DESC,
            'label' => Yii::t('app', 'Updated At'),
        ];
        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            // 'role' => $this->role,
            'seq' => $this->seq,
            'show_year' => $this->show_year,
            'status' => $this->status
        ]);

        $query->andFilterWhere(['=', new Expression('DATE(created_at)'), $this->date]);

        // $query->andFilterWhere(['like', 'show_year', $this->show_year]);
        //     ->andFilterWhere(['like', 'name', $this->name])
        //     ->andFilterWhere(['like', 'mobile', $this->mobile]);

        return $dataProvider;
    }
}
