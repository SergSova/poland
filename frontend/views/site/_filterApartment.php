<?php
    /**
     * @var \yii\web\View $this
     * @var \frontend\models\Search $searchModel
     */
    use common\models\District;
    use macgyer\yii2materializecss\lib\Html;
    use macgyer\yii2materializecss\widgets\form\ActiveForm;
    use yii\helpers\ArrayHelper;
    use yii\widgets\Pjax;
?>
<div class="col s12" id="apartment" style="display: none">
    <br>
    <?php Pjax::begin(['id' => 'apartment-filter']) ?>
    <?php $apartmentForm = ActiveForm::begin([
                                             'method' => 'GET',
                                             'action' => ['catalog'],
                                             'options' => ['data-pjax' => true]
                                         ]); ?>
    <div class="row">

        <?= $apartmentForm->field($searchModel, 'districtId', ['options' => ['class' => 'input-field marg-top col s10 offset-s1']])
                          ->dropDownList(ArrayHelper::map(District::find()
                                                              ->all(), 'id', 'name'), ['prompt' => 'Все направления'])
                          ->label('Направление') ?>
        <?= Html::activeHiddenInput($searchModel, 'realtyTypeId', ['value' => 2]) ?>
        <?= Html::activeHiddenInput($searchModel, 'serviceTypeId', ['value' => 1]) ?>

        <div class="input-field no-marg-top col s10 offset-s1">
            <p class="label no-marg-bot">Стоимость, руб</p>
            <?= Html::activeInput('text', $searchModel, 'price',['id' => 'apartment-price']) ?>
        </div>
        <div class="input-field no-marg-top col s10 offset-s1">
            <p class="label no-marg-bot">Площадь квартиры, м2</p>
            <?= Html::activeInput('text', $searchModel, 'apartment_area') ?>
        </div>
    </div>
    <div class="row">
        <div class="col s12 mypallete lighten">
            <br>
            <?= $apartmentForm->field($searchModel, 'apartment_rooms', ['options' => ['class' => 'input-field marg-top col s10 offset-s1']])
                          ->dropDownList([
                                             0 => 'Любое',
                                             1 => 1,
                                             2 => 2,
                                             3 => 3,
                                             4 => 4,
                                             5 => 5,
                                         ], [
                                             'multiple' => true,
                                             'options' => [0 => ['disabled' => true]]
                                         ])
                          ->label('Количество комнат') ?>
        </div>
    </div>
    <div class="row">
        <div class="col s10 offset-s1">
            <?= Html::submitButton('Подобрать', ['class' => 'btn red fullWidth waves-effect waves-light']) ?>
        </div>
    </div>
    <?php ActiveForm::end() ?>
    <?php Pjax::end() ?>
</div>
</div>