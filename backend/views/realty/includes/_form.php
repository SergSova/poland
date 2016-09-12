<?php

    use backend\widgets\MapWidget\FormMapWidget;
    use common\models\District;
    use common\models\ServiceType;
    use yii\helpers\ArrayHelper;
    use yii\helpers\Html;
    use yii\web\View;
    use yii\widgets\ActiveForm;

    /* @var $this yii\web\View */
    /* @var $model backend\components\RealtyModel */
    /* @var $form yii\widgets\ActiveForm */
    /* @var $realtyType string */

    if($model->baseModel->isNewRecord){
        $centerMap = Yii::$app->params['mapConfig']['center'];
        $zoom = Yii::$app->params['mapConfig']['zoom'];
    }else{
        $coord = explode(';', $model->baseModel->map_coord);
        $centerMap = [
            'lat' => $coord[0] * 1,
            'lng' => $coord[1] * 1
        ];
        $zoom = 18;
    }
?>
<?php $form = ActiveForm::begin([
                                    'options' => [
                                        'class' => 'form-horizontal',
                                        'id' => 'realty-form'
                                    ],
                                    'fieldConfig' => [
                                        'template' => '{label}<div class="col-sm-12 col-md-8">{input}</div><div class="col-sm-12 col-md-8 col-md-offset-4">{error}</div><div class="col-sm-12 col-md-8 col-md-offset-4"> {hint}</div>',
                                        'labelOptions' => ['class' => 'label-control col-sm-12 col-md-4 text-right']
                                    ]
                                ]); ?>
<div class="row">
    <?php if($model->baseModel->hasErrors() || $model->entityModel->hasErrors()): ?>
        <?php var_dump($model->errors) ?>;
    <?php endif; ?>
</div>
<div class="col-lg-6">
    <div class="realty-form">
        <div class="panel panel-primary">
            <div class="panel-heading">Основное</div>
            <div class="panel-body">
                <?= Html::activeHiddenInput($model->baseModel, 'realty_type_id',
                                            ['value' => \common\models\RealtyType::findOne(['realty_table' => $realtyType])->id]) ?>
                <?= $form->field($model->baseModel, 'service_type_id')
                         ->dropDownList(ArrayHelper::map(ServiceType::find()
                                                                    ->all(), 'id', 'name')) ?>
                <?= $form->field($model->baseModel, 'status')
                         ->dropDownList([
                                            'active' => 'Активно',
                                            'inactive' => 'Неактивно',
                                            'sale' => 'Продано',
                                            'deposit' => 'Под залогом',
                                        ]) ?>
                <?= $form->field($model->baseModel, 'district_id')
                         ->dropDownList(ArrayHelper::map(District::find()
                                                                 ->all(), 'id', 'name'), [
                                            'prompt' => 'Выберите расположение'
                                        ]) ?>
                <?= $form->field($model->baseModel, 'address')
                         ->textInput([
                                         'maxlength' => true,
                                         'placeholder' => 'Введите адрес'
                                     ]) ?>
                <?= $form->field($model->baseModel, 'map_coord')
                         ->input('text', [
                             'readonly' => true,
                             'placeholder' => 'Выберите точку на карте'
                         ])
                         ->label('Координаты') ?>
                <div class="panel panel-danger" style="height: 452px">
                    <?= FormMapWidget::widget([

                                                  'mapSetting' => [
                                                      'center' => $centerMap,
                                                      'zoom' => $zoom,
                                                      'draggable' => true,
                                                      'addressInpId' => 'realty-address',
                                                      'coordInpId' => 'realty-map_coord'
                                                  ]
                                              ]) ?>
                </div>
                <?= $form->field($model->baseModel, 'price')
                         ->input('number', ['placeholder' => 'руб']) ?>
                <?= $form->field($model->baseModel, 'description')
                         ->textarea([
                                        'rows' => 7,
                                        'placeholder' => 'Введите описание объекта'
                                    ]) ?>
            </div>
        </div>
    </div>
</div>
<?= $this->render('_form'.ucfirst($realtyType), [
    'form' => $form,
    'model' => $model
]); ?>
<?= $this->render('_uploadFile', ['model' => $model]) ?>
<div class="form-group">
    <?= Html::submitButton($model->baseModel->isNewRecord ? 'Создать объект' : 'Обновить данные', [
                                                                                                    'class' => $model->baseModel->isNewRecord ? 'btn btn-success' : 'btn btn-primary',
                                                                                                    'style' => 'width: 100%;'
                                                                                                ]) ?>
</div>
<?php ActiveForm::end(); ?>

