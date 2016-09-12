<?php

    use yii\helpers\Html;
    use yii\widgets\DetailView;

    /* @var $this yii\web\View */
    /* @var $model \backend\models\User */

    $this->title = $model->username;
    $this->params['breadcrumbs'][] = ['label' => 'Профиль', 'url' => ['index']];
    $this->params['breadcrumbs'][] = $this->title;
?>
<div class="profile-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
                               'model'      => $model,
                               'attributes' => [
                                   'username:text:Login',
                                   'password:text:Password',
                                   'email:email:E-mail',
                                   'created_at:date:Дата создания',
                                   'updated_at:date:Дата обновления',
                               ],
                           ]) ?>
    <span>
        <a href="<?= Yii::$app->urlManager->createUrl(['/site/reset-password-current'])?>"
           class="btn btn-primary btn-lg active" role="button">Сбросить пароль</a>
        <a href="<?= Yii::$app->urlManager->createUrl(['/site/request-change-email'])?>"
           class="btn btn-primary btn-lg active" role="button">Изменить email</a>
    </span>

</div>
