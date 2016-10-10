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
                    <h1 class="hide-on-med-and-down general-title">Дома от застройщика<br>Новый Адрес</h1>
                    <!--                    <h2 class="hide-on-small-only">Мы найдем дом Вашей мечты</h2>-->
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
        <h2 class="btn mypallete lighten scrollDown hide-on-med-and-down waves-effect waves-light btn-to-map" data-target="#map-box"><i
                class="large material-icons right">keyboard_arrow_down</i>Наши дома в Подмосковье</h2>
    </div>
</div>
<!-- map box -->
<div class="section scrollspy fullHeight no-padding" id="map-box">
    <h2 class="mypallete white-text center map-header section-title">Дома от застройщика - "Новый Адрес"</h2>
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
<?php
    $hotRealties = Realty::getModelWithActionName('hot', 4);
    if(!empty($hotRealties)):
        ?>
        <div class="section scrollspy no-pad" id="hot-box">
            <h2 class="mypallete white-text center section-title">Горячие предложения недвижимости - Дома</h2>
            <div class="container">
                <div class="row">
                    <?php
                        foreach($hotRealties as $realty):
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
    <?php endif; ?>
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
<!-- about -->
<?= $this->render('about') ?>
<!-- contacts box -->
<?= $this->render('contact', ['feedback' => $feedback]) ?>
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
