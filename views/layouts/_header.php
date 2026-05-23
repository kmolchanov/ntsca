<?php

declare(strict_types=1);

/** @var yii\web\View $this */

use kartik\bs5dropdown\Dropdown;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;
use yii\helpers\Html;
use yii\helpers\Url;

$currentLang = Yii::$app->params['lang'] ?? Yii::$app->params['defaultLanguage'] ?? 'ru';
$languages = Yii::$app->params['languages'] ?? [];
$current = $languages[$currentLang] ?? reset($languages);
$route = Yii::$app->controller->route;
$params = Yii::$app->request->get();

$items = [
    [
        'label' => 'Home',
        'url' => ['/site/index'],
    ],
    [
        'label' => 'About',
        'url' => ['/site/about'],
    ],
    [
        'label' => 'Contact',
        'url' => ['/site/contact'],
        'items' => [
            [
                'label' => 'About',
                'url' => ['/site/about'],
                'items' => [
                    [
                        'label' => 'About',
                        'url' => ['/site/about'],
                        'items' => [
                            [
                                'label' => 'About',
                                'url' => ['/site/about'],
                                'items' => [
                                    [
                                        'label' => 'About',
                                        'url' => ['/site/about'],
                                    ],
                                ]
                            ],
                        ]
                    ],
                    [
                        'label' => 'About',
                        'url' => ['/site/about'],
                        'items' => [
                            [
                                'label' => 'About',
                                'url' => ['/site/about'],
                            ],
                        ]
                    ],
                ]
            ],
        ]
    ],
    [
        'label' => 'Login',
        'url' => ['/site/login'],
        'visible' => Yii::$app->user->isGuest,
    ],
    [
        'label' => 'Logout (' . Html::encode(Yii::$app->user->identity?->username ?? '') . ')',
        'url' => ['/site/logout'],
        'linkOptions' => [
            'data-method' => 'post',
            'class' => 'nav-link logout',
        ],
        'visible' => !Yii::$app->user->isGuest,
    ],
];

?>
<header id="header">
    <?php NavBar::begin([
        'brandLabel' => Html::img('/images/logo.png', [
                'alt' => '',
                'class' => 'header-logo'
            ]),
        'brandUrl' => ['/site/index', 'lang' => Yii::$app->params['lang'] ?? 'ru'],
        'options' => ['class' => 'navbar navbar-expand-md navbar-dark bg-dark fixed-top'],
    ]) ?>
    <?= Nav::widget(
        [
            'options' => ['class' => 'navbar-nav me-auto'],
            'encodeLabels' => false,
            'dropdownClass' => Dropdown::class,
            'items' => $items,
            'activateParents' => false,
        ],
    ) ?>
    <?php if ($current && $languages): ?>
        <div class="dropdown">
            <a class="nav-link dropdown-toggle d-flex align-items-center gap-2"
               href="#"
               id="languageDropdown"
               role="button"
               data-bs-toggle="dropdown"
               aria-expanded="false">
                <span class="fi fi-<?= Html::encode($current['flag']) ?>"></span>
                <span><?= Html::encode($current['label']) ?></span>
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
    <?php Html::button(
        '&#127769;',
        [
            'id' => 'theme-toggle',
            'class' => 'btn btn-link nav-link fs-5',
            'aria-label' => 'Switch to dark mode',
        ],
    ) ?>
    <?php NavBar::end() ?>
</header>
