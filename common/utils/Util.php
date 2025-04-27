<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace common\utils;

use Yii;
use yii\db\Expression;
use yii\helpers\FileHelper;

class Util {

  const GENDER_MALE = 'm';
  const GENDER_FEMALE = 'f';
  const YES = '1';
  const NO = '0';

  public static function getYesNo($yesLabel = null, $noLabel = null) {
    if (is_null($yesLabel))
      $yesLabel = Yii::t('app', '是');
    if (is_null($noLabel))
      $noLabel = Yii::t('app', '否');
    return [
        self::YES => $yesLabel,
        self::NO => $noLabel
    ];
  }

  public static function getGender() {
    return [
        self::GENDER_MALE => Yii::t('app', '男'),
        self::GENDER_FEMALE => Yii::t('app', '女')
    ];
  }

  public static function calculateAgeByDate($date) {
    $from = new \DateTime($date);
    $to = new \DateTime('today');

    return $from->diff($to)->y;
  }

  public static function dayToSecond($day) {
    return $day * 24 * 60 * 60;
  }

  public static function secondToDay($second) {
    return ceil($second / (24 * 60 * 60));
  }

  public static function secondToHour($second) {

    return round($second / ( 60 * 60), 2);
  }

  public static function getMinutesFromDateTimeDifference($start_time, $end_time) {
    $datetime_start = new \DateTime($start_time);
    $datetime_end = new \DateTime($end_time);
    $interval = $datetime_start->diff($datetime_end);

    return $interval->format('%h')*60+$interval->format('%i');
  }

  public static function getDateTimeDifference($start_time, $end_time) {
    $dateTime1 = strtotime($start_time);
    $dateTime2 = strtotime($end_time);

    return $dateTime2 - $dateTime1;
  }

  public static function getTimeDifference($time1, $time2) {
    $time1 = strtotime("1/1/1980 $time1");
    $time2 = strtotime("1/1/1980 $time2");

    if ($time2 < $time1) {
      return $time1 - $time2;
    }
    return $time2 - $time1;
  }

  public static function dbExpNow() {
    return new Expression('NOW()');
  }

  public static function getYear($time) {
    return date('Y', strtotime($time));
  }

  public static function getMonth($time) {
    return date('m', strtotime($time));
  }

  public static function getDay($time) {
    return date('d', strtotime($time));
  }

  public static function getYears() {
    $result = [];
    for ($i = date('Y'); $i >= 1900; $i--) {
      $result[$i] = $i;
    }
    return $result;
  }

  public static function getMonths() {
    return [
        1 => 1,
        2 => 2,
        3 => 3,
        4 => 4,
        5 => 5,
        6 => 6,
        7 => 7,
        8 => 8,
        9 => 9,
        10 => 10,
        11 => 11,
        12 => 12
    ];
  }

  public static function getDaysOfWeek($index = false) {
    $array = [
      1 => Yii::t('app', '星期一'),
      2 => Yii::t('app', '星期二'),
      3 => Yii::t('app', '星期三'),
      4 => Yii::t('app', '星期四'),
      5 => Yii::t('app', '星期五'),
      6 => Yii::t('app', '星期六'),
      7 => Yii::t('app', '星期日'),
    ];
    return $index !== false ? ($index==NULL || !isset($array[$index]))? NULL: $array[$index] : $array;
  }
  
  public static function getShortDaysOfWeek($index = false) {
    $array = [
      1 => Yii::t('app', '一'),
      2 => Yii::t('app', '二'),
      3 => Yii::t('app', '三'),
      4 => Yii::t('app', '四'),
      5 => Yii::t('app', '五'),
      6 => Yii::t('app', '六'),
      7 => Yii::t('app', '日'),
    ];
    return $index !== false ? ($index==NULL || !isset($array[$index]))? NULL: $array[$index] : $array;
  }

  public static function getDays($year = null, $month = null) {
    $result = [];
    if ($year && $month) {
      $lastDayOfMonth = self::getLastDayOfMonth($year, $month);
      for ($i = 1; $i <= $lastDayOfMonth; $i++) {
        $result[$i] = $i;
      }
    }
    return $result;
  }

  public static function getLastDayOfMonth($year, $month) {
    return date("t", strtotime("$year-$month-1"));
  }

  public static function removeNewLine($string) {
    return trim(preg_replace('/\s\s+/', ' ', $string));
  }

  public static function encodeWord($text) {
    return preg_replace('~\R~u', '<w:t><w:br/></w:t>', Html::encode($text));
  }

  public static function getTimeslots() {
    $timeslots = [];
    foreach (self::getDaysOfWeek() as $i => $dayOfWeek) {
      foreach (self::getPeriods() as $j => $periods) {
        $timeslots[$i.'_'.$j] = $dayOfWeek.' ('.$periods.')';
      }
    }
    return $timeslots;
  }

  public static function sendFile($file, $filename) {
    Yii::$app->response->sendFile($file, $filename, ['mimeType' => FileHelper::getMimeTypeByExtension($filename)]);
  }

  public static function formatCurrency($amount) {
    return Yii::$app->formatter->asCurrency($amount, 'HKD', [
        \NumberFormatter::MIN_FRACTION_DIGITS => 2,
        \NumberFormatter::MAX_FRACTION_DIGITS => 2
    ]);
  }

  public static function columnLetter($c) {
    $c = intval($c);
    if ($c <= 0)
      return '';

    $letter = '';

    while ($c != 0) {
      $p = ($c - 1) % 26;
      $c = intval(($c - $p) / 26);
      $letter = chr(65 + $p).$letter;
    }

    return $letter;
  }

  function integerToRoman($integer)
  {
   // Convert the integer into an integer (just to make sure)
   $integer = intval($integer);
   $result = '';

   // Create a lookup array that contains all of the Roman numerals.
   $lookup = array('M' => 1000,
   'CM' => 900,
   'D' => 500,
   'CD' => 400,
   'C' => 100,
   'XC' => 90,
   'L' => 50,
   'XL' => 40,
   'X' => 10,
   'IX' => 9,
   'V' => 5,
   'IV' => 4,
   'I' => 1);

   foreach($lookup as $roman => $value){
    // Determine the number of matches
    $matches = intval($integer/$value);

    // Add the same number of characters to the string
    $result .= str_repeat($roman,$matches);

    // Set the integer to be the remainder of the integer and the value
    $integer = $integer % $value;
   }

   // The Roman numeral should be built, return it
   return $result;
  }

}
