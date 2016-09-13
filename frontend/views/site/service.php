<?php
    /**
     * @var $this  \yii\web\View
     * @var $model \common\models\Service[]
     */

    use yii\helpers\Url;

    $this->title = 'Услуги компании застройщика - “Новый адрес”';
    $this->registerMetaTag([
                               'name' => 'description',
                               'content' => 'Услуги компании застройщика - “Новый адрес”. Наша компания поможет Вам с покупкой дома, арендой, продажей, страховкой дома.'
                           ]);

    $this->registerMetaTag([
                               'name' => 'keywords',
                               'content' => 'Услуги застройщиков, Услуги агентства недвижимости, помощь в покупке домов, помощь в продаже домов'
                           ]);
?>

    <!-- services -->
    <div class="section mypallete white-text scrollspy" id="services">
        <div class="container">
            <h1 class="white-text center">Услуги компании <br>застройщика - "Новый адрес"</h1>
            <div class="row no-marg-bot">
                <br>
                <?php foreach($model as $item): ?>
                    <div class="col s12 m4 l4 center hide-on-med-and-down">
                        <a href="#service<?= $item->id ?>" class="scrollTo">
                            <?php if($item->icon): ?>
                                <img class="responsive-img" src="<?= Url::to('@web/'.$item->icon) ?>">
                            <?php endif ?>
                            <h3 class=""><?= $item->title ?></h3>
                            <p class=""><?= $item->short_description ?></p>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <div class="section">
        <div class="row no-marg-bot">
            <p class="flow-text mypallete-text center">Если Вы не смогли найти нужную Вам услугу, напишите нам и мы найдем решение <i
                    class="material-icons modal-trigger" data-target="modalEmail">mail</i></p>
        </div>
    </div>

<?php foreach($model as $item): ?>
    <div class="section" id="service<?= $item->id ?>">
        <div class="row no-marg-bot">
            <h3 class="flow-text"><?= $item->title ?></h3>
            <p><?= $item->full_description ?></p>
        </div>
    </div>
<?php endforeach; ?>