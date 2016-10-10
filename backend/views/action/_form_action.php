<?php
    /**
     * @var $this  \yii\web\View
     * @var $model \common\models\Action
     */
    use yii\bootstrap\ActiveForm;
    use yii\bootstrap\Html;

    $action_val = json_decode($model->value);
    $val = $action_val->discount ? $action_val->discount : $model->value;
?>

<div class="container">
    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>
    <?= $form->field($model, 'title')
             ->textInput() ?>
    <?= $form->field($model, 'name')
             ->textInput(['placeholder' => 'hot, discount и т.д.']) ?>
    <?= $form->field($model, 'status')
             ->dropDownList([
                                "active"   => "active",
                                "inactive" => "inactive",
                                "blocked"  => "blocked",
                            ]) ?>
    <?= $form->field($model, 'dateS') ?>
    <?= $form->field($model, 'dateE') ?>
    <?= $form->field($model, 'icon')
             ->fileInput() ?>
    <?= $form->field($model, 'value')
             ->textarea([
                            'placeholder' => 'Запись в виде JSON или для "discount" % скидки',
                            'value'       => $val,
                        ]) ?>
    <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    <?php ActiveForm::end() ?>
</div>