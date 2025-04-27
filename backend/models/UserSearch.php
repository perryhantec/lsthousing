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
class UserSearch extends User
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['role', 'status', 'user_appl_status'], 'integer'],
            [['chi_name', 'eng_name', 'app_no', 'mobile'], 'safe'],
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
    public function search($params, $action = false)
    {
        $query = User::find()->andWhere(['>=', 'role', Yii::$app->user->identity->role]);

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
            'role' => $this->role,
            'status' => $this->status,
            'user_appl_status' => $this->user_appl_status,
        ]);

        $query->andFilterWhere(['like', 'chi_name', $this->chi_name])
            ->andFilterWhere(['like', 'eng_name', $this->eng_name])
            ->andFilterWhere(['like', 'app_no', $this->app_no])
            ->andFilterWhere(['like', 'mobile', $this->mobile]);

        return $dataProvider;
    }
}
