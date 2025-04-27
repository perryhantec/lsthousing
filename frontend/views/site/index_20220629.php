<?php

/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use common\models\General;
use common\models\Home;
use common\models\Definitions;

$model_general = General::findOne(1);
$this->title = $model_general->name;

$model_home = Home::findOne(1);
$model_home_content = ArrayHelper::map(Home::find()->where(['id' => [1]])->all(), 'id', 'content');
?>
<style>

</style>
<div class="site-index">
    <?= $this->render('_project_search_menu', []) ?>

    <section class="big-grids">
        <div>
            <ul>
                <li>
                    <a href="<?= Yii::getAlias('@web')?>/latest-news">
                        <div class="big-grid big-grid-1">
                            <div>
                                <img src="images/main1.jpg" />
                            </div>
                            <div class="big-grid-word">最新消息</div>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="<?= Yii::getAlias('@web')?>/housing-application">
                        <div class="big-grid big-grid-2">
                            <div>
                                <img src="images/main2.jpg" />
                            </div>
                            <div class="big-grid-word">申請樂屋</div>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="<?= Yii::getAlias('@web')?>/household-information">
                        <div class="big-grid big-grid-3">
                            <div>
                                <img src="images/main3.jpg" />
                            </div>
                            <div class="big-grid-word">劏房戶資訊</div>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="<?= Yii::getAlias('@web')?>/lst-housing-story">
                        <div class="big-grid big-grid-4">
                            <div>
                                <img src="images/main4.jpg" />
                            </div>
                            <div class="big-grid-word">樂屋故事</div>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="<?= Yii::getAlias('@web')?>/contact">
                        <div class="big-grid big-grid-5">
                            <div>
                                <img src="images/main5.jpg" />
                            </div>
                            <div class="big-grid-word">聯絡我們</div>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="<?= Yii::getAlias('@web')?>/lst-housing-household">
                        <div class="big-grid big-grid-6">
                            <div>
                                <img src="images/main6.jpg" />
                            </div>
                            <div class="big-grid-word">樂屋住戶</div>
                        </div>
                    </a>
                </li>
            </ul>
        </div>
    </section>
<?php if (sizeof($model_home->top_youtubes) > 0) { ?>
    <div class="page-top_youtube">
        <div class="youtube-box">
            <?= Html::tag('iframe', '', [
                    'src' => "https://www.youtube.com/embed/".$model_home->top_youtubes[0]['id']."?modestbranding=0&rel=0&showinfo=0",
                    'frameborder' => 0,
                    'allow' => 'accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture',
                    'allowfullscreen' => true,
                    'data' => [
                        'id' => $model_home->top_youtubes[0]['id'],
                        'title' => $model_home->top_youtubes[0]['title']
                    ]
                ])
            ?>
        </div>
        <div class="row">
<?php for ($num=1; $num<sizeof($model_home->top_youtubes); $num++) { ?>
            <div class="col-sm-4">
                <?= Html::a(('<img class="page-top_youtube-thumb" src="http://img.youtube.com/vi/'.$model_home->top_youtubes[$num]['id'].'/maxresdefault.jpg"><div class="page-top_youtube-title">'.Html::encode($model_home->top_youtubes[$num]['title']).'</div>'), 'https://youtu.be/'.$model_home->top_youtubes[$num]['id'], [
                        'target' => '_blank',
                        'data' => [
                            'id' => $model_home->top_youtubes[$num]['id'],
                            'title' => $model_home->top_youtubes[$num]['title']
                        ]
                    ]) ?>
            </div>
<?php } ?>
        </div>
    </div>
    <hr />
<?php } ?>
    
    <?= implode('', $model_home_content) ?>
    <!-- <h1 style="color:red;text-align:center;">樂屋網，建設中！</h1>
    <hr />
    <h3>計劃目的</h3>
    <p>計劃旨在協助正在輪候公屋的基層家庭，改善目前居住環境，以及善用「社區為本」的支援網絡，在醫療、膳食、就業和家庭服務上，為服務使用者提供協助。</p>
    <div style="width:80%;margin:0 auto;">
        <img src="images/LST_housing_tmp1.jpg" style="width:100%;" />
    </div>
    <div style="margin:20px 0;">
        <div style="margin:10px 0;">
            <i>按此了解詳情</i>
        </div>
        <div style="margin:10px 0;">
            <a href="https://www.loksintong.org/lok-sin-tong-social-housing-scheme-lst-housing---cheung-shan-estate-tsuen-wan" target="_blank">荃灣象山邨學校項目</a>
        </div>
        <div style="margin:10px 0;">
            <a href="https://www.loksintong.org/lok-sin-tong-modular-social-housing-scheme---hotel-project" target="_blank">酒店式社會房屋項目</a>
        </div>
        <div style="margin:10px 0;">
            <a href="https://www.youtube.com/watch?v=cZiOn5szcco" target="_blank">樂善堂小學項目</a>
        </div>
        <div style="margin:10px 0;">
            <a href="https://www.youtube.com/watch?v=laSfj3TXpeA" target="_blank">宋皇臺道及土瓜灣道交界組合屋項目</a>
        </div>
    </div>
    <div style="margin:20px 0;">
        <h3 style="color:red;">查詢</h3>
        <div>電話：2272-9888 / 2382-1576</div> 
        <div>電郵：<a href="mailto:housing@loksintong.org">housing@loksintong.org</a></div> 
    </div> -->
</div>
