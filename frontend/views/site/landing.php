<?php

    /**
     * @var                                $this yii\web\View
     * @var \frontend\models\ContactForm   $feedback
     * @var \frontend\models\Callback $callback
     */

    use common\models\District;
    use common\models\Realty;
    use frontend\assets\LandingAsset;
    use frontend\models\Search;
    use macgyer\yii2materializecss\lib\Html;
    use macgyer\yii2materializecss\widgets\form\ActiveForm;
    use yii\helpers\ArrayHelper;
    use yii\helpers\Url;
    use yii\web\View;
    use yii\widgets\Pjax;

    $this->title = 'Landing';
    LandingAsset::register($this);
    $models = Realty::find()
                    ->where([
                                'status' => [
                                    'active',
                                    'deposit'
                                ]
                            ])
                    ->all();
    $hot = array_slice($models, -4);
    $markersData = [];
    foreach($models as $realty){
        $coord = explode(';', $realty->map_coord);
        $content = $this->render('_map_prev', ['model' => $realty]);

        $markersData[] = [
            'position' => [
                'lat' => $coord[0] * 1,
                'lng' => $coord[1] * 1
            ],
            'content' => $content
        ];
    }
    $markersData = json_encode($markersData);

    $mapConfig = [
        'center' => Yii::$app->params['mapCenter'],
        'zoom' => Yii::$app->params['mapZoom'],
    ];
    $mapConfig = json_encode($mapConfig);

    $script = <<<JS
mapInit({$mapConfig});
showMarkers({$markersData});
JS;
    $this->registerJs($script);

    $housePriceInterval = Search::getPriceInterval(1);
    $apartmentPriceInterval = Search::getPriceInterval(2);
    $houseAreaInterval = Search::getInterval('house_area', 'house');
    $houseDistanceInterval = Search::getInterval('distance', 'house');
    $apartmentAreaInterval = Search::getInterval('area', 'apartment');
    $searchModel = new Search();

    $sliderScript = <<<JS
var slidersSettings = [
    {
        id: '#house-price',
        type: 'double',
        postfix: ' руб',
        min: {$housePriceInterval[0]},
        max: {$housePriceInterval[1]}
    },
    {
        id: '#search-house_area',
        type: 'double',
        postfix: ' м2',
        min: {$houseAreaInterval[0]},
        max: {$houseAreaInterval[1]}
    },
    {
        id: '#search-house_distance',
        type: 'double',
        postfix: ' км',
        min: {$houseDistanceInterval[0]},
        max: {$houseDistanceInterval[1]}
    },
    {
        id: '#apartment-price',
        type: 'double',
        postfix: ' руб',
        min: {$apartmentPriceInterval[0]},
        max: {$apartmentPriceInterval[1]}
    },
    {
        id: '#search-apartment_area',
        type: 'double',
        postfix: ' м2',
        min: {$apartmentAreaInterval[0]},
        max: {$apartmentAreaInterval[1]}
    },
];
function createSlider(obj){
    var sliderInp = $(obj.id);
    var delimPos = sliderInp.val().indexOf(';');
    var min = sliderInp.val().substring(0, delimPos);
    var max = sliderInp.val().substring(delimPos+1);
    
    return sliderInp.ionRangeSlider({
        type: obj.type,
        min: obj.min,
        max: obj.max,

        postfix: obj.postfix
    });
    
}

for(var i = 0; i < slidersSettings.length; i++){
   createSlider(slidersSettings[i]);
}    
JS;
    $this->registerJs($sliderScript, View::POS_END);

?>
<!-- hero box -->
<div class="sectionWithBg fullHeight scrollspy" id="hero-box">
    <div class="sectionWithBg-wrap valign-wrapper padBot-on-small-only">
        <div class="container valign">
            <div class="row">
                <div class="col s12 m4 l3 center-on-small-only">
                    <br>
                    <br>
                    <img class="responsive-img" src="<?= Url::to('@web/img/big-logo.png')?>">
                </div>
                <div class="col s12 m8 l9 mypallete-text center-on-small-only">
                    <h1 class="hide-on-med-and-down">Новый Адрес</h1>
                    <h2 class="hide-on-small-only">Мы найдем дом Вашей мечты</h2>
                    <p class="flow-text">Дом там, где сердце! Мы поможем Вам и Вашей семье найти место, где вы будете чувствовать себя, как дома!</p>
                </div>
            </div>
            <div class="row">
                <div class="col s12 m6 l4 offset-l2 marg-bot">
                    <a href="<?= Url::to(['site/catalog']) ?>" class="btn fullWidth mypallete waves-effect waves-light">Перейти к каталогу</a>
                </div>
                <div class="col s12 m6 l4 scrollTo">
                    <a href="#services" class="btn fullWidth mypallete waves-effect waves-light">Наши услуги</a>
                </div>
            </div>
        </div>
        <button class="btn-floating mypallete lighten scrollDown hide-on-med-and-down waves-effect waves-light" data-target="#map-box"><i
                class="large material-icons">keyboard_arrow_down</i></button>
    </div>
