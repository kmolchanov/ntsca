<?php

use app\assets\FancyboxAsset;
use app\assets\SwiperAsset;
use yii\helpers\Html;

/** @var app\models\Gallery $model */

FancyboxAsset::register($this);
SwiperAsset::register($this);

$this->registerJs("
    Fancybox.bind('[data-fancybox]', {});
");

$this->registerJs("
    Fancybox.bind('[data-fancybox]', {});
    new Swiper('.gallery-swiper-{$model->id}', {
        slidesPerView: 1.2,
        spaceBetween: 16,
        navigation: {
            nextEl: '.gallery-swiper-next-{$model->id}',
            prevEl: '.gallery-swiper-prev-{$model->id}',
        },
        breakpoints: {
            576: { slidesPerView: 2.2 },
            768: { slidesPerView: 3 },
            1200: { slidesPerView: 4 }
        }
    });
");
?>

<div class="page-gallery my-5">
    <div class="position-relative">
        <div class="swiper gallery-swiper-<?= $model->id ?>">
            <div class="swiper-wrapper">
                <?php foreach ($model->items as $item): ?>
                    <div class="swiper-slide">
                        <a href="<?= $item->picture ?>"
                           data-fancybox="gallery-<?= $model->id ?>">
                            <?= Html::img($item->thumbnailPicture, [
                                'class' => 'img-fluid rounded shadow-sm w-100',
                                'style' => 'height: 190px; object-fit: cover;',
                            ]) ?>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <button class="gallery-swiper-button gallery-swiper-prev gallery-swiper-prev-<?= $model->id ?> position-absolute top-50 translate-middle-y">
            &#10094;
        </button>
        <button class="gallery-swiper-button gallery-swiper-next gallery-swiper-next-<?= $model->id ?> position-absolute top-50 translate-middle-y">
            &#10095;
        </button>
    </div>
</div>
