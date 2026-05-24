<?php

namespace app\assets;

use yii\web\AssetBundle;

class FontAwesomeAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $css = [
        'font-awesome/css/font-awesome.min.css',
    ];

    public $depends = [
        'yii\web\YiiAsset',
    ];
}