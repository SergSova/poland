<?php

    /**
     * @var                                $this yii\web\View
     * @var \frontend\models\ContactForm   $feedback
     * @var \frontend\models\Callback      $callback
     */

    use common\models\Action;
    use common\models\Realty;
    use frontend\assets\LandingAsset;
    use frontend\models\Search;
    use macgyer\yii2materializecss\widgets\form\ActiveForm;
    use yii\helpers\Url;
    use yii\web\View;
    use yii\widgets\Pjax;

    $this->title = 'Агентство недвижимости и застройщики в Москве - Новый адрес, подберем Вам дом';
    $this->registerMetaTag([
                               'name' => 'description',
                               'content' => 'Агентство недвижимости в Москве - Новый адрес, широкий выбор домов для покупки или аренды, мы являемся компанией застройщиком'
                           ]);
    $this->registerMetaTag([
                               'name' => 'keywords',
                               'content' => 'Агентство недвижимости, Москва недвижимость, Новый адрес'
                           ]);

    LandingAsset::register($this);

        $markersData = json_encode(Realty::getMarkerData());

        $mapConfig = json_encode(Yii::$app->params['mapConfig']);

        $searchModel = new Search();

    $MapInit = <<<JS
mapInit({$mapConfig});
showMarkers({$markersData});
JS;
    $this->registerJs($MapInit, View::POS_END);
?>
<!-- hero box -->
<div class="sectionWithBg fullHeight scrollspy" id="hero-box">
    <div class="sectionWithBg-wrap valign-wrapper padBot-on-small-only">
        <div class="container valign">
            <div class="row">
                <div class="col s12 m4 l3 center-on-small-only">
                    <br>
                    <br>
                    <img class="responsive-img" src="<?= Url::to('@web/img/big-logo.png') ?>">
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
                <div class="col s12 m6 l4">
                    <a href="<?= Url::to(['site/service']) ?>" class="btn fullWidth mypallete waves-effect waves-light">Наши услуги</a>
                </div>
            </div>
        </div>
        <button class="btn-floating mypallete lighten scrollDown hide-on-med-and-down waves-effect waves-light" data-target="#map-box"><i
                class="large material-icons">keyboard_arrow_down</i></button>
    </div>
</div>
<!-- map box -->
<div class="section scrollspy fullHeight no-padding" id="map-box">
    <h1 class="mypallete-text center map-header">Дома от застройщика - “Новый Адрес“</h1>
    <div class="map-wrapper">
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
                            <?= $this->render('_filterHouse', ['searchModel' => $searchModel]) ?>
                        </div>
                        <div class="col s12" id="apartment" style="display: none">
                            <?= $this->render('_filterApartment', ['searchModel' => $searchModel]) ?>
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
        <h2 class="mypallete-text center">Горячие предложения недвижимости - Дома</h2>
        <div class="row">
            <?php
                foreach(Realty::getModelWithActionName('hot', 4) as $realty):
                    ?>
                    <?= $this->render('_hot_item', ['model' => $realty->model]) ?>
                    <?php
                endforeach;
            ?>
        </div>
        <div class="row">
            <div class="col s12 m4 offset-m4">
                <a href="<?= Url::to([
                                         'site/catalog',
                                         'Search[action_id]' => Action::findOne(['name' => 'hot'])->id
                                     ]) ?>" class="btn fullWidth red waves-effect waves-light">Все горячие предложения</a>
            </div>
        </div>
    </div>
