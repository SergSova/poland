<?php
    use yii\helpers\Url;

    $realtyType = $model->realtyType->realty_table;
?>

<div class="card info-window">
    <div class="card-image left">
        <img class="responsive-img" src="<?= Yii::getAlias('@storageUrl').'/'.$model->$realtyType->cover?>">
    </div>
    <div class="card-content left">
        <div class="info center">
            <p class="price"><?= $model->price?> руб</p>
            <p class="subtitle"><?= $model->address?></p>
        </div>
        <p class="description"><?= $model->description?></p>
    </div>
    <a href="<?= Url::to(['site/realty', 'id'=> $model->id])?>" class="btn mypallete fullWidth waves-effect waves-light">Подробнее</a>
</div>
