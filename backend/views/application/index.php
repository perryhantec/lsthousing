<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\widgets\ActiveForm;
use kartik\grid\GridView;
use kartik\editable\Editable;
use common\models\Definitions;
use common\models\Application;
use kartik\widgets\DatePicker;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UsersDataProvider */
/* @var $dataProvider yii\data\ActiveDataProvider */

$extra_text = '';

if (isset($action)) {
  if ($action == 'request') {
    $extra_text = '要求上載文件 - 請先選擇';
  } elseif ($action == 'response') {
    $extra_text = '已提交上載文件 - 請先選擇';
  }
  //  elseif ($action == 'visit') {
  //   $extra_text = '家訪紀錄 - 請先選擇';
  // }  
}

$this->title = $extra_text.'申請表';
$this->params['breadcrumbs'][] = $this->title;

$js = <<<JS
    let canSubmit = true;

    $('#application-form-import').on('beforeSubmit',function(){
        if (canSubmit) {
          canSubmit = false;
        } else {
          return false;
        }
    });
JS;

$this->registerJs($js);
?>
<style>
.red{color:red;}
.blue{color:blue;}
</style>
<div class="users-index">
<?php if (0 && isset($model_application_form_import)) { ?>
  <p>
    <?= Html::a(Yii::t('app', 'Export'), ['export-application'], ['class' => 'btn btn-info']) ?>
  </p>
<?php } ?>

<?php if (false) { ?>
    <p>
      <?= Html::a(Yii::t('app',"Create {modelClass}",['modelClass'=>'申請表']),['create'],
            ['class' => 'btn btn-success']);
                  ?>
    </p>
<?php } ?>

    <?php Pjax::begin(['id'=>'application-pjax']); ?>

