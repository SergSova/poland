<?php
    /**
     * @var \yii\web\View $this
     * @var \common\models\House $model
     */
?>
<div class="row realty-data">
    <div class="col s12">
        <ul class="tabs">
            <li class="tab col s4"><a class="active" href="#characteristics">Характеристики</a></li>
            <li class="tab col s4"><a href="#communacions">Коммуникации</a></li>
            <li class="tab col s4"><a href="#additional">Дополнительно</a></li>
        </ul>
    </div>
    <div class="col s12" id="characteristics">
        <table class="striped">
            <tr>
                <td>Плошадь дома</td>
                <td><?= $model->house_area ?> м2</td>
            </tr>
            <tr>
                <td>Плошадь участка</td>
                <td><?= $model->land_area ?> м2</td>
            </tr>
            <tr>
                <td>Размер дома</td>
                <td><?= $model->house_type ?></td>
            </tr>
            <tr>
                <td>Удаленность от МКАД</td>
                <td><?= $model->distance ?> км</td>
            </tr>
        </table>
    </div>
    <div class="col s12" id="communacions" style="display: none">
        <table class="striped">
            <tr>
                <td>Электричество</td>
                <td><?= $model->communication_electro ?></td>
            </tr>
            <tr>
                <td>Вода</td>
                <td><?= $model->communication_water ?></td>
            </tr>
            <tr>
                <td>Газ</td>
                <td><?= $model->communication_gas ?></td>
            </tr>
            <tr>
                <td>Канализация</td>
                <td><?= $model->communication_sewage ?></td>
            </tr>
        </table>
    </div>
    <div class="col s12" id="additional" style="display: none">
        <table class="striped">
            <tr>
                <td>Внешняя отделка</td>
                <td><?= $model->decor_outside ?></td>
            </tr>
            <tr>
                <td>Внутрення отделка</td>
                <td><?= $model->decor_inside ?></td>
            </tr>
            <tr>
                <td>Санузлы</td>
                <td><?= $model->bath_count ?></td>
            </tr>
        </table>
    </div>
</div>