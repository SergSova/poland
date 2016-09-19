<?php
    /**
     * @var \yii\web\View           $this
     * @var \common\models\Realty   $realty
     * @var \common\models\Callback $requestCall
     * @var \common\models\Feedback $requestEmail
     */

    use frontend\assets\RealtyAsset;
    use macgyer\yii2materializecss\widgets\form\ActiveForm;
    use yii\helpers\Url;
    use yii\web\View;
    use yii\widgets\Pjax;

    $this->title = 'Realty '.$realty->id;
    RealtyAsset::register($this);

    $coord = explode(';', $realty->map_coord);
    $marker = [
        'position' => [
            'lat' => $coord[0] * 1,
            'lng' => $coord[1] * 1
        ]
    ];
    $marker = json_encode($marker);

    $mapConfig = [
        'center' => [
            'lat' => $coord[0] * 1,
            'lng' => $coord[1] * 1
        ],
        'zoom' => 14,
        'draggable' => false
    ];
    $mapConfig = json_encode($mapConfig);
    $script = <<<JS
mapInit({$mapConfig});
setMarker({$marker});
JS;
    $this->registerJs($script, View::POS_END);

    $realtyTypeName = $realty->realtyType->realty_table;
    $photos = json_decode($realty->$realtyTypeName->photos);
    foreach($photos as $key => $value){
        $delimPos = strrpos($value, '/');
        $dir = Yii::getAlias('@storageUrl').'/'.substr($value, 0, $delimPos + 1);
        $photoName = substr($value, $delimPos + 1);
        $photos[$key] = [
            'base' => $dir.$photoName,
            'thumb' => $dir.'thumb_'.$photoName,
            'full' => $dir.'full_'.$photoName
        ];
    }
?>
<div class="section">
    <div class="container">
        <div class="row no-marg-bot">
            <div class="col s12 m6 l3 center-on-small-only">
                <a href="<?= Url::to(['site/catalog']) ?>" class="btn mypallete fullWidth waves-effect waves-light"><i class="material-icons left">arrow_back</i>К
                    каталогу</a>
            </div>
            <div class="col s12 m6 l3 push-l6 realty-code">
                <span class="chip">Код недвижимости: <?= $realty->id ?></span>
            </div>
            <div class="col s12 m12 l3 center">
                <h2 class="realty-title"><?= Yii::$app->params['realties']['realtyType'][$realtyTypeName] ?></h2>
            </div>
        </div>
        <div class="row">
            <br>
            <div class="col s12 m12 l6 push-l6">
                <div class="slick-container row">
                    <div class="slick-for col s12 m12 l10">
                        <?php
                            foreach($photos as $photo):
                                ?>
                                <div>
                                    <img data-lazy="<?= $photo['base'] ?>">
                                </div>
                                <?php
                            endforeach;
                        ?>
                    </div>
                    <div class="slick-nav col m12 l2 hide-on-small-only">
                        <?php
                            foreach($photos as $photo):
                                ?>
                                <div class="waves-effect waves-light">
                                    <img src="<?= $photo['thumb'] ?>">
                                </div>
                                <?php
                            endforeach;
                        ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m6 marg-bot">
                        <button class="btn btn-large mypallete fullWidth waves-effect waves-light modal-trigger" data-target="requestCall"><i
                                class="material-icons left">phone_in_talk</i>Заказать
                            звонок
                        </button>
                    </div>
                    <div class="col s12 m6">
                        <button class="btn btn-large mypallete fullWidth waves-effect waves-light modal-trigger" data-target="requestEmail"><i
                                class="material-icons left">mail</i>Отправить
                            заявку
                        </button>
                    </div>
                </div>
            </div>
            <div class="col s12 m12 l6 pull-l6 realty">
                <div class="center-on-small-only">
                    <p class="title"><?= $realty->address ?></p>
                    <p class="price"><?= $realty->price ?> руб</p>
                    <p class="subtitle"><?= $realty->district->name ?></p>
                </div>
                <div class="divider"></div>
                <p class="description flow-text"><?= $realty->short_description ?></p>
                <div class="divider"></div>
                <?= $this->render('_view'.ucfirst($realtyTypeName), ['model' => $realty->$realtyTypeName]) ?>
            </div>
        </div>
    </div>
</div>
<div class="section">
    <div class="container">
        <p class="description-r flow-text"><?= $realty->full_description ?></p>
    </div>
</div>
<div class="section map-wrapper fullHeight">
    <div class="map-container" id="map"></div>
    <?php
        $tmp = explode(';', $realty->map_coord);
        $realtyCoordinates = $tmp[0].','.$tmp[1];
    ?>
    <a href="https://www.google.com.ua/maps/dir//<?= $realtyCoordinates ?>" class="btn mypallete" target="_blank" id="directionBut">Проложить
        маршрут</a>
</div>
<div class="modal" id="requestCall">
    <div class="modal-content">
        <i class="material-icons right close-modal-but" data-target="#requestCall">close</i>
        <h4>Заказать звонок</h4>
        <?php Pjax::begin([
                              'enablePushState' => false,
                              'id' => 'callback-form-wrap'
                          ]) ?>
        <?php $rcf = ActiveForm::begin([
                                           'action' => [
                                               'site/feedback',
                                               'm' => 'callback'
                                           ],

                                           'options' => [
                                               'data-pjax' => true
                                           ]
                                       ]) ?>
        <div class="row">
            <?= $rcf->field($requestCall, 'phone')
                    ->widget(\yii\widgets\MaskedInput::className(), ['mask' => '+7 (999) 999 99 99']) ?>
            <?= $rcf->field($requestCall, 'name') ?>
            <?= $rcf->field($requestCall, 'subject')
                    ->hiddenInput()
                    ->label(false) ?>
        </div>
        <div class="row no-marg-bot">
            <div class="col s12 m6 offset-m3">
                <button class="btn red fullWidth waves-effect waves-light">Отправить заявку</button>
            </div>
        </div>
        <?php ActiveForm::end() ?>
        <?php Pjax::end() ?>
    </div>
</div>
<div class="modal" id="requestEmail">
    <div class="modal-content">
        <i class="material-icons right close-modal-but" data-target="#requestEmail">close</i>
        <h4>Оставить заявку</h4>
        <?php Pjax::begin([
                              'enablePushState' => false,
                              'id' => 'feedback-form-wrap'
                          ]) ?>
        <?php $requestEmailForm = ActiveForm::begin([
                                                        'action' => [
                                                            'site/feedback',
                                                            'm' => 'feedback'
                                                        ],

                                                        'options' => [
                                                            'data-pjax' => true
                                                        ]
                                                    ]) ?>
        <div class="row">
            <?= $requestEmailForm->field($requestEmail, 'subject')
                                 ->hiddenInput()
                                 ->label(false) ?>
            <?= $requestEmailForm->field($requestEmail, 'email') ?>
            <?= $requestEmailForm->field($requestEmail, 'name') ?>
            <?= $requestEmailForm->field($requestEmail, 'body')
                                 ->textarea(['class' => 'materialize-textarea']) ?>
        </div>
        <div class="row no-marg-bot">
            <div class="col s12 m6 offset-m3">
                <button class="btn red fullWidth waves-effect waves-light">Отправить заявку</button>
            </div>
        </div>
        <?php ActiveForm::end() ?>
        <?php Pjax::end() ?>
    </div>
</div>
