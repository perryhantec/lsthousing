<?php

namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii\db\Expression;

class Definitions {

    public static function getBooleanDescription($index = false) {
      $array = [
          '1' => Yii::t('definitions','Yes'),
          '0' => Yii::t('definitions','No'),
      ];
      return $index !== false ? ($index===NULL || !isset($array[$index]))? NULL: $array[$index] : $array;
    }
    public static function getCanCannotDescription($index = false) {
      $array = [
          '1' => Yii::t('definitions','Can'),
          '0' => Yii::t('definitions','Cannot'),
      ];
      return $index !== false ? ($index===NULL || !isset($array[$index]))? NULL: $array[$index] : $array;
    }
    public static function getAllowNotAllowedDescription($index = false) {
      $array = [
          '1' => Yii::t('definitions','Allow'),
          '0' => Yii::t('definitions','Not Allowed'),
      ];
      return $index !== false ? ($index===NULL || !isset($array[$index]))? NULL: $array[$index] : $array;
    }
    //status
    public static function getStatus($index = false) {
      $array = [
          0 => Yii::t('definitions','Deactivate'),
          1 => Yii::t('definitions','Active'),
      ];
      return $index !== false ? ($index===NULL || !isset($array[$index]))? NULL: $array[$index] : $array;
    }
    //auth role
    public static function getRole($index = false, $min_role = 0) {
      $array = [
          User::ROLE_MEMBER => Yii::t('definitions','Member'),
      ];

      foreach ($array as $array_index => $array_value) {
          if ($array_index < $min_role)
            unset($array[$array_index]);
      }

      return $index !== false ? ($index===NULL || !isset($array[$index]))? NULL: $array[$index] : $array;
    }

    //menu list
    public static function getMenuList($index = false) {
      $models = Menu::find()->where(['MID' => null])->orderBy(['seq' => 'ASC'])->all();
      $array = ArrayHelper::map($models, 'id', 'name');
      $array = array_map(function($v) { return strip_tags($v); }, $array);
      return $index !== false ? ($index===NULL || !isset($array[$index]))? '': $array[$index] : $array;
    }

    //menu list
    public static function getParentMenuList($MID = null) {
      return Menu::getAllMenusForDropdown($MID, true, (Menu::MAX_LAYER-1), null, true);
    }


    //menu display
    public static function getMenuDisplay($index = false) {
      $array = [
          '1' => Yii::t('definitions','Yes'),
          '0' => Yii::t('definitions','No'),
      ];
      return $index !== false ? ($index===NULL || !isset($array[$index]))? NULL: $array[$index] : $array;
    }

    //menu type
    public static function getMenuType($index = false) {
      $array = [
          1 => Yii::t('definitions','Menu Level1'),
          2 => Yii::t('definitions','Menu Level2'),
          //3 => Yii::t('definitions','Menu Level3'),
      ];
      return $index !== false ? ($index===NULL || !isset($array[$index]))? NULL: $array[$index] : $array;
    }

    //page type
    public static function getPageType($index = false) {
      $array = [
          0 => Yii::t('definitions','Link'),
          1 => Yii::t('definitions','Page'),
          10 => Yii::t('definitions', 'Page (With Page Header and YouTube)'),
          // 3 => Yii::t('definitions','Gallery'),
//           2 => Yii::t('definitions','Video'),
          4 => Yii::t('definitions','Blog'),
          // 5 => Yii::t('definitions','File List'),
          // 7 => Yii::t('definitions', 'Committee Members'),
          // 8 => Yii::t('definitions', 'Job Opportunity'),
          // 9 => Yii::t('definitions', 'Tender Notice'),
          // 11 => 'Blog (New Project)',
          // 12 => 'Blog (Current Project)',
      ];
      return $index !== false ? ($index===NULL || !isset($array[$index]))? NULL: $array[$index] : $array;
    }

    //page type 2 category
    public static function getPageType2Category($index = false, $MID, $lang=NULL) {
      $array = [];
      $models = \common\models\PageType2Category::findAll(['MID' => $MID]);
      foreach($models as $model){
        if($lang=='zh-TW'){
          $array[$model->id] = $model->name_tw;
        }elseif($lang=='en'){
          $array[$model->id] = $model->name_en;
        }else{
          $array[$model->id] = $model->name_tw.' '.$model->name_en;
        }
      }
      return $index !== false ? ($index===NULL || !isset($array[$index]))? '': $array[$index] : $array;
    }

    public static function getPageType2PressDocType($index = false) {
      $array = [
          1 => Yii::t('app','Link'),
          2 => Yii::t('app','File'),
      ];
      return $index !== false ? ($index===NULL || !isset($array[$index]))? NULL: $array[$index] : $array;
    }

    public static function getPageType3DisplayAtAllYear($MID) {
      $max_display_at = \common\models\PageType3::find()->where(['MID' => $MID, 'status' => 1])->max('display_at');
      $min_display_at = \common\models\PageType3::find()->where(['MID' => $MID, 'status' => 1])->min('display_at');

      if ($max_display_at == null && $min_display_at == null)
        return [];
      else if ($max_display_at == null)
        return [$min_display_at => $min_display_at];
      else if ($min_display_at == null)
        return [$max_display_at => $max_display_at];

      $max_year = date('Y', strtotime($max_display_at));
      $min_year = date('Y', strtotime($min_display_at));

      $array = [];
      for ($year = $max_year; $year >= $min_year; $year--)
        $array[$year] = $year;

      return $array;
    }

    public static function getPageType4DisplayAtAllYear($MID) {
      $max_display_at = \common\models\PageType4::find()->where(['MID' => $MID, 'status' => 1])->max('display_at');
      $min_display_at = \common\models\PageType4::find()->where(['MID' => $MID, 'status' => 1])->min('display_at');

      if ($max_display_at == null && $min_display_at == null)
        return [];
      else if ($max_display_at == null)
        return [$min_display_at => $min_display_at];
      else if ($min_display_at == null)
        return [$max_display_at => $max_display_at];

      $max_year = date('Y', strtotime($max_display_at));
      $min_year = date('Y', strtotime($min_display_at));

      $array = [];
      for ($year = $max_year; $year >= $min_year; $year--)
        $array[$year] = $year;

      return $array;
    }

