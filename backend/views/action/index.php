<?php
    /**
     * @var $this         \yii\web\View
     * @var $dataProvider \yii\data\ActiveDataProvider
     */
    use yii\bootstrap\Html;
    use yii\grid\GridView;

?>

<?= Html::a('Создать акцию', ['create'], ['class' => 'btn btn-primary']) ?>
<?= GridView::widget([
                         'dataProvider' => $dataProvider,
                         'columns' => [
                             'id',
                             'title',
                             'name',
                             'description',
                             'imgPath:image',
                             'date_start:date',
                             'date_end:date',
                             'value',
                             'status',
                             ['class' => \yii\grid\ActionColumn::className()]
                         ]
                     ]) ?>
