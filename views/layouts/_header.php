<?php

declare(strict_types=1);

/** @var yii\web\View $this */

use app\models\Page;
use kartik\bs5dropdown\Dropdown;
use yii\bootstrap5\Nav;
use yii\helpers\Html;
use yii\helpers\Url;

$currentLang = Yii::$app->params['lang'] ?? Yii::$app->params['defaultLanguage'] ?? 'ru';
$languages = Yii::$app->params['languages'] ?? [];
$current = $languages[$currentLang] ?? reset($languages);
$route = Yii::$app->controller->route;
$params = Yii::$app->request->get();
$items = Page::getMenuItems();

?>
<header id="header">
    <nav class="site-navbar fixed-top" aria-label="Main navigation">
        <div class="container-fluid">
            <div class="site-navbar-inner">
                <?= Html::a(
                    Html::img('/images/logo.png', [
                        'alt' => Yii::$app->name,
                        'class' => 'header-logo',
                    ]),
                    ['/site/index', 'lang' => Yii::$app->params['lang'] ?? 'ru'],
                    ['class' => 'site-navbar-brand'],
                ) ?>

                <div class="collapse navbar-collapse site-navbar-collapse" id="siteNavbarMenu">
                    <?= Nav::widget(
                        [
                            'options' => ['class' => 'navbar-nav site-navbar-nav'],
                            'encodeLabels' => false,
                            'dropdownClass' => Dropdown::class,
                            'items' => $items,
                            'activateParents' => false,
                        ],
                    ) ?>

                    <?php if ($current && $languages): ?>
                        <div class="dropdown site-navbar-language">
                            <a class="site-navbar-language-toggle dropdown-toggle d-inline-flex align-items-center gap-2"
                               href="#"
                               id="languageDropdown"
                               role="button"
                               data-bs-toggle="dropdown"
                               aria-expanded="false">
                                <span class="fi fi-<?= Html::encode($current['flag']) ?>"></span>
                                <span><?= Html::encode(strtoupper($currentLang)) ?></span>
                            </a>

                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="languageDropdown">
                                <?php foreach ($languages as $code => $language): ?>
                                    <?php $params['lang'] = $code; ?>

                                    <li>
                                        <a class="dropdown-item d-flex align-items-center gap-2 <?= $code === $currentLang ? 'active' : '' ?>"
                                           href="<?= Url::to(array_merge([$route], $params)) ?>">
                                            <span class="fi fi-<?= Html::encode($language['flag']) ?>"></span>
                                            <span><?= Html::encode($language['label']) ?></span>
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="site-navbar-actions">
                    <button class="navbar-toggler site-navbar-toggler"
                            type="button"
                            data-bs-toggle="collapse"
                            data-bs-target="#siteNavbarMenu"
                            aria-controls="siteNavbarMenu"
                            aria-expanded="false"
                            aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                </div>
            </div>
        </div>
    </nav>
</header>
