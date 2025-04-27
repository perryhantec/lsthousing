<?php

namespace frontend\controllers;

use frontend\models\ResendVerificationEmailForm;
use frontend\models\VerifyEmailForm;
use Yii;
use yii\base\InvalidArgumentException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

use frontend\models\LoginForm;
use frontend\models\UserRegistrationForm;
use common\components\AccessRule;
use common\models\Menu;
use common\models\Config;
use common\models\General;
use common\models\User;
// use common\models\Product;
use common\utils\Html;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7;
use yii\helpers\Url;



/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'ruleConfig' => [
                    'class' => AccessRule::className(),
                ],
               'rules' => [
                    [
                        'actions' => [],
                        'allow' => true,
                        'roles' => [],
                    ],
                    // [
                    //     'actions' => ['logout'],
                    //     'allow' => true,
                    //     'roles' => ['@']
                    // ],
                    // [
                    //     'actions' => ['send-otp','login'],
                    //     'allow' => true,
                    //     'roles' => ['?']
                    // ]
                ],
                // 'only' => ['household-regulations'],
                // 'rules' => [
                //     [
                //         'actions' => ['household-regulations'],
                //         'allow' => true,
                //         'roles' => ['$'],
                //     ],
                // ],
                // 'only' => ['logout', 'signup'],
                // 'rules' => [
                //     [
                //         'actions' => ['signup'],
                //         'allow' => true,
                //         'roles' => ['?'],
                //     ],
                //     [
                //         'actions' => ['logout'],
                //         'allow' => true,
                //         'roles' => ['@'],
                //     ],
                // ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    // 'logout' => ['post'],
                    // 'send-otp' => ['post']
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                // 'class' => 'yii\captcha\CaptchaAction',
                'class' => 'common\components\NumberCaptcha',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
                'foreColor' => 0xD35A4E,
            ],
        ];
    }

    function init()
    {
        parent::init();
        Config::RefreshSetting();
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionPage()
    {
      $basename = basename(\yii\helpers\Url::current());
      $basename_temp = explode("?", $basename);
      $url_name = $basename_temp[0];
      if ($url_name == "disclaimer" || $url_name == "privacy-policy" || $url_name == "copyright-notice") {
        return $this->render('static_page', ['route' => $url_name, 'model' => General::findOne(1)]);
      }
      $model = Menu::find()->where(['url' => $url_name])->one();
      if ($model->show_after_login === 1) {
        if (Yii::$app->user->isGuest) {
            $this->redirect(['/login']);
        }
      }
      if($model==NULL)throw new \yii\web\NotFoundHttpException('#404 Page Not Found');
      if($model->page_type === 0)$this->redirect($model->link);
      $_subMenu = $model->getSubMenu()->orderBy(['seq' => SORT_ASC])->limit(1)->one();
      if($_subMenu != null)$this->redirect($_subMenu->aUrl);
      return $this->render('page',['model'=>$model]);
    }

    public function actionType3detail($id)
    {
      $model_album = \common\models\PageType3::findOne($id);
      if($model_album==NULL)throw new \yii\web\NotFoundHttpException('#404 Page Not Found');
      $model_photos = $model_album->getPhotos()->where(['status' => 1])->orderBy(['seq' => SORT_ASC, 'id' => SORT_DESC])->all();
      return $this->render('type3_detail',['model_album'=> $model_album, 'model_photos'=>$model_photos]);
    }

    public function actionType4detail($id)
    {
      $model = \common\models\PageType4::findOne(['id' => $id, 'status' => 1]);
      if($model==NULL)throw new \yii\web\NotFoundHttpException('#404 Page Not Found');
      return $this->render('type4_detail',['model'=>$model]);
    }

    public function actionType11detail($id)
    {
      $model = \common\models\PageType11::findOne(['id' => $id, 'status' => 1]);
      if($model==NULL)throw new \yii\web\NotFoundHttpException('#404 Page Not Found');
      return $this->render('type11_detail',['model'=>$model]);
    }

    public function actionType12detail($id)
    {
      $model = \common\models\PageType12::findOne(['id' => $id, 'status' => 1]);
      if($model==NULL)throw new \yii\web\NotFoundHttpException('#404 Page Not Found');
      return $this->render('type12_detail',['model'=>$model]);
    }

    public function actionSearch()
    {
      return $this->render('search',[]);
    }

    public function actionProjectSearch()
    {
      $no_of_ppl = (int)Yii::$app->request->get('no_of_ppl');
      $project = (int)Yii::$app->request->get('project');
      $district = (int)Yii::$app->request->get('district');

      $condition = [];

      if ($no_of_ppl) {
        $condition[] = ['<=','avl_no_of_people_min',$no_of_ppl];
        $condition[] = ['>=','avl_no_of_people_max',$no_of_ppl];
      }

      if ($project) {
        $condition[] = ['id' => $project];
      }

      if ($district) {
        $condition[] = ['district_id' => $district];
      }

      array_unshift($condition, 'and');
      array_push($condition, ['status' => 1]);

    //   echo '<pre>';
    //   print_r($condition);
    //   echo '</pre>';

      $model = \common\models\PageType12::find()->where($condition)->all();
    //   $model = \common\models\PageType12::find()->where($condition);
    //   echo $model->createCommand()->sql;
    //   echo '<pre>';
    //   print_r($model);
    //   echo '</pre>';

      return $this->render('project_search',[
        'model_pt12' => $model,
      ]);
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
      $model = new \frontend\models\ContactForm();

      if ($model->load(Yii::$app->request->post()) && $model->validate()) {
          if ($model->sendEmail()) {
            Yii::$app->session->setFlash('success', Yii::t('web', 'Thank you for your inquiry.'));
          }
          return $this->redirect(['/contact']);
      }

      return $this->render('contact', [
          'model' => $model,
      ]);
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */

    public function actionLogin($return=null)
    {

        if (!Yii::$app->user->isGuest) {
            return $this->goBack(['/']);
        }

        $login_model = new LoginForm(['scenario' => LoginForm::SCENARIO_WEB]);
        $login_model->type = $login_model::LOGIN_TYPE_NORMAL;

        if ($login_model->load(Yii::$app->request->post()) && $login_model->login()) {
            // return $login_model->returnUrl != "" ? $this->redirect($login_model->returnUrl) : $this->goBack(['/']);
            // return $login_model->returnUrl != false ? $this->redirect($login_model->returnUrl) : $this->goBack(['/']);
            return $login_model->returnUrl != false ? $this->redirect($login_model->returnUrl) : $this->redirect(['/my/application']);
        }

        $login_model->returnUrl = $return ?: Yii::$app->request->referrer;

        $login_model->password = null;
        $login_model->verifyCode = null;

        return $this->render('login', [
            'login_model' => $login_model,
        ]);
    }

    public function actionLoginOtp()
    {
        if (! Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        
        $model = new LoginForm();
        $model->type = $model::LOGIN_TYPE_OTP;

        if (\Yii::$app->request->isAjax){
            \Yii::$app->response->format = 'json';
            $model->load(Yii::$app->request->post());
            if ($model->login()) {
                $response = [
                    'success' => true,
                    'msg' => 'Login Successful'
                ];
            } else {
                $error = implode(", ", \yii\helpers\ArrayHelper::getColumn($model->errors, 0, false)); // Model's Errors string
                $response = [
                    'success' => false,
                    'msg' => $error
                ];
            }
            return $response;
        }
        $model->password = '';
        return $this->render('login_otp', [
            'model' => $model
        ]);
    }

    public function actionForgetPassword($username=null)
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goBack();
        }

        $model = new \frontend\models\ForgetPasswordForm();
        // $model->username = $username;
        $model->email = $username;
        $model->verifyCode = null;


        if ($model->load(Yii::$app->request->post())) {
            if (Yii::$app->request->isAjax) {
                return Json::encode(\yii\widgets\ActiveForm::validate($model));

            } else if ($model->validate() && $model->sendEmail()) {
                Yii::$app->session->setFlash('success', Yii::t('app', 'Please check your email for further instructions.'));

                return $this->redirect(['/login']);

            } else {
                Yii::$app->session->setFlash('error', Yii::t('app', 'Sorry, we are unable to reset password for email provided.'));

                return $this->redirect(['/login']);
            }
        }

        return $this->render('forgetPassword', [
            'model' => $model,
        ]);
    }

    public function actionResetPassword($token)
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goBack();
        }

        try {
            $model = new \frontend\models\ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', Yii::t('app', 'New password was saved. Please use new password to login.'));

            return $this->redirect(['/login']);
        }

        $model->new_password = "";
        $model->re_new_password = "";
        $model->verifyCode = null;

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    public function actionRegistration()
    {
        $return_url = Yii::$app->request->referrer;

        if (!Yii::$app->user->isGuest) {
            return $this->goBack();
        }

        $registration_model = new UserRegistrationForm(['scenario' => UserRegistrationForm::SCENARIO_WEB]);

        if ($registration_model->load(Yii::$app->request->post()) && $registration_model->submit()) {
            return $this->goBack();
        }

        $registration_model->new_password = null;
        $registration_model->re_new_password = null;
        $registration_model->verifyCode = null;
        $registration_model->acknowledge_tc = null;

        return $this->render('registration', [
            'registration_model' => $registration_model,
        ]);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();
        // return $this->redirect(['/']);
        return $this->goHome();
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    // public function actionRequestPasswordReset()
    // {
    //     $model = new PasswordResetRequestForm();
    //     if ($model->load(Yii::$app->request->post()) && $model->validate()) {
    //         if ($model->sendEmail()) {
    //             Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

    //             return $this->goHome();
    //         }

    //         Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
    //     }

    //     return $this->render('requestPasswordResetToken', [
    //         'model' => $model,
    //     ]);
    // }


    /**
     * Verify email address
     *
     * @param string $token
     * @throws BadRequestHttpException
     * @return yii\web\Response
     */
    // public function actionVerifyEmail($token)
    // {
    //     try {
    //         $model = new VerifyEmailForm($token);
    //     } catch (InvalidArgumentException $e) {
    //         throw new BadRequestHttpException($e->getMessage());
    //     }
    //     if (($user = $model->verifyEmail()) && Yii::$app->user->login($user)) {
    //         Yii::$app->session->setFlash('success', 'Your email has been confirmed!');
    //         return $this->goHome();
    //     }

    //     Yii::$app->session->setFlash('error', 'Sorry, we are unable to verify your account with provided token.');
    //     return $this->goHome();
    // }

    /**
     * Resend verification email
     *
     * @return mixed
     */
    // public function actionResendVerificationEmail()
    // {
    //     $model = new ResendVerificationEmailForm();
    //     if ($model->load(Yii::$app->request->post()) && $model->validate()) {
    //         if ($model->sendEmail()) {
    //             Yii::$app->session->setFlash('success', 'Check your email for further instructions.');
    //             return $this->goHome();
    //         }
    //         Yii::$app->session->setFlash('error', 'Sorry, we are unable to resend verification email for the provided email address.');
    //     }

    //     return $this->render('resendVerificationEmail', [
    //         'model' => $model
    //     ]);
    // }

    public function actionSendOtp()
    {
        $phone = \Yii::$app->request->post('phone');
        \Yii::$app->response->format = 'json';
        $response_otp = [];
        if ($phone) {
            $user = \common\models\User::findByPhone($phone);
            $otp = rand(100000, 999999); // a random 6 digit number
            if ($user == null) {
                // $user = new \common\models\User();
                // $user->created_on = time();
                return $response_otp = [
                    'success' => false,
                    'msg' => '用戶不存在'
                ];
            }
            $user->mobile = $phone;
            $user->otp = "$otp";
            $user->otp_expire = time() + 600; // To expire otp after 10 minutes
            if (! $user->save()) {
                $errorString = implode(", ", \yii\helpers\ArrayHelper::getColumn($user->errors, 0, false)); // Model's Errors string
                $response_otp = [
                    'success' => false,
                    'msg' => $errorString
                ];
            } else {
                $sms_content = '一次性密碼: ' . $otp;

                $client = new Client([
                    'base_uri' => Yii::$app->params['easySmsApiPath'],
                //                 'timeout'  => 2.0,
                ]);
        
                try {    
                    $_mobile = '852-'.$phone;
        
                    $_request_url = Yii::$app->params['easySmsApiPath'].'api/send/'.Yii::$app->params['easySmsUsername'].'/'.md5(Yii::$app->params['easySmsPassword']).'/'.$_mobile.'/'.(urlencode(mb_convert_encoding($sms_content, 'UTF-8')));

                    // if (YII_ENV_DEV)
                    //     var_dump($_request_url);

                    $response = $client->request('GET', $_request_url, [
                    ]);
        
                    $xml = simplexml_load_string($response->getBody(), "SimpleXMLElement", LIBXML_NOCDATA);
                    $json = json_encode($xml);
                    $result = json_decode($json,TRUE);
        
                    // if (YII_ENV_DEV)
                    //     var_dump($result);
    
                    if (isset($result['record']) && isset($result['record']['id']) && isset($result['record']['status'])) {
                        // $appl_sms_model->sent_response = null;
                        // $appl_sms_model->sent_reference = $result['record']['id'];
                        // $appl_sms_model->save(false);

                        $response_otp = [
                            'success' => true,
                            'msg' => '一次性密碼有效時間為十分鐘'
                        ];

                        // if ($result['record']['status'] == "failed") {
                        //     // return false;
                        // } else if ($result['record']['status'] == "sent") {
                        //     // return true;
                        // } else {
                        //     // return null;
                        // }
                    } else if (isset($result['code']) | isset($result['description'])) {
                        // $appl_sms_model->sent_response = trim((isset($result['description']) ? $result['description'] : '').(isset($result['code']) ? (' #'.$result['code']) : ''));
                        // $appl_sms_model->save(false);
        
                        // return false;
                        $response_otp = [
                            'success' => false,
                            'msg' => '回應失敗'
                        ];
                    }
        
                    // return false;
                } catch (\GuzzleHttp\Exception\GuzzleException $e) {
                    if (YII_ENV_DEV) {
                        echo Psr7\Message::toString($e->getRequest());
                        echo Psr7\Message::toString($e->getResponse());
                    }
                    // $appl_sms_model->sent_response = Psr7\Message::toString($e->getResponse());
                    // $appl_sms_model->save(false);
        
                    // return false;
                    $response_otp = [
                        'success' => false,
                        'msg' => 'G失敗'
                    ];
                } catch (\yii\base\InvalidArgumentException $e) {
                    // return false;
                    $response_otp = [
                        'success' => false,
                        'msg' => '其他失敗'
                    ];
                }

                // $sid = \Yii::$app->params['twilioSid'];  //accessing the above twillio credentials saved in params.php file
                // $token = \Yii::$app->params['twiliotoken'];
                // $twilioNumber = \Yii::$app->params['twilioNumber'];
                
                // try{
                //             $client = new \Twilio\Rest\Client($sid, $token);
                //             $client->messages->create($phone, [
                //                         'from' => $twilioNumber,
                //                         'body' => (string) $msg
                //             ]);
                //             $response = [
                //                         'success' => true,
                //                         'msg' => 'OTP Sent and valid for 10 minutes.'
                //             ];
                // }catch(\Exception $e){
                //             $response = [
                //                         'success' => false,
                //                         'msg' => $e->getMessage()
                //             ];
                // }
            }
        } else {
            $response_otp = [
                'success' => false,
                'msg' => '電話不能為空'
            ];
        }
        return $response_otp;
    }
}
