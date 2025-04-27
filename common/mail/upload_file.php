<?php
use yii\helpers\Html;

/* @var $this \yii\web\View view component instance */
/* @var $message \yii\mail\MessageInterface the message being composed */
/* @var $content string main view render result */
?>
<?php $this->beginPage() ?>
<?php $this->beginBody() ?>

<p><?= $model->application->getAttributeLabel('appl_no') ?>: <?= $appl_no ?></p>
<p><?= $model->application->getAttributeLabel('chi_name') ?>: <?= $chi_name ?></p>
<p><?= $model->application->getAttributeLabel('eng_name') ?>: <?= $eng_name ?></p>
<p><?= $model->application->getAttributeLabel('mobile') ?>: <?= $mobile ?></p>

<?php $this->endBody() ?>
<?php $this->endPage() ?>