    public static function getPageType11DisplayAtAllYear($MID) {
      $max_display_at = \common\models\PageType11::find()->where(['MID' => $MID, 'status' => 1])->max('display_at');
      $min_display_at = \common\models\PageType11::find()->where(['MID' => $MID, 'status' => 1])->min('display_at');

      if ($max_display_at == null && $min_display_at == null)
        return [];
      else if ($max_display_at == null)
        return [$min_display_at => $min_display_at];
      else if ($min_display_at == null)
        return [$max_display_at => $max_display_at];

      $max_year = date('Y', strtotime($max_display_at));
      $min_year = date('Y', strtotime($min_display_at));

      $array = [];
      for ($year = $max_year; $year >= $min_year; $year--)
        $array[$year] = $year;

      return $array;
    }

    public static function getPageType12DisplayAtAllYear($MID) {
      $max_display_at = \common\models\PageType12::find()->where(['MID' => $MID, 'status' => 1])->max('display_at');
      $min_display_at = \common\models\PageType12::find()->where(['MID' => $MID, 'status' => 1])->min('display_at');

      if ($max_display_at == null && $min_display_at == null)
        return [];
      else if ($max_display_at == null)
        return [$min_display_at => $min_display_at];
      else if ($min_display_at == null)
        return [$max_display_at => $max_display_at];

      $max_year = date('Y', strtotime($max_display_at));
      $min_year = date('Y', strtotime($min_display_at));

      $array = [];
      for ($year = $max_year; $year >= $min_year; $year--)
        $array[$year] = $year;

      return $array;
    }

    //page type 4 category
    public static function getPageType4Category($index = false, $MID, $lang=NULL) {
      $models = \common\models\PageType4Category::findAll(['MID' => $MID]);
      $array = ArrayHelper::map($models, 'id', 'name');
      return $index !== false ? ($index===NULL || !isset($array[$index]))? '': $array[$index] : $array;
    }

    //page type 5 category
    public static function getPageType5Category($index = false, $MID, $lang=NULL) {
       $array = [];
      $models = \common\models\PageType5Category::findAll(['MID' => $MID, 'status' => 1]);
      $array = ArrayHelper::map($models, 'id', 'name');
      return $index !== false ? ($index==NULL || !isset($array[$index]))? '': $array[$index] : $array;
    }

    public static function getPageType5PressDocType($index = false) {
      $array = [
          1 => Yii::t('app','Link'),
          2 => Yii::t('app','File'),
      ];
      return $index !== false ? ($index==NULL || !isset($array[$index]))? NULL: $array[$index] : $array;
    }

    public static function getCategoryStatus($index = false) {
      $array = [
          1 => Yii::t('definitions','Active'),
//           2 => Yii::t('definitions','Hidden'),
          0 => Yii::t('definitions','Deactivate'),
      ];
      return $index !== false ? ($index===NULL || !isset($array[$index]))? NULL: $array[$index] : $array;
    }

    public static function getProductStatus($index = false) {
      $array = [
          1 => Yii::t('definitions','Active'),
          0 => Yii::t('definitions','Deactivate'),
      ];
      return $index !== false ? ($index===NULL || !isset($array[$index]))? NULL: $array[$index] : $array;
    }

    public static function getProductCategories($index = false, $activeOnly = true, $asModel = false) {
      $model = Category::find()->where(['category_id' => null])->orderBy(['seq'=>SORT_ASC, 'id'=>SORT_ASC]);
      if ($activeOnly)
        $model->andWhere(['status' => 1]);
      $model = $model->all();

      $array = [];

      $category_oname = $activeOnly ? 'activeCategories' : 'categories';

      foreach ($model as $category) {
          if ($category->{$category_oname}) {
              foreach ($category->{$category_oname} as $sub_category) {

                  if ($sub_category->{$category_oname}) {
                      foreach ($sub_category->{$category_oname} as $sub_sub_category) {
                          $array[$sub_sub_category->id] = $asModel ? $sub_sub_category : $sub_sub_category->nameWithParentCategories;
                      }
                  } else {
                      $array[$sub_category->id] = $asModel ? $sub_category : $sub_category->nameWithParentCategories;
                  }
              }
          } else {
                  $array[$category->id] = $asModel ? $category : $category->nameWithParentCategories;
          }
      }

      return $index !== false ? ($index===NULL || !isset($array[$index]))? NULL: $array[$index] : $array;
    }

    public static function getTopCategory($index = false, $activeOnly = true) {
      $model = Category::find()->where(['category_id' => null])->orderBy(['seq'=>SORT_ASC, 'id'=>SORT_ASC]);
      if ($activeOnly)
        $model->andWhere(['status' => 1]);
      $model = $model->all();

      $array = [];

      $category_oname = $activeOnly ? 'activeCategories' : 'categories';

      foreach ($model as $category) {
          $array[$category->id] = $category->name;
          if ($category->{$category_oname}) {
              foreach ($category->{$category_oname} as $sub_category) {
                  $array[$sub_category->id] = $sub_category->nameWithParentCategories;
              }
          }
      }

      return $index !== false ? ($index===NULL || !isset($array[$index]))? NULL: $array[$index] : $array;
    }

    public static function getRankingList($index = false) {
      $array = [
        0 => '0',
        1 => '1',
        2 => '2',
        3 => '3',
        4 => '4',
        5 => '5',
        6 => '6',
        7 => '7',
        8 => '8',
        9 => '9',
        10 => '10'
      ];
      return $index !== false ? ($index===NULL || !isset($array[$index]))? NULL: $array[$index] : $array;
    }

    public static function getOrderDeliveryMethod($index = false) {
      $array = [
          Order::DELIVERY_METHOD_PICKUP => Yii::t('app', 'Collect at Lok Sin Tong Office'),
          Order::DELIVERY_METHOD_DELIVERY => Yii::t('app', 'By Mail'),
          Order::DELIVERY_METHOD_SFEXPRESS => Yii::t('app', 'By SF Express (Delivery fee paid by Buyers)'),
          Order::DELIVERY_METHOD_NAVG => Yii::t('app', 'Not applicable for Virtual Gift campaign'),
      ];
      return $index !== false ? ($index===NULL || !isset($array[$index]))? NULL: $array[$index] : $array;
    }

    public static function getOrderDeliveryMethodForCheckout($index = false) {
      $array = [
          Order::DELIVERY_METHOD_PICKUP => Yii::t('app', 'Collect at Lok Sin Tong Office'),
//           Order::DELIVERY_METHOD_DELIVERY => Yii::t('app', 'By Mail'),
          Order::DELIVERY_METHOD_SFEXPRESS => Yii::t('app', 'By SF Express (Delivery fee paid by Buyers)'),
          Order::DELIVERY_METHOD_NAVG => Yii::t('app', 'Not applicable for Virtual Gift campaign'),
      ];
      return $index !== false ? ($index===NULL || !isset($array[$index]))? NULL: $array[$index] : $array;
    }

