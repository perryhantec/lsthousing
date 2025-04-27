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
use common\models\PageType11;

/**
 * Cart controller
 */
class Pagetype11Controller extends Controller
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
                        'actions' => ['index'],
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
      /*
      $basename = basename(\yii\helpers\Url::current());
      $basename_temp = explode("?", $basename);
      $url_name = $basename_temp[0];
      if ($url_name == "disclaimer" || $url_name == "privacy-policy" || $url_name == "copyright-notice") {
        return $this->render('static_page', ['route' => $url_name, 'model' => General::findOne(1)]);
      }
      */
/*
      $url_name = 'latest-news';
      
      $model = Menu::find()->where(['url' => $url_name])->one();
      if ($model->show_after_login === 1) {
        if (Yii::$app->user->isGuest) {
            $this->redirect(['/login']);
        }
      }

      if($model==NULL)throw new \yii\web\NotFoundHttpException('#404 Page Not Found');
      //if($model->page_type === 0)$this->redirect($model->link);
      $_subMenu = $model->getSubMenu()->orderBy(['seq' => SORT_ASC])->limit(1)->one();
      if($_subMenu != null)$this->redirect($_subMenu->aUrl);

//      echo $model->page_type;
//      echo '<pre>';
//      print_r($_subMenu);
//      echo '</pre>';
//      exit();

      return $this->render('page',['model'=>$model]);
*/
//$_subMenu = PageType11::find()->where(['status' => 1])->all();
//
//      return $this->render('page',['model'=>$model]);
//        $model_pt11 = PageType11::find()->where(['status' => 1])->all();

        return $this->render('index', [
//            'model_pt11' => $model_pt11,
        ]);
    }
}
