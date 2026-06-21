<?php

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap5\LinkPager;

$lang = Yii::$app->params['lang'] ?? Yii::$app->params['defaultLanguage'] ?? 'ru';
$newsTitle = Yii::$app->params['languages'][$lang]['menu']['news'] ?? 'Новости';
$labels = [
    'ru' => [
        'intro' => 'Последние новости и события школы.',
        'readMore' => 'Читать далее',
        'empty' => 'Новости пока не опубликованы.',
    ],
    'en' => [
        'intro' => 'Latest school news and events.',
        'readMore' => 'Read more',
        'empty' => 'No news has been published yet.',
    ],
    'ky' => [
        'intro' => 'Мектептин акыркы жаңылыктары жана окуялары.',
        'readMore' => 'Кененирээк окуу',
        'empty' => 'Азырынча жаңылыктар жарыялана элек.',
    ],
][$lang] ?? [
    'intro' => 'Последние новости и события школы.',
    'readMore' => 'Читать далее',
    'empty' => 'Новости пока не опубликованы.',
];

$this->title = $newsTitle;
$this->params['breadcrumbs'][] = $this->title;
?>

<section class="news-index">
    <div class="d-flex align-items-end justify-content-between gap-3 mb-4">
        <div>
            <h1 class="mb-2"><?= Html::encode($this->title) ?></h1>
            <p class="text-body-secondary mb-0"><?= Html::encode($labels['intro']) ?></p>
        </div>
    </div>

    <?php $models = $dataProvider->getModels(); ?>

    <?php if ($models): ?>
        <div class="row g-4">
            <?php foreach ($models as $model): ?>
                <div class="col-md-6 col-xl-4">
                    <article class="news-card h-100">
                        <a class="news-card-image-link" href="<?= Url::to(['/news/view', 'lang' => $lang, 'slug' => $model->slug]) ?>">
                            <?= Html::img($model->thumbnailPicture, [
                                'class' => 'news-card-image',
                                'alt' => $model->title,
                            ]) ?>
                        </a>

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

                            <?= Html::a($labels['readMore'], ['/news/view', 'lang' => $lang, 'slug' => $model->slug], [
                                'class' => 'news-card-link',
                            ]) ?>
                        </div>
                    </article>
                </div>
            <?php endforeach; ?>
        </div>

        <?= LinkPager::widget([
            'pagination' => $dataProvider->pagination,
            'options' => ['class' => 'pagination justify-content-center mt-5'],
        ]) ?>
    <?php else: ?>
        <div class="alert alert-info mb-0">
            <?= Html::encode($labels['empty']) ?>
        </div>
    <?php endif; ?>
</section>
