<?php
    use yii\bootstrap\ActiveForm;
    use yii\bootstrap\Html;

?>

<div class="service-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'title')
             ->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'short_description')
             ->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'full_description')
             ->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'icon')
             ->fileInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

