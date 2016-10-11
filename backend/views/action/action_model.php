<?php
    /**
     * @var $this         \yii\web\View
     * @var $dataProvider \yii\data\ActiveDataProvider
     * @var $action       \common\models\Action
     */
    use yii\bootstrap\Html;
    use yii\grid\GridView;
    use yii\grid\SerialColumn;

    $columns = [
        ['class' => SerialColumn::className()],
        'model.address',
    ];

    if($action->name == 'discount'){
        $columns = array_merge($columns, [
            'model.newPrice:text:Новая цена',
            'model.price'
        ]);
    }
    $columns = array_merge($columns, [
        [
            'content' => function($data){
                return Html::a('Удалить', [
                    'remove-model',
                    'action_model_id' => $data->id,
                ]);
            }
        ]
    ]);
?>

<div class="container">
    <h1><?= $action->title ?></h1>
    <?= Html::a('Изменить '.$action->title, [
        'update',
        'id' => $action->id
    ], ['class' => 'btn btn-primary']) ?>
    <?= GridView::widget([
                             'dataProvider' => $dataProvider,
                             'columns' => $columns
                         ]) ?>
</div>
