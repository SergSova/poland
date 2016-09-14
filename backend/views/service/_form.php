<?php
    /**
     * @var $this  \yii\web\View
     * @var $model \common\models\Service
     */

    use yii\bootstrap\ActiveForm;
    use yii\bootstrap\Html;

?>

<div class="service-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'title')
             ->textInput(['maxlength' => true]) ?>


    <?= $form->field($model, 'description')
             ->textarea(['rows' => 6]) ?>

    <?= Html::img(Yii::getAlias('@storageUrl').DIRECTORY_SEPARATOR.$model->icon, ['class' => 'thumbnail' ,'alt'=>'no_foto']) ?>

    <?= $form->field($model, 'icon')
             ->fileInput()?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

