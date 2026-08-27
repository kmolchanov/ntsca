<?php

declare(strict_types=1);

/** @var yii\web\View $this */
/** @var string $content */

use app\widgets\Alert;
use yii\bootstrap5\Breadcrumbs;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\helpers\Url;

$this->render('_head');

$siteName = trim((string)(Yii::$app->params['appName'] ?? Yii::$app->name));
$pageTitle = trim((string)$this->title);
$documentTitle = $pageTitle;

if ($siteName !== '' && $pageTitle !== '' && $pageTitle !== $siteName) {
    $documentTitle = $pageTitle . ' | ' . $siteName;
} elseif ($documentTitle === '') {
    $documentTitle = $siteName;
}

$websiteStructuredData = [
    '@context' => 'https://schema.org',
    '@type' => 'WebSite',
    'name' => $siteName !== '' ? $siteName : 'NTSCA',
    'alternateName' => 'NTSCA',
    'url' => Url::home(true),
];
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100" data-bs-theme="light">
<head>
    <?php $this->head() ?>
    <?= $this->render('_yandex_metrika_head') ?>
    <title><?= Html::encode($documentTitle) ?></title>
    <script type="application/ld+json"><?= Json::htmlEncode($websiteStructuredData) ?></script>
</head>
<body class="d-flex flex-column h-100">
<?php $this->beginBody() ?>

<?= $this->render('_header') ?>

<div class="site-bauhaus-frame" aria-hidden="true">
    <span class="site-bauhaus-shape site-bauhaus-shape-left site-bauhaus-semicircle-blue"></span>
    <span class="site-bauhaus-shape site-bauhaus-shape-left site-bauhaus-dot-grid"></span>
    <span class="site-bauhaus-shape site-bauhaus-shape-left site-bauhaus-square-yellow"></span>
    <span class="site-bauhaus-shape site-bauhaus-shape-left site-bauhaus-slash-purple"></span>
    <span class="site-bauhaus-shape site-bauhaus-shape-right site-bauhaus-semicircle-purple"></span>
    <span class="site-bauhaus-shape site-bauhaus-shape-right site-bauhaus-circle-olive"></span>
    <span class="site-bauhaus-shape site-bauhaus-shape-right site-bauhaus-square-blue"></span>
    <span class="site-bauhaus-shape site-bauhaus-shape-right site-bauhaus-stripes-yellow"></span>
</div>

<main id="main" class="flex-grow-1" role="main">
    <?php $hasBreadcrumbs = !empty($this->params['breadcrumbs']); ?>
    <div class="container<?= $hasBreadcrumbs ? ' has-breadcrumbs' : '' ?>">
        <?php if ($hasBreadcrumbs): ?>
            <?= Breadcrumbs::widget(['links' => $this->params['breadcrumbs']]) ?>
        <?php endif ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</main>

<?= $this->render('_footer') ?>

<?= $this->render('_floating_contacts') ?>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
