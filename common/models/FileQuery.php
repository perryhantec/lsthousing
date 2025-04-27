<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[File]].
 *
 * @see File
 */
class FileQuery extends \yii\db\ActiveQuery {

  public function byAuthKey($value) {
    return $this->andWhere(['file.auth_key' => $value]);
  }

  public function active() {
    return $this->andWhere(['file.status' => File::STATUS_ACTIVE]);
  }

  /**
   * {@inheritdoc}
   * @return File[]|array
   */
  public function all($db = null) {
    return parent::all($db);
  }

  /**
   * {@inheritdoc}
   * @return File|array|null
   */
  public function one($db = null) {
    return parent::one($db);
  }

}
