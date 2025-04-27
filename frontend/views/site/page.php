<?php

/* @var $this yii\web\View */
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;
use yii\helpers\Html;
use common\models\Config;
use frontend\models\CreatePageMenu;
use frontend\models\CreatePageContent;

$this->title = strip_tags($model->name);

Yii::$app->params['page_route'] = $model->route;
Yii::$app->params['page_header_title'] = $model->name;

$_subMenus = $model->allSubMenu;
foreach ($_subMenus as $_subMenu) {
    Yii::$app->params['breadcrumbs'][] = strip_tags($_subMenu->name);
    if ($_subMenu->banner_image_file_name != "")
        Yii::$app->params['page_header_img'] = $_subMenu->banner_image_file_name;
}
if (sizeof($_subMenus) > 0)
    Yii::$app->params['page_header_title'] = $_subMenus[0]->name;
if ($model->banner_image_file_name != "")
    Yii::$app->params['page_header_img'] = $model->banner_image_file_name;

Yii::$app->params['breadcrumbs'][] = $this->title;

?>
    <?= Alert::widget() ?>
    <div class="row">
<?php if (sizeof($_subMenus) > 0) { ?>
        <div class="col-md-3">
            <?= $this->render('../layouts/_body_left_nav', ['menus' => $_subMenus[0]->getActiveSubMenu()->orderBy(['seq' => SORT_ASC])->all()]); ?>
        </div>
        <div class="col-md-9 has-sub-nav">
<?php } else { ?>
        <div class="col-sm-12">
<?php } ?>
            <div class="content">
                <?php // isset(Yii::$app->params['page_header_sub_title']) ? Html::tag('h3', Yii::$app->params['page_header_sub_title']) : '' ?>
                <?php
                    $page_type = $model->page_type;
                    $MID = $model->id;
                    // echo '<pre>';
                    // print_r($model);
                    // echo '</pre>';
                    // exit();
                    switch($page_type){
                        case 1:
                            echo $this->render('_page_type1',['MID'=>$MID]);
                            break;
                        case 2:
                            echo $this->render('_page_type2',['MID'=>$MID]);
                            break;
                        case 3:
                            echo $this->render('_page_type3',['MID'=>$MID, 'title' => $model->name]);
                            break;
                        case 4:
                            echo $this->render('_page_type4',['MID'=>$MID, 'title' => $model->name]);
                            break;
                        case 5:
                            echo $this->render('_page_type5',['MID'=>$MID, 'title' => $model->name]);
                            break;
                        case 7:
                            echo $this->render('_page_type7',['MID'=>$MID, 'title' => $model->name]);
                            break;
                        case 8:
                            echo $this->render('_page_type8',['MID'=>$MID, 'title' => $model->name]);
                            break;
                        case 9:
                            echo $this->render('_page_type9',['MID'=>$MID, 'title' => $model->name]);
                            break;
                        case 10:
                            echo $this->render('_page_type10',['MID'=>$MID, 'title' => $model->name]);
                            break;
                        case 11:
                            echo $this->render('_page_type11',['MID'=>$MID, 'title' => $model->name]);
                            break;
                        case 12:
                            echo $this->render('_page_type12',['MID'=>$MID, 'title' => $model->name]);
                            break;    
                    }
                ?>
            </div>
        </div>
    </div>
