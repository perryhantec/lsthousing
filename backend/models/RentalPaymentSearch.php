<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\RentalPayment;
use common\models\Definitions;
use yii\helpers\ArrayHelper;
use yii\db\Expression;

/**
 * UserSearch represents the model behind the search form about `common\models\User`.
 */
class RentalPaymentSearch extends RentalPayment
{
    public $date;
    public $date2;
    public $user_appl_status;
    public $chi_name;
    public $mobile;
    // public $chi_name;
    public $eng_name;
    public $appl_no;
    public $project;
    public $room_no;
    // public $app_status;
    // public $ref_code;
    // public $mobile;
    // public $application_status;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // [['application_id', 'application_status', 'mark'], 'integer'],
            // [['application_id', 'total'], 'integer'],
            [['user_id', 'user_appl_status', 'payment_year', 'payment_month'], 'integer'],
            // [['chi_name', 'eng_name', 'appl_no', 'mobile'], 'safe'],
            // [['chi_name', 'eng_name', 'appl_no'], 'safe'],
            [['chi_name', 'eng_name', 'mobile', 'appl_no', 'project', 'room_no'], 'safe'],
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
    public function search($params, $id = false)
    {
        if (!$id) {
            // $query = ApplicationRequestFiles::find();
            $query = RentalPayment::find()->where(['is_read' => RentalPayment::IS_READ_NO]);
        } else {
            $query = RentalPayment::find()->where(['rental_payment.user_id' => $id]);
            // $query = ApplicationRequestFiles::find();
        }

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['date2' => SORT_DESC, 'date' => SORT_DESC]],
        ]);
        $dataProvider->sort->attributes['date'] = [
            'asc' => ['rental_payment.created_at' => SORT_ASC],
            'desc' => ['rental_payment.created_at' => SORT_DESC],
            'default' => SORT_DESC,
            'label' => Yii::t('app', 'Date'),
        ];
        $dataProvider->sort->attributes['date2'] = [
            'asc' => ['rental_payment.updated_at' => SORT_ASC],
            'desc' => ['rental_payment.updated_at' => SORT_DESC],
            'default' => SORT_DESC,
            'label' => Yii::t('app', 'Updated At'),
        ];
        $dataProvider->sort->attributes['appl_no'] = [
            'asc' => ['application.appl_no' => SORT_ASC],
            'desc' => ['application.appl_no' => SORT_DESC],
            'default' => SORT_DESC,
        ];
        $dataProvider->sort->attributes['project'] = [
            'asc' => ['application.project' => SORT_ASC],
            'desc' => ['application.project' => SORT_DESC],
            'default' => SORT_DESC,
        ];
        $dataProvider->sort->attributes['room_no'] = [
            'asc' => ['application.room_no' => SORT_ASC],
            'desc' => ['application.room_no' => SORT_DESC],
            'default' => SORT_DESC,
        ];
        $dataProvider->sort->attributes['chi_name'] = [
            'asc' => ['application.chi_name' => SORT_ASC],
            'desc' => ['application.chi_name' => SORT_DESC],
            'default' => SORT_DESC,
        ];
        $dataProvider->sort->attributes['eng_name'] = [
            'asc' => ['application.eng_name' => SORT_ASC],
            'desc' => ['application.eng_name' => SORT_DESC],
            'default' => SORT_DESC,
        ];
        $dataProvider->sort->attributes['mobile'] = [
            'asc' => ['application.mobile' => SORT_ASC],
            'desc' => ['application.mobile' => SORT_DESC],
            'default' => SORT_DESC,
        ];
        $dataProvider->sort->attributes['user_appl_status'] = [
            'asc' => ['user.user_appl_status' => SORT_ASC],
            'desc' => ['user.user_appl_status' => SORT_DESC],
            'default' => SORT_DESC,
            // 'label' => Yii::t('app', 'Updated At'),
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // $query->rightJoin('application', true)->where(['application_status' => Application::APPL_STATUS_UPLOAD_FILES]);
        // $query->joinWith('user', true);
        // $query->joinWith('applicationRequestFiles', true);
        // $query->joinWith('application')->where(['user.application_id' => 'application.id']); 

        $query->joinWith([
            'user' => function ($query) {
                $query->joinWith(['application']);
            },
        ]);
        // grid filtering conditions
        $query->andFilterWhere([
            // 'role' => $this->role,
            'user.user_appl_status' => $this->user_appl_status,
            'payment_year' => $this->payment_year,
            'payment_month' => $this->payment_month,
            // 'is_read' => $this->is_read,
            // 'application_id' => $this->application_id,
            // 'total' => $this->total
        ]);

        $query->andFilterWhere(['=', new Expression('DATE(rental_payment.created_at)'), $this->date]);
        $query->andFilterWhere(['=', new Expression('DATE(rental_payment.updated_at)'), $this->date2]);

        // $query->andFilterWhere(['like', 'chi_name', $this->chi_name])
        //     ->andFilterWhere(['like', 'eng_name', $this->eng_name])
        $query->andFilterWhere(['like', 'application.appl_no', $this->appl_no]);
        $query->andFilterWhere(['like', 'application.project', $this->project]);
        $query->andFilterWhere(['like', 'application.room_no', $this->room_no]);
        $query->andFilterWhere(['like', 'application.chi_name', $this->chi_name]);
        $query->andFilterWhere(['like', 'application.eng_name', $this->eng_name]);
        $query->andFilterWhere(['like', 'application.mobile', $this->mobile]);
        // $query->andFilterWhere(['like', 'payment_date', $this->payment_date]);
            // ->andFilterWhere(['like', 'mobile', $this->mobile]);

        return $dataProvider;
    }
}
