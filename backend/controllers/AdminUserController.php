<?php

namespace backend\controllers;

use Yii;
use common\models\AdminUser;
use common\models\Definitions;
use backend\models\AdminUserForm;
use backend\models\AdminUserSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\grid\EditableColumnAction;

/**
 * AdminUserController implements the CRUD actions for AdminUser model.
 */
class AdminUserController extends Controller
{

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
                      'roles' => ['admin.user'],
                  ],
                  [
                    'actions' => ['profileview', 'profileupdate', 'select2-search'],
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
     * Lists all AdminUser models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AdminUserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Creates a new AdminUser model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new AdminUserForm();
        $model->scenario = AdminUser::SCENARIO_CREATE;
        $model->status = AdminUser::STATUS_ACTIVE;
        $model->role = AdminUser::ROLE_USER;

        if ($model->load(Yii::$app->request->post()) && $model->submit()) {
            Yii::$app->adminLog->insert(Yii::t('log', 'Add {record} to {model}', ['record' => $model->nameWithEmail.('[#'.$model->id.']'), 'model' => Yii::t('app', 'Admin User')]));

            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('edit', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing AdminUser model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModelForm($id);

        if ($model->load(Yii::$app->request->post()) && $model->submit()) {
            Yii::$app->adminLog->insert(Yii::t('log', 'Update {record} of {model}', ['record' => $model->nameWithEmail.('[#'.$model->id.']'), 'model' => Yii::t('app', 'Admin User')]));

            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('edit', [
                'model' => $model,
            ]);
        }
    }

    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionProfileview()
    {
        return $this->render('profile_view', [
            'model' => $this->findModel(Yii::$app->user->id),
        ]);
    }

    public function actionProfileupdate()
    {
        $model = \backend\models\AdminUserMyForm::FindOne(Yii::$app->user->id);
        if ($model->load(Yii::$app->request->post()) && $model->submit()) {
            return $this->redirect(['profileview']);
        } else {
            return $this->render('profile_update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing AdminUser model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->status = 0;
        $model->save();

        Yii::$app->adminLog->insert(Yii::t('log', 'Delete {record} of {model}', ['record' => $model->nameWithEmail.('[#'.$model->id.']'), 'model' => Yii::t('app', 'Admin User')]));

        return $this->redirect(['index']);
    }

    public function actionSelect2Search($q = null, $id = null)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $result = ['results' => ['id' => '', 'text' => '']];
        if (!is_null($q)) {
            $model = AdminUser::find()
                            ->orWhere(['like', 'name', $q])
                            ->orWhere(['like', 'email', $q])
                            ->andWhere(['!=', 'status', AdminUser::STATUS_DELETED])
                            ->andWhere(['>=', 'role', Yii::$app->user->identity->role])
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
            $result['results'] = ['id' => $id, 'text' => Html::encode(AdminUser::findOne($id)->nameWithEmail)];
        }
        return $result;
    }

    /**
     * Finds the AdminUser model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return AdminUser the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AdminUser::findOne($id)) !== null) {
            if ($model->role < Yii::$app->user->identity->role)
                throw new \yii\web\ForbiddenHttpException(Yii::t('yii', 'You are not allowed to perform this action.'));

            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function findModelForm($id)
    {
        if (($model = AdminUserForm::findOne($id)) !== null) {
            if ($model->role < Yii::$app->user->identity->role)
                throw new \yii\web\ForbiddenHttpException(Yii::t('yii', 'You are not allowed to perform this action.'));

            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
