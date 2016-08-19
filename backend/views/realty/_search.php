<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Search */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="realty-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'realty_type_id') ?>

    <?= $form->field($model, 'service_type_id') ?>

    <?= $form->field($model, 'district_id') ?>

    <?= $form->field($model, 'price') ?>

    <?php // echo $form->field($model, 'address') ?>

    <?php // echo $form->field($model, 'map_coord') ?>

    <?php // echo $form->field($model, 'description') ?>

    <?php // echo $form->field($model, 'status') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
