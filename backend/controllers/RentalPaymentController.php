<?php

namespace backend\controllers;

use Yii;
use common\models\Application;
use common\models\RentalPayment;
use common\models\Definitions;
use backend\models\UserRentalPaymentSearch;
use backend\models\RentalPaymentSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\grid\EditableColumnAction;
use backend\models\ApplicationImport;

class RentalPaymentController extends Controller
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
                    'actions' => ['index', 'user-list', 'update', 'view', 'delete'],
                      'allow' => true,
                      'roles' => ['rental'],
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
        $searchModel = new RentalPaymentSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $id);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'uid' => $id,
        ]);
    }

    public function actionUserList()
    {
        $searchModel = new UserRentalPaymentSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $model_application_import = new ApplicationImport;

        if ($model_application_import->load(Yii::$app->request->post()) && $model_application_import->import()) {
          $model_application_import = new ApplicationImport;
        }

        return $this->render('user-list', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model_application_import' => $model_application_import,
        ]);
    }
    
    // public function actionCreate($aid)
    // {
    //     $model = new RentalPayment();

    //     // if ($model->load(Yii::$app->request->post()) && $model->save()) {
    //     // if ($model->load(Yii::$app->request->post()) && $model->submit()) {
    //     if ($model->load(Yii::$app->request->post()) && $model->validate()) {
    //         $model->submit();
    //         // $model->application->sendSubmittedEmail(2);

    //         Yii::$app->adminLog->insert(Yii::t('log', 'Add {record} to {model}', ['record' => $model->application->appl_no.('[#'.$model->id.']'), 'model' => '要求上載文件']));

    //         return $this->redirect(['view', 'id' => $model->id]);
    //     } else {
    //         return $this->render('edit', [
    //             'model' => $model,
    //             'aid' => $aid,
    //         ]);
    //     }
    // }

    // public function actionView($id)
    // {
    //     return $this->render('view', [
    //         'model' => $this->findModel($id),
    //     ]);
    // }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        
        if ($model->is_read == $model::IS_READ_NO) {
            $model->is_read = $model::IS_READ_YES;
            $model->save(false);
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $username = isset($model->user->chi_name) ? $model->user->chi_name : $model->user->eng_name;

            Yii::$app->adminLog->insert(Yii::t('log', 'Update {record} of {model}', ['record' => $username.('[#'.$model->id.']'), 'model' => '住戶交租案']));

            return $this->redirect(['index', 'id' => $model->user_id]); 

        } else {
            return $this->render('edit', [
                'model' => $model,
            ]);
        }
    }

    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->delete();

        $username = isset($model->user->chi_name) ? $model->user->chi_name : $model->user->eng_name;

        Yii::$app->adminLog->insert(Yii::t('log', 'Delete {record} of {model}', ['record' => $username.('[#'.$model->id.']'), 'model' => '住戶交租案']));

        return $this->redirect(['index', 'id' => $model->user_id]);
    }

    protected function findModel($id)
    {
        if (($model = RentalPayment::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
