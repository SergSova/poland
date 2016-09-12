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
<div class="col s12" id="house">
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
            <p class="label no-marg-bot">Стоимость, руб</p>
            <?= Html::activeInput('text', $searchModel, 'price', ['id' => 'house-price']) ?>
        </div>
        <div class="input-field no-marg-top col s10 offset-s1">
            <p class="label no-marg-bot">Площадь дома, м2</p>
            <?= Html::activeInput('text', $searchModel, 'house_area') ?>
        </div>
        <div class="input-field no-marg-top col s10 offset-s1">
            <p class="label no-marg-bot">Удаленность от МКАД, км</p>
            <?= Html::activeInput('text', $searchModel, 'house_distance') ?>
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