    public static function getDeliveryAddressDistrict($index = false) {
      $array = [
/*
          1 => Yii::t('definitions', 'Hong Kong'),
          2 => Yii::t('definitions', 'Kowloon'),
          3 => Yii::t('definitions', 'New Territories'),
*/
          101 => Yii::t('district', 'Central and Western'), // 中西區
          102 => Yii::t('district', 'Eastern'), // 東區
          103 => Yii::t('district', 'Southern'), // 南區
          104 => Yii::t('district', 'Wan Chai'), // 灣仔區
          201 => Yii::t('district', 'Sham Shui Po'), // 深水埗區
          202 => Yii::t('district', 'Kowloon City'), // 九龍城區
          203 => Yii::t('district', 'Kwun Tong'), // 觀塘區
          204 => Yii::t('district', 'Wong Tai Sin'), // 黃大仙區
          205 => Yii::t('district', 'Yau Tsim Mong'), // 油尖旺區
          301 => Yii::t('district', 'Islands'), // 離島區
          302 => Yii::t('district', 'Kwai Tsing'), // 葵青區
          303 => Yii::t('district', 'North'), // 北區
          304 => Yii::t('district', 'Sai Kung'), // 西貢區
          305 => Yii::t('district', 'Sha Tin'), // 沙田區
          306 => Yii::t('district', 'Tai Po'), // 大埔區
          307 => Yii::t('district', 'Tsuen Wan'), // 荃灣區
          308 => Yii::t('district', 'Tuen Mun'), // 屯門區
      ];
      return $index !== false ? ($index===NULL || !isset($array[$index]))? NULL: $array[$index] : $array;
    }

    public static function getDeliveryAddressDistrictWithGroup($index = false) {
      $array = [
          Yii::t('district', 'Hong Kong Island') => [
            101 => Yii::t('district', 'Central and Western'), // 中西區
            102 => Yii::t('district', 'Eastern'), // 東區
            103 => Yii::t('district', 'Southern'), // 南區
            104 => Yii::t('district', 'Wan Chai'), // 灣仔區
          ],
          Yii::t('district', 'Kowloon') => [
            201 => Yii::t('district', 'Sham Shui Po'), // 深水埗區
            202 => Yii::t('district', 'Kowloon City'), // 九龍城區
            203 => Yii::t('district', 'Kwun Tong'), // 觀塘區
            204 => Yii::t('district', 'Wong Tai Sin'), // 黃大仙區
            205 => Yii::t('district', 'Yau Tsim Mong'), // 油尖旺區
          ],
          Yii::t('district', 'New Territories') => [
            301 => Yii::t('district', 'Islands'), // 離島區
            302 => Yii::t('district', 'Kwai Tsing'), // 葵青區
            303 => Yii::t('district', 'North'), // 北區
            304 => Yii::t('district', 'Sai Kung'), // 西貢區
            305 => Yii::t('district', 'Sha Tin'), // 沙田區
            306 => Yii::t('district', 'Tai Po'), // 大埔區
            307 => Yii::t('district', 'Tsuen Wan'), // 荃灣區
            308 => Yii::t('district', 'Tuen Mun'), // 屯門區
            309 => Yii::t('district', 'Yuen Long') // 元朗區
          ]
      ];
      return $index !== false ? ($index===NULL || !isset($array[$index]))? NULL: $array[$index] : $array;
    }

    public static function getOrderPaymentMethod($index = false) {
      $array = [
        Order::PAYMENT_PAYPAL => Yii::t('payment', 'PayPal'),
        Order::PAYMENT_ALIPAY => Yii::t('payment', 'AlipayHK'),
        Order::PAYMENT_FPS => Yii::t('payment', 'Faster Payment System (FPS)'),
//           Order::PAYMENT_CREDIT_CARD => Yii::t('app', 'Credit Card'),
//           Order::PAYMENT_CASH => Yii::t('app', 'Cash'),
//           Order::PAYMENT_CHEQUE => Yii::t('app', 'Cheque'),
//           Order::PAYMENT_PAYPAL => Yii::t('app', 'PayPal'),
//           Order::PAYMENT_BANKIN => Yii::t('app', 'Direct Bank-in'),
      ];
      return $index !== false ? ($index===NULL || !isset($array[$index]))? NULL: $array[$index] : $array;
    }

    public static function getOrderStatus($index = false, $min_status = 0) {
      $array = [
        Order::STATUS_CANCELED => Yii::t('definitions', 'Canceled'),
        Order::STATUS_START => Yii::t('definitions', 'Shopping'),
        Order::STATUS_CHECKOUT => Yii::t('definitions', 'Checkout processing'),
        Order::STATUS_CHECKOUT_FORM_SUBMITED => Yii::t('definitions', 'Checkout form submitted'),
        Order::STATUS_CHECKOUT_SUBMITED => Yii::t('definitions', 'Checkout submitted'),
        Order::STATUS_CHECKOUT_DONE => Yii::t('definitions', 'Checkout done'),
        Order::STATUS_CHECKOUT_PAYMENT => Yii::t('definitions', 'Payment processing'),
        Order::STATUS_CREDIT_CARD_PAYMENT => Yii::t('definitions', 'Online payment processing'),
        Order::STATUS_CREDIT_CARD_PAYMENT_FAILED => Yii::t('definitions', 'Online payment failed'),
        Order::STATUS_ORDER_SUBMITED => Yii::t('definitions', 'Order submitted'),
        Order::STATUS_WAITING_FOR_BANKIN => Yii::t('definitions', 'Waiting for Direct Bank-in'),
        Order::STATUS_WAITING_FOR_CONFIRM_BANKIN => Yii::t('definitions', 'Waiting for Direct Bank-in confirmation'),
        Order::STATUS_WAITING_FOR_CONFIRM => Yii::t('definitions', 'Waiting for confirmation'),
        Order::STATUS_CONFIRMED => Yii::t('definitions', 'Confirmed'),
        Order::STATUS_TO_BE_SHIPPED => Yii::t('definitions', 'To be shipped'),
        Order::STATUS_SHIPPED => Yii::t('definitions', 'Shipped'),
        Order::STATUS_END => Yii::t('definitions', 'Finish'),
      ];

      foreach ($array as $array_index => $array_value) {
          if ($array_index < $min_status && $array_index >= 0)
            unset($array[$array_index]);
      }

      return $index !== false ? ($index===NULL || !isset($array[$index]))? NULL: $array[$index] : $array;
    }

