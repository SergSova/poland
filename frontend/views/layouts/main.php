<?php

    /* @var $this \yii\web\View */
    /* @var $content string */

    use frontend\assets\AppAsset;
    use \common\models\Callback;
    use \common\models\Feedback;
    use macgyer\yii2materializecss\lib\Html;
    use macgyer\yii2materializecss\widgets\Nav;
    use macgyer\yii2materializecss\widgets\NavBar;
    use macgyer\yii2materializecss\widgets\Alert;
    use yii\helpers\Url;



    AppAsset::register($this);

    $feedbackModel = new Feedback();
    $callbackModel = new Callback();

    $this->registerMetaTag([
                               'name' => 'yandex-verification',
                               'content' => 'fe1be1f85741d159'
                           ]);

    $this->registerJs('(function (d, w, c) {(w[c] = w[c] || []).push(function() {try {w.yaCounter39973625 = new Ya.Metrika({id:39973625, clickmap:true, trackLinks:true, accurateTrackBounce:true, webvisor:true});} catch(e) { }});var n = d.getElementsByTagName("script")[0],s = d.createElement("script"),f = function () { n.parentNode.insertBefore(s, n); };s.type = "text/javascript";s.async = true;s.src = "https://mc.yandex.ru/metrika/watch.js";if (w.opera == "[object Opera]") {d.addEventListener("DOMContentLoaded", f, false);} else { f(); }})(document, window, "yandex_metrika_callbacks");', \yii\web\View::POS_HEAD);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">

<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <noscript><div><img src="https://mc.yandex.ru/watch/39973625" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
    <?php $this->head() ?>
</head>

<body>
<?php $this->beginBody() ?>

<header class="page-header">
    <?php
        NavBar::begin([
                          'brandLabel' => '<img src="'.Url::to('@web/img/small-logo.png').'" class="responsive-img">',
                          'brandUrl' => Yii::$app->homeUrl,
                          'fixed' => true,
                          'wrapperOptions' => [
                              'class' => 'container'
                          ],
                          'options' => ['class' => 'mypallete lighten']
                      ]);

        $menuItems = [
            [
                'label' => 'Каталог',
                'url' => ['site/catalog']
            ],
            [
                'label' => 'Услуги',
                'url' => [
                    'site/service'
                ],
            ],
            [
                'label' => 'Видео Обзоры',
                'url' => ['/site/video-review']
            ],
            [
                'label' => 'Технология',
                'url' => [
                    'site/technology',
                ],
            ],
            [
                'label' => 'О нас',
                'url' => [
                    'site/index',
                    '#' => 'about',
                ],
                'options' => ['class' => 'scrollTo']

            ],
            [
                'label' => 'Kонтакты',
                'url' => [
                    'site/index',
                    '#' => 'contacts'
                ],
                'options' => ['class' => 'scrollTo']
            ],
        ];

        $menuItems[] = '<li class="right actions">
                                <ul>
                                    <li class="waves-effect waves-light">
                                        <i class="material-icons modal-trigger" data-target="modalCall">phone_in_talk</i>
                                    </li>
                                    <li class="waves-effect waves-light">
                                        <i class="material-icons modal-trigger" data-target="modalEmail">mail</i>
                                    </li>
                                </ul>
                            </li>';
        echo Nav::widget([
                             'options' => [
                                 'class' => 'hide-on-med-and-down site-nav',
                                 'id' => 'general-menu'
                             ],
                             'items' => $menuItems,
                         ]);

        NavBar::end();
    ?>
</header>

<main class="content">
    <?= $content ?>
</main>

<div class="modal" id="modalCall">
    <div class="modal-content">
        <i class="material-icons right close-modal-but" data-target="#modalCall">close</i>
        <h4>Заказать обратный звонок</h4>
        <?= $this->render('../site/_formCallback', ['model' => $callbackModel]) ?>
    </div>
</div>
<div class="modal" id="modalEmail">
    <div class="modal-content">
        <i class="material-icons right close-modal-but" data-target="#modalEmail">close</i>
        <h4>Напишите нам</h4>
        <?= $this->render('../site/_formFeedback', ['model' => $feedbackModel]) ?>
    </div>
</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
