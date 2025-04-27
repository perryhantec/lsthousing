<?php

namespace common\behaviors;

use yii\db\Expression;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class TimestampBehavior extends \yii\behaviors\TimestampBehavior {

  protected function getValue($event) {
    return new Expression('NOW()');
  }

}
