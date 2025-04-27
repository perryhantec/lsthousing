<?php

namespace backend\controllers;

use Yii;
use common\models\Application;
use common\models\ApplicationRequestFiles;
use common\models\Definitions;
use backend\models\ApplicationRequestFilesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\grid\EditableColumnAction;

class ApplicationRequestFilesController extends Controller
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
    public function actions()
    {
        return ArrayHelper::merge(parent::actions(), []);
    }


    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex($id = false)
    {
        $searchModel = new ApplicationRequestFilesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $id);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'aid' => $id,
        ]);
    }

    public function actionCreate($aid, $alert = '')
    {
        $model = new ApplicationRequestFiles();

        // if ($model->load(Yii::$app->request->post()) && $model->save()) {
        // if ($model->load(Yii::$app->request->post()) && $model->submit()) {
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->submit();

            if (
                $model->application->application_status == Application::APPL_STATUS_UPLOAD_FILES_AGAIN && 
                isset($model->application->applicationResponseFiles) &&
                count($model->application->applicationResponseFiles) > 0
            ) {
                $model->application->sendSubmittedEmail(5, $model->request);
                $request_text = '要求再次提交文件';
            } else {
                $model->application->sendSubmittedEmail(2);
                $request_text = '要求上載文件';
            }

            Yii::$app->adminLog->insert(Yii::t('log', 'Add {record} to {model}', ['record' => $model->application->appl_no.('[#'.$model->id.']'), 'model' => $request_text]));

            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('edit', [
                'model' => $model,
                'aid' => $aid,
                'alert' => $alert,
            ]);
        }
    }

    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    protected function findModel($id)
    {
        if (($model = ApplicationRequestFiles::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
