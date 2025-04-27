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
use common\models\HouseholdActivity;
use frontend\models\HouseholdActivityForm;

/**
 * Cart controller
 */
class HouseholdActivityController extends Controller
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
                        'roles' => ['$'],
                    ],
                    [
                        'actions' => ['thank-you'],
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

    public function beforeAction($action)
    {
        if ($action->id == 'index') {
            $this->enableCsrfValidation = false;
        }

        $this->enableCsrfValidation = false;

        return parent::beforeAction($action);
    }

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
        $model = new HouseholdActivityForm();
        $submitted = false;

        // if ($model->load(Yii::$app->request->post())) {
        if ($model->load(Yii::$app->request->post())) {
            $submitted = true;
            if ($model->submit()) {
                return $this->redirect(['thank-you']);
            }

        }

        // $model->verifyCode = "";

        return $this->render('index', [
            'model' => $model,
            'submitted' => $submitted
        ]);
    }

    public function actionThankYou()
    {
        return $this->render('thankYou');
    }
}
