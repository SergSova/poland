<?php
    /**
     * @var $this yii\web\View
     * @var $user common\models\User
     */

    use yii\bootstrap\Html;

    $confirmLink = Yii::$app->urlManager->createAbsoluteUrl(['site/confirm-registration', 'token' => $user->password_reset_token]);
?>
<div class="password-reset">
    <p>Hello <?= Html::encode($user->username) ?>,</p>

    <p>Follow the link below to confirm your account in <?= Yii::$app->name ?></p>

    <p><?= Html::a(Html::encode($confirmLink), $confirmLink) ?></p>
</div>