<?php

declare(strict_types=1);

/** @var yii\web\View $this */

use yii\helpers\Html;

$lang = Yii::$app->params['lang'] ?? Yii::$app->params['defaultLanguage'];
$language = Yii::$app->params['languages'][$lang] ?? [];

?>
<footer id="footer" class="mt-auto py-4 bg-body-tertiary border-top">
    <div class="container">

        <div class="text-center text-body-secondary small">

            <div class="fw-semibold mb-2">
                &copy; <?= Html::encode($language['appName'] ?? Yii::$app->name) ?> <?= date('Y') ?>
            </div>

            <?php if (!empty($language['license'])): ?>
                <div style="max-width: 900px; margin: 0 auto;">
                    <?= Html::encode($language['license']) ?>
                </div>
            <?php endif; ?>

        </div>

    </div>
</footer>