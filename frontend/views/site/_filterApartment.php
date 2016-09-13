<?php
    /**
     * @var \yii\web\View           $this
     * @var \frontend\models\Search $searchModel
     */
    use common\models\District;
    use frontend\models\Search;
    use frontend\widgets\SliderWidget\SliderWidget;
    use macgyer\yii2materializecss\lib\Html;
    use macgyer\yii2materializecss\widgets\form\ActiveForm;
    use yii\helpers\ArrayHelper;
    use yii\widgets\Pjax;

    $apartmentPriceInterval = Search::getPriceInterval(2);
    $apartmentAreaInterval = Search::getInterval('area', 'apartment');
?>
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
        <?= SliderWidget::widget([
                                     'label' => 'Стоимость, руб',
                                     'model' => $searchModel,
                                     'attribute' => 'price',
                                     'inputId' => 'slider-price-apartment',
                                     'postfix' => ' руб',
                                     'min' => $apartmentPriceInterval[0],
                                     'max' => $apartmentPriceInterval[1]
                                 ]) ?>
    </div>
    <div class="input-field no-marg-top col s10 offset-s1">
        <?= SliderWidget::widget([
                                     'label' => 'Площадь квартиры, м2',
                                     'model' => $searchModel,
                                     'attribute' => 'apartment_area',
                                     'postfix' => ' м2',
                                     'min' => $apartmentAreaInterval[0],
                                     'max' => $apartmentAreaInterval[1]
                                 ]) ?>
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
