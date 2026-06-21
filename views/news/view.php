<?php

/** @var yii\web\View $this */
/** @var app\models\News $model */

use yii\helpers\Html;

$lang = Yii::$app->params['lang'] ?? Yii::$app->params['defaultLanguage'] ?? 'ru';
$newsTitle = Yii::$app->params['languages'][$lang]['menu']['news'] ?? 'Новости';

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => $newsTitle, 'url' => ['/news/index', 'lang' => $lang]];
$this->params['breadcrumbs'][] = $this->title;
?>

<article class="news-view">
    <div class="container">
        <header class="news-view-header mb-4">
            <h1 class="mb-2"><?= Html::encode($this->title) ?></h1>

            <time class="news-view-date" datetime="<?= Html::encode($model->date) ?>">
                <?= Yii::$app->formatter->asDate($model->date, 'long') ?>
            </time>
        </header>

        <?php if ($model->topVideo): ?>
            <?= $this->render('//site/_video', ['model' => $model->topVideo]) ?>
        <?php endif; ?>

        <?php if ($model->topGallery): ?>
            <?= $this->render('//site/_gallery', ['model' => $model->topGallery]) ?>
        <?php endif; ?>

        <div class="page-content news-view-content">
            <?= $model->content ?>
        </div>

        <?php if ($model->bottomVideo): ?>
            <?= $this->render('//site/_video', ['model' => $model->bottomVideo]) ?>
        <?php endif; ?>

        <?php if ($model->bottomGallery): ?>
            <?= $this->render('//site/_gallery', ['model' => $model->bottomGallery]) ?>
        <?php endif; ?>
    </div>
</article>
