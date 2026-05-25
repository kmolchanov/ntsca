<?php

declare(strict_types=1);

/** @var yii\web\View $this */

use app\models\Page;
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

$items = Page::getMenuItems();

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
