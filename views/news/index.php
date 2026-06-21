<?php

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap5\LinkPager;

$lang = Yii::$app->params['lang'] ?? Yii::$app->params['defaultLanguage'] ?? 'ru';
$defaultLang = Yii::$app->params['defaultLanguage'] ?? 'ru';
$languages = Yii::$app->params['languages'] ?? [];
$defaultLanguage = $languages[$defaultLang] ?? [];
$language = $languages[$lang] ?? $defaultLanguage;
$menu = array_merge($defaultLanguage['menu'] ?? [], $language['menu'] ?? []);
$labels = array_merge($defaultLanguage['news'] ?? [], $language['news'] ?? []);
$newsTitle = $menu['news'] ?? '';

$this->title = $newsTitle;
$this->params['breadcrumbs'][] = $this->title;
?>

<section class="news-index">
    <div class="d-flex align-items-end justify-content-between gap-3 mb-4">
        <div>
            <h1 class="mb-2"><?= Html::encode($this->title) ?></h1>
            <?php if (!empty($labels['intro'])): ?>
                <p class="text-body-secondary mb-0"><?= Html::encode($labels['intro']) ?></p>
            <?php endif; ?>
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

                        <?= $this->render('_card', [
                            'model' => $model,
                            'lang' => $lang,
                            'readMoreLabel' => $labels['readMore'] ?? '',
                        ]) ?>
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
            <?= Html::encode($labels['empty'] ?? '') ?>
        </div>
    <?php endif; ?>
</section>
