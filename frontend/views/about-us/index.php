<?php

/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\helpers\Url;
use yii\captcha\Captcha;
use kartik\form\ActiveForm;
// use yii\widgets\ActiveForm;
use kartik\widgets\FileInput;
use common\widgets\Alert;
use common\models\Menu;
use common\models\Definitions;
use common\models\User;
use kartik\widgets\DatePicker;

// Yii::$app->params['page_header_img'] = '/images/page_header_img-donation.jpg';

$menu_model = Menu::findOne(['url' => 'about-us']);
$user_model = User::findOne(['id' => Yii::$app->user->id]);

if ($menu_model != null) {
    Yii::$app->params['page_route'] = $menu_model->route;
    $_subMenus = $menu_model->allSubMenu;

    $this->title = strip_tags($menu_model->name);
    Yii::$app->params['page_header_title'] = $menu_model->name;

    foreach ($_subMenus as $_subMenu) {
        Yii::$app->params['breadcrumbs'][] = strip_tags($_subMenu->name);
        if ($_subMenu->banner_image_file_name != "")
            Yii::$app->params['page_header_img'] = $_subMenu->banner_image_file_name;
    }
    if (sizeof($_subMenus) > 0)
        Yii::$app->params['page_header_title'] = $_subMenus[0]->name;

    Yii::$app->params['breadcrumbs'][] = $this->title;
}

$this->registerJs(<<<JS
let latest_left = $('#about-us li').length - 1 - 4;

$('.slider-nav').slick({
  slidesToShow: 5,
  slidesToScroll: 1,
//   asNavFor: '.slider-for',
//   dots: true,
//   centerMode: false,
//   focusOnSelect: false,
  infinite: false,
  arrows: true,
  //initialSlide: latest_left
});

$('#about-us li').on('click', function () {
    let index = $(this).index();
    $(this).closest('ul').find('li').each(function () {
        $(this).removeClass('active');
    })
    $(this).addClass('active');

    $(this).closest('ul').next().find('.description').each(function (i) {
        $(this).addClass('hidden');
        if (i == index) {
            $(this).removeClass('hidden');
        }
    });

    $(this).closest('ul').next().next().find('.images').each(function (i) {
        $(this).addClass('hidden');
        if (i == index) {
            $(this).removeClass('hidden');
        }
    });
});

JS
);

// $app_no = 'LSTH';

// $no_of_zero = User::APP_NO_ZERO - strlen(Yii::$app->user->id);

// echo User::APP_NO_ZERO.'<br />';
// echo Yii::$app->user->id.'<br />';
// echo $no_of_zero.'<br />';
// $app_no = str_pad($app_no, $no_of_zero, '0').Yii::$app->user->id;
// echo $app_no.'<br />';

$_labelSpan = Yii::$app->language == 'en' ? 4 : 3;
?>
    <div class="row">
<?php if (sizeof($_subMenus) > 0) { ?>
        <div class="col-md-3">
            <?= $this->render('../layouts/_body_left_nav', ['menus' => $_subMenus[0]->getActiveSubMenu()->orderBy(['seq' => SORT_ASC])->all()]); ?>
        </div>
        <div class="col-md-9 has-sub-nav">
<?php } else { ?>
        <div class="col-sm-12">
<?php } ?>
<style>
#about-us ul{list-style-type:none;padding:0;}
#about-us ul:after{display:table;content:'';clear:both;}
#about-us ul li{float:left;width:20%;text-align:center;cursor:pointer;}
#about-us .title{font-weight:bold;font-size:35px;margin:12px 0;}
#about-us .timeline{height:16px;position:relative;overflow:hidden;}
.tri-1{
    position:absolute;
    left:0;
    top:0;
    border:8px solid transparent;
    border-left:8px solid #FFF;
}
.tri-2{
    position:absolute;
    right:0;
    top:0;
    transform:translateX(50%);
    border:8px solid transparent;
    border-top:8px solid #FFF;
    border-bottom:8px solid #FFF;
}
.v-line{width:50%;height:45px;}
.active .v-line{height:150px;}
.icon{border-radius:50%;width:66px;height:66px;margin:0 auto;}
.icon img{width:50px;margin-top:12px;display:inline;}
.description{border-radius:20px;padding:5px 10px;}
.description p{margin:0;}
.images-area{margin-top:50px;}
@media (max-width:980px) {
    #about-us .title{font-size:25px;}  
}

.slick-prev:before, .slick-next:before {
    color: grey;
}
</style>
            <div id="about-us" class="application content">
                <h3><?= $menu_model->name ?></h3>

                <ul class="slider-nav">
                <?php 
                    $i = 0;
                    // $total = count($model) - 1;
                    foreach ($model as $about) { 
                        $active = ($i == 0) ? 'active' : '';
                ?>
                    <li class="<?= $active?>">
                        <div class="title" style="color:<?= $about->color ?>;"><?= $about->show_year ?></div>
                        <div class="timeline" style="background:<?= $about->color ?>;">
                            <div class="tri-1"></div>
                            <div class="tri-2"></div>
                        </div>
                        <div class="v-line" style="border-right:1px solid <?= $about->color ?>;"></div>
                        <div class="icon" style="border:1px solid <?= $about->color ?>;">
                            <?= Html::img($about->iconDisplayPath, ['alt'=>'']) ?>
                        </div>
                    </li>
                <?php 
                        $i++;
                    } 
                ?>
                </ul>

                <div>
                <?php 
                    $i = 0;        
                    foreach ($model as $about) { 
                        $hidden = ($i == 0) ? '' : 'hidden';
                ?>
                    <div class="description <?= $hidden ?>" style="border:1px solid <?= $about->color ?>;">
                        <?= $about->description ?>
                    </div>
                <?php 
                        $i++;
                    } 
                ?>
                </div>

                <div class="images-area">
                <?php
                    $i = 0;
                
                    foreach($model as $about) {
                        $hidden = ($i == 0) ? '' : 'hidden';

                        echo '<div class="images '.$hidden.'">';
                        foreach($about->picture_file_names as $file_name => $file_description) {
                            if ($i++ % 2 == 0)
                                echo '<div class="clearfix"></div>';
                            echo '<div class="col-sm-6"><p class="text-center">';
                            echo Html::a(Html::img($about->fileThumbDisplayPath.$file_name), $about->fileDisplayPath.$file_name, ['data' => ['fancybox' => "pageImages", 'caption' => $file_description]]);
                            echo '</p></div>';
                        }
                        echo '</div>';
                    }
                ?>
                </div>
            </div>
        </div>
    </div>