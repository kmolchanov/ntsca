<?php

/** @var yii\web\View $this */
/** @var app\models\Page $model */
/** @var app\models\News[] $latestNews */

use yii\helpers\Html;
use yii\helpers\StringHelper;

$this->title = $model->title;
$this->params['breadcrumbs'] = $model->breadcrumbs;
$this->params['meta_description'] = StringHelper::truncate(
    preg_replace('/\s+/', ' ', trim(html_entity_decode(strip_tags((string)$model->content), ENT_QUOTES | ENT_HTML5, Yii::$app->charset))),
    160,
    ''
);
$siteIndexClass = $model->is_main ? 'site-index site-index-main' : 'site-index';
$subpages = (int)$model->show_subpages === $model::IS_YES ? $model->subpages : [];
?>

<div class="<?= Html::encode($siteIndexClass) ?>">

    <div class="container">

        <?php if (!$model->is_main): ?>
            <h1 class="mb-4">
                <?= Html::encode($model->title) ?>
            </h1>
        <?php endif; ?>

        <?php if ($subpages): ?>
            <?= $this->render('_subpages', ['pages' => $subpages]) ?>
        <?php endif; ?>

        <?php if ($model->topVideo): ?>
            <?= $this->render('_video', ['model' => $model->topVideo]) ?>
        <?php endif; ?>

        <?php if ($model->topGallery): ?>
            <?= $this->render('_gallery', ['model' => $model->topGallery]) ?>
        <?php endif; ?>

        <div class="page-content">
            <?= $model->content ?>
        </div>

        <?php if ($model->bottomVideo): ?>
            <?= $this->render('_video', ['model' => $model->bottomVideo]) ?>
        <?php endif; ?>

        <?php if ($model->bottomGallery): ?>
            <?= $this->render('_gallery', ['model' => $model->bottomGallery]) ?>
        <?php endif; ?>

        <?php if ($model->is_main && $latestNews): ?>
            <?= $this->render('_latest_news', ['models' => $latestNews]) ?>
        <?php endif; ?>

    </div>

</div>
