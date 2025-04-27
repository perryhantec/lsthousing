<?php

namespace backend\controllers;

use Yii;
use common\models\ApplicationMark;
use common\models\Definitions;
use backend\models\ApplicationMarkSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\grid\EditableColumnAction;

/**
 * ApplicationController implements the CRUD actions for User model.
 */
class ApplicationMarkController extends Controller
{
  public $enableCsrfValidation = false;

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
            'access' => [
              'class' => \yii\filters\AccessControl::className(),
              'ruleConfig' => [
			            'class' => \backend\components\AccessRule::className(),
			        ],
              'rules' => [
                  [
                    'actions' => ['index', 'create', 'update', 'view'],
                      'allow' => true,
                      'roles' => ['user'],
                  ],
                  [
                    'actions' => ['select2-search'],
                      'allow' => true,
                      'roles' => ['@'],
                  ],
              ],
            ],

        ];
    }
    //editable config
    public function actions()
    {
        return ArrayHelper::merge(parent::actions(), []);
    }


    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ApplicationMarkSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

/*
    public function actionCreate()
    {
        $model = new User();
        $model->scenario = User::SCENARIO_CREATE;
        $model->status = User::STATUS_ACTIVE;
        $model->role = User::ROLE_MEMBER;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->adminLog->insert(Yii::t('log', 'Add {record} to {model}', ['record' => $model->nameWithEmail.('[#'.$model->id.']'), 'model' => Yii::t('app', 'User')]));

            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('edit', [
                'model' => $model,
            ]);
        }
    }
*/
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->adminLog->insert(Yii::t('log', 'Update {record} of {model}', ['record' => $model->application->appl_no.('[#'.$model->id.']'), 'model' => '評分']));

            return $this->redirect(['index']);
            // return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('edit', [
                'model' => $model,
            ]);
        }
    }
 /*   
    public function actionUpdateAddress($id)
    {
        $model = $this->findModel($id)->address;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->adminLog->insert(Yii::t('log', 'Update {record} of {model}', ['record' => $model->user->nameWithEmail.('[#'.$model->id.']'), 'model' => Yii::t('app', 'Address Information')]));

            return $this->redirect(['view', 'id' => $model->user->id]);
        } else {
            return $this->render('edit-address', [
                'model' => $model,
            ]);
        }
    }
*/
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

/*
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->status = 0;
        $model->save();

        Yii::$app->adminLog->insert(Yii::t('log', 'Delete {record} of {model}', ['record' => $model->nameWithEmail.('[#'.$model->id.']'), 'model' => Yii::t('app', 'User')]));

        return $this->redirect(['index']);
    }

    public function actionSelect2Search($q = null, $id = null)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $result = ['results' => ['id' => '', 'text' => '']];
        if (!is_null($q)) {
            $model = User::find()
                            ->orWhere(['like', 'name', $q])
                            ->orWhere(['like', 'phone', $q])
                            ->orWhere(['like', 'email', $q])
                            ->andWhere(['!=', 'status', User::STATUS_DELETED])
                            ->all();
            $results = [];
            if ($model !== null) {
                foreach ($model as $user) {
                    $results[] = ['id' => $user->id, 'text' => Html::encode($user->nameWithEmail)];
                }
            }
            $result['results'] = $results;
        }
        elseif ($id > 0) {
            $result['results'] = ['id' => $id, 'text' => Html::encode(User::findOne($id)->nameWithEmail)];
        }
        return $result;
    }
*/

    protected function findModel($id)
    {
        if (($model = ApplicationMark::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
