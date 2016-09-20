<?php
    /**
     * @var $this  \yii\web\View
     * @var $model \common\models\Action
     */
    use yii\bootstrap\ActiveForm;
    use yii\bootstrap\Html;

?>

<div class="container">
    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>
    <?= $form->field($model, 'title')
             ->textInput() ?>
    <?= $form->field($model, 'name')
             ->textInput(['placeholder'=>'hot, discount и т.д.']) ?>
    <?= $form->field($model, 'description')
             ->textarea() ?>
    <?= $form->field($model, 'date_start') ?>
    <?= $form->field($model, 'date_end') ?>
    <?= $form->field($model, 'icon')
             ->fileInput() ?>
    <?= $form->field($model, 'value')
             ->textarea(['placeholder'=>'Запись в виде JSON для discount {"attr":"price","discount":20} для hot {"limit":4}']) ?>
    <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    <?php ActiveForm::end() ?>
</div>