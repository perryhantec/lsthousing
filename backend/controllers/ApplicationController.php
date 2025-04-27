<?php

namespace backend\controllers;

use Yii;
use common\models\Application;
use common\models\ApplicationMark;
use common\models\ApplicationRequestFiles;
use common\models\ApplicationResponseFiles;
use common\models\ApplicationSms;
use common\models\Definitions;
use backend\models\ApplicationSearch;
use backend\models\ApplicationVisitSearch;
use backend\models\ApplicationApproveSearch;
use backend\models\ApplicationAllocateSearch;
use backend\models\ApproveExportForm;
use backend\models\ApplicationFormImport;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\grid\EditableColumnAction;
use PhpOffice\PhpSpreadsheet\IOFactory;
use yii\helpers\FileHelper;

/**
 * ApplicationController implements the CRUD actions for User model.
 */
class ApplicationController extends Controller
{
  public $enableCsrfValidation = false;

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
            'access' => [
              'class' => \yii\filters\AccessControl::className(),
              'ruleConfig' => [
			            'class' => \backend\components\AccessRule::className(),
			        ],
              'rules' => [
                  [
                    'actions' => [
                        'index', 'request-file-list', 'response-file-list', 'visit-list', 'approve-list', 'allocate-list',
                        'create', 'update', 'update-application', 'update-visit', 'update-approve', 'update-allocate', 'view',
                        'export', 'export-application', 'delete'],
                      'allow' => true,
                      'roles' => [
                        'application', 'mark', 'visit', 'requestFile', 'responseFile', 'approve', 'allocate'
                      ],
                  ],
                  [
                    'actions' => ['select2-search'],
                      'allow' => true,
                      'roles' => ['@'],
                  ],
              ],
            ],

        ];
    }
    //editable config
    public function actions()
    {
        return ArrayHelper::merge(parent::actions(), []);
    }


    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ApplicationSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $model_application_form_import = new ApplicationFormImport;

        if ($model_application_form_import->load(Yii::$app->request->post()) && $model_application_form_import->import()) {
          $model_application_form_import = new ApplicationFormImport;
        }

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model_application_form_import' => $model_application_form_import,
        ]);
    }

    public function actionRequestFileList()
    {
        $searchModel = new ApplicationSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, 'request');

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'action' => 'request',
        ]);
    }

    public function actionResponseFileList()
    {
        $searchModel = new ApplicationSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, 'response');

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'action' => 'response',
        ]);
    }

    public function actionVisitList()
    {
        $searchModel = new ApplicationVisitSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index-visit', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionApproveList()
    {
        $searchModel = new ApplicationApproveSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index-approve', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionAllocateList()
    {
        $searchModel = new ApplicationAllocateSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index-allocate', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

/*
    public function actionCreate()
    {
        $model = new User();
        $model->scenario = User::SCENARIO_CREATE;
        $model->status = User::STATUS_ACTIVE;
        $model->role = User::ROLE_MEMBER;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->adminLog->insert(Yii::t('log', 'Add {record} to {model}', ['record' => $model->nameWithEmail.('[#'.$model->id.']'), 'model' => Yii::t('app', 'User')]));

            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('edit', [
                'model' => $model,
            ]);
        }
    }
*/
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->submit()) {
            Yii::$app->adminLog->insert(Yii::t('log', 'Update {record} of {model}', ['record' => $model->appl_no.('[#'.$model->id.']'), 'model' => '申請表']));
            if ($model->application_status == Application::APPL_STATUS_REJECTED) {
                $model->sendSubmittedEmail(3);
            }

            if ($model->application_status == Application::APPL_STATUS_FILES_PASSED) {
                $model->sendSubmittedEmail(4);
            }

            if ($model->application_status == Application::APPL_STATUS_UPLOAD_FILES) {
                return $this->redirect(['request-file-list']); 
            } else if ($model->application_status == Application::APPL_STATUS_UPLOAD_FILES_AGAIN) {
                return $this->redirect(['application-request-files/create', 'aid' => $model->id]); 
            } else if ($model->application_status == Application::APPL_STATUS_FILES_PASSED) {
                return $this->redirect(['visit-list']); 
            }

            return $this->redirect(['index']); 
        } else {
            return $this->render('edit', [
                'model' => $model,
            ]);
        }
    }

    public function actionUpdateApplication($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->submitApplication()) {
            Yii::$app->adminLog->insert(Yii::t('log', 'Update {record} of {model}', ['record' => $model->appl_no.('[#'.$model->id.']'), 'model' => '申請表']));

            return $this->redirect(['index']); 
        } else {
            return $this->render('edit-application', [
                'model' => $model,
            ]);
        }
    }

    public function actionUpdateVisit($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save(false)) {
            Yii::$app->adminLog->insert(Yii::t('log', 'Update {record} of {model}', ['record' => $model->appl_no.('[#'.$model->id.']'), 'model' => '家訪紀錄']));

            return $this->redirect(['visit-list']); 
        } else {
            return $this->render('edit-visit', [
                'model' => $model,
            ]);
        }
    }

    public function actionUpdateApprove($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save(false)) {
            Yii::$app->adminLog->insert(Yii::t('log', 'Update {record} of {model}', ['record' => $model->appl_no.('[#'.$model->id.']'), 'model' => '批核清單']));

            if ($model->approved == Application::APPROVED) {
                $model->sendSubmittedEmail(7);
            }

            return $this->redirect(['approve-list']); 
        } else {
            return $this->render('edit-approve', [
                'model' => $model,
            ]);
        }
    }

    public function actionUpdateAllocate($id)
    {
        $model = $this->findModel($id);

        // if ($model->load(Yii::$app->request->post()) && $model->submitAllocate()) {
        if ($model->load(Yii::$app->request->post()) && $model->submit()) {
            if ($model->application_status == Application::APPL_STATUS_ALLOCATE_UNIT_FAILED) {
                $model->sendSubmittedEmail(6);
            }

            Yii::$app->adminLog->insert(Yii::t('log', 'Update {record} of {model}', ['record' => $model->appl_no.('[#'.$model->id.']'), 'model' => '編配單位']));

            return $this->redirect(['allocate-list']); 
        } else {
            return $this->render('edit-allocate', [
                'model' => $model,
            ]);
        }
    }