    public static function getOrderItemQty($index = false) {
        $array = [];
        for ($i=1; $i<=99; $i++)
            $array[$i] = $i;

        return $index !== false ? ($index===NULL || !isset($array[$index]))? NULL: $array[$index] : $array;
    }

    public static function getDonationEvent($index = false, $allRecord = false) {
        $array = [];
        $query = \common\models\DonationEvent::find()->orderBy(new Expression('IF(`id`=0, 1, 0) ASC, `seq`, `id` DESC'));
        if ($allRecord != true)
            $query->where(['status' => 1]);
        $array = ArrayHelper::map($query->all(), 'id', 'name');

        return $index !== false ? ($index==NULL || !isset($array[$index]))? '': $array[$index] : $array;
    }

    public static function getDonationType($index = false) {
      $array = [
        Donation::TYPE_ONCE => Yii::t('donation', 'One-off Donation'),
        Donation::TYPE_MONTHLY => Yii::t('donation', 'Monthly Donation')
      ];
      return $index !== false ? ($index===NULL || !isset($array[$index]))? NULL: $array[$index] : $array;
    }

    public static function getDonationReceipt($index = false) {
      $array = [
        Donation::RECEIPT_ONCE => Yii::t('donation', 'Please issue one-off donation receipt'),
        Donation::RECEIPT_YEALY => Yii::t('donation', 'Please issue yearly donation receipt'),
        Donation::RECEIPT_ONCE_MAIL => Yii::t('donation', 'Please issue one-off donation receipt by mail'),
        Donation::RECEIPT_ONCE_EMAIL => Yii::t('donation', 'Please issue one-off donation receipt by email'),
        Donation::RECEIPT_NO => Yii::t('donation', 'To save administration costs, no donation receipt is required')
      ];
      return $index !== false ? ($index===NULL || !isset($array[$index]))? NULL: $array[$index] : $array;
    }

    public static function getDonationReceiptFrontend($index = false) {
      $array = [
//         Donation::RECEIPT_ONCE => Yii::t('donation', 'Please issue one-off donation receipt'),
//         Donation::RECEIPT_YEALY => Yii::t('donation', 'Please issue yearly donation receipt'),
        Donation::RECEIPT_ONCE_MAIL => Yii::t('donation', 'Please issue one-off donation receipt by mail'),
        Donation::RECEIPT_ONCE_EMAIL => Yii::t('donation', 'Please issue one-off donation receipt by email'),
        Donation::RECEIPT_NO => Yii::t('donation', 'To save administration costs, no donation receipt is required')
      ];
      return $index !== false ? ($index===NULL || !isset($array[$index]))? NULL: $array[$index] : $array;
    }

    public static function getDonationPaymentMethod($index = false) {
      $array = [
        Donation::PAYMENTMETHOD_PAYPAL => Yii::t('donation', 'Online Donation - PayPal'),
//         Donation::PAYMENTMETHOD_PPS => Yii::t('donation', 'Online Donation - PPS'),
        Donation::PAYMENTMETHOD_ALIPAYHK => Yii::t('donation', 'Online Donation - Alipay HK'),
        Donation::PAYMENTMETHOD_ONLINE_FPS => Yii::t('donation', 'Online Donation - Faster Payment System (FPS)'),
        Donation::PAYMENTMETHOD_PPS => Yii::t('donation', 'By PPS'),
        Donation::PAYMENTMETHOD_FPS => Yii::t('donation', 'By Faster Payment System (FPS)'),
        Donation::PAYMENTMETHOD_CHEQUE => Yii::t('donation', 'By Cheque'),
        Donation::PAYMENTMETHOD_CASH => Yii::t('donation', 'By Cash / Direct Transfer'),
        Donation::PAYMENTMETHOD_BANK_AUTO => Yii::t('donation', 'By Bank Account Monthly Autopay'),
      ];
      return $index !== false ? ($index===NULL || !isset($array[$index]))? NULL: $array[$index] : $array;
    }

    public static function getDonationStatus($index = false, $min_status = 0) {
      $array = [
        Donation::STATUS_CANCELED => Yii::t('definitions', 'Canceled'),
        Donation::STATUS_FORM_SUBMITTED => Yii::t('definitions', 'Form submitted'),
        Donation::STATUS_ONLINE_PAYMENT_FAILED => Yii::t('definitions', 'Online payment failed'),
        Donation::STATUS_ONLINE_PAYMENT => Yii::t('definitions', 'Online payment processing'),
        Donation::STATUS_WAITING_FOR_CONFIRM => Yii::t('definitions', 'Waiting for confirmation'),
        Donation::STATUS_CONFIRMED => Yii::t('definitions', 'Confirmed'),
        Donation::STATUS_END => Yii::t('definitions', 'Finish'),
      ];

      foreach ($array as $array_index => $array_value) {
          if ($array_index < $min_status && $array_index >= 0)
            unset($array[$array_index]);
      }

      return $index !== false ? ($index===NULL || !isset($array[$index]))? NULL: $array[$index] : $array;
    }

    public static function getInKindDonationStatus($index = false, $min_status = 0) {
      $array = [
        InkindDonation::STATUS_CANCELED => Yii::t('definitions', 'Canceled'),
        InkindDonation::STATUS_SUBMITED => Yii::t('definitions', 'Form submitted'),
        InkindDonation::STATUS_WAITING_FOR_PROCESS => Yii::t('definitions', 'Waiting for process'),
        InkindDonation::STATUS_CONFIRMED => Yii::t('definitions', 'Confirmed'),
        InkindDonation::STATUS_END => Yii::t('definitions', 'Finish'),
      ];

      foreach ($array as $array_index => $array_value) {
          if ($array_index < $min_status && $array_index >= 0)
            unset($array[$array_index]);
      }

      return $index !== false ? ($index===NULL || !isset($array[$index]))? NULL: $array[$index] : $array;
    }

    public static function getPaymentMethod($index = false) {
      $array = [
        Payment::METHOD_PAYPAL_PAYMENT => Yii::t('payment', 'PayPal'),
        Payment::METHOD_PAYPAL_AGREEMENT => Yii::t('payment', 'PayPal (Subscriptions)'),
        Payment::METHOD_PPS => Yii::t('payment', 'PPS'),
        Payment::METHOD_ALIPAY => Yii::t('payment', 'AlipayHK'),
        Payment::METHOD_FPS => Yii::t('payment', 'Faster Payment System (FPS)'),
      ];
      return $index !== false ? ($index===NULL || !isset($array[$index]))? NULL: $array[$index] : $array;
    }

