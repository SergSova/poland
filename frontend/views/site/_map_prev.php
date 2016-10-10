<?php
    use yii\helpers\Url;

    /**
     * @var \common\models\Realty $model
     */
    $realtyType_id = $model->realty_type_id;
    $realtyType = \common\models\Realty::getDb()
                                       ->cache(function() use ($realtyType_id){
                                           return \common\models\RealtyType::findOne($realtyType_id)->realty_table;
                                       }, 3600);
?>

<div class="card info-window">
    <div class="card-image left">
        <img class="responsive-img" src="<?= Yii::getAlias('@storageUrl').'/'.$model->$realtyType->cover ?>">
    </div>
    <div class="card-content left">
        <div class="info center">
            <p class="price"><?= $model->price ?> руб</p>
            <p class="subtitle"><?= $model->address ?></p>
        </div>
        <div class="description"><p><?= $model->br_short_description ?></p></div>
    </div>
    <a href="<?= Url::to([
                             'site/realty',
                             'id' => $model->id
                         ]) ?>" class="btn mypallete fullWidth waves-effect waves-light">Подробнее</a>
</div>
