<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\helpers\ArrayHelper;
use yii\data\ActiveDataProvider;
use common\models\AdminUser;
use common\models\AdminLog;

/**
 * AdminLogSearch represents the model behind the search form about `common\models\AdminLog`.
 */
class AdminLogSearch extends AdminLog
{
    public $date;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['menu_id', 'admin_user_id'], 'integer'],
            [['message', 'ip'], 'safe'],
            [['date'], 'safe'],
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
        $adminUser_ids = ArrayHelper::getColumn(AdminUser::find()->where(['>=', 'role', Yii::$app->user->identity->role])->all(), 'id');

        $query = AdminLog::find()->where(['admin_user_id' => $adminUser_ids]);

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

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'menu_id' => $this->menu_id,
            'admin_user_id' => $this->admin_user_id
        ]);

        $query->andFilterWhere(['=', new yii\db\Expression('DATE(created_at)'), $this->date]);
        $query->andFilterWhere(['like', 'message', $this->message])
              ->andFilterWhere(['like', 'ip', $this->ip]);

        return $dataProvider;
    }
}
