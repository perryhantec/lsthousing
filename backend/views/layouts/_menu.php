<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use backend\components\AccessRule;

$lang = Yii::$app->language;

$url = \yii\helpers\Url::current();
$_url = explode("/", $url);

if (sizeof($_url) > 2)
    $base_name = $_url[2];
else
    $base_name = basename(\yii\helpers\Url::current());
if (strpos($base_name, '?'))
    $base_name = substr($base_name, 0, strpos($base_name, '?'));

$ecommerce_menu = [
  // ['model' => 'order', 'route' => 'order/index', 'name' => Yii::t('app','Orders'), 'visible'=>AccessRule::checkRole(['order'])],
  // ['model' => 'product', 'route' => 'product/index', 'name' => Yii::t('app','Products'), 'visible'=>AccessRule::checkRole(['product'])],
  // ['model' => 'category', 'route' => 'category/index', 'name' => Yii::t('app','Categories'), 'visible'=>AccessRule::checkRole(['category'])],
  ['model' => 'user', 'route' => 'user/index', 'name' => Yii::t('app','Member'), 'visible'=>AccessRule::checkRole(['user'])],
  // ['model' => 'member-news', 'route' => 'member-news/index', 'name' => Yii::t('app','Member News'), 'visible'=>AccessRule::checkRole(['memberNews'])],
  // ['model' => 'e-news-subscription', 'route' => 'e-news-subscription/index', 'name' => Yii::t('app','eNews Subscription'), 'visible'=>AccessRule::checkRole(['eNewsSubscription'])],
];

$application_menu = [
  ['model' => 'application', 'route' => 'application/index', 'name' => '申請表', 'visible'=>AccessRule::checkRole(['application'])],
  ['model' => 'application-mark', 'route' => 'application-mark/index', 'name' => '評分', 'visible'=>AccessRule::checkRole(['mark'])],
  ['model' => 'application', 'route' => 'application/visit-list', 'name' => '家訪紀錄', 'visible'=>AccessRule::checkRole(['visit'])],
  ['model' => 'application', 'route' => 'application/request-file-list', 'name' => '要求上載文件', 'visible'=>AccessRule::checkRole(['requestFile'])],
  ['model' => 'application', 'route' => 'application/response-file-list', 'name' => '已提交上載文件', 'visible'=>AccessRule::checkRole(['responseFile'])],
  ['model' => 'application', 'route' => 'application/approve-list', 'name' => '批核清單', 'visible'=>AccessRule::checkRole(['approve'])],
  ['model' => 'application', 'route' => 'application/allocate-list', 'name' => '編配單位', 'visible'=>AccessRule::checkRole(['allocate'])],
];

$household_menu = [
  // ['model' => 'household-activity', 'route' => 'household-activity/index', 'name' => '住戶活動', 'visible'=>AccessRule::checkRole(['user'])],
  // ['model' => 'user', 'route' => 'user/rental-payment-list', 'name' => '住戶上載交租文件', 'visible'=>AccessRule::checkRole(['rental'])],
  ['model' => 'user', 'route' => 'rental-payment/user-list', 'name' => '住戶上載交租文件', 'visible'=>AccessRule::checkRole(['rental'])],
];

$others_menu = [
  ['model' => 'about-us', 'route' => 'about-us/index', 'name' => '關於樂屋', 'visible'=>AccessRule::checkRole(['page.about'])],
  ['model' => 'pagetype11', 'route' => 'pagetype11/index', 'name' => '樂屋新項目', 'visible'=>AccessRule::checkRole(['page.newProject'])],
  ['model' => 'pagetype12', 'route' => 'pagetype12/index', 'name' => '樂屋項目', 'visible'=>AccessRule::checkRole(['page.project'])],
];


$donation_menu = [
  // ['model' => 'online-donation', 'route' => 'online-donation/index', 'name' => Yii::t('app','Online Donations'), 'visible'=>AccessRule::checkRole(['donation.online'])],
  // ['model' => 'in-kind-donation', 'route' => 'in-kind-donation/index', 'name' => Yii::t('app','In-Kind Donations'), 'visible'=>AccessRule::checkRole(['donation.inkind'])],
  // ['model' => 'donation-event', 'route' => 'donation-event/index', 'name' => Yii::t('app','Donation Events'), 'visible'=>AccessRule::checkRole(['donation.event'])],
];

