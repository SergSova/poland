<?php
    /* @var \common\models\House $model*/
?>
<div class="panel panel-default">
    <div class="panel-heading">Характеристики</div>
    <div class="panel-body">
        <p>Площадь дома: <strong><?= $model->house_area ?></strong></p>
        <p>Площадь участка: <strong><?= $model->land_area ?></strong></p>
        <p>Размер дома: <strong><?= $model->house_type ?></strong></p>
        <p>Удалленость от МКАД: <strong><?= $model->distance ?></strong></p>
    </div>
</div>
<div class="panel panel-default">
    <div class="panel-heading">Коммуникации</div>
    <div class="panel-body">
        <p>Вода: <strong><?= $model->communication_water ?></strong></p>
        <p>газ: <strong><?= $model->communication_gas ?></strong></p>
        <p>Электричество: <strong><?= $model->communication_electro ?></strong></p>
        <p>Канализация: <strong><?= $model->communication_sewage ?></strong></p>
    </div>
</div>
