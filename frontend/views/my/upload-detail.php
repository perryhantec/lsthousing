<?php

/* @var $this yii\web\View */
// use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use yii\widgets\Breadcrumbs;
use kartik\widgets\FileInput;
use common\widgets\Alert;
use common\models\Config;
use common\models\Definitions;
use common\models\ApplicationRequestFiles;

use common\components\MultipleInput;
use unclead\multipleinput\TabularColumn;
use yii\web\JsExpression;
use kartik\icons\Icon;
use common\models\File;
use common\utils\Html;


$model_general = common\models\General::findOne(1);

$this->title = '上載文件 - 詳細';

// Yii::$app->params['page_header_title'] = Yii::t('app', 'LST Shop');
// Yii::$app->params['page_header_img'] = '/images/page_header_img-shop.jpg';

// Yii::$app->params['breadcrumbs'][] = ['label' => Yii::t('app', 'LST Shop'), 'url' => ['/shop']];
Yii::$app->params['breadcrumbs'][] = Yii::t('app', "My Account");
Yii::$app->params['breadcrumbs'][] = ['label' => '我的申請 - 總覽', 'url' => ['application']];
Yii::$app->params['breadcrumbs'][] = ['label' => '上載文件 - 總覽', 'url' => ['upload', 'id' => $req_model->application->id]];
Yii::$app->params['breadcrumbs'][] = '上載文件 - 詳細';

$this->registerJs(<<<JS
JS
);

?>
<?= $this->render('../layouts/_user_header') ?>
    <div class="page-my">
        <div class="content">
            <div class="">
                <h1><strong>申請編號：<?= $req_model->application->appl_no ?></strong></h1>
                <h1><strong>參考編號：<?= $req_model->ref_code ?></strong></h1>
                <hr />
                
<?php if ($req_model->remarks) { ?>
    <h2 class="blue"><strong><u>本堂職員給 閣下的訊息</u></strong></h2>
    <div>
        <?= $req_model->remarks ?>
    </div>
    <hr />
<?php } ?>

<?php if (!($req_model->app_status == ApplicationRequestFiles::RESQ_APP_STATUS_SUBMITTED)) { ?>
<h2 class="green"><strong><u>上載文件注意事項</u></strong></h2>
<!-- <ul>
    <li>最多可上載 50 個檔案</li>
    <li>按住 Ctrl 或 Command 鍵可以選擇多個檔案</li>
    <li>總上限為 200MB</li>
    <li>可上載文件種類：jpeg，jpg，png，pdf</li>
    <li>檔案只能上載一次</li>
    <li>如有需要，本堂職員會通知 閣下再次上載文件</li>
    <li>如有查詢，可電郵至 <a href="mailto:info@loksintong.org">info@loksintong.org</a></li>
</ul> -->
<ul>
    <li>先選擇清單，再上傳對應檔案</li>
    <li>按 ＋ 號可以添加檔案柵，每個檔案柵只能加入一個檔案</li>
    <li>如果每個檔案柵拖曳多個檔案，只有最後一個才會生效</li>
    <li>成功上傳後，該檔案柵會出現<span class="green">完成</span>字樣</li>
    <li>如果按了儲存將<span class="red">不能</span>再次上傳</li>
    <li>請先再次確認所有上傳檔案已符合上述上載文件清單</li>
    <li>如有需要，本堂職員會通知 閣下再次上載文件</li>
    <li>如有查詢，可電郵至 <a href="mailto:housing@loksintong.org">housing@loksintong.org</a></li>
</ul>
<hr />
<?php } ?>
<h2 class="red"><strong><u>需要上載的文件</u></strong></h2>

