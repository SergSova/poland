<?php

    use yii\helpers\Html;

    /* @var $this yii\web\View */
    /* @var $model backend\components\RealtyModel */
    /* @var $realtyType string */

    $this->title = 'Создание Объекта Недвижимости';
    $this->params['breadcrumbs'][] = [
        'label' => 'Каталог',
        'url' => ['index']
    ];
    $this->params['breadcrumbs'][] = $this->title;
?>
<div class="realty-create">

    <h1><?= Html::encode($this->title) ?></h1>
    <div class="row">
    <?= $this->render('includes/_form', [
        'model' => $model,
        'realtyType' => $realtyType
    ]) ?>
    </div>

</div>
