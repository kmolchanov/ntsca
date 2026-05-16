<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\assets\SchoolTemplateAsset;
use yii\bootstrap\Html;

SchoolTemplateAsset::register($this);

$this->registerCsrfMetaTags();
$this->registerMetaTag(['charset' => Yii::$app->charset], 'charset');
$this->registerMetaTag(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1, shrink-to-fit=no']);
$this->registerMetaTag(['name' => 'description', 'content' => $this->params['meta_description'] ?? '']);
$this->registerMetaTag(['name' => 'keywords', 'content' => $this->params['meta_keywords'] ?? '']);
$this->registerLinkTag(['rel' => 'apple-touch-icon', 'sizes' => '180x180', 'href' => Yii::getAlias('@web/apple-touch-icon.png')]);
$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/png', 'sizes' => '32x32', 'href' => Yii::getAlias('@web/favicon-32x32.png')]);
$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/png', 'sizes' => '16x16', 'href' => Yii::getAlias('@web/favicon-16x16.png')]);
$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/png', 'href' => Yii::getAlias('@web/favicon.ico')]);
$this->registerLinkTag(['rel' => 'manifest', 'href' => Yii::getAlias('@web/site.webmanifest')]);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body data-spy="scroll" data-target=".site-navbar-target" data-offset="300">
<?php $this->beginBody() ?>
<div class="site-wrap">
    <div class="site-mobile-menu site-navbar-target">
        <div class="site-mobile-menu-header">
            <div class="site-mobile-menu-close mt-3">
                <span class="icon-close2 js-menu-toggle"></span>
            </div>
        </div>
        <div class="site-mobile-menu-body"></div>
    </div>
    <header class="site-navbar py-4 js-sticky-header site-navbar-target" role="banner">
        <div class="container-fluid">
            <div class="d-flex align-items-center">
                <div class="site-logo mr-auto w-25">
                    <?= Html::a(Html::img(Yii::getAlias('@web/images/logo.png'), ['style' => 'width: 300px;']), Yii::$app->homeUrl) ?>
                </div>

                <div class="mx-auto text-center">
                    <nav class="site-navigation position-relative text-right" role="navigation">
                        <ul class="site-menu main-menu js-clone-nav mx-auto d-none d-lg-block  m-0 p-0">
                            <li><a href="#home-section" class="nav-link">Home</a></li>
                            <li><a href="#courses-section" class="nav-link">Courses</a></li>
                            <li><a href="#programs-section" class="nav-link">Programs</a></li>
                            <li><a href="#teachers-section" class="nav-link">Teachers</a></li>
                        </ul>
                    </nav>
                </div>

                <div class="ml-auto w-25">
                    <nav class="site-navigation position-relative text-right" role="navigation">
                        <ul class="site-menu main-menu site-menu-dark js-clone-nav mr-auto d-none d-lg-block m-0 p-0">
                            <li class="cta"><a href="#contact-section" class="nav-link"><span>Contact Us</span></a></li>
                        </ul>
                    </nav>
                    <a href="#" class="d-inline-block d-lg-none site-menu-toggle js-menu-toggle text-black float-right"><span class="icon-menu h3"></span></a>
                </div>
            </div>
        </div>
    </header>
    <main class="site-main">
        <?= $content ?>
    </main>
</div>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
