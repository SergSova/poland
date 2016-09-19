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
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">

<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
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
                    '#'=>'about',
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
    <?= Alert::widget() ?>
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
