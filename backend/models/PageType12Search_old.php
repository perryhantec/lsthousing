<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\PageType12;

/**
 * PageType4Search represents the model behind the search form about `common\models\PageType4`.
 */
class PageType12Search extends PageType12
{
    public $title = NULL;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // [['id', 'MID', 'category_id', 'status', 'updated_UID'], 'integer'],
            [['id', 'MID', 'district_id', 'avl_no_of_people_min', 'avl_no_of_people_max', 'avl_no_of_application', 'avl_no_of_live_year', 'status', 'updated_UID'], 'integer'],
            [['housing_location', 'housing_rent', 'display_at', 'author', 'title_tw', 'title_cn', 'title_en', 'content', 'created_at', 'updated_at'], 'safe'],
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
        $query = PageType12::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['display_at'=>SORT_DESC,'id'=>SORT_DESC]],
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
            'display_at' => $this->display_at,
            // 'category_id' => $this->category_id,
            'district_id' => $this->district_id,
            'housing_location' => $this->housing_location,
            'housing_rent' => $this->housing_rent,
            'avl_no_of_people_min' => $this->avl_no_of_people_min,
            'avl_no_of_people_max' => $this->avl_no_of_people_max,
            'avl_no_of_application' => $this->avl_no_of_application,
            'avl_no_of_live_year' => $this->avl_no_of_live_year,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'updated_UID' => $this->updated_UID,
        ]);

/*
        $query->andWhere(['or',
                ['like', 'content_tw', "<img"],
                ['like', 'content_tw', "<a"]]);
*/

        $query->andFilterWhere(['like', 'author', $this->author])
            ->andFilterWhere(['like', 'title_tw', $this->title])
            ->andFilterWhere(['like', 'title_cn', $this->title])
            ->andFilterWhere(['like', 'title_en', $this->title])
            ->andFilterWhere(['like', 'content_tw', $this->content])
            ->andFilterWhere(['like', 'content_cn', $this->content])
            ->andFilterWhere(['like', 'content_en', $this->content]);

        return $dataProvider;
    }
}
