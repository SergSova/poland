<?php

    /**
     * @var $this  yii\web\View
     */

    use common\models\Realty;
    use yii\grid\GridView;
    use yii\helpers\Html;
    use yii\helpers\Url;

    /** @var \yii\data\ActiveDataProvider $callbackProvider */
    /** @var \yii\data\ActiveDataProvider $feedbackProvider */
    $this->title = 'Dashboard';
?>

<div class="row">
    <div class="col-sm-12 col-md-4 col-lg-3">
        <div class="list-group">
            <a href="<?= Url::to([
                                     'realty/create',
                                     'realtyType' => 'house'
                                 ]) ?>" class="list-group-item">Добавить Дом</a>
            <a href="<?= Url::to([
                                     'realty/create',
                                     'realtyType' => 'apartment'
                                 ]) ?>" class="list-group-item">Добавить квартиру</a>
            <a href="<?= Url::to(['video-review/create']) ?>" class="list-group-item">Добавить видео Обзор</a>
        </div>
    </div>
    <div class="col-sm-12 col-md-4 col-lg-5">
        <p>Callback</p>
        <?= GridView::widget([
                                 'dataProvider' => $callbackProvider,
                                 'columns'      => [
                                     'name:text:Имя',
                                     [
                                         'attribute' => 'subject',
                                         'label'     => 'Тема',
                                         'content'   => function($model){
                                             $realty = Realty::findOne($model->subject);
                                             if(!$realty){
                                                 return $model->subject;
                                             }
                                             return Html::a($realty->address, ['/realty/view', 'id' => $realty->id]);
                                         }
                                     ],
                                     'phone:text:Телефон',
                                 ],
                             ]); ?>
    </div>
    <div class="col-sm-12 col-md-4 col-lg-4">
        <p>Feedback</p>
        <?=GridView::widget([
                                 'dataProvider' => $feedbackProvider,
                                 'columns'      => [
                                     'name:text:Имя',
                                     'email:text:Почта',
                                     [
                                         'attribute' => 'subject',
                                         'label'     => 'Тема',
                                         'content'   => function($model){
                                             $realty = Realty::findOne($model->subject);
                                             if(!$realty){
                                                 return $model->subject;
                                             }
                                             return Html::a($realty->address, ['/realty/view', 'id' => $realty->id]);
                                         }
                                     ],
                                     'body:text:Текст',
                                 ],
                             ]); ?>
    </div>

</div>