$settings_menu = [
  ['model' => 'page/general', 'route' => 'page/general', 'name' => Yii::t('app','General'), 'visible'=>AccessRule::checkRole(['page.general'])],
  ['model' => 'site/file-browser', 'route' => 'site/file-browser', 'name' => Yii::t('app','File Browser'), 'visible'=>AccessRule::checkRole(['fileBrowser'])],
//   ['model' => 'logo', 'route' => 'logo/index', 'name' => Yii::t('app','Upload Logos'), 'visible'=>AccessRule::checkRole(['admin'])],
  // ['model' => 'banner', 'route' => 'banner/index', 'name' => Yii::t('app','Banners'), 'visible'=>AccessRule::checkRole(['banner'])],
  ['model' => 'menu', 'route' => 'menu/index', 'name' => Yii::t('app','Menu'), 'visible'=>AccessRule::checkRole(['menu'])]
];

// $others_menu = [
//   ['model' => 'lstgame140', 'route' => 'lstgame140/index', 'name' => '「眼明手快」網上有獎遊戲', 'visible'=>AccessRule::checkRole(['lstgame140'])],
// ];

$admin_menu = [
  ['model' => 'admin-user', 'route' => 'admin-user/index', 'name' => Yii::t('app','Admin Users'), 'visible'=>AccessRule::checkRole(['admin.user'])],
  ['model' => 'admin-group', 'route' => 'admin-group/index', 'name' => Yii::t('app','Admin Groups'), 'visible'=>AccessRule::checkRole(['admin.group'])],
  ['model' => 'admin-log', 'route' => 'admin-log/index', 'name' => Yii::t('app','Admin Logs'), 'visible'=>AccessRule::checkRole(['admin.log'])],
];

function generateSidebarMenuTreeview($model) {
    $result = [
        'html' => "",
        'active' => (isset(Yii::$app->params['MID']) && Yii::$app->params['MID'] == $model->id) ? true : false
    ];
    $_subMenus = $model->getSubMenu()->orderBy(['seq' => SORT_ASC])->all();

    if (sizeof($_subMenus) > 0) {
        if (!AccessRule::checkRole(['page.top.'.$model->id, 'page.'.$model->id, 'page.allpages']))
            return ;
        $_subMenus_html = "";
        foreach ($_subMenus as $_subMenu) {
            $_subMenu_result = generateSidebarMenuTreeview($_subMenu);
            $_subMenus_html .= $_subMenu_result['html'];
            if ($_subMenu_result['active'])
                $result['active'] = true;
        }
        $result['html'] .= '<li class="treeview'.($result['active'] ? ' active' : '').'">
          <a href="#">
            <span>'.$model->name.'</span>
            <i class="fa fa-angle-left pull-right"></i>
          </a>
          <ul class="treeview-menu">
            '.$_subMenus_html.'
          </ul>
        </li>';
    } else if ($model->page_type !== null && $model->page_type !== 0) {
        if (!AccessRule::checkRole(['page.'.$model->id, 'page.allpages']))
            return ;
        $result['html'] .= '<li class="'.($result['active'] ? 'active' : '').'">
            '.Html::a($model->name, ['/page/edit', 'id' => $model->id], ['class'=>'fa']).'
          </li>';
    }

    return $result;
}

?>
 <!-- <ul class="sidebar-menu scrollable-menu" role="menu" style="height: auto;max-height: 650px; overflow-x: hidden;"> -->

<ul class="sidebar-menu">

<?php if (in_array(true, ArrayHelper::getColumn($ecommerce_menu, 'visible'))) { ?>
  <li class="header">USER</li>

<?php foreach($ecommerce_menu as $m):?>
  <?php if(isset($m['visible']) && $m['visible']):?>
    <li class="treeview <?= ($this->context->route==$m['route'] || $base_name==$m['model'])? 'active':NULL?>">
      <?= Html::a($m['name'], [$m['route']], ['class'=>'fa']) ?>
    </li>
  <?php endif?>
<?php endforeach;?>
<?php } ?>

<?php if (in_array(true, ArrayHelper::getColumn($application_menu, 'visible'))) { ?>
  <li class="header">APPLICATION</li>

<?php foreach($application_menu as $m):?>
  <?php if(isset($m['visible']) && $m['visible']):?>
    <li class="treeview <?= ($this->context->route==$m['route'] || $base_name==$m['model'])? 'active':NULL?>">
      <?= Html::a($m['name'], [$m['route']], ['class'=>'fa']) ?>
    </li>
  <?php endif?>
<?php endforeach;?>
<?php } ?>

