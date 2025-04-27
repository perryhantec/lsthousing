<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace frontend\models;

use common\models\File;

/**
 * Description of UploadForm
 *
 * @author jamesli
 */
class UploadForm extends \yii\base\Model {

  public $files;

  public function rules() {
    return [
        ['files', 'required'],
        ['files', 'each', 'rule' => ['file']]
    ];
  }

  public function save() {
    if ($this->validate()) {
      $result = [];
      foreach ($this->files as $uploadedFile) {
        $file = new File(['filedata' => $uploadedFile]);
        $file->save();
        $result[] = [
            'auth_key' => $file->auth_key,
            'file' => $file->filename
        ];
      }
      return $result;
    }
  }

}
