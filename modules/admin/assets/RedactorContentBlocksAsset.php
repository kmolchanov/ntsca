<?php

namespace app\modules\admin\assets;

use yii\web\AssetBundle;

class RedactorContentBlocksAsset extends AssetBundle
{
    public $sourcePath = '@app/modules/admin/assets';

    public $js = [
        'js/redactor-contentblocks.js',
    ];

    public $depends = [
        'vova07\imperavi\Asset',
    ];
}
