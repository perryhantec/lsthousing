<?php

namespace backend\controllers;

use Yii;
use common\models\Application;
use common\models\ApplicationResponseFiles;
use common\models\Definitions;
use common\models\File;
use backend\models\ApplicationResponseFilesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use kartik\grid\EditableColumnAction;

class ApplicationResponseFilesController extends Controller
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
                    'actions' => ['index', 'create', 'update', 'view', 'download'],
                      'allow' => true,
                      'roles' => ['user'],
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
    public function actions()
    {
        return ArrayHelper::merge(parent::actions(), []);
    }


    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex($id = false)
    {
        $searchModel = new ApplicationResponseFilesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $id);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'aid' => $id,
        ]);
    }

    // public function actionCreate($aid)
    // {
    //     $model = new ApplicationResponseFiles();

    //     // if ($model->load(Yii::$app->request->post()) && $model->save()) {
    //     // if ($model->load(Yii::$app->request->post()) && $model->submit()) {
    //     if ($model->load(Yii::$app->request->post()) && $model->validate()) {
    //         $model->submit();
    //         // $model->application->sendSubmittedEmail(2);

    //         Yii::$app->adminLog->insert(Yii::t('log', 'Add {record} to {model}', ['record' => $model->application->appl_no.('[#'.$model->id.']'), 'model' => '要求上載文件']));

    //         return $this->redirect(['view', 'id' => $model->id]);
    //     } else {
    //         return $this->render('edit', [
    //             'model' => $model,
    //             'aid' => $aid,
    //         ]);
    //     }
    // }

    // public function actionView($id)
    // {
    //     return $this->render('view', [
    //         'model' => $this->findModel($id),
    //     ]);
    // }

    public function actionDownload($id)
    {
        $zip = new \ZipArchive();

        $zip_path = '../../content/response/'.$id;

        if (!file_exists($zip_path)){
            if (!mkdir($zip_path, 0777, true)) {
                throw new CHttpException(404, 'Directory create error!');
            }
        }

        $model = $this->findModel($id);
        $zip_file = $zip_path.'/'.$model->applicationRequestFiles->ref_code.'.zip';

        if ($zip->open($zip_file, \ZipArchive::CREATE | \ZipArchive::OVERWRITE) === TRUE) {
            $files = File::find()->where(['in', 'auth_key', $model->file_keys])->asArray()->all();

            foreach ($files as $file) {
              if (isset($file['filepath']) && $file['filepath'] != false) {
                $zip->addFile('../../content/files/'.$file['filepath'], $file['filename']);
              }
            } 

            $zip->close();

            $file = $zip_file;

            if (file_exists($file)) {
                header('Content-Description: File Transfer');
                header('Content-Type: application/octet-stream');
                header('Content-Disposition: attachment; filename="'.basename($file).'"');
                header('Expires: 0');
                header('Cache-Control: must-revalidate');
                header('Pragma: public');
                header('Content-Length: ' . filesize($file));
                readfile($file);
                exit;
            } else {
                echo 'file is not exist';
            }
        } else {
            echo 'failed';
        }
        return;
    }
    
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->submit()) {
            Yii::$app->adminLog->insert(Yii::t('log', 'Update {record} of {model}', ['record' => $model->application->appl_no.('[#'.$model->id.']'), 'model' => '已提交上載文件']));

            $results = json_decode($model->response_result, true);
            $all_pass = true;
            $alert = [];

            foreach ($results as $field => $result) {
                if ($result != 1) {
                    $all_pass = false;
                    $field = str_replace('s', '', $field);
                    $alert[] = $field.'-'.$result;
                }
            }

            $alert = implode('_',$alert);

            if (!$all_pass) {
                return $this->redirect(['application-request-files/create', 'aid' => $model->application_id, 'alert' => $alert]); 
            } else {
                return $this->redirect(['index', 'id' => $model->application_id]); 
            }

            // if ($model->application->application_status == Application::APPL_STATUS_REJECTED) {
            //     $model->sendSubmittedEmail(3);
            // }
            // TO DO: redirect to request files
            // return $this->redirect(['response-file-list']); 
        } else {
            return $this->render('edit', [
                'model' => $model,
            ]);
        }
    }

    protected function findModel($id)
    {
        if (($model = ApplicationResponseFiles::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
