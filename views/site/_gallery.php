<?php

use app\assets\FancyboxAsset;
use yii\helpers\Html;

/** @var app\models\Gallery $model */

FancyboxAsset::register($this);

$this->registerJs("
    Fancybox.bind('[data-fancybox]', {});
");
?>

<div class="page-gallery my-5">

    <?php if ($model->title): ?>
        <h2 class="text-center mb-4">
            <?= Html::encode($model->title) ?>
        </h2>
    <?php endif; ?>

    <div class="gallery-scroll d-flex gap-3 justify-content-center overflow-auto pb-3">
        <?php foreach ($model->items as $item): ?>
            <a
                href="<?= $item->picture ?>"
                data-fancybox="gallery-<?= $model->id ?>"
                data-caption="<?= Html::encode($item->title) ?>"
                class="gallery-item flex-shrink-0"
            >
                <?= Html::img($item->thumbnailPicture, [
                    'class' => 'img-fluid rounded shadow-sm',
                    'alt' => $item->title,
                    'style' => 'height: 180px; object-fit: cover;',
                ]) ?>
            </a>
        <?php endforeach; ?>
    </div>

</div>
