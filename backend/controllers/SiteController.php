<?php
namespace backend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use backend\models\LoginForm;
use backend\models\RentalPaymentSearch;
use common\models\RentalPayment;
use yii\filters\VerbFilter;

/**
 * Site controller
 */
class SiteController extends Controller
{
  public $enableCsrfValidation = false;


  //  public $layout = "login";

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'ruleConfig' => [
			            'class' => \backend\components\AccessRule::className(),
			        ],
                'rules' => [
                    [
                        'actions' => ['login', 'error', 'captcha', 'requestpasswordreset', 'reset-password'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['index', 'logout', 'read'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['file-browser'],
                        'allow' => true,
                        'roles' => ['fileBrowser'],
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

    /**
     * @inheritdoc
     */
     public function actions()
     {
         return [
             'error' => [
                 'class' => 'yii\web\ErrorAction',
             ],
             'captcha' => [
                 'class' => 'common\components\NumberCaptcha',
                 'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
             ],
         ];
     }
     public function beforeAction($action)
     {
          if (parent::beforeAction($action)) {
              // change layout for error action
              if ($action->id=='error')
                   $this->layout ='login';
              return true;
          } else {
              return false;
          }
      }


    public function actionIndex($id = false)
    {
        $searchModel = new RentalPaymentSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $id);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'uid' => $id,
        ]);
      
        // return $this->render('index');
    }

    public function actionRead($id)
    {
        $model = RentalPayment::findOne($id);
        
        $model->is_read = $model::IS_READ_YES;
        $model->save(false);

        return $this->redirect(['index']); 
    }

    public function actionLogin()
    {
        $this->layout = "login";
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goHome();
        }
        $model->verifyCode = null;

        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestpasswordreset()
    {
        $this->layout = "login";
        $model = new \backend\models\PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', Yii::t('app', 'Check your email for further instructions.'));

                return $this->redirect('index');
            } else {
                Yii::$app->session->setFlash('error', Yii::t('app', 'Sorry, we are unable to reset password for email provided.'));
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        $this->layout = "login";
        try {
            $model = new \backend\models\ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            //Yii::$app->session->setFlash('success', 'New password was saved.');

            return $this->redirect('login');
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    public function actionFileBrowser()
    {
        return $this->render('file_browser');
    }
}
