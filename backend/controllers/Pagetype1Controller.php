<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\PageType1;


class Pagetype1Controller extends Controller
{
  public $enableCsrfValidation = false;

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                  //  'delete' => ['post'],
                ],
            ],
            'access' => [
              'class' => \yii\filters\AccessControl::className(),
              'ruleConfig' => [
			            'class' => \backend\components\AccessRule::className(),
			        ],
              'rules' => [
                  [
                    'actions' => ['index'],
                      'allow' => true,
                      'roles' => ['page'],
                  ],
              ],
            ],
        ];
    }


    //Page Type1
    public function actionIndex($id)
    {
      $menu_model = $this->findMenu($id);
      Yii::$app->params['MID'] = $menu_model->id;

      $model = PageType1::findOne(['MID'=>$menu_model->id]);
      if($model==NULL){
        $model = new PageType1;
        $model->MID = $id;
      }

      if ($model->load(Yii::$app->request->post()) && $model->saveContent()) {
          Yii::$app->adminLog->insert(Yii::t('log', 'Update {record}', ['record' => $menu_model->name.('[#'.$model->id.']')]), $menu_model->id);

          return $this->redirect(['index','id'=>$id]);
      }else{
        return $this->render('index', [
            'model' => $model,
        ]);
      }
    }

    private function findMenu($id) {
        $model = \common\models\Menu::find()->where(['id' => $id, 'page_type' => 1])->one();

        if ($model == null)
            throw new \yii\web\NotFoundHttpException();

        if (!\backend\components\AccessRule::checkRole(['page.'.$model->id, 'page.allpages']))
            throw new \yii\web\ForbiddenHttpException(Yii::t('yii', 'You are not allowed to perform this action.'));

        return $model;
    }

}