/*
    public function actionUpdateAddress($id)
    {
        $model = $this->findModel($id)->address;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->adminLog->insert(Yii::t('log', 'Update {record} of {model}', ['record' => $model->user->nameWithEmail.('[#'.$model->id.']'), 'model' => Yii::t('app', 'Address Information')]));

            return $this->redirect(['view', 'id' => $model->user->id]);
        } else {
            return $this->render('edit-address', [
                'model' => $model,
            ]);
        }
    }
*/
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $appl_no = $model->appl_no;
        $model->delete();

        ApplicationMark::deleteAll(['application_id' => $id]);
        ApplicationRequestFiles::deleteAll(['application_id' => $id]);
        ApplicationResponseFiles::deleteAll(['application_id' => $id]);
        ApplicationSms::deleteAll(['application_id' => $id]);

        Yii::$app->adminLog->insert(Yii::t('log', 'Delete {record} of {model}', ['record' => $appl_no.('[#'.$id.']'), 'model' => '申請表']));

        return $this->redirect(['index']);
    }

/*
    public function actionSelect2Search($q = null, $id = null)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $result = ['results' => ['id' => '', 'text' => '']];
        if (!is_null($q)) {
            $model = User::find()
                            ->orWhere(['like', 'name', $q])
                            ->orWhere(['like', 'phone', $q])
                            ->orWhere(['like', 'email', $q])
                            ->andWhere(['!=', 'status', User::STATUS_DELETED])
                            ->all();
            $results = [];
            if ($model !== null) {
                foreach ($model as $user) {
                    $results[] = ['id' => $user->id, 'text' => Html::encode($user->nameWithEmail)];
                }
            }
            $result['results'] = $results;
        }
        elseif ($id > 0) {
            $result['results'] = ['id' => $id, 'text' => Html::encode(User::findOne($id)->nameWithEmail)];
        }
        return $result;
    }
*/

    protected function findModel($id)
    {
        if (($model = Application::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionExport()
    {
        $model = new ApproveExportForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $formatter = Yii::$app->getFormatter();
            $formatter->nullDisplay = '';

            $columns = [
                [
                    'attribute' => 'created_at',
                    'header' => Yii::t('app', 'Date'),
                    'value' => function($model) {
                        return Yii::$app->formatter->asDate($model->created_at, 'long')." ".Yii::$app->formatter->asTime($model->created_at, 'short');
                    },
                ],
                [
                    'attribute' => 'approved',
                    'value' => function($model) {
                        return Definitions::getApproved($model->approved);
                    },
                ],
                [
                    'attribute' => 'priority_1',
                    'value' => function($model) {
                        return Definitions::getProjectName($model->priority_1);
                    },
                ],
                [
                    'attribute' => 'priority_2',
                    'value' => function($model) {
                        return Definitions::getProjectName($model->priority_2);
                    },
                ],
                [
                    'attribute' => 'priority_3',
                    'value' => function($model) {
                        return Definitions::getProjectName($model->priority_3);
                    },
                ],
                'appl_no',
                'chi_name',
                'eng_name',
                'phone',
                'mobile',
                'email',
                'address',
/*
                [
                    'attribute' => 'status',
                    'value' => function($model) {
                        return Definitions::getDonationStatus($model->status);
                    },
                ],
                // [
                //     'attribute' => 'eventName',
                // ],
                [
                    'attribute' => 'order_no',
                ],
                [
                    'attribute' => 'type',
                    'value' => function($model) {
                        return Definitions::getDonationType($model->type);
                    },
                ],
                [
                    'attribute' => 'amount',
                ],
                [
                    'attribute' => 'service',
                    'value' => function($model) {
                        return Definitions::getService($model->service);
                    },
                ],
                // 'name',
                [
                    'attribute' => 'prefix',
                    'value' => function($model) {
                        return Definitions::getPrefix($model->prefix);
                    },
                ],
                'firstname',
                'lastname',
                // 'organization',
                'phone',
                // 'fax',
                [
                    'attribute' => 'email',
                ],
                [
                    'attribute' => 'address',
                ],
                [
                    'attribute' => 'd_number',
                    // 'header' => Yii::t('donation', 'Donor Number'),
                    'header' => 'Donor Number',
                ],
                [
                    'attribute' => 'receipt',
                    // 'header' => Yii::t('donation', 'Receipt'),
                    'value' => function($model) {
                        // return Definitions::getDonationReceipt($model->receipt);
                        return Definitions::getReceipt($model->receipt);
                    },
                ],
                [
                    'attribute' => 'recipient',
                    // 'header' => Yii::t('donation', 'Recipient'),
                ],
                // [
                //     'attribute' => 'receipt_name',
                // ],
                [
                    'attribute' => 'payment_method',
                    'value' => function($model) {
                        return Definitions::getDonationPaymentMethod($model->payment_method);
                    },
                ],
                [
                    'attribute' => 'receive',
                    // 'header' => Yii::t('donation', 'Receive information from HOHCS'),
                    'header' => 'Receive information from HOHCS',
                    'value' => function($model) {
                        return Definitions::getReceive($model->receive);
                    },
                ],
                // [
                //     'attribute' => 'receipts.receiptNumber',
                //     'value' => function($model) {
                //         return implode(", ", ArrayHelper::getColumn($model->receipts, 'receiptNumber'));
                //     },
                // ],
                [
                    'attribute' => 'refCode',
                    'header' => 'Ref Code',
                    'value' => function($model){
                        return isset($model->payment->refCode) ? $model->payment->refCode : '';
                    },
                ],
                [
                    'attribute' => 'payment_note',
                    'header' => 'Third Party Order ID',
                    'value' => function($model){
                        $third_party_order_id = '';
                        
                        if (isset($model->payment->payment_note) && $model->payment->payment_note) {
                          $payment_note = Json::decode($model->payment->payment_note);
                          
                          if (
                            $model->payment->method == Payment::METHOD_PAYPAL_PAYMENT ||
                            $model->payment->method == Payment::METHOD_PAYPAL_AGREEMENT
                          ) {
                            $third_party_order_id = isset($payment_note[0]['data']['id']) ? $payment_note[0]['data']['id'] : '';
                          } elseif (
                            $model->payment->method == Payment::METHOD_ALIPAY_PAYMENT ||
                            $model->payment->method == Payment::METHOD_ALIPAY_AGREEMENT ||
                            $model->payment->method == Payment::METHOD_WECHAT_PAYMENT ||
                            $model->payment->method == Payment::METHOD_WECHAT_AGREEMENT ||
                            $model->payment->method == Payment::METHOD_FPS_PAYMENT ||
                            $model->payment->method == Payment::METHOD_FPS_AGREEMENT
                          ) {
                            $third_party_order_id = isset($payment_note[0]['data']['out_transaction_id']) ? $payment_note[0]['data']['out_transaction_id'] : '';
                          } elseif (
                            $model->payment->method == Payment::METHOD_PAYME_PAYMENT ||
                            $model->payment->method == Payment::METHOD_PAYME_AGREEMENT
                          ) {
                            $third_party_order_id = isset($payment_note[0]['data']['paymentRequestId']) ? $payment_note[0]['data']['paymentRequestId'] : '';
                          } elseif (
                            $model->payment->method == Payment::METHOD_VM_PAYMENT ||
                            $model->payment->method == Payment::METHOD_VM_AGREEMENT ||
                            $model->payment->method == Payment::METHOD_UNION_PAYMENT ||
                            $model->payment->method == Payment::METHOD_UNION_AGREEMENT
                          ) {
                            
                          }
                        }

                        return $third_party_order_id;
                    },
                ],
                [
                    'attribute' => 'status',
                    'header'=>'Payment Status',
                    'value' => function($model){
                      return isset($model->payment->status) ? Definitions::getPaymentStatus($model->payment->status) : '';
                    },
                ],
                */
            ];

            $year = intval(substr($model->month, 0, 4));
            $month = intval(substr($model->month, 5, 2));
            $filename = 'UAT_LST_Housing_批核清單_'.$year.'年'.$month.'月_'.date('Ymd_His').'.xlsx';

            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment; filename="'.$filename.'.xlsx"');
            header('Cache-Control: max-age=0');
            header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
            header('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT');

            return \moonland\phpexcel\Excel::widget([
                    'models' => Application::find()->where(['YEAR(`created_at`)' => $year, 'MONTH(`created_at`)' => $month])->orderBy(['created_at' => SORT_ASC])->all(),
                    'fileName' => $filename,
                    'mode' => 'export',
                    'formatter' => $formatter,
                    'columns' => $columns
                ]);
        }

        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('export', [
                'pageType' => 'popup',
                'model' => $model,
            ]);
        } else {
            return $this->render('export', [
                'pageType' => 'page',
                'model' => $model,
            ]);
        }
    }

    public function actionExportApplication()
    {
        $objPHPExcel = IOFactory::load(Yii::getAlias('@common/templates').'/blank.xlsx');
        $objPHPExcelActiveSheet = $objPHPExcel->getSheet(0);
  
        $col_no = 'A';
        $row_no = '1';
  
        $row_header = [
            '申請編號',
            '第一優先選擇',
            '第二優先選擇',
            '第三優先選擇',
            '姓名(中文)',
            '姓名(英文)',
            '住宅電話',
            '手提電話',
            '居住地址',
            '單位面積(平方呎)',
            '電郵地址',
            '現時居住房屋種類',
            '其他(請註明)',
            '私人樓宇種類',
            '同住房屋種類',
            '其他(請註明)',
            '過去3個月的平均租金(不包括水電費)',
            '已居於目前單位(年)',
            '已居於目前單位(月)',
            '家庭成員數目',
            '有沒有申請公屋',
            '公屋申請編號',
            '申請公屋地點',
            '申請公屋日期(年份)',
            '申請公屋日期(月)',
            '申請公屋日期(日)',
            '申請人 - 性別',
            '申請人 - 出生日期(日/月/年)',
            '申請人 - 身份證明文件類別',
            '申請人 - 身份證明文件號碼',
            '申請人 - 婚姻狀況',
            '申請人 - 長期病患(請說明)',
            '申請人 - 工作狀況',
            '申請人 - 職業',
            '申請人 - 過去3個月每月平均收入',
            '申請人 - 現正領取的政府資助 > 綜合社會保障援助 (綜援)',
            '申請人 - 現正領取的政府資助 > 高齡津貼',
            '申請人 - 現正領取的政府資助 > 長者生活津貼',
            '申請人 - 現正領取的政府資助 > 傷殘津貼(包括普通和高額津貼)',
            '申請人 - 現正領取的政府資助 > 半額及全額書簿津貼',
            '申請人 - 現正領取的政府資助 > 其他',
            '申請人 - 資助總額',
            '申請人 - 個人資產(需遞交相關證明文件)',
            '申請人 - 個人資產種類',
            '申請人 - 個人資產總值',
            '申請人 - 存款/現金',
            '家庭成員 1 - 中文姓名',
            '家庭成員 1 - 英文姓名',
            '家庭成員 1 - 性別',
            '家庭成員 1 - 出生日期(日/月/年)',
            '家庭成員 1 - 身份證明文件類別',
            '家庭成員 1 - 身份證明文件號碼',
            '家庭成員 1 - 與申請人關係',
            '家庭成員 1 - 婚姻狀況',
            '家庭成員 1 - 長期病患(請說明)',
            '家庭成員 1 - 是否特殊學習需要兒童',
            '家庭成員 1 - 工作狀況',
            '家庭成員 1 - 職業',
            '家庭成員 1 - 過去3個月每月平均收入',
            '家庭成員 1 - 現正領取的政府資助 > 綜合社會保障援助 (綜援)',
            '家庭成員 1 - 現正領取的政府資助 > 高齡津貼',
            '家庭成員 1 - 現正領取的政府資助 > 長者生活津貼',
            '家庭成員 1 - 現正領取的政府資助 > 傷殘津貼(包括普通和高額津貼)',
            '家庭成員 1 - 現正領取的政府資助 > 半額及全額書簿津貼',
            '家庭成員 1 - 現正領取的政府資助 > 其他',
            '家庭成員 1 - 資助總額',
            '家庭成員 1 - 個人資產(需遞交相關證明文件)',
            '家庭成員 1 - 個人資產種類',
            '家庭成員 1 - 個人資產總值',
            '家庭成員 1 - 存款/現金',
            '家庭成員 2 - 中文姓名',
            '家庭成員 2 - 英文姓名',
            '家庭成員 2 - 性別',
            '家庭成員 2 - 出生日期(日/月/年)',
            '家庭成員 2 - 身份證明文件類別',
            '家庭成員 2 - 身份證明文件號碼',
            '家庭成員 2 - 與申請人關係',
            '家庭成員 2 - 婚姻狀況',
            '家庭成員 2 - 長期病患(請說明)',
            '家庭成員 2 - 是否特殊學習需要兒童',
            '家庭成員 2 - 工作狀況',
            '家庭成員 2 - 職業',
            '家庭成員 2 - 過去3個月每月平均收入',
            '家庭成員 2 - 現正領取的政府資助 > 綜合社會保障援助 (綜援)',
            '家庭成員 2 - 現正領取的政府資助 > 高齡津貼',
            '家庭成員 2 - 現正領取的政府資助 > 長者生活津貼',
            '家庭成員 2 - 現正領取的政府資助 > 傷殘津貼(包括普通和高額津貼)',
            '家庭成員 2 - 現正領取的政府資助 > 半額及全額書簿津貼',
            '家庭成員 2 - 現正領取的政府資助 > 其他',
            '家庭成員 2 - 資助總額',
            '家庭成員 2 - 個人資產(需遞交相關證明文件)',
            '家庭成員 2 - 個人資產種類',
            '家庭成員 2 - 個人資產總值',
            '家庭成員 2 - 存款/現金',
            '家庭成員 3 - 中文姓名',
            '家庭成員 3 - 英文姓名',
            '家庭成員 3 - 性別',
            '家庭成員 3 - 出生日期(日/月/年)',
            '家庭成員 3 - 身份證明文件類別',
            '家庭成員 3 - 身份證明文件號碼',
            '家庭成員 3 - 與申請人關係',
            '家庭成員 3 - 婚姻狀況',
            '家庭成員 3 - 長期病患(請說明)',
            '家庭成員 3 - 是否特殊學習需要兒童',
            '家庭成員 3 - 工作狀況',
            '家庭成員 3 - 職業',
            '家庭成員 3 - 過去3個月每月平均收入',
            '家庭成員 3 - 現正領取的政府資助 > 綜合社會保障援助 (綜援)',
            '家庭成員 3 - 現正領取的政府資助 > 高齡津貼',
            '家庭成員 3 - 現正領取的政府資助 > 長者生活津貼',
            '家庭成員 3 - 現正領取的政府資助 > 傷殘津貼(包括普通和高額津貼)',
            '家庭成員 3 - 現正領取的政府資助 > 半額及全額書簿津貼',
            '家庭成員 3 - 現正領取的政府資助 > 其他',
            '家庭成員 3 - 資助總額',
            '家庭成員 3 - 個人資產(需遞交相關證明文件)',
            '家庭成員 3 - 個人資產種類',
            '家庭成員 3 - 個人資產總值',
            '家庭成員 3 - 存款/現金',
            '家庭成員 4 - 中文姓名',
            '家庭成員 4 - 英文姓名',
            '家庭成員 4 - 性別',
            '家庭成員 4 - 出生日期(日/月/年)',
            '家庭成員 4 - 身份證明文件類別',
            '家庭成員 4 - 身份證明文件號碼',
            '家庭成員 4 - 與申請人關係',
            '家庭成員 4 - 婚姻狀況',
            '家庭成員 4 - 長期病患(請說明)',
            '家庭成員 4 - 是否特殊學習需要兒童',
            '家庭成員 4 - 工作狀況',
            '家庭成員 4 - 職業',
            '家庭成員 4 - 過去3個月每月平均收入',
            '家庭成員 4 - 現正領取的政府資助 > 綜合社會保障援助 (綜援)',
            '家庭成員 4 - 現正領取的政府資助 > 高齡津貼',
            '家庭成員 4 - 現正領取的政府資助 > 長者生活津貼',
            '家庭成員 4 - 現正領取的政府資助 > 傷殘津貼(包括普通和高額津貼)',
            '家庭成員 4 - 現正領取的政府資助 > 半額及全額書簿津貼',
            '家庭成員 4 - 現正領取的政府資助 > 其他',
            '家庭成員 4 - 資助總額',
            '家庭成員 4 - 個人資產(需遞交相關證明文件)',
            '家庭成員 4 - 個人資產種類',
            '家庭成員 4 - 個人資產總值',
            '家庭成員 4 - 存款/現金',
            '家庭成員 5 - 中文姓名',
            '家庭成員 5 - 英文姓名',
            '家庭成員 5 - 性別',
            '家庭成員 5 - 出生日期(日/月/年)',
            '家庭成員 5 - 身份證明文件類別',
            '家庭成員 5 - 身份證明文件號碼',
            '家庭成員 5 - 與申請人關係',
            '家庭成員 5 - 婚姻狀況',
            '家庭成員 5 - 長期病患(請說明)',
            '家庭成員 5 - 是否特殊學習需要兒童',
            '家庭成員 5 - 工作狀況',
            '家庭成員 5 - 職業',
            '家庭成員 5 - 過去3個月每月平均收入',
            '家庭成員 5 - 現正領取的政府資助 > 綜合社會保障援助 (綜援)',
            '家庭成員 5 - 現正領取的政府資助 > 高齡津貼',
            '家庭成員 5 - 現正領取的政府資助 > 長者生活津貼',
            '家庭成員 5 - 現正領取的政府資助 > 傷殘津貼(包括普通和高額津貼)',
            '家庭成員 5 - 現正領取的政府資助 > 半額及全額書簿津貼',
            '家庭成員 5 - 現正領取的政府資助 > 其他',
            '家庭成員 5 - 資助總額',
            '家庭成員 5 - 個人資產(需遞交相關證明文件)',
            '家庭成員 5 - 個人資產種類',
            '家庭成員 5 - 個人資產總值',
            '家庭成員 5 - 存款/現金',
            '單親家庭',
            '家庭成員懷孕滿16週或上',
            '懷孕週期',
            '過去3個月申請人及家庭成員總收入',
            '過去3個月政府資助總額',
            '家庭總資產淨值',
            '機構轉介 - 轉介社工姓名',
            '機構轉介 - 聯絡電話',
            '機構轉介 - 電郵',
        ];
  
        $excel_headers = [
            $row_header,
        ];

        foreach ($excel_headers as $excel_header) {
            $objPHPExcelActiveSheet->fromArray($excel_header, null, $col_no.($row_no++));
        }

        $col_no = 'A';
        $row_no = '1';

        $application_model = Application::find()->all();

        foreach($application_model as $model){
            // $priority_1           = $this->convertToValue($model->priority_1, Definitions::getProjectName());
            // $priority_2           = $this->convertToValue($model->priority_2, Definitions::getProjectName());
            // $priority_3           = $this->convertToValue($model->priority_3, Definitions::getProjectName());
            $priority_1           = Definitions::getProjectName($model->priority_1);
            $priority_2           = Definitions::getProjectName($model->priority_2);
            $priority_3           = Definitions::getProjectName($model->priority_3);
            $house_type           = $this->convertToValue($model->house_type, Definitions::getHouseType());
            $private_type         = $this->convertToValue($model->private_type, Definitions::getPrivateType());
            $together_type        = $this->convertToValue($model->together_type, Definitions::getTogetherType());
            $live_year            = $this->convertToValue($model->live_year, Definitions::getLiveYear());
            $live_month           = $this->convertToValue($model->live_month, Definitions::getLiveMonth());
            $prh                  = $this->convertToValue($model->prh, Definitions::getPrh());
            $prh_location         = $this->convertToValue($model->prh_location, Definitions::getPrhLocation());
            $app_gender           = $this->convertToValue($model->app_gender, Definitions::getGender());
            $app_id_type          = $this->convertToValue($model->app_id_type, Definitions::getIdType());
            $app_marriage_status  = $this->convertToValue($model->app_marriage_status, Definitions::getMarriageStatus());
            $app_working_status   = $this->convertToValue($model->app_working_status, Definitions::getWorkingStatus());

            $app_funding_types    = $this->convertToMultiValue($model->app_funding_type, Definitions::getFundingType());

            $app_funding_type_1   = $this->convertToValue($app_funding_types[0], Definitions::getFundingType2());
            $app_funding_type_2   = $this->convertToValue($app_funding_types[1], Definitions::getFundingType2());
            $app_funding_type_3   = $this->convertToValue($app_funding_types[2], Definitions::getFundingType2());
            $app_funding_type_4   = $this->convertToValue($app_funding_types[3], Definitions::getFundingType2());
            $app_funding_type_5   = $this->convertToValue($app_funding_types[4], Definitions::getFundingType2());
            $app_funding_type_6   = $this->convertToValue($app_funding_types[5], Definitions::getFundingType2());

            $app_asset            = $this->convertToValue($model->app_asset, Definitions::getAsset());
            $m1_gender            = $this->convertToValue($model->m1_gender, Definitions::getGender());
            $m1_id_type           = $this->convertToValue($model->m1_id_type, Definitions::getIdType());
            $m1_marriage_status   = $this->convertToValue($model->m1_marriage_status, Definitions::getMarriageStatus());
            $m1_special_study     = $this->convertToValue($model->m1_special_study, [0 => '否', 1 => '是']);
            $m1_working_status    = $this->convertToValue($model->m1_working_status, Definitions::getWorkingStatus());

            $m1_funding_types     = $this->convertToMultiValue($model->m1_funding_type, Definitions::getFundingType());

            $m1_funding_type_1    = $this->convertToValue($m1_funding_types[0], Definitions::getFundingType2());
            $m1_funding_type_2    = $this->convertToValue($m1_funding_types[1], Definitions::getFundingType2());
            $m1_funding_type_3    = $this->convertToValue($m1_funding_types[2], Definitions::getFundingType2());
            $m1_funding_type_4    = $this->convertToValue($m1_funding_types[3], Definitions::getFundingType2());
            $m1_funding_type_5    = $this->convertToValue($m1_funding_types[4], Definitions::getFundingType2());
            $m1_funding_type_6    = $this->convertToValue($m1_funding_types[5], Definitions::getFundingType2());

            $m1_asset             = $this->convertToValue($model->m1_asset, Definitions::getAsset());

            $m2_gender            = $this->convertToValue($model->m2_gender, Definitions::getGender());
            $m2_id_type           = $this->convertToValue($model->m2_id_type, Definitions::getIdType());
            $m2_marriage_status   = $this->convertToValue($model->m2_marriage_status, Definitions::getMarriageStatus());
            $m2_special_study     = $this->convertToValue($model->m2_special_study, [0 => '否', 1 => '是']);
            $m2_working_status    = $this->convertToValue($model->m2_working_status, Definitions::getWorkingStatus());

            $m2_funding_types     = $this->convertToMultiValue($model->m2_funding_type, Definitions::getFundingType());

            $m2_funding_type_1    = $this->convertToValue($m2_funding_types[0], Definitions::getFundingType2());
            $m2_funding_type_2    = $this->convertToValue($m2_funding_types[1], Definitions::getFundingType2());
            $m2_funding_type_3    = $this->convertToValue($m2_funding_types[2], Definitions::getFundingType2());
            $m2_funding_type_4    = $this->convertToValue($m2_funding_types[3], Definitions::getFundingType2());
            $m2_funding_type_5    = $this->convertToValue($m2_funding_types[4], Definitions::getFundingType2());
            $m2_funding_type_6    = $this->convertToValue($m2_funding_types[5], Definitions::getFundingType2());

            $m2_asset             = $this->convertToValue($model->m2_asset, Definitions::getAsset());

            $m3_gender            = $this->convertToValue($model->m3_gender, Definitions::getGender());
            $m3_id_type           = $this->convertToValue($model->m3_id_type, Definitions::getIdType());
            $m3_marriage_status   = $this->convertToValue($model->m3_marriage_status, Definitions::getMarriageStatus());
            $m3_special_study     = $this->convertToValue($model->m3_special_study, [0 => '否', 1 => '是']);
            $m3_working_status    = $this->convertToValue($model->m3_working_status, Definitions::getWorkingStatus());

            $m3_funding_types     = $this->convertToMultiValue($model->m3_funding_type, Definitions::getFundingType());

            $m3_funding_type_1    = $this->convertToValue($m3_funding_types[0], Definitions::getFundingType2());
            $m3_funding_type_2    = $this->convertToValue($m3_funding_types[1], Definitions::getFundingType2());
            $m3_funding_type_3    = $this->convertToValue($m3_funding_types[2], Definitions::getFundingType2());
            $m3_funding_type_4    = $this->convertToValue($m3_funding_types[3], Definitions::getFundingType2());
            $m3_funding_type_5    = $this->convertToValue($m3_funding_types[4], Definitions::getFundingType2());
            $m3_funding_type_6    = $this->convertToValue($m3_funding_types[5], Definitions::getFundingType2());

            $m3_asset             = $this->convertToValue($model->m3_asset, Definitions::getAsset());

            $m4_gender            = $this->convertToValue($model->m4_gender, Definitions::getGender());
            $m4_id_type           = $this->convertToValue($model->m4_id_type, Definitions::getIdType());
            $m4_marriage_status   = $this->convertToValue($model->m4_marriage_status, Definitions::getMarriageStatus());
            $m4_special_study     = $this->convertToValue($model->m4_special_study, [0 => '否', 1 => '是']);
            $m4_working_status    = $this->convertToValue($model->m4_working_status, Definitions::getWorkingStatus());

            $m4_funding_types     = $this->convertToMultiValue($model->m4_funding_type, Definitions::getFundingType());

            $m4_funding_type_1    = $this->convertToValue($m4_funding_types[0], Definitions::getFundingType2());
            $m4_funding_type_2    = $this->convertToValue($m4_funding_types[1], Definitions::getFundingType2());
            $m4_funding_type_3    = $this->convertToValue($m4_funding_types[2], Definitions::getFundingType2());
            $m4_funding_type_4    = $this->convertToValue($m4_funding_types[3], Definitions::getFundingType2());
            $m4_funding_type_5    = $this->convertToValue($m4_funding_types[4], Definitions::getFundingType2());
            $m4_funding_type_6    = $this->convertToValue($m4_funding_types[5], Definitions::getFundingType2());

            $m4_asset             = $this->convertToValue($model->m4_asset, Definitions::getAsset());

            $m5_gender            = $this->convertToValue($model->m5_gender, Definitions::getGender());
            $m5_id_type           = $this->convertToValue($model->m5_id_type, Definitions::getIdType());
            $m5_marriage_status   = $this->convertToValue($model->m5_marriage_status, Definitions::getMarriageStatus());
            $m5_special_study     = $this->convertToValue($model->m5_special_study, [0 => '否', 1 => '是']);
            $m5_working_status    = $this->convertToValue($model->m5_working_status, Definitions::getWorkingStatus());

            $m5_funding_types     = $this->convertToMultiValue($model->m5_funding_type, Definitions::getFundingType());

            $m5_funding_type_1    = $this->convertToValue($m5_funding_types[0], Definitions::getFundingType2());
            $m5_funding_type_2    = $this->convertToValue($m5_funding_types[1], Definitions::getFundingType2());
            $m5_funding_type_3    = $this->convertToValue($m5_funding_types[2], Definitions::getFundingType2());
            $m5_funding_type_4    = $this->convertToValue($m5_funding_types[3], Definitions::getFundingType2());
            $m5_funding_type_5    = $this->convertToValue($m5_funding_types[4], Definitions::getFundingType2());
            $m5_funding_type_6    = $this->convertToValue($m5_funding_types[5], Definitions::getFundingType2());

            $m5_asset             = $this->convertToValue($model->m5_asset, Definitions::getAsset());

            $single_parents       = $this->convertToValue($model->single_parents, Definitions::getSingleParents());
            $pregnant             = $this->convertToValue($model->pregnant, Definitions::getPregnant());

            $excel_row = [
                $model->appl_no,
                $priority_1,
                $priority_2,
                $priority_3,
                $model->chi_name,
                $model->eng_name,
                $model->phone,
                $model->mobile,
                $model->address,
                $model->area,
                $model->email,
                $house_type,
                $model->house_type_other,
                $private_type,
                $together_type,
                $model->together_type_other,
                $model->live_rent,
                $live_year,
                $live_month,
                $model->family_member,
                $prh,
                $model->prh_no,
                $prh_location,
                $model->apply_prh_year,
                $model->apply_prh_month,
                $model->apply_prh_day,
                $app_gender,
                $model->app_born_date,
                $app_id_type,
                $model->app_id_no,
                $app_marriage_status,
                $model->app_chronic_patient,
                $app_working_status,
                $model->app_career,
                $model->app_income,
                $app_funding_type_1,
                $app_funding_type_2,
                $app_funding_type_3,
                $app_funding_type_4,
                $app_funding_type_5,
                $app_funding_type_6,
                $model->app_funding_value,
                $app_asset,
                $model->app_asset_type,
                $model->app_asset_value,
                $model->app_deposit,
                $model->m1_chi_name,
                $model->m1_eng_name,
                $m1_gender,
                $model->m1_born_date,
                $m1_id_type,
                $model->m1_id_no,
                $model->m1_relationship,
                $m1_marriage_status,
                $model->m1_chronic_patient,
                $m1_special_study,
                $m1_working_status,
                $model->m1_career,
                $model->m1_income,
                $m1_funding_type_1,
                $m1_funding_type_2,
                $m1_funding_type_3,
                $m1_funding_type_4,
                $m1_funding_type_5,
                $m1_funding_type_6,
                $model->m1_funding_value,
                $m1_asset,
                $model->m1_asset_type,
                $model->m1_asset_value,
                $model->m1_deposit,
                $model->m2_chi_name,
                $model->m2_eng_name,
                $m2_gender,
                $model->m2_born_date,
                $m2_id_type,
                $model->m2_id_no,
                $model->m2_relationship,
                $m2_marriage_status,
                $model->m2_chronic_patient,
                $m2_special_study,
                $m2_working_status,
                $model->m2_career,
                $model->m2_income,
                $m2_funding_type_1,
                $m2_funding_type_2,
                $m2_funding_type_3,
                $m2_funding_type_4,
                $m2_funding_type_5,
                $m2_funding_type_6,
                $model->m2_funding_value,
                $m2_asset,
                $model->m2_asset_type,
                $model->m2_asset_value,
                $model->m2_deposit,
                $model->m3_chi_name,
                $model->m3_eng_name,
                $m3_gender,
                $model->m3_born_date,
                $m3_id_type,
                $model->m3_id_no,
                $model->m3_relationship,
                $m3_marriage_status,
                $model->m3_chronic_patient,
                $m3_special_study,
                $m3_working_status,
                $model->m3_career,
                $model->m3_income,
                $m3_funding_type_1,
                $m3_funding_type_2,
                $m3_funding_type_3,
                $m3_funding_type_4,
                $m3_funding_type_5,
                $m3_funding_type_6,
                $model->m3_funding_value,
                $m3_asset,
                $model->m3_asset_type,
                $model->m3_asset_value,
                $model->m3_deposit,
                $model->m4_chi_name,
                $model->m4_eng_name,
                $m4_gender,
                $model->m4_born_date,
                $m4_id_type,
                $model->m4_id_no,
                $model->m4_relationship,
                $m4_marriage_status,
                $model->m4_chronic_patient,
                $m4_special_study,
                $m4_working_status,
                $model->m4_career,
                $model->m4_income,
                $m4_funding_type_1,
                $m4_funding_type_2,
                $m4_funding_type_3,
                $m4_funding_type_4,
                $m4_funding_type_5,
                $m4_funding_type_6,
                $model->m4_funding_value,
                $m4_asset,
                $model->m4_asset_type,
                $model->m4_asset_value,
                $model->m4_deposit,
                $model->m5_chi_name,
                $model->m5_eng_name,
                $m5_gender,
                $model->m5_born_date,
                $m5_id_type,
                $model->m5_id_no,
                $model->m5_relationship,
                $m5_marriage_status,
                $model->m5_chronic_patient,
                $m5_special_study,
                $m5_working_status,
                $model->m5_career,
                $model->m5_income,
                $m5_funding_type_1,
                $m5_funding_type_2,
                $m5_funding_type_3,
                $m5_funding_type_4,
                $m5_funding_type_5,
                $m5_funding_type_6,
                $model->m5_funding_value,
                $m5_asset,
                $model->m5_asset_type,
                $model->m5_asset_value,
                $model->m5_deposit,
                $single_parents,
                $pregnant,
                $model->pregnant_period,
                $model->total_income,
                $model->total_funding,
                $model->total_asset,
                $model->social_worker_name,
                $model->social_worker_phone,
                $model->social_worker_email,
            ];

            $objPHPExcelActiveSheet->fromArray($excel_row, null, $col_no.(++$row_no));          
        }

        $objPHPExcel->setActiveSheetIndex(0);
  
        $objPHPExcelActiveSheet = $objPHPExcel->getSheet(0);
        $objPHPExcelActiveSheet->getStyle('A1');
  
        $filename = 'LST_申請表_'.date('Ymd_His').'.xlsx';
        $writer = IOFactory::createWriter($objPHPExcel, "Xlsx");
        $temp_file = tempnam(sys_get_temp_dir(), 'PhpSpreadsheet');
        $writer->save($temp_file);
  
        Yii::$app->response->sendFile($temp_file, $filename, ['mimeType' => FileHelper::getMimeTypeByExtension($filename)]);
    }

    public function convertToValue ($db_data, $arr)
    {
      $data = trim($db_data) ? $arr[$db_data] : null;

      return $data;
    }

    public function convertToMultiValue ($db_data, $arr)
    {
        // $db_datum = $db_data ? json_ecode($db_data) : [];

        $data = [];
        foreach ($arr as $k => $v) {
            // if (in_array($k, $db_datum)) {
            if (in_array($k, $db_data)) {
                array_push($data, 1);
            } else {
                array_push($data, 2);
            }
        }

        return $data;
    }    
}
