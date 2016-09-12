<?php

    use backend\widgets\MapWidget\SimpleMapWidget;
    use yii\helpers\Html;
    use yii\widgets\DetailView;

    /* @var $this yii\web\View */
    /* @var $model backend\components\RealtyModel */

    $this->title = $model->baseModel->id;
    $this->params['breadcrumbs'][] = [
        'label' => 'Realties',
        'url' => ['index']
    ];
    $this->params['breadcrumbs'][] = $this->title;

    $coord = explode(';', $model->baseModel->map_coord);
    $centerMap = ['lat'=>$coord[0]*1, 'lng'=> $coord[1]*1];
    $zoom = 16;
?>
<div class="realty-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', [
            'update',
            'id' => $model->baseModel->id
        ], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', [
            'delete',
            'id' => $model->baseModel->id
        ], [
                        'class' => 'btn btn-danger',
                        'data' => [
                            'confirm' => 'Are you sure you want to delete this item?',
                            'method' => 'post',
                        ],
                    ]) ?>
    </p>
    <div class="row">
        <div class="col-lg-6">
            <div class="panel panel-default">
                <div class="panel-heading">Основная информция</div>
                <div class="panel-body">
                    <p>Тип недвижимости: <strong><?= $model->baseModel->realtyType->name ?></strong></p>
                    <p>Тип Услуги: <strong><?= $model->baseModel->serviceType->name ?></strong></p>
                    <p>Направление/район: <strong><?= $model->baseModel->district->name ?></strong></p>
                    <p>Адрес: <strong><?= $model->baseModel->address ?></strong></p>
                    <p>Цена: <strong><?= $model->baseModel->price ?></strong></p>
                    <p>Краткое описание: <strong><?= $model->baseModel->short_description ?></strong></p>
                    <p>Полное описание: <strong><?= $model->baseModel->full_description ?></strong></p>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">Местоположение</div>
                <div class="panel-body" style="height: 300px;">
                    <?= SimpleMapWidget::widget([
                                                                               'mapSetting' => [
                                                                                   'center' => $centerMap,
                                                                                   'zoom' => $zoom,
                                                                                   'draggable' => false
                                                                               ]

                                                                           ]) ?>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <?= $this->render('includes/_view'.ucfirst($model->baseModel->realtyType->realty_table), ['model'=>$model->entityModel])?>
        </div>
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">Фото</div>
                <div class="panel-body">
                    <?php
                        if(!empty($model->entityModel->photos)):
                            $photos = json_decode($model->entityModel->photos);
                            foreach($photos as $photo):
                                $photoName = substr($photo, strrpos($photo, '/') + 1);
                                $thumb = 'thumb_'.$photoName;
                                $directory = substr($photo, 0, strrpos($photo, '/'));
                                if($model->entityModel->cover == $photoName):
                                    ?>
                                    <img src="<?= Yii::getAlias('@storageUrl').'/'.$directory.'/'.$thumb ?>" class="isCover">
                                    <?php
                                else:
                                    ?>
                                    <img src="<?= Yii::getAlias('@storageUrl').'/'.$directory.'/'.$thumb ?>">
                                    <?php
                                endif;
                            endforeach;
                        else:?>
                            <div class="alert alert-info">Ни одного фото не загружено...</div>
                        <?php endif;
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
