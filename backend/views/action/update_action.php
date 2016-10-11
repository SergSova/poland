<?php
    /**
     * @var $this  \yii\web\View
     * @var $model \common\models\Action
     */
    $this->title = 'Изменить акцию '.$model->title;
?>

<?= $this->render('_form_action', ['model' => $model]) ?>
