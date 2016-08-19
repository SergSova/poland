<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\VideoReview */

$this->title = 'Create Video Review';
$this->params['breadcrumbs'][] = ['label' => 'Video Reviews', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="video-review-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
