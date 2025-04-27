<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\ContactUs;
use common\models\PageType1;
use common\models\Home;


class PageController extends Controller
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
                    'actions' => ['general'],
                      'allow' => true,
                      'roles' => ['page.general'],
                  ],
                  [
                    'actions' => ['edit'],
                      'allow' => true,
                      'roles' => [],
                  ],
                  [
                    'actions' => ['home'],
                      'allow' => true,
                      'roles' => ['page.home'],
                  ],
                  [
                    'actions' => ['contact-us'],
                      'allow' => true,
                      'roles' => ['page.contactus'],
                  ],
              ],
            ],
        ];
    }

    public function actionGeneral()
    {
      $model = \common\models\General::findOne(['id'=>1]);
      if($model==NUll){
        $model = new \common\models\General;
        $model->id = 1;
        $model->lang = 'zh-TW';
      }

      if(Yii::$app->request->post()){
        if ($model->load(Yii::$app->request->post())) {
          $model->image_file = \yii\web\UploadedFile::getInstance($model, 'image_file');
          if ($model->saveContent()) {
              Yii::$app->adminLog->insert(Yii::t('log', 'Update {model}', ['model' => Yii::t('app', 'General')]));

              return $this->refresh();
          }
            //return $this->redirect(['edit','id'=>$id]);
        }
      }
      return $this->render('general', [
          'model' => $model,
      ]);
    }

    public function actionEdit($id)
    {
        $model = \common\models\Menu::findOne($id);

        if (!\backend\components\AccessRule::checkRole(['page.'.$model->id, 'page.allpages']))
            throw new \yii\web\ForbiddenHttpException();

        $page_type = $model->page_type;

      switch($page_type){
        case 1:
          $this->redirect(['pagetype1/index', 'id' => $id]);
          break;
        case 2:
          $this->redirect(['pagetype2/index', 'id' => $id]);
          break;
        case 3:
          $this->redirect(['pagetype3/index', 'id' => $id]);
          break;
        case 4:
          $this->redirect(['pagetype4/index', 'id' => $id]);
          break;
        case 5:
          $this->redirect(['pagetype5/index', 'id' => $id]);
          break;
        case 6:
          $this->redirect(['pagetype6/index', 'id' => $id]);
          break;
        case 7:
          $this->redirect(['pagetype7/index', 'id' => $id]);
          break;
        case 8:
          $this->redirect(['pagetype8/index', 'id' => $id]);
          break;
        case 9:
          $this->redirect(['pagetype9/index', 'id' => $id]);
          break;
        case 10:
          $this->redirect(['pagetype10/index', 'id' => $id]);
          break;
        case 10:
          $this->redirect(['pagetype10/index', 'id' => $id]);
          break;
        case 11:
          $this->redirect(['pagetype11/index', 'id' => $id]);
          break;  
        case 12:
          $this->redirect(['pagetype12/index', 'id' => $id]);
          break;    
        default:
          return $this->render('error', [
              'model' => $model,
          ]);
      }
    }

    //Home
    public function actionHome($id)
    {
      $model = Home::findOne($id);
      if($model==NULL){
        $model = new PageType1;
        $model->id = $id;
      }
      Yii::$app->params['HID'] = $id;

      if ($model->load(Yii::$app->request->post()) && $model->saveContent()) {
          Yii::$app->adminLog->insert(Yii::t('log', 'Update {record} of {model}', ['record' => ('[#'.$model->id.']'), 'model' => Yii::t('app', 'Home')]));

          return $this->redirect(['home', 'id' => $id]);
      }else{
        return $this->render('home', [
            'model' => $model,
        ]);
      }
    }

//contact us
    public function actionContactUs()
    {
      $model = ContactUs::findOne(['id'=>1]);
      if($model==NUll){
        $model = new ContactUs;
        $model->id = 1;
      }
      if(Yii::$app->request->post()){

        if ($model->load(Yii::$app->request->post())  && $model->save()) {
            Yii::$app->adminLog->insert(Yii::t('log', 'Update {model}', ['model' => Yii::t('app', 'Contact Info')]));

            return $this->redirect(['contact-us']);
        }
        return $this->refresh();
      }
      return $this->render('contact_us', [
          'model' => $model,
      ]);

    }
}