<?php
    $part7s = Definitions::getPart7ContentWithTitle();
    $requests = json_decode($req_model->request);
    $html = '';

    // foreach ($part7s as $title => $subcontents) {
    //     $html .= '<h3><strong>'.$title.'</strong></h3>';
    //     foreach ($subcontents as $subtitle => $items) {
    //         $html .= '<h4 style="margin-left:15px;"><u>'.$subtitle.'</u></h4>';
    //         foreach ($items as $i => $label) {
    //         // echo $form->field($model, 'i'.$i)->checkbox(['label' => $label,'value' => $i, 'style' => 'margin-left:30px;'])->label(false);
    //             if (in_array($i, $requests)) {
    //                 $html .= '<div style="margin-left:30px;">'.$label.'</div>';
    //             }
    //         }
    //     }
    // }

    $first_access_title_1 = true;
    $first_access_title_2 = true;
    $first_access_subtitle_1 = true;
    $first_access_subtitle_2 = true;
    $first_access_subtitle_3 = true;
    $first_access_subtitle_4 = true;
    
    $title_gp = Definitions::getPart7TitleGroup();
    $subtitle_gp = Definitions::getPart7SubtitleGroup();
    $titles = [];
    $titles[] = '請選擇';
    
    foreach ($requests as $request) {
        $i = $j = 0;

        foreach ($part7s as $title => $subcontents) {
            if ($i == 0 && in_array($request, $title_gp[0]) && $first_access_title_1) {
                $html .= '<h3 style="margin-top:20px;margin-bottom:10px;"><strong>'.$title.'</strong></h3>';
                $first_access_title_1 = false;
            } elseif ($i == 1 && in_array($request, $title_gp[1]) && $first_access_title_2) {
                $html .= '<h3 style="margin-top:20px;margin-bottom:10px;"><strong>'.$title.'</strong></h3>';
                $first_access_title_2 = false;
            }
            foreach ($subcontents as $subtitle => $items) {
                if ($j == 0 && in_array($request, $subtitle_gp[0]) && $first_access_subtitle_1) {
                    $html .= '<h4 style="margin-left:15px;"><u>'.$subtitle.'</u></h4>';
                    $first_access_subtitle_1 = false;
                } elseif ($j == 1 && in_array($request, $subtitle_gp[1]) && $first_access_subtitle_2) {
                    $html .= '<h4 style="margin-left:15px;"><u>'.$subtitle.'</u></h4>';
                    $first_access_subtitle_2 = false;
                } elseif ($j == 2 && in_array($request, $subtitle_gp[2]) && $first_access_subtitle_3) {
                    $html .= '<h4 style="margin-left:15px;"><u>'.$subtitle.'</u></h4>';
                    $first_access_subtitle_3 = false;
                } elseif ($j == 3 && in_array($request, $subtitle_gp[3]) && $first_access_subtitle_4) {
                    $html .= '<h4 style="margin-left:15px;"><u>'.$subtitle.'</u></h4>';
                    $first_access_subtitle_4 = false;
                } elseif ($j > 3 &&  in_array($request, $subtitle_gp[$j])) {
                    $html .= '<h4 style="margin-left:15px;"><u>'.$subtitle.'</u></h4>';
                }
    
                foreach ($items as $index => $label) {
                    if ($index == $request) {
                        $html .= '<div style="margin-left:30px;"><i class="fa fa-upload"></i> '.$label.'</div>';
                        // $titles[$index] = '<u>'.$subtitle.'</u><br />'.$label;
                        $titles[$index] = $subtitle.' - '.$label;
                    }
                }
                $j++;
            }
            $i++;
        }
    }
    echo $html;