</div>
<!-- videoreview box -->
<?php if($videoReview): ?>
    <div class="sectionWithBg scrollspy" id="videoreview-box">
        <div class="sectionWithBg-wrap">
            <h2 class="mypallete-text center videoreview-header">Видео Обзоры</h2>
            <div class="valign-wrapper">
                <div class="valign" id="videobox">
                    <div id="videobox-title">
                        <div class="row">
                            <div class="col s12 m10 offset-m1">
                                <div class="card">
                                    <div class="card-content center">
                                        <p class="card-title mypallete-text"><?= $videoReview->title ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <iframe id="videobox-container" width="1280" height="720"
                            src="https://www.youtube.com/embed/<?= $videoReview->video ?>?enablejsapi=1"
                            frameborder="0" allowfullscreen></iframe>

                    <div id="videobox-description">
                        <div class="row">
                            <div class="col s12 m10 offset-m1">
                                <div class="card">
                                    <div class="card-content center">
                                        <p class="flow-text mypallete-text"><?= $videoReview->description ?></p>
                                        <div class="row">
                                            <div class="col s12 m6 marg-bot"><a href="<?= Url::to(['site/catalog']) ?>"
                                                                                class="btn mypallete fullWidth waves-effect waves-light">Открыть в
                                                    каталоге</a></div>
                                            <div class="col s12 m6"><a href="<?= Url::to(['site/video-review']) ?>"
                                                                       class="btn red fullWidth waves-effect waves-light">Все Обзоры</a></div>
                                        </div>
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
        <h2 class="center">Информация о нашем Агентстве недвижимости</h2>
    </div>
</div>
<div class="section scrollspy" id="about">
    <div class="container">
        <p class="flow-text center">
            10 причин, почему вам стоит покупать дома у нас
            За много лет работы на рынке <strong>застройщик</strong> “Новый адрес” изучил потребности клиентов и точно знает, что предложить каждому
            из вас. Мы перепробовали много технологий, материалов, способов строительства и выбрали самые лучшие, чтобы дарить вам комфорт и тепло.
            Ищете новое жилье, в котором можно было бы находиться круглый год? Нет проблем! Обращайтесь к <strong>застройщику</strong> и <strong>агентству
                недвижимости в Москве “Новый адрес”</strong>.
        </p>
        <ol>
            <li>
                Вы сможете выбрать для себя оптимальное соотношение “цена - качество”. Мы предлагаем множество объектов по доступной цене.
            </li>
            <li>
                Вы будете жить в том районе, в котором сами захотите: у нас огромный выбор <strong>домов в Подмосковье</strong> - от Ленинградского до
                Носовихинского
                шоссе.
            </li>
            <li>
                У вас будет определенное место жительства - на каждый участок есть право собственности, поэтому вы сможете прописаться в доме.
            </li>
            <li>
                Вам не надо переживать за обустройство жилья, мы строим <strong>дома в Подмосковье</strong> “под ключ” - выполняем всю внутреннюю
                отделку, заводим
                коммуникации. Вам остается только завезти мебель и заселяться!
            </li>
            <li>После покупки, вы сможете жить в новом доме круглый год. Мы заботимся о том, чтобы у наших клиентов была возможность подъехать на
                машине
                ко всем объектам в любую погоду.
            </li>
            <li>С нашим <strong>агентством недвижимости в Москве</strong> вы подберете дом с той инфраструктурой, которая нужна именно вам. Хотите
                жить рядом со
                школой,
                детским садом или рядом с вокзалом? Не проблема, найдем для вас подходящий объект!
            </li>
            <li>Вы можете быть уверены в качестве работы <strong>застройщика</strong>. Все <strong>дома в Подмосковье</strong> строятся по современным
                европейским технологиям.
            </li>
            <li>Наше <strong>агентство недвижимости</strong> работает уже 10 лет на <strong>Московском</strong> рынке, и за это время зарекомендовало
                себя как надежный партнер.
            </li>
            <li>С вами работают опытные специалисты: у нас вы можете получить юридическое сопровождение сделок, помощь в оформлении ипотеки и другие
                услуги.
            </li>
            <li>За время нашей работы уже более ___ человек стали счастливыми обладателями комфортных <strong>домов в Подмосковье</strong>.</li>
        </ol>

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
    <li><a href="#videoreview-box" class="tooltipped" data-position="left" data-delay="50" data-tooltip="Видео обзор"></a></li>
    <li><a href="#about" class="tooltipped" data-position="left" data-delay="50" data-tooltip="О нас"></a></li>
    <li><a href="#contacts" class="tooltipped" data-position="left" data-delay="50" data-tooltip="Контакты"></a></li>
</ul>
