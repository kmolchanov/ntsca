<?php

/** @var yii\web\View $this */
/** @var app\models\News $model */

use yii\helpers\Html;
use yii\helpers\StringHelper;

$lang = Yii::$app->params['lang'] ?? Yii::$app->params['defaultLanguage'] ?? 'ru';
$defaultLang = Yii::$app->params['defaultLanguage'] ?? 'ru';
$languages = Yii::$app->params['languages'] ?? [];
$defaultLanguage = $languages[$defaultLang] ?? [];
$language = $languages[$lang] ?? $defaultLanguage;
$menu = array_merge($defaultLanguage['menu'] ?? [], $language['menu'] ?? []);
$newsTitle = $menu['news'] ?? '';

$this->title = $model->title;
$this->params['meta_description'] = StringHelper::truncate(
    preg_replace('/\s+/', ' ', trim(html_entity_decode(strip_tags((string)($model->description ?: $model->content)), ENT_QUOTES | ENT_HTML5, Yii::$app->charset))),
    160,
    ''
);
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