<?php if (isset($model_application_form_import)) { ?>
    <div class="row">
      <div class="col-md-12">
        <!-- general form elements -->
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title"><?= Yii::t('app', 'Import')?> <button type="button" data-toggle="collapse" data-target="#rule" onclick="toggleIcon(this);"><i class="fa fa-plus"></i></button></h3>
          </div>
          <!-- /.box-header -->
          <!-- form start -->
            <div class="box-body">
              <div class="row">
                <?php $form = ActiveForm::begin([
                    'id' => 'application-form-import',
                    'options' => ['enctype' => 'multipart/form-data']
                    ]) ?>

                  <div class="col-xs-12">
                    <?php
                    foreach($model_application_form_import->error_excel as $row=>$error){
                      echo $form->errorSummary($error, ['header' => Yii::t('app', 'Row'). ' '. $row]);
                    }
                    ?>
                 </div>
               </div>

              <div class="row">
                <div class="col-xs-12 ">
                  <div id="rule" class="collapse">
                    <h4><u>Excel: </u></h4>
                    <p>
                      <b>A</b>: 申請編號
                      <b>B</b>: 第一優先選擇
                      <b>C</b>: 第二優先選擇
                      <b>D</b>: 第三優先選擇
                      <b>E</b>: 姓名(中文)
                      <b>F</b>: 姓名(英文)
                      <b>G</b>: 住宅電話
                      <b>H</b>: 手提電話
                      <b>I</b>: 居住地址
                      <b>J</b>: 單位面積(平方呎)
                      <b>K</b>: 電郵地址
                      <b>L</b>: 現時居住房屋種類
                      <b>M</b>: 其他(請註明)
                      <b>N</b>: 私人樓宇種類
                      <b>O</b>: 同住房屋種類
                      <b>P</b>: 其他(請註明)
                      <b>Q</b>: 過去3個月的平均租金(不包括水電費)
                      <b>R</b>: 已居於目前單位(年)
                      <b>S</b>: 已居於目前單位(月)
                      <b>T</b>: 家庭成員數目
                      <b>U</b>: 有沒有申請公屋
                      <b>V</b>: 公屋申請編號
                      <b>W</b>: 申請公屋地點
                      <b>X</b>: 申請公屋日期(年份)
                      <b>Y</b>: 申請公屋日期(月)
                      <b>Z</b>: 申請公屋日期(日)
                      <b>AA</b>: 申請人 - 性別
                      <b>AB</b>: 申請人 - 出生日期(日/月/年)
                      <b>AC</b>: 申請人 - 身份證明文件類別
                      <b>AD</b>: 申請人 - 身份證明文件號碼
                      <b>AE</b>: 申請人 - 婚姻狀況
                      <b>AF</b>: 申請人 - 長期病患(請說明)
                      <b>AG</b>: 申請人 - 工作狀況
                      <b>AH</b>: 申請人 - 職業
                      <b>AI</b>: 申請人 - 過去3個月每月平均收入
                      <b>AJ</b>: 申請人 - 現正領取的政府資助 > 綜合社會保障援助 (綜援)
                      <b>AK</b>: 申請人 - 現正領取的政府資助 > 高齡津貼
                      <b>AL</b>: 申請人 - 現正領取的政府資助 > 長者生活津貼
                      <b>AM</b>: 申請人 - 現正領取的政府資助 > 傷殘津貼(包括普通和高額津貼)
                      <b>AN</b>: 申請人 - 現正領取的政府資助 > 半額及全額書簿津貼
                      <b>AO</b>: 申請人 - 現正領取的政府資助 > 其他
                      <b>AP</b>: 申請人 - 資助總額
                      <b>AQ</b>: 申請人 - 個人資產(需遞交相關證明文件)
                      <b>AR</b>: 申請人 - 個人資產種類
                      <b>AS</b>: 申請人 - 個人資產總值
                      <b>AT</b>: 申請人 - 存款/現金
                      <b>AU</b>: 家庭成員 1 - 中文姓名
                      <b>AV</b>: 家庭成員 1 - 英文姓名
                      <b>AW</b>: 家庭成員 1 - 性別
                      <b>AX</b>: 家庭成員 1 - 出生日期(日/月/年)
                      <b>AY</b>: 家庭成員 1 - 身份證明文件類別
                      <b>AZ</b>: 家庭成員 1 - 身份證明文件號碼
                      <b>BA</b>: 家庭成員 1 - 與申請人關係
                      <b>BB</b>: 家庭成員 1 - 婚姻狀況
                      <b>BC</b>: 家庭成員 1 - 長期病患(請說明)
                      <b>BD</b>: 家庭成員 1 - 是否特殊學習需要兒童
                      <b>BE</b>: 家庭成員 1 - 工作狀況
                      <b>BF</b>: 家庭成員 1 - 職業
                      <b>BG</b>: 家庭成員 1 - 過去3個月每月平均收入
                      <b>BH</b>: 家庭成員 1 - 現正領取的政府資助 > 綜合社會保障援助 (綜援)
                      <b>BI</b>: 家庭成員 1 - 現正領取的政府資助 > 高齡津貼
                      <b>BJ</b>: 家庭成員 1 - 現正領取的政府資助 > 長者生活津貼
                      <b>BK</b>: 家庭成員 1 - 現正領取的政府資助 > 傷殘津貼(包括普通和高額津貼)
                      <b>BL</b>: 家庭成員 1 - 現正領取的政府資助 > 半額及全額書簿津貼
                      <b>BM</b>: 家庭成員 1 - 現正領取的政府資助 > 其他
                      <b>BN</b>: 家庭成員 1 - 資助總額
                      <b>BO</b>: 家庭成員 1 - 個人資產(需遞交相關證明文件)
                      <b>BP</b>: 家庭成員 1 - 個人資產種類
                      <b>BQ</b>: 家庭成員 1 - 個人資產總值
                      <b>BR</b>: 家庭成員 1 - 存款/現金
                      <b>BS</b>: 家庭成員 2 - 中文姓名
                      <b>BT</b>: 家庭成員 2 - 英文姓名
                      <b>BU</b>: 家庭成員 2 - 性別
                      <b>BV</b>: 家庭成員 2 - 出生日期(日/月/年)
                      <b>BW</b>: 家庭成員 2 - 身份證明文件類別
                      <b>BX</b>: 家庭成員 2 - 身份證明文件號碼
                      <b>BY</b>: 家庭成員 2 - 與申請人關係
                      <b>BZ</b>: 家庭成員 2 - 婚姻狀況
                      <b>CA</b>: 家庭成員 2 - 長期病患(請說明)
                      <b>CB</b>: 家庭成員 2 - 是否特殊學習需要兒童
                      <b>CC</b>: 家庭成員 2 - 工作狀況
                      <b>CD</b>: 家庭成員 2 - 職業
                      <b>CE</b>: 家庭成員 2 - 過去3個月每月平均收入
                      <b>CF</b>: 家庭成員 2 - 現正領取的政府資助 > 綜合社會保障援助 (綜援)
                      <b>CG</b>: 家庭成員 2 - 現正領取的政府資助 > 高齡津貼
                      <b>CH</b>: 家庭成員 2 - 現正領取的政府資助 > 長者生活津貼
                      <b>CI</b>: 家庭成員 2 - 現正領取的政府資助 > 傷殘津貼(包括普通和高額津貼)
                      <b>CJ</b>: 家庭成員 2 - 現正領取的政府資助 > 半額及全額書簿津貼
                      <b>CK</b>: 家庭成員 2 - 現正領取的政府資助 > 其他
                      <b>CL</b>: 家庭成員 2 - 資助總額
                      <b>CM</b>: 家庭成員 2 - 個人資產(需遞交相關證明文件)
                      <b>CN</b>: 家庭成員 2 - 個人資產種類
                      <b>CO</b>: 家庭成員 2 - 個人資產總值
                      <b>CP</b>: 家庭成員 2 - 存款/現金
                      <b>CQ</b>: 家庭成員 3 - 中文姓名
                      <b>CR</b>: 家庭成員 3 - 英文姓名
                      <b>CS</b>: 家庭成員 3 - 性別
                      <b>CT</b>: 家庭成員 3 - 出生日期(日/月/年)
                      <b>CU</b>: 家庭成員 3 - 身份證明文件類別
                      <b>CV</b>: 家庭成員 3 - 身份證明文件號碼
                      <b>CW</b>: 家庭成員 3 - 與申請人關係
                      <b>CX</b>: 家庭成員 3 - 婚姻狀況
                      <b>CY</b>: 家庭成員 3 - 長期病患(請說明)
                      <b>CZ</b>: 家庭成員 3 - 是否特殊學習需要兒童
                      <b>DA</b>: 家庭成員 3 - 工作狀況
                      <b>DB</b>: 家庭成員 3 - 職業
                      <b>DC</b>: 家庭成員 3 - 過去3個月每月平均收入
                      <b>DD</b>: 家庭成員 3 - 現正領取的政府資助 > 綜合社會保障援助 (綜援)
                      <b>DE</b>: 家庭成員 3 - 現正領取的政府資助 > 高齡津貼
                      <b>DF</b>: 家庭成員 3 - 現正領取的政府資助 > 長者生活津貼
                      <b>DG</b>: 家庭成員 3 - 現正領取的政府資助 > 傷殘津貼(包括普通和高額津貼)
                      <b>DH</b>: 家庭成員 3 - 現正領取的政府資助 > 半額及全額書簿津貼
                      <b>DI</b>: 家庭成員 3 - 現正領取的政府資助 > 其他
                      <b>DJ</b>: 家庭成員 3 - 資助總額
                      <b>DK</b>: 家庭成員 3 - 個人資產(需遞交相關證明文件)
                      <b>DL</b>: 家庭成員 3 - 個人資產種類
                      <b>DM</b>: 家庭成員 3 - 個人資產總值
                      <b>DN</b>: 家庭成員 3 - 存款/現金
                      <b>DO</b>: 家庭成員 4 - 中文姓名
                      <b>DP</b>: 家庭成員 4 - 英文姓名
                      <b>DQ</b>: 家庭成員 4 - 性別
                      <b>DR</b>: 家庭成員 4 - 出生日期(日/月/年)
                      <b>DS</b>: 家庭成員 4 - 身份證明文件類別
                      <b>DT</b>: 家庭成員 4 - 身份證明文件號碼
                      <b>DU</b>: 家庭成員 4 - 與申請人關係
                      <b>DV</b>: 家庭成員 4 - 婚姻狀況
                      <b>DW</b>: 家庭成員 4 - 長期病患(請說明)
                      <b>DX</b>: 家庭成員 4 - 是否特殊學習需要兒童
                      <b>DY</b>: 家庭成員 4 - 工作狀況
                      <b>DZ</b>: 家庭成員 4 - 職業
                      <b>EA</b>: 家庭成員 4 - 過去3個月每月平均收入
                      <b>EB</b>: 家庭成員 4 - 現正領取的政府資助 > 綜合社會保障援助 (綜援)
                      <b>EC</b>: 家庭成員 4 - 現正領取的政府資助 > 高齡津貼
                      <b>ED</b>: 家庭成員 4 - 現正領取的政府資助 > 長者生活津貼
                      <b>EE</b>: 家庭成員 4 - 現正領取的政府資助 > 傷殘津貼(包括普通和高額津貼)
                      <b>EF</b>: 家庭成員 4 - 現正領取的政府資助 > 半額及全額書簿津貼
                      <b>EG</b>: 家庭成員 4 - 現正領取的政府資助 > 其他
                      <b>EH</b>: 家庭成員 4 - 資助總額
                      <b>EI</b>: 家庭成員 4 - 個人資產(需遞交相關證明文件)
                      <b>EJ</b>: 家庭成員 4 - 個人資產種類
                      <b>EK</b>: 家庭成員 4 - 個人資產總值
                      <b>EL</b>: 家庭成員 4 - 存款/現金
                      <b>EM</b>: 家庭成員 5 - 中文姓名
                      <b>EN</b>: 家庭成員 5 - 英文姓名
                      <b>EO</b>: 家庭成員 5 - 性別
                      <b>EP</b>: 家庭成員 5 - 出生日期(日/月/年)
                      <b>EQ</b>: 家庭成員 5 - 身份證明文件類別
                      <b>ER</b>: 家庭成員 5 - 身份證明文件號碼
                      <b>ES</b>: 家庭成員 5 - 與申請人關係
                      <b>ET</b>: 家庭成員 5 - 婚姻狀況
                      <b>EU</b>: 家庭成員 5 - 長期病患(請說明)
                      <b>EV</b>: 家庭成員 5 - 是否特殊學習需要兒童
                      <b>EW</b>: 家庭成員 5 - 工作狀況
                      <b>EX</b>: 家庭成員 5 - 職業
                      <b>EY</b>: 家庭成員 5 - 過去3個月每月平均收入
                      <b>EZ</b>: 家庭成員 5 - 現正領取的政府資助 > 綜合社會保障援助 (綜援)
                      <b>FA</b>: 家庭成員 5 - 現正領取的政府資助 > 高齡津貼
                      <b>FB</b>: 家庭成員 5 - 現正領取的政府資助 > 長者生活津貼
                      <b>FC</b>: 家庭成員 5 - 現正領取的政府資助 > 傷殘津貼(包括普通和高額津貼)
                      <b>FD</b>: 家庭成員 5 - 現正領取的政府資助 > 半額及全額書簿津貼
                      <b>FE</b>: 家庭成員 5 - 現正領取的政府資助 > 其他
                      <b>FF</b>: 家庭成員 5 - 資助總額
                      <b>FG</b>: 家庭成員 5 - 個人資產(需遞交相關證明文件)
                      <b>FH</b>: 家庭成員 5 - 個人資產種類
                      <b>FI</b>: 家庭成員 5 - 個人資產總值
                      <b>FJ</b>: 家庭成員 5 - 存款/現金
                      <b>FK</b>: 單親家庭
                      <b>FL</b>: 家庭成員懷孕滿16週或上
                      <b>FM</b>: 懷孕週期
                      <b>FN</b>: 過去3個月申請人及家庭成員總收入
                      <b>FO</b>: 過去3個月政府資助總額
                      <b>FP</b>: 家庭總資產淨值
                      <b>FQ</b>: 機構轉介 - 轉介社工姓名
                      <b>FR</b>: 機構轉介 - 聯絡電話
                      <b>FS</b>: 機構轉介 - 電郵
                    </p>

                    <h4><u>Rule: </u></h4>
                    <p><b>A</b>:申請編號: 如輸入為已有編號 >> 更新, 如有輸入但系統沒有該編號 >> 新增 (編號將為輸入編號), 如沒有輸入編號 >> 新增 (編號將為系統編配)</p>
                    <p><b>B</b>:第一優先選擇: 請跟據 樂屋項目 >「標題 (繁體版本)」
                    <p><b>C</b>:第二優先選擇: 請跟據 樂屋項目 >「標題 (繁體版本)」
                    <p><b>D</b>:第三優先選擇: 請跟據 樂屋項目 >「標題 (繁體版本)」
                    <p><b>E</b>:姓名(中文): 跟F: 姓名(英文)<span class="red">其中一項為必填</span></p>
                    <p><b>F</b>:姓名(英文): 跟E: 姓名(中文)<span class="red">其中一項為必填</span></p>
                    <!-- <p><b>H</b>:手提電話: <span class="red">必填</span>, 只能填寫4、5、6或9字頭的8位數字</p> -->
                    <p><b>H</b>:手提電話: <span class="red">必填</span></p>
                    <p><b>L</b>:現時居住房屋種類: (租住私人樓宇 / 租住酒店或賓館 / 與家人同住 / 暫住親友家 / 露宿 / 其他)</p>
                    <p><b>M</b>:其他(請註明): 對應L: 現時居住房屋種類 選擇 其他</p>
                    <p><b>N</b>:私人樓宇種類: 對應L: 現時居住房屋種類 選擇 租住私人樓宇, (獨立單位 / 板間房 / 劏房 / 天台屋 / 床位 / 工厦 / 寮屋 / 鐵皮屋)</p>
                    <p><b>O</b>:同住房屋種類: 對應L: 現時居住房屋種類 選擇 與家人同住, (公屋 / 其他)</p>
                    <p><b>P</b>:其他(請註明): 對應O: 同住房屋種類 選擇 其他</p>
                    <p><b>R</b>:已居於目前單位(年): (0 至 20 / 20年以上)</p>
                    <p><b>S</b>:已居於目前單位(月): (1 至 11)</p>
                    <p><b>T</b>:家庭成員數目: <span class="red">必填</span>, 輸入<b><u>包括申請人在內</u></b>的人數, 輸入最小數值為1, 如果輸入2, 則AU: 家庭成員 1 - 中文姓名以及AV: 家庭成員 1 - 英文姓名其中一項為必填, 如此類推</p>
                    <p><b>U</b>:有沒有申請公屋: (有 / 沒有)</p>
                    <p><b>W</b>:申請公屋地點: (市區 / 擴展 / 新界)</p>
                    <p><b>AA</b>:申請人 - 性別: (男 / 女)</p>
                    <p><b>AB</b>:申請人 - 出生日期(日/月/年): 格式為「'xxxx-xx-xx」, 例: '2019-01-01</p>
                    <p><b>AC</b>:申請人 - 身份證明文件類別: (香港永久性居民身份證 / 香港居民身份證 / 香港出生證明書(適用於未滿11 歲人士) / 回港證 / 簽證身份書 / 前往港澳通行證(即單程證) / 其他)</p>
                    <p><b>AE</b>:申請人 - 婚姻狀況: (未婚 / 已婚 / 離婚 / 喪偶 / 正辦理離婚)</p>
                    <p><b>AG</b>:申請人 - 工作狀況: (全職 / 兼職 / 待業 / 退休 / 主婦 / 在學 / 其他)</p>
                    <p><b>AJ</b>:申請人 - 現正領取的政府資助 > 綜合社會保障援助: (是 / 否)</p>
                    <p><b>AK</b>:申請人 - 現正領取的政府資助 > 高齡津貼: (是 / 否)</p>
                    <p><b>AL</b>:申請人 - 現正領取的政府資助 > 長者生活津貼: (是 / 否)</p>
                    <p><b>AM</b>:申請人 - 現正領取的政府資助 > 傷殘津貼(包括普通和高額津貼): (是 / 否)</p>
                    <p><b>AN</b>:申請人 - 現正領取的政府資助 > 半額及全額書簿津貼: (是 / 否)</p>
                    <p><b>AO</b>:申請人 - 現正領取的政府資助 > 其他: (是 / 否)</p>
                    <p><b>AQ</b>:申請人 - 個人資產(需遞交相關證明文件): (有 / 沒有)</p>
                    <p><b>AU</b>:家庭成員 1 - 中文姓名, <span class="blue">如果T: 家庭成員數目為2或以上</span>, 則跟AV: 家庭成員 1 - 英文姓名<span class="blue">其中一項為必填</span></p>
                    <p><b>AV</b>:家庭成員 1 - 英文姓名, <span class="blue">如果T: 家庭成員數目為2或以上</span>, 則跟AU: 家庭成員 1 - 中文姓名<span class="blue">其中一項為必填</span></p>
                    <p><b>AW</b>:家庭成員 1 - 性別: (男 / 女)</p>
                    <p><b>AX</b>:家庭成員 1 - 出生日期(日/月/年): 格式為「'xxxx-xx-xx」, 例: '2019-01-01</p>
                    <p><b>AY</b>:家庭成員 1 - 身份證明文件類別: (香港永久性居民身份證 / 香港居民身份證 / 香港出生證明書(適用於未滿11 歲人士) / 回港證 / 簽證身份書 / 前往港澳通行證(即單程證) / 其他)</p>
                    <p><b>BB</b>:家庭成員 1 - 婚姻狀況: (未婚 / 已婚 / 離婚 / 喪偶 / 正辦理離婚)</p>
                    <p><b>BD</b>:家庭成員 1 - 是否特殊學習需要兒童: (是 / 否)</p>
                    <p><b>BE</b>:家庭成員 1 - 工作狀況: (全職 / 兼職 / 待業 / 退休 / 主婦 / 在學 / 其他)</p>
                    <p><b>BH</b>:家庭成員 1 - 現正領取的政府資助 > 綜合社會保障援助: (是 / 否)</p>
                    <p><b>BI</b>:家庭成員 1 - 現正領取的政府資助 > 高齡津貼: (是 / 否)</p>
                    <p><b>BJ</b>:家庭成員 1 - 現正領取的政府資助 > 長者生活津貼: (是 / 否)</p>
                    <p><b>BK</b>:家庭成員 1 - 現正領取的政府資助 > 傷殘津貼(包括普通和高額津貼): (是 / 否)</p>
                    <p><b>BL</b>:家庭成員 1 - 現正領取的政府資助 > 半額及全額書簿津貼: (是 / 否)</p>
                    <p><b>BM</b>:家庭成員 1 - 現正領取的政府資助 > 其他: (是 / 否)</p>
                    <p><b>BO</b>:家庭成員 1 - 個人資產(需遞交相關證明文件): (有 / 沒有)</p>
                    <p><b>BS</b>:家庭成員 2 - 中文姓名, <span class="blue">如果T: 家庭成員數目為3或以上</span>, 則跟BT: 家庭成員 2 - 英文姓名<span class="blue">其中一項為必填</span></p>
                    <p><b>BT</b>:家庭成員 2 - 英文姓名, <span class="blue">如果T: 家庭成員數目為3或以上</span>, 則跟BS: 家庭成員 2 - 中文姓名<span class="blue">其中一項為必填</span></p>
                    <p><b>BU</b>:家庭成員 2 - 性別: (男 / 女)</p>
                    <p><b>BV</b>:家庭成員 2 - 出生日期(日/月/年): 格式為「'xxxx-xx-xx」, 例: '2019-01-01</p>
                    <p><b>BW</b>:家庭成員 2 - 身份證明文件類別: (香港永久性居民身份證 / 香港居民身份證 / 香港出生證明書(適用於未滿11 歲人士) / 回港證 / 簽證身份書 / 前往港澳通行證(即單程證) / 其他)</p>
                    <p><b>BZ</b>:家庭成員 2 - 婚姻狀況: (未婚 / 已婚 / 離婚 / 喪偶 / 正辦理離婚)</p>
                    <p><b>CB</b>:家庭成員 2 - 是否特殊學習需要兒童: (是 / 否)</p>
                    <p><b>CC</b>:家庭成員 2 - 工作狀況: (全職 / 兼職 / 待業 / 退休 / 主婦 / 在學 / 其他)</p>
                    <p><b>CF</b>:家庭成員 2 - 現正領取的政府資助 > 綜合社會保障援助: (是 / 否)</p>
                    <p><b>CG</b>:家庭成員 2 - 現正領取的政府資助 > 高齡津貼: (是 / 否)</p>
                    <p><b>CH</b>:家庭成員 2 - 現正領取的政府資助 > 長者生活津貼: (是 / 否)</p>
                    <p><b>CI</b>:家庭成員 2 - 現正領取的政府資助 > 傷殘津貼(包括普通和高額津貼): (是 / 否)</p>
                    <p><b>CJ</b>:家庭成員 2 - 現正領取的政府資助 > 半額及全額書簿津貼: (是 / 否)</p>
                    <p><b>CK</b>:家庭成員 2 - 現正領取的政府資助 > 其他: (是 / 否)</p>
                    <p><b>CM</b>:家庭成員 2 - 個人資產(需遞交相關證明文件): (有 / 沒有)</p>
                    <p><b>CQ</b>:家庭成員 3 - 中文姓名, <span class="blue">如果T: 家庭成員數目為4或以上</span>, 則跟CR: 家庭成員 3 - 英文姓名<span class="blue">其中一項為必填</span></p>
                    <p><b>CR</b>:家庭成員 3 - 英文姓名, <span class="blue">如果T: 家庭成員數目為4或以上</span>, 則跟CQ: 家庭成員 3 - 中文姓名<span class="blue">其中一項為必填</span></p>
                    <p><b>CS</b>:家庭成員 3 - 性別: (男 / 女)</p>
                    <p><b>CT</b>:家庭成員 3 - 出生日期(日/月/年): 格式為「'xxxx-xx-xx」, 例: '2019-01-01</p>
                    <p><b>CU</b>:家庭成員 3 - 身份證明文件類別: (香港永久性居民身份證 / 香港居民身份證 / 香港出生證明書(適用於未滿11 歲人士) / 回港證 / 簽證身份書 / 前往港澳通行證(即單程證) / 其他)</p>
                    <p><b>CX</b>:家庭成員 3 - 婚姻狀況: (未婚 / 已婚 / 離婚 / 喪偶 / 正辦理離婚)</p>
                    <p><b>CZ</b>:家庭成員 3 - 是否特殊學習需要兒童: (是 / 否)</p>
                    <p><b>DA</b>:家庭成員 3 - 工作狀況: (全職 / 兼職 / 待業 / 退休 / 主婦 / 在學 / 其他)</p>
                    <p><b>DD</b>:家庭成員 3 - 現正領取的政府資助 > 綜合社會保障援助: (是 / 否)</p>
                    <p><b>DE</b>:家庭成員 3 - 現正領取的政府資助 > 高齡津貼: (是 / 否)</p>
                    <p><b>DF</b>:家庭成員 3 - 現正領取的政府資助 > 長者生活津貼: (是 / 否)</p>
                    <p><b>DG</b>:家庭成員 3 - 現正領取的政府資助 > 傷殘津貼(包括普通和高額津貼): (是 / 否)</p>
                    <p><b>DH</b>:家庭成員 3 - 現正領取的政府資助 > 半額及全額書簿津貼: (是 / 否)</p>
                    <p><b>DI</b>:家庭成員 3 - 現正領取的政府資助 > 其他: (是 / 否)</p>
                    <p><b>DK</b>:家庭成員 3 - 個人資產(需遞交相關證明文件): (有 / 沒有)</p>
                    <p><b>DO</b>:家庭成員 4 - 中文姓名, <span class="blue">如果T: 家庭成員數目為5或以上</span>, 則跟DP: 家庭成員 4 - 英文姓名<span class="blue">其中一項為必填</span></p>
                    <p><b>DP</b>:家庭成員 4 - 英文姓名, <span class="blue">如果T: 家庭成員數目為5或以上</span>, 則跟DO: 家庭成員 4 - 中文姓名<span class="blue">其中一項為必填</span></p>
                    <p><b>DQ</b>:家庭成員 4 - 性別: (男 / 女)</p>
                    <p><b>DR</b>:家庭成員 4 - 出生日期(日/月/年): 格式為「'xxxx-xx-xx」, 例: '2019-01-01</p>
                    <p><b>DS</b>:家庭成員 4 - 身份證明文件類別: (香港永久性居民身份證 / 香港居民身份證 / 香港出生證明書(適用於未滿11 歲人士) / 回港證 / 簽證身份書 / 前往港澳通行證(即單程證) / 其他)</p>
                    <p><b>DV</b>:家庭成員 4 - 婚姻狀況: (未婚 / 已婚 / 離婚 / 喪偶 / 正辦理離婚)</p>
                    <p><b>DX</b>:家庭成員 4 - 是否特殊學習需要兒童: (是 / 否)</p>
                    <p><b>DY</b>:家庭成員 4 - 工作狀況: (全職 / 兼職 / 待業 / 退休 / 主婦 / 在學 / 其他)</p>
                    <p><b>EB</b>:家庭成員 4 - 現正領取的政府資助 > 綜合社會保障援助: (是 / 否)</p>
                    <p><b>EC</b>:家庭成員 4 - 現正領取的政府資助 > 高齡津貼: (是 / 否)</p>
                    <p><b>ED</b>:家庭成員 4 - 現正領取的政府資助 > 長者生活津貼: (是 / 否)</p>
                    <p><b>EE</b>:家庭成員 4 - 現正領取的政府資助 > 傷殘津貼(包括普通和高額津貼): (是 / 否)</p>
                    <p><b>EF</b>:家庭成員 4 - 現正領取的政府資助 > 半額及全額書簿津貼: (是 / 否)</p>
                    <p><b>EG</b>:家庭成員 4 - 現正領取的政府資助 > 其他: (是 / 否)</p>
                    <p><b>EI</b>:家庭成員 4 - 個人資產(需遞交相關證明文件): (有 / 沒有)</p>
                    <p><b>EM</b>:家庭成員 5 - 中文姓名, <span class="blue">如果T: 家庭成員數目為6或以上</span>, 則跟EN: 家庭成員 5 - 英文姓名<span class="blue">其中一項為必填</span></p>
                    <p><b>EN</b>:家庭成員 5 - 英文姓名, <span class="blue">如果T: 家庭成員數目為6或以上</span>, 則跟EM: 家庭成員 5 - 中文姓名<span class="blue">其中一項為必填</span></p>
                    <p><b>EO</b>:家庭成員 5 - 性別: (男 / 女)</p>
                    <p><b>EP</b>:家庭成員 5 - 出生日期(日/月/年): 格式為「'xxxx-xx-xx」, 例: '2019-01-01</p>
                    <p><b>EQ</b>:家庭成員 5 - 身份證明文件類別: (香港永久性居民身份證 / 香港居民身份證 / 香港出生證明書(適用於未滿11 歲人士) / 回港證 / 簽證身份書 / 前往港澳通行證(即單程證) / 其他)</p>
                    <p><b>ET</b>:家庭成員 5 - 婚姻狀況: (未婚 / 已婚 / 離婚 / 喪偶 / 正辦理離婚)</p>
                    <p><b>EW</b>:家庭成員 5 - 是否特殊學習需要兒童: (是 / 否)</p>
                    <p><b>EX</b>:家庭成員 5 - 工作狀況: (全職 / 兼職 / 待業 / 退休 / 主婦 / 在學 / 其他)</p>
                    <p><b>EZ</b>:家庭成員 5 - 現正領取的政府資助 > 綜合社會保障援助: (是 / 否)</p>
                    <p><b>FA</b>:家庭成員 5 - 現正領取的政府資助 > 高齡津貼: (是 / 否)</p>
                    <p><b>FB</b>:家庭成員 5 - 現正領取的政府資助 > 長者生活津貼: (是 / 否)</p>
                    <p><b>FC</b>:家庭成員 5 - 現正領取的政府資助 > 傷殘津貼(包括普通和高額津貼): (是 / 否)</p>
                    <p><b>FD</b>:家庭成員 5 - 現正領取的政府資助 > 半額及全額書簿津貼: (是 / 否)</p>
                    <p><b>FE</b>:家庭成員 5 - 現正領取的政府資助 > 其他: (是 / 否)</p>
                    <p><b>FG</b>:家庭成員 5 - 個人資產(需遞交相關證明文件): (有 / 沒有)</p>
                    <p><b>FK</b>:單親家庭: (是 / 否)</p>
                    <p><b>FL</b>:家庭成員懷孕滿16週或上: (有 / 沒有)</p>

                    <p>新增/更新用戶後前台預設密碼為<b><u>LSThousing2022</u></b></p>
                    <!-- <p>此匯入只新增/更新用戶基本資料, 如需更改資料, 請到 申請表 > 更改申請表</p>
                    <p><b>I</b>:起租日期: 格式為「'xxxx-xx-xx」, 例: '2019-01-01</p> -->
                    <?php $url = Yii::getAlias('@web').'/file/application_form_import_demo.xlsx'; ?>
                  </div>
                  <p><?= Html::a('下載範例', $url, ['download' => true, 'onclick' => 'reloadPage(event,"'.$url.'");'])?></p>
                </div>
                <div class="col-xs-6 col-md-6">
                    <?= $form->field($model_application_form_import, 'file')->fileInput() ?>
                </div>
              </div>
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
              <?= Html::submitButton(Yii::t('app', 'Submit'), ['class' => 'btn btn-primary']) ?>
            </div>
            <?php ActiveForm::end() ?>
        </div>
      </div>
      
    </div>
<?php } ?>

    <?php
    $gridColumns =
    [
        [
          'attribute' => 'date',
          'label' => Yii::t('app', 'Created At'),
          'width' => '10%',
          'format' => 'raw',
          'filter' => DatePicker::widget([
                          'model'=>$searchModel,
                          'attribute'=>'date',
                          'type' => DatePicker::TYPE_INPUT,
                          'options' => ['autocomplete' => 'off'],
                          'pluginOptions' => [
                              'autoclose'=>true,
                              'weekStart' => 0,
                              'format' => 'yyyy-mm-dd'
                          ]
                        ]),
          'value' => function($model){
  //                  return Yii::$app->formatter->asDate($model->created_at, 'long');
                    return ($model->created_at) ? date('Y-m-d',strtotime($model->created_at)) : '';
          },
          'vAlign'=>'middle',
          'headerOptions'=>['class'=>'kv-sticky-column'],
          'contentOptions'=>['class'=>'kv-sticky-column'],
        ],
  //       [
  //         'attribute' => 'date2',
  //         'label' => Yii::t('app', 'Updated At'),
  //         'width' => '10%',
  //         'format' => 'raw',
  //         'filter' => DatePicker::widget([
  //                         'model'=>$searchModel,
  //                         'attribute'=>'date2',
  //                         'type' => DatePicker::TYPE_INPUT,
  //                         'options' => ['autocomplete' => 'off'],
  //                         'pluginOptions' => [
  //                             'autoclose'=>true,
  //                             'weekStart' => 0,
  //                             'format' => 'yyyy-mm-dd'
  //                         ]
  //                       ]),
  //         'value' => function($model){
  // //                  return Yii::$app->formatter->asDate($model->created_at, 'long');
  //                   return ($model->updated_at) ? date('Y-m-d',strtotime($model->updated_at)) : '';
  //         },
  //         'vAlign'=>'middle',
  //         'headerOptions'=>['class'=>'kv-sticky-column'],
  //         'contentOptions'=>['class'=>'kv-sticky-column'],
  //       ],
        [
          'attribute' => 'appl_no',
          'vAlign'=>'middle',
          'headerOptions'=>['class'=>'kv-sticky-column'],
          'contentOptions'=>['class'=>'kv-sticky-column', 'style'=>'width: 10%;'],
        ],
        [
          'label' => '申請人數',
          'attribute' => 'family_member',
          'vAlign'=>'middle',
          'headerOptions'=>['class'=>'kv-sticky-column'],
          'contentOptions'=>['class'=>'kv-sticky-column', 'style'=>'width: 5%;'],
        ],
        [
          'attribute' => 'chi_name',
          'vAlign'=>'middle',
          'headerOptions'=>['class'=>'kv-sticky-column'],
          'contentOptions'=>['class'=>'kv-sticky-column', 'style'=>'width: 10%;'],
        ],
        [
          'attribute' => 'eng_name',
          'vAlign'=>'middle',
          'headerOptions'=>['class'=>'kv-sticky-column'],
          'contentOptions'=>['class'=>'kv-sticky-column', 'style'=>'width: 10%;'],
        ],
        [
          'attribute' => 'mobile',
          'vAlign'=>'middle',
          'headerOptions'=>['class'=>'kv-sticky-column'],
          'contentOptions'=>['class'=>'kv-sticky-column', 'style'=>'width: 10%;'],
          'value' => function($model){
              return '';
          },
        ],
        [
          'attribute' => 'priority_1',
          'vAlign'=>'middle',
          'filter' => Definitions::getProjectName(),
          'value' => function($model){
                    return Definitions::getProjectName($model->priority_1);
          },
          'headerOptions'=>['class'=>'kv-sticky-column'],
          'contentOptions'=>['class'=>'kv-sticky-column', 'style'=>'width: 10%;'],
        ],
        [
          'attribute' => 'priority_2',
          'vAlign'=>'middle',
          'filter' => Definitions::getProjectName(),
          'value' => function($model){
                    return Definitions::getProjectName($model->priority_2);
          },
          'headerOptions'=>['class'=>'kv-sticky-column'],
          'contentOptions'=>['class'=>'kv-sticky-column', 'style'=>'width: 10%;'],
        ],
        [
          'attribute' => 'priority_3',
          'vAlign'=>'middle',
          'filter' => Definitions::getProjectName(),
          'value' => function($model){
                    return Definitions::getProjectName($model->priority_3);
          },
          'headerOptions'=>['class'=>'kv-sticky-column'],
          'contentOptions'=>['class'=>'kv-sticky-column', 'style'=>'width: 10%;'],
        ],
        [
            'attribute' => 'application_status',
            'vAlign'=>'middle',
            'filter' => Definitions::getApplicationStatus(),
            'value' => function($model){
                      return Definitions::getApplicationStatus($model->application_status);
            },
            'headerOptions'=>['class'=>'kv-sticky-column'],
            'contentOptions'=>['class'=>'kv-sticky-column', 'style'=>'width: 10%;'],
        ],
      [
        'class' => 'backend\components\ActionColumn',
        // 'template'=> '{view} {update} {application-request-files} {application-response-files} {application-visit} {update-visit}',
        'template'=> '{view} {update} {update-application} {application-request-files} {application-response-files} {delete}',
        'contentOptions'=>['style'=>['width'=>'5%','white-space' => 'nowrap']],
        'buttons' => [
          'view' => function ($url, $model, $key) {
            return  Html::a('檢視申請資料', $url, ['class' => 'btn btn-info btn-xs']);
          },
          'update' => function ($url, $model, $key) {
            return  Html::a('更改狀態', $url, ['class' => 'btn btn-warning btn-xs']);
          },
          'update-application' => function ($url, $model, $key) {
            return  Html::a('更改申請表', $url, ['class' => 'btn btn-default btn-xs']);
          },
          'application-request-files' => function($url, $model, $key) {
            $url = str_replace('/admin/application','/admin',$url);

            return Html::a('要求上載文件', $url, ['class' => 'btn btn-xs btn-danger', 'onclick' => 'reloadPage(event,"'.$url.'");']);
          },
          'application-response-files' => function($url, $model, $key) {
            $url = str_replace('/admin/application','/admin',$url);

            return Html::a('檢查已提交上載文件', $url, ['class' => 'btn btn-xs btn-success', 'onclick' => 'reloadPage(event,"'.$url.'");']);
          },
          // 'application-visit' => function($url, $model, $key) {
          //   $url = str_replace('/admin/application','/admin',$url);

          //   return Html::a('家訪紀錄', $url, ['class' => 'btn btn-xs btn-primary', 'onclick' => 'reloadPage(event,"'.$url.'");']);
          // },
          // 'update-visit' => function ($url, $model, $key) {
          //   return  Html::a('家訪紀錄', $url, ['class' => 'btn btn-primary btn-xs']);
          // },
        ],
        'visibleButtons' => [
          // 'view' => function ($model) { return $model->application_status == $model::APPL_STATUS_SUBMITED_FORM; },
          // 'update' => function ($model) { return $model->application_status == $model::APPL_STATUS_SUBMITED_FORM; },
          'update-application' => function ($model) {
            return !(basename(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)) == 'request-file-list' ||
                   basename(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)) == 'response-file-list');
          },
          'application-request-files' => function ($model) {
            return basename(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)) == 'request-file-list' &&
                   ($model->application_status >= Application::APPL_STATUS_UPLOAD_FILES);
                  //  ($model->application_status == $model::APPL_STATUS_UPLOAD_FILES ||
                  //  $model->application_status == $model::APPL_STATUS_UPLOAD_FILES_AGAIN);
          },
          'application-response-files' => function ($model) {
            return basename(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)) == 'response-file-list' &&
                   $model->application_status >= Application::APPL_STATUS_UPLOAD_FILES;
                  //  ($model->application_status == $model::APPL_STATUS_UPLOAD_FILES ||
                  //  $model->application_status == $model::APPL_STATUS_UPLOAD_FILES_AGAIN);
          },
          'delete' => function ($model) {
            return !(basename(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)) == 'request-file-list' ||
                   basename(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)) == 'response-file-list');
          },
          // 'application-visit' => function ($model) {
          //   return basename($_SERVER['REQUEST_URI']) == 'visit-list' &&
          //          ($model->application_status >= $model::APPL_STATUS_FILES_PASSED);
          // },
          // 'update-visit' => function ($model) {
          //   return basename($_SERVER['REQUEST_URI']) == 'visit-list' &&
          //          ($model->application_status >= $model::APPL_STATUS_FILES_PASSED);
          // },
        ]
      ],
    ]

    ?>

     <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns'=>$gridColumns,
            'containerOptions'=>['style'=>'overflow: auto'], // only set when $responsive = false
            'headerRowOptions'=>['class'=>'kartik-sheet-style'],
            'filterRowOptions'=>['class'=>'kartik-sheet-style'],
            'pjax'=>true, // pjax is set to always true for this demo
            'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container',], 'enablePushState' => false],

            // set your toolbar
            'toolbar'=> [
                // ['content'=>
                //     Html::a('<i class="glyphicon glyphicon-plus"></i>', ['create'], ['class'=>'btn btn-success', 'title'=>Yii::t('app', 'Create')])
                // ],
                //'{export}',
                //'{toggleData}',
            ],
            'export'=>[
               'fontAwesome'=>true
           ],
           // parameters from the demo form
           'bordered'=>true,
           'striped'=>false,
           'condensed'=>true,
           'responsive'=>true,
           'responsiveWrap' => false,
           'hover'=>true,
           //'showPageSummary'=>true,
           'panel'=>[
               'type'=>GridView::TYPE_PRIMARY,
               'heading'=> '',
           ],
           'persistResize'=>false,
           //'exportConfig'=>$exportConfig,


        ]); ?>
    <?php Pjax::end(); ?></div>
  </div>
<script>
function reloadPage(e, url) {
  e.preventDefault();
  // prevent render wrong view, i.e. application/index  
  window.location.href = url;
}
function toggleIcon(ele) {
    let eleI = $(ele).find('i').first();
    if (eleI.hasClass('fa-plus')){
        eleI.removeClass('fa-plus').addClass('fa-minus');
    } else if (eleI.hasClass('fa-minus')){
        eleI.removeClass('fa-minus').addClass('fa-plus');
    } 
}
</script>