<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\PageType4Category;

/**
 * PageType4CategorySearch represents the model behind the search form about `common\models\PageType4Category`.
 */
class PageType4CategorySearch extends PageType4Category
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'MID', 'category_id', 'status', 'updated_UID'], 'integer'],
            [['name_cn', 'name_en', 'created_at', 'updated_at'], 'safe'],
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
        $query = PageType4Category::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'MID' => $this->MID,
            'category_id' => $this->category_id,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'updated_UID' => $this->updated_UID,
        ]);

        $query->andFilterWhere(['like', 'name_cn', $this->name_cn])
            ->andFilterWhere(['like', 'name_en', $this->name_en]);

        return $dataProvider;
    }
}
