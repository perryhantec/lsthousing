<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use common\models\Menu;

/**
 * MenuCreationDataProvider represents the model behind the search form about `backend\models\MenuCreation`.
 */
class MenuSearch extends Menu
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
      return [
          [['id', 'MID', 'seq', 'page_type', 'display_home', 'status', 'updated_UID'], 'integer'],
          [['name_tw', 'name_cn', 'name_en', 'created_at', 'updated_at'], 'safe'],
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
        $query = Menu::find();

        $_canEditMenusId = Yii::$app->user->identity->getCanEditMenusId();
        if ($_canEditMenusId != null)
            $query->andWhere(['id' => $_canEditMenusId]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['MID'=>SORT_ASC,'seq'=>SORT_ASC]]
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
            'seq' => $this->seq,
            'page_type' => $this->page_type,
            'display_home' => $this->display_home,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'updated_UID' => $this->updated_UID,
        ]);

        $query->andFilterWhere(['like', 'name_tw', $this->name_tw])
            ->andFilterWhere(['like', 'name_cn', $this->name_cn])
            ->andFilterWhere(['like', 'name_en', $this->name_en]);

        return $dataProvider;
    }
}
