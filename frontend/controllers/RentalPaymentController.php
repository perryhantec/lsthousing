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
use common\models\RentalPayment;
use frontend\models\RentalPaymentForm;

/**
 * Cart controller
 */
class RentalPaymentController extends Controller
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
        $model = new RentalPaymentForm;
        $submitted = false;

        if ($model == null)
            throw new \yii\web\HttpException(400, Yii::t('app', 'Error! Please try again.'));

        if ($model->load(Yii::$app->request->post())) {
            if ($model->saveContent()) {
                $submitted = true;
                // Yii::$app->session->setFlash('success', Yii::t('app', 'Successfully save changes.'));
                return $this->redirect(['thank-you']);
            }
        }
        // if ($model->load(Yii::$app->request->post())) {
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
