<?php

/** @var yii\web\View $this */
/** @var app\models\News $model */
/** @var string $lang */
/** @var string $readMoreLabel */

use yii\helpers\Html;

?>

<div class="news-card-body">
    <time class="news-card-date" datetime="<?= Html::encode($model->date) ?>">
        <?= Yii::$app->formatter->asDate($model->date, 'long') ?>
    </time>

    <h2 class="news-card-title">
        <?= Html::a(Html::encode($model->title), ['/news/view', 'lang' => $lang, 'slug' => $model->slug]) ?>
    </h2>

    <?php if ($model->description): ?>
        <p class="news-card-description">
            <?= Html::encode($model->description) ?>
        </p>
    <?php endif; ?>

    <?= Html::a($readMoreLabel, ['/news/view', 'lang' => $lang, 'slug' => $model->slug], [
        'class' => 'news-card-link',
    ]) ?>
</div>
