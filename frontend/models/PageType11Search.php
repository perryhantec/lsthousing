<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\PageType11;

class PageType11Search extends PageType11
{
    public $year;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [[], 'integer'],
            [['display_at'], 'safe'],
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
        $query = PageType11::find()->andWhere(['MID' => $this->MID, 'status' => 1]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['display_at' => SORT_DESC, 'id'=>SORT_DESC]],
            'pagination' => [
                'pageSize' => 10,
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
/*
        $query->andFilterWhere([
            'id' => $this->id,
            'MID' => $this->MID,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'updated_UID' => $this->updated_UID,
        ]);
*/

//         $query->andWhere(['<=', 'display_at', date('Y-m-d')]);

        return $dataProvider;
    }
}
