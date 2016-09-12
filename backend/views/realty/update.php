<?php

    use yii\helpers\Html;

    /* @var $this yii\web\View */
    /* @var $model backend\components\RealtyModel */
    /* @var $realtyType string */

    $this->title = 'Update Realty: '.$model->baseModel->id;
    $this->params['breadcrumbs'][] = [
        'label' => 'Realties',
        'url' => ['index']
    ];
    $this->params['breadcrumbs'][] = [
        'label' => $model->baseModel->id,
        'url' => [
            'view',
            'id' => $model->baseModel->id
        ]
    ];
    $this->params['breadcrumbs'][] = 'Update';
?>
<div class="realty-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('includes/_form', [
        'model' => $model,
        'realtyType' => $realtyType
    ]) ?>

</div>