    public static function getPaymentStatus($index = false, $min_status = 0) {
      $array = [
        Payment::STATUS_START => Yii::t('payment', 'Start'),
        Payment::STATUS_WAITING => Yii::t('payment', 'Waiting for complete'),
        Payment::STATUS_DONE => Yii::t('payment', 'Done'),
        Payment::STATUS_CANCEL => Yii::t('payment', 'Cancel'),
        Payment::STATUS_FAIL => Yii::t('payment', 'Fail'),
      ];

      foreach ($array as $array_index => $array_value) {
          if ($array_index < $min_status && $array_index >= 0)
            unset($array[$array_index]);
      }

      return $index !== false ? ($index===NULL || !isset($array[$index]))? NULL: $array[$index] : $array;
    }
    //auth role
    public static function getAdminRole($index = false, $min_role = 0) {
      $array = [
          AdminUser::ROLE_SUPERADMIN => Yii::t('definitions','Super Admin'),
          AdminUser::ROLE_ADMIN => Yii::t('definitions','Admin'),
          AdminUser::ROLE_USER => Yii::t('definitions','User'),
      ];

      foreach ($array as $array_index => $array_value) {
          if ($array_index < $min_role)
            unset($array[$array_index]);
      }

      return $index !== false ? ($index===NULL || !isset($array[$index]))? NULL: $array[$index] : $array;
    }

    public static function getAdminGroup($index = false, $allRecord = false) {
        $array = [];
        $query = \common\models\AdminGroup::find()->orderBy(['name' => SORT_ASC, 'id' => SORT_DESC]);
        if ($allRecord != true)
            $query->where(['status' => 1]);

        $array = ArrayHelper::map($query->all(), 'id', 'name');
        return $index !== false ? ($index==NULL || !isset($array[$index]))? '': $array[$index] : $array;
    }

    public static function getAdminUser($index = false, $allRecord = false, $userOnly = false) {
        $array = [];
        $query = \common\models\AdminUser::find()->orderBy(['name' => SORT_ASC, 'id' => SORT_DESC]);
        if ($allRecord != true)
            $query->andWhere(['status' => 1]);
        if ($userOnly == true)
            $query->andWhere(['role' => AdminUser::ROLE_USER]);

        $array = ArrayHelper::map($query->all(), 'id', 'nameWithEmail');
        return $index !== false ? ($index==NULL || !isset($array[$index]))? '': $array[$index] : $array;
    }

    public static function getHousingStatus($index = false) {
      $array = [
          1 => '前期顧問評估中',
          2 => '興建中',
          3 => '改裝工程中',
          4 => '快將入伙',
          5 => '正式入伙',
      ];
      return $index !== false ? ($index===NULL || !isset($array[$index]))? NULL: $array[$index] : $array;
    }

