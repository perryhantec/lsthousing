<?php

namespace backend\components;

use Yii;
use yii\helpers\Html;

class ActionColumn extends \kartik\grid\ActionColumn {

    public $hAlign = \kartik\grid\GridView::ALIGN_LEFT;

    public $template = '{view} {update} {delete}';

    public $contentOptions = ['style' => ['white-space' => 'nowrap']];

    public $visibleButtons = [
                    'view' => true,
                    'update' => true,
                    'delete' => true,
                    'enabled' => true,
                    'disabled' => true,
                    'category_update' => true,
                    'category_delete' => true,
                ];

    protected function initDefaultButtons()
    {
        if (!isset($this->buttons['view'])) {
                $this->buttons['view'] = function ($url, $model, $key) {
                        return  Html::a(Yii::t('app', 'View'), $url, ['class' => 'btn btn-info btn-xs']);
                };
        }
        if (!isset($this->buttons['update'])) {
                $this->buttons['update'] = function ($url, $model, $key) {
                        return  Html::a(Yii::t('app', 'Update'), $url, ['class' => 'btn btn-primary btn-xs']);
                };
        }
        if (!isset($this->buttons['category_update'])) {
                $this->buttons['category_update'] = function ($url, $model, $key) {
                        return  Html::a(Yii::t('app', 'Update'), $url, ['class' => 'btn btn-primary btn-xs']);
                };
        }
        if (!isset($this->buttons['delete'])) {
                $this->buttons['delete'] = function ($url, $model, $key) {
                        return  Html::a(Yii::t('app', 'Delete'), $url, [
                                        'class' => 'btn btn-danger btn-xs',
                                        'data' => [
                                            'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                                            'method' => 'post',
                                        ],
                                    ]);
                };
        }
        if (!isset($this->buttons['category_delete'])) {
                $this->buttons['category_delete'] = function ($url, $model, $key) {
                        return  Html::a(Yii::t('app', 'Delete'), $url, [
                                        'class' => 'btn btn-danger btn-xs',
                                        'data' => [
                                            'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                                            'method' => 'post',
                                        ],
                                    ]);
                };
        }
        if (!isset($this->buttons['enabled'])) {
                $this->buttons['enabled'] = function ($url, $model, $key) {
                        return  Html::a(Yii::t('definitions', 'Enabled'), $url, [
                                        'class' => 'btn btn-success btn-xs',
                                        'data' => [
                                            'confirm' => Yii::t('app', 'Are you sure you want to enable this item?'),
                                            'method' => 'post',
                                        ],
                                    ]);
                };
        }
        if (!isset($this->buttons['disabled'])) {
                $this->buttons['disabled'] = function ($url, $model, $key) {
                        return  Html::a(Yii::t('definitions', 'Disabled'), $url, [
                                        'class' => 'btn btn-warning btn-xs',
                                        'data' => [
                                            'confirm' => Yii::t('app', 'Are you sure you want to disable this item?'),
                                            'method' => 'post',
                                        ],
                                    ]);
                };
        }
    }
}
