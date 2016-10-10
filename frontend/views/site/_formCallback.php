<?php
    /**
     * @var \yii\web\View $this
     * @var \frontend\models\Callback $model
     */
    use macgyer\yii2materializecss\widgets\form\ActiveForm;
    use yii\widgets\MaskedInput;
    use yii\widgets\Pjax;

?>
<?php Pjax::begin([
                      'enablePushState' => false,
                      'id' => 'callback-form-wrap'
                  ]) ?>
<?php $form = ActiveForm::begin([
                                    'action' => [
                                        'site/feedback',
                                        'm' => 'callback'
                                    ],

                                    'options' => [
                                        'data-pjax' => true
                                    ]
                                ]) ?>
<div class="row">
    <?= $form->field($model, 'subject', ['options' => ['class' => 'input-field s12']]) ?>
    <?= $form->field($model, 'name', ['options' => ['class' => 'input-field s12']]) ?>
    <?= $form->field($model, 'phone', ['options' => ['class' => 'input-field s12']])
             ->widget(MaskedInput::className(), Yii::$app->params['phoneMask']) ?>
</div>
<div class="row no-marg-bot">
    <div class="col s12 m6 offset-m3">
        <button class="btn red fullWidth waves-effect waves-light">Заказать обратный звонок</button>
    </div>
</div>
<?php ActiveForm::end() ?>
<div class="preloader">
    <div class="preloader-wrapper big active">
        <div class="spinner-layer spinner-blue-only">
            <div class="circle-clipper left">
                <div class="circle"></div>
            </div>
            <div class="gap-patch">
                <div class="circle"></div>
            </div>
            <div class="circle-clipper right">
                <div class="circle"></div>
            </div>
        </div>
    </div>
</div>
<?php Pjax::end() ?>
