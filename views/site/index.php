<?php

/** @var yii\web\View $this */
/** @var app\models\Page $model */

use yii\helpers\Html;

$this->title = $model->title;
$this->params['breadcrumbs'] = $model->breadcrumbs;
$siteIndexClass = $model->is_main ? 'site-index site-index-main' : 'site-index';
?>

<div class="<?= Html::encode($siteIndexClass) ?>">

    <div class="container">

        <?php if (!$model->is_main): ?>
            <h1 class="mb-4">
                <?= Html::encode($model->title) ?>
            </h1>
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

    </div>

</div>
