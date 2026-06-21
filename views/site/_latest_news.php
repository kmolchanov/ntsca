<?php

/** @var yii\web\View $this */
/** @var app\models\News[] $models */

use yii\helpers\Html;
use yii\helpers\Url;

$lang = Yii::$app->params['lang'] ?? Yii::$app->params['defaultLanguage'] ?? 'ru';
$defaultLang = Yii::$app->params['defaultLanguage'] ?? 'ru';
$languages = Yii::$app->params['languages'] ?? [];
$defaultLanguage = $languages[$defaultLang] ?? [];
$language = $languages[$lang] ?? $defaultLanguage;
$newsLabels = array_merge($defaultLanguage['news'] ?? [], $language['news'] ?? []);

?>

<section class="latest-news-section">
    <div class="d-flex align-items-end justify-content-between gap-3 mb-4">
        <h2 class="mb-0"><?= Html::encode($newsLabels['latestTitle'] ?? '') ?></h2>

        <?= Html::a($newsLabels['allNews'] ?? '', ['/news/index', 'lang' => $lang], [
            'class' => 'news-card-link latest-news-all-link',
        ]) ?>
    </div>

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

                    <?= $this->render('//news/_card', [
                        'model' => $model,
                        'lang' => $lang,
                        'readMoreLabel' => $newsLabels['readMore'] ?? '',
                    ]) ?>
                </article>
            </div>
        <?php endforeach; ?>
    </div>
</section>
