<?php
    /**
     * @var \yii\web\View           $this
     * @var \frontend\models\Search $searchModel
     */

    $prefix = '';
?>
<div class="filter-box">
    <div class="row no-marg-bot">
        <div class="col s12">
            <ul class="tabs">
                <li class="tab col s6 waves-effect waves-light"><a href="#mobile-filter-house">Дома</a></li>
                <li class="tab col s6 waves-effect waves-light"><a href="#mobile-filter-apartment">Квартиры</a></li>
            </ul>
        </div>

        <div class="col s12" id="mobile-filter-house">
            <?= $this->render('_filterHouse', [
                'searchModel' => $searchModel,
            ]) ?>
        </div>
        <div class="col s12" id="mobile-filter-apartment">
            <?= $this->render('_filterApartment', [
                'searchModel' => $searchModel,
            ]) ?>
        </div>

    </div>
</div>
