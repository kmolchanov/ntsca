<?php

/** @var yii\web\View $this */
/** @var app\models\Page[] $pages */

use yii\helpers\Html;
use yii\helpers\Url;

$lang = Yii::$app->params['lang'] ?? Yii::$app->params['defaultLanguage'] ?? 'ru';
$defaultLang = Yii::$app->params['defaultLanguage'] ?? 'ru';
$languages = Yii::$app->params['languages'] ?? [];
$defaultLanguage = $languages[$defaultLang] ?? [];
$language = $languages[$lang] ?? $defaultLanguage;
$pageLabels = array_merge($defaultLanguage['pages'] ?? [], $language['pages'] ?? []);

?>

<nav class="subpages-section mb-4" aria-label="<?= Html::encode($pageLabels['subpagesLabel'] ?? '') ?>">
    <div class="subpages-grid">
        <?php foreach ($pages as $page): ?>
            <a class="subpage-card" href="<?= Html::encode(Url::to($page->url)) ?>">
                <span class="subpage-card-title"><?= Html::encode($page->menuTitle) ?></span>
            </a>
        <?php endforeach; ?>
    </div>
</nav>
