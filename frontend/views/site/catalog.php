<?php
    /**
     * @var \yii\web\View                $this
     * @var \frontend\models\Search      $searchModel
     * @var \yii\data\ActiveDataProvider $dataProvider
     */
    use common\models\District;
    use common\models\House;
    use frontend\assets\CatalogAsset;
    use frontend\models\Search;
    use macgyer\yii2materializecss\lib\Html;
    use macgyer\yii2materializecss\widgets\FixedActionButton;
    use macgyer\yii2materializecss\widgets\form\ActiveForm;
    use yii\helpers\ArrayHelper;
    use yii\helpers\Url;
    use yii\web\View;
    use yii\widgets\ListView;
    use yii\widgets\Pjax;

    $this->title = 'catalog';
    CatalogAsset::register($this);

    $housePriceInterval = Search::getPriceInterval(1);
    $apartmentPriceInterval = Search::getPriceInterval(2);
    $houseAreaInterval = Search::getInterval('house_area', 'house');
    $houseDistanceInterval = Search::getInterval('distance', 'house');
    $apartmentAreaInterval = Search::getInterval('area', 'apartment');

    $pjaxScript = <<<JS
    function updateData(){
        $.pjax.reload({container:"#realty-list"});
        $("select").material_select();
        for(var i = 0; i < slidersSettings.length; i++){
            createSlider(slidersSettings[i]);
        }
    }
$("#house-filter").on("pjax:end", updateData);
$("#apartment-filter").on("pjax:end", updateData);
$("#mobile-house-filter").on("pjax:end", function() {
    $("#showFilter").sideNav('hide');
    updateData();
});
$("#mobile-apartment-filter").on("pjax:end", function() {
    $("#showFilter").sideNav('hide');
    updateData();
});
JS;
    $this->registerJs($pjaxScript);
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
                <?php Pjax::begin(['id' => 'realty-list']); ?>    <?= ListView::widget([
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