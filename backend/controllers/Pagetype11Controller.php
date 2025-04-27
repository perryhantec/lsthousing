<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use kartik\grid\EditableColumnAction;
use backend\models\PageType11Search;
use backend\models\PageType11Form;
use common\models\PageType11;
// use common\models\PageType4Category;
// use backend\models\PageType4CategorySearch;
use common\models\Definitions;
use common\models\Menu;
use yii\imagine\Image;
use yii\imagine\BaseImage;


class Pagetype11Controller extends Controller
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
                    'actions' => ['index', 'create', 'update', 'delete', 'enabled', 'disabled', 'category', 'category_create', 'category_update', 'category_delete'],
                      'allow' => true,
                      'roles' => ['page.newProject'],
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

//Page Type4
    // public function actionIndex($id)
    public function actionIndex()
    {
      // $menu_model = $this->findMenu($id);
      // Yii::$app->params['MID'] = $menu_model->id;

/*
      $models = Pagetype4::find()->where(['>', 'id', '130'])->all();
      foreach ($models as $model) {
          $files = explode('|', $model->file_names);
          $file_names = [];
          if (sizeof($files) == 0 || $files[0] == "")
            continue;
        foreach($files as $file) {
            $file_data = explode(':', $file);
            $filename_path = '/home/lstweb/from_old/news_photo/'.$file_data[0];
            $filename_display = $file_data[1];
            if (!file_exists($filename_path))
                continue;
            $_filename = Yii::$app->security->generateRandomString(32) . '_' . time().'.'.pathinfo($filename_path, PATHINFO_EXTENSION);

            Image::thumbnail($filename_path, null, 180)
                ->save($model->fileThumbPath.$_filename, ['quality' => 100]);

            copy($filename_path, $model->filePath.$_filename);

            $file_names[$_filename] = pathinfo($filename_display, PATHINFO_FILENAME);
        }
        $model->image_file_name = json_encode($file_names, JSON_UNESCAPED_UNICODE);

        $model->save(false);

      }
*/
/*
      $models = Pagetype4::find()->where(['>', 'id', '130'])->andWhere(['image_file_name' => null])->all();
      foreach ($models as $model) {
            if ($model->file_names == "" || sizeof($model->picture_file_names) == 0)
                continue;
            $_picture_file_names = $model->picture_file_names;
            reset($_picture_file_names);
            $_image = $model->fileThumbPath.key($_picture_file_names);

            $_image_filename = $model->id.'.'.pathinfo($_image, PATHINFO_EXTENSION);
            $_image_file_path = $model->imagePath . '/' . $_image_filename;

            $model->image_file_name = $model->imageDisplayPath.$_image_filename.'?'.time();

            $image = Image::getImagine()->open($_image);
            $imageSize = getimagesize($_image);

            if ($imageSize[0] < $model::IMAGE_FILE_MAX_WIDTH && $imageSize[1] < $model::IMAGE_FILE_MAX_HEIGHT) {
                copy($_image, $_image_file_path);

            } else {
                if ($imageSize[0] > $imageSize[1]) {
                    $newSizeImage = new Box($model::IMAGE_FILE_MAX_WIDTH, floor(($imageSize[1] / $imageSize[0]) * $model::IMAGE_FILE_MAX_WIDTH));
                } else {
                    $newSizeImage = new Box(floor(($imageSize[0] / $imageSize[1]) * $model::IMAGE_FILE_MAX_HEIGHT), $model::IMAGE_FILE_MAX_HEIGHT);
                }
                $image->resize($newSizeImage)
                    ->save($_image_file_path, ['quality' => 100]);
            }

            $model->save(false);

      }
*/

      $searchModel = new PageType11Search();
      // $searchModel->MID = $menu_model->id;
      $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

      // if ($searchModel->load(Yii::$app->request->post()) && $searchModel->saveContent()) {
      //     return $this->redirect(['index','id'=>$id]);
      // }
      return $this->render('index', [
          'searchModel' => $searchModel,
          'dataProvider' => $dataProvider,
      ]);
    }

    public function actionCreate()
    {
      // $model = new PageType11Form();
      $menu_model = Menu::findOne(['url' => 'lst-housing-new-project']);
      $model = new PageType11();
      $model->MID = $menu_model->id;

      if ($model->load(Yii::$app->request->post())) {
          $model->image_file = \yii\web\UploadedFile::getInstance($model, 'image_file');
          
          if ($model->saveContent()) {
                Yii::$app->adminLog->insert(Yii::t('log', 'Add {record} to {model}', ['record' => '樂屋新建案 [#'.$model->id.']', 'model' => '樂屋新建案']));

              return $this->redirect(['index']);
          }
      }
      return $this->render('edit', [
          'model' => $model,
      ]);

    }

    public function actionUpdate($id)
    {
      $menu_model = Menu::findOne(['url' => 'lst-housing-new-project']);
      $model = $this->findModelForm($id);
      $model->MID = $menu_model->id;

      if ($model->load(Yii::$app->request->post())) {
          $model->image_file = \yii\web\UploadedFile::getInstance($model, 'image_file');

          if ($model->saveContent()) {
              Yii::$app->adminLog->insert(Yii::t('log', 'Update {record} of {model}', ['record' => '樂屋新建案 [#'.$model->id.']', 'model' => '樂屋新建案']));
              return $this->redirect(['index']);
          }
      }
      return $this->render('edit', [
            'model' => $model,
        ]);

    }

    public function actionDelete($id)
    {
      $model = $this->findModel($id);
      $model->delete();

        Yii::$app->adminLog->insert(Yii::t('log', 'Delete {record} of {model}', ['record' => '樂屋新建案 [#'.$model->id.']', 'model' => '樂屋新建案']));

      return $this->redirect(['index']);

    }

    public function actionEnabled($id)
    {
        $model = $this->findModel($id);

        $model->status = 1;
        $model->save();

        Yii::$app->adminLog->insert(Yii::t('log', 'Enable {record} of {model}', ['record' => '樂屋新建案 [#'.$model->id.']', 'model' => '樂屋新建案']));
        
        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionDisabled($id)
    {
        $model = $this->findModel($id);

        $model->status = 0;
        $model->save();

        Yii::$app->adminLog->insert(Yii::t('log', 'Disable {record} of {model}', ['record' => '樂屋新建案 [#'.$model->id.']', 'model' => '樂屋新建案']));

        return $this->redirect(Yii::$app->request->referrer);
    }

    //category
    // public function actionCategory($id)
    // {
    //   $menu_model = $this->findMenu($id);
    //   Yii::$app->params['MID'] = $menu_model->id;

    //   $searchModel = new PageType4CategorySearch;
    //   $searchModel->MID = $menu_model->id;
    //   $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

    //   return $this->render('category', [
    //       'searchModel' => $searchModel,
    //       'dataProvider' => $dataProvider,
    //   ]);

    // }
    // public function actionCategory_create($id)
    // {
    //   $menu_model = $this->findMenu($id);
    //   Yii::$app->params['MID'] = $menu_model->id;

    //   $model = new PageType4Category;
    //   $model->MID = $menu_model->id;

    //   if ($model->load(Yii::$app->request->post()) && $model->save()) {
    //       Yii::$app->adminLog->insert(Yii::t('log', 'Add {record} to {model}', ['record' => $model->name.('[#'.$model->id.']'), 'model' => Yii::t('app', 'Category')]), $menu_model->id);

    //       return $this->redirect(['category','id'=>$id]);
    //   }
    //   return $this->render('category_edit', [
    //       'model' => $model,
    //   ]);
    // }

    // public function actionCategory_update($id)
    // {
    //   $model = $this->findPageType4Category($id);
    //   Yii::$app->params['MID'] = $model->MID;

    //   $MID = $model->MID;

    //   if ($model->load(Yii::$app->request->post()) && $model->save()) {
    //       Yii::$app->adminLog->insert(Yii::t('log', 'Update {record} of {model}', ['record' => $model->name.('[#'.$model->id.']'), 'model' => Yii::t('app', 'Category')]), $model->menu->id);

    //       return $this->redirect(['category','id'=>$MID]);
    //   }
    //   return $this->render('category_edit', [
    //         'model' => $model,
    //     ]);
    // }

    // public function actionCategory_delete($id)
    // {
    //   $model = $this->findPageType4Category($id);

    //   $MID = $model->MID;
    //   $model->delete();

    //   Yii::$app->adminLog->insert(Yii::t('log', 'Delete {record} of {model}', ['record' => $model->name.('[#'.$model->id.']'), 'model' => Yii::t('app', 'Category')]), $model->menu->id);

    //   return $this->redirect(['category', 'id'=>$MID]);

    // }

    public function actionReorder($id=NULL)
    {
    $model = new \backend\models\PageType11Reorder;
    // $model->category_id = $id;
    $model->setContent();

    if ($model->load(Yii::$app->request->post())  && $model->saveContent()) {
        Yii::$app->adminLog->insert(Yii::t('log', 'Update {record} of {model}', ['record' => Yii::t('log', 'Order'), 'model' => '樂屋新建案']));

        return $this->redirect(['index']);
    }else{
        return $this->renderAjax('reorder', [
            'model' => $model,
        ]);
    }
    }
    
    protected function findModel($id)
    {
        if (($model = PageType11::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function findModelForm($id)
    {
        // if (($model = PageType11Form::findOne($id)) !== null) {
        if (($model = PageType11::findOne($id)) !== null) {
            if (!\backend\components\AccessRule::checkRole(['page.allpages', 'page.'.$model->id]))
                throw new \yii\web\ForbiddenHttpException(Yii::t('yii', 'You are not allowed to perform this action.'));

            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    // private function findPageType4Category($id) {
    //     $model = PageType4Category::findOne($id);

    //     if ($model == null)
    //         throw new \yii\web\NotFoundHttpException();

    //     if (!\backend\components\AccessRule::checkRole(['page.'.$model->MID, 'page.allpages']))
    //         throw new \yii\web\ForbiddenHttpException(Yii::t('yii', 'You are not allowed to perform this action.'));

    //     return $model;
    // }
}
