<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use kartik\grid\EditableColumnAction;
use backend\models\MenuForm;
use backend\models\MenuSearch;
use common\models\Menu;
use common\models\Definitions;
/**
 * MenuController implements the CRUD actions for Menu model.
 */
class MenuController extends Controller
{
  public $enableCsrfValidation = false;

    public function behaviors()
    {
        return [

            'access' => [
              'class' => \yii\filters\AccessControl::className(),
              'ruleConfig' => [
			            'class' => \backend\components\AccessRule::className(),
			        ],
              'rules' => [
                  [
                    'actions' => ['index', 'create', 'update', 'delete', 'selecttype', 'reorder', 'edit_grid'],
                      'allow' => true,
                      'roles' => ['menu'],
                  ],
                  [
                    'actions' => ['home-reorder'],
                      'allow' => true,
                      'roles' => ['page.home'],
                  ],
              ],
            ],
        ];
    }

    //editable config
    public function actions()
    {
        return ArrayHelper::merge(parent::actions(), [
            'edit_grid' => [                                       // identifier for your editable column action
                'class' => EditableColumnAction::className(),     // action class name
                'modelClass' => Menu::className(),                // the model for the record being edited
                'outputValue' => function ($model, $attribute, $key, $index) {
                  switch($attribute){
                    // case 'type':
                    //    return Definitions::getMenuType($model->type);
                    //   break;
                    case 'page_type':
                       return Definitions::getPageType($model->page_type);
                      break;
                    default:
                      return $model->$attribute;
                  }
                },
                'outputMessage' => function($model, $attribute, $key, $index) {
                      return '';                                  // any custom error to return after model save
                },
                'showModelErrors' => true,                        // show model validation errors after save
                'errorOptions' => ['header' => '']                // error summary HTML options
                // 'postOnly' => true,
                // 'ajaxOnly' => true,
                // 'findModel' => function($id, $action) {},
                // 'checkAccess' => function($action, $model) {}
            ],
        ]);
    }

    /**
     * Lists all Menu models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new MenuSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Menu model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $_show_url = false;
        $model = new MenuForm();
        $model->page_type = 1;
        $model->status = 1;
        if ($model->load(Yii::$app->request->post())) {
            if ($model->saveContent()) {
                Yii::$app->adminLog->insert(Yii::t('log', 'Add {record} to {model}', ['record' => $model->name.('[#'.$model->id.']'), 'model' => Yii::t('app', 'Menu')]));

                return $this->redirect(['index']);
            } else
                $_show_url = true;
        }
        return $this->render('edit', [
            'model' => $model,
            '_show_url' => $_show_url
        ]);

    }

    /**
     * Updates an existing Menu model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModelForm($id);

        if ($model->load(Yii::$app->request->post()) && $model->saveContent()) {
            Yii::$app->adminLog->insert(Yii::t('log', 'Update {record} of {model}', ['record' => $model->name.('[#'.$model->id.']'), 'model' => Yii::t('app', 'Menu')]));

            return $this->redirect(['index']);
        }
//         Yii::debug($model->getErrorSummary(true));
        return $this->render('edit', [
            'model' => $model,
            '_show_url' => true
        ]);
    }

    /**
     * Deletes an existing Menu model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
      $model = $this->findModelForm($id);
      // $model->seq = NULL;
      // $model->status = 0;
      // $model->save();
      $model->delete();
      Yii::$app->adminLog->insert(Yii::t('log', 'Delete {record} of {model}', ['record' => $model->name.('[#'.$model->id.']'), 'model' => Yii::t('app', 'Menu')]));

      \common\models\Menu::updateSeq($id);
      return $this->redirect(['index']);
    }


    public function actionSelecttype($id)
    {
      $model = \common\models\PageType::findOne(['MID'=>$id]);
      if($model==NULL){
        $model = new \common\models\PageType;
        $model->MID = $id;
      }

      if ($model->load(Yii::$app->request->post()) && $model->save()) {
          return $this->redirect(['index']);
      }
      return $this->renderAjax('selecttype', [
          'model' => $model,
      ]);

    }

    public function actionReorder($id=NULL)
    {
      $model = new \backend\models\MenuReorder;
      $model->MID = $id;
      $model->setContent();

      if ($model->load(Yii::$app->request->post())  && $model->saveContent()) {
          Yii::$app->adminLog->insert(Yii::t('log', 'Update {record} of {model}', ['record' => Yii::t('log', 'Order'), 'model' => Yii::t('app', 'Menu')]));

          return $this->redirect(['index']);
      }else{
        return $this->renderAjax('reorder', [
            'model' => $model,
        ]);
      }
    }

    public function actionHomeReorder()
    {
      $model = new \backend\models\MenuHomeReorder;
      $model->setContent();

      if ($model->load(Yii::$app->request->post())  && $model->saveContent()) {
          Yii::$app->adminLog->insert(Yii::t('log', 'Update {record} of {model}', ['record' => Yii::t('log', 'Home Order'), 'model' => Yii::t('app', 'Menu')]));

          return $this->redirect(['index']);
      }else{
        return $this->renderAjax('reorder', [
            'model' => $model,
        ]);
      }
    }

    /**
     * Finds the Menu model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Menu the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Menu::findOne($id)) !== null) {
            if (!\backend\components\AccessRule::checkRole(['page.allpages', 'page.'.$model->id]))
                throw new \yii\web\ForbiddenHttpException(Yii::t('yii', 'You are not allowed to perform this action.'));

            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function findModelForm($id)
    {
        if (($model = MenuForm::findOne($id)) !== null) {
            if (!\backend\components\AccessRule::checkRole(['page.allpages', 'page.'.$model->id]))
                throw new \yii\web\ForbiddenHttpException(Yii::t('yii', 'You are not allowed to perform this action.'));

            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
