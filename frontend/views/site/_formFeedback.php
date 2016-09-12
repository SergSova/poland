<?php
    /**
     * @var \yii\web\View                  $this
     * @var \frontend\models\Callback $model
     */
    use macgyer\yii2materializecss\widgets\form\ActiveForm;
    use yii\widgets\Pjax;

?>
<?php Pjax::begin(['enablePushState' => false, 'id'=>'feedback-form-wrap']) ?>
<?php $form = ActiveForm::begin([
                                    'action' => [
                                        'site/feedback',
                                        'm' => 'feedback'
                                    ],

                                    'options' => [
                                        'data-pjax' => true
                                    ]
                                ]) ?>
<div class="row">
    <?= $form->field($model, 'name', ['options' => ['class' => 'input-field col s12 m6']]) ?>
    <?= $form->field($model, 'email', ['options' => ['class' => 'input-field col s12 m6']]) ?>
    <?= $form->field($model, 'subject', ['options' => ['class' => 'input-field col s12']]) ?>
    <?= $form->field($model, 'body', ['options' => ['class' => 'input-field col s12']])
             ->textarea(['class' => 'materialize-textarea']) ?>
</div>
<div class="row no-marg-bot">
    <div class="col s12 m6 offset-m3">
        <button class="btn red fullWidth waves-effect waves-light">Отправить сообщение</button>
    </div>
</div>
<?php ActiveForm::end() ?>
<div class="preloader">
    <div class="preloader-wrapper big active">
        <div class="spinner-layer spinner-blue-only">
            <div class="circle-clipper left">
                <div class="circle"></div>
            </div><div class="gap-patch">
                <div class="circle"></div>
            </div><div class="circle-clipper right">
                <div class="circle"></div>
            </div>
        </div>
    </div>
</div>
<?php Pjax::end() ?>
