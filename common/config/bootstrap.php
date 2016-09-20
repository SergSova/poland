<?php
    Yii::setAlias('@common', dirname(__DIR__));
    Yii::setAlias('@frontend', dirname(dirname(__DIR__)).'/frontend');
    Yii::setAlias('@backend', dirname(dirname(__DIR__)).'/backend');
    Yii::setAlias('@console', dirname(dirname(__DIR__)).'/console');
    Yii::setAlias('@storage', dirname(dirname(__DIR__)).'/www/storage');
    Yii::setAlias('@wwwRoot', dirname(dirname(__DIR__)).'/www');
    Yii::setAlias('@wwwUrl', 'http://newaddress.local/');
    Yii::setAlias('@storageUrl', 'http://newaddress.local/storage');