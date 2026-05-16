<?php

/**
 * @link https://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license https://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * Main application asset bundle.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class SchoolTemplateAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'https://fonts.googleapis.com/css?family=Muli:300,400,700,900',
        'school-template/fonts/icomoon/style.css',
        'school-template/fonts/flaticon/font/flaticon.css',
        'school-template/css/bootstrap.min.css',
        'school-template/css/jquery-ui.css',
        'school-template/css/owl.carousel.min.css',
        'school-template/css/owl.theme.default.min.css',
        'school-template/css/jquery.fancybox.min.css',
        'school-template/css/bootstrap-datepicker.css',
        'school-template/css/aos.css',
        'school-template/css/style.css',
    ];
    public $js = [
        'school-template/js/jquery-3.3.1.min.js',
        'school-template/js/jquery-migrate-3.0.1.min.js',
        'school-template/js/jquery-ui.js',
        'school-template/js/popper.min.js',
        'school-template/js/bootstrap.min.js',
        'school-template/js/owl.carousel.min.js',
        'school-template/js/jquery.stellar.min.js',
        'school-template/js/jquery.countdown.min.js',
        'school-template/js/bootstrap-datepicker.min.js',
        'school-template/js/jquery.easing.1.3.js',
        'school-template/js/aos.js',
        'school-template/js/jquery.fancybox.min.js',
        'school-template/js/jquery.sticky.js',
        'school-template/js/main.js',
    ];
    public $depends = [
    ];
}
