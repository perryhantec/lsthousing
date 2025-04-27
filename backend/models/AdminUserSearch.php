<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\AdminUser;

/**
 * AdminUserSearch represents the model behind the search form about `common\models\AdminUser`.
 */
class AdminUserSearch extends AdminUser
{
    public $adminGroup_id;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['adminGroup_id', 'role', 'status'], 'integer'],
            [['name', 'email', 'username'], 'safe'],
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
        $query = AdminUser::find()->andWhere(['>=', 'role', Yii::$app->user->identity->role]);

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

        if ($this->adminGroup_id != null) {
            $query->joinWith('adminGroups')
                  ->andWhere(['admin_group.id' => $this->adminGroup_id]);
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'role' => $this->role,
            'status' => $this->status
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'username', $this->username]);

        return $dataProvider;
    }
}
