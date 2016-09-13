<?php
    /**
     * @var \yii\web\View $this
     * @var \frontend\models\Search $searchModel
     */
    use common\models\District;
    use frontend\models\Search;
    use frontend\widgets\SliderWidget\SliderWidget;
    use macgyer\yii2materializecss\lib\Html;
    use macgyer\yii2materializecss\widgets\form\ActiveForm;
    use yii\helpers\ArrayHelper;
    use yii\widgets\Pjax;

    $housePriceInterval = Search::getPriceInterval(1);
    $houseAreaInterval = Search::getInterval('house_area', 'house');
    $houseDistanceInterval = Search::getInterval('distance', 'house');
?>
    <br>
    <?php Pjax::begin(['id' => 'house-filter']) ?>
    <?php $houseForm = ActiveForm::begin([
                                             'method' => 'GET',
                                             'action' => ['catalog'],
                                             'options' => ['data-pjax' => true]
                                         ]); ?>
    <div class="row">

        <?= $houseForm->field($searchModel, 'districtId', ['options' => ['class' => 'input-field marg-top col s10 offset-s1']])
                      ->dropDownList(ArrayHelper::map(District::find()
                                                              ->all(), 'id', 'name'), ['prompt' => 'Все направления'])
                      ->label('Направление') ?>
        <?= Html::activeHiddenInput($searchModel, 'realtyTypeId', ['value' => 1]) ?>
        <?= Html::activeHiddenInput($searchModel, 'serviceTypeId', ['value' => 1]) ?>

        <div class="input-field no-marg-top col s10 offset-s1">
            <?= SliderWidget::widget([
                                         'label' => 'Стоимость, руб',
                                         'model' => $searchModel,
                                         'attribute' => 'price',
                                         'postfix' => ' руб',
                                         'min' => $housePriceInterval[0],
                                         'max' => $housePriceInterval[1]
                                     ]) ?>
        </div>
        <div class="input-field no-marg-top col s10 offset-s1">
            <?= SliderWidget::widget([
                                         'label' => 'Площадь дома, м2',
                                         'model' => $searchModel,
                                         'attribute' => 'house_area',
                                         'postfix' => ' м2',
                                         'min' => $houseAreaInterval[0],
                                         'max' => $houseAreaInterval[1]
                                     ]) ?>
        </div>
        <div class="input-field no-marg-top col s10 offset-s1">
            <?= SliderWidget::widget([
                                         'label' => 'Удаленность от МКАД, км',
                                         'model' => $searchModel,
                                         'attribute' => 'house_distance',
                                         'postfix' => ' км',
                                         'min' => $houseDistanceInterval[0],
                                         'max' => $houseDistanceInterval[1]
                                     ]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col s10 offset-s1">
            <?= Html::submitButton('Подобрать', ['class' => 'btn red fullWidth waves-effect waves-light']) ?>
        </div>
    </div>
    <?php ActiveForm::end() ?>
    <?php Pjax::end() ?>
