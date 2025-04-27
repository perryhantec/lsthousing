<?php
use yii\helpers\Html;

/* @var $this \yii\web\View view component instance */
/* @var $message \yii\mail\MessageInterface the message being composed */
/* @var $content string main view render result */
?>
<?php $this->beginPage() ?>
<?php $this->beginBody() ?>

<p><?= $model->getAttributeLabel('name') ?>: <?= $name ?></p>
<p><?= $model->getAttributeLabel('phone') ?>: <?= $phone ?></p>
<p><?= $model->getAttributeLabel('email') ?>: <?= $email ?></p>
<p><?= $model->getAttributeLabel('body') ?>: <?= nl2br($body) ?></p>

<?php $this->endBody() ?>
<?php $this->endPage() ?>
