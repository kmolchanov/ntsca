<?php

namespace app\assets;

use yii\web\AssetBundle;

class FancyboxAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $css = [
        'fancybox/fancybox.css',
    ];

    public $js = [
        'fancybox/fancybox.umd.js',
    ];

    public $depends = [
        'yii\web\YiiAsset',
    ];
}