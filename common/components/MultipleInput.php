<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace common\components;

/**
 * Description of MultipleInput
 *
 * @author jamesli
 */
class MultipleInput extends \unclead\multipleinput\MultipleInput {

  public $allowEmptyList = true;
  
  public $addButtonOptions = [
      'class' => 'btn btn-default btn-sm'
  ];
  
  public $removeButtonOptions = [
      'class' => 'btn btn-danger btn-sm'
  ];

}
