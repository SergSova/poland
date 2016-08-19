<?php

    use yii\helpers\Html;
    use yii\widgets\ActiveForm;

    /* @var $this yii\web\View */
    /* @var $model backend\components\RealtyModel */
    /* @var $form yii\widgets\ActiveForm */
?>
<div class="col-lg-6">
    <div class="house-form">
        <div class="panel panel-primary">
            <div class="panel-heading">Характеристики дома</div>
            <div class="panel-body">
                <?= $form->field($model->entityModel, 'house_area')
                         ->input('number', ['placeholder' => 'м2']) ?>

                <?= $form->field($model->entityModel, 'land_area')
                         ->input('number', ['placeholder' => 'м2']) ?>

                <?= $form->field($model->entityModel, 'distance')
                         ->input('number', ['placeholder' => 'от МКАД']) ?>

                <?= $form->field($model->entityModel, 'house_type')
                         ->textInput([
                                         'maxlength' => true,
                                         'placeholder' => 'Ширина х Высота'
                                     ]) ?>
            </div>
        </div>
        <div class="panel panel-primary">
            <div class="panel-heading">Коммуникации</div>
            <div class="panel-body">
                <?= $form->field($model->entityModel, 'communication_water')
                         ->textInput(['maxlength' => true]) ?>

                <?= $form->field($model->entityModel, 'communication_electro')
                         ->textInput(['maxlength' => true]) ?>

                <?= $form->field($model->entityModel, 'communication_gas')
                         ->textInput(['maxlength' => true]) ?>

                <?= $form->field($model->entityModel, 'communication_sewage')
                         ->textInput(['maxlength' => true]) ?>
            </div>
        </div>
        <div class="panel panel-primary">
            <div class="panel-heading">Дополнительная информация</div>
            <div class="panel-body">
                <?= $form->field($model->entityModel, 'decor_inside')?>
                <?= $form->field($model->entityModel, 'decor_outside')?>
                <?= $form->field($model->entityModel, 'bath_count')->label('Санузлы')?>
            </div>
        </div>
        <?= Html::activeHiddenInput($model->entityModel, 'cover', ['id' => 'realty-cover']) ?>
        <?php
            if(!$model->entityModel->isNewRecord):
                echo Html::activeHiddenInput($model->entityModel, 'photos', ['id'=>'photo-inp']);
            endif;
        ?>

    </div>
</div>
