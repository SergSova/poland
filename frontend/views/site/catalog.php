<?php
    /**
     * @var \yii\web\View                $this
     * @var \frontend\models\Search      $searchModel
     * @var \yii\data\ActiveDataProvider $dataProvider
     */
    use frontend\assets\CatalogAsset;
    use yii\widgets\ListView;
    use yii\widgets\Pjax;

    $this->title = 'catalog';
    CatalogAsset::register($this);

?>
<button class="hide-on-large-only" data-activates="mobile-filter" id="showFilter"><i class="material-icons">search</i></button>
<div class="row">
    <div class="hide-on-med-and-down" id="filter-box">
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
        <div class="col s12 m12 l9 relative">
            <div class="row no-marg-bot">
                <?php Pjax::begin(['id' => 'realty-list']); ?>
                <?= ListView::widget([
                                         'dataProvider' => $dataProvider,
                                         'itemView' => '_catalog_item',
                                         'layout' => "<div class='row'>{items}</div><div class='row center'>{pager}</div>",
                                         'pager' => [
                                             'options' => ['class' => 'pagination'],
                                             'prevPageLabel' => '<i class="material-icons">chevron_left</i>',
                                             'nextPageLabel' => '<i class="material-icons">chevron_right</i>',
                                             'pageCssClass' => 'waves-effect'
                                         ]
                                     ]) ?>
                <?php Pjax::end(); ?>
            </div>
        </div>
    </div>
</div>

<div class="side-nav mypallete white-text" id="mobile-filter">
    <?= $this->render('_mobile_filter', ['searchModel' => $searchModel]) ?>
</div>