</div>
<!-- map box -->
<div class="map-wrapper fullHeight scrollspy" id="map-box">
    <div class="map-container hide-on-small-only" id="map"></div>
    <div class="map-filter">
        <div class="filter-box">
            <div class="card mypallete white-text">
                <div class="row no-marg-bot">
                    <div class="col s12">
                        <ul class="tabs">
                            <li class="tab col s6 waves-effect waves-light"><a href="#house">Дома</a></li>
                            <li class="tab col s6 waves-effect waves-light"><a href="#apartment">Квартиры</a></li>
                        </ul>
                    </div>
                    <div class="col s12" id="house">
                        <br>
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
                    </div>
                    <div class="col s12" id="apartment" style="display: none">
                        <br>
                        <?php $apartmentForm = ActiveForm::begin([
                                                                     'method' => 'GET',
                                                                     'action' => ['catalog'],
                                                                     'options' => ['data-pjax' => true]
                                                                 ]); ?>
                        <div class="row">

                            <?= $apartmentForm->field($searchModel, 'districtId',
                                                      ['options' => ['class' => 'input-field marg-top col s10 offset-s1']])
                                              ->dropDownList(ArrayHelper::map(District::find()
                                                                                      ->all(), 'id', 'name'), ['prompt' => 'Все направления'])
                                              ->label('Направление') ?>
                            <?= Html::activeHiddenInput($searchModel, 'realtyTypeId', ['value' => 2]) ?>
                            <?= Html::activeHiddenInput($searchModel, 'serviceTypeId', ['value' => 1]) ?>

                            <div class="input-field no-marg-top col s10 offset-s1">
                                <p class="label no-marg-bot">Стоимость, руб</p>
                                <?= Html::activeInput('text', $searchModel, 'price', ['id' => 'apartment-price']) ?>
                            </div>
                            <div class="input-field no-marg-top col s10 offset-s1">
                                <p class="label no-marg-bot">Площадь квартиры, м2</p>
                                <?= Html::activeInput('text', $searchModel, 'apartment_area') ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col s12 mypallete lighten">
                                <br>
                                <?= $apartmentForm->field($searchModel, 'apartment_rooms',
                                                          ['options' => ['class' => 'input-field marg-top col s10 offset-s1']])
                                                  ->dropDownList([
                                                                     0 => 'Любое',
                                                                     1 => 1,
                                                                     2 => 2,
                                                                     3 => 3,
                                                                     4 => 4
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
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<!-- hot box -->
<div class="section scrollspy" id="hot-box">
    <div class="container">
        <h2 class="mypallete-text center">Горячие предложения</h2>
        <div class="row">
            <?php
                foreach($hot as $realty):
                    ?>
                    <?= $this->render('_hot_item', ['model' => $realty]) ?>
                    <?php
                endforeach;
            ?>
        </div>
        <div class="row">
            <div class="col s12 m4 offset-m4">
                <a href="<?= Url::to(['site/catalog']) ?>" class="btn fullWidth red waves-effect waves-light">Все горячие предложения</a>
            </div>
        </div>
    </div>
</div>
<!-- services -->
<div class="section mypallete white-text scrollspy" id="services">
    <div class="container">
        <h2 class="white-text center">Наши услуги</h2>
        <div class="row no-marg-bot">
            <br>
            <div class="col s12 m4 l4 center">
                <img class="responsive-img" src="<?= Url::to('@web/img/icon-serv1.png')?>">
                <p class="flow-text">Юридическое сопровождение сделки купли/продажи</p>
            </div>
            <div class="col s12 m4 l4 center">
                <img class="responsive-img" src="<?= Url::to('@web/img/icon-serv2.png')?>">
                <p class="flow-text">Помощь в получении ипотеки с/без первоначального взноса</p>
            </div>
            <div class="col s12 m4 l4 center">
                <img class="responsive-img" src="<?= Url::to('@web/img/icon-serv3.png')?>">
                <p class="flow-text">Возможность использовать материснкий капитал</p>
            </div>
        </div>
        <div class="row no-marg-bot">
            <div class="col s12 m4 l4 center">
                <img class="responsive-img" src="<?= Url::to('@web/img/icon-serv4.png')?>">
                <p class="flow-text">Гарантированное прохождение опеки</p>
            </div>
            <div class="col s12 m4 l4 center">
                <img class="responsive-img" src="<?= Url::to('@web/img/icon-serv4.png')?>">
                <p class="flow-text">Помощь в продаже недвижимости</p>
            </div>
            <div class="col s12 m4 l4 center">
                <img class="responsive-img" src="<?= Url::to('@web/img/icon-serv4.png')?>">
                <p class="flow-text">Рассмотрение вариантов взаиморасчета</p>
            </div>
        </div>
    </div>
</div>
<div class="section">
    <div class="row no-marg-bot">
        <p class="flow-text mypallete-text center">Консультацию по услугам Вы можете получить по телефону +7 000 000 00 00 или закажите обратный
            звонок!</p>
        <div class="col s12 m8 offset-m2 l6 offset-l3 waves-effect waves-light">
            <div class="row no-marg-bot mypallete feedback-call">
                <div class="col s12 m6 push-m6">
                    <?= Html::input('tel', 'ServiceCallModel[phone]', null, [
                        'class' => 'center',
                        'id' => 'service-call-inp',
                        'placeholder' => '8 000 000 00 00'
                    ]) ?>
                </div>
                <div class="col s12 m6 pull-m6">
                    <button class="btn fullWidth mypallete" id="service-call-button"><i class="material-icons left">phone_in_talk</i>Заказать звонок
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- videoreview box -->
<?php if($videoReview):?>
<div class="sectionWithBg fullHeight scrollspy" id="videoreview-box">
    <div class="sectionWithBg-wrap valign-wrapper">
        <div class="container valign" id="videobox">
            <div id="videobox-title">
                <div class="row">
                    <div class="col s12 m10 offset-m1">
                        <div class="card">
                            <div class="card-content center">
                                <p class="card-title mypallete-text"><?= $videoReview->title?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <iframe id="videobox-container" width="1280" height="720" src="https://www.youtube.com/embed/<?= $videoReview->video?>?enablejsapi=1" frameborder="0" allowfullscreen></iframe>

            <div id="videobox-description">
                <div class="row">
                    <div class="col s12 m10 offset-m1">
                        <div class="card">
                            <div class="card-content center">
                                <p class="flow-text mypallete-text"><?= $videoReview->description?></p>
                                <div class="row">
                                    <div class="col s12 m6 marg-bot"><a href="<?= Url::to(['site/catalog'])?>" class="btn mypallete fullWidth waves-effect waves-light">Открыть в каталоге</a></div>
                                    <div class="col s12 m6"><a href="<?= Url::to(['site/video-review'])?>" class="btn red fullWidth waves-effect waves-light">Все Обзоры</a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<?php endif; ?>
<!-- techology -->
<div class="section mypallete white-text">
    <div class="container">
        <h2 class="center">Технология строительства</h2>
    </div>
</div>
<div class="section scrollspy" id="technology">
    <div class="container">
        <div class="tech-item">
            <p class="flow-text center"><strong>Фундамент</strong></p>
            <div class="cover">
                <img class="responsive-img" src="img/fundament.jpg">
            </div>
            <p class="flow-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eum debitis maxime ipsum, optio quam magnam omnis iste vel
                hic cumque blanditiis expedita aliquam odio vitae id, rem obcaecati ipsa velit. Lorem ipsum dolor sit amet, consectetur adipisicing
                elit. Cum voluptas tenetur, voluptatibus mollitia odio sint, alias debitis quasi ut. Ut amet qui id magni consectetur recusandae
                sequi, aperiam, voluptatem repellendus!</p>
        </div>
        <div class="tech-item">
            <p class="flow-text center"><strong>Фундамент</strong></p>
            <div class="cover">
                <img class="responsive-img" src="img/fundament.jpg">
            </div>
            <p class="flow-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eum debitis maxime ipsum, optio quam magnam omnis iste vel
                hic cumque blanditiis expedita aliquam odio vitae id, rem obcaecati ipsa velit. Lorem ipsum dolor sit amet, consectetur adipisicing
                elit. Cum voluptas tenetur, voluptatibus mollitia odio sint, alias debitis quasi ut. Ut amet qui id magni consectetur recusandae
                sequi, aperiam, voluptatem repellendus!</p>
        </div>
        <div class="tech-item">
            <p class="flow-text center"><strong>Фундамент</strong></p>
            <div class="cover">
                <img class="responsive-img" src="img/fundament.jpg">
            </div>
            <p class="flow-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eum debitis maxime ipsum, optio quam magnam omnis iste vel
                hic cumque blanditiis expedita aliquam odio vitae id, rem obcaecati ipsa velit. Lorem ipsum dolor sit amet, consectetur adipisicing
                elit. Cum voluptas tenetur, voluptatibus mollitia odio sint, alias debitis quasi ut. Ut amet qui id magni consectetur recusandae
                sequi, aperiam, voluptatem repellendus!</p>
        </div>
        <div class="tech-item">
            <p class="flow-text center"><strong>Фундамент</strong></p>
            <div class="cover">
                <img class="responsive-img" src="img/fundament.jpg">
            </div>
            <p class="flow-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eum debitis maxime ipsum, optio quam magnam omnis iste vel
                hic cumque blanditiis expedita aliquam odio vitae id, rem obcaecati ipsa velit. Lorem ipsum dolor sit amet, consectetur adipisicing
                elit. Cum voluptas tenetur, voluptatibus mollitia odio sint, alias debitis quasi ut. Ut amet qui id magni consectetur recusandae
                sequi, aperiam, voluptatem repellendus!</p>
        </div>
        <div class="tech-item">
            <p class="flow-text center"><strong>Фундамент</strong></p>
            <div class="cover">
                <img class="responsive-img" src="img/fundament.jpg">
            </div>
            <p class="flow-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eum debitis maxime ipsum, optio quam magnam omnis iste vel
                hic cumque blanditiis expedita aliquam odio vitae id, rem obcaecati ipsa velit. Lorem ipsum dolor sit amet, consectetur adipisicing
                elit. Cum voluptas tenetur, voluptatibus mollitia odio sint, alias debitis quasi ut. Ut amet qui id magni consectetur recusandae
                sequi, aperiam, voluptatem repellendus!</p>
        </div>
    </div>
</div>
<!-- contacts box -->
<div class="sectionWithBg fullHeight scrollspy" id="contacts">
    <div class="sectionWithBg-wrap valign-wrapper">
        <div class="container valign">
            <div class="row contact-info mypallete-text">
                <div class="col s12 m12 l5">
                    <div class="row center-on-small-only">
                        <p class="flow-text col s12 m6 l12"><i class="material-icons">phone_in_talk</i><strong>+7 000 000 00 00</strong></p>
                        <p class="flow-text col s12 m6 l12"><i class="material-icons">mail</i><strong>example<span
                                    class="r">@</span>email.com</strong></p>
                    </div>
                </div>
                <div class="col s12 m12 l7">
                    <p class="flow-text center">Если у Вас остались вопросы, напишите нам!</p>
                    <?php $feedbackForm = ActiveForm::begin([
                                                                'action' => [
                                                                    'site/send-mail'
                                                                ],
                                                                'options' => [
                                                                    'class' => 'feedback-email',
                                                                    'id' => 'sendMail-form'
                                                                ]

                                                            ]) ?>
                    <?= $feedbackForm->field($feedback, 'name', ['options' => ['class' => 'input-field col s12 m6']]) ?>
                    <?= $feedbackForm->field($feedback, 'email', ['options' => ['class' => 'input-field col s12 m6']]) ?>
                    <?= $feedbackForm->field($feedback, 'subject', ['options' => ['class' => 'input-field col s12']]) ?>
                    <?= $feedbackForm->field($feedback, 'body', ['options' => ['class' => 'input-field col s12']])
                                     ->textarea(['class' => 'materialize-textarea']) ?>
                    <div class="input-field col s12">
                        <button class="btn fullWidth mypallete waves-effect waves-light">Отправить сообщение</button>
                    </div>
                    <?php ActiveForm::end() ?>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- footer -->


<!-- sidebar -->
<ul class="mysidebar table-of-contents" id="scrollbar">
    <li><a href="#hero-box" class="tooltipped" data-position="left" data-delay="50" data-tooltip="О нас"></a></li>
    <li><a href="#map-box" class="tooltipped" data-position="left" data-delay="50" data-tooltip="Карта"></a></li>
    <li><a href="#hot-box" class="tooltipped" data-position="left" data-delay="50" data-tooltip="Горячие предложения"></a></li>
    <li><a href="#services" class="tooltipped" data-position="left" data-delay="50" data-tooltip="Услуги"></a></li>
    <li><a href="#videoreview-box" class="tooltipped" data-position="left" data-delay="50" data-tooltip="Видео обзор"></a></li>
    <li><a href="#technology" class="tooltipped" data-position="left" data-delay="50" data-tooltip="Технология"></a></li>
    <li><a href="#contacts" class="tooltipped" data-position="left" data-delay="50" data-tooltip="Контакты"></a></li>
</ul>
