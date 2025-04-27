<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\PageType3;

class PageType3Search extends PageType3
{
    public $year;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['display_at'], 'safe'],
            [['year'], 'safe'],
        ];
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
        $query = PageType3::find()->andWhere(['MID' => $this->MID, 'status' => 1]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['display_at' => SORT_DESC]],
            'pagination' => [
                'pageSize' => 12,
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere(['=', new yii\db\Expression('YEAR(display_at)'), $this->year]);

        // grid filtering conditions
        $query->andFilterWhere([
            'display_at' => $this->display_at
        ]);

        return $dataProvider;
    }
}
