<?php
    use yii\helpers\Html;

    /* @var $this yii\web\View */
    /* @var $user \backend\models\User */
    /** @var string $new_email */


    $resetLink = Yii::$app->urlManager->createAbsoluteUrl(['site/change-email-token', 'token' => $user->password_reset_token, 'email' =>$new_email]);
?>
<div class="password-reset">
    <p>Добрый день <b><?= Html::encode($user->username) ?></b>,</p>

    <p>Перейдите по ссылке для того что бы изменить вашу почту на <b style="color: #d0181e"><?=$new_email?></b>:</p>

    <p><?= Html::a(Html::encode($resetLink), $resetLink) ?></p>
</div>