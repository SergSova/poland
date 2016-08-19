<?php
    /**
     * @var \yii\web\View $this
     * @var \common\models\Apartment $model
     */
?>
<div class="row realty-data">
    <div class="col s12">
        <ul class="tabs">
            <li class="tab col s6"><a class="active" href="#characteristics">Характеристики</a></li>
            <li class="tab col s6"><a class="active" href="#house">Дом</a></li>
        </ul>
    </div>
    <div class="col s12" id="characteristics">
        <table class="striped">
            <tr>
                <td>Количество комнат</td>
                <td><?= $model->room_count ?></td>
            </tr>
            <tr>
                <td>Этаж</td>
                <td><?= $model->floor ?></td>
            </tr>
            <tr>
                <td>Площадь</td>
                <td><?= $model->area ?> м2</td>
            </tr>
            <tr>
                <td>Площаль комнат</td>
                <td><?= $model->rooms_area ?></td>
            </tr>
            <tr>
                <td>Площадь кухни</td>
                <td><?= $model->kitchen_area ?> м2</td>
            </tr>
            <tr>
                <td>Балкон</td>
                <td><?= $model->balcony ?></td>
            </tr>
            <tr>
                <td>Тип санузла</td>
                <td><?= $model->bathroom_type ?></td>
            </tr>
        </table>
    </div>
    <div class="col s12" id="house">
        <table class="striped">
            <tr>
                <td>Год постройки дома</td>
                <td><?= $model->house_year ?></td>
            </tr>
            <tr>
                <td>Материал дома</td>
                <td><?= $model->house_material ?></td>
            </tr>
            <tr>
                <td>Этажность дома</td>
                <td><?= $model->house_floor_count ?></td>
            </tr>
        </table>
    </div>
</div>