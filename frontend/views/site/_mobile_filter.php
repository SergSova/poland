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
    <div class="filter-box">
            <div class="row no-marg-bot">
                <div class="col s12">
                    <ul class="tabs">
                        <li class="tab col s6 waves-effect waves-light"><a href="#mobile-filter-house">Дома</a></li>
                        <li class="tab col s6 waves-effect waves-light"><a href="#mobile-filter-apartment">Квартиры</a></li>
                    </ul>
                </div>
                <div class="col s12" id="mobile-filter-house">
                    <br>
                    <?php Pjax::begin(['id' => 'mobile-house-filter']) ?>
                    <?php $mobileHouseForm = ActiveForm::begin([
                                                             'method' => 'GET',
                                                             'action' => ['catalog'],
                                                             'options' => ['data-pjax' => true]
                                                         ]); ?>
                    <div class="row">

                        <?= $mobileHouseForm->field($searchModel, 'districtId', ['options' => ['class' => 'input-field marg-top col s10 offset-s1']])
                                            ->dropDownList(ArrayHelper::map(District::find()
                                                                              ->all(), 'id', 'name'), ['prompt' => 'Все направления', 'id'=> 'mobile-filter-district'])
                                            ->label('Направление') ?>
                        <?= Html::activeHiddenInput($searchModel, 'realtyTypeId', ['value' => 1]) ?>
                        <?= Html::activeHiddenInput($searchModel, 'serviceTypeId', ['value' => 1]) ?>

                        <div class="input-field no-marg-top col s10 offset-s1">
                            <p class="label no-marg-bot">Стоимость, руб</p>
                            <?= Html::activeInput('text', $searchModel, 'price', ['id' => 'mobile-filter-house-price']) ?>
                        </div>
                        <div class="input-field no-marg-top col s10 offset-s1">
                            <p class="label no-marg-bot">Площадь дома, м2</p>
                            <?= Html::activeInput('text', $searchModel, 'house_area', ['id'=> 'mobile-filter-house-area']) ?>
                        </div>
                        <div class="input-field no-marg-top col s10 offset-s1">
                            <p class="label no-marg-bot">Удаленность от МКАД, км</p>
                            <?= Html::activeInput('text', $searchModel, 'house_distance', ['id' => 'mobile-filter-house-distance']) ?>
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
                <div class="col s12" id="mobile-filter-apartment" style="display: none">
                    <br>
                    <?php Pjax::begin(['id' => 'mobile-apartment-filter']) ?>
                    <?php $mobileApartmentForm = ActiveForm::begin([
                                                                 'method' => 'GET',
                                                                 'action' => ['catalog'],
                                                                 'options' => ['data-pjax' => true]
                                                             ]); ?>
                    <div class="row">

                        <?= $mobileApartmentForm->field($searchModel, 'districtId', ['options' => ['class' => 'input-field marg-top col s10 offset-s1']])
                                                ->dropDownList(ArrayHelper::map(District::find()
                                                                                  ->all(), 'id', 'name'), ['prompt' => 'Все направления'])
                                                ->label('Направление') ?>
                        <?= Html::activeHiddenInput($searchModel, 'realtyTypeId', ['value' => 2]) ?>
                        <?= Html::activeHiddenInput($searchModel, 'serviceTypeId', ['value' => 1]) ?>

                        <div class="input-field no-marg-top col s10 offset-s1">
                            <p class="label no-marg-bot">Стоимость, руб</p>
                            <?= Html::activeInput('text', $searchModel, 'price',['id' => 'mobile-filter-apartment-price']) ?>
                        </div>
                        <div class="input-field no-marg-top col s10 offset-s1">
                            <p class="label no-marg-bot">Площадь квартиры, м2</p>
                            <?= Html::activeInput('text', $searchModel, 'apartment_area', ['id' => 'mobile-filter-apartment-area']) ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s12 mypallete lighten">
                            <br>
                            <?= $mobileApartmentForm->field($searchModel, 'apartment_rooms', ['options' => ['class' => 'input-field marg-top col s10 offset-s1']])
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
            </div>
    </div>