<?php
    /**
     * @var \yii\web\View               $this
     * @var \common\models\VideoReview[] $models
     */
    $this->title = 'Дома в Московской области - видео обзоры';
    $this->registerMetaTag([
                               'name' => 'description',
                               'content' => 'Видео обзоры домов от застройщика в Московской области, посмотреть дом снаружи и внутри - компания "Новый адрес"'
                           ]);
?>
<h1 class="center catalog-title-h1">Дома от застройщика - видео обзоры</h1>
<div class="container">
    <?php
        if(!empty($models)):
            foreach($models as $model):
                ?>
                <div class="card">
                    <div class="row">
                        <div class="col s12">
                            <div class="flow-text mypallete-text center"><?= $model->title ?></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s12 m12 l8">
                            <div class="video-container">
                                <iframe width="853" height="480" src="//www.youtube.com/embed/<?= $model->video ?>?rel=0" frameborder="0"
                                        allowfullscreen></iframe>
                            </div>
                        </div>
                        <div class="col s12 m12 l4">
                            <div class="card-content flow-text">
                                <?= $model->description ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
            endforeach;
        else:?>
            <h2 class="center">Ничего не найдено</h2>
        <?php endif; ?>
</div>
