<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\ApplicationResponseFiles;
use common\models\Definitions;
use yii\helpers\ArrayHelper;
use yii\db\Expression;

/**
 * UserSearch represents the model behind the search form about `common\models\User`.
 */
class ApplicationResponseFilesSearch extends ApplicationResponseFiles
{
    public $date;
    public $date2;
    // public $chi_name;
    // public $eng_name;
    public $appl_no;
    public $app_status;
    public $ref_code;

    public $chi_name;
    public $eng_name;
    public $mobile;
    public $family_member;
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
            [['application_id', 'app_status', 'family_member'], 'integer'],
            // [['chi_name', 'eng_name', 'appl_no', 'mobile'], 'safe'],
            // [['chi_name', 'eng_name', 'appl_no'], 'safe'],
            [['appl_no', 'ref_code', 'chi_name', 'eng_name', 'mobile'], 'safe'],
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
            $query = ApplicationResponseFiles::find();
            // $query = Application::find()->where(['application_status' => Application::APPL_STATUS_UPLOAD_FILES]);
        } else {
            $query = ApplicationResponseFiles::find()->where(['application_response_files.application_id' => $id]);
            // $query = ApplicationRequestFiles::find();
        }

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['date2' => SORT_DESC, 'date' => SORT_DESC]],
        ]);
        $dataProvider->sort->attributes['date'] = [
            'asc' => ['application_response_files.created_at' => SORT_ASC],
            'desc' => ['application_response_files.created_at' => SORT_DESC],
            'default' => SORT_DESC,
            'label' => Yii::t('app', 'Date'),
        ];
        $dataProvider->sort->attributes['date2'] = [
            'asc' => ['application_response_files.updated_at' => SORT_ASC],
            'desc' => ['application_response_files.updated_at' => SORT_DESC],
            'default' => SORT_DESC,
            'label' => Yii::t('app', 'Updated At'),
        ];
        $dataProvider->sort->attributes['appl_no'] = [
            'asc' => ['application.appl_no' => SORT_ASC],
            'desc' => ['application.appl_no' => SORT_DESC],
            'default' => SORT_DESC,
            // 'label' => Yii::t('app', 'Updated At'),
        ];
        $dataProvider->sort->attributes['family_member'] = [
            'asc' => ['application.family_member' => SORT_ASC],
            'desc' => ['application.family_member' => SORT_DESC],
            'default' => SORT_DESC,
        ];
        $dataProvider->sort->attributes['ref_code'] = [
            'asc' => ['application_request_files.ref_code' => SORT_ASC],
            'desc' => ['application_request_files.ref_code' => SORT_DESC],
            'default' => SORT_DESC,
            // 'label' => Yii::t('app', 'Updated At'),
        ];
        $dataProvider->sort->attributes['app_status'] = [
            'asc' => ['application_request_files.app_status' => SORT_ASC],
            'desc' => ['application_request_files.app_status' => SORT_DESC],
            'default' => SORT_DESC,
            // 'label' => Yii::t('app', 'Updated At'),
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

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // $query->rightJoin('application', true)->where(['application_status' => Application::APPL_STATUS_UPLOAD_FILES]);
        $query->joinWith('application', true);
        $query->joinWith('applicationRequestFiles', true);
        // grid filtering conditions
        $query->andFilterWhere([
            // 'role' => $this->role,
            'application.family_member' => $this->family_member,
            'application_request_files.app_status' => $this->app_status,
            // 'application_id' => $this->application_id,
            // 'total' => $this->total
        ]);

        $query->andFilterWhere(['=', new Expression('DATE(application_response_files.created_at)'), $this->date]);
        $query->andFilterWhere(['=', new Expression('DATE(application_response_files.updated_at)'), $this->date2]);

        $query->andFilterWhere(['like', 'application.chi_name', $this->chi_name]);
        $query->andFilterWhere(['like', 'application.eng_name', $this->eng_name]);
        $query->andFilterWhere(['like', 'application.mobile', $this->mobile]);
        $query->andFilterWhere(['like', 'application.appl_no', $this->appl_no]);
        $query->andFilterWhere(['like', 'application_request_files.ref_code', $this->ref_code]);

        return $dataProvider;
    }
}
