<?php
    /**
     * @var                              $this \yii\web\View
     * @var \yii\data\ActiveDataProvider $dataProvider
     */
    use yii\bootstrap\Html;
    use yii\grid\GridView;

?>
<div class="service-index">
    <?= Html::a('Создать Услугу', ['service/create'], ['class' => 'btn btn-primary']) ?>
    <?= GridView::widget([
                             'dataProvider' => $dataProvider,
                             'columns' => [
                                 ['class' => 'yii\grid\SerialColumn'],
                                 'title',
                                 'imgPath:image',
                                 ['class' => 'yii\grid\ActionColumn'],
                             ]
                         ]) ?>
</div>