?>
<hr />
<?php if ($req_model->app_status == ApplicationRequestFiles::RESQ_APP_STATUS_SUBMITTED) { ?>

    <h2 class="text-center"><strong>閣下已提交交件，請等待本堂職員審批</strong></h2>
    <h2 class="text-center"><strong>如有查詢，可電郵至 <a href="mailto:housing@loksintong.org">housing@loksintong.org</a></strong></h2>
    <p><?= Html::a(Yii::t('app', 'Back'), Yii::$app->request->referrer, ['class' => 'btn btn-primary']) ?></p>

<?php } else { ?>
<div style="margin-bottom:100px;">
<?php
    // echo '<pre>';
    // print_r($titles);
    // echo '</pre>';

    $form = ActiveForm::begin([
        'id' => 'upload-detail-form',
        'options'=>['enctype'=>'multipart/form-data','onsubmit' => 'submitForm(event)'],
        // 'enableAjaxValidation' => false,
    ]);
    // echo $form->errorSummary($model);
/*

    // echo $form->field($model, 'upload_files[]')->fileInput(['accept' => 'image/png, image/jpeg, application/pdf', 'multiple' => true])->label(false);
    echo $form->field($model, 'upload_files[]')->widget(FileInput::classname(), [
        'options' => ['accept' => 'image/png, image/jpeg, application/pdf', 'multiple' => true],
        'pluginOptions' => [
            // 'showPreview' => false,
            'previewFileType' => 'any',

            // 'showCaption' => false,
            'showRemove' => false,
            'showUpload' => false,
            // 'browseClass' => 'btn btn-primary btn-block',
            'browseIcon' => '<i class="fa fa-file"></i> ',
            'browseLabel' => '選擇文件',
            // 'uploadUrl' => Url::to(['/my/upload-detail', 'id' => 2]),
            // 'uploadExtraData' => [
            //     'album_id' => 20,
            //     'cat_id' => 'Nature'
            // ],
            // "uploadAsync" => true,
            'maxFileSize'=> 209715200,
            'maxFileCount' => 50
        ]
    ])->label(false);
*/
?>
<style>
.kv-file-remove,.fileinput-remove{display:none;}
/* .radio{display:block;} */
.success{width:50%;}
</style>
<?=
    $form->field($model, 'upload_files')->widget(MultipleInput::class, [
        'columns' => [
            [
                'name' => 'id',
                'type' => TabularColumn::TYPE_HIDDEN_INPUT
            ], [
                'name' => 'file_key',
                'type' => TabularColumn::TYPE_HIDDEN_INPUT
            ], [
                'name'  => 'title',
                'type'  => TabularColumn::TYPE_DROPDOWN,
                'title' => '選擇清單',
                'headerOptions' => [
                    'class' => 'success',
                ],
                'items' => $titles,
            ], [
                'name' => 'upload_file',
                'type' => FileInput::class,
                'headerOptions' => [
                    'class' => 'success',
                ],
                'title' => '上傳',
                'options' => function($data) {
                return[
                    'pluginOptions' => [
    //                            'initialPreview' => $data['file_id'] ? Url::to(['attachement-download', 'id' => $data['id'], 'attribute' => 'file_id', 'auth_key' => File::findOne($data['file_id'])]) : '',
                        'initialPreviewAsData' => true,
                        'initialPreviewShowDelete' => false,
                        'uploadUrl' => Url::to(['/my/upload-file']),
                        'showRemove' => false,
                    ],
                    'pluginEvents' => [
                        'fileuploaded' => new JsExpression('function(event, data){var tr = $(this).closest("tr");tr.find("input[name$=\"[file_key]\"]").val(data.response.data.auth_key);}'),
                        'fileclear' => new JsExpression('function(event, data){var tr = $(this).closest("tr");tr.find("input[name$=\"[file_key]\"]").val("");}'),
                        'filebatchselected' =>  new JsExpression('function(event, data){var tr = $(this).closest("tr");tr.find("a.fileinput-upload-button").trigger("click");}'),
                    ],
                ];
                }
            ], [
                'name' => 'remarks',
                // 'title' => Yii::t('app', '備註'),
                'type' => TabularColumn::TYPE_HIDDEN_INPUT,
                // 'headerOptions' => [
                //     'class' => 'success',
                // ]
            ]
        ]
    ])->label(false);
?>
    <?= $form->field($model, 'application_id')->hiddenInput(['value' => '','id' => 'application_id'])->label(false); ?>
    <?= $form->field($model, 'request_id')->hiddenInput(['value' => '','id' => 'request_id'])->label(false); ?>
    <hr />
</div>
<?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success', 'onclick' => 'submitFormBtn(event)']) ?>
<?= Html::a(Yii::t('app', 'Back'), Yii::$app->request->referrer, ['class' => 'btn btn-primary', 'style' => 'margin-left:10px;']) ?>
<?php ActiveForm::end(); ?>
<?php } ?>
            </div>
        </div>
    </div>
<script>
function submitForm(e) {
    // e.preventDefault();
    $('#application_id').val('<?= $req_model->application_id ?>');
    $('#request_id').val('<?= $req_model->id ?>');
}
function submitFormBtn(e) {
    // e.preventDefault();
    if (confirm('如果按了儲存將不能再次上傳，建議再次檢查清楚')) {
        return true;
    } else {
        e.preventDefault();
        return false;
    }
}

</script>