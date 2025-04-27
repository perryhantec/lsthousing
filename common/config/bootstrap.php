<?php
Yii::setAlias('weburl', ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') ? 'https://' : 'http://') . $_SERVER['SERVER_NAME']);
Yii::setAlias('common', dirname(__DIR__));
Yii::setAlias('api', dirname(dirname(__DIR__)) . '/api');
Yii::setAlias('frontend', dirname(dirname(__DIR__)) . '/frontend');
Yii::setAlias('backend', dirname(dirname(__DIR__)) . '/backend');
Yii::setAlias('console', dirname(dirname(__DIR__)) . '/console');
Yii::setAlias('content', dirname(dirname(__DIR__)) . '/content');
Yii::setAlias('data', dirname(dirname(__DIR__)) . '/../data');
Yii::setAlias('cert', dirname(dirname(__DIR__)) . '/../cert');
// Yii::setAlias('file', dirname(dirname(__DIR__)).'/files');
Yii::setAlias('file', dirname(dirname(__DIR__)) . '/files');