<?php

namespace frontend\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\helpers\Url;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\components\AccessRule;
use common\models\Menu;
use common\models\Config;
use common\models\Test;
use common\models\Application;
use yii\helpers\ArrayHelper;
use common\components\UploadedFile;
use frontend\models\UploadForm;

/**
 * Cart controller
 */
class TestController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        // return [
        //     'verbs' => [
        //         'class' => VerbFilter::className(),
        //         'actions' => [
        //         ],
        //     ],
        // ];
        return [
            'access' => [
                'class' => AccessControl::className(),
                'ruleConfig' => [
			            'class' => AccessRule::className(),
			        ],
                'rules' => [
                    [
                        'actions' => ['index','upload','encrypt'],
                        'allow' => true,
                        'roles' => [],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                  //  'logout' => ['post'],
                ],
            ],
        ];
    }

    function init()
    {
        parent::init();
        Config::RefreshSetting();
    }

    // public function beforeAction($action)
    // {
    //     if ($action->id == 'index') {
    //         $this->enableCsrfValidation = false;
    //     }

    //     $this->enableCsrfValidation = false;

    //     return parent::beforeAction($action);
    // }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],

        ];
    }

    public function actionIndex()
    {
        $model = new Test;

        if ($model->load(Yii::$app->request->post()) && $model->submit()) {

            echo '<pre>';
            print_r($model->upload_files);
            echo '</pre>';
            // if ($model->save()) {
            //   $this->flashCreateSuccess();
            //   return $this->redirectView($model);
            // }
            // else {
            //   $this->flashActiveRecordErrors($model->getErrors());
            // }
        }

        return $this->render('index', [
            'model' => $model,
        ]);
    }

    public function actionUpload()
    {
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = yii\web\Response::FORMAT_JSON;
      
            $name = ArrayHelper::getValue(array_keys(UploadedFile::getFiles()), 0);
      
            $model = new UploadForm();
            $model->files = [UploadedFile::getInstanceByName($name)];
            if (($result = $model->save()) !== false) {
              return [
                'success' => true,
                'data' => $result[0]
              ];
            } else {
              return [
                'success' => false,
                'errors' => $model->getErrors()
              ];
            }
          }
    }

    public function actionEncrypt()
    {
      $models = Application::find()->all();
      
      foreach ($models as $model) {
        $model->save();
      }
      echo 'encrypted';
    }

    // public function actionUploadMultiple($name = 'files')
    // {
    //   if (Yii::$app->request->isAjax) {
    //     Yii::$app->response->format = yii\web\Response::FORMAT_JSON;
    //     $model = new UploadForm();
    //     $model->files = UploadedFile::getInstancesByName($name);
  
    //     if (($result = $model->save()) !== false) {
    //       return [
    //         'success' => true,
    //         'data' => $result
    //       ];
    //     } else {
    //       return [
    //         'success' => false,
    //         'errors' => $model->getErrors()
    //       ];
    //     }
    //   }
    // }
}
