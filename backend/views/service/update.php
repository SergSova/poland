<?php
    /**
     * @var $this  \yii\web\View
     * @var $model \common\models\Service
     */
    $this->title = 'Изменить услугу '.$model->title;
?>

<?= $this->render('_form', ['model' => $model]);
