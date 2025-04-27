<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\widgets\Breadcrumbs;
use common\widgets\Alert;
use yii\helpers\Html;

$this->title = $name;

Yii::$app->params['page_header_title'] = $this->title;

$model_general = common\models\General::findOne(1);

?>
        <div class="content">
            <!-- Content -->
            <div class="alert alert-danger">
              <?= nl2br(Html::encode($message)) ?>
            </div>

            <p>
              The above error occurred while the Web server was processing your request.
            </p>
            <p>
              Please contact us if you think this is a server error. Thank you.
            </p>
        </div>