    public static function getNoOfPeople($index = false) {
      $array = [];
      for ($i=1; $i<=6; $i++)
          $array[$i] = $i;

      return $index !== false ? ($index===NULL || !isset($array[$index]))? NULL: $array[$index] : $array;
    }
    public static function getProjectName($index = false) {
      $array = [];
      $models = \common\models\PageType12::find()->where(['status' => 1])->orderby(['display_at' => SORT_DESC])->all();
      $array = ArrayHelper::map($models, 'id', 'title_tw');
      return $index !== false ? ($index==NULL || !isset($array[$index]))? '': $array[$index] : $array;
    }
    public static function getOpenProjectName($index = false) {
      $array = [];
      $models = \common\models\PageType12::find()->where(['is_open' => 1, 'status' => 1])->orderby(['display_at' => SORT_DESC])->all();
      $array = ArrayHelper::map($models, 'id', 'title_tw');
      return $index !== false ? ($index==NULL || !isset($array[$index]))? '': $array[$index] : $array;
    }
    public static function getProjectLocation($index = false) {
      $array = [];
      $models = \common\models\PageType12::find()->where(['status' => 1])->orderby(['display_at' => SORT_DESC])->all();
      $array = ArrayHelper::map($models, 'id', 'housing_location');
      return $index !== false ? ($index==NULL || !isset($array[$index]))? '': $array[$index] : $array;
    }
    public static function getAreaDistrict($index = false) {
      // $array = [
      //   1 => '中西區', 2 => '東區', 3 => '南區', 4 => '灣仔區',
      //   5 => '九龍城區', 6 => '觀塘區', 7 => '深水埗區', 8 => '黃大仙區', 9 => '油尖旺區',
      //   10 => '離島區', 11 => '葵青區', 12 => '北區', 13 => '西貢區', 14 => '沙田區', 15 => '大埔區', 16 => '荃灣區', 17 => '屯門區', 18 => '元朗區', 
      // ];
      $array = [
        '香港' => [1 => '中西區', 2 => '東區', 3 => '南區', 4 => '灣仔區',],
        '九龍' => [5 => '九龍城區', 6 => '觀塘區', 7 => '深水埗區', 8 => '黃大仙區', 9 => '油尖旺區',],
        '新界' => [10 => '離島區', 11 => '葵青區', 12 => '北區', 13 => '西貢區', 14 => '沙田區', 15 => '大埔區', 16 => '荃灣區', 17 => '屯門區', 18 => '元朗區',],
      ];
      return $index !== false ? ($index==NULL || !isset($array[$index]))? '': $array[$index] : $array;
    }
    public static function getHouseType($index = false) {
      $array = [1 => '租住私人樓宇', 2 => '租住酒店或賓館', 3 => '與家人同住', 4 => '暫住親友家', 5 => '露宿', 6 => '其他'];
      return $index !== false ? ($index==NULL || !isset($array[$index]))? '': $array[$index] : $array;
    }
    public static function getPrivateType($index = false) {
      $array = [1 => '獨立單位', 2 => '板間房', 3 => '劏房', 4 => '天台屋', 5 => '床位', 6 => '工厦', 7 => '寮屋', 8 => '鐵皮屋'];
      return $index !== false ? ($index==NULL || !isset($array[$index]))? '': $array[$index] : $array;
    }
    public static function getTogetherType($index = false) {
      $array = [1 => '公屋', 2 => '其他'];
      return $index !== false ? ($index==NULL || !isset($array[$index]))? '': $array[$index] : $array;
    }
    public static function getLiveYear($index = false) {
      $array = [
        0  =>  '0',  1 =>  '1',  2 =>  '2',  3 =>  '3',  4 =>  '4',  5 =>  '5',  6 =>  '6',  7 =>  '7',  8 =>  '8',  9 =>  '9',
        10 => '10', 11 => '11', 12 => '12', 13 => '13', 14 => '14', 15 => '15', 16 => '16', 17 => '17', 18 => '18', 19 => '19',
        20 => '20', 21 => '20年以上'
      ];
      return $index !== false ? ($index==NULL || !isset($array[$index]))? '': $array[$index] : $array;
    }
    public static function getLiveMonth($index = false) {
      $array = [
        1 => '1', 2 => '2', 3 => '3', 4 => '4', 5 => '5', 6 => '6', 7 => '7', 8 => '8', 9 => '9', 10 => '10', 11 => '11'
      ];
      return $index !== false ? ($index==NULL || !isset($array[$index]))? '': $array[$index] : $array;
    }
    public static function getPrh($index = false) {
      $array = [
        1 => '有', 2 => '沒有',
      ];
      return $index !== false ? ($index==NULL || !isset($array[$index]))? '': $array[$index] : $array;
    }
    public static function getPrhLocation($index = false) {
      $array = [1 => '市區', 2 => '擴展', 3 => '新界'];
      return $index !== false ? ($index==NULL || !isset($array[$index]))? '': $array[$index] : $array;
    }
    public static function getGender($index = false) {
      $array = [1 => '男', 2 => '女'];
      return $index !== false ? ($index==NULL || !isset($array[$index]))? '': $array[$index] : $array;
    }
    public static function getBornType($index = false) {
      $array = [1 => '17 歲或以下', 2 => '60 歲或以上'];
      return $index !== false ? ($index==NULL || !isset($array[$index]))? '': $array[$index] : $array;
    }
    public static function getIdType($index = false) {
      $array = [
        1 => '香港永久性居民身份證', 2 => '香港居民身份證', 3 => '香港出生證明書(適用於未滿11 歲人士)',
        4 => '回港證', 5 => '簽證身份書', 6 => '前往港澳通行證(即單程證)', 7 => '其他'
      ];
      return $index !== false ? ($index==NULL || !isset($array[$index]))? '': $array[$index] : $array;
    }
    public static function getMarriageStatus($index = false) {
      $array = [
        1 => '未婚', 2 => '已婚', 3 => '離婚', 4 => '喪偶', 5 => '正辦理離婚',
      ];
      return $index !== false ? ($index==NULL || !isset($array[$index]))? '': $array[$index] : $array;
    }
    public static function getWorkingStatus($index = false) {
      $array = [
        1 => '全職', 2 => '兼職', 3 => '待業', 4 => '退休', 5 => '主婦', 6 => '在學', 7 => '其他',
      ];
      return $index !== false ? ($index==NULL || !isset($array[$index]))? '': $array[$index] : $array;
    }
    public static function getFamilyMemberWorkingStatus($index = false) {
      $array = [
        1 => '全職', 2 => '兼職', 3 => '待業', 4 => '退休', 5 => '主婦', 6 => '在學', 7 => '未入學', 8 => '其他',
      ];
      return $index !== false ? ($index==NULL || !isset($array[$index]))? '': $array[$index] : $array;
    }
    public static function getFundingType($index = false) {
      $array = [
        1 => '綜合社會保障援助 (綜援)', 2 => '高齡津貼', 3 => '長者生活津貼',
        4 => '傷殘津貼(包括普通和高額津貼)', 5 => '半額及全額書簿津貼', 6 => '其他',
      ];
      return $index !== false ? ($index==NULL || !isset($array[$index]))? '': $array[$index] : $array;
    }
    public static function getFundingType2($index = false) {
      $array = [
        1 => '是', 2 => '否',
      ];
      return $index !== false ? ($index==NULL || !isset($array[$index]))? '': $array[$index] : $array;
    }
    public static function getAsset($index = false) {
      $array = [
        1 => '有', 2 => '沒有',
      ];
      return $index !== false ? ($index==NULL || !isset($array[$index]))? '': $array[$index] : $array;
    }
    public static function getSingleParents($index = false) {
      $array = [
        1 => '是', 2 => '否',
      ];
      return $index !== false ? ($index==NULL || !isset($array[$index]))? '': $array[$index] : $array;
    }
    public static function getPregnant($index = false) {
      $array = [
        1 => '有', 2 => '沒有',
      ];
      return $index !== false ? ($index==NULL || !isset($array[$index]))? '': $array[$index] : $array;
    }
    public static function getPart5Terms($index = false) {
      $array = [
        1 => '本人填報申請表前，已明白本計劃的申請程序、申請資料、評審準則等內容。本人承諾將會遵守計劃內一切已訂定或將因應情況而修訂的申請和編配房屋政策及安排，而九龍樂善堂（下稱本堂）將擁有房屋編配的最終決定權。', 
        2 => '本人及／或家庭成員在填寫申請表當日並無擁有、與他人共同擁有或簽訂任何買賣合約購買各種香港住宅物業或持有任何直接或透過附屬公司擁有香港住宅物業的公司50% 以上的股權。',
        3 => '本堂為審核及評估申請，可向有關的政府部門、公營／私營機構（例如但不限於金融機構及銀行）及／或任何擁有本人及／或家庭成員個人資料的第三者（例如但不限於僱主）蒐集本人及／或家庭成員的個人資料進行核對，以核實申請資格。在蒐集資料過程中，本堂可將本人及／或家庭成員提供的個人資料向上述機構及／或第三者披露，以及授權任何擁有本人及／或家庭成員個人資料的第三者，向本堂提供個人資料，以核實申請。',
        4 => '本人及／或家庭成員同意，申請表格內的個人資料及所有往來文件，在處理、審核及／或調查申請的工作下，可以向相關部門、機構或合作單位，披露、核對及／或轉移有關資料。',
        5 => '本人及／或家庭成員同意，本堂可使用申請表格所提供的資料進行統計調查或研究。',
        6 => '本人聲明本人及／或申請人代本人在本申請表上填報的資料及就本項目已／可能遞交的其他資料，均屬正確無訛。本人明白，如明知或故意作出虛假陳述或隱瞞資料，或以其他方式誤導本堂，可被檢控及導致即時喪失申請資格，須立即停止及租住社會房屋。本人明白，蓄意提供虛假資料或漏報資料，以期以欺騙手段令本人及／或家庭成員取得本計劃的申請資格，屬刑事罪行。',
      ];
      return $index !== false ? ($index==NULL || !isset($array[$index]))? '': $array[$index] : $array;
    }
    public static function getPart6Terms($index = false) {
      $array = [
        1 => '本人已細閱及明白上述有關「收集資料的目的」內容，並同意收集個人資料聲明書適用於申請人及／或家庭成員。', 
      ];
      return $index !== false ? ($index==NULL || !isset($array[$index]))? '': $array[$index] : $array;
    }
    public static function getUserApplicationStatus($index = false) {
      $array = [
        -10 => '未能編配單位',
        10  => '未編配單位',
        20  => '已編配單位', 
        30  => '已退租', 
      ];
      return $index !== false ? ($index==NULL || !isset($array[$index]))? '': $array[$index] : $array;
    }
    public static function getApplicationStatus($index = false, $type = false) {
      $array = [
        -20  => '未能編配單位',
        -10 => '拒絕申請',
        10  => '已填申請表',
        15  => '要求更新申請表',
        20  => '上載文件',
        30  => '要求再次提交文件',
        40  => '已檢查上載文件', 
        50  => '已編配單位',
        60  => '已編配其他單位',
        70  => '已退租',
      ];  

/*
      if ($type === 1) {
        $array = [
          -10 => '拒絕申請',
          10  => '已填申請表',
          15  => '要求更新申請表',
          20  => '上載文件',
        ];
      } elseif ($type === 2) {
        $array = [
          -10 => '拒絕申請',
          20  => '上載文件',
          30  => '要求再次提交文件',
          40  => '已檢查上載文件', 
        ];
      } elseif ($type === 3) {
        $array = [
          -20  => '未能編配單位',
          40  => '已檢查上載文件', 
          50  => '已編配單位',
          60  => '已編配其他單位',
          70  => '已退租',
        ];
      } else {
        $array = [
          -20  => '未能編配單位',
          -10 => '拒絕申請',
          10  => '已填申請表',
          15  => '要求更新申請表',
          20  => '上載文件',
          30  => '要求再次提交文件',
          40  => '已檢查上載文件', 
          50  => '已編配單位',
          60  => '已編配其他單位',
          70  => '已退租',
        ];  
      }
*/
      return $index !== false ? ($index==NULL || !isset($array[$index]))? '': $array[$index] : $array;
    }
    public static function getApplicationMarkTotalPart1($id) {
      $model = \common\models\ApplicationMark::findOne(['id' => $id]);
      if ($model == null) return 0;
      $total_p1 = $model->i1 + $model->i2 + $model->i3 + $model->i4 + $model->i5 + $model->i6;
      return $total_p1;
    }
    public static function getApplicationMarkTotalPart2AndPart3($id) {
      $model = \common\models\ApplicationMark::findOne(['id' => $id]);
      if ($model == null) return 0;
      $total_p2_p3 = $model->i7 + $model->i8 + $model->i9 + $model->i10 + $model->i11 + $model->i12 + $model->i13;
      return $total_p2_p3;
    }

