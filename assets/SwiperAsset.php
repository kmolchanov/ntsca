<?php

namespace app\assets;

use yii\web\AssetBundle;

class SwiperAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $css = [
        'swiper/swiper-bundle.min.css',
    ];

    public $js = [
        'swiper/swiper-bundle.min.js',
    ];

    public $depends = [
        'yii\web\YiiAsset',
    ];
}