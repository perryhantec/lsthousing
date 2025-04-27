<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\ApplicationMark;
use common\models\Definitions;
use yii\helpers\ArrayHelper;
use yii\db\Expression;

/**
 * UserSearch represents the model behind the search form about `common\models\User`.
 */
class ApplicationMarkSearch extends ApplicationMark
{
    public $date;
    public $date2;
    public $chi_name;
    public $eng_name;
    public $appl_no;
    // public $mobile;
    // public $application_status;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // [['application_id', 'application_status', 'mark'], 'integer'],
            [['application_id', 'total'], 'integer'],
            // [['chi_name', 'eng_name', 'appl_no', 'mobile'], 'safe'],
            [['chi_name', 'eng_name', 'appl_no'], 'safe'],
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
        $query = ApplicationMark::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['date2' => SORT_DESC, 'date' => SORT_DESC]],
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
        $dataProvider->sort->attributes['appl_no'] = [
            'asc' => ['application.appl_no' => SORT_ASC],
            'desc' => ['application.appl_no' => SORT_DESC],
            'default' => SORT_DESC,
            // 'label' => Yii::t('app', 'Updated At'),
        ];
        $dataProvider->sort->attributes['chi_name'] = [
            'asc' => ['application.chi_name' => SORT_ASC],
            'desc' => ['application.chi_name' => SORT_DESC],
            'default' => SORT_DESC,
            // 'label' => Yii::t('app', 'Updated At'),
        ];
        $dataProvider->sort->attributes['eng_name'] = [
            'asc' => ['application.eng_name' => SORT_ASC],
            'desc' => ['application.eng_name' => SORT_DESC],
            'default' => SORT_DESC,
            // 'label' => Yii::t('app', 'Updated At'),
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
            // 'role' => $this->role,
            // 'application_status' => $this->application_status,
            'application_id' => $this->application_id,
            'total' => $this->total
        ]);

        $query->andFilterWhere(['=', new Expression('DATE(created_at)'), $this->date]);
        $query->andFilterWhere(['=', new Expression('DATE(updated_at)'), $this->date2]);

        $query->andFilterWhere(['like', 'chi_name', $this->chi_name])
            ->andFilterWhere(['like', 'eng_name', $this->eng_name])
            ->andFilterWhere(['like', 'appl_no', $this->appl_no]);
            // ->andFilterWhere(['like', 'mobile', $this->mobile]);

        return $dataProvider;
    }
}