<?php if (in_array(true, ArrayHelper::getColumn($household_menu, 'visible'))) { ?>
  <li class="header">HOUSEHOLD</li>

<?php foreach($household_menu as $m):?>
  <?php if(isset($m['visible']) && $m['visible']):?>
    <li class="treeview <?= ($this->context->route==$m['route'] || $base_name==$m['model'])? 'active':NULL?>">
      <?= Html::a($m['name'], [$m['route']], ['class'=>'fa']) ?>
    </li>
  <?php endif?>
<?php endforeach;?>
<?php } ?>

<?php if (in_array(true, ArrayHelper::getColumn($donation_menu, 'visible'))) { ?>
  <li class="header">DONATION</li>

<?php foreach($donation_menu as $m):?>
  <?php if(isset($m['visible']) && $m['visible']):?>
    <li class="treeview <?= ($this->context->route==$m['route'] || $base_name==$m['model'])? 'active':NULL?>">
      <?= Html::a($m['name'], [$m['route']], ['class'=>'fa']) ?>
    </li>
  <?php endif?>
<?php endforeach;?>
<?php } ?>

<?php if (AccessRule::checkRole(['page'])) { ?>
  <li class="header">PAGE EDITOR</li>
<?php if (AccessRule::checkRole(['page.home'])) { ?>
  <li class="treeview <?= ($this->context->route=='page/home')? 'active':NULL?>">
      <a href="#">
        <span><?= Yii::t('app','Home') ?></span>
        <i class="fa fa-angle-left pull-right"></i>
      </a>
      <ul class="treeview-menu">
        <li class="<?= ($this->context->route=='page/home' && Yii::$app->params['HID']==1)? 'active':NULL?>">
          <?= Html::a("頁底", ['/page/home', 'id' => 1], ['class'=>'fa']); ?>
        </li>
      </ul>
  </li>
<?php } ?>

  <?php
    $menus = \common\models\Menu::find()
                ->where(['MID'=>null])
                ->orderBy('seq')
                ->all();
    foreach($menus as $menu) {
        $menu_result = generateSidebarMenuTreeview($menu);
        echo $menu_result['html'];
    }
  ?>

<?php if (AccessRule::checkRole(['page.contactus'])) { ?>
  <li class="treeview <?= ($this->context->route=='page/contact-us')? 'active':NULL?>">
    <?= Html::a(Yii::t('app', 'Contact Us'), ['/page/contact-us'], ['class'=>'fa']);?>
  </li>
<?php } ?>

<?php } ?>

<?php if (in_array(true, ArrayHelper::getColumn($others_menu, 'visible'))) { ?>
  <li class="header">OTHER PAGE</li>

<?php foreach($others_menu as $m):?>
  <?php if(isset($m['visible']) && $m['visible']):?>
    <li class="treeview <?= ($this->context->route==$m['route'] || $base_name==$m['model'])? 'active':NULL?>">
      <?= Html::a($m['name'], [$m['route']], ['class'=>'fa']) ?>
    </li>
  <?php endif?>
<?php endforeach;?>
<?php } ?>

<?php if (in_array(true, ArrayHelper::getColumn($settings_menu, 'visible'))) { ?>
  <li class="header">SETTINGS</li>

<?php foreach($settings_menu as $m):?>
  <?php if(isset($m['visible']) && $m['visible']):?>
    <li class="treeview <?= ($this->context->route==$m['route'] || $base_name==$m['model'])? 'active':NULL?>">
      <?= Html::a($m['name'], [$m['route']], ['class'=>'fa']) ?>
    </li>
  <?php endif?>
<?php endforeach;?>
<?php } ?>

<?php if (in_array(true, ArrayHelper::getColumn($admin_menu, 'visible'))) { ?>
  <li class="header">ADMIN</li>

<?php foreach($admin_menu as $m):?>
  <?php if(isset($m['visible']) && $m['visible']):?>
    <li class="treeview <?= ($this->context->route==$m['route'] || $base_name==$m['model'])? 'active':NULL?>">
      <?= Html::a($m['name'], [$m['route']], ['class'=>'fa']) ?>
    </li>
  <?php endif?>
<?php endforeach;?>
<?php } ?>

</ul>
