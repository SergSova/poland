<?php

    use common\models\District;
    use common\models\RealtyType;
    use common\models\ServiceType;
    use yii\helpers\ArrayHelper;
    use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\Search */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Realties';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="realty-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php  //echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Добавить Дом', ['create', 'realtyType'=>'house'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Добавить Квартиру', ['create', 'realtyType'=>'apartment'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php Pjax::begin(); ?>
    <?= GridView::widget([
                             'dataProvider' => $dataProvider,
                             'filterModel' => $searchModel,
                             'tableOptions' => [
                                 'class' => 'table table-striped table-bordered table-hover'
                             ],
                             'layout' => '{errors}<div class="table-responsive">{items}</div>{summary}{pager}',
                             'columns' => [
                                 [
                                     'attribute' => 'id',
                                     'headerOptions' => ['style' => 'width:90px;', 'class'=>'text-center'],
                                     'contentOptions' => ['class'=>'text-center']
                                 ],
                                 [
                                     'class' => 'yii\grid\ActionColumn',
                                     'headerOptions' => ['style' => 'width:50px;', 'class'=>'text-center'],
                                 ],
                                 [
                                     'attribute' => 'realtyType.name',
                                     'filter' => ArrayHelper::map(RealtyType::find()->all(), 'name', 'name'),
                                     'filterInputOptions' => ['prompt' => 'Все типы', 'class'=>'form-control'],
                                     'headerOptions' => ['style' => 'width:150px;', 'class'=>'text-center'],
                                     'contentOptions' => ['class'=>'text-center'],
                                 ],
                                 [
                                     'attribute' => 'serviceType.name',
                                     'filter' => ArrayHelper::map(ServiceType::find()->all(), 'name', 'name'),
                                     'filterInputOptions' => [ 'prompt' => 'Все', 'class' => 'form-control'],
                                     'headerOptions' => ['style' => 'width:150px;', 'class'=>'text-center'],
                                     'contentOptions' => ['class'=>'text-center'],
                                 ],
                                 [
                                     'attribute' => 'district.name',
                                     'headerOptions' => ['style' => 'width:200px;', 'class'=>'text-center'],
                                     'filter' => ArrayHelper::map(District::find()->all(), 'name', 'name'),
                                     'filterInputOptions' => ['prompt' => 'Все', 'class'=>'form-control'],
                                 ],
                                 [
                                     'attribute' => 'address',
                                     'filterInputOptions' => ['placeholder'=>'Введите адрес', 'class'=>'form-control']
                                 ],
                                 [
                                     'attribute' => 'price',
                                     'headerOptions' => ['style' => 'width:50px;', 'class'=>'text-center'],
                                     'contentOptions' => ['class'=>'text-center'],
                                     'filter' => false
                                 ],
                                 [
                                     'attribute' => 'status',
                                     'filter' => [
                                         'active' => 'Активно',
                                         'inactive' => 'Неактивно',
                                         'sale' => 'Продано',
                                         'deposit' => 'Под залогом',
                                     ],
                                     'filterInputOptions' => ['prompt'=> 'Все', 'class'=>'form-control'],
                                     'headerOptions' => ['class' => 'text-center', 'style' => 'width: 120px;'],
                                     'contentOptions' => ['class'=>'text-center']
                                 ]

                             ],
                         ]); ?>
    <?php Pjax::end(); ?></div>
