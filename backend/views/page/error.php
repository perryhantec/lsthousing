<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use mihaildev\ckeditor\CKEditor;
use mihaildev\elfinder\ElFinder;

$this->title = Yii::t('app','Error');
?>
<p><?=Yii::t('app','Please select page type for this page.')." (".$model->name_en.")"?></p>
