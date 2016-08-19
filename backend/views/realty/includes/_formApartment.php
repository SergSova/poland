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
            <div class="panel-heading">Характеристики Квартиры</div>
            <div class="panel-body">
                <?= $form->field($model->entityModel, 'house_year')
                         ->input('number', ['placeholder' => '1987']) ?>
                <?= $form->field($model->entityModel, 'house_material') ?>
                <?= $form->field($model->entityModel, 'house_floor_count')
                         ->input('number') ?>
                <?= $form->field($model->entityModel, 'room_count')
                         ->input('number') ?>
                <?= $form->field($model->entityModel, 'floor')->input('number')?>
                <?= $form->field($model->entityModel, 'area')->input('number', ['placeholder'=> '25m2'])?>
                <?= $form->field($model->entityModel, 'rooms_area')?>
                <?= $form->field($model->entityModel, 'kitchen_area')->input('number')?>
                <?= $form->field($model->entityModel, 'balcony')?>
                <?= $form->field($model->entityModel, 'bathroom_type')->dropDownList(['separated'=>'Раздельный', 'combined'=>'Совмещенный'])?>
            </div>
        </div>
        <?= Html::activeHiddenInput($model->entityModel, 'cover', ['id'=>'realty-cover'])?>

    </div>
</div>
