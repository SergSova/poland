<?php

    /* @var $this yii\web\View */
    /* @var $form yii\bootstrap\ActiveForm */
    /* @var $model \backend\models\EmailChangeRequestForm */

    use yii\helpers\Html;
    use yii\bootstrap\ActiveForm;

    $this->title = 'Request email change';
    $this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-request-email-change">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Please fill new your email.</p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'request-email-change-form']); ?>

            <?= $form->field($model, 'new_email')->textInput(['autofocus' => true]) ?>

            <div class="form-group">
                <?= Html::submitButton('Send', ['class' => 'btn btn-primary']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
