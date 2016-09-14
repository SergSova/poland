<?php
    /**
     * @var $this  \yii\web\View
     * @var $model \common\models\Service
     */
    $this->title = $model->title;
?>

<div class="section">
    <div class="container">
        <div class="row no-marg-bot">
            <h3><?= $model->title ?></h3>
            <p><?= $model->description ?></p>
        </div>
    </div>
</div>
