<?php

namespace backend\models;

use Yii;
use yii\base\Model;

class ApproveExportForm extends Model
{
    public $month;

    public function rules()
    {
        return [
            [['month'], 'required'],
            ['month', 'date', 'format' => 'php:Y-m'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'month' => Yii::t('pch', '月份'),
        ];
    }
}
