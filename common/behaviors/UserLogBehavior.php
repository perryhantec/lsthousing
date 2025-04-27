<?php


namespace common\behaviors;

use Yii;
use yii\base\InvalidCallException;
use yii\db\BaseActiveRecord;
use yii\behaviors\AttributeBehavior;

class UserLogBehavior extends AttributeBehavior {

  /**
   * @var string the attribute that will receive timestamp value
   * Set this property to false if you do not want to record the creation time.
   */
  public $createdAtAttribute = 'created_by';

  /**
   * @var string the attribute that will receive timestamp value.
   * Set this property to false if you do not want to record the update time.
   */
  public $updatedAtAttribute = 'updated_by';

  /**
   * @inheritdoc
   *
   * In case, when the value is `null`, the result of the PHP function [time()](http://php.net/manual/en/function.time.php)
   * will be used as value.
   */
  public $value;

  /**
   * @inheritdoc
   */
  public function init() {
    parent::init();

    if (empty($this->attributes)) {
      $this->attributes = [
          BaseActiveRecord::EVENT_BEFORE_INSERT => [$this->createdAtAttribute, $this->updatedAtAttribute],
          BaseActiveRecord::EVENT_BEFORE_UPDATE => $this->updatedAtAttribute,
      ];
    }
  }

  /**
   * @inheritdoc
   *
   * In case, when the [[value]] is `null`, the result of the PHP function [time()](http://php.net/manual/en/function.time.php)
   * will be used as value.
   */
  protected function getValue($event) {
    // Console
    if (is_a(Yii::$app, 'yii\console\Application')) {
      return 'System';
    }
    
    if(!array_key_exists('identityClass', Yii::$app->components['user'])){
      return 'System';
    }
    
    // With user
    if (($model = Yii::$app->user->getIdentity()) != null) {
      return $model->getName();
    }
    else {
      return 'System';
    }
  }

  /**
   * Updates a timestamp attribute to the current timestamp.
   *
   * ```php
   * $model->touch('lastVisit');
   * ```
   * @param string $attribute the name of the attribute to update.
   * @throws InvalidCallException if owner is a new record (since version 2.0.6).
   */
  public function touch($attribute) {
    /* @var $owner BaseActiveRecord */
    $owner = $this->owner;
    if ($owner->getIsNewRecord()) {
      throw new InvalidCallException('Updating the timestamp is not possible on a new record.');
    }
    $owner->updateAttributes(array_fill_keys((array) $attribute, $this->getValue(null)));
  }

}
