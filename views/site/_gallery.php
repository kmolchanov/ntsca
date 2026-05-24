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

    <div class="gallery-scroll d-flex gap-3 justify-content-center overflow-auto pb-3">
        <?php foreach ($model->items as $item): ?>
            <a
                href="<?= $item->picture ?>"
                data-fancybox="gallery-<?= $model->id ?>"
                class="gallery-item flex-shrink-0"
            >
                <?= Html::img($item->thumbnailPicture, [
                    'class' => 'img-fluid rounded shadow-sm',
                    'style' => 'height: 180px; object-fit: cover;',
                ]) ?>
            </a>
        <?php endforeach; ?>
    </div>

</div>
