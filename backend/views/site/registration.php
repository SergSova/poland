<?php
    /**
     * @var  $this  yii\web\View
     * @var  $model \backend\models\form\RegistrationForm
     */
    use yii\bootstrap\ActiveForm;
    use yii\bootstrap\Html;

?>
<div class="row">
    <div class="col-lg-5">
        <?php $form = ActiveForm::begin() ?>
        <?= $form->field($model, 'username') ?>
        <?= $form->field($model, 'email') ?>
        <?= $form->field($model, 'password_repeat') ?>
        <?= $form->field($model, 'password') ?>
        <?= Html::submitButton('Registration', ['class' => 'btn btn-success']) ?>
        <?php ActiveForm::end() ?>
    </div>
</div>
