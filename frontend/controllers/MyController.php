<?php

namespace frontend\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\helpers\Json;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\components\AccessRule;
use common\models\Menu;
use common\models\Config;
use common\models\General;
use common\models\Application;
use common\models\ApplicationRequestFiles;
use common\models\ApplicationResponseFiles;
// use common\models\DeliveryOption;
// use common\models\UserDelivery;
use frontend\models\UserAccountDetailForm;
use frontend\models\UserApplicationDetailForm;
use frontend\models\UserUploadDetailForm;
// use frontend\models\UserBillingAddressForm;
// use frontend\models\UserShippingAddressForm;
// use frontend\models\UserDeliveryForm;
// use frontend\models\UserLoginInfoForm;
// use frontend\models\UserPersonalInfoForm;
use yii\helpers\ArrayHelper;
use common\components\UploadedFile;
use frontend\models\UploadForm;
use frontend\models\ApplicationForm;

/**
 * Site controller
 */
class MyController extends Controller
{
    /**
     * @inheritdoc
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
                        'actions' => [
                                        'index', 'account', 'detail', 'upload', 'upload-detail', 'upload-file',
                                        'application', 'application-view', 'application-update'
                                    ],
                        'allow' => true,
                        'roles' => ['$'],
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

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('index', [
        ]);
    }

    public function actionAccount()
    {
        $model = UserAccountDetailForm::findOne(['id' => Yii::$app->user->id]);

        if ($model == null)
            throw new \yii\web\HttpException(400, Yii::t('app', 'Error! Please try again.'));

        if ($model->load(Yii::$app->request->post()) && $model->submit()) {
            Yii::$app->session->setFlash('success', Yii::t('app', 'Successfully save changes.'));
            // Yii::$app->session->setFlash('success', '資料已傳送，請等待管理員審批，成功批核將不會另行通知。如更改密碼則更改成功（毋須審批）');
            return $this->redirect(['/my/account']);
        }

        $model->old_password = null;
        $model->new_password = null;
        $model->re_new_password = null;

        return $this->render('account', [
            'model' => $model
        ]);
    }

    public function actionDetail()
    {
        $model = UserApplicationDetailForm::findOne(['id' => Yii::$app->user->id]);

        if ($model == null)
            throw new \yii\web\HttpException(400, Yii::t('app', 'Error! Please try again.'));

        if ($model->load(Yii::$app->request->post()) && $model->submit()) {
            Yii::$app->session->setFlash('success', Yii::t('app', 'Successfully save changes.'));
            return $this->redirect(['/my/detail']);
        }

        // $model->old_password = null;
        // $model->new_password = null;
        // $model->re_new_password = null;

        return $this->render('detail', [
            'model' => $model
        ]);
    }

    public function actionUpload($id)
    {
        $model = ApplicationRequestFiles::find()->where(['user_id' => Yii::$app->user->id,'application_id' => $id])->orderby(['created_at'=> SORT_DESC])->all();

        $appl_model = Application::findOne(['id' => $id]);

        // if ($model == null)
        //     throw new \yii\web\HttpException(400, Yii::t('app', 'Error! Please try again.'));

        // if ($model->load(Yii::$app->request->post()) && $model->submit()) {
        //     Yii::$app->session->setFlash('success', Yii::t('app', 'Successfully save changes.'));
        //     return $this->redirect(['/my/detail']);
        // }

        // $model->old_password = null;
        // $model->new_password = null;
        // $model->re_new_password = null;

        return $this->render('upload-list', [
            'model' => $model,
            'appl_model' => $appl_model
        ]);
    }

    public function actionUploadDetail($id)
    {
        $model = new UserUploadDetailForm;
        // $model = new ApplicationResponseFiles;

        if ($model == null)
            throw new \yii\web\HttpException(400, Yii::t('app', 'Error! Please try again.'));

        if ($model->load(Yii::$app->request->post())) {
            if ($model->submit()) {
            // if ($model->saveContent()) {
                $model->sendEmail();
                Yii::$app->session->setFlash('success', Yii::t('app', 'Successfully save changes.'));
                return $this->redirect(['/my/upload', 'id' => $model->application_id]);
            }
        }
      
        $req_model = ApplicationRequestFiles::findOne($id);
// echo '<pre>';
// print_r($req_model);
// echo '</pre>';
// exit();
        if ($req_model == null || isset($req_model->user_id) && $req_model->user_id != Yii::$app->user->id) {
            return $this->redirect(['/my/upload', 'id' => $application_id]);
        }
        // if ($model->load(Yii::$app->request->post()) && $model->submit()) {
        //     Yii::$app->session->setFlash('success', Yii::t('app', 'Successfully save changes.'));
        //     return $this->redirect(['/my/detail']);
        // }

        // $model->old_password = null;
        // $model->new_password = null;
        // $model->re_new_password = null;

        return $this->render('upload-detail', [
            'model' => $model,
            'req_model' => $req_model,
            // 'id'    => $id
        ]);
    }

    public function actionUploadFile()
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

    public function actionApplication()
    {
        $model = Application::find()->where(['user_id' => Yii::$app->user->id])->orderby(['created_at'=> SORT_DESC])->all();

        // if ($model == null)
        //     throw new \yii\web\HttpException(400, Yii::t('app', 'Error! Please try again.'));

        // if ($model->load(Yii::$app->request->post()) && $model->submit()) {
        //     Yii::$app->session->setFlash('success', Yii::t('app', 'Successfully save changes.'));
        //     return $this->redirect(['/my/detail']);
        // }

        return $this->render('application-list', [
            'model' => $model
        ]);
    }

    public function actionApplicationView($id)
    {
        $model = Application::findOne(['id' => $id]);

        if ($model == null || isset($model->user_id) && $model->user_id != Yii::$app->user->id)
            throw new \yii\web\HttpException(400, Yii::t('app', 'Error! Please try again.'));

        // if ($model->load(Yii::$app->request->post()) && $model->submit()) {
        //     Yii::$app->session->setFlash('success', Yii::t('app', 'Successfully save changes.'));
        //     return $this->redirect(['/my/detail']);
        // }

        return $this->render('application-view', [
            'model' => $model
        ]);
    }

    public function actionApplicationUpdate($id)
    {
        // $model = new ApplicationForm();
        $model = ApplicationForm::findOne(['id' => $id]);
        // $model = Application::findOne(['id' => $id]);
        $model->create_form = false;
        if ($model == null || isset($model->user_id) && $model->user_id != Yii::$app->user->id)
            throw new \yii\web\HttpException(400, Yii::t('app', 'Error! Please try again.'));

        if ($model->load(Yii::$app->request->post()) && $model->submit()) {
            Yii::$app->session->setFlash('success', Yii::t('app', 'Successfully save changes.'));
            return $this->redirect(['/my/application']);
        }

        return $this->render('application-edit', [
            'model' => $model
        ]);
    }

/*
    public function actionEditLoginInfo() {
        $model = UserLoginInfoForm::findOne(['id' => Yii::$app->user->id]);

        if (Yii::$app->request->get("fancybox"))
            $this->layout = false;

        if ($model->load(Yii::$app->request->post())) {
            if (Yii::$app->request->isAjax)
                return Json::encode(\yii\widgets\ActiveForm::validate($model));
            else if ($model->submit())
                return $this->redirect(['/my']);
            else
                throw new \yii\web\HttpException(400, Yii::t('app', 'Error! Please try again.'));

        }

        if (!$this->layout)
            return $this->renderAjax('login_info_edit', [
                'layout' => $this->layout,
                'model' => $model
            ]);
        else
            return $this->render('login_info_edit', [
                'layout' => $this->layout,
                'model' => $model
            ]);
    }

    public function actionEditPersonalInfo() {
        $model = UserPersonalInfoForm::findOne(['id' => Yii::$app->user->id]);

        if (Yii::$app->request->get("fancybox"))
            $this->layout = false;

        if ($model->load(Yii::$app->request->post())) {
            if (Yii::$app->request->isAjax)
                return Json::encode(\yii\widgets\ActiveForm::validate($model));
            else if ($model->save())
                return $this->redirect(['/my']);
            else
                throw new \yii\web\HttpException(400, Yii::t('app', 'Error! Please try again.'));

        }

        if (!$this->layout)
            return $this->renderAjax('personal_info_edit', [
                'layout' => $this->layout,
                'model' => $model
            ]);
        else
            return $this->render('personal_info_edit', [
                'layout' => $this->layout,
                'model' => $model
            ]);
    }

    public function actionAddDelivery($from="/my")
    {
        $model = new UserDeliveryForm();

        $model->user_id = Yii::$app->user->id;
        $model->name = Yii::$app->user->identity->name;
        $model->email = Yii::$app->user->identity->email;
        $model->preferred = true;

        if (Yii::$app->request->get("fancybox"))
            $this->layout = false;

        if ($model->load(Yii::$app->request->post())) {
            if (Yii::$app->request->isAjax)
                return Json::encode(\yii\widgets\ActiveForm::validate($model));
            else if ($model->save()) {
                if ($model->preferred) {
                    Yii::$app->user->identity->address_id = $model->id;
                    Yii::$app->user->identity->save();
                }

                return $this->redirect($from);
            } else
                throw new \yii\web\HttpException(400, Yii::t('app', 'Error! Please try again.'));

        }

        if (!$this->layout)
            return $this->renderAjax('delivery_edit', [
                'layout' => $this->layout,
                'action' => 'add',
                'model' => $model
            ]);
        else
            return $this->render('delivery_edit', [
                'layout' => $this->layout,
                'action' => 'add',
                'model' => $model
            ]);
    }

    public function actionEditDelivery($id, $from="/my")
    {
        $model = UserDeliveryForm::findOne(['id' => $id, 'user_id' => Yii::$app->user->id]);

        if (Yii::$app->request->get("fancybox"))
            $this->layout = false;

        if ($model == null)
            throw new \yii\web\HttpException(403, Yii::t('app', 'Error! Please try again.'));

        $model->preferred = (Yii::$app->user->identity->address_id == $model->id);

        if ($model->load(Yii::$app->request->post())) {
            if (Yii::$app->request->isAjax)
                return Json::encode(\yii\widgets\ActiveForm::validate($model));
            else if ($model->save()) {
                if (Yii::$app->user->identity->address_id == null || $model->preferred) {
                    Yii::$app->user->identity->address_id = $model->id;
                    Yii::$app->user->identity->save();
                } else if (Yii::$app->user->identity->address_id == $model->id && !$model->preferred) {
                    Yii::$app->user->identity->address_id = null;
                    Yii::$app->user->identity->save();
                }

                return $this->redirect($from);
            } else
                throw new \yii\web\HttpException(400, Yii::t('app', 'Error! Please try again.'));
        }

        if (!$this->layout)
            return $this->renderAjax('delivery_edit', [
                'layout' => $this->layout,
                'action' => 'edit',
                'model' => $model
            ]);
        else
            return $this->render('delivery_edit', [
                'layout' => $this->layout,
                'action' => 'edit',
                'model' => $model
            ]);
    }

    public function actionChangePreferredDelivery($id, $from="/my")
    {
        $model = UserDelivery::findOne(['id' => $id, 'user_id' => Yii::$app->user->id]);

        if ($model == null)
            throw new \yii\web\HttpException(403, Yii::t('app', 'Error! Please try again.'));

        if ($model) {
            Yii::$app->user->identity->address_id = $model->id;
            Yii::$app->user->identity->save();
        }

        return $this->redirect($from);
    }

    public function actionGetDeliveryOptionDetail() {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $_description = "";

        if (Yii::$app->request->isAjax) {
            if (Yii::$app->request->post('id') !== null) {
                $model = DeliveryOption::findOne(Yii::$app->request->post('id'));

                if ($model)
                    $_description = $model->Display_description;
            }
        }

        return ['description' => $_description];
    }
*/
}