    public static function getPart7ContentWithTitle($index = false) {
      $array = [
        '1. 申請人及家庭成員的身份證明文件' => [
          '各人的身份證明文件副本' => [
            1 => '香港智能身份證 (年滿 11 歲或以上的人士)',
            2 => '出生證明書 (年滿 11 歲以下的人士)', 
            3 => '單程證/旅遊證件/護照或相關證明文件 (居港未滿 7 年人士須附上印有首次獲准入境日期的證明文件)',
          ],
          '親屬關係證明文件副本' => [
            4 => '出生證明文件或公證書',
            5 => '經司法機關/政府機構發出的子女領養或監護人的判令/委任文件', 
            6 => '聲明書',
          ],
          '已婚人士的結婚證明文件副本' => [
            7 => '結婚證書在香港以舊式婚禮結合，請宣誓說明並交回正本',
            8 => '配偶未獲香港入境權，須以聲明書面說明，並附上結婚證書及其所在地身份證副本 (底面兩面)', 
            9 => '在中國結婚人士，如從未申領有關證明文件，請提交公證書',
          ],
          '離婚人士、未婚單親家長或喪偶人士' => [
            10 => '離婚證明文件副本，如在香港辦理離婚的人士，須提交絕對離婚令 (即表格 6 或表格 7B) 副本',
            11 => '與未滿 18 歲的子女一同申請，須附上已獲法庭判予擁有子女管養權令副本', 
            12 => '正進行法律程序辦理離婚的文件副本及聲明書',
            13 => '同居後分居的人士，女方須附上宣誓書正本，說明同居後分居的日期及子女管養權的安排；男方則須提交已獲法庭判予擁有子女管養權令副本',
            14 => '配偶已去世，請附上結婚證書及死亡證副本',
            15 => '聲明書',
          ],
          '地址證明' => [
            16 => '任何有申請人中/英文住宅/通訊地址的文件副本 (如電費單)',
          ],
          '租金證明' => [
            17 => '任租單及租約副本',
          ],
          '公屋申請證明' => [
            18 => '由香港房屋委員會發出印有申請編號的書面通知 (藍卡)',
          ],
          '懷孕滿 16 星期或以上' => [
            19 => '註冊醫生簽發的預產期證明書副本',
          ],
          '如有長期病患/殘疾家庭成員' => [
            20 => '註冊醫生或認可醫療人員簽發的醫療證明文件副本',
          ],
        ],
        '2. 申請人及家庭成員的入息及資產淨值證明' => [
          '受薪人士 (有固定僱主)' => [
            21 => '稅單、僱主發出的糧單 (需有公司名稱、印章、負責人簽署等)、出糧戶口銀行存摺等',
          ],
          '受薪人士 (沒有固定僱主)' => [
            22 => '聲明書',
          ],
          '自僱人士' => [
            23 => '聲明書及有關文件',
          ],
          '領取綜合社會保障援助金的人士' => [
            24 => '列明援助金額的證明文件及醫療費用豁免證明書副本',
          ],
          '申請人及成年的家庭成員如退休、失業或沒有從事任何工作' => [
            25 => '說明經濟來源的聲明書',
          ],
          '存款紀錄' => [
            26 => '申請人及家庭成員的銀行戶口紀錄，如存摺、月結單等',
          ],
          '出租/空置土地/房產' => [
            27 => '最近期的差餉及地租繳費通知書副本/聲明書',
          ],
          '其他收入 (股息、紅利、保險計劃收益、定期利息、長俸、親友餽贈等)' => [
            28 => '退休金證明文件副本/聲明書',
          ],
        ]
      ];
      return $index !== false ? ($index==NULL || !isset($array[$index]))? '': $array[$index] : $array;
    }
    public static function getPart7TitleGroup($index = false) {
      $array = [
        [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20],
        [21,22,23,24,25,26,27,28],
      ];
      return $index !== false ? ($index==NULL || !isset($array[$index]))? '': $array[$index] : $array;
    }
    public static function getPart7SubtitleGroup($index = false) {
      $array = [
        [1,2,3],
        [4,5,6],
        [7,8,9],
        [10,11,12,13,14,15],
        [16],[17],[18],[19],[20],[21],[22],[23],[24],[25],[26],[27],[28],
      ];
      return $index !== false ? ($index==NULL || !isset($array[$index]))? '': $array[$index] : $array;
    }
    public static function getPart7ContentWithTitleSingleLine($index = false) {
      $array = [
          1  => '各人的身份證明文件副本 - 香港智能身份證 (年滿 11 歲或以上的人士)',
          2  => '各人的身份證明文件副本 - 出生證明書 (年滿 11 歲以下的人士)', 
          3  => '各人的身份證明文件副本 - 單程證/旅遊證件/護照或相關證明文件 (居港未滿 7 年人士須附上印有首次獲准入境日期的證明文件)',
          4  => '親屬關係證明文件副本 - 出生證明文件或公證書',
          5  => '親屬關係證明文件副本 - 經司法機關/政府機構發出的子女領養或監護人的判令/委任文件', 
          6  => '親屬關係證明文件副本 - 聲明書',
          7  => '已婚人士的結婚證明文件副本 - 結婚證書在香港以舊式婚禮結合，請宣誓說明並交回正本',
          8  => '已婚人士的結婚證明文件副本 - 配偶未獲香港入境權，須以聲明書面說明，並附上結婚證書及其所在地身份證副本 (底面兩面)', 
          9  => '已婚人士的結婚證明文件副本 - 在中國結婚人士，如從未申領有關證明文件，請提交公證書',
          10 => '離婚人士、未婚單親家長或喪偶人士 - 離婚證明文件副本，如在香港辦理離婚的人士，須提交絕對離婚令 (即表格 6 或表格 7B) 副本',
          11 => '離婚人士、未婚單親家長或喪偶人士 - 與未滿 18 歲的子女一同申請，須附上已獲法庭判予擁有子女管養權令副本', 
          12 => '離婚人士、未婚單親家長或喪偶人士 - 正進行法律程序辦理離婚的文件副本及聲明書',
          13 => '離婚人士、未婚單親家長或喪偶人士 - 同居後分居的人士，女方須附上宣誓書正本，說明同居後分居的日期及子女管養權的安排；男方則須提交已獲法庭判予擁有子女管養權令副本',
          14 => '離婚人士、未婚單親家長或喪偶人士 - 配偶已去世，請附上結婚證書及死亡證副本',
          15 => '離婚人士、未婚單親家長或喪偶人士 - 聲明書',
          16 => '地址證明 - 任何有申請人中/英文住宅/通訊地址的文件副本 (如電費單)',
          17 => '租金證明 - 任租單及租約副本',
          18 => '公屋申請證明 - 由香港房屋委員會發出印有申請編號的書面通知 (藍卡)',
          19 => '懷孕滿 16 星期或以上 - 註冊醫生簽發的預產期證明書副本',
          20 => '如有長期病患/殘疾家庭成員 - 註冊醫生或認可醫療人員簽發的醫療證明文件副本',
          21 => '受薪人士 (有固定僱主) - 稅單、僱主發出的糧單 (需有公司名稱、印章、負責人簽署等)、出糧戶口銀行存摺等',
          22 => '受薪人士 (沒有固定僱主) - 聲明書',
          23 => '自僱人士 - 聲明書及有關文件',
          24 => '領取綜合社會保障援助金的人士 - 列明援助金額的證明文件及醫療費用豁免證明書副本',
          25 => '申請人及成年的家庭成員如退休、失業或沒有從事任何工作 - 說明經濟來源的聲明書',
          26 => '存款紀錄 - 申請人及家庭成員的銀行戶口紀錄，如存摺、月結單等',
          27 => '出租/空置土地/房產 - 最近期的差餉及地租繳費通知書副本/聲明書',
          28 => '其他收入 (股息、紅利、保險計劃收益、定期利息、長俸、親友餽贈等) - 退休金證明文件副本/聲明書',
      ];
      return $index !== false ? ($index==NULL || !isset($array[$index]))? '': $array[$index] : $array;
    }
    public static function getAppStatus($index = false) {
      $array = [
        1 => '未提交文件',
        2 => '已提交文件', 
      ];
      return $index !== false ? ($index==NULL || !isset($array[$index]))? '': $array[$index] : $array;
    }
    public static function getFileStatus($index = false) {
      $array = [
        1 => '成功',
        2 => '不成功', 
        3 => '遺漏', 
      ];
      return $index !== false ? ($index==NULL || !isset($array[$index]))? '': $array[$index] : $array;
    }
    // public static function getVisitStatus($index = false) {
    //   $array = [
    //     1 => '未家訪',
    //     2 => '已家訪', 
    //   ];
    //   return $index !== false ? ($index==NULL || !isset($array[$index]))? '': $array[$index] : $array;
    // }
    public static function getApproved($index = false) {
      $array = [
        1 => '未批核',
        2 => '已批核', 
      ];
      return $index !== false ? ($index==NULL || !isset($array[$index]))? '': $array[$index] : $array;
    }
    public static function getHouseholdActivityStatus($index = false) {
      $array = [
        1 => '報名待批核', 
        2 => '報名未成功',
        3 => '報名成功', 
      ];
      return $index !== false ? ($index==NULL || !isset($array[$index]))? '': $array[$index] : $array;
    }
    public static function getIsRead($index = false) {
      $array = [
        -1 => '未閱讀',
        1  => '已閱讀',
      ];
      return $index !== false ? ($index==NULL || !isset($array[$index]))? '': $array[$index] : $array;
    }
    public static function getIsOpen($index = false) {
      $array = [
        -1 => '暫停申請',
        1  => '開放申請',
      ];
      return $index !== false ? ($index==NULL || !isset($array[$index]))? '': $array[$index] : $array;
    }
}
