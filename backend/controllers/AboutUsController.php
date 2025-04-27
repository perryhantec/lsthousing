<?php

namespace backend\controllers;

use Yii;
use common\models\AboutUs;
use common\models\Definitions;
use backend\models\AboutUsSearch;
use backend\models\AboutUsForm;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\grid\EditableColumnAction;

/**
 * ApplicationController implements the CRUD actions for User model.
 */
class AboutUsController extends Controller
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
                    'actions' => ['index', 'create', 'update', 'view', 'reorder', 'disabled', 'enabled', 'delete'],
                      'allow' => true,
                      'roles' => ['page.about'],
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
        $searchModel = new AboutUsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCreate()
    {
        $model = new AboutUsForm();

        if ($model->load(Yii::$app->request->post())) {
            if ($model->saveContent()) {
                Yii::$app->adminLog->insert(Yii::t('log', 'Add {record} to {model}', ['record' => '關於樂屋 ('.$model->show_year.')', 'model' => '關於樂屋']));

                return $this->redirect(['index']);
            }
        } else {
            return $this->render('edit', [
                'model' => $model,
            ]);
        }
    }

    public function actionUpdate($id)
    {
        $model = $this->findModelForm($id);

        if ($model->load(Yii::$app->request->post()) && $model->saveContent()) {
            Yii::$app->adminLog->insert(Yii::t('log', 'Update {record} of {model}', ['record' => '關於樂屋 ('.$model->show_year.')', 'model' => '關於樂屋']));
            // if ($model->activity_status == AboutUs::ACTIVITY_FAIL) {
            //     $model->sendSubmittedEmail(1);
            // } elseif ($model->activity_status == AboutUs::ACTIVITY_SUCCESS) {
            //     $model->sendSubmittedEmail(2);
            // }

            return $this->redirect(['index']); 
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


    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->delete();

        Yii::$app->adminLog->insert(Yii::t('log', 'Delete {record} of {model}', ['record' => $model->show_year.('[#'.$model->id.']'), 'model' => '關於樂屋']));

        return $this->redirect(['index']);
    }

/*    public function actionSelect2Search($q = null, $id = null)
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

    public function actionEnabled($id)
    {
        $model = $this->findModel($id);

        $model->status = 1;
        $model->save();

        Yii::$app->adminLog->insert(Yii::t('log', 'Enable {record} of {model}', ['record' => $model->show_year.('[#'.$model->id.']'), 'model' => '關於樂屋']));

        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionDisabled($id)
    {
        $model = $this->findModel($id);

        $model->status = 0;
        $model->save();

        Yii::$app->adminLog->insert(Yii::t('log', 'Disable {record} of {model}', ['record' => $model->show_year.('[#'.$model->id.']'), 'model' => '關於樂屋']));

        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionReorder($id=NULL)
    {
    $model = new \backend\models\AboutUsReorder;
    // $model->category_id = $id;
    $model->setContent();

    if ($model->load(Yii::$app->request->post())  && $model->saveContent()) {
        Yii::$app->adminLog->insert(Yii::t('log', 'Update {record} of {model}', ['record' => Yii::t('log', 'Order'), 'model' => '關於樂屋']));

        return $this->redirect(['index']);
    }else{
        return $this->renderAjax('reorder', [
            'model' => $model,
        ]);
    }
    }

    protected function findModel($id)
    {
        if (($model = AboutUs::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function findModelForm($id)
    {
        if (($model = AboutUsForm::findOne($id)) !== null) {
            if (!\backend\components\AccessRule::checkRole(['page.allpages', 'page.'.$model->id]))
                throw new \yii\web\ForbiddenHttpException(Yii::t('yii', 'You are not allowed to perform this action.'));

            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
