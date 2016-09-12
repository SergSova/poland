<?php
    /* @var \common\models\Apartment $model*/
?>
<div class="panel panel-default">
    <div class="panel-heading">Характеристики</div>
    <div class="panel-body">
        <p>Площадь: <strong><?= $model->area ?></strong></p>
        <p>Площадь комнат: <strong><?= $model->rooms_area ?></strong></p>
        <p>Площадь кухни: <strong><?= $model->kitchen_area ?></strong></p>
        <p>Тип санузла: <strong><?= $model->bathroom_type ?></strong></p>
        <p>Балкон: <strong><?= $model->balcony ?></strong></p>
        <p>Этаж: <strong><?= $model->floor ?></strong></p>
    </div>
</div>
<div class="panel panel-default">
    <div class="panel-heading">Дом</div>
    <div class="panel-body">
        <p>Год постройки: <strong><?= $model->house_year ?></strong></p>
        <p>Этажность: <strong><?= $model->house_floor_count ?></strong></p>
        <p>Материал: <strong><?= $model->house_material ?></strong></p>
    </div>
</div